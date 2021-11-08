<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\IWellness\DiamondConversionClass;
use Illuminate\Http\Request;

class DiamondConversionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $requestClass;

    public function __construct()
    {
        $this->requestClass = new DiamondConversionClass;
    }

    public function index()
    {
        $request = $this->requestClass->getRequest()->request;
        if(request()->ajax()){
            return response()->json(['data'=> $request]);
        }
        return view('admin.conversions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        if ($request->action == 'approve') {
            $request = $this->requestClass->approveConversion($request->id);
        }else{
            $request = $this->requestClass->declineConversion($request->id);
        }
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
