<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyEntries extends Model
{
    use HasFactory;

    protected $table = "survey_entries";

    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
        'month'
    ];

    public function setMonthAttribute($value)
    {
        $this->attributes['month'] = date('F');
    }
}
