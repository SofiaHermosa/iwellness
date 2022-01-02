<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\IWellness\CartClass;
use App\IWellness\OrderingClass;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $cartClass, $orderingClass;

    public function __construct()
    {
        $this->cartClass        = new CartClass;
        $this->orderingClass    = new OrderingClass;
    }
    public function index()
    {
        return view('member.cart.index');
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
        $this->cartClass->products()->updateCart();

        return response()->json([
            'message' => 'products successfully added to cart',
            'cart'    => auth()->check() ? auth()->user()->cart : Session::get('my-cart') 
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->orderingClass->get($id)->orders->first();
        return view('content.order-invoice', compact('order'));
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
        $this->cartClass->updateOrderQty();

        return response()->json([
            'message' => 'Cart successfully updated',
            'cart'    => auth()->user()->cart ?? json_decode(Session::get('my-cart'))
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cartClass->deleteProd($id);

        return response()->json([
            'message' => 'Product Successfully removed to cart',
            'cart'    => auth()->user()->cart ?? json_decode(Session::get('my-cart'))
        ], 200);
    }

    public function proceedToCheckout(Request $request)
    {   
        if(auth()->check()){
            $toCheckedOut = $request->checkout;
            return $this->checkOrderTotal($toCheckedOut);
        }else{
            Session::flash('message', 'To proceed checkout please sign-in or sign-up your account.');
            return redirect('register');
        }
    }

    public function checkoutPayment(Request $request){
        $request['orders'] = json_decode(base64_decode($request->orders));
        $checkout_details  = base64_encode(json_encode($request->all()));
        Session::put('checkout_details', $checkout_details);
        return view('payment.pay-checkout', compact('checkout_details'));
    }

    public function checkOrderTotal($cart){
        $toCheckedOut = $cart;
        $amount = [];
    
        foreach($cart ?? [] as $checkout){
            $id         = base64_decode($checkout);
            $orders     = auth()->check() ? auth()->user()->cart->$id : json_decode(Session::get('my-cart'))->$id;
            $amount[]   = $orders->price * $orders->quantity;
        }

        $amount = array_sum($amount);
       
        if($amount < 500){
            Session::flash('error', "Orders can't be less than 500"); 
            return back();
        }

        return view('content.checkout-details', compact('toCheckedOut'));
    }
}
