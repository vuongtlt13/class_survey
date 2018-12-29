<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Lecturer;
use App\Student;
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

    function goToStudentIndex() {
        $user = Sentinel::check();
//        dd($user->id);
        // get all classes of user
        $classes = Student::find($user->id)
            ->class_students()
            ->whereHas('classes', function ($query) {
                $query->where('template_id', '<>', null);
            })
            ->orderBy('is_done')
            ->with(['classes.subject'])
            ->get();
//        ->classes()->where('classes.template_id', '<>', null)->with(['subject'])->orderBy('is_done')->get();
//        return response()->json($classes);
//        dd($classes);
        return view('student.index', ['classes' => $classes]);
    }

    function goToLecturerIndex() {
        $user = Sentinel::check();
        $year = date('Y');
        $month = date("m");
        $term = 0;
        $school_year = $year . '-' . ($year + 1);
//        dd($year, $month);
        if ($month >= 1 and $month <= 6) {
            $term = 1;
        }
        $classes = Lecturer::find($user->id)
            ->classes()->leftJoin('subjects', 'subjects.code', 'classes.subject_code')
            ->groupBy('classes.subject_code')
            ->where('classes.term', $term)
            ->where('classes.school_year', $school_year)
            ->select('subjects.code', 'subjects.name')
            ->get();
//        dd($classes);
        return view('lecturer.view_by_subject', ['classes' => $classes]);
    }

    function index() {
        $user = Sentinel::check();
        // echo($user->type);
        switch ($user->type) {
            case 0:
                return $this->goToStudentIndex();
                break;
            case 1:
                return $this->gotoLecturerIndex();
                break;
            case 2:
                return AdminController::index();
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
