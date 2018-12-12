<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\User;
use Yajra\Datatables\Datatables;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

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

    function updateUser(Request $request) {
        $status = 1;
        $error = "";
        $user_id = $request->query('id');
//        dd($user_id);
//        $username = $request->input('username');
        $name = $request->input('name');
        $account_type = $request->input('account_type');
        $gender = $request->input('gender');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');
//        # validate username
//        if (!preg_match('/^\w{5,20}$/', $username)) {
//            return 'Tên đăng nhập không hợp lệ';
//        }

        # validate phone
        if ($phone != null && (!preg_match('/^[0-9]{10}$/', $phone))) {
            $error = 'Số điện thoại không hợp lệ';
            $status = 0;
        }

        # validate email
        if ($email != null && (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $error = 'Email không hợp lệ';
            $status = 0;
        }

        # validate type
        if ($account_type > 2 or $account_type < 0) {
            $error = 'Loại tài khoản không hợp lệ';
            $status = 0;
        };

        $user = Sentinel::findById($user_id);
        try {
            $credentials = [
//                'username'    => $username,
                'name' => $name,
                'type' => $account_type,
                'gender' => $gender,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
            ];

            $user = Sentinel::update($user, $credentials);
        } catch (QueryException $e) {
            return response()
                ->json(['status' => 0, 'msg' => 'Trùng tên tài khoản, số điện thoại hoặc email']);
        }
        return response()
            ->json(['status' => $status, 'msg' => $error]);
    }

    function createUser(Request $request) {
        $status = 1;
        $error = "";
        $username = $request->input('username');
        $name = $request->input('name');
        $account_type = $request->input('account_type');
        $gender = $request->input('gender');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');
        # validate username
        if (!preg_match('/^\w{5,20}$/', $username)) {
//            return 'Tên đăng nhập không hợp lệ';
            $error = 'Tên đăng nhập không hợp lệ';
            $status = 0;
        }

        # validate phone
        if ($phone != null && (!preg_match('/^[0-9]{10}$/', $phone))) {
//            return 'Số điện thoại không hợp lệ';
            $error = 'Số điện thoại không hợp lệ';
            $status = 0;
        }

        # validate email
        if ($email != null && (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
//            return 'Email không hợp lệ';
            $error = 'Email không hợp lệ';
            $status = 0;
        }

        # validate type
        if ($account_type > 2 or $account_type < 0) {
//            return 'Loại tài khoản không hợp lệ';
            $error = 'Loại tài khoản không hợp lệ';
            $status = 0;
        };

        try {
            $credentials = [
                'username'    => $username,
                'password' => '12345678',
                'name' => $name,
                'type' => $account_type,
                'gender' => $gender,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
            ];

            $user = Sentinel::registerAndActivate($credentials);
        } catch (QueryException $e) {
            return response()
                ->json(['status' => 0, 'msg' => 'Trùng tên tài khoản, số điện thoại hoặc email']);
        }
        return response()
            ->json(['status' => $status, 'msg' => $error]);
//        return redirect()->route('index');
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
            })
            ->select('*');
        // ->get();
        // dd($users);
        return Datatables::of($users)->make(true);
    }

    function lockUser(Request $request) {
//        dd($request);
        $list_id = explode(",", $request->input('selected_id'));
        foreach ($list_id as $user_id) {
            $user = Sentinel::findById($user_id);
            $credentials = [
                'is_active' => 0
            ];
            $user = Sentinel::update($user, $credentials);
        }
        return response()
            ->json(['status' => 1, 'msg' => '']);
    }

    function unlockUser(Request $request) {
        $list_id = explode(",", $request->input('selected_id'));
        foreach ($list_id as $user_id) {
            $user = Sentinel::findById($user_id);
            $credentials = [
                'is_active' => 1
            ];
            $user = Sentinel::update($user, $credentials);
        }
        return response()
            ->json(['status' => 1, 'msg' => '']);
    }

    function resetPassword(Request $request) {
        $list_id = explode(",", $request->input('selected_id'));
        foreach ($list_id as $user_id) {
            $user = Sentinel::findById($user_id);
            $credentials = [
                'password' => '12345678'
            ];
            $user = Sentinel::update($user, $credentials);
        }
        return response()
            ->json(['status' => 1, 'msg' => '']);
    }

    function deleteUser(Request $request) {
        $list_id = explode(",", $request->input('selected_id'));
        foreach ($list_id as $user_id) {
            $user = Sentinel::findById($user_id);
            $user->delete();
        }
        return response()
            ->json(['status' => 1, 'msg' => '']);
    }
}
