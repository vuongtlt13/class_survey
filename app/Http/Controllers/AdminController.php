<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Lecturer;
use App\Question;
use App\Student;
use App\Subject;
use App\Title;
use function Complex\add;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use function Sodium\crypto_pwhash_scryptsalsa208sha256_str;
use Yajra\Datatables\Datatables;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;


class AdminController extends Controller
{
    public static function index() {
        $year = date('Y');
        $month = date("m");
        $term = 0;
        $school_year = $year . '-' . ($year + 1);
//        dd($year, $month);
        if ($month >= 1 and $month <= 6) {
            $term = 1;
        }

        $query = Classes::where('classes.term', $term)
            ->where('classes.school_year', $school_year);

        $classes = (clone $query)->count('classes.id');

        $subject = (clone $query)
                ->leftJoin('subjects', 'subjects.code', 'classes.subject_code')
                ->groupBy('subject_code')
                ->select('subject_code')
                ->get()->count();
//                ->count();
//        dd($subject);
        $query = $query->where('template_id', '<>', null)
            ->leftJoin('class_student', 'classes.id', 'class_student.class_id');

        $survey = (clone $query)->count('class_student.id');

        $complete_survey = (clone $query)->where('class_student.is_done', 1)->count('class_student.id');

        $lecturer = Lecturer::all()->count();
        $student = Student::all()->count();

        return view('admin.index', [
            'survey' => $survey,
            'complete_survey' => $complete_survey,
            'subject' => $subject,
            'classes' => $classes,
            'lecturer' => $lecturer,
            'student' => $student,
        ]);
    }

    function userManager() {
        return view('admin.user');
    }

    function surveyManager() {
        return view('admin.survey');
    }

    function surveyTemplateManager() {
        return view('admin.survey-template');
    }

    function questionManager() {
        return view('admin.question');
    }

    function updateUser(Request $request) {
//        dd($request);
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
        $code = null;
        $code = $request->input('code');
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

        if ($account_type == 1) {
            # validate phone
            if ($code == null || !preg_match('/^[0-9]{7,9}$/', $code)) {
//            return 'Số điện thoại không hợp lệ';
                $error = 'Mã giảng viên không hợp lệ!';
                $status = 0;
            }
        }

        $user = Sentinel::findById($user_id);
//        dd($user);
//        dd($user->lecturer);
//        var_dump($user->lecturer === null);
        if ($user->type != $account_type) {
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
                        ->json(['status' => 0, 'msg' => 'Loại tài khoản không hợp lệ!']);
                    break;
            }
        }

        // update info
        $user->name = $name;
        $user->type = $account_type;
        $user->gender = $gender;
        $user->phone = $phone;
        $user->address = $address;
        $user->email = $email;
        $user->save();

        switch ($user->type) {
            case 0:
                if ($user->student === null) {
                    $student = new Student();
                    $user->student()->save($student);
                }
                break;
            case 1:
                if ($user->lecturer === null) {
                    $lecturer = new Lecturer(['code' => $code]);
                    $user->lecturer()->save($lecturer);
                } else {
                    $user->lecturer()->update(['code'=> $code]);
                }
                break;
            case 2:
                break;
            default:
                return response()
                    ->json(['status' => 0, 'msg' => 'Loại tài khoản không hợp lệ!']);
                break;
        }
//        var_dump($user->lecturer === null);
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
        $code = null;
        if ($account_type == 1) {
            $code = $request->input('code');
        }

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
        $other_info = ['code' => $code];
//        return dd($credentials);
        return UserController::create_user($credentials, $other_info);
    }

    function searchUser(Request $request) {
//         dd($request);
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
            })->with('lecturer', 'student')
            ->orWhereHas('lecturer', function ($query) use ($word) {
                $query->where('code', 'like', '%' . $word . '%');
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
            ->json(['status' => 1, 'msg' => 'Khóa tài khoản thành công!']);
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
            ->json(['status' => 1, 'msg' => 'Mở khóa tài khoản thành công!']);
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
            ->json(['status' => 1, 'msg' => 'Reset mật khẩu thành công!']);
    }

    function deleteUser(Request $request) {
        $list_id = explode(",", $request->input('selected_id'));
        foreach ($list_id as $user_id) {
            $user = Sentinel::findById($user_id);
            if ($user != null) $user->delete();
        }
        return response()
            ->json(['status' => 1, 'msg' => 'Xóa tài khoản thành công!']);
    }

    function importStudent(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');
        $name = $request->input('name');
        $email = $request->input('email');
        $khoahoc = $request->input('khoahoc');

        $username = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($username));
        $password = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($password));
        $name = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($name));
        $email = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($email));
        $khoahoc = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($khoahoc));

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
        $other_infor = ['khoahoc' => $khoahoc];
