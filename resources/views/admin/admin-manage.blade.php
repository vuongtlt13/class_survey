@extends('layouts.master')

@section('css')
    <link href="vendor/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="vendor/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendor/assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendor/assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendor/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendor/assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendor/assets/plugins/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css"/>
    <link href="vendor/assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendor/assets/plugins/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css"/>

    <link href="vendor/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />

    <link href="vendor/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="vendor/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <style>
        table.myTable.stripe tbody tr.odd,
        table.myTable.display tbody tr.odd {
            background-color: #f9f9f9
        }

        table.myTable.hover tbody tr:hover,
        table.myTable.display tbody tr:hover {
            cursor: pointer;
            background-color: #aab7d1
        }
    </style>
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="panel panel-border panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title">Tìm kiếm</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row text-center">
                                <div class="col-sm-3 form-group">
                                    <label for="name">Loại tài khoản</label>
                                    <div class="btn-group bootstrap-select">
                                        <select id="account_type" class="selectpicker" data-style="btn-white" tabindex="-98">
                                            <option>Tất cả</option>
                                            <option value="admin">Admin</option>
                                            <option value="giangvien">Giảng viên</option>
                                            <option value="sinhvien">Sinh viên</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Điền tên">
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label>Giới tính</label>
                                    <div class="btn-group bootstrap-select">
                                        <select id="gender" class="selectpicker" data-style="btn-white" tabindex="-98">
                                            <option>Tất cả</option>
                                            <option>Nam</option>
                                            <option>Nữ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <span class="input-group-btn" style="padding-top: 10px">
                                        <button id="btnSearch" type="button" class="btn waves-effect waves-light btn-default btn-md"><i class="fa fa-search m-r-5"></i> Tìm kiếm</button>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable" class="table table-bordered display myTable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Tên</th>
                                <th>Tuổi</th>
                                <th>Giới tính</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Công việc</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--@foreach($courses as $course)--}}
                            {{--<tr>--}}
                            {{--<td>{{$course->user_id}}</td>--}}
                            {{--<td>{{$course->user_id}}</td>--}}
                            {{--<td>{{$course->user_id}}</td>--}}
                            {{--<td>{{$course->subject_id}}</td>--}}
                            {{--<td>{{$course->area_id}}</td>--}}
                            {{--<td>{{$course->fee}} VNĐ</td>--}}
                            {{--</tr>--}}
                            {{--@endforeach--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="custom-modal" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Thông tin chi tiết</h4>
        <div class="custom-modal-text">
            <div class="row card-box">
                <div class="col-sm-5">
                    <img class="img-circle" src="vendor/assets/images/users/avatar-6.jpg" alt="">
                    <h3 id="name_info" class="header-title"><b>Bill Bertz</b></h3>
                    <p id="gender_age_info" class="text-muted">Nam - 26 tuổi</p>
                </div>
                <div class="col-sm-7 pull-left" style="padding-right: 5%;padding-top: 3%;">
                    <div class="form-group" style="text-align: left">
                        <p><b>Nghề nghiệp: </b><label class="text-muted" id="job_info">Branch manager</label></p>
                        <p><b>Nơi làm việc: </b><label class="text-muted" id="company_info">ABC company Pvt Ltd.</label></p>
                        <p><b>Email: </b><label class="text-muted" id="email_info">abc@abc</label></p>
                        <p><b>Số điện thoại: </b><label class="text-muted" id="phone_info">0123456789</label></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none" id="myDiv">
        <a id ="btnModal"  href="#custom-modal" class="btn btn-primary waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a">Show Me</a>
    </div>
@endsection

@section('script')
    <script src="vendor/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <script src="vendor/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="vendor/assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="vendor/assets/plugins/datatables/jszip.min.js"></script>
    <script src="vendor/assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="vendor/assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="vendor/assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="vendor/assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="vendor/assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="vendor/assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="vendor/assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="vendor/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
    <script src="vendor/assets/plugins/datatables/dataTables.scroller.min.js"></script>
    <script src="vendor/assets/plugins/datatables/dataTables.colVis.js"></script>
    <script src="vendor/assets/plugins/datatables/dataTables.fixedColumns.min.js"></script>

    <script src="vendor/assets/pages/datatables.init.js"></script>

    <script src="vendor/assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="vendor/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

    <script src="vendor/assets/plugins/switchery/js/switchery.min.js"></script>

    <script src="/js/admin-manage.js"></script>

    <!-- Modal-Effect -->
    <script src="vendor/assets/plugins/custombox/js/custombox.min.js"></script>
    <script src="vendor/assets/plugins/custombox/js/legacy.min.js"></script>

    <script src="/js/admin-action.js"></script>
@endsection
