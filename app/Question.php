<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'content',
        'title_id',
    ];

    public $timestamps = false;
    protected $table = "questions";

    public function title() {
        return $this->belongsTo('App\Title', 'title_id', 'id');
    }

    public function templates() {
        return $this->belongsToMany('App\Template', 'surveytemplate_question', 'question_id', 'surveytemplate_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($question) { // before delete() method call this
            $question->templates()->detach();
        });
    }
}
