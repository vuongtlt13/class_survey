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
            <div class="primary_content justify-content-center row">
              <div class="col-sm-11">
                <div class="" style="text-align: center;">
                  <h2 style="color: blue;">Lop phat trien web INT2203 1</h2>
                  <br>
                </div>
                <div class="row" style="background: white; padding: 10px;">
                  <div class="info" style="padding-left: 10px;">
                    <p><b>Ghi chú:</b> </p>
                    <div class="col-sm-6">
                      <p>1: Hoàn toàn không tán thành</p>
                      <p>2: Tương đối không tán thành</p>
                      <p>3: Phân vân</p>
                    </div>
                    <div class="col-sm-6">
                      <p>4: Tương đối tán thành</p>
                      <p>5: Hoàn toàn tán thành</p>
                    </div>                    
                  </div>
                  <table class="table table-bordered display myTable">
                    <thead>
                      <tr>
                        <th style="width: 5%">STT</th>
                        <th style="width: 50%">Tiêu chí</th>
                        <th style="width: 7%">1</th>
                        <th style="width: 7%">2</th>
                        <th style="width: 7%">3</th>
                        <th style="width: 7%">4</th>
                        <th style="width: 7%">5</th>
                        <th style="width: 10%">Trung bình</th>
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
