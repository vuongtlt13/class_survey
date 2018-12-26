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

    <link href="/vendor/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/assets/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
    <link href="/vendor/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

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

        table > tbody > tr, table > tbody > tr > td{
            border-top: 2px solid #e0e0e0;
        }

        table > thead {
            border-bottom: 3px solid #e0e0e0;
        }

        .white-space-normal {
            white-space: normal;
        }

        span.removable:hover {
            display: inline;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-sm-5" id="title-area">
                    <div class="row text-center">
                        <h2>Mẫu khảo sát</h2>
                        <br>
                    </div>
                    <div class="row pull-right" style="padding-right: 50px; padding-bottom: 10px;">
                        <button id="btnTemplateShowModal" style="display:none" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#template-con-close-modal"> <i class="fa fa-heart m-r-5"></i> <span>Thêm</span> </button>
                        <button id="btnTemplateAdd" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-heart m-r-5"></i> <span>Thêm</span> </button>
                        <button id="btnTemplateDelete" class="btn btn-primary waves-effect waves-light">Xóa</button>
                        <form style="display: none" id="template-select-form" method="post" action="{{route('delete-template')}}">
                            {{csrf_field()}}
                            <input id="template-selected_id" name="selected_id" type="text">
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-sm-11 col-sm-offset-1">
                            <div class="card-box table-responsive" >
                                <table id="template-datatable" class="table table-bordered display myTable">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox checkbox-primary">
                                                <input id="template-checkbox-all" type="checkbox">
                                                <label for="template-checkbox-all">
                                                </label>
                                            </div>
                                        </th>
                                        <th>Tên</th>
                                        <th>Trạng thái</th>
                                        <th>Xem và sửa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7" id="preview-area">
                    <div class="row text-center">
                        <h2>Xem và sửa</h2>
                        <br>
                    </div>
                    <div id="content_area" style="display: none;">
                        <div class="row">
                            <div class="col-sm-6 pull-right" style="padding-right: 50px; padding-bottom: 10px;">
                                <button id="btnShowModal" style="display:none" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#question-con-close-modal"> <i class="fa fa-heart m-r-5"></i> <span>Thêm</span> </button>
                                <button id="btnAddQuestion" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-heart m-r-5"></i> <span>Thêm câu hỏi</span> </button>
                            </div>
                            <div class="col-sm-3 pull-right">
                                <h3 id="" class="name_template">Tên mẫu khảo sát</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="card-box col-sm-offset-1 col-sm-11" style="height: 760px;overflow: auto;">
                                <div class="survey_content">
                                </div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Template Modal -->
    <div id="template-con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="form-template" class="modal-title">Tạo mẫu mới</h4>
                </div>
                <form id="template-form" method="post" action="{{route('create-template')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="template" class="control-label">Tên mẫu</label>
                                    <input type="text" class="form-control" id="template" name="template" placeholder="Nội dung">
                                    <span id="template-error" style="color: red; display: none">Chưa nhập tên mẫu</span>
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
        <div class="modal-dialog" style="width: 75%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="form-question" class="modal-title">Thêm câu hỏi vào mẫu khảo sát</h4>
                </div>
                <form id="question-form" method="post" action="{{route('add-question')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <select name="selected_questions" class="multi-select" multiple="multiple" data-selectable-optgroup="true" id="selected_questions" >
                                <optgroup label="NFC EAST">
                                    <option>Dallas Cowboys</option>
                                    <option>New York Giants</option>
                                    <option>Philadelphia Eagles</option>
                                    <option>Washington Redskins</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnSubmit" type="button" class="btn btn-info waves-effect waves-light">Thêm</button>
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
    <script type="text/javascript" src="/vendor/assets/plugins/multiselect/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="/vendor/assets/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
    <script src="/vendor/assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="/vendor/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

    <script src="/js/admin-surveytemplate.js"></script>
    <script type="text/javascript" src="/vendor/assets/pages/jquery.form-advanced.init.js"></script>
@endsection
