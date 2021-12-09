<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\IWellness\AdsClass;
use Session;
use DB;

class WatchedAds
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public $AdsClass;

    public function __construct()
    {
        $this->AdsClass   = new AdsClass;
    }

    public function handle(Request $request, Closure $next)
    {
        $this->AdsClass->releaseAds();
        
        return $next($request);
    }
}
