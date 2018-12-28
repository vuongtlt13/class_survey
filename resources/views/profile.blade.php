@extends('layouts.master')
@section('css')

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
              <h2 class="page-title">Profile</h2>
              <br>
              <div class="row" style="background: white; text-align: center; padding: 10px;">
                <img src="/images/avatar-default.png" width="" class="img-circle" alt="profile-image">
                <hr>
                <h3 class="text-uppercase font-600">Thông tin cá nhân</h3>
                <br>
                <form class="form-horizontal" id="myForm" role="form" action="/profile/update" method="post">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="user_id" id="user_id" value="{{$userInfo->id_number}}">
                  <div class="row">
                    <div class="row col-sm-6">
                      <div class="form-group row">
                        <label for="form-name" class="col-md-4 control-label">Họ và tên</label>
                        <div class="col-sm-7">
                          <input type="text" name="name" id="form-name" value="{{$userInfo->name}}" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="form-email" class="col-sm-4 control-label"><span style="color: red;">* </span>Email</label>
                        <div class="col-sm-7">
                          <input type="text" name="email" value="{{$userInfo->email}}" class="form-control" id="form-email" required disabled>
                        </div>
                      </div>

                      @if($userInfo->type == 1)
                      <div class="form-group">
                        <label for="form-code" class="col-sm-4 control-label"><span style="color: red;">* </span>Mã giảng viên</label>
                        <div class="col-sm-7">
                          <input type="text" name="code" value="{{$userInfo->code}}" class="form-control" id="form-code" required disabled>
                        </div>
                      </div>
                      @endif
                      
                      <div class="form-group">
                        <label for="form-username" class="col-sm-4 control-label"><span style="color: red;">* </span>Tên đăng nhập</label>
                        <div class="col-sm-7">
                          <input type="text" disabled id="form-username" name="username" class="form-control" value="{{ $userInfo->username }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="form-password" class="col-sm-4 control-label"><span style="color: red;">* </span>Mật khẩu</label>
                        <div class="col-sm-7">
                          <input type="password" disabled id="form-password" name="password" class="form-control" value="not showed" required>
                        </div>
                      </div>
                      <div class="form-group" id="confirm-pass" hidden>
                        <label for="form-confirm-pass" class="col-sm-4 control-label"><span style="color: red;">* </span>Nhập lại mật khẩu</label>
                        <div class="col-sm-7">
                          <input type="password" id="form-confirm-pass" name="password" class="form-control" value="" required>
                        </div>
                      </div>

                    </div>

                    <div class="col-sm-6 row">
                      <div class="form-group">
                        <label for="form-phone" class="col-sm-4 control-label">Điện thoại</label>
                        <div class="col-sm-7">
                          <input type="text" name="phone" value="{{$userInfo->phone}}" class="form-control" id="form-phone" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="form-address" class="col-sm-4 control-label">Địa chỉ</label>
                        <div class="col-sm-7">
                          <input type="text" disabled id="form-address" name="address" class="form-control" value="{{ $userInfo->address }}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="form-gender" class="col-sm-4 control-label">Giới tính</label>
                        <div class="col-sm-7">
                          <input type="text" disabled id="form-gender" name="gender" class="form-control" value="{{ $userInfo->gender }}">
                        </div>
                      </div>
                      @if($userInfo->type == 0)
                        <div class="form-group">
                          <label for="form-course" class="col-sm-4 control-label">Khóa học</label>
                          <div class="col-sm-7">
                            <input type="text" disabled id="form-course" name="course" class="form-control" value="{{ $userInfo->khoahoc }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="form-major" class="col-sm-4 control-label">Ngành học</label>
                          <div class="col-sm-7">
                            <input type="text" disabled id="form-major" name="major" class="form-control" value="{{ $userInfo->major }}">
                          </div>
                        </div>
                      @elseif($userInfo->type == 1)
                        <div class="form-group">
                          <label for="form-degree" class="col-sm-4 control-label">Bằng cấp</label>
                          <div class="col-sm-7">
                            <input type="text" disabled id="form-degree" name="degree" class="form-control" value="{{ $userInfo->degree }}">
                          </div>
                        </div>
                      @endif

                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <button type="button" id="btn-edit" class="btn btn-default waves-effect waves-light">Thay đổi thông tin</button>
                    <button type="submit" id="btn-save" disabled class="btn btn-default waves-effect waves-light">Lưu</button>
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
    <script src="/js/profile.js"></script>
@endsection
