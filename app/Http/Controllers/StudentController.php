<?php

namespace App\Http\Controllers;

use App\Classes;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class StudentController extends Controller
{
    function my_cmp($a, $b){
//        dd($b['title']['content'], $a['title']['content'], strcasecmp($b['title']['content'], $a['title']['content']));
        return strcasecmp($b['title']['content'], $a['title']['content']);
    }

    function survey($class_id) {
//        dd($class_id);
        $user = Sentinel::check();
        $class = Classes::find($class_id);
        if ($class == null) {
            return 'Lớp học không tồn tại';
        }
//        dd($class);
        $template = $class->template;
        if ($template == null) {
            return 'Mẫu khảo sát không tồn tại';
        }

        $class_student = $class->class_students()->where('class_student.student_id', $user->id)->get();
//        dd(count($class_student));
        if (count($class_student) == 0) {
            return 'Không tìm thấy sinh viên trong lớp!';
        }
        $class_student = $class_student[0];
        $questions = $class_student->questions()->with(['title'])->get()->toArray();
//        dd($questions);
        usort($questions, array($this, "my_cmp"));

//        dd($questions);
//        dd(count($questions));
        return view('student.survey', [
            'questions' => $questions,
            'class_id' => $class->id,
            'class_name' => $class->subject->name]);
    }
}
