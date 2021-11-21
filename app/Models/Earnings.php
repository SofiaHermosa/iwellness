<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Earnings extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'earnings';

    protected static $logName = 'earning';

    protected $fillable = [
        'user_id',
        'from',
        'amount',
        'downline_id'
    ];

    protected static $logFillable = true;
}
