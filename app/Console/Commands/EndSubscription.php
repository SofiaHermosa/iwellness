<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\IWellness\ActivityClass;
use App\IWellness\WalletClass;
use Illuminate\Support\Carbon;

class EndSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'end:subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ending active subsciption that has been due';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public $activityClass, $walletClass;
    public function __construct()
    {
        parent::__construct();
        $this->activityClass = new ActivityClass;
        $this->walletClass   = new WalletClass;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscriptions = Subscription::whereMonth(
            'created_at', '=', Carbon::now()->subDays(40)->month
        )
        ->orWhereMonth(
            'created_at', '=', Carbon::now()->subDays(30)->month
        )
        ->with(['capital', 'user'])->get();

        foreach($subscriptions as $subscription){
            //Deactivate user accunt
            $lockInDays = config('constants.complans.'.$subscription->complan.'.locked_in');
            if(Carbon::now()->format('Y-m-d') == Carbon::parse($subscription->created_at)->addDays($lockInDays)->format('Y-m-d')){
                $user = $subscription->user;

                if(!empty($user)){
                    $user->update(['activated' => 0]);
                }

                $capital_amount = $subscription->capital->first()->amount;
    
                //Delete Capital
                $capitals = $subscription->capital;

                foreach($capitals as $capital){
                    $capital->update(['status' => 0]);
                    $capital->delete();
                }

                $earning_data = [
                    'balance' => $capital_amount,
                    'user_id' => $user->id
                ];

                $this->walletClass->update($earning_data);

                session()->put('activity_type', $capital_amount);
                        
                $this->activityClass->logActivity('capital_released', $user->id);
    
                //Delete Subscription
                $subscription->update(['status' => 0, 'valid' => 0]);
                $subscription->delete();

                $other_subscription = Subscription::where('user_id', $user->id ?? null)->where('valid', 1)->where('status', 1)->first();
                
                if(!empty($other_subscription)){
                    $user->update(['activated' => 1]);
                }

                $this->info('- ' . $subscription->user->name.' subscription has been deactivated.');
            }
        }

        $this->info('Listed subscriptions has been successfully deactivated. ('.now()->format('M d, Y g:ia').')');
    }
}
