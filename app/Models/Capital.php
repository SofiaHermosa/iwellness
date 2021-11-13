<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capital extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "capital";

    protected $fillable = [
        'user_id',
        'subscription_id',
        'amount',
        'status'
    ];
}
