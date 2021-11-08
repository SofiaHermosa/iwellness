<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IWellness\ProductClass;
use App\Http\Requests\ProductRequest;
use Session;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $productClass;

    public function __construct()
    {
        $this->productClass = new ProductClass;
    }
    public function index()
    {
        $products = $this->productClass->get()->data;
       
        if(request()->ajax()){
            return response()->json(['data'=> $products]);
        }
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $this->productClass->updateCreate();
            Session::flash('message', 'Product was successfully added'); 

            return back();
        } catch (\Throwable $th) {
            dd($th);
            Session::flash('error', 'Something went wrong'); 

            return back();
        }
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
        $product = $this->productClass->get($id)->data->first();

        return view('admin.products.module.create', compact('product'));
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
        try {
            $this->productClass->updateCreate($id);
            Session::flash('message', 'Product was successfully updated'); 

            return back();
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong'); 

            return back();
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
        $this->productClass
        ->get($id)
        ->data
        ->first()
        ->delete();

        Session::flash('error', 'Product successfully deleted'); 

        return redirect('res/products');
    }
}
