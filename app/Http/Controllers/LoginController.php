<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
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
                if ($user->is_active) {
                    Sentinel::login($user);
                    return redirect(route('index'));
                } else {
                    return redirect(route('login')) -> with('block', 'fail');
                }
            } else {
                return redirect(route('login')) -> with('wrong', 'fail');
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
                return view('lecturer.index');
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
