<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\Contracts\Activity;

class CashIn extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cash_in';

    protected static $logName = 'cash in';

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
        'attachments',
        'date_sent',
        'amount_number_format',
        'prop',
        'transac_id'
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $data = json_decode($activity->properties)->attributes;

        $description = ucfirst($eventName)." cash-in request amounting ₱ ".number_format($data->amount, 2, '.', ',').' with transaction # '.$activity->subject->transac_id;
        $activity->description = $description;
    }

    public function getTransacIdAttribute(){
        return generateIDs('CI', $this->id);
    }

    public function getDetailsAttribute($value)
    {
        return json_decode($value);
    }

    public function setAmountAttribute($value){
        $this->attributes['amount'] = str_replace(',','',$value);
    }

    public function getAmountAttribute($value){
        return $this->TrimTrailingZeroes($value);
    }

    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = json_encode($value);
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getPropAttribute(){
        return $this->details->attachments[0];
    }

    public function getAmountNumberFormatAttribute(){
        return preg_replace('/(\.0+|0+)$/', '',number_format(round($this->amount, 2), 2, '.', ','));
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

    public function getAttachmentsAttribute(){
        return !empty($this->details->attachments[0]) ? asset('storage/'.$this->details->attachments[0]) : null;
    }

    public function getDateSentAttribute(){
        return $this->created_at->format('M d, Y g:ia');
    }

    public function TrimTrailingZeroes($nbr) {
        return strpos($nbr,'.')!==false ? rtrim(rtrim($nbr,'0'),'.') : $nbr;
    }
}
