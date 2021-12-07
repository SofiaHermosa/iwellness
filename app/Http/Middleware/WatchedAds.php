<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\IWellness\SurveyClass;
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
    public $surveyClass;

    public function __construct()
    {
        $this->surveyClass   = new SurveyClass;
    }

    public function handle(Request $request, Closure $next)
    {
        if($this->surveyClass->watchedAds() && !auth()->user()->hasanyrole('system administrator')){
            $ads = DB::table('ads_videos')
            ->inRandomOrder()
            ->first();

            session()->put('play_ads', $ads->link ?? null);
        }else{
            session()->has('play_ads') ? session()->forget('play_ads') : ''; 
        }
        
        return $next($request);
    }
}
