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
        $from   = $activity->causer_id == $data->user_id ? config('constants.payment_transaction_type.'.$data->from) : ($data->from == 1 ? 'referral bonus' : 'commission');
        $member = $activity->causer_id == $data->user_id ? '' : ' from '.$activity->causer->username;     
        $description = ucfirst($event)." ". $from ." total of ".number_format($data->amount, 2, '.', ',').' diamond '.$member;
        if($activity->causer_id == $data->user_id){
            $description = ucfirst($event)." diamond total of ".number_format($data->amount, 2, '.', ',').' from '.$from;
        }
        $activity->causer_id = $data->user_id;
        $activity->description = $description;
    }
}
