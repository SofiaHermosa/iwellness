<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Orders extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "orders";

    protected static $logName = 'order';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'cart',
        'details',
        'total',
        'delivered',
        'order_id',
        'shipping_fee',
        'payment_charge'
    ];

    protected static $logFillable = true;
    
    protected $appends = [
        'full_address',
        'ordered_list',
        'order_contact',
        'order_date',
        'status_badge'
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $data = json_decode($activity->properties)->attributes;

        $description = ucfirst($eventName)." order amounting ₱ ".number_format($data->total, 2, '.', ',').' with transaction '.$activity->subject->order_id;
        $activity->description = $description;
    }

    public function setCartAttribute($value){
        $this->attributes['cart'] = json_encode($value);
    }


    public function getOrderedListAttribute(){
        $list = collect($this->cart)->pluck('details.name')->toArray();
        $list = implode(',', $list);

        return strlen($list) > 30 ? substr($list,0,30)."..." : $list;
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getCartAttribute($value){
        return json_decode($value);
    }

    public function setDetailsAttribute($value){
        $this->attributes['details'] = json_encode($value);
    }

    public function getDetailsAttribute($value){
        return json_decode($value);
    }

    public function getFullAddressAttribute(){
        $suite = !empty($this->details->apartment) ? ' ,'.$this->details->apartment : ''; 
        
        return $this->details->address.$suite;
    }

    public function getOrderContactAttribute(){
        return $this->details->contact_no;
    }

    public function getOrderDateAttribute(){
        return $this->created_at->format('F d, Y g:i a');
    }

    public function getStatusBadgeAttribute(){
        $badge = "<span class='badge badge-lg badge-default'>Pending</span>";
        if(!empty($this->delivered)){
            $badge = "<span class='badge badge-lg badge-success'>Delivered</span>";   
        }

        return $badge;
    }
}
