<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use DB;

class CashOut extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'cash_out';

    protected static $logName = 'cash out';

    protected $fillable = [
        'user_id',
        'amount',
        'details',
        'status',
        'declining_reason'
    ];

    protected static $logFillable = true;

    protected $appends = [
        'status_badge',
        'date_sent',
        'amount_number_format',
        'transac_id',
        'username',
        'name_user'
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $data = json_decode($activity->properties)->attributes;
        $old  = json_decode($activity->properties)->old ?? [];
        $description = ucfirst($eventName)." cash-out request amounting ₱ ".number_format($data->amount, 2, '.', ',').' with transaction # '.$activity->subject->transac_id;
        
        if($eventName == 'updated' && $data->status == 1 && $old->status == 0){
            $description = "Cash-out request amounting ₱ ".number_format($data->amount, 2, '.', ',').' with transaction # '.$activity->subject->transac_id . ' has been approved.';
        }

        $activity->description = $description;
        $activity->causer_id   = $data->user_id ?? auth()->user()->id;
    }

    public function getTransacIdAttribute(){
        return generateIDs('CO', $this->id);
    }

    public function getDetailsAttribute($value)
    {
        return json_decode($value);
    }

    public function setAmountAttribute($value){
        $this->attributes['amount'] = str_replace(',','',$value);
    }

    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = json_encode($value);
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getUsernameAttribute(){
        $user = DB::table('users')->select('username')->where('id', $this->user_id)->first();

        return $user->username;
    }

    public function getNameUserAttribute(){
        $user = DB::table('users')->select('name')->where('id', $this->user_id)->first();

        return $user->name;
    }

    public function getAmountNumberFormatAttribute(){
        $percent  = $this->amount * 0.02;
        $amount   = $this->amount - $percent; 
        return preg_replace('/(\.0+|0+)$/', '',number_format(round($amount, 2), 2, '.', ','));
    }

    public function getStatusBadgeAttribute(){
        if($this->status == 1){
            return "<span class='badge badge-lg badge-success'>Approved</span>";
        }else if($this->status == 2){
            return "<span class='badge badge-lg badge-danger'>Declined</span>";
        }else{
            return "<span class='badge badge-lg badge-default'>Pending</span>";
        }
    }

    public function getDateSentAttribute(){
        return $this->created_at->format('M d, Y g:ia');
    }
}
