@extends('layouts.master')
@section('css')
    <!--calendar css-->
    <link href="vendor/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <br>
                    <br>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="widget-panel widget-style-2 bg-white">
                        <i class="md md-rate-review text-pink"></i>
                        <h2 class="m-0 text-dark counter font-600">{{$complete_survey}}</h2>
                        <div class="text-muted m-t-5">Khảo sát hoàn thành</div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="widget-panel widget-style-2 bg-white">
                        <i class="md md-subject text-info"></i>
                        <h2 class="m-0 text-dark counter font-600">{{$subject}}</h2>
                        <div class="text-muted m-t-5">Môn học</div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="widget-panel widget-style-2 bg-white">
                        <i class="md md-account-child text-primary"></i>
                        <h2 class="m-0 text-dark counter font-600">{{$lecturer}}</h2>
                        <div class="text-muted m-t-5">Giảng viên</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="widget-panel widget-style-2 bg-white">
                        <i class="md md-rate-review text-primary"></i>
                        <h2 class="m-0 text-dark counter font-600">{{$survey}}</h2>
                        <div class="text-muted m-t-5"> Tổng số khảo sát</div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="widget-panel widget-style-2 bg-white">
                        <i class="md md-subject text-custom"></i>
                        <h2 class="m-0 text-dark counter font-600">{{$classes}}</h2>
                        <div class="text-muted m-t-5">Lớp môn học</div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="widget-panel widget-style-2 bg-white">
                        <i class="md md-account-child text-pink"></i>
                        <h2 class="m-0 text-dark counter font-600">{{$student}}</h2>
                        <div class="text-muted m-t-5">Sinh viên</div>
                    </div>
                </div>

                {{--<div class="col-lg-3 col-sm-6">--}}
                    {{--<div class="widget-panel widget-style-2 bg-white">--}}
                        {{--<i class="md md-store-mall-directory text-info"></i>--}}
                        {{--<h2 class="m-0 text-dark counter font-600">18</h2>--}}
                        {{--<div class="text-muted m-t-5">Môn học</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-3 col-sm-6">--}}
                    {{--<div class="widget-panel widget-style-2 bg-white">--}}
                        {{--<i class="md md-account-child text-custom"></i>--}}
                        {{--<h2 class="m-0 text-dark counter font-600">8564</h2>--}}
                        {{--<div class="text-muted m-t-5">Lớp môn học</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
@endsection
@section('script')
    <script src="vendor/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- BEGIN PAGE SCRIPTS -->
    <script src="vendor/assets/plugins/moment/moment.js"></script>
    <script src='vendor/assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
    <script src="vendor/assets/pages/jquery.fullcalendar.js"></script>
@endsection
