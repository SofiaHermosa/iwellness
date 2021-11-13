<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversionRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diamond_conversion';

    protected $fillable = [
        'user_id',
        'item_id',
        'status',
        'declining_reason',
        'details'
    ];

    protected $appends = [
        'status_badge',
        'date_sent',
        'full_address'
    ];

    public function setDecliningReasonAttribute($value){
        $this->attributes['declining_reason'] = base64_encode($value);
    }

    public function getDecliningReasonAttribute($value){
        return base64_decode($value);
    }

    public function getDetailsAttribute($value)
    {
        return json_decode($value);
    }

    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = json_encode($value);
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function item() {
        return $this->belongsTo('App\Models\DiamondConversionItems', 'item_id', 'id');
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

    public function getFullAddressAttribute(){
        $details    = $this->details->address;
        $suite      = !empty($details->apartment) ? ' ,'.$details->apartment : ''; 
        return $details->address.$suite.', '.$details->city.', '.$details->region.'. '.$details->postal_code;
    }
}
