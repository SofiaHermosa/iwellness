<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IWellness\DiamondConversionClass;
use Illuminate\Support\Facades\Session;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $itemClass;

    public function __construct()
    {
        $this->itemClass = new DiamondConversionClass;
    }

    public function index()
    {
        $items = $this->itemClass->get()->data;
       
        if(request()->ajax()){
            return response()->json(['data'=> $items]);
        }
        return view('admin.items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.items.module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->itemClass->updateCreate();
            Session::flash('message', 'Item was successfully added'); 

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
        $item = $this->itemClass->get($id)->data->first();

        return view('admin.items.module.create', compact('item'));
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
            $this->itemClass->updateCreate($id);
            Session::flash('message', 'Item was successfully updated'); 

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
        $this->itemClass
        ->get($id)
        ->data
        ->first()
        ->delete();

        Session::flash('error', 'Item successfully deleted'); 

        return redirect('res/diamond/conversion/items');
    }
}
