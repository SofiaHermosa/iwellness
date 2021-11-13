<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Earnings extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'earnings';

    protected $fillable = [
        'user_id',
        'from',
        'amount',
        'downline_id'
    ];
}
