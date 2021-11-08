<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\IWellness\UsersClass;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $usersClass;

    public function __construct(){
        $this->usersClass = new UsersClass;
    }
    public function index()
    {
        try { 
            if(request()->ajax()){
                $users = $this->usersClass->get()->users;
                return response()->json(['data'=> $users]);
            }
            return view('admin.users.index');//code...
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $this->usersClass->updateCreate();
            Session::flash('message', 'User was successfully added'); 

            return back();
        } catch (\Throwable $th) {
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
        $user = $this->usersClass->get($id)->users->first();
        return view('admin.users.module.create', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $this->usersClass->updateCreate();
            Session::flash('message', 'User was successfully updated'); 

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
        //
    }
}
