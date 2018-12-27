<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name',
        'is_default'
    ];

    protected $table = "templates";

    public function questions() {
        return $this->belongsToMany('App\Question', 'template_question', 'template_id', 'question_id');
    }

    public function classes() {
        return $this->hasMany('App\Classes', 'template_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($template) { // before delete() method call this
            $template->questions()->detach();
            $classes = $template->classes;
            foreach ($classes as $class) {
                $class->template_id = null;
                $class->is_done = 0;
                $class->save();
            }
        });
    }
}
