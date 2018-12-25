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
            background-color: #abc9ef
        }

        table td {
            text-overflow:ellipsis;
            overflow:hidden;
            white-space:nowrap;
        }

        .my-search {
            width: 70%;
        }
    </style>
@endsection

@section('content')
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-sm-4" id="title-area">
                    <div class="row text-center">
                        <h2>TIÊU ĐỀ</h2>
                        <br>
                    </div>
                    <div class="row pull-right" style="padding-right: 50px; padding-bottom: 10px;">
                        <button id="btnTitleShowModal" style="display:none" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#title-con-close-modal"> <i class="fa fa-heart m-r-5"></i> <span>Thêm</span> </button>
                        <button id="btnTitleAdd" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-heart m-r-5"></i> <span>Thêm</span> </button>
                        <button id="btnTitleDelete" class="btn btn-primary waves-effect waves-light">Xóa</button>
                        <form style="display: none" id="title-select-form" method="post" action="{{route('delete-title')}}">
                            {{csrf_field()}}
                            <input id="title-selected_id" name="selected_id" type="text">
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-sm-11 col-sm-offset-1">
                            <div class="card-box table-responsive" >
                                <table id="title-datatable" class="table table-bordered display myTable">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox checkbox-primary">
                                                <input id="title-checkbox-all" type="checkbox">
                                                <label for="title-checkbox-all">
                                                </label>
                                            </div>
                                        </th>
                                        <th>Tiêu đề</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7" id="question-area">
                    <div class="row text-center">
                        <h2>CÂU HỎI</h2>
                        <br>
                    </div>
                    <div class="row pull-right" style="padding-right: 50px; padding-bottom: 10px;">
                        <button id="btnQuestionShowModal" style="display:none" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#question-con-close-modal"> <i class="fa fa-heart m-r-5"></i> <span>Thêm</span> </button>
                        <button id="btnQuestionAdd" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-heart m-r-5"></i> <span>Thêm</span> </button>
                        <button id="btnQuestionDelete" class="btn btn-primary waves-effect waves-light">Xóa</button>
                        <form style="display: none" id="question-select-form" method="post" action="{{route('delete-question')}}">
                            {{csrf_field()}}
                            <input id="question-selected_id" name="selected_id" type="text">
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="card-box table-responsive">
                                <table id="question-datatable" class="table table-bordered display myTable">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox checkbox-primary">
                                                <input id="question-checkbox-all" type="checkbox">
                                                <label for="question-checkbox-all">
                                                </label>
                                            </div>
                                        </th>
                                        <th>Tiêu đề</th>
                                        <th>Câu hỏi</th>
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

        </div>
    </div>

    <!-- Title Modal -->
    <div id="title-con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="form-title" class="modal-title">Tạo tiêu đề mới</h4>
                </div>
                <form id="title-form" method="post" action="{{route('create-title')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title" class="control-label">Tiêu đề</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Nội dung">
                                    <span id="title-error" style="color: red; display: none">chưa nhập nội dung tiêu đề</span>
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

    <!-- Question Modal -->
    <div id="question-con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="form-question" class="modal-title">Tạo câu hỏi mới</h4>
                </div>
                <form id="question-form" method="post" action="{{route('create-question')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="prevew_title">Tiêu đề</label>
                                    <select id="prevew_title" name="title_id" class="selectpicker" data-style="btn-white" tabindex="-98">
                                        <option value="">Hãy chọn tiêu đề</option>
                                    </select>
                                    <span id="prevew_title-error" style="color: red; display: none">Hãy chọn tiêu đề</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="question" class="control-label">Câu hỏi</label>
                                    <input type="text" class="form-control" id="question" name="question" placeholder="Nội dung">
                                    <span id="question-error" style="color: red; display: none">Chưa nhập nội dung câu hỏi</span>
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

    <script src="/vendor/assets/plugins/switchery/js/switchery.min.js"></script>

    <script src="/vendor/assets/plugins/notifyjs/js/notify.js"></script>
    <script src="/vendor/assets/plugins/notifications/notify-metro.js"></script>

    <!-- Modal-Effect -->
    <script src="/vendor/assets/plugins/custombox/js/custombox.min.js"></script>
    <script src="/vendor/assets/plugins/custombox/js/legacy.min.js"></script>

    <script src="/js/admin-question.js"></script>
@endsection
