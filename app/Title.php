<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable = [
        'content',
    ];

    public $timestamps = false;
    protected $table = "titles";

    public function questions() {
        return $this->hasMany('App\Question', 'title_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($title) { // before delete() method call this
//            dd($title);
            $questions = $title->questions()->get();
//            dd($questions);
            foreach ($questions as $question) {
                if ($question != null) {
                    $question->delete();
                }
            }
        });
    }
}
