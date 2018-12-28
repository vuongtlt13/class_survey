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
              <div class="row" style="background: white; text-align: center; padding: 10px;">
                <img src="/images/avatar-default.png" width="" class="img-circle" alt="profile-image">
                <hr>
                <h3 class="text-uppercase font-600">Thông tin cá nhân</h3>
                <br>
                <form class="form-horizontal" id="myForm" role="form" action="/profile/update" method="post">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="user_id" id="user_id" value="$userInfo->id">
                  <div class="row">
                    <div class="row col-sm-6">
                      <div class="form-group row">
                        <label for="form-name" class="col-md-3 control-label">Họ và tên</label>
                        <div class="col-sm-8">
                          <input type="text" name="name" id="form-name" value="{$userInfo->name}" class="form-control" required disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="form-email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-8">
                          <input type="text" name="email" value="{$userInfo->email}" class="form-control" id="form-email" required disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="form-phone" class="col-sm-3 control-label">Điện thoại</label>
                        <div class="col-sm-8">
                          <input type="text" name="phone" value="{$userInfo->phone}" class="form-control" id="form-phone" required disabled>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="form-password" class="col-sm-3 control-label">Mật khẩu</label>
                        <div class="col-sm-8">
                          <input type="password" disabled id="form-password" name="password" class="form-control" value="Khong xem dc dau">
                        </div>
                      </div>

                    </div>

                    <div class="col-sm-6 row">

                    </div>
                  </div>
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
