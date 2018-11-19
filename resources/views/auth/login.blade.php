<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="images/edit.png">

    <title>Class survey</title>

    <link href="vendor/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="vendor/assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="vendor/assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="vendor/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="vendor/assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="vendor/assets/css/responsive.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="vendor/assets/js/modernizr.min.js"></script>

</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class=" card-box">
        <div class="panel-heading">
            <h3 class="text-center"> <strong class="text-custom">Đăng nhập vào hệ thống</strong> </h3>
            @if (session('result'))
                <div class="alert alert-warning">
                    Tên đăng nhập hoặc mật khẩu không chính xác!
                </div>
            @endif
            @if (session('activation'))
                <div class="alert alert-warning">
                    Tài khoản đang trong thời gian xác nhận!
                </div>
            @endif
            @if (session('login-require'))
                <div class="alert alert-warning">
                    Bạn chưa đăng nhập!
                </div>
            @endif
        </div>


        <div class="panel-body">
            <form class="form-horizontal m-t-20" method="POST" action="{route('authentication')}">
                {{--<input hidden type="text" name="_token" value="{{ csrf_token() }}">--}}
                {{ csrf_field() }}
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" name="username" required="" placeholder="Tên đăng nhập">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="password" required="" placeholder="Mật khẩu">
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-signup" type="checkbox" checked = "">
                            <label for="checkbox-signup">
                                Ghi nhớ đăng nhập
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">Đăng nhập</button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="page-recoverpw.html" class="text-dark"><i class="fa fa-lock m-r-5"></i> Quên mật khẩu?</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <p>Bạn chưa có tài khoản? <a href="{route('register')}" class="text-primary m-l-5"><b>Đăng ký ngay tại đây</b></a></p>

        </div>
    </div>

</div>




<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="vendor/assets/js/jquery.min.js"></script>
<script src="vendor/assets/js/bootstrap.min.js"></script>
<script src="vendor/assets/js/detect.js"></script>
<script src="vendor/assets/js/fastclick.js"></script>
<script src="vendor/assets/js/jquery.slimscroll.js"></script>
<script src="vendor/assets/js/jquery.blockUI.js"></script>
<script src="vendor/assets/js/waves.js"></script>
<script src="vendor/assets/js/wow.min.js"></script>
<script src="vendor/assets/js/jquery.nicescroll.js"></script>
<script src="vendor/assets/js/jquery.scrollTo.min.js"></script>


<script src="vendor/assets/js/jquery.core.js"></script>
<script src="vendor/assets/js/jquery.app.js"></script>

</body>
</html>
