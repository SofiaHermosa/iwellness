<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\IWellness\OrderingClass;
use Illuminate\Http\Request;
use App\Models\Orders;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $orderingClass;

    public function __construct()
    {
        $this->orderingClass = new OrderingClass;
    }

    public function index()
    {
        $orders = $this->orderingClass->get()->orders;
        if(request()->ajax()){
            return response()->json(['data'=> $orders]);
        }
        return view('admin.orders.index');
    }

    public function userOrders()
    {
        $orders = auth()->user()->orders;
        if(request()->ajax()){
            return response()->json(['data'=> $orders]);
        }
        return view('member.orders.index');
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
        $order = Orders::findOrFail($id);
        $order->delivered = date('Y-m-d');
        $order->save();

        return redirect('res/orders');
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
