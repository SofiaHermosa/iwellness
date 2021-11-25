<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment';

    protected static $logName = 'payment';

    protected $fillable = ['user_id', 'pg_transaction_id', 'payment_source', 'amount_paid'];

    protected static $logFillable = true;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $data = json_decode($activity->properties)->attributes;

        $description = ucfirst($eventName)." payment via ".$activity->subject->payment_source." amounting ₱ ".number_format($data->amount_paid, 2, '.', ',').' with transaction # '.$activity->subject->pg_transaction_id;
        $activity->description = $description;
    }
}
