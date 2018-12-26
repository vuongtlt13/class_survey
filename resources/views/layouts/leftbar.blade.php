<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
              @if (Sentinel::getUser()->type == 0)
              <!-- Sinh viên -->
              <li class="text-muted menu-title">Sinh viên</li>
              <li class="has_sub">
                  <a href="{{route('index')}}" class="waves-effect"><i class="ti-pencil-alt"></i><span> Đánh giá khảo sát </span></a>
              </li>
              @endif
              @if (Sentinel::getUser()->type == 1)
              <!-- Giảng viên -->
              <li class="text-muted menu-title">Giảng viên</li>
              <li class="has_sub">
                  <a href="{{ route('index') }}" class="waves-effect"><i class="ti-bar-chart"></i> <span> Kết quả tổng hợp </span></a>
              </li>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="ti-view-list"></i> <span> Danh sách lớp môn học </span></a>
                <ul>
                  <li>
                    <a href="{{ route('detail-result', ['idClass' => 1]) }}" class="waves-effect"><span> INT2203 1 </span></a>
                  </li>
                  <li>
                    <a href="{{ route('detail-result', ['idClass' => 2]) }}" class="waves-effect"><span> INT2203 1 </span></a>
                  </li>
                </ul>
              </li>
              @endif
              @if (Sentinel::getUser()->type == 2)
              <li class="has_sub">
                  <a href="{{route('admin-user')}}" class="waves-effect"><i class="ti ti-home"></i> <span> Trang chủ </span></a>
              </li>
              <!-- Admin -->
                <li class="text-muted menu-title">Quản lý</li>

                <li class="has_sub">
                    <a href="{{route('admin-user')}}" class="waves-effect"><i class="ti-user"></i> <span> Tài khoản </span></a>
                </li>
                <li class="has_sub">
                    <a href="{{route('admin-survey-template')}}" class="waves-effect"><i class="ti-pencil-alt"></i><span>Mẫu phiếu khảo sát </span></a>
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
                @endif
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
