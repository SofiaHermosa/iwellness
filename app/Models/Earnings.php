<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Earnings extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'earnings';

    protected static $logName = 'earning';

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
        $event  = $eventName == 'created' ? 'earned' : 'used';
        $from   = $activity->causer_id == $data->user_id ? config('constants.payment_transaction_type.'.$data->from) : ($data->from == 1 ? 'referral bonus' : ($data->from == 4 ? 'change' : ($data->from == 3 ? 'profit' :'commission')));
        $member = empty($activity->causer) ? '' : ($activity->causer_id == $data->user_id ? '' : ' from '.$activity->causer->username ?? null);     
        $description = ucfirst($event)." ". $from ." total of ".number_format($data->amount, 2, '.', ',').' '.$member;
        if($activity->causer_id == $data->user_id){
            $description = ucfirst($event)." total of ".number_format($data->amount, 2, '.', ',').' from '.$from;
        }
        $activity->causer_id = $data->user_id;
        $activity->description = $description;
    }
}
