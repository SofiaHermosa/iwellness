<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\Earnings;
use App\Models\User;
use Storage;
use Session;


class NetworkClass
{
    public $earnings;

    public function __construct()
    {
        
    }

    public function getEarnings($downline = null){
        $earnings = Earnings::where('user_id', auth()->user()->id);

        if(!empty($downline)){
            $earnings = $earnings->where('downline_id', $downline);
        }

        $this->earnings = $earnings->get();

        return $this;
    }

    public function getDownlines($id=null){
        return User::where('referer', $id)->get();
    }

    public function getNetwork()
    {
        $network = [];
        $childs = [];
        $downline = $this->getDownlines(auth()->user()->id);
        $level = 2;
       
        while(!empty($downline)){
            $nextDownline = [];
            foreach($downline as $user){
                $user->level = ordinal($level);
                $user->commission = array_sum($this->getEarnings($user->id)->earnings->pluck('amount')->toArray());
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