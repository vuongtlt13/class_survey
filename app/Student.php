<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'khoahoc',
        'major',
    ];

    public $timestamps = false;
    protected $table = "students";

    public function user() {
        return $this->belongsTo('App\User', 'id');
    }
}
