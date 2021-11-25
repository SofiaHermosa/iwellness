<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\IWellness\ActivityClass;
use App\Models\Earnings;
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
    public $activityClass;

    public function __construct()
    {
        parent::__construct();
        $this->activityClass = new ActivityClass;
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
           
            if(in_array($current, $user->earning_dates) && empty($flag)){
                $earning = $user->capital * 0.08;
            
                $data = [
                    'user_id'           => $user->id,
                    'downline_id'       => $user->id,
                    'from'              => 3,
                    'amount'            => $earning,
                ];

                $profit = Earnings::create($data);

                $this->activityClass->logActivity('profit', $user->id, $profit->id);
                
                $this->info('- ' . $user->name . ' earned total amount of ₱' . $earning);
            }
        }

        $this->info('Dissemination of quarterly earnigns succeeded');
    }
}
