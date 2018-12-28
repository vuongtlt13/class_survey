<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'id',
        'khoahoc',
        'major',
    ];

    public $timestamps = false;
    protected $table = "students";

    public function user() {
        return $this->belongsTo('App\User', 'id');
    }

    public function classes() {
        return $this->belongsToMany('App\Classes', 'class_student','student_id', 'class_id');
    }

    public function class_students() {
        return $this->hasMany('App\ClassStudent', 'student_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($student) { // before delete() method call this
//            dd($student);
            $student->classes()->detach();
        });
    }
}
