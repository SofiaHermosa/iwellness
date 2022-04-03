<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\AccountConfirmationEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Session;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'min:6', 'unique:users'],
            'secret_question.question' => ['required'],
            'secret_question.answer' => ['required'],
            'referer' => ['nullable', 'min:6'],
            'contact' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ['required', 'captcha']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {   
        $referrer = $this->referrer($data['referer']);

        $data['referer']            = $referrer->id ?? null;

        unset($data['_token']);

        $registeredUser = User::create($data);

        $registeredUser->assignRole('observer');

        Mail::to($registeredUser->email)->send(new AccountConfirmationEmail($registeredUser));
        
        return $registeredUser;
    }

    protected function updateCart(){
        $cart = Session::has('my-cart') ? json_decode(Session::get('my-cart')) : [];

        if(!empty($cart)){
            Cart::updateOrCreate(
                ['user_id' => auth()->user()->id],
                [
                    'user_id' => auth()->user()->id,
                    'cart'    => $cart
                ]
            );
        }
    }

    protected function redirectTo()
    {
        $this->updateCart();
        
        Session::flash('message', 'Registered successfully,<br/> Check your email for account activation');
        return 'res';
    }

    public function referrer($uname){
        return User::where('username', $uname)->first();
    }

    public function verifyEmail($user){
        $user = User::where('id', base64_decode($user))->where('email_verified_at', null)->update(['email_verified_at' => Carbon::now()]);
        
        return view('auth.successfully-verified');
    }
}
