@extends('layouts.master')
@section('content')
    <!-- Start content -->
    <div class="content">

        <div class="wraper container">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Profile</h4>
                </div>
            </div>

            <div class="row" style="text-align: center" >
                <div class="col-md-8 col-md-offset-2">
                    <div class="profile-detail card-box">
                        <div>
                            <img src="/images/avatar-default.png" width="" class="img-circle" alt="profile-image">

                            <hr>
                            <h4 class="text-uppercase font-600">Thông tin cá nhân</h4>

                            <form class="form-horizontal" id="myForm" method="post" role="form" style="padding-left: 20%" action="/profile/update">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="user_id" id="user_id" value="$userInfo->id">
                                <div class="form-group">
                                    <label for="form-name" class="col-md-2 control-label">Họ và tên</label>
                                    <div class="col-md-6">
                                        <input type="text" required id="form-name" name="name" disabled class="form-control" value="{$userInfo->name}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="form-email" class="col-md-2 control-label">Email</label>
                                    <div class="col-md-6">
                                        <input type="email" required disabled id="form-email" name="email" class="form-control" value="{$userInfo->email}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="form-phone" class="col-md-2 control-label">Phone</label>
                                    <div class="col-md-6">
                                        <input type="text" id="form-phone" disabled name="phone" class="form-control" value="{$userInfo->phone}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="form-password" class="col-md-2 control-label">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" disabled id="form-password" name="password" class="form-control" value="Khong xem dc dau">
                                    </div>
                                </div>

                                <button type="button" id="btn-edit" class="btn btn-default waves-effect waves-light">Thay đổi thông tin</button>
                                <button type="submit" id="btn-save" disabled class="btn btn-default waves-effect waves-light">Lưu</button>
                                <span id="message"></span>
                            </form>

                        </div>

                    </div>
                </div>

            </div>



        </div> <!-- container -->

    </div> <!-- content -->
@stop

@section('script')
    <script src="/js/profile.js"></script>
@endsection
