<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IWellness\WalletClass;
use App\Models\Earnings;
use App\Models\Wallets;
use App\Models\User;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $walletClass;
    public function __construct()
    {
        $this->walletClass   = new WalletClass;
    }
    public function index()
    {

        $subsciptions = auth()->user()->active_subscriptions;
        if(request()->ajax()){
            return response()->json(['data'=> $subsciptions]);
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
        //
    }

    public function addAmountOnWallet($user_id, $amount){
        $earning_data = [
            'balance' => $amount,
            'user_id' => $user_id
        ];

        $this->walletClass->update($earning_data);

        return 'Successfully Added to Wallet';
    }
    
    public function addCommissions($source, $user_id, $downline, $amount){
        $user = User::where('id', $user_id)->first();

        if (empty($user)) {
            $user = User::where('username', $user_id)->first();
        }

        if(empty($user)){
            return 'user not found';
        }

        $commission = [
            'user_id'       => $user->id,
            'downline_id'   => $downline,
            'from'          => $source,
            'amount'        => $amount,
        ];

        Earnings::create($commission);

        $this->addAmountOnWallet($user->id, $amount);

        return $user->username.' has received commission from user # '.$downline;
    }
    
    public function deductAmountOnWallet($user_id, $amount){
        $user = User::where('id', $user_id)->first();

        if (empty($user)) {
            $user = User::where('username', $user_id)->first();
        }

        $balance = $user->wallet_balance ?? 0;

        if($balance == 0 || $balance < $amount){
            return 'insufficient balance. '.$user->username ?? 'user'.' current balance: '. $balance;
        }

        $balance = $balance - $amount;

        $wallet = Wallets::where('user_id', $user->id)->first();
        $wallet->balance = $balance;
        
        if($wallet->save()){
            return $user->username.' new balance '.$balance;
        }
    }
}
