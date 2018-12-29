@extends('layouts.master')
@section('css')
    <!--calendar css-->
    <link href="vendor/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/student.css" type="text/css">
    <style>
        .myTable {
            background: white;
        }

        .table > tbody > tr > td {
            text-align: center;
            vertical-align: middle;
        }

        .table > thead > tr > th {
            text-align: center;
            vertical-align: middle;
        }

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
            <div class="col-sm-offset-1 col-sm-10 primary_content">
                <!-- header -->
                <div class="row">
                    <h2 style="color: #0D47A1;">Danh sách môn học giảng dạy trong kỳ này</h2>
                    <br>
                </div>
                <!-- body -->
            @foreach($classes as $class)
                <!-- a subject -->
                <div class="item_subject col-sm-8">
                    <div class="col-sm-9">
                        <a href="{{route('subject-result', $class->code)}}"><h3
                                    class="subject_name">[{{$class->code}}] {{$class->name}}</h3></a>
                    </div>
                </div>
                <br>
            @endforeach
            </div>
            <br>
        </div>
    </div>
@endsection
@section('script')
    <script src="vendor/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- BEGIN PAGE SCRIPTS -->
    <script src="vendor/assets/plugins/moment/moment.js"></script>
    <script src='vendor/assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
    <script src="vendor/assets/pages/jquery.fullcalendar.js"></script>
@endsection
