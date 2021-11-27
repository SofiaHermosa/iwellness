<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Cart extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = "cart";

    protected static $logName = 'cart';
    
    protected $fillable = [
        'user_id',
        'cart'
    ];

    protected static $logFillable = true;

    public function setCartAttribute($value)
    {
        $this->attributes['cart'] = json_encode($value);
    }

    public function getCartAttribute($value)
    {
        return json_decode($value);
    }
}
