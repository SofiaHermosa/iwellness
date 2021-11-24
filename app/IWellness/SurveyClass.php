<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\SurveyQuestions;
use App\Models\SurveyEntries;
use Carbon\Carbon;
use Storage;
use Session;
use DB;


class SurveyClass
{
    public $surveys, $request, $entries;

    public function __construct()
    {
        $this->request = request();
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
        $this->entries = SurveyEntries::where('user_id', auth()->user()->id)
        ->whereMonth('created_at', Carbon::now()->month)
        ->get();

        return $this;
    }

    public function survey(){
        $question = [];

        if(empty($this->entries->first())){
            $question = SurveyQuestions::orderBy(DB::raw('RAND()'))->take(3)->get();
        }

        return $question;
    }

    public function sendEntry(){
        foreach($this->request->answer as $key => $answer){
            $data = [
                'user_id'       => auth()->user()->id,
                'question_id'   => $key,
                'answer'        => $answer,
                'month'         => date('F')
            ];

            SurveyEntries::create($data);
        }
    }
}

?>