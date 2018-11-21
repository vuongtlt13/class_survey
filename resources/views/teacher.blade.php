@extends('layouts.master')
@section('css')
        <!--calendar css-->
        <link href="vendor/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/css/student.css" type="text/css">
@endsection
@section('content')
        <div class="content">
          <div class="container">
            <h2>Danh sách lớp môn học</h2>
            <br>
            <div class="item_subject col-sm-8">
              <div class="subject_name col-sm-10">
                <h4>Phát triển ứng dụng</h4>
              </div>
              <div class="col-sm-2 btn_option">
                <button class="btn btn-primary" type="button" name="danh_gia_survey" onclick="window.location='{{ url("survey") }}'">Kết quả đánh giá</button>
              </div>
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
