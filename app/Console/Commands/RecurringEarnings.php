<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\IWellness\ActivityClass;
use App\IWellness\WalletClass;
use App\Models\Earnings;
use App\Models\Subscription;
use App\Models\SurveyEntries;    
use App\Models\User;

class RecurringEarnings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurring:earnings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'disseminating the quarterly earning of subscribed users';

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
        $current = date('Y-m-d');
        $users   = User::where('user_type', 2)->where('activated', 1)->get();

        foreach($users as $key => $user){
            $flag = Earnings::select('id')
            ->where('user_id', $user->id)
            ->where('from', 3)
            ->whereDate('created_at', $current)
            ->first();
            
            foreach($user->earning_dates as $index => $active_subscription){
                $capital_details = Subscription::where('id', $index)->with('capital')->first();
                if(in_array($current, $active_subscription) && empty($flag)){
                    $earning    = $capital_details->capital->first()->amount * 0.12;
                    $earningKey = array_search($current, $active_subscription);
                    $survey     = SurveyEntries::where('user_id', $user->id)->where('key', $earningKey)->where('subs_id', $index)->first();

                    if(!empty($survey)){
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
                        
                        session()->put('activity_type', $earningKey);
                        
                        $this->activityClass->logActivity('profit', $user->id, $index);
                        
                        $this->walletClass->update($earning_data); 
                        
                        session()->forget('activity_type');
    
                        $this->info('- ' . $user->name . ' earned total amount of ₱' . $earning);
                    }
                }
            }
        }

        $this->info('Dissemination of quarterly earnigns succeeded');
    }
}
