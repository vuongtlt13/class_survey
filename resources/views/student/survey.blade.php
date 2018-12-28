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
                <div class="card-box survey_content">
                    @for($i = 0; $i < count($questions); $i++)

                        @if ($i == 0 or $questions[$i]['title']['id'] != $questions[$i - 1]['title']['id'])
                            @if ($i > 0)
                                        </tbody>
                                        </table>
                                        <br>
                                    </div>
                                </div>
                            @endif
                            <div class="row single_content">
                                <div class="" style="padding-left: 10px">
                                    <h4><span style="color: red;">* </span>{{$questions[$i]['title']['content']}}</h4>
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
                                            <td class="white-space-normal" id="{{$questions[$i]['id']}}">{{$questions[$i]['content']}}</td>
                                            <td class="white-space-normal"><input type="radio" name="rate{{ $questions[$i]['id'] }}"></td>
                                            <td class="white-space-normal"><input type="radio" name="rate{{ $questions[$i]['id'] }}"></td>
                                            <td class="white-space-normal"><input type="radio" name="rate{{ $questions[$i]['id'] }}"></td>
                                            <td class="white-space-normal"><input type="radio" name="rate{{ $questions[$i]['id'] }}"></td>
                                            <td class="white-space-normal"><input type="radio" name="rate{{ $questions[$i]['id'] }}"></td>
                                        </tr>
                        @else
                            <tr>
                                <td class="white-space-normal" id="{{$questions[$i]['id']}}">{{$questions[$i]['content']}}</td>
                                <td class="white-space-normal"><input type="radio" name="rate{{ $questions[$i]['id'] }}"></td>
                                <td class="white-space-normal"><input type="radio" name="rate{{ $questions[$i]['id'] }}"></td>
                                <td class="white-space-normal"><input type="radio" name="rate{{ $questions[$i]['id'] }}"></td>
                                <td class="white-space-normal"><input type="radio" name="rate{{ $questions[$i]['id'] }}"></td>
                                <td class="white-space-normal"><input type="radio" name="rate{{ $questions[$i]['id'] }}"></td>
                            </tr>
                        @endif
                        @endfor
                                </tbody>
                            </table>
                            <br>
                            <div class="">
                                <h4><span style="color: red;"></span>Ghi chú</h4>
                            </div>
                            <div class="">
                              <textarea name="note" rows="3" cols="95"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn_submit" style="text-align: center;">
                    <input class="btn btn-primary" type="submit" name="submit" value="Hoàn thành">
                </div>
                <br>
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
