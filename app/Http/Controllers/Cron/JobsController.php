<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Earnings;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Carbon;

class JobsController extends Controller
{
    function endSubscription(){
        try {
            $subscriptions = Subscription::whereMonth(
                'created_at', '=', Carbon::now()->subMonth()->month
            )->with(['capital', 'user'])->get();

            foreach($subscriptions as $subscription){
                //Deactivate user accunt
                $user = $subscription->user;
                if(!empty($user)){
                    $user->update(['activated' => 0]);
                }
    
                //Delete Capital
                $capitals = $subscription->capital;
                foreach($capitals as $capital){
                    $capital->update(['status' => 0]);
                    $capital->delete();
                }
    
                //Delete Subscription
                $subscription->update(['status' => 0, 'valid' => 0]);
                $subscription->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function recurringEarnings(){
        $current = date('Y-m-d');
        $users   = User::where('user_type', 2)->where('activated', 1)->get();

        foreach($users as $key => $user){
            $flag = Earnings::select('id')
            ->where('user_id', $user->id)
            ->where('from', 3)
            ->whereDate('created_at', $current)
            ->first();
           
            if(in_array($current, $user->earning_dates) && empty($flag)){
                $earning = $user->capital * 0.08;
            
                $data = [
                    'user_id'           => $user->id,
                    'downline_id'       => $user->id,
                    'from'              => 3,
                    'amount'            => $earning,
                ];

                Earnings::create($data);
            }
        }
    }
}
