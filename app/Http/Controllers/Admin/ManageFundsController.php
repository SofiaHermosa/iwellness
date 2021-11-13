<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\IWellness\ManageFundsClass;
use Illuminate\Http\Request;

class ManageFundsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $fundsClass;

    public function __construct()
    {
        $this->fundsClass = new ManageFundsClass();
    }

    public function index()
    {
        try {
            if(request()->ajax()){
                $funds = $this->fundsClass
                 ->get(request()->type)
                 ->funds;

                return response()->json(['data'=> $funds]);
            }  

            return view('admin.manage-funds.index');

        } catch (\Throwable $th) {
            
        }
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
        if(request()->ajax()){
            if ($request->type == 'cashin' && $request->response == 'approve') {
                $this->fundsClass->approveCashIn($request->id,$request->user_id, $request->amount);

                return response()->json([
                    'message' => 'Cash in was successfully approved'
                ], 200);
            }

            if ($request->type == 'cashin' && $request->response == 'decline') {
                $this->fundsClass->declineCashIn($request->id,$request->user_id, $request->amount);

                return response()->json([
                    'message' => 'Cash in was successfully declined'
                ], 200);
            }

            if ($request->type == 'cashout' && $request->response == 'approve') {
                $this->fundsClass->approveCashOut($request->id,$request->user_id, $request->amount);

                return response()->json([
                    'message' => 'Cash out was successfully approved'
                ], 200);
            }

            if ($request->type == 'cashout' && $request->response == 'decline') {
                $this->fundsClass->declineCashOut($request->id,$request->user_id, $request->amount);

                return response()->json([
                    'message' => 'Cash Out was successfully declined'
                ], 200);
            }
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
