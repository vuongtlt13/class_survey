<?php

namespace App\Http\Controllers;

use App\Question;
use App\Template;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;
use Yajra\DataTables\Facades\DataTables;

class SurveyController extends Controller
{
    function result() {
      return view('view_result');
    }

    function getTemplate() {
        $templates = Template::all();
        return Datatables::of($templates)->make(true);
    }

    function getAllTemplate() {
        $templates = Template::all();
        return response()
            ->json($templates);
    }

    function createTemplate(Request $request) {
        $name = $request->input('template');

        try {
            $template = new Template();
            $template->name = $name;
            $template->is_default = 0;
            $template->save();
            return response()
                ->json(['status' => 1, 'msg' => 'Thêm mẫu khảo sát thành công!']);
        } catch (QueryException $e) {
            return response()
                ->json(['status' => 0, 'msg' => $e]);
        }
    }

    function updateTemplate(Request $request) {
        $id = $request->input('id');
        $name = $request->input('template');

        try {
            $template = Template::find($id);
            $template->name = $name;
            $template->save();
            return response()
                ->json(['status' => 1, 'msg' => 'Thêm mẫu khảo sát thành công!']);
        } catch (QueryException $e) {
            return response()
                ->json(['status' => 0, 'msg' => $e]);
        }
    }

    function setDefaultTemplate(Request $request) {
        $id = $request->input('id');

        # remove last default
        $templates = Template::where('is_default', 1)->get();
        foreach ($templates as $template) {
            try {
                $template->is_default = 0;
                $template->save();
            } catch (QueryException $e) {
                continue;
            }
        }

        try {
            # make new default
            $template = Template::find($id);
            $template->is_default = 1;
            $template->save();
            return response()
                ->json(['status' => 1, 'msg' => 'Đặt mặc định mẫu khảo sát thành công!']);
        } catch (QueryException $e) {
            return response()
                ->json(['status' => 0, 'msg' => $e]);
        }
    }

    function deleteTemplate(Request $request) {
       // dd($request);
        $list_id = explode(",", $request->input('selected_id'));
        foreach ($list_id as $template_id) {
            $template = Template::find($template_id);
            if ($template != null) $template->delete();
        }
        return response()
            ->json(['status' => 1, 'msg' => '']);
    }

    function my_cmp($a, $b){
//        dd($b['title']['content'], $a['title']['content'], strcasecmp($b['title']['content'], $a['title']['content']));
        return strcasecmp($b['title']['content'], $a['title']['content']);
    }

    function loadTemplate(Request $request) {
        $template_id = $request->input('id');
        $template = Template::find($template_id);
        if ($template == null) return response()
            ->json(['status' => 0, 'msg' => 'Không tìm thấy mẫu khảo sát']);

        $questions = ($template->questions()->with(['title'])->get())->toArray();

        usort($questions, array($this, "my_cmp"));
        return response()->json($questions);
    }

    function removeQuestion(Request $request) {
        $template_id = $request->input('template_id');
        $question_id = $request->input('question_id');
        $template = Template::find($template_id);
        if ($template != null) {
            try {
                $template->questions()->detach($question_id);
                return response()
                    ->json(['status' => 1, 'msg' => 'Xóa thành công!']);
            } catch (QueryException $e) {
                return response()
                    ->json(['status' => 0, 'msg' => $e]);
            }
        }
        return response()
            ->json(['status' => 0, 'msg' => 'Không tồn tại mẫu khảo sát!']);
    }

    function loadQuestion(Request $request) {
        $template_id = $request->input('id');
        $questions = Question::whereDoesntHave('templates', function ($query) use ($template_id) {
            $query->where('templates.id', $template_id);
        })->with(['title'])->get()->toArray();

        usort($questions, array($this, "my_cmp"));
        return response()
            ->json($questions);
    }

    function addQuestion(Request $request) {
//        dd($request);
        $template_id = $request->input('template_id');
        $selected_questions = $request->input('selected_questions');
        $template = Template::find($template_id);
        if ($template != null) {
            try {
                foreach ($selected_questions as $question_id) {
                    $template->questions()->attach($question_id);
                }
                return response()
                    ->json(['status' => 1, 'msg' => 'Thêm câu hỏi vào mẫu khảo sát thành công!']);
            } catch (QueryException $e) {
                return response()
                    ->json(['status' => 0, 'msg' => $e]);
            }
        }
        return response()
            ->json(['status' => 0, 'msg' => 'Không tồn tại mẫu khảo sát!']);
    }
}
