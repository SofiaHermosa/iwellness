<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    function forgetPasswordPage(){
        return view('auth.passwords.find-account');
    }

    function retriveAccount(Request $request){
        switch ($request->method()) {
            case 'POST':
            $request->validate([
                'username'  => 'required|exists:users'
            ]);

            $user = User::where('username', $request->username)->first();

            if ($user) {
                return view('auth.passwords.email', compact('user'));
            }

            return back()->withInput()->with('error', 'Credential not found');
            break;
            default:
                return view('auth.passwords.find-account');
            break;
        }    
    }

    function retriveAccountUsingSecretQuestion(Request $request){
        $request->validate([
            'email'     => 'required|email|exists:users',
            'username'  => 'required|exists:users',
            'answer'    => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
                            ->where('email', $request->email)
                            ->first();

        if (!Hash::check($request->token, $updatePassword->token)) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('username', $request->username)->where('email', $request->email)->first();
        if (strtoupper($user->secret_question->answer  ?? '') == strtoupper($request->answer)) {
                Auth::login(User::findOrFail($user->id));
                DB::table('password_resets')->where('email', $request->email)->delete();
                return redirect('res/profile');
        }

        return back()->withInput()->with('error', 'Incorrect answer');
    }
}
