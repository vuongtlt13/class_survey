<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="vuong">

        <link rel="shortcut icon" href="vendor/assets/images/favicon_1.ico">

        <title>Class survey</title>

        @yield('css')

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

        <style>
          .content{
            height: 100%;
          }
        </style>

    </head>


    <body>

        <!-- Begin page -->
        <div id="wrapper" style="background-color:#E3F2FD;">

            <!-- Top Bar Start -->
            <!-- Top Bar End -->
            @include('layouts.student_teacher.topbar')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content">
                <!-- Start content -->
                @yield('content')

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- footer -->
            <div id="footer" class="container-fluid text-center" style="background: #2196F3;">
              <h2 style="color: white;">Team phát triển</h2>
              <h4 class="col-sm-4" style="color: white;">Đỗ Quốc Vương</h4>
              <h4 class="col-sm-4" style="color: white;">Nguyễn Đức Vượng</h4>
              <h4 class="col-sm-4" style="color: white;">Bùi Thị Diệu Linh</h4>
            </div>
            <!-- end footer -->
        </div>
        <!-- END wrapper -->

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

        @yield('script')
	</body>
</html>
