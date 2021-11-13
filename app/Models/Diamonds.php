<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diamonds extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diamonds';

    protected $fillable = [
        'user_id',
        'from',
        'amount',
        'downline_id'
    ];
}
