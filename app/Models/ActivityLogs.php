<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
    use HasFactory;

    protected $table = "activity_log";

    protected $fillable = [
        'causer_id',
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'properties'
    ];

    protected $appends = [
        'date_sent'
    ];

    public function getDateSentAttribute(){
        return $this->created_at->format('M d, Y g:ia');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'causer_id');
    }
}
