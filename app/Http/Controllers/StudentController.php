<?php

namespace App\Http\Controllers;

use App\Classes;
use App\ClassStudent;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    function my_cmp($a, $b){
//        dd($b['title']['content'], $a['title']['content'], strcasecmp($b['title']['content'], $a['title']['content']));
        return strcasecmp($b['question']['title']['content'], $a['question']['title']['content']);
    }

    function my_cmp1($a, $b){
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
        usort($questions, array($this, "my_cmp1"));

//        dd($questions);
//        dd(count($questions));
        return view('student.survey', [
            'student_id' => $user->id,
            'questions' => $questions,
            'class_id' => $class->id,
            'class_name' => $class->subject->name]);
    }

    function sendSurvey(Request $request) {
//        dd($request);
        $student_id = $request->input('student_id');
        $class_id = $request->input('class_id');
        $class = Classes::find($class_id);
        if ($class == null) {
            return 'Lớp học không tồn tại';
        }

        $class_student = $class->class_students()->where('class_student.student_id', $student_id)->get();
//        dd(count($class_student));
        if (count($class_student) == 0) {
            return 'Không tìm thấy sinh viên trong lớp!';
        }
        $class_student = $class_student[0];
        $questions = $class_student->question_scores;
        foreach ($questions as $question) {
//            dd($question);
            $question->score = (int)$request->input('rate-' . $question->question_id);
//            dd($request->input('rate-' . $question->question_id));
            $question->save();
        }

        $class_student->is_done = 1;
        $class_student->note = $request->input('note');;
        $class_student->save();
        return redirect()->route('index');
    }

    function result($class_student) {
//        dd($class_student);
        $class_student = ClassStudent::where('id', $class_student)->with(['classes.subject'])->get();
//        dd($class_student);
        if (count($class_student) == 0) {
            return 'Không tìm thấy sinh viên trong lớp!';
        }
        $class_student = $class_student[0];
        $questions = $class_student->question_scores()->with(['question.title'])->get()->toArray();
//        dd($questions);
        usort($questions, array($this, "my_cmp"));

//        dd($questions);
//        dd(count($questions));
//        dd($class_student);
        return view('student.view_result', [
            'note' => $class_student->note,
            'student_id' => $class_student->student_id,
            'questions' => $questions,
            'class_id' => $class_student->class_id,
            'class_name' => $class_student->classes->subject->name]);
    }
}
