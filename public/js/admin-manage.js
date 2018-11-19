function getMinAge(ages) {
    if (ages === "Tất cả") return 0;
    let stringArray = ages.split(" ");
    //console.log(typeof stringArray, stringArray);

    if (stringArray.length === 2) {
        if (stringArray[0] === "<=") return 0;
        else return parseInt(stringArray[1]);
    }
    return parseInt(stringArray[0]);
}

function getMaxAge(ages) {
    if (ages === "Tất cả") return 100;
    let stringArray = ages.split(" ");
    //console.log(typeof stringArray, stringArray);

    if (stringArray.length === 2) {
        if (stringArray[0] === "<=") return parseInt(stringArray[1]);
        else return 100;
    }
    return parseInt(stringArray[2]);
}

function createQuery(params) {
    let res = "";
    params.forEach((query) => {
        if (res === "") res += query;
        else res += '&' + query;
    });
    return res;
}

function makeUrl() {
    let res = "/search?type=admin&";
    /** GET NAME */
    let name = $('#name').val().trim() === "" ? "all" : $('#name').val().trim();
    // console.log('name : ', name);

    /** GET GENDER */
    let gender = $('#gender').val().trim() === "Tất cả" ? "all" : $('#gender').val().trim();
    // console.log('gender : ', gender);

    /** GET MIN AGE AND MAX AGE */
    let ages = $('#age').val().trim();

    let minAge = getMinAge(ages);
    // console.log('Min age : ', minAge);
    let maxAge = getMaxAge(ages);
    // console.log('Max age : ', maxAge);

    // console.log('\n\n');
    name = 'name=' + name;
    gender = 'gender=' + gender;
    minAge = 'minage=' + minAge;
    maxAge = 'maxage=' + maxAge;

    res += createQuery([name, gender, minAge, maxAge]);
    // console.log('URL :', res);
    return res;
}

function showModal(data) {
    // console.log('Data: ', data);

    $('#name_info').text(data.name);
    $.ajax({
        url: '/getinfo?id=' + data.id,
        dataType: 'json',
        error: function () {
            console.log("Loi r");
        },
        success: function (data) {
            // console.log('admin-info:', data);
            $('#gender_age_info').text(data.gender + ' - ' + data.age + ' tuổi');
            $('#job_info').text(data.job);
            $('#company_info').text(data.workplace);

            $('#email_info').text(data.email);
            $('#phone_info').text(data.phone);

            $('#btnModal').trigger("click");
        }
    });
}

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
        targets: -2,
        render: function (data, type, row) {
            return data == 1 ?
                '<span class="label label-success">Hoạt động</span>'
                :
                '<span class="label label-danger">Khóa</span>';
        }
    }, {
        targets: -1,
        data: null,
        render: function ( data, type, row ) {
            // console.log(row);
            return  data == 1 ?
                '<button class="btnLock btn btn-danger waves-effect waves-light btn-xs">' +
                        'Lock ' +
                '</button> '
                :
                '<button class="btnUnlock btn btn-success waves-effect waves-light btn-xs">' +
                    'Active ' +
                '</button>';
        },
    }],
    columns: [
        { data: "id", name: "id", "visible": false},
        { data: "name", name: "name"},
        { data: "age", name: "age"},
        { data: "gender", name: "gender"},
        { data: "phone", name: "phone"},
        { data: "email", name: "email"},
        { data: "job", name: "job"},
        { data: "status"},
        { data: "status"},
    ],
    drawCallback: function() {
        // console.log('after');
        $.getScript('/js/admin-action.js', function () {
            // console.log('script loaded');
        });
    },
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
    order:[[0, 'desc']]
});

$(document).ready(function () {
    $('#btnSearch').on('click', function (e) {
        e.preventDefault();
        // console.log("Tim kiem lai");
        let url = makeUrl();
        table.ajax.url(url).load();
    });

    $('#datatable tbody').on('click', 'tr td:not(:last-child)', function () {
        // console.log($(this));
        let row = $(this).closest('tr');
        // console.log('click to row with course_id: ', table.row($(row)).data().id);
        showModal(table.row($(row)).data());
    });
});