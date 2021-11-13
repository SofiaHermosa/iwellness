<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\Wallets;
use App\Models\Payment;
use Storage;
use Session;


class WalletClass
{
    public $wallet;
  
    public function update($data){
        $data['balance'] = $this->getCurrentBalance($data['user_id']) + $data['balance'];
        $wallet = Wallets::updateOrCreate(
            ['user_id' => $data['user_id']],
            $data
        );

        return $this;
    }

    public function getCurrentBalance($id){
        $balance = Wallets::where('user_id', $id)->first();
        
        $this->wallet = !empty($balance->balance) ? $balance->balance : 0;
        return !empty($balance->balance) ? $balance->balance : 0;
    }

    public function payWithWallet($amount){
        $current_balance = auth()->user()->wallet_balance;
        $new_balance     = $current_balance - $amount;
        $new_balance     = $new_balance < 0 ? 0 : $new_balance;

        $wallet = Wallets::where('user_id', auth()->user()->id)->first();
        $wallet->balance = $new_balance;
        $wallet->save();

        if($wallet){
            $payment = $this->createPaymentRecord($wallet, $amount);
            $wallet['payment_intent'] = $payment;
        }

        return $wallet;

    }

    public function createPaymentRecord($payment, $amount){
        $data = [
            'user_id'           => auth()->user()->id,
            'transaction_type'  => request()->type,
            'pg_transaction_id' => 'pay_wallet_'.uniqid(),
            'payment_source'    => 'wallet',
            'amount_paid'       => $amount
        ];

        return Payment::create($data);
    }
}

?>