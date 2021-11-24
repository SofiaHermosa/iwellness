<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestions extends Model
{
    use HasFactory;

    protected $table = "survey_questions";

    protected $fillable = [
        'question',
        'answer',
        'type',
    ];

    protected $appends = [
        'date_sent',
        'choices'
    ];
    
    public function setAnswerAttribute($value){
        $this->attributes['answer'] = json_encode(explode(',', $value));
    }

    public function getAnswerAttribute($value){
       return json_decode($value);
    }

    public function getChoicesAttribute($value){
        return implode(', ', $this->answer);
     }

    public function getDateSentAttribute(){
        return $this->created_at->format('M d, Y g:ia');
    }
}
