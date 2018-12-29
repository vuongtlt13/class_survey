<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Lecturer;
use App\Subject;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    function classResult($class_id){
        $class = Classes::find($class_id);
        if ($class === null) {
            return "Lớp môn học không tồn tại!";
        }
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
where is_done = 1 and lecturer_id = " . Sentinel::check()->id . "
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
where is_done = 1 and lecturer_id = " . Sentinel::check()->id . "
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
            'questions' => $questions]);
    }

    function subjectResult($subject_code){
        $subject = Subject::where('code', $subject_code)->first();
        if ($subject === null) {
            return "Môn học không tồn tại!";
        }
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

        $student = (clone $query)->count('class_student.id');

        $student_done = (clone $query)->where('class_student.is_done', '1')->count('class_student.id');

        $raw_query = "DROP TEMPORARY TABLE IF EXISTS tmp_table;";
        DB::statement($raw_query);
        $raw_query = "CREATE TEMPORARY TABLE tmp_table 
 select question_id, lecturer_id, is_done, score, subject_code
 from `classes` 
 left join `class_student` 
	on `classes`.`id` = `class_student`.`class_id` 
left join `class_student_question` 
	on `class_student`.`id` = `class_student_question`.`class_student_id` 
where `classes`.`term` = " . $term . " 
	and `classes`.`school_year` = '" . $school_year . "';";
        DB::statement($raw_query);
        $raw_query = "CREATE TEMPORARY TABLE MandSTD 
select question_id, avg(score) as M, STD(score) as STD
from tmp_table
where `subject_code` = '" . $subject_code . "' and is_done = 1 and lecturer_id = " . Sentinel::check()->id . "
group by question_id order by question_id asc;";
        DB::statement($raw_query);
        $raw_query = "CREATE TEMPORARY TABLE M1andSTD1
select question_id, avg(score) as M1, STD(score) as STD1
from tmp_table 
where `subject_code` = '" . $subject_code . "' and is_done = 1 
group by question_id order by question_id asc;";
        DB::statement($raw_query);
        $raw_query = "CREATE TEMPORARY TABLE M2andSTD2
select question_id, avg(score) as M2, STD(score) as STD2
from tmp_table 
where is_done = 1 and lecturer_id = " . Sentinel::check()->id . "
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
        return view('lecturer.subject_result', [
            'subject_name'=> $subject->name,
            'student_done' => $student_done,
            'student' => $student,
            'lecturer' => $lecturer,
            'questions' => $questions]);
    }

    function viewClass() {
        $user = Sentinel::check();
        $year = date('Y');
        $month = date("m");
        $term = 0;
        $school_year = $year . '-' . ($year + 1);
//        dd($year, $month);
        if ($month >= 1 and $month <= 6) {
            $term = 1;
        }
        $classes = Lecturer::find($user->id)
            ->classes()
            ->where('classes.term', $term)
            ->where('classes.school_year', $school_year)
            ->leftJoin('subjects', 'subjects.code', 'classes.subject_code')
            ->orderByRaw('subjects.name')
            ->get();
//        dd($classes);
        return view('lecturer.view_by_class', ['classes' => $classes]);
    }
}
