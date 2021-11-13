<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "cart";
    
    protected $fillable = [
        'user_id',
        'cart'
    ];

    public function setCartAttribute($value)
    {
        $this->attributes['cart'] = json_encode($value);
    }

    public function getCartAttribute($value)
    {
        return json_decode($value);
    }
}
