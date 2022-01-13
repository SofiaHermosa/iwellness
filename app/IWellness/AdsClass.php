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


class AdsClass
{

    public $cutoffs;

    public function __construct(){
        $this->cutoffs =  auth()->user()->earning_dates;
    }

    public function releaseAds(){
        $releaseAds = [];
        $now = Carbon::now()->format('Y-m-d');
        $end = Carbon::now()->subWeeks(2)->format('Y-m-d');
    
        foreach($this->cutoffs as $key => $subscription){
            foreach($subscription as $index => $release_date){
                $start = Carbon::parse($release_date)->subDays(8);
                $end   = Carbon::parse($release_date);
                $weeksAgo = Carbon::now()->subWeeks(2);
                $now = Carbon::now()->format('Y-m-d');
                if(Carbon::now()->between($start,$end)  || $end->between($weeksAgo, $now)){
                    $activity = ActivityLogs::select('id')->where('log_name', 'ads')->where('causer_id', auth()->user()->id)->where('subject_id', $key)->where('subject_type', $index)->first();
                    $play = [1,2,3];
                    $random_play = (int)array_rand($play, 1);
                    if(empty($activity)){
                        $ads = DB::table('ads_videos')
                               ->inRandomOrder()
                               ->first();

                        $releaseAds[] = array(
                            'sub_id' => $key,
                            'key'    => $index,
                            'date'   => $release_date,
                            'ads'    => $ads->link,
                            'play'   => $play[$random_play]
                        );
                    }
                }
            }
        }
        if(!empty($releaseAds)){
            session()->put('play_ads', $releaseAds[0]);
        }else{
            session()->has('play_ads') ? session()->forget('play_ads') : ''; 
        } 
    }

}

?>