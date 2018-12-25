<?php

namespace App\Http\Controllers;

use App\Question;
use App\Title;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    function getTitle() {
        $titles = Title::all();
        return Datatables::of($titles)->make(true);
    }

    function loadTitle() {
        $titles = Title::all();
        return $titles;
    }

    function getQuestion() {
        $questions = Question::with(['title'])->get();
//        dd($questions);
        return Datatables::of($questions)->make(true);
    }

    public static function createTitle($content) {
        $status = 1;
        $error = '';
        try {
            $title = new Title();
            $title->content = $content;
            $title->save();
            return array($status, $error);
        } catch (QueryException $e) {
            $status = 0;
            $error = $e;
            return array($status, $error);
        }
    }

    public static function updateTitle($id, $content) {
        $status = 1;
        $error = '';
        try {
            $title = Title::find($id);
            $title->content = $content;
            $title->save();
            return array($status, $error);
        } catch (QueryException $e) {
            $status = 0;
            $error = $e;
            return array($status, $error);
        }
    }

    public static function createQuestion($title_id, $content) {
        $status = 1;
        $error = '';
        try {
            $question = new Question();
            $question->title_id = $title_id;
            $question->content = $content;
            $question->save();
            return array($status, $error);
        } catch (QueryException $e) {
            $status = 0;
            $error = $e;
            return array($status, $error);
        }
    }

    public static function updateQuestion($id, $title_id, $content) {
        $status = 1;
        $error = '';
        try {
            $question = Question::find($id);
            $question->title_id = $title_id;
            $question->content = $content;
            $question->save();
            return array($status, $error);
        } catch (QueryException $e) {
            $status = 0;
            $error = $e;
            return array($status, $error);
        }
    }
}
