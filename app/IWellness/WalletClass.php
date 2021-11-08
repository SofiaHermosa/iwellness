<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\Wallets;
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
}

?>