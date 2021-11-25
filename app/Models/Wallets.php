<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Crypt;

class Wallets extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wallets';

    protected static $logName = 'wallet';

    protected $fillable = [
        'user_id',
        'balance'
    ];

    protected static $logFillable = true;

    public function getBalanceAttribute($value){
        return str_replace('$','0',base64_decode(Crypt::decryptString($value)));
    }

    public function setBalanceAttribute($value){
        $this->attributes['balance'] = Crypt::encryptString(base64_encode(str_replace('0','$',$value)));
    }
}
