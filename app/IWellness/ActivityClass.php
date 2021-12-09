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
            'profit'   => 'Earned cutoff profit',
            'login'    => 'Login',
            'survey'   => 'Answered scheduled survey',
            'ads'     => 'Watched Ads'
        ];
    }

    public function logActivity($type, $causer, $subject = null){
        $data = [
            'causer_id'     => $causer,
            'log_name'      => $type,
            'description'   => $this->desc[$type],
            'subject_id'    => $subject ?? $causer,
            'subject_type'  => session()->has('activity_type') ? session()->get('activity_type') : null
        ];

        ActivityLogs::create($data);
    }

    public function get(){
        $subscriptions = auth()->user()->earning_dates;
        $activity      = [];

        foreach($subscriptions as $key => $subscription){
            foreach($subscription as $index => $release_date){
                $data = [
                    'activation_date'   =>  Carbon::parse($subscription[0])->subDays(7)->format('M d, Y'),
                    'sched'             =>  Carbon::parse($release_date)->subDays(7)->format('m/d') . ' - ' . Carbon::parse($release_date)->format('m/d'), 
                    'survey'            =>  $this->hasSurvey($release_date),
                    'logged_in'         =>  $this->retriveActivity($release_date, 'login'),
                    'ads'               =>  $this->retriveActivity($release_date, 'ads', $key, $index),
                    'profit'            =>  $this->retriveActivity($release_date, 'profit'),
                    'release'           =>  Carbon::parse($release_date)->format('m-d-Y'),
                    'start'             =>  Carbon::parse($release_date)->subDays(7)->format('Y-m-d'),
                    'end'               =>  Carbon::parse($release_date)->format('Y-m-d'),  
                ];  
    
                $activity[] = $data;            
            }
        }   

        return !empty($activity) ? collect($activity) : [];
    }

    public function hasSurvey($date){
        $start = Carbon::parse($date)->subDays(7);
        $end   = Carbon::parse($date);

        $entry = SurveyEntries::whereBetween('created_at', [$start, $end])->where('user_id', auth()->user()->id)->first();

        return $entry ?? [];
    }

    public function retriveActivity($date, $type, $sub=null, $key=null){
        $start = Carbon::parse($date)->subDays(7);
        $end   = Carbon::parse($date);

        $activity = new ActivityLogs;
        
        if($type == 'login'){
            $activity = $activity->whereBetween('created_at', [$start, $end]);
        }

        if($type == 'ads'){
            $activity = $activity->whereBetween('created_at', [$start, $end])->where('subject_id', $sub)->where('subject_type', $key);
        }

        if($type == 'profit'){
            $activity = $activity->whereDate('created_at', Carbon::parse($end));
        }

        $activity = $activity->where('causer_id', auth()->user()->id)->where('log_name', $type)->first();

        return $activity ?? [];
    }
}
