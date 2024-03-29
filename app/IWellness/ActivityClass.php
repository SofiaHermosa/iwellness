<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\SurveyQuestions;
use App\Models\ActivityLogs;
use App\Models\Subscription;
use App\Models\SurveyEntries;
use Carbon\Carbon;
use Storage;
use Session;
use DB;


class ActivityClass
{
    public $desc;

    public function __construct(){
        $this->desc = [
            'profit'            => 'Earned cutoff profit',
            'login'             => 'Login',
            'survey'            => 'Answered scheduled survey',
            'ads'               => 'Watched Ads',
            'capital_released'  => 'Capital has been released',
            'wallet_cashin'     => 'Added cashin amount of 0 to user wallet',
            'login_bonus'       => 'Earned Daily login bonus'
        ];
    }

    public function logActivity($type, $causer, $subject = null){
        $causer_type = null;
        if($type == 'capital_released'){
            $amount = session()->has('activity_type') ? session()->get('activity_type') : 0;
            $this->desc[$type] = 'Capital amounting '.number_format($amount, 2, '.', ',').' has been released';
        }

        if($type == 'login_bonus'){
            $amount = session()->has('activity_type') ? session()->get('activity_type') : 0;
            $this->desc[$type] = 'Earned Daily login bonus amounting '.number_format($amount, 2, '.', ',').' from majestic complan';
        }

        if($type == 'wallet_cashin'){
            $amount = session()->has('activity_type') ? session()->get('activity_type') : 0;
            $this->desc[$type] = 'added cashin amount '.number_format($amount, 2, '.', ',').' to wallet';

            $causer_type = 'App\Models\CashIn';
        }

        $data = [
            'causer_id'     => $causer,
            'log_name'      => $type,
            'description'   => $this->desc[$type],
            'subject_id'    => $subject ?? $causer,
            'subject_type'  => session()->has('activity_type') ? session()->get('activity_type') : null,
            'causer_type'   => $causer_type
        ];

        ActivityLogs::create($data);
    }

    public function get(){
        $subscriptions = auth()->user()->activity_earning_dates;
        $activity      = [];

        foreach($subscriptions as $key => $subscription){
            $complan = Subscription::where('id', $key)->first();
            $plan = strtoupper(config('constants.complans.'.$complan->complan.'.name'));
            $plan_class = config('constants.complans.'.$complan->complan.'.class');
            end($subscription);
            $endDate = key($subscription);
            foreach($subscription as $index => $release_date){

                $data = [
                    'activation_date'   =>  Carbon::parse($subscription[0])->subDays(8)->format('M d, Y'),
                    'sched'             =>  Carbon::parse($release_date)->subDays(8)->format('m/d') . ' - ' . Carbon::parse($release_date)->format('m/d'), 
                    'survey'            =>  $this->hasSurvey($release_date, $key, $index == $endDate ? $endDate - 1 : $index),
                    'logged_in'         =>  $this->retriveActivity($release_date, 'login'),
                    'ads'               =>  $this->retriveActivity($release_date, 'ads', $key, $index == $endDate ? $endDate - 1 : $index),
                    'profit'            =>  $this->retriveActivity($release_date, 'profit', $key, $index == $endDate ? $endDate - 1 : $index),
                    'release'           =>  Carbon::parse($release_date)->format('m-d-Y'),
                    'start'             =>  Carbon::parse($release_date)->subDays(8)->format('Y-m-d'),
                    'end'               =>  Carbon::parse($release_date)->format('Y-m-d'),  
                    'plan'              =>  $plan,
                    'plan_class'        =>  $plan_class,
                    'capital_release'   =>  $index == $endDate ? true : false   
                ];  
    
                $activity[] = $data;            
            }
        }   

        return !empty($activity) ? collect($activity) : [];
    }

    public function hasSurvey($date, $subs_id=null, $key=null){
        $start = Carbon::parse($date)->subDays(8);
        $end   = Carbon::parse($date);

        $entry = SurveyEntries::where('user_id', auth()->user()->id)
        ->where('key', $key)
        ->where('subs_id', $subs_id)
        ->first();

        return $entry ?? [];
    }

    public function retriveActivity($date, $type, $sub=null, $key=null){
        $start = Carbon::parse($date)->subDays(8);
        $end   = Carbon::parse($date);

        $activity = new ActivityLogs;
        
        if($type == 'login'){
            $activity = $activity->whereBetween('created_at', [$start, $end]);
        }

        if($type == 'ads'){
            $activity = $activity->where('subject_id', $sub)->where('subject_type', $key);
        }

        if($type == 'profit'){
            $activity = $activity->where('subject_id', $sub)->where('subject_type', $key);
        }

        $activity = $activity->where('causer_id', auth()->user()->id)->where('log_name', $type)->first();

        return $activity ?? [];
    }
}
