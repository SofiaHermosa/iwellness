<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLogs;
use App\Models\Subscription;
use App\Models\Orders;
use App\Models\Earnings;
use App\Models\CashIn;
use Session;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected static $logName = 'profile';
    
    protected $fillable = [
        'name',
        'contact',
        'username',
        'address',
        'referer',
        'activated',
        'user_type',
        'secret_question',
        'email',
        'password',
        'prof_img'
    ];

    protected static $logFillable = true;

    protected $appends = [
        'secret_question_string',
        'subscrip_status',
        'position',
        'referrer_uname',
        'cart',
        'orders',
        'wallet_balance',
        'earning_dates',
        'capital',
        'active_subscriptions',
        'is_active',
        'sales'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasSubscription() {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    public function subscription(){
        return $this->hasSubscription()
        ->orderBy('created_at', 'DESC')
        ->with('capital')
        ->get();
    }

    public function getIsActiveAttribute(){
        $subscription = $this->hasSubscription()
        ->orderBy('created_at', 'DESC')
        ->where('status', 1)
        ->where('valid', 1)
        ->first();

        if(!empty($subscription) && auth()->user()->activated == 1){
            return true;
        }

        return false;
    }

    public function getCapitalAttribute(){
        return Capital::where('user_id', $this->id)
        ->get()
        ->sum('amount');
    }

    public function setSecretQuestionAttribute($value)
    {
        $this->attributes['secret_question'] = json_encode($value);
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    public function getSecretQuestionAttribute($value)
    {
        return json_decode($value);
    }

    public function getActiveSubscriptionsAttribute(){
        $subscriptions = new Subscription;

        if(!auth()->user()->hasanyrole('system administrator')){
            $subscriptions = $subscriptions
            ->where('user_id',auth()->user()->id);
        }

        $subscriptions = $subscriptions
        ->with('capital')
        ->where('valid', 1)
        ->where('status', 1)
        ->orderBy('created_at', 'DESC')
        ->get();

        return $subscriptions ?? [];
    }

    public function referrer(){
        return $this->belongsTo('App\Models\User', 'referer');
    }

    public function child(){
        return $this->hasMany('App\Models\User', 'referer');
    }

    public function parent(){
        return $this->belongsTo('App\Models\User', 'referer', 'id');
    }

    public function getNetwork(){
        return $this->child()->with('child')->get();
    }

    public function getParent(){
        return $this->child()->with(['parent', 'parent.parent.parent'])->get();
    }

    public function getSecretQuestionStringAttribute(){
        $question = $this->secret_question;
        
        if(!empty($question)){
            return config('constants.questions.'.$question->question)."<br> Answer: ".$question->answer;
        }

        return '';
    }

    public function getSubscripStatusAttribute(){
        $subscription = $this->hasSubscription();
        if(!empty($subscription->first()) && !empty($subscription->where('valid', 1)->where('status', 1)->first())){
            return '<center><span class="badge badge-lg badge-success">Active</span><center>';
        }

        return '<center><span class="badge badge-lg badge-default">Inactive</span></center>';
    }
    
    public function getPositionAttribute(){
        return !empty($this->roles->first()->name) ? ucwords($this->roles->first()->name) : '';
    }

    public function getReferrerUnameAttribute(){
        $referrer = $this->referrer;

        return $referrer->username ?? '';
    }

    public function cart(){
        return $this->belongsTo('App\Models\Cart', 'id','user_id');
    }

    public function getCartAttribute()
    {
        return $this->cart()->first()->cart ?? [];
    }

    public function orders(){
        return $this->hasMany(Orders::class,'user_id');
    }

    public function getOrdersAttribute()
    {
        return $this->orders()->get() ?? [];
    }

    public function wallets(){
        return $this->belongsTo('App\Models\Wallets','id','user_id');
    }

    public function logs(){
        return auth()->user()->hasanyrole('system administrator') ? Activitylogs::whereNotIn('log_name', ['survey', 'login','profit', 'profile'])->whereNotIn('description', ['created', 'updated'])->with('user')->get() : $this->hasmany(Activitylogs::class,'causer_id')->whereNotIn('log_name', ['survey', 'login','profit', 'profile'])->whereNotIn('description', ['created', 'updated']);
    }

    public function getWalletBalanceAttribute(){
        $cashout = CashOut::where('status', 0)->where('user_id', $this->id)->get()->sum('amount');
        $wallet  = $this->wallets()->first()->balance ?? 0;
        $balance = $wallet - $cashout;
        $balance = $balance < 0 ? 0 : $balance;

        return  $balance;
    }

    public function getProfImgAttribute($value){
        return !empty($value) ? asset('storage/'.$value) : asset('assets/images/default-profile.jpg');
    }

    public function getEarningDatesAttribute(){
        $releaseSched = [];
        $subscriptions = Subscription::where('user_id', $this->id)
        ->orderBy('created_at', 'DESC')
        ->get() ?? '';

        foreach($subscriptions as $subscription){
            $releaseSched[$subscription->id][] = $subscription->created_at->addDays(7)->format('Y-m-d');
            $releaseSched[$subscription->id][] = $subscription->created_at->addDays(15)->format('Y-m-d');
            $releaseSched[$subscription->id][] = $subscription->created_at->addDays(22)->format('Y-m-d');
            $releaseSched[$subscription->id][] = $subscription->created_at->addDays(29)->format('Y-m-d');
        }

        return $releaseSched ?? [];
    }

    public function getSalesAttribute(){
        $orders     = Orders::where('user_id', $this->id)->get()->sum('total');
        $earnings   = Earnings::where('user_id', $this->id)->withTrashed()->get()->sum('amount');
        $cashin     = Cashin::where('user_id', $this->id)->withTrashed()->get()->sum('amount');
        $total      = $orders + $earnings + $cashin;

        return $total;
    }
}
