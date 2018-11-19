<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="images/edit.png">

    <title>Tìm gia sư ôn thi đại học - Tại Hà Nội</title>

    <link href="vendor/light/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="vendor/light/assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="vendor/light/assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="vendor/light/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="vendor/light/assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="vendor/light/assets/css/responsive.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="vendor/light/assets/js/modernizr.min.js"></script>

</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class=" card-box">
        <div class="panel-heading">
            <h3 class="text-center"> Đăng ký thông tin <strong class="text-custom">Gia sư</strong> </h3>
        </div>

        <div class="panel-body">
            <form class="form-horizontal m-t-20" method="post" action="{{route('registration')}}">
                {{csrf_field()}}
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" name = "username" required="" placeholder="Tên đăng nhập">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name ="password" required="" placeholder="Mật khẩu">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" required="" placeholder="Nhập lại mật khẩu">
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="email" required="" name = "email" placeholder="Email">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <label for="name"> Đối tượng đăng ký *</label>
                        <input type="text" id = "result-type" name="result-type" hidden value="0">
                        <div class="radio radio-primary">
                            <input type="radio" name="radioType" id="isTutor" checked="">
                            <label for="isTutor">
                                Gia sư
                            </label>
                        </div>

                        <div class="radio radio-primary">
                            <input type="radio" name="radioType" id="isStudent">
                            <label for="isStudent">
                                Người học
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-signup" type="checkbox" checked="checked">
                            <label for="checkbox-signup">Tôi đồng ý với <a href="#">Các quy định và điều khoản</a></label>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">
                            Đăng ký
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <p>
                Nếu bạn đã có tài khoản?<a href="{{route('login')}}" class="text-primary m-l-5"><b>Đăng nhập</b></a>
            </p>
        </div>
    </div>

</div>

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="vendor/light/assets/js/jquery.min.js"></script>
<script src="vendor/light/assets/js/bootstrap.min.js"></script>
<script src="vendor/light/assets/js/detect.js"></script>
<script src="vendor/light/assets/js/fastclick.js"></script>
<script src="vendor/light/assets/js/jquery.slimscroll.js"></script>
<script src="vendor/light/assets/js/jquery.blockUI.js"></script>
<script src="vendor/light/assets/js/waves.js"></script>
<script src="vendor/light/assets/js/wow.min.js"></script>
<script src="vendor/light/assets/js/jquery.nicescroll.js"></script>
<script src="vendor/light/assets/js/jquery.scrollTo.min.js"></script>


<script src="vendor/light/assets/js/jquery.core.js"></script>
<script src="vendor/light/assets/js/jquery.app.js"></script>

<script>
    $('#isTutor').on('click', function () {
        $('#result-type').val("0");
        //console.log($('#result-type').val());
    });

    $('#isStudent').on('click', function () {
        $('#result-type').val("1");
        //console.log($('#result-type').val());
    });
</script>
</body>
</html>