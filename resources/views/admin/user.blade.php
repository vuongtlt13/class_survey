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
                                            <option value="all">Tất cả</option>
                                            <option value="2">Admin</option>
                                            <option value="1">Giảng viên</option>
                                            <option value="0">Sinh viên</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label for="keyword">Từ khóa</label>
                                    <input type="text" class="form-control" id="keyword" placeholder="Điền từ khóa">
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label>Giới tính</label>
                                    <div class="btn-group bootstrap-select">
                                        <select id="gender" class="selectpicker" data-style="btn-white" tabindex="-98">
                                            <option value="all">Tất cả</option>
                                            <option value="0">Nam</option>
                                            <option value="1">Nữ</option>
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

            <div class="row pull-right" style="padding-right: 100px; padding-bottom: 10px;">
              <button id="btnShowModal" style="display:none" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal"> <i class="fa fa-heart m-r-5"></i> <span>Thêm</span> </button>
              <button id="btnAdd" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-heart m-r-5"></i> <span>Thêm</span> </button>
              <button class="btn btn-default waves-effect waves-light"> <i class="fa fa-heart m-r-5"></i> <span>Xóa</span> </button>
              <button class="btn btn-default waves-effect waves-light"> <i class="fa fa-heart m-r-5"></i> <span>Khóa</span> </button>
              <button class="btn btn-default waves-effect waves-light"> <i class="fa fa-heart m-r-5"></i> <span>Thêm từ excel</span> </button>
            </div>
            <div class="row">
                <div class="col-sm-12">
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
                                <th>Tên</th>
                                <th>Tên đăng nhập</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Loại tài khoản</th>
                                <th>Trạng thái</th>
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
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="form-title" class="modal-title">Tạo tài khoản</h4>
                </div>
                <form id="myform" method="post" action="{{route('create-user')}}">
                  {{csrf_field()}}
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="username" class="control-label">Tên đăng nhập</label>
                                  <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="name" class="control-label">Họ và tên</label>
                                  <input type="text" class="form-control" id="name" name="name" placeholder="Họ và tên">
                              </div>
                          </div>
                      </div>
                      <div class="col-sm-3 form-group">
                          <label for="account_type">Loại tài khoản</label>
                          <div class="btn-group bootstrap-select">
                              <select id="account_type" name="account_type" class="selectpicker" data-style="btn-white" tabindex="-98">
                                  <option value="admin">Admin</option>
                                  <option value="giangvien">Giảng viên</option>
                                  <option value="sinhvien">Sinh viên</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-sm-2 form-group">
                          <label for="gender">Giới tính</label>
                          <div class="btn-group bootstrap-select">
                              <select id="gender" name="gender" class="selectpicker" data-style="btn-white" tabindex="-98">
                                  <option value=""> </option>
                                  <option value="male">Nam</option>
                                  <option value="female">Nữ</option>
                              </select>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="email" class="control-label">Email</label>
                                  <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="phone" class="control-label">Số điện thoại</label>
                                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="address" class="control-label">Địa chỉ</label>
                                  <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ">
                              </div>
                          </div>
                      </div>

                  </div>
                  <div class="modal-footer">
                    <button id="btnSubmit" type="button" class="btn btn-info waves-effect waves-light">Tạo</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Hủy</button>
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


    <!-- Modal-Effect -->
    <script src="/vendor/assets/plugins/custombox/js/custombox.min.js"></script>
    <script src="/vendor/assets/plugins/custombox/js/legacy.min.js"></script>

    <script src="/js/admin-user.js"></script>
    <script src="/js/admin-user-ajax.js"></script>
@endsection
