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
            $networks  = $this->networkClass->getNetwork($supervisior->id);
            $upline    = $this->getUpline($supervisior->referer);
            $networks  = array_merge($networks, $upline);

            $capital  = [];
            $orders   = [];
            $earnings = [];
            $cashin   = [];

            foreach($networks as $index => $network){
                $network    = $this->getIndividualSales($network, $date);
                $capital  []= $network['individual_sales']['capital'];
                $earnings []= $network['individual_sales']['earnings'];
                $orders   []= $network['individual_sales']['orders'];
                $cashin   []= $network['individual_sales']['cashin'];
                $checker  []= $network['individual_sales'];
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

    public function getIndividualSales($user, $date){
        $orders     = Orders::where('user_id', $user['id']);
        $capital    = Capital::where('user_id', $user['id']);
        $cashin     = Cashin::where('user_id', $user['id']);
        $earnings   = Earnings::where('user_id', $user['id'])->whereIn('from', [1,2]);

        if (!empty($date) && $date != '') {
            $date       = date("Y-m-d", strtotime($date));
            $orders     = $orders->whereDate('created_at', $date);
            $capital    = $capital->whereDate('created_at', $date);
            $cashin     = $cashin->whereDate('created_at', $date);
            $earnings   = $earnings->whereDate('created_at', $date);
        }

        $orders     = $orders->withTrashed()->get()->sum('total');
        $capital    = $capital->withTrashed()->get()->sum('amount');
        $cashin     = $cashin->withTrashed()->get()->sum('amount');
        $earnings   = $earnings->withTrashed()->get()->sum('amount');

        $individual_sales = array(
            'orders'     => $orders,
            'capital'    => $capital,
            'cashin'     => $cashin,
            'earnings'   => $earnings
        );

        $user['individual_sales'] = $individual_sales;

        return $user;     
    }
}

?>