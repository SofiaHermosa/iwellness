<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "subscription";

    protected $fillable = [
        'user_id',
        'start',
        'end',
        'validity',
        'status',
        'valid',
    ];

    public function capital() {
        return $this->hasMany('App\Models\Capital', 'subscription_id')->where('status', 1);
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
