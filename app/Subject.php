<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'class_code',
        'subject_code',
        'lecturer_id',
        'school_year',
        'term',
        'template_id'
    ];

    protected $table = "subjects";
    public $timestamps = false;

    public function classes()
    {
        return $this->hasMany('App\Classes', 'subject_code', 'code');
    }
}
