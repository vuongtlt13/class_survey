<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Yajra\Datatables\Datatables;

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

    function questionManager() {
      echo('quan ly cau hoi');
    }

    function createUser(Request $request) {
      dd($request);
    }

    function searchUser(Request $request) {
      // dd($request);
      $word = $request->input('word');
      if ($word == null) {
        $word = "";
      }
      $type = $request->input('type');
      if ($type == "all") {
        $type = "";
      }
      $gender = $request->input('gender');
      if ($gender == "all") {
        $gender = "";
      }
      // dd($gender);
      $users = User::where('type', 'like', $type . '%')
                  ->where(function ($query) use ($gender) {
                    $query->where('gender', 'like', $gender . '%')
                          ->orWhereNull('gender');
                  })
                  ->where(function ($query) use ($word) {
                      $query->where('username', 'like', '%' . $word . '%')
                            ->orWhere('name', 'like', '%' . $word . '%')
                            ->orWhere('id_number', 'like', '%' . $word . '%')
                            ->orWhere('phone', 'like', '%' . $word . '%')
                            ->orWhere('email', 'like', '%' . $word . '%');
                  });
                  // ->get();
      // dd($users);
      return Datatables::of($users)->make(true);
    }
}
