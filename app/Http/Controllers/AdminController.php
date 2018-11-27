<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index() {
      return view('admin/index');
    }

    function userManager() {
      return view('admin/user');
    }

    function surveyManager() {
      return view('admin/survey');
    }

    function surveyTemplateManager() {
      return view('admin/survey-template');
    }
}
