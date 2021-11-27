<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Diamonds extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'diamonds';

    protected static $logName = 'diamond earned';

    protected $fillable = [
        'user_id',
        'from',
        'amount',
        'downline_id'
    ];

    protected static $logFillable = true;
}
