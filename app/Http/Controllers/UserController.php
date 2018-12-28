<?php

namespace App\Http\Controllers;

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    static function create_admin($username, $password, $is_active) {
        $credentials = [
            'username' => $username,
            'password' => $password,
            'is_active' => $is_active,
            'type' => 2,
        ];

        UserController::create_user($credentials, []);
        return true;
    }

    function profile() {
      $user = Sentinel::check();
        return view('profile', ['userInfo' => $user]);
    }

    static function validateUser($credentials) {
        $status = 1;
        $error = "";
        # validate username
        if (array_key_exists('username', $credentials) && !preg_match('/^\w{4,20}$/', $credentials['username'])) {
//            return 'Tên đăng nhập không hợp lệ';
            $error = 'Tên đăng nhập không hợp lệ';
//            $error = $credentials['username'];
            $status = 0;
        }

        # validate phone
        if (array_key_exists('phone', $credentials) && $credentials['phone'] != null && (!preg_match('/^[0-9]{10}$/', $credentials['phone']))) {
//            return 'Số điện thoại không hợp lệ';
            $error = 'Số điện thoại không hợp lệ';
            $status = 0;
        }

        # validate email
        if (array_key_exists('email', $credentials) && $credentials['email'] != null
            && (!preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $credentials['email']))) {
//            return 'Email không hợp lệ';
            $error = 'Email không hợp lệ';
            $status = 0;
        }

        # validate type
        if (array_key_exists('type', $credentials) && ($credentials['type'] > 2 or $credentials['type'] < 0)) {
//            return 'Loại tài khoản không hợp lệ';
            $error = 'Loại tài khoản không hợp lệ';
            $status = 0;
        };
        return array($status, $error);
    }

    static function create_user($credentials, $other_infor) {
//        dd($credentials, $other_infor);
        list($status, $error) = UserController::validateUser($credentials);
        if ($credentials['type'] == 1) {
            # validate phone
            if (array_key_exists('code', $other_infor) && $other_infor['code'] != null && (!preg_match('/^[0-9]{7,9}$/', $other_infor['code']))) {
//            return 'Số điện thoại không hợp lệ';
                $error = 'Mã giảng viên không hợp lệ';
                $status = 0;
            }
        }
        if ($status == 1) {
            try {
                $user = Sentinel::registerAndActivate($credentials);
                switch ($user->type) {
                    case 0:
                        if (sizeof($other_infor) > 0) {
                            $user->student()->update($other_infor);
                        }
                        break;
                    case 1:
                        if (sizeof($other_infor) > 0) {
                            $user->lecturer()->update($other_infor);
                        }
                        break;
                    case 2:
                        break;
                    default:
                        return response()
                            ->json(['status' => 0, 'msg' => 'Loại tài khoản không hợp lệ']);
                        break;
                }
            } catch (QueryException $e) {
//                dd($e);
                return response()
                    ->json(['status' => 0, 'msg' => 'Trùng tên tài khoản, số điện thoại hoặc email']);
            }
        }
        return response()
            ->json(['status' => $status, 'msg' => $error]);
//        return redirect()->route('index');
    }

    function updateProfile(Request $request) {
//        dd($request);
        $user = User::find($request->input('user_id'));

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = $request->input('password');
        if ($password != null and $password != "") {
            $user->password = bcrypt($password);
        }
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->gender = $request->input('gender');
        $user->save();
        return redirect()->route('profile');
    }
}
