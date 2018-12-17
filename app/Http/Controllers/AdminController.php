<?php

namespace App\Http\Controllers;

use App\Lecturer;
use App\Student;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
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
        ini_set('max_execution_time', 300); //3 minutes
//        dd($request);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->storeAs('tmp', $file->getClientOriginalName());
//            dd($path);
            $path_full= Storage::disk('local')->path($path);
//            dd($path_full);
            list($status, $error) = $this->import_student($path_full);
            Storage::delete($path);
            return response()
                ->json(['status' => $status, 'msg' => $error]);
        }
        return response()
            ->json(['status' => 0, 'msg' => 'File không tồn tại!']);
    }

    function importLecturer(Request $request) {
        ini_set('max_execution_time', 300); //3 minutes
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->storeAs('tmp', $file->getClientOriginalName());
//            dd($path);
            $path_full= Storage::disk('local')->path($path);
//            dd($path_full);
            list($status, $error) = $this->import_lecturer($path_full);
            Storage::delete($path);
            return response()
                ->json(['status' => $status, 'msg' => $error]);
        }
        return response()
            ->json(['status' => 0, 'msg' => 'File không tồn tại!']);
    }

    function import_student($file) {
        $no_success = 0;
        $no_error = 0;
        $data=Excel::load($file, function($reader) {})->get();
//        $count=count($data);
//        dd($count);
        //looping out data of excel rows
        foreach ($data as $key => $value) {
//            echo $key . ':' . $value . PHP_EOL;
//            dd($value);
            # extract a row
            $row = [];
            foreach ($value as $col => $val) {
//                echo $val . PHP_EOL;
                array_push($row, $val);
            }
            # import
//            dd(str_replace('\n','',$row[1]));
            $username = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim(((string)$row[1])));
            $password = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($row[2]));
            $name = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($row[3]));
            $email = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($row[4]));
            $major = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($row[5]));

            if ($username == null) continue;
            $credentials = [
                'username'    => $username,
                'password' => $password,
                'name' => $name,
                'type' => 0,
                'gender' => null,
                'email' => $email,
                'phone' => null,
                'address' => null,
            ];
            $other_infor = ['major' => $major];

            list($sta, $err) = UserController::validateUser($credentials);
            if ($sta == 1) {
                try {
                    $user = Sentinel::registerAndActivate($credentials);
                    $user->student()->update($other_infor);
                    $no_success++;
                } catch (QueryException $e) {
//                    dd($e);
                    $no_error++;
                    continue;
                }
            } else {
                $no_error++;
            }
        }
        if ($no_error == 0) {
            $status = 1;
            $error = $no_success . " tài khoản đã import thành công!";
        } else {
            if ($no_success == 0) {
                $status = 0;
                $error = "Import không thành công!";
            } else {
                $status = 2;
                $error = $no_success . " thành công, " . $no_error . " thất bại!";
            }
        }
        return array($status, $error);
    }

    function import_lecturer($file) {
        $no_success = 0;
        $no_error = 0;
        $data=Excel::load($file, function($reader) {})->get();
        //looping out data of excel rows
        foreach ($data as $key => $value) {
            # extract a row
            $row = [];
            foreach ($value as $col => $val) {
//                echo $val . PHP_EOL;
                array_push($row, $val);
            }
            # import
            $username = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim(((string)$row[1])));
            $password = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($row[2]));
            $name = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($row[3]));
            $email = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($row[4]));

            $code = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($row[5]));

            if ($username == null) continue;
            $credentials = [
                'username'    => $username,
                'password' => $password,
                'name' => $name,
                'type' => 1,
                'gender' => null,
                'email' => $email,
                'phone' => null,
                'address' => null,
            ];
            $other_infor = ['code' => $code];

            list($sta, $err) = UserController::validateUser($credentials);
            if ($sta == 1) {
                try {
                    $user = Sentinel::registerAndActivate($credentials);
                    $user->lecturer()->update($other_infor);
                    $no_success++;
                } catch (QueryException $e) {
//                    dd($e);
                    $no_error++;
                    continue;
                }
            } else {
                $no_error++;
            }
        }
        if ($no_error == 0) {
            $status = 1;
            $error = $no_success . " tài khoản đã import thành công!";
        } else {
            if ($no_success == 0) {
                $status = 0;
                $error = "Import không thành công!";
            } else {
                $status = 2;
                $error = $no_success . " thành công, " . $no_error . " thất bại!";
            }
        }
        return array($status, $error);
    }
}
