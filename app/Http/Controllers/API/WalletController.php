<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\IWellness\SubscriptionClass;
use App\IWellness\WalletClass;
use App\IWellness\CartClass;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class WalletController extends Controller
{
    public $walletClass, $subscripClass, $cartClass,$wallet;

    public function __construct()
    {
        $this->walletClass      = new WalletClass;
        $this->subscripClass    = new SubscriptionClass;   
        $this->cartClass        = new CartClass; 
    }

    public function payWithWallet(Request $request){
        try {
            if(Hash::check($request->password, auth()->user()->password)){   
                $amountToPay    = $request->type == 2 ? $this->getTotalOrderAmount() : $request->amount;
                $shipping_fee   = $amountToPay <= 5000 ? 120 : 200;
                $amountToPay    = $request->type == 2 ? $amountToPay + $shipping_fee : $amountToPay;
                $this->wallet = $this->walletClass->payWithWallet($amountToPay);

                if($this->wallet){
                    $proceedRequest = $this->proceedRequest($request->type, $amountToPay);

                    return response()->json([
                        'message' => 'payment successfully sent',
                        'url'     => $proceedRequest 
                    ], 200);
                }

                return response()->json([
                    'message' => 'something went wrong',
                ], 500);

            }else{
                return response()->json([
                    'message' => 'incorrect password'
                ], 401);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function proceedRequest($type, $amount){
        switch ($type) {
            case 1:

                $this->subscripClass->activateAccount(request()->toArray())->parentsCommision();
                return url('res/profile');
                break;
            
            default:
                $order = $this->getOrderDetails();
                return url('res/order/invoice/'.$order->id);
                break;
        }
    }

    public function getTotalOrderAmount(){
        $details = json_decode(base64_decode(Session::get('checkout_details')));
        $cart    = $details->orders;

        $amount = [];

        foreach($cart as $checkout){
            $id         = base64_decode($checkout);
            $orders     = auth()->user()->cart->$id;
            $amount[]   = $orders->price * $orders->quantity;
        }

        $amount         = array_sum($amount);

        return $amount;
    }

    public function getOrderDetails(){
        $details = json_decode(base64_decode(Session::get('checkout_details')));
        $cart    = $details->orders;

        $amount = [];

        foreach($cart as $checkout){
            $id         = base64_decode($checkout);
            $orders     = auth()->user()->cart->$id;
            $amount[]   = $orders->price * $orders->quantity;
        }

        $amount         = array_sum($amount);
        $shipping_fee   = $amount <= 5000 ? 120 : 200;
        $service_charge = 0;
        $data = [
            'amount'            => $amount,
            'shipping_fee'      => $shipping_fee,
            'service_charge'    => $service_charge,
            'payment_id'        => $this->wallet->payment_intent->pg_transaction_id,
            'paymongo_method'   => false
        ];

        return $this->cartClass->placeOrders($data);
    }
}