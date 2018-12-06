<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class UserController extends Controller
{
    static function create_admin($username, $password, $is_active) {
        try {
            $credentials = [
                'username' => $username,
                'password' => $password,
                'is_active' => $is_active,
                'type' => 2,
            ];

            $user = Sentinel::registerAndActivate($credentials);
            return true;
        } catch (Illuminate\Database\QueryException $e) {
              // report($e);
              return false;
        }
    }

    function profile() {
        return view('profile');
    }
}
