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
}
