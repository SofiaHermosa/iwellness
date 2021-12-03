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
        $earnings = Earnings::select('amount')->where('user_id', auth()->user()->id);

        if(!empty($downline)){
            $earnings = $earnings->where('downline_id', $downline);
        }

        $this->earnings = $earnings->sum('amount');

        return $this;
    }

    public function getDownlines($id=null){
        return User::select('id', 'name', 'username', 'referer')->where('referer', $id)->get();
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