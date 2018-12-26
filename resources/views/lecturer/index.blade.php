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
                  <h2 style="color: blue;">Kết quả phản hồi về học phần</h2>
                </div>
                <br>
                <div class="" style="background: white; padding: 10px;">
                  <div class="subject_info" style="padding-left: 20px;">
                    <h4><b>Tên học phần:</b> Phat trien web</h4>
                    <h4><b>Tên giảng viên:</b> Le Dinh Thanh</h4>
                    <h4><b>Số sinh viên đánh giá:</b> 100</h4>
                    <h4><b>Số giảng viên tham gia dạy học phần Phat trien web:</b> 3</h4>
                    <h4><b>Số lượng môn học giảng viên tham gia dạy:</b> 2</h4>
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
