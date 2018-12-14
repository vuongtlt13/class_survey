<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
use App\Lecturer;
use App\Student;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
        switch ($user->type) {
            case 0:
                if ($user->student != null) {
                    $user->student()->delete();
                }
                break;
            case 1:
                if ($user->lecturer != null) {
                    $user->lecturer()->delete();
                }
                break;
            case 2:
                break;
            default:
                return response()
                    ->json(['status' => 0, 'msg' => 'Loại tài khoản không hợp lệ']);
                break;
        }
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
            switch ($user->type) {
                case 0:
                    if ($user->student === null) {
                        $student = new Student([]);
                        $user->student()->save($student);
                    }
                    break;
                case 1:
                    if ($user->lecturer === null) {
                        $lecturer = new Lecturer([]);
                        $user->lecturer()->save($lecturer);
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
            return response()
                ->json(['status' => 0, 'msg' => 'Trùng tên tài khoản, số điện thoại hoặc email']);
        }
        return response()
            ->json(['status' => $status, 'msg' => $error]);
    }

    function createUser(Request $request) {
        $username = $request->input('username');
        $name = $request->input('name');
        $account_type = $request->input('account_type');
        $gender = $request->input('gender');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');

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
//        return dd($credentials);
        return UserController::create_user($credentials, []);
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

    function importStudent(Request $request) {
//        dd($request);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->storeAs('tmp', $file->getClientOriginalName());
//            dd($path);
            $reader = IOFactory::createReaderForFile($path);
            $reader->setReadDataOnly(true);
            $reader->load($path);
            Storage::delete($path);
        }
        return response()
            ->json(['status' => 0, 'msg' => 'File không tồn tại!']);
    }
}
