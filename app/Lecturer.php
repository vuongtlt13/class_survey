<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = [
        'degree',
    ];

    public $timestamps = false;
    protected $table = "lecturers";

    public function user() {
        return $this->belongsTo('App\User', 'id');
    }

    public function classes() {
        return $this->hasMany('App\Classes', 'lecturer_id');
    }
}
