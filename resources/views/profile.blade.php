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
        .primary_content{
            display: flex;
            align-items: center;
            flex-direction: column;
        }
    </style>
@endsection
@section('content')
    <!-- Start content -->
    <div class="content">

        <div class="container">
            <div class="primary_content">
                <div class="col-sm-11">
                    <br>
                    <div class="col-sm-8 col-sm-offset-2 card-box" style="text-align: center; padding: 10px;">
                        <img src="/vendor/assets/images/users/avatar-1.jpg" width="" class="img-circle" alt="profile-image">
                        <hr>
                        <h3 class="text-uppercase font-600">Thông tin cá nhân</h3>
                        <br>

                        <form class="form-horizontal" id="myForm" role="form" action="/profile/update" method="post">
                            {{csrf_field()}}
                            <div class="row body-form">
                                <input type="hidden" name="user_id" id="user_id" value="{{$userInfo->id}}">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="form-name" class="col-md-4 control-label">Họ và tên</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="name" id="form-name" value="{{$userInfo->name}}" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="form-email" class="col-sm-4 control-label"><span style="color: red;">* </span>Email</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="email" value="{{$userInfo->email}}" class="form-control" id="form-email" required disabled>
                                            <span class="row" id="email-error" style="color: red; display: none">loi email</span>
                                        </div>

                                    </div>
                                </div>

                                @if($userInfo->type == 1)
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="form-code" class="col-sm-4 control-label"><span style="color: red;">* </span>Mã giảng viên</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="code" value="{{$userInfo->code}}" class="form-control" id="form-code" required disabled>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="form-username" class="col-sm-4 control-label"><span style="color: red;">* </span>Tên đăng nhập</label>
                                        <div class="col-sm-7">
                                            <input type="text" disabled id="form-username" name="username" class="form-control" value="{{ $userInfo->username }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="form-password" class="col-sm-4 control-label"><span style="color: red;">* </span>Mật khẩu</label>
                                        <div class="col-sm-7">
                                            <input type="password" disabled id="form-password" name="password" class="form-control" value="not showed" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6"  id="confirm-pass" hidden>
                                    <div class="form-group">
                                        <label for="form-confirm-pass" class="col-sm-4 control-label"><span style="color: red;">* </span>Nhập lại mật khẩu</label>
                                        <div class="col-sm-7">
                                            <input type="password" id="form-confirm-pass" name="password" class="form-control" value="" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="form-phone" class="col-sm-4 control-label">Điện thoại</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="phone" value="{{$userInfo->phone}}" class="form-control" id="form-phone" disabled>
                                            <span class="row" id="phone-error" style="color: red; display: none">loi phone</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="form-address" class="col-sm-4 control-label">Địa chỉ</label>
                                        <div class="col-sm-7">
                                            <input type="text" disabled id="form-address" name="address" class="form-control" value="{{ $userInfo->address }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 ">
                                    <div class="form-group">
                                        <label class="col-sm-4">Giới tính</label>
                                        <div class="col-sm-8 btn-group bootstrap-select">
                                            <select id="gender" class="selectpicker" name="gender" data-style="btn-white" tabindex="-98">
                                                <option value=""> </option>
                                                <option value="0">Nam</option>
                                                <option value="1">Nữ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @if($userInfo->type == 0)
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="form-course" class="col-sm-4 control-label">Khóa học</label>
                                            <div class="col-sm-7">
                                                <input type="text" disabled id="form-course" name="course" class="form-control" value="{{ $userInfo->khoahoc }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="form-major" class="col-sm-4 control-label">Ngành học</label>
                                            <div class="col-sm-7">
                                                <input type="text" disabled id="form-major" name="major" class="form-control" value="{{ $userInfo->major }}">
                                            </div>
                                        </div>
                                    </div>
                                @elseif($userInfo->type == 1)
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="form-degree" class="col-sm-4 control-label">Bằng cấp</label>
                                            <div class="col-sm-7">
                                                <input type="text" disabled id="form-degree" name="degree" class="form-control" value="{{ $userInfo->degree }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <br>
                            <div class="row">
                                <button type="button" id="btnEdit" class="btn btn-default waves-effect waves-light">Thay đổi thông tin</button>
                                <button type="button" id="btnSave" disabled class="btn btn-default waves-effect waves-light">Lưu</button>
                                <span id="message"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- container -->

    </div> <!-- content -->
@stop

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

    <script src="/vendor/assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="/vendor/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

    <script src="/vendor/assets/plugins/custombox/js/custombox.min.js"></script>
    <script src="/vendor/assets/plugins/custombox/js/legacy.min.js"></script>
    <script src="/js/profile.js"></script>

@endsection
