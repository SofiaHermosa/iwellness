<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
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
    public $walletClass;
    public function __construct()
    {
        parent::__construct();
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
            'created_at', '=', Carbon::now()->subMonth()->month
        )->with(['capital', 'user'])->get();

        foreach($subscriptions as $subscription){
            //Deactivate user accunt
            $subscription->capital;
            if(Carbon::now()->format('Y-m-d') == Carbon::parse($subscription->created_at)->addDays(33)->format('Y-m-d')){
                $user = $subscription->user;
                if(!empty($user)){
                    $user->update(['activated' => 0]);
                }

                $capital_amount = $subscription->capital->amount;
    
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

        $this->info('Listed subscriptions has been successfully deactivated.');
    }
}
