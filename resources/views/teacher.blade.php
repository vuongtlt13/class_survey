@extends('layouts.student_teacher.master')
@section('css')
        <!--calendar css-->
        <link href="vendor/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/css/student.css" type="text/css">
@endsection
@section('content')
        <div class="container">
          <div class="col-sm-offset-1 col-sm-10 primary_content">
            <h2 style="color: #0D47A1;">Danh sách lớp môn học</h2>
            <br>
            <div class="item_subject col-sm-8">
              <div class="subject_name col-sm-9">
                <h4>Phát triển ứng dụng Web - INT3306 1</h4>
              </div>
              <div class="col-sm-3 btn_option">
                <button class="btn btn-primary" type="button" name="danh_gia_survey" onclick="window.location='{{ url("result") }}'">Xem Đánh giá</button>
              </div>
            </div>
            <br>

            <div class="item_subject col-sm-8">
              <div class="subject_name col-sm-9">
                <h4>Phát triển ứng dụng Web - INT3306 2</h4>
              </div>
              <div class="col-sm-3 btn_option">
                <button class="btn btn-primary" type="button" name="danh_gia_survey" onclick="window.location='{{ url("result") }}'">Xem Đánh giá</button>
              </div>
            </div>
            <br>

          </div>
        </div> <!-- container -->
@endsection
@section('script')
        <script src="vendor/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

        <!-- BEGIN PAGE SCRIPTS -->
        <script src="vendor/assets/plugins/moment/moment.js"></script>
        <script src='vendor/assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
        <script src="vendor/assets/pages/jquery.fullcalendar.js"></script>
@endsection
