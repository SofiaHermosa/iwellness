<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Diamonds extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'diamonds';

    protected static $logName = 'diamond earned';

    protected $fillable = [
        'user_id',
        'from',
        'amount',
        'downline_id'
    ];

    protected static $logFillable = true;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $data   = json_decode($activity->properties)->attributes;
        $event  = $eventName == 'created' ? 'earned' : $eventName;

        $description = ucfirst($event)." diamond total of ".number_format($data->amount, 2, '.', ',').' from '.config('constants.payment_transaction_type.'.$data->from);
        $activity->description = $description;
    }
}
