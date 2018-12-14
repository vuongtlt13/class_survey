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
        $this->belongsTo('App\User', 'id');
    }
}
