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
                <h2 class="subject_name">Phát triển ứng dụng Web</h2>
                <br>
                <div class="card-box">
                    <div class="row">
                        <div class="" style="padding-left: 10px">
                            <h4><span style="color: red;">* </span>Cơ sở vật chất</h4>
                        </div>
                        <div class="" style="padding-left: 20px">
                            <table class="table table-bordered">
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
                        </div>
                    </div>
                </div>
                <br>
                <div class="btn_submit" style="text-align: center;">
                    <input class="btn btn-primary" type="submit" name="submit" value="Hoàn thành">
                </div>
                <br>
            </div>
        </div><!-- container -->
    </div>
@endsection
@section('script')
    <script src="vendor/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- BEGIN PAGE SCRIPTS -->
    <script src="vendor/assets/plugins/moment/moment.js"></script>
    <script src='vendor/assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
    <script src="vendor/assets/pages/jquery.fullcalendar.js"></script>
@endsection
