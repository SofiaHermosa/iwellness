<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\IWellness\SurveyClass;
use Illuminate\Http\Request;
use Session;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $surveyClass;

    public function __construct()
    {
        $this->surveyClass = new SurveyClass;
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
        return view('member.survey.index');
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
        return redirect('res/');
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
}
