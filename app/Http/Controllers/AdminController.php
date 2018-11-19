<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index() {
      return view('admin/index');
    }

    function userManager() {
      return view('admin/admin-manager');
    }

    function surveyQuestionnaireManager() {
      return view('admin/surveyQuestionnaire-manager');
    }
}
