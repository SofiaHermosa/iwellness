<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\SurveyQuestions;
use App\Models\SurveyEntries;
use App\Models\Earnings;
use App\Models\Subscription;
use App\IWellness\ActivityClass;
use App\IWellness\WalletClass;
use Carbon\Carbon;
use Storage;
use Session;
use DB;


class SurveyClass
{
    public $surveys, $request, $entries, $activityClass, $walletClass;

    public function __construct()
    {
        $this->request       = request();
        $this->activityClass = new ActivityClass;
        $this->walletClass   = new WalletClass;
    }

    public function manageSurvey(){
        $question = SurveyQuestions::updateOrCreate(
            ['id' => $this->request->id ?? null],
            $this->request->except(['_token', 'id'])
        );

        return $question;
    }

    public function get($id=null){
        $survey = new SurveyQuestions;

        if(!empty($id)){
            $survey = $survey->where('id', $id);
        }

        $survey = $survey->orderBy('created_at')->get();
        $this->surveys = $survey;
        
        return $this;
    }

    public function monthlyEntries(){
        $releaseSurvey = [];
        foreach(auth()->user()->earning_dates as $key => $subscription){
            foreach($subscription as $index => $release_date){
                $start = Carbon::parse($release_date)->subDays(7);
                $end   = Carbon::parse($release_date);
                $weeksAgo = Carbon::now()->subWeeks(2);
                $now = Carbon::now()->format('Y-m-d');
                if(Carbon::now()->between($start,$end) || $end->between($weeksAgo, $now)){
                    $entries = SurveyEntries::where('user_id', auth()->user()->id)->where('subs_id', $key)->where('key', $index)->first();

                    if(empty($entries)){
                        $releaseSurvey[] = array(
                            'subs_id'=> $key,
                            'key'    => $index,
                            'date'   => $release_date,
                            'survey' => $this->randomSurvey(),
                            'type'   => Carbon::now()->between($start,$end) ? 'upcoming' : 'past'
                        );
                    }   
                }
            }
        }
        
        return $releaseSurvey;
    }

    public function hasSurvey(){
        $pending = [];
        $now     = Carbon::now()->format('Y-m-d');
        $ads  = !empty($this->activityClass->get()) ? 
        $this->activityClass
        ->get()
        ->where('survey', '===', []) : 
        [];

        foreach($ads as $ad){
            if(($now >= $ad['start']) && ($now <= $ad['end'])){
                $pending[] = $ad;
            }
        }

        
        if(count($pending) == 0){
            return false;
        }

        return true;
    }

    public function watchedAds(){
        $pending = [];
        $now     = Carbon::now()->format('Y-m-d');
        $ads  = !empty($this->activityClass->get()) ? 
        $this->activityClass
        ->get()
        ->where('ads', '===', []) : 
        [];

        foreach($ads as $ad){
            if(($now >= $ad['start']) && ($now <= $ad['end'])){
                $pending[] = $ad;
            }
        }

        
        if(count($pending) == 0){
            return false;
        }

        return true;
    }

    public function randomSurvey(){
        return SurveyQuestions::orderBy(DB::raw('RAND()'))->take(3)->get();
    }
    public function survey(){
        $question = [];

        if(empty($this->entries->first())){
            $question = SurveyQuestions::orderBy(DB::raw('RAND()'))->take(3)->get();
        }

        return $question;
    }

    public function sendEntry(){
       
        $data = [
            'user_id'       => auth()->user()->id,
            'answer'        => $this->request->answer,
            'month'         => date('F'),
            'key'           => $this->request->key,
            'subs_id'       => $this->request->subs_id
        ];

        if($this->request->type == 'past'){
            $this->delayedProfit($this->request->subs_id, $this->request->key);
        }

        $survey = SurveyEntries::create($data);
        $this->activityClass->logActivity('survey', auth()->user()->id, $survey->id);
    }

    public function delayedProfit($subs_id, $key){
        $subscription = Subscription::with('capital')->findOrFail($subs_id);
        $earning      = $subscription->capital->first()->amount * 0.12;
        $data = [
            'user_id'           => auth()->user()->id,
            'downline_id'       => auth()->user()->id,
            'from'              => 3,
            'amount'            => $earning,
        ];

        $earning_data = [
            'balance' => $earning,
            'user_id' => auth()->user()->id
        ];

        $profit = Earnings::create($data);
        
        session()->put('activity_type', $key);
        
        $this->activityClass->logActivity('profit', auth()->user()->id, $subs_id);
        
        $this->walletClass->update($earning_data); 
        
        session()->forget('activity_type');
    }
}

?>