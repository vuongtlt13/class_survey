<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class LoginController extends Controller
{
    function login() {
        return view('auth/login');
    }

    function authentication(Request $request) {
        // dd($request);
        $credentials = [
          'username' => $request->input('username'),
          'password' => $request->input('password'),
        ];

        try {
            if ($user = Sentinel::stateless($credentials)) {
                Sentinel::login($user);
                return redirect(route('index'));
            } else {
                return redirect(route('login')) -> with('result', 'fail');
            }
        } catch (NotActivatedException $ex) {
            return redirect(route('login')) -> with('activation', 'fail');
        }
    }

    function index() {
        $user = Sentinel::check();
        // echo($user->type);
        switch ($user->type) {
            case 0:
                return view('student.index');
                break;
            case 1:
                return view('teacher.index');
                break;
            case 2:
                return view('admin.user');
                break;
            default:
                echo('Permission denied!');
        }
    }

    function logout(Request $request) {
        $user = Sentinel::check();
        Sentinel::logout($user);
        return redirect()->route('index');
    }
}
