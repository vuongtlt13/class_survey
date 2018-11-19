@extends('layouts.master')

@section('css')
    <!--Form Wizard-->
    <link rel="stylesheet" type="text/css" href="vendor/light/assets/plugins/jquery.steps/css/jquery.steps.css" />

    <link href="vendor/light/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="vendor/light/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <div class="content">
            <div class="container">
                <!-- Wizard with Validation -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title"><b>Hoàn thành thông tin đăng ký</b></h4>
                            <p class="text-muted m-b-30 font-13">
                                Bạn phải điền đầy đủ thông tin để được hệ thống xác nhận, đặc biệt các thông tin có dấu (*)
                            </p>

                            <form id="wizard-validation-form" method="post" action="{{route('complete-info')}}">
                                {{csrf_field()}}
                                <div>
                                    <h3>Bước 1: Điền thông tin cơ bản</h3>
                                    <section>

                                        <div class="form-group clearfix">
                                            <label class="col-lg-2 control-label" for="name"> Họ và Tên *</label>
                                            <div class="col-lg-10">
                                                <input id="name" name="name" type="text" class="required form-control">
                                            </div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <label class="col-lg-2 control-label " for="sex">Giới tính </label>
                                            <div class="col-sm-2 btn-group bootstrap-select">
                                                <select id = "gender" name = "gender" class="selectpicker" data-style="btn-white" tabindex="-98">
                                                    <option>Nam</option>
                                                    <option>Nữ</option>
                                                    <option>Khác</option>
                                                </select>
                                            </div>
                                            {{--<input id="address2" name="sex" type="text" class="form-control">--}}
                                        </div>

                                        <div class="form-group clearfix">
                                            <label class="col-lg-2 control-label" for="dob"> Ngày sinh *</label>
                                            <div class="col-lg-10">
                                                <input id="dob" name="dob" type="date" class="required form-control">
                                            </div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <label class="col-lg-2 control-label" for="cmnd"> CMND *</label>
                                            <div class="col-lg-10">
                                                <input data-parsley-type="digits" data-parsley-id="45" id="cmnd" name="cmnd" type="text" class="required form-control">
                                            </div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <label class="col-lg-2 control-label" for="phone"> Số điện thoại *</label>
                                            <div class="col-lg-10">
                                                <input data-parsley-type="digits" data-parsley-id="44" id="phone" name="phone" type="text" class="required form-control">
                                            </div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <label class="col-lg-2 control-label " for="address">Địa chỉ </label>
                                            <div class="col-lg-10">
                                                <input id="address" name="address" type="text" class="form-control">
                                            </div>
                                        </div>

                                    </section>
                                    <h3>Bước 2: Điền thông tin thêm</h3>
                                    <section>
                                        @if ($type == 1)
                                            <div class="form-group clearfix">
                                                <label class="col-lg-2 control-label" for="job"> Công việc chính</label>
                                                <div class="col-lg-10">
                                                    <input id="job" name="job" type="text" class="required form-control">
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="col-lg-2 control-label" for="workplace"> Cơ quan</label>
                                                <div class="col-lg-10">
                                                    <input id="workplace" name="workplace" type="text" class="required form-control">
                                                </div>
                                            </div>
                                        @elseif ($type == 0)
                                            <div class="form-group clearfix">
                                                <label class="col-lg-2 control-label" for="school"> Trường</label>
                                                <div class="col-lg-10">
                                                    <input id="school" name="school" type="text" class="required form-control">
                                                </div>
                                            </div>
                                        @endif
                                    </section>
                                    <h3>Bước 3: Xác nhận</h3>
                                    <section>
                                        <div class="form-group clearfix">
                                            <div class="col-lg-12">
                                                <ul class="list-unstyled w-list">
                                                    <li><b>Họ và Tên :</b><span id="result-name"> </span></li>
                                                    <li><b>Giới tính :</b> <span id="result-gender"> </span></li>
                                                    <li><b>Ngày sinh :</b> <span id="result-dob"> </span></li>
                                                    <li><b>CMND :</b> <span id="result-cmnd"> </span></li>
                                                    <li><b>Số điện thoại :</b> <span id="result-phone"> </span></li>
                                                    <li><b>Địa chỉ :</b> <span id="result-address"> </span></li>
                                                    @if ($type == 1)
                                                        <li><b>Công việc :</b><span id="result-job"> </span></li>
                                                        <li><b>Cơ quan :</b> <span id="result-workplace"> </span></li>
                                                    @elseif ($type == 0)
                                                        <li><b>Trường : </b><span id="result-school"> </span></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End row -->
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
@endsection

@section('script')
    <!--Form Wizard-->
    <script src="vendor/light/assets/plugins/jquery.steps/js/jquery.steps.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="vendor/light/assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>

    <!--wizard initialization-->
    <script src="vendor/light/assets/pages/jquery.wizard-init.js" type="text/javascript"></script>

    <script src="vendor/light/assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="vendor/light/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="vendor/light/assets/plugins/parsleyjs/parsley.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('form').parsley();
        });
    </script>
@endsection