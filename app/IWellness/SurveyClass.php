<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\SurveyQuestions;
use App\Models\SurveyEntries;
use App\IWellness\ActivityClass;
use Carbon\Carbon;
use Storage;
use Session;
use DB;


class SurveyClass
{
    public $surveys, $request, $entries, $activityClass;

    public function __construct()
    {
        $this->request       = request();
        $this->activityClass = new ActivityClass;
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
        $this->entries = [];

        $pending = [];
        $now     = Carbon::now()->format('Y-m-d');
        $survey  = !empty($this->activityClass->get()) ? 
        $this->activityClass
        ->get()
        ->where('survey', '===', []) : 
        [];

        foreach($survey as $entry){
            if(($now >= $entry['start']) && ($now <= $entry['end'])){
                $this->entries[] = SurveyEntries::where('user_id', auth()->user()->id)
                ->whereBetween('created_at', [$entry['start'], $entry['end']])
                ->first();
            }
        }

        $this->entries = collect($this->entries);

        return $this;
    }

    public function hasSurvey(){
        $pending = [];
        $now     = Carbon::now()->format('Y-m-d');
        $survey  = !empty($this->activityClass->get()) ? 
        $this->activityClass
        ->get()
        ->where('survey', '===', []) : 
        [];

        foreach($survey as $entry){
            if(($now >= $entry['start']) && ($now <= $entry['end'])){
                $pending[] = $entry;
            }
        }

        
        if(count($pending) == 0){
            return false;
        }

        return true;
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
            'month'         => date('F')
        ];

        $survey = SurveyEntries::create($data);
        $this->activityClass->logActivity('survey', auth()->user()->id, $survey->id);
    }
}

?>