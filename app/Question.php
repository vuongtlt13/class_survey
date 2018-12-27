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
        return $this->belongsToMany('App\Template', 'template_question', 'question_id', 'template_id');
    }

    public function class_students() {
        return $this->belongsToMany('App\ClassStudent', 'class_student_question', 'question_id', 'class_student_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($question) { // before delete() method call this
            $question->templates()->detach();
            $question->class_students()->detach();
        });
    }
}
