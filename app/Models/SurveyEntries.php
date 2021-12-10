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
        'answer',
        'month',
        'subs_id',
        'key'
    ];

    public function setMonthAttribute($value)
    {
        $this->attributes['month'] = date('F');
    }

    public function setAnswerAttribute($value)
    {
        $this->attributes['answer'] = json_encode($value);
    }

    public function getAnswerAttribute($value)
    {
        return json_decode($value);
    }
}
