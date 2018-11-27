<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    function index() {
      return view('student');
    }

    function survey() {
      return view('survey');
    }
}
