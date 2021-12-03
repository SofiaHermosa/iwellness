<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashIn;
use App\Models\CashOut;
use App\IWellness\ManageFundsClass;
use Illuminate\Support\Facades\Session;

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
        return view('member.manage-funds.index');
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
        $funds = $this->fundsClass
                 ->store();

        Session::flash('message', 'Cash-in request successfully sent'); 
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
        try {
            $funds = $this->fundsClass
                 ->get($id, auth()->user()->id)
                 ->funds;
            if(request()->ajax()){
                return response()->json(['data'=> $funds]);
            }  

        } catch (\Throwable $th) {
            
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(request()->ajax()){
            if (request()->type == 'cashin') {
                $cashIn = CashIn::findOrFail($id);
                $cashIn->delete();

                return response()->json([
                    'message' => 'Cash in was successfully deleted'
                ], 200);
            }

            if (request()->type == 'cashout') {
                $cashOut = CashOut::findOrFail($id);
                $cashOut->delete();

                return response()->json([
                    'message' => 'Cash out was successfully deleted'
                ], 200);
            }
        }    
    }

    public function validateRefence(Request $request){
        $ref_no =  preg_replace('/[^A-Za-z0-9\-]/', '', $request->details['reference_no']);
        $cashIn = CashIn::whereJsonContains('details', ['reference_no' => $ref_no])->where('status', '!=', 2)->first();

        if(!empty($cashIn)){
            return json_encode(false);
        }

        return json_encode(true);
    }
}
