<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\IWellness\NetworkClass;
use App\Models\Earnings;
use App\Models\Capital;
use App\Models\Cashin;
use App\Models\Orders;
use App\Models\User;
use Storage;
use Session;
use DB;


class SalesClass
{
    public $orders, $request, $networkClass;

    public function __construct()
    {
       $this->request       = request(); 
       $this->networkClass  = new NetworkClass();
    }

    public function getUpline($user_id=null){
        $user_id = !empty($user_id) ? $user_id : auth()->user()->referer;
        $network = [];
        $childs = [];
        $downline = $this->networkClass->getUplines($user_id);
        $level = 2;
       
        while(!empty($downline)){
            $nextDownline = [];
            foreach($downline as $user){
                $user->level = ordinal($level);
                $user->commission = $this->networkClass->getEarnings($user->id)->earnings;
                $network[] = $user->toArray();
                foreach($this->networkClass->getUplines($user->referer) as $child){
                    $nextDownline[] = $child;
                }
            }

            $downline = $nextDownline;
            $level++;
        }
    
        return $network;
    }

    public function supervisor($date = null){
        $sales = [];
        $supervisiors = User::whereHas("roles", function($q) {
            $q->where("name", "team leader");
        })->get();

        $sups_sales = [];
        $checker = [];

        foreach ($supervisiors as $key => $supervisior) {
            $networks  = $this->getNetwork($supervisior->id);
            // $upline    = $this->getUpline($supervisior->referer);
            // $networks  = array_merge($networks, $upline);

            $capital  = [];
            $orders   = [];
            $earnings = [];
            $cashin   = [];

            foreach($networks as $index => $network){
                $network    = $this->getIndividualSales($network, $date);
                $capital  []= $network->individual_sales['capital'];
                $earnings []= $network->individual_sales['earnings'];
                $orders   []= $network->individual_sales['orders'];
                $cashin   []= $network->individual_sales['cashin'];
                $checker  []= $network->individual_sales;
            }
            $capital  = array_sum($capital);
            $earnings = array_sum($earnings);
            $orders   = array_sum($orders);
            $cashin   = array_sum($cashin);
            
            $sups_sales[] = array(
                'supervisor'   =>  $supervisior,
                'teams'        =>  $networks,
                'sales'        =>  array(
                    'orders'     => $orders,
                    'capital'    => $capital,
                    'cashin'     => $cashin,
                    'earnings'   => $earnings
                )
            );
        }
        return $sups_sales;
    }

    public function getDownlines($id=null){
        return DB::select("SELECT id, name, username, referer FROM users WHERE referer = ".$id);
    }

    public function getNetwork($user_id=null)
    {
        $user_id = !empty($user_id) ? $user_id : auth()->user()->id;
        $network = [];
        $childs = [];
        $downline = $this->getDownlines($user_id);
        $level = 2;
       
        while(!empty($downline)){
            $nextDownline = [];
            foreach($downline as $user){
                $user->level = ordinal($level);
                $network[] = $user;
                foreach($this->getDownlines($user->id) as $child){
                    $nextDownline[] = $child;
                }
            }

            $downline = $nextDownline;
            $level++;
        }
        return $network;
    }

    public function getIndividualSales($user, $date){
        $capital   = 0;
        $orders    = 0;
        $cashin    = 0;
        $earnings  = 0;
    
        if (!empty($date) && $date != '') {
            $date       = explode(' - ', $date);
            $capital    = DB::table('capital')->where('user_id', $user->id)->whereBetween('created_at', [date("Y-m-d", strtotime($date[0])), date("Y-m-d", strtotime($date[1]))])->sum('amount');
            $orders     = DB::table('orders')->where('user_id', $user->id)->whereBetween('created_at', [date("Y-m-d", strtotime($date[0])), date("Y-m-d", strtotime($date[1]))])->sum('total');
        }else{
            $capital    = DB::table('capital')->where('user_id', $user->id)->sum('amount');
            $orders     = DB::table('orders')->where('user_id', $user->id)->sum('total');
        }

        $orders     = $orders ?? 0;
        $capital    = $capital ?? 0;
        $cashin     = $cashin ?? 0;
        $earnings   = $earnings ?? 0;

        $individual_sales = array(
            'orders'     => $orders,
            'capital'    => $capital,
            'cashin'     => $cashin,
            'earnings'   => $earnings
        );

        $user->individual_sales = $individual_sales;

        return $user;     
    }
}

?>