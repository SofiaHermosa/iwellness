<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\Contracts\Activity;

class Capital extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "capital";

    protected static $logName = 'capital';

    protected $fillable = [
        'user_id',
        'subscription_id',
        'amount',
        'status'
    ];

    protected static $logAttributes = [
        'user_id',
        'subscription_id',
        'amount',
        'status'
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $data = json_decode($activity->properties)->attributes;

        $description = ucfirst($eventName)." capital amounting ". number_format($data->amount, 2, '.', ',');
        $activity->description = $description;
    }
}
