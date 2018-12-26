<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    function index() {
      return view('teacher');
    }

    function detailResult(Request $request){
      return view('lecturer.general_survey_result');
    }
}
