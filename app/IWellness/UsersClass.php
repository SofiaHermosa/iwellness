<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\User;
use Storage;
use Session;
use DB;


class UsersClass
{
    public $users, $request;
    public function __construct()
    {
       $this->request = request(); 
    }

    public function get($id=null){
        if(!empty($id)){
            $this->users = User::where('id', $id)->get();
            return $this;
        }

        $users = DB::table('users')->orderBy('created_at')->where('id', '!=', 1)->get();
   
        foreach($users as $keys => $user){
            $referer  =  DB::table('users')->where('id', $user->referer)->first();
            $position =  DB::table('model_has_roles')->where('model_id', $user->id)->leftJoin('roles', function($join) {
                $join->on('model_has_roles.role_id', '=', 'roles.id');
            })->first();
            $user->position        = ucwords($position->name);
            $user->referrer_uname  = $referer->username ?? null;
            $this->users[] = $user;
        }
        
        return $this;
    }

    public function updateCreate($id=null){
        if(!empty($id)){
            $this->request['id'] = $id;
        }

        if($this->request->position == 'system administrator'){
            $this->request->user_type = 1;
        }else{
            $this->request->user_type = 2;
        }

        $user = User::updateOrCreate(
            ['id' => $this->request->id ?? null],
            $this->request->except(['_token', 'position', 'password_confirmation'])
        );

       
        $role = $this->get($user->id)->users->first();
        $role->roles()->detach();
        $role->assignRole($this->request->position);

        $this->users = $user;
        
        return $this;
    }

    public function saveImages(){
        $images = [];

        foreach($this->request->file('image') as $image){
            $path = $image->store('products');

            array_push($images, $path);
        }

        $this->request['images'] = $images;
    }
}