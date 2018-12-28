<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionScore extends Model
{
    protected $fillable = [
        'class_student_id',
        'question_id',
        'score',
    ];

    protected $table = "class_student_question";
    public $timestamps = false;

    public function question() {
        return $this->belongsTo('App\Question', 'question_id', 'id');
    }
}
