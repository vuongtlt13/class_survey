@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="/css/student.css" type="text/css">
@endsection
@section('content')
    <div class="content">
        <div class="container">
            <div class="col-sm-offset-1 col-sm-10 primary_content">
                <!-- header -->
                <div class="row">
                    <h2 style="color: #0D47A1;">Danh sách môn học</h2>
                    <br>
                </div>
                <!-- body -->
                @foreach($classes as $class)
                    <!-- a subject -->
                    <div class="item_subject col-sm-8">
                        <div class="col-sm-9">
                            <a href="{{route('student-survey', $class->id)}}"><h3 class="subject_name">{{$class->subject->name}}</h3>
                            </a>
                        </div>
                        <div class="col-sm-3" style="text-align: right;">
                            @if($class->is_done == 0)
                                <span class="label label-danger"> Chưa đánh giá</span>
                            @else
                                <span class="label label-success"> Hoàn thành</span>
                            @endif
                        </div>
                    </div>
                    <br>
                @endforeach
            </div>
            <br>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="vendor/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- BEGIN PAGE SCRIPTS -->
    <script src="vendor/assets/plugins/moment/moment.js"></script>
    <script src='vendor/assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
    <script src="vendor/assets/pages/jquery.fullcalendar.js"></script>
@endsection
