<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'is_done',
        'note',
    ];

    protected $table = "class_student";
    public $timestamps = false;

    public function questions() {
        return $this->belongsToMany('App\Question', 'class_student_question', 'class_student_id', 'question_id');
    }

    public function question_scores() {
        return $this->hasMany('App\QuestionScore', 'class_student_id', 'id');
    }

    public function classes() {
        return $this->belongsTo('App\Classes', 'class_id', 'id');
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($class_student) { // before delete() method call this
            $class_student->questions()->detach();
        });
    }
}
