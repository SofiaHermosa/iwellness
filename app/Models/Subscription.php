<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\Contracts\Activity;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "subscription";

    protected static $logName = 'subscription';

    protected $fillable = [
        'user_id',
        'start',
        'end',
        'validity',
        'status',
        'valid',
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

}
