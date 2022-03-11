<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = "subscription";

    protected static $logName = 'subscription';

    protected $fillable = [
        'user_id',
        'start',
        'end',
        'validity',
        'status',
        'valid',
        'complan'
    ];

    protected $appends = [
        'release_dates',
        'date_sent',
        'valid_until',
        'complan_badge'
    ];

    protected static $logFillable = true;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $data = json_decode($activity->properties)->attributes;

        $description = ucfirst($eventName)." subscription for the month of ". $activity->subject->created_at->format('F');
        $activity->description = $description;
    }

    public function capital() {
        return $this->hasMany('App\Models\Capital', 'subscription_id')->where('status', 1);
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getReleaseDatesAttribute(){        
        $releaseSched = array(
            $this->created_at->addDays(8)->format('M d'),
            $this->created_at->addDays(16)->format('M d'),
            $this->created_at->addDays(24)->format('M d'),
            $this->created_at->addDays(32)->format('M d')
        );
        
        if(in_array($this->complan, [2, 3])){
            $releaseSched[] = $this->created_at->addDays(40)->format('M d');
        }

        return $releaseSched ?? [];
    }

    public function getDateSentAttribute(){
        return $this->created_at->format('M d, Y g:ia');
    }

    public function getValidUntilAttribute(){
        return Carbon::parse($this->created_at)->addDays(in_array($this->complan, [2, 3]) ? 40 : 32)->format('M d, Y g:ia');
    }

    public function getComplanBadgeAttribute(){
        return '<badge class="badge badge-lg '.config('constants.complans.'.$this->complan.'.class').'">'.strtoupper(config('constants.complans.'.$this->complan.'.name')).'</badge>';
    }
}
