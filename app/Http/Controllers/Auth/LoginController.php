<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\IWellness\ActivityClass;
use Session;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/res';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $activityClass;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->username = 'username';

        $this->activityClass = new ActivityClass;
    }

    public function username()
    {
        return $this->username;
    }

    protected function redirectTo(){
        if(auth()->user()->hasanyrole('system administrator')){
            return '/res/dashboard/';
        }else{
            auth()->user()->dailyLogin();
            auth()->user()->checkDailyLogin();
            $this->activityClass->logActivity('login', auth()->user()->id);
            Session::flash('has_logged_in', 'Recently logged in');
            return '/res/profile/';
        }

        return '/res';
    }
}
