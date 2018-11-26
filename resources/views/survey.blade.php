@extends('layouts.student_teacher.master')
@section('css')
        <!--calendar css-->
        <link href="vendor/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/css/survey.css" type="text/css">
@endsection
@section('content')
<div class="container">
  <div class="col-sm-offset-1 col-sm-10">
    <h2 class="subject_name">Phát triển ứng dụng Web</h2>
    <br>
    <div class="survey_content">
      <h4>1. <span style="color: red;">* </span>Cơ sở vật chất</h4>
      <div class="">
        <table class="table" style="width: 100%">
          <thead>
            <th></th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
          </thead>
          <tbody>
            <tr>
              <td>Giảng đường đáp ứng yêu cầu của môn học</td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
            </tr>
            <tr>
              <td>Các trang thiết bị tại giảng đường đáp ứng yêu cầu giảng dạy và học tập</td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
            </tr>
          </tbody>
        </table>
        <br>
        <h4>2. <span style="color: red;">* </span>Môn học</h4>
        <table class="table" style="width: 100%">
          <thead>
            <th></th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
          </thead>
          <tbody>
            <tr>
              <td>Bạn được hỗ trợ kịp thời trong quá trình học môn này</td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
            </tr>
            <tr>
              <td>Mục tiêu của môn học nêu rõ kiến thức và kỹ năng người học cần đạt được</td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
            </tr>
          </tbody>
        </table>
        <br>
      </div>
  <!--  test -->
      <h4>1. <span style="color: red;">* </span>Cơ sở vật chất</h4>
      <div class="">
        <table class="table" style="width: 100%">
          <thead>
            <th></th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
          </thead>
          <tbody>
            <tr>
              <td>Giảng đường đáp ứng yêu cầu của môn học</td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
            </tr>
            <tr>
              <td>Các trang thiết bị tại giảng đường đáp ứng yêu cầu giảng dạy và học tập</td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
            </tr>
          </tbody>
        </table>
        <br>
        <h4>2. <span style="color: red;">* </span>Môn học</h4>
        <table class="table" style="width: 100%">
          <thead>
            <th></th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
          </thead>
          <tbody>
            <tr>
              <td>Bạn được hỗ trợ kịp thời trong quá trình học môn này</td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
            </tr>
            <tr>
              <td>Mục tiêu của môn học nêu rõ kiến thức và kỹ năng người học cần đạt được</td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
              <td><input type="radio" name="rate"/></td>
            </tr>
          </tbody>
        </table>
      </div>
  <!-- test -->
    </div>
    <br>
    <div class="btn_submit" style="text-align: center;">
      <input class="btn btn-primary" type="submit" name="submit" value="Hoàn thành">
    </div>
    <br>
  </div>
</div><!-- container -->
@endsection
@section('script')
        <script src="vendor/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

        <!-- BEGIN PAGE SCRIPTS -->
        <script src="vendor/assets/plugins/moment/moment.js"></script>
        <script src='vendor/assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
        <script src="vendor/assets/pages/jquery.fullcalendar.js"></script>
@endsection
