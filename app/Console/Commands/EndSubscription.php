<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
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
    public function __construct()
    {
        parent::__construct();
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
            if(Carbon::now()->format('Y-m-d') == Carbon::parse($subscription->created_at)->addDays(33)->format('Y-m-d')){
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
    
                $this->info('- ' . $subscription->user->name.' subscription has been deactivated.');
            }
        }

        $this->info('Listed subscriptions has been successfully deactivated.');
    }
}
