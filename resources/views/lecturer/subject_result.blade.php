@extends('layouts.master')
@section('css')
        <!--calendar css-->
        <link href="vendor/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/css/student.css" type="text/css">
        <style>
          .myTable{
            background: white;
          }
          .table > tbody > tr > td{
            text-align: center;
            vertical-align: middle;
          }
          .table > thead > tr > th{
            text-align: center;
            vertical-align: middle;
          }
          table.myTable.stripe tbody tr.odd,
          table.myTable.display tbody tr.odd {
              background-color: #f9f9f9
          }

          table.myTable.hover tbody tr:hover,
          table.myTable.display tbody tr:hover {
              cursor: pointer;
              background-color: #abc9ef
          }
        </style>
@endsection
@section('content')
    <div class="content">
        <div class="container">
            <div class="justify-content-center row primary_content">
              <div class="col-sm-11">
                <div style="text-align: center;">
                  <h2 style="color: blue;">Kết quả phản hồi về học phần Phat trien web</h2>
                </div>
                <br>
                <div class="" style="background: white; padding: 10px;">
                  <div class="subject_info" style="padding-left: 20px; color: black;">
                    <div class="row" style="font-size: 120%">
                      <div class="col-sm-6">
                        <p><b>Tên giảng viên:</b> Le Dinh Thanh</p>
                        <p><b>Số sinh viên đánh giá:</b>100 </p>
                      </div>
                      <div class="col-sm-6">
                        <p><b>Số giảng viên tham gia dạy học phần:</b> 3</p>
                        <p><b>Số lượng môn học giảng viên tham gia dạy:</b> 3</p>
                      </div>
                    </div>
                    <p><b>Ghi chú:</b></p>
                    <p>M: giá trị trung bình của các tiêu chí theo lớp học phần</p>
                    <p>STD: độ lệch chuẩn của các tiêu chí theo lớp học phần</p>
                    <p>M1: giá trị trung bình các tiêu chí dựa trên dữ liệu phản hồi của sinh cho các giảng viện dạy cùng môn học với thầy/cô</p>
                    <p>STD1: độ lệch chuẩn của các tiêu chí dựa trên ý kiến phản hồi của sinh viên cho các giảng viên dạy cùng môn học với thầy/cô</p>
                    <p>M2: giá trị trung bình của các tiêu chí dựa trên ý kiến phản hồi của sinh viên về các môn học mà thầy/cô đã thực hiện giảng dạy</p>
                    <p>STD2: độ lệch chuẩn của các tiêu chí dựa trên ý kiến phản hồi của sinh viên về các môn học mà thầy/cô đã thực hiện giảng dạy</p>
                  </div>
                  <br>
                  <table class="table table-bordered display myTable">
                    <thead>
                      <tr>
                        <th style="width: 5%">STT</th>
                        <th style="width: 53%">Tiêu chí</th>
                        <th style="width: 7%">M</th>
                        <th style="width: 7%">STD</th>
                        <th style="width: 7%">M1</th>
                        <th style="width: 7%">STD1</th>
                        <th style="width: 7%">M2</th>
                        <th style="width: 7%">STD2</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td style="text-align: left;">tieu chi 1</td>
                        <td>4</td>
                        <td>4</td>
                        <td>4</td>
                        <td>4</td>
                        <td>4</td>
                        <td>4</td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td style="text-align: left;">tieu chi 1</td>
                        <td>4</td>
                        <td>4</td>
                        <td>4</td>
                        <td>4</td>
                        <td>4</td>
                        <td>4</td>
                      </tr>
                    </tbody>
                  </table>

                </div>
              </div>
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