//        return dd($credentials);
        return UserController::create_user($credentials, $other_infor);
    }

    function importLecturer(Request $request) {
//        dd($request);
        $username = $request->input('username');
        $password = $request->input('password');
        $name = $request->input('name');
        $email = $request->input('email');
        $code = $request->input('code');

        $username = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($username));
        $password = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($password));
        $name = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($name));
        $email = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($email));
        $code = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', trim($code));


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
//        return dd($credentials->username);
        return UserController::create_user($credentials, $other_infor);
    }

    function createTitle(Request $request) {
//        dd($request);
        $content = $request->input('title');
        list($status, $error) = QuestionController::createTitle($content);
//        dd($status, $error);
        return response()
            ->json(['status' => $status, 'msg' => $error]);
    }

    function updateTitle(Request $request) {
//        dd($request);
        $title_id = $request->input('id');
        $content = $request->input('title');
        list($status, $error) = QuestionController::updateTitle($title_id, $content);
//        dd($status, $error);
        return response()
            ->json(['status' => $status, 'msg' => $error]);
    }

    function deleteTitle(Request $request) {
//        dd($request);
        $list_id = explode(",", $request->input('selected_id'));
        foreach ($list_id as $title_id) {
            $title = Title::find($title_id);
            if ($title != null) $title->delete();
        }
        return response()
            ->json(['status' => 1, 'msg' => '']);
    }

    function createQuestion(Request $request) {
//        dd($request);
        $title_id = $request->input('title_id');
        $content = $request->input('question');
        list($status, $error) = QuestionController::createQuestion($title_id, $content);
//        dd($status, $error);
        return response()
            ->json(['status' => $status, 'msg' => $error]);
    }

    function updateQuestion(Request $request) {
//        dd($request);
        $question_id = $request->input('id');
        $title_id = $request->input('title_id');
        $content = $request->input('question');
        list($status, $error) = QuestionController::updateQuestion($question_id, $title_id, $content);
//        dd($status, $error);
        return response()
            ->json(['status' => $status, 'msg' => $error]);
    }

    function deleteQuestion(Request $request) {
//        dd($request);
        $list_id = explode(",", $request->input('selected_id'));
        foreach ($list_id as $question_id) {
            $question = Question::find($question_id);
            if ($question != null) $question->delete();
        }
        return response()
            ->json(['status' => 1, 'msg' => '']);
    }

    function searchClass(Request $request) {
//        dd($request);
        $word = $request->input('word');
        if ($word == null) {
            $word = '';
        }
        $year = date('Y');
        $month = date("m");
        $term = 0;
        $school_year = $year . '-' . ($year + 1);
//        dd($year, $month);
        if ($month >= 1 and $month <= 6) {
            $term = 1;
        }

        $classes = Classes::with(['subject'])
                    ->where('term', $term)
                    ->where('school_year', $school_year)
                    ->whereHas('subject', function ($query) use ($word) {
                        $query->where('code', 'like', '%' . $word . '%')
                            ->orWhere('name', 'like', '%' . $word . '%');
                    });
//        dd($term, $school_year);
//        return response()->json($classes->get());
        return DataTables::of($classes)->make(true);
    }

    function deleteAllUser() {
        $users = User::where('type', '<>', 2)->get();
        foreach ($users as $user) {
            $user->delete();
        }
        return response()
            ->json(['status' => 1, 'msg' => 'Xóa tất cả tài khoản thành công!']);
    }

    function viewClass() {
        $year = date('Y');
        $month = date("m");
        $term = 0;
        $school_year = $year . '-' . ($year + 1);
//        dd($year, $month);
        if ($month >= 1 and $month <= 6) {
            $term = 1;
        }

        $classes = Classes::where('classes.term', $term)
            ->where('classes.school_year', $school_year)
            ->leftJoin('subjects', 'subjects.code', 'classes.subject_code')
            ->orderByRaw('subjects.name')
            ->get();
//        dd($classes);
        return view('admin.view_by_class', ['classes' => $classes]);
    }

    function classResult($class_id){
        $class = Classes::find($class_id);
        if ($class === null) {
            return "Lớp môn học không tồn tại!";
        }
        $lecturer_name = User::find($class->lecturer_id)->name;

        $subject_code = Classes::find($class_id)->subject_code;
//        dd($subject_code);
        $subject = Subject::where('code', $subject_code)->first();

        $year = date('Y');
        $month = date("m");
        $term = 0;
        $school_year = $year . '-' . ($year + 1);
//        dd($year, $month);
        if ($month >= 1 and $month <= 6) {
            $term = 1;
        }

        $query = Classes::where('subject_code', $subject_code)
            ->where('classes.term', $term)
            ->where('classes.school_year', $school_year);

        $lecturer = (clone $query)->select('classes.id', 'classes.lecturer_id')->groupBy('classes.lecturer_id')->select('classes.lecturer_id')->count('classes.lecturer_id');
//        dd($lecturer);
        $query = $query->select('classes.id', 'classes.lecturer_id')->leftJoin('class_student', 'classes.id', 'class_student.class_id');

        $student = (clone $query)->where('classes.id', $class_id)->count('class_student.id');

        $student_done = (clone $query)->where('classes.id', $class_id)->where('class_student.is_done', '1')->count('class_student.id');

        $raw_query = "DROP TEMPORARY TABLE IF EXISTS tmp_table;";
        DB::statement($raw_query);
        $raw_query = "CREATE TEMPORARY TABLE tmp_table
 select question_id, lecturer_id, is_done, score
 from `classes`
 left join `class_student`
	on `classes`.`id` = `class_student`.`class_id`
left join `class_student_question`
	on `class_student`.`id` = `class_student_question`.`class_student_id`
where `subject_code` = '" . $subject_code . "'
	and `classes`.`term` = " . $term . "
	and `classes`.`school_year` = '" . $school_year . "';";
        DB::statement($raw_query);
        $raw_query = "CREATE TEMPORARY TABLE MandSTD
select question_id, avg(score) as M, STD(score) as STD
from tmp_table
where is_done = 1 and lecturer_id = " . $class->lecturer_id . "
group by question_id order by question_id asc;";
        DB::statement($raw_query);
        $raw_query = "CREATE TEMPORARY TABLE M1andSTD1
select question_id, avg(score) as M1, STD(score) as STD1
from tmp_table
where is_done = 1
group by question_id order by question_id asc;";
        DB::statement($raw_query);
        $raw_query = "CREATE TEMPORARY TABLE M2andSTD2
select question_id, avg(score) as M2, STD(score) as STD2
from tmp_table
where is_done = 1 and lecturer_id = " . $class->lecturer_id . "
group by question_id order by question_id asc;";
        DB::statement($raw_query);
        $raw_query = "select MandSTD.question_id, questions.content, M, `STD`, M1, STD1, M2, STD2
from MandSTD
left join M1andSTD1
	on MandSTD.question_id = M1andSTD1.question_id
left join M2andSTD2
	on MandSTD.question_id = M2andSTD2.question_id
left join questions
	on questions.id = MandSTD.question_id;";
        $questions = DB::select($raw_query);
        $raw_query = "DROP TEMPORARY TABLE tmp_table,MandSTD,M1andSTD1,M2andSTD2;";
        DB::statement($raw_query);
//        dd($questions);

        return view('lecturer.class_result', [
            'subject_name'=> $subject->name,
            'student_done' => $student_done,
            'student' => $student,
            'lecturer' => $lecturer,
            'questions' => $questions,
            'lecturer_name' => $lecturer_name]);
    }
}
