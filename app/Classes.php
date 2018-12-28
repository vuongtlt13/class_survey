<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'class_code',
        'subject_code',
        'lecturer_id',
        'school_year',
        'term',
        'template_id',
    ];

    protected $table = "classes";

    public function template() {
        return $this->belongsTo('App\Template', 'template_id');
    }

    public function lecturer() {
        return $this->belongsTo('App\Lecturer', 'lecturer_id');
    }

    public function students() {
        return $this->belongsToMany('App\Student', 'class_student', 'class_id', 'student_id');
    }

    public function subject() {
        return $this->belongsTo('App\Subject', 'subject_code', 'code');
    }

    public function class_students() {
        return $this->hasMany('App\ClassStudent', 'class_id', 'id');
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($class) { // before delete() method call this
            $class_students = $class->class_students;
//                dd($class_students);
            foreach ($class_students as $class_student) {
                $class_student->questions()->detach();
            }
            $class->students()->detach();
        });
    }
}
