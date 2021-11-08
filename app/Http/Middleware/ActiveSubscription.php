<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ActiveSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->hasSubscription && auth()->user()->activated) {
            return $next($request);    
        }else{
            Session::flash('error', 'Fund is on-hold please activate/re-activate account');
            return redirect('res/profile'); 
        }
    }
}
