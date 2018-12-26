<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name',
        'is_default'
    ];

    protected $table = "survey_templates";

    public function questions() {
        return $this->belongsToMany('App\Question', 'surveytemplate_question', 'surveytemplate_id', 'question_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($template) { // before delete() method call this
            $template->questions()->detach();
        });
    }
}
