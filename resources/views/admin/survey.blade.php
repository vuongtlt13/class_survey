@extends('layouts.master')

@section('css')
    <link href="/vendor/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="/vendor/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/assets/plugins/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/assets/plugins/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css"/>

    <link href="/vendor/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />

    <link href="/vendor/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
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
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="panel panel-border panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title">Tìm kiếm</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row text-center">
                                <div class="col-sm-3 form-group">
                                    {{--<label for="name">Loại tài khoản</label>--}}
                                    {{--<div class="btn-group bootstrap-select">--}}
                                        {{--<select id="account_type" class="selectpicker" data-style="btn-white" tabindex="-98">--}}
                                            {{--<option>Tất cả</option>--}}
                                            {{--<option value="admin">Admin</option>--}}
                                            {{--<option value="giangvien">Giảng viên</option>--}}
                                            {{--<option value="sinhvien">Sinh viên</option>--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="col-sm-5 form-group">
                                    <label for="keyword">Từ khóa</label>
                                    <input type="text" class="form-control" id="keyword" placeholder="Từ khóa...">
                                </div>
                                <div class="col-sm-2 form-group">
                                    {{--<label>Giới tính</label>--}}
                                    {{--<div class="btn-group bootstrap-select">--}}
                                        {{--<select id="gender" class="selectpicker" data-style="btn-white" tabindex="-98">--}}
                                            {{--<option>Tất cả</option>--}}
                                            {{--<option>Nam</option>--}}
                                            {{--<option>Nữ</option>--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="col-sm-2 form-group" style="display: none">
                                    <span class="input-group-btn" style="padding-top: 10px">
                                        <button id="btnSearch" type="button" class="btn waves-effect waves-light btn-default btn-md"><i class="fa fa-search m-r-5"></i> Tìm kiếm</button>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row col-sm-11" style="padding-bottom: 15px;">
                <div class="row pull-right">
                    <button id="btnShowModal" style="display:none" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal"> <i class="fa fa-heart m-r-5"></i>Thêm</button>
                    <button id="btnAdd" onclick="importClass()" class="btn btn-primary waves-effect waves-light"> <i class="glyphicon glyphicon-plus m-r-5"></i> <span>Thêm lớp môn học</span> </button>
                    <div class="fileupload btn btn-purple waves-effect waves-light" style="display: none">
                        <form id="form-upload" method="post" action="{{route('import-class')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <span><i class="ion-upload m-r-5"></i>Upload</span>
                            <input id="btnUpload" name="file" type="file" multiple accept=".csv, .xlsx, .xls" class="upload">
                        </form>
                    </div>
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="glyphicon glyphicon-tasks m-r-5"></i>Thao tác <i class="caret"></i></button>
                        <form style="display: none" id="select-form" method="post" action="">
                            {{csrf_field()}}
                            <input id="selected_id" name="selected_id" type="text">
                        </form>
                        <ul class="dropdown-menu" role="menu">
                            <li><a onclick="sendAction('{{route('delete-class')}}')"> Xóa đã chọn </a></li>
                            <li><a onclick="sendAction('{{route('delete-all')}}')">Xóa tất cả</a></li>
                            <li><a id="btnChange">Đổi mẫu khảo sát</a></li>
                        </ul>
                    </div>

                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="glyphicon glyphicon-import m-r-5"></i>Generate khảo sát <i class="caret"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a onclick="generateTemplate('selected')">Lớp đã chọn</a></li>
                            <li><a onclick="generateTemplate('all')">Tất cả</a></li>
                        </ul>
                    </div>
                    {{--<button class="btn btn-default waves-effect waves-light"> <i class="fa fa-heart m-r-5"></i> <span>Thêm từ excel</span> </button>--}}
                </div>
                <div id="import-progress" class="col-sm-2 pull-right" style="display: none;">
                    <div class="progress progress-lg m-b-5" style="position: relative">
                        <div id="progress_value" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="96" aria-valuemin="0" aria-valuemax="100" style="width: 96%;">
                            <div class="row text-center" id="progress-info" style="color: black;position: absolute; width: 100%;left: 15px;"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="card-box table-responsive">
                        <table id="datatable" class="table table-bordered display myTable">
                            <thead>
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-primary">
                                        <input id="checkbox-all" type="checkbox">
                                        <label for="checkbox-all">
                                        </label>
                                    </div>
                                </th>
                                <th>Mã lớp</th>
                                <th>Lớp môn học</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhật</th>
                                <th>Trạng thái</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="form-title" class="modal-title">Chọn mẫu khảo sát</h4>
                </div>
                <form id="myform" method="post" action="{{route('change-template')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <input style="display: none" id="class_ids" name="class_ids" type="text">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="template">Mẫu khảo sát</label>
                                    <select id="template_picker" name="template" class="selectpicker" data-style="btn-white" tabindex="-98">
                                    </select>
                                    {{--<span id="type-error" style="color: red; display: none">loi type</span>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnSubmit" type="button" class="btn btn-info waves-effect waves-light">Tạo</button>
                        <button id="btnHideModal" type="button" class="btn btn-default waves-effect" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->

    <div style="display: none">
        <button id="btnShowModal" style="display:none" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal"> <i class="fa fa-heart m-r-5"></i>Thêm</button>
    </div>
@endsection

@section('script')
    <script src="/vendor/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <script src="/vendor/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/jszip.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="/vendor/assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/dataTables.scroller.min.js"></script>
    <script src="/vendor/assets/plugins/datatables/dataTables.colVis.js"></script>
    <script src="/vendor/assets/plugins/datatables/dataTables.fixedColumns.min.js"></script>

    <script src="/vendor/assets/pages/datatables.init.js"></script>

    <script src="/vendor/assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="/vendor/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

    <script src="/vendor/assets/plugins/notifyjs/js/notify.js"></script>
    <script src="/vendor/assets/plugins/notifications/notify-metro.js"></script>

    <!-- Modal-Effect -->
    <script src="/vendor/assets/plugins/custombox/js/custombox.min.js"></script>
    <script src="/vendor/assets/plugins/custombox/js/legacy.min.js"></script>
    <!-- excel -->
    <script lang="javascript" src="js/shim.min.js"></script>
    <script lang="javascript" src="js/jszip.js"></script>
    <script lang="javascript" src="js/xlsx.full.min.js"></script>


    <script src="/js/admin-survey.js"></script>
@endsection
