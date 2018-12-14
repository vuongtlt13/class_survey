<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Notifications\Notifiable;

class User extends EloquentUser
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'permissions',
        'name',
        'id_number',
        'address',
        'type',
        'is_active',
        'gender',
        'dob',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];
    protected $table = 'users';
    protected $loginNames = ['username'];

    public function student()
    {
        return $this->hasOne('App\Student', 'id');
    }

    public function lecturer()
    {
        return $this->hasOne('App\Lecturer', 'id');
    }


    public static function boot() {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
            if ($user->type == 0) {
                $user->student()->delete();
            } elseif ($user->type == 1) {
                $user->lecturer()->delete();
            }
        });

        static::created(function($user) { // before delete() method call this
            if ($user->type == 0) {
                $student = new Student([]);
                $user->student()->save($student);
            } elseif ($user->type == 1) {
                $lecturer = new Lecturer([]);
                $user->lecturer()->save($lecturer);
            }
        });
    }
}
