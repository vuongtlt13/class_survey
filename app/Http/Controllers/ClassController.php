<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Lecturer;
use App\Student;
use App\Subject;
use App\Template;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Worksheet\PageMargins;

class ClassController extends Controller
{
    function importClass(Request $request) {
//        dd($request);
        $lecturer = Lecturer::where('code', (int)$request->input('lecturer_code'))->first();
//        dd($request->input('lecturer_code'));
//        dd($lecturer);
        if ($lecturer == null) {
            return response()
                ->json(['status' => 0, 'msg' => 'Mã giảng viên không tồn tại!']);
//                ->json(['status' => 0, 'msg' => $request->input('lecturer_code')]);
        }
        $subject = Subject::where('code', $request->input('subject_code'))->first();
        if ($subject == null) {
            // create subject if it doesn't exist
            try {
                $subject = new Subject();
                $subject->code = $request->input('subject_code');
                $subject->name = $request->input('subject_name');
                $subject->sotinchi = $request->input('sotinchi');
                $subject->save();
            } catch (QueryException $e) {
                return response()
                    ->json(['status' => 0, 'msg' => 'Không thể tạo được môn học!']);
            }
        }

        $term = $request->input('term');
        if ($term == 'I' or $term == 1) {
            $term = 0;
        } else {
            $term = 1;
        }

        $school_year = $request->input('school_year');

        $class_code = $request->input('class_code');
        $class = Classes::where('school_year', $school_year)
                        ->where('term', $term)
                        ->where('class_code', $class_code)
                        ->first();
        if ($class != null) {
//            return response()->json($class->students);
            $class->students()->detach();
//            return response()
//                ->json(['status' => 0, 'msg' => 'Lớp môn học đã tồn tại!']);
        } else {
            // create new class
            try {
                $class = new Classes();
                $class->class_code = $class_code;
                $class->subject_code = $subject->code;
                $class->lecturer_id = $lecturer->id;
                $class->school_year = $school_year;
                $class->term = $term;
                $class->save();
            } catch (QueryException $e) {
//                return $e;
                return response()
                    ->json(['status' => 0, 'msg' => 'Lớp môn học đã tồn tại!']);
            }
        }
        $students = $request->input('students');
//        dd($students);
        foreach ($students as $student_id) {

            try {
                $student = User::where('username', $student_id)->first();
                if ($student == null) {
                    $class->delete();
                    return response()
                        ->json(['status' => 0, 'msg' => 'Sinh viên không tồn tại!']);
//                    ->json(['status' => 0, 'msg' => $student_id]);
//                continue;
                }
//                dd($student->id);
                $class->students()->attach($student->id);
            } catch (QueryException $e) {
//                return response()
//                    ->json(['status' => 0, 'msg' => $e]);
                continue;
            } catch (\Exception $e) {
                continue;
            }
        }
        return response()
            ->json(['status' => 1, 'msg' => 'Tạo lớp môn học thành công!']);
    }

    function deleteClass(Request $request) {
        //        dd($request);
        $list_id = explode(",", $request->input('selected_id'));
        foreach ($list_id as $class_id) {
            $class = Classes::find($class_id);
            if ($class != null) $class->delete();
        }
        return response()
            ->json(['status' => 1, 'msg' => 'Xóa lớp môn học đã chọn thành công!']);
    }

    function deleteAllClass() {
        $classes = Classes::all();
        foreach ($classes as $class) {
            try {
                $class->delete();
            } catch (QueryException $e) {
                return $e;
                continue;
            } catch (\Exception $e) {
                return $e;
                continue;
            }
        }
        return response()
            ->json(['status' => 1, 'msg' => 'Xóa tất cả lớp môn học thành công!']);
    }

    function change_template($class_id, $template_id) {
        $template = Template::find($template_id);
        $class = Classes::find($class_id);
        if ($class != null) {
            // delete old questions
            $class_students = $class->class_students;
//                dd($class_students);
            foreach ($class_students as $class_student) {
                $class_student->questions()->detach();
            }

            // assign template_id
            $class->template_id = $template->id;
            $class->save();
            // create questions
            $questions = $template->questions;
            foreach ($class_students as $class_student) {
                foreach ($questions as $question) {
                    $class_student->questions()->attach($question->id);
                }
            }
        }
    }

    function changeTemplate(Request $request) {
//        dd($request);
        $list_id = explode(",", $request->input('class_ids'));
        $template_id = $request->input('template');
        $template = Template::find($template_id);
        if ($template == null) {
            return response()
                ->json(['status' => 0, 'msg' => 'Mẫu khảo sát không tồn tại!']);
        }
        try {
            foreach ($list_id as $class_id) {
                $this->change_template($class_id, $template_id);
            }
        } catch (QueryException $e) {
            return response()
                ->json(['status' => 0, 'msg' => $e]);
        }
        return response()
            ->json(['status' => 1, 'msg' => 'Đổi mẫu khảo sát thành công!']);
    }

    function generateClass(Request $request) {
        //        dd($request);

        // get default template
        $template = Template::where('is_default', 1)->first();
        if ($template == null) {
            return response()
                ->json(['status' => 0, 'msg' => 'Không có template mặc định!']);
        }

        $list_id = explode(",", $request->input('selected_id'));
        try {
            foreach ($list_id as $class_id) {
                $this->change_template($class_id, $template->id);
            }
        } catch (QueryException $e) {
            return response()
                ->json(['status' => 0, 'msg' => $e]);
        }
        return response()
            ->json(['status' => 1, 'msg' => 'Generate cuộc khảo sát thành công!']);
    }

    function getAllClass() {
        $year = date('Y');
        $month = date("m");
        $term = 0;
        $school_year = $year . '-' . ($year + 1);
//        dd($year, $month);
        if ($month >= 1 and $month <= 6) {
            $term = 1;
        }

        $classes = Classes::where('term', $term)
            ->where('school_year', $school_year)
            ->select('id')
            ->get()
            ->toArray();
        return response()
            ->json($classes);
    }
}
