<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTemplate extends Model
{
    protected $fillable = [
        'question_id',
        'surveytemplate_id',
    ];

    public $timestamps = false;
    protected $table = "surveytemplate_question";
}
