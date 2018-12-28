@extends('layouts.master')
@section('css')
    <style>
        .subject_name{
            text-align: center;
            color: #0D47A1;
        }

        table > tbody > tr, table > tbody > tr > td{
            border-top: 2px solid #e0e0e0;
        }

        table > thead {
            border-bottom: 3px solid #e0e0e0;
        }
    </style>
@endsection
@section('content')
    <div class="content">
        <div class="container">
            <div class="col-sm-offset-1 col-sm-10">
                <h2 id="class-{{$class_id}}" class="subject_name">{{$class_name}}</h2>
                <br>
                <form id="survey-form" method="post" action="">
                    {{csrf_field()}}
                    <div style="display: none">
                        <input type="text" name="class_id" value="{{$class_id}}">
                        <input type="text" name="student_id" value="{{$student_id}}">
                    </div>
                    <div class="card-box survey_content">
                        @for($i = 0; $i < count($questions); $i++)
                            @if ($i == 0 or $questions[$i]['question']['title']['id'] != $questions[$i - 1]['question']['title']['id'])
                                @if ($i > 0)
                                            </tbody>
                                            </table>
                                            <br>
                                        </div>
                                </div>
                                @endif
                                <div class="row single_content">
                                    <div class="" style="padding-left: 10px">
                                        <h4><span style="color: red;">* </span>{{$questions[$i]['question']['title']['content']}}</h4>
                                    </div>
                                    <div class="question_area" style="padding-left: 20px">
                                        <table class="table table-bordered">
                                            <colgroup>
                                                <col style="width:70%">
                                                <col style="width:6%">
                                                <col style="width:6%">
                                                <col style="width:6%">
                                                <col style="width:6%">
                                                <col style="width:6%">
                                            </colgroup><thead>
                                            <tr><th></th>
                                                <th>1</th>
                                                <th>2</th>
                                                <th>3</th>
                                                <th>4</th>
                                                <th>5</th>
                                            </tr></thead>
                                            <tbody>
                                            <tr>
                                                <td class="white-space-normal">{{$questions[$i]['question']['content']}}</td>
                                                @if ($questions[$i]['score'] == 1)
                                                    <td class="white-space-normal"><input type="radio" value="1" checked name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="2" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="3" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="4" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="5" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                @elseif ($questions[$i]['score'] == 2)
                                                    <td class="white-space-normal"><input type="radio" value="1" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="2" checked name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="3" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="4" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="5" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                @elseif ($questions[$i]['score'] == 3)
                                                    <td class="white-space-normal"><input type="radio" value="1" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="2" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="3" checked name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="4" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="5" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                @elseif ($questions[$i]['score'] == 4)
                                                    <td class="white-space-normal"><input type="radio" value="1" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="2" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="3" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="4" checked name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="5" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                @elseif ($questions[$i]['score'] == 5)
                                                    <td class="white-space-normal"><input type="radio" value="1" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="2" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="3" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="4" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    <td class="white-space-normal"><input type="radio" value="5" checked name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                @endif
                                            </tr>
                                            @else
                                                <tr>
                                                    <td class="white-space-normal">{{$questions[$i]['question']['content']}}</td>
                                                    @if ($questions[$i]['score'] == 1)
                                                        <td class="white-space-normal"><input type="radio" value="1" checked name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="2" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="3" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="4" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="5" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    @elseif ($questions[$i]['score'] == 2)
                                                        <td class="white-space-normal"><input type="radio" value="1" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="2" checked name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="3" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="4" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="5" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    @elseif ($questions[$i]['score'] == 3)
                                                        <td class="white-space-normal"><input type="radio" value="1" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="2" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="3" checked name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="4" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="5" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    @elseif ($questions[$i]['score'] == 4)
                                                        <td class="white-space-normal"><input type="radio" value="1" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="2" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="3" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="4" checked name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="5" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    @elseif ($questions[$i]['score'] == 5)
                                                        <td class="white-space-normal"><input type="radio" value="1" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="2" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="3" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="4" name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                        <td class="white-space-normal"><input type="radio" value="5" checked name="rate-{{ $questions[$i]['question']['id'] }}"></td>
                                                    @endif
                                                </tr>
                                            @endif
                                            @endfor
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="">
                                            <h4><span style="color: red;"></span>Ý kiến đóng góp khác</h4>
                                        </div>
                                        <div class="">
                                            <textarea class="col-sm-10" name="note" rows="5">{{$note}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </form>
            </div>
        </div><!-- container -->
    </div>
@endsection
@section('script')
    <script src="/vendor/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- BEGIN PAGE SCRIPTS -->
    <script src="/vendor/assets/plugins/moment/moment.js"></script>
    <script src='/vendor/assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
    <script src="/vendor/assets/pages/jquery.fullcalendar.js"></script>

@endsection
