<?php

namespace App\IWellness;
use Luigel\Paymongo\Facades\Paymongo;
use Luigel\Paymongo\Models\Webhook;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use App\IWellness\ProductClass;
use App\IWellness\OrderingClass;
use App\IWellness\CommissionClass;
use App\Models\Orders;
use App\Models\Cart;
use Storage;
use Session;
use stdClass;

class CartClass
{
    public $products, $request, $productClass, $orderClass, $commissionClass, $cart;

    public function __construct()
    {
       $this->request           = request(); 
       $this->productClass      = new ProductClass;
       $this->orderClass        = new OrderingClass;
       $this->commissionClass   = new CommissionClass;
    }

    public function products(){
        $id = $this->request->id;
        $this->products = $this->productClass->get($id)->data->first();

        return $this;
    }

    public function updateCart(){
        $id = $this->products->id;
        $cart = auth()->check() ? auth()->user()->cart : json_decode(Session::get('my-cart'));
        if(!empty($cart->$id)){
            $quantity = $cart->$id->quantity + $this->request->quantity;
            $cart->$id = array(
                "prod_id"  => $this->products->id,
                "details"  => $this->products->toArray(),
                "quantity" => $quantity,
                "price"    => !empty($this->products->discounted_price['price']) ? $this->products->discounted_price['price']  : $this->products->price,
            );
        }else{
            $array = array(
                "prod_id"  => $this->products->id,
                "details"  => $this->products->toArray(),
                "quantity" => $this->request->quantity,
                "price"    => !empty($this->products->discounted_price['price']) ? $this->products->discounted_price['price']  : $this->products->price,
            );

            $cart = !empty($cart) ? $cart : new stdClass();
            if(property_exists($cart, $id)){
                $cart[$id] = $array;
            }else{
                $cart->$id = $array;
            }
        }

        if(auth()->check()){
            Cart::updateOrCreate(
                ['user_id' => auth()->user()->id],
                [
                    'user_id' => auth()->user()->id,
                    'cart'    => $cart
                ]
            );
        }else{
            Session::put('my-cart', json_encode($cart));
        }
        
        return $this;
    }
    public function deleteProd($id=null){
        $cart                = auth()->check() ? auth()->user()->cart : json_decode(Session::get('my-cart'));
        unset($cart->$id);

        if(auth()->check()){
            $this->cart          = Cart::where('user_id', auth()->user()->id)->first();
            $this->cart->cart    = $cart; 
            $this->cart->save();
        }else{
            Session::put('my-cart', json_encode($cart));
        }    

        return $this;
    }

    public function updateOrderQty(){
        $cart                = auth()->check() ? auth()->user()->cart : json_decode(Session::get('my-cart'));
        $id                  = $this->request->id; 
        $cart->$id->quantity = $this->request->quantity;

        if(auth()->check()){
            $this->cart          = Cart::where('user_id', auth()->user()->id)->first();
            $this->cart->cart    = $cart; 
            $this->cart->save();    
        }else{
            Session::put('my-cart', json_encode($cart));
        }
      
        return $this;
    }

    public function placeOrders($data = null, $attachedPaymentIntent = null){
        $checkout_details = Session::get('checkout_details');
        $checkout_details = json_decode(base64_decode($checkout_details));
        $current_cart     = auth()->check() ? auth()->user()->cart : json_decode(Session::get('my-cart'));
        $dataIntent       = !empty($attachedPaymentIntent)? $attachedPaymentIntent->getData() : null;
        $amount           = $data['amount'];
        $shipping         = $data['shipping_fee'];
        $addCharge        = $data['service_charge'];
        $cart = [];
        $transactionId = "";
    
        if ($data['paymongo_method'])
        {
            $transactionId                  = $dataIntent['payments'][0]['id'] ?? $data['payment_id'];
        }else if(!$data['paymongo_method']){
            $transactionId                  = $data['payment_id'];
        }else
        {
            $transactionId                  = $dataIntent->getData()['id'] ?? $data['payment_id'];
        }

        foreach($checkout_details->orders as $key => $order){
            $id = base64_decode($order); 
            $cart[] = auth()->check() ? auth()->user()->cart->$id : json_decode(Session::get('my-cart'))->$id;
        
            unset($current_cart->$id);
        }

        if(auth()->check()){
            Cart::updateOrCreate(
                ['user_id' => auth()->check() ? auth()->user()->id : ''],
                [
                    'user_id' => auth()->check() ? auth()->user()->id : 0,
                    'cart'    => $current_cart
                ]
            );
        }else{
            Session::put('my-cart', json_encode($current_cart));
        }

        $latestOrder = $this->orderClass->get()->orders->first();
       
        $data = [
            'order_id'          => '#'.str_pad(($latestOrder->id ?? 0) + 1, 8, "0", STR_PAD_LEFT),
            'user_id'           => auth()->check() ? auth()->user()->id : 0,
            'transaction_id'    => $transactionId,
            'cart'              => $cart,
            'details'           => $checkout_details->shipping_details,
            'total'             => $amount,
            'shipping_fee'      => $shipping,
            'payment_charge'    => $addCharge
        ];

        $orderPlaced = Orders::create($data);
        $this->commissionClass->disseminate($amount, 2);
      
        Mail::to($orderPlaced->details->email)->send(new OrderConfirmation($orderPlaced));

        return $orderPlaced;
    }
}