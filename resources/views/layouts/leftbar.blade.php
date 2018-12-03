<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
              <!-- Sinh viên -->
              <li class="text-muted menu-title">Sinh viên</li>
              <li class="has_sub">
                  <a href="{{route('student-index')}}" class="waves-effect"><i class="ti-pencil-alt"></i><span> Đánh giá khảo sát </span></a>
              </li>
              <!-- Giảng viên -->
              <li class="text-muted menu-title">Giảng viên</li>
              <!-- Admin -->
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-bar-chart"></i> <span> Xem kết quả khảo sát </span></a>
                </li>

                <li class="text-muted menu-title">Quản lý</li>

                <li class="has_sub">
                    <a href="{{route('admin-user')}}" class="waves-effect"><i class="ti-user"></i> <span> Tài khoản </span></a>
                </li>
                <li class="has_sub">
                    <a href="{{route('admin-survey-template')}}" class="waves-effect"><i class="ti-pencil-alt"></i><span> Phiếu khảo sát </span></a>
                </li>
                <li class="has_sub">
                    <a href="{{route('admin-survey')}}" class="waves-effect"><i class="ti-files"></i> <span> Cuộc khảo sát </span></a>
                </li>
                <li class="has_sub">
                    <a href="{{route('admin-question')}}" class="waves-effect"><i class="ti-help"></i> <span> Câu hỏi khảo sát </span></a>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-bar-chart"></i> <span> Xem kết quả khảo sát </span></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
