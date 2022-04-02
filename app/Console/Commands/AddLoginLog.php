<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActivityLogs;
use App\Models\Subscription;
use Carbon\CarbonPeriod;

class AddLoginLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:login_logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $subscriptions = Subscription::where('complan', 3)
        ->where('status', 1)
        ->has('capital')
        ->with('user')
        ->orderBy('created_at', 'DESC')
        ->groupBy('user_id')
        ->get();

        foreach($subscriptions as $key => $subscription){
            $startDate  = '2022-03-26';
            $endDate    = '2022-04-01';
            $dateRange  = CarbonPeriod::create($startDate, $endDate);

            $this->info($subscription->user->username. PHP_EOL);

            foreach($dateRange->toArray() as $pastDate){
                $logged_in  = ActivityLogs::where('log_name', 'login')->where('causer_id', $subscription->user_id)->whereBetween('created_at', [$pastDate->startOfDay()->format('Y-m-d H:s:i'), $pastDate->endOfDay()->format('Y-m-d H:s:i')])->first();
               
                if(empty($logged_in)){
                    $data = [
                        'causer_id'     => $subscription->user_id,
                        'log_name'      => 'login',
                        'description'   => 'Login',
                        'subject_id'    => $subscription->user_id,
                        'subject_type'  => null,
                        'causer_type'   => null
                    ];
            
                    $activity = ActivityLogs::create($data);
                    $activity->created_at = $pastDate;
                    $activity->save();

                   $this->info('-'.$pastDate . PHP_EOL);
                }
            }
        }
    }
}
