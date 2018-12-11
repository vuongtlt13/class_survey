$(document).ready(function() {
  let table = $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: makeUrl(),
        error: function (err) {
            // console.log(makeUrl());
            console.log('Loi r', err);
        },
    },
    columnDefs: [ {
        targets: 0,
        render: function (data, type, row) {
            // console.log(data);
            return  '<div class="checkbox checkbox-primary">' +
                    '<input id="checkbox-' + data + '" type ="checkbox">' +
                    '<label for="checkbox-' + data + '">' +
                    '</label>' +
                '</div>';
        }
    },{
        targets: -1,
        render: function (data, type, row) {
            // console.log(data);
            return data == 1 ?
                '<span class="label label-success">Hoạt động</span>'
                :
                '<span class="label label-danger">Khóa</span>';
        }
    },
    {
        targets: -2,
        render: function (data, type, row) {
            // console.log(data);
            res = "Sinh viên";
            if (data = 2) {
                res = "Admin";
            }
            else if (data == 1){
                res = "Giảng viên";
            }

            return res;
            return '<span class="label label-success">' + res + '</span>';
        }
    }
  ],
    columns: [
        { data: "id", name: "id", orderable: false, width: "5%"},
        { data: "name", name: "name"},
        { data: "username", name: "username"},
        { data: "email", name: "email"},
        { data: "phone", name: "phone"},
        { data: "type", name: "type"},
        { data: "is_active", name: "is_active"},
    ],
    pageLength: 15,
    searching: false,
    lengthChange: false,
    language:{
        emptyTable:     "Không có dữ liệu trong bảng",
        info:           "Đang xem từ _START_ đến _END_ trong tổng số _TOTAL_",
        infoEmpty:      "",
        loadingRecords: "Đang tải...",
        processing:     "Đang lấy thông tin từ server...",
        paginate: {
            first:      "Trang đầu",
            last:       "Trang cuối",
            next:       "Sau",
            previous:   "Trước"
        }
    },
    order:[[1, 'desc']]
  });
});
