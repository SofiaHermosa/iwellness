<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Earnings;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use App\IWellness\ActivityClass;
use App\IWellness\WalletClass;

class JobsController extends Controller
{
    public $activityClass, $walletClass;

    public function __construct()
    {
        $this->activityClass = new ActivityClass;
        $this->walletClass   = new WalletClass;
    }

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
            
            foreach($user->earning_dates as $key => $active_subscription){
                $capital_details = Subscription::where('id', $key)->with('capital')->first();
                if(in_array($current, $active_subscription) && empty($flag)){

                    $earning = $capital_details->capital->first()->amount * 0.08;
                
                    $data = [
                        'user_id'           => $user->id,
                        'downline_id'       => $user->id,
                        'from'              => 3,
                        'amount'            => $earning,
                    ];
    
                    $earning_data = [
                        'balance' => $earning,
                        'user_id' => $user->id
                    ];
                    

                    $profit = Earnings::create($data);
                    
                    $this->activityClass->logActivity('profit', $user->id, $profit->id);
    
                    $this->walletClass->update($earning_data); 
                    
                   echo '- ' . $user->name . ' earned total amount of ₱' . $earning;
                }
            }
        }

        echo 'Dissemination of quarterly earnigns succeeded';    
    }
}
