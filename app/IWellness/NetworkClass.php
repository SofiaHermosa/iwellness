<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\Earnings;
use App\Models\User;
use Storage;
use Session;
use DB;

class NetworkClass
{
    public $earnings;

    public function __construct()
    {
        
    }

    public function getEarnings($downline = null){
        $earnings = Earnings::select('amount')->where('user_id', auth()->user()->id)->where('from', '!=', 4);

        if(!empty($downline)){
            $earnings = $earnings->where('downline_id', $downline);
        }

        $this->earnings = $earnings->withTrashed()->sum('amount');

        return $this;
    }

    public function getDownlines($id=null){
        return User::select('id', 'name', 'username', 'referer')->where('referer', $id)->get();
    }

    public function getUplines($id=null){
        return User::select('id', 'name', 'username', 'referer')->where('id', $id)->get();
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
                $user->commission = $this->getEarnings($user->id)->earnings;
                $network[] = $user->toArray();
                foreach($this->getDownlines($user->id) as $child){
                    $nextDownline[] = $child;
                }
            }

            $downline = $nextDownline;
            $level++;
        }
        return $network;
    }


}

?>