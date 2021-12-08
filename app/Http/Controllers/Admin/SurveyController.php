<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\IWellness\SurveyClass;
use App\IWellness\ActivityClass;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $surveyClass, $activityClass;

    public function __construct()
    {
        $this->surveyClass   = new SurveyClass;
        $this->activityClass = new ActivityClass;
    }

    public function index()
    {
        $survey = $this->surveyClass->get()->surveys;
       
        if(request()->ajax()){
            return response()->json(['data'=> $survey]);
        }

        return view('admin.survey.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.survey.module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->surveyClass->manageSurvey();

        Session::flash('message', 'New survey question was successfully added'); 
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->surveyClass->hasSurvey()){
            return view('member.survey.index');
        }else{

            $back = 'window.history.back()';
            return view('layouts.survey-success', compact('back'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->surveyClass->sendEntry();

        Session::flash('message', 'Thank you for your help!');
        
        $back = 'window.location.href="'.url('res/').'"';
        return view('layouts.survey-success', compact('back'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function watchAds($action){
        if($action == 'get' && request()->ajax()){
            $ads = session()->has('play_ads') ? session()->get('play_ads') : null;

            return $ads;
        }

        if($action == 'remove' && request()->ajax()){
            if(session()->has('play_ads')){
                session()->forget('play_ads');

                // $this->activityClass->logActivity('ads', auth()->user()->id);
            }
        }
    }
}
