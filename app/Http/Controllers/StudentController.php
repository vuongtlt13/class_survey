<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    function survey() {
      return view('student.survey');
    }
}
