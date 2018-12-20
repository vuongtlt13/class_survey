var table;

function createQuery(params) {
    let res = "";
    params.forEach((query) => {
        if (res === "") res += query;
        else res += '&' + query;
    });
    return res;
}

function makeUrl() {
    let res = "/search-user?";
    /** GET NAME */
    let word = $('#keyword').val().trim();
    // console.log('name : ', name);

    /** GET Account type */
    let account_type = $('#account_type').val().trim() === "Tất cả" ? "all" : $('#account_type').val().trim();
    // console.log('Account type : ', account_type);

    /** GET GENDER */
    let gender = $('#gender').val().trim() === "Tất cả" ? "all" : $('#gender').val().trim();
    // console.log('gender : ', gender);

    // console.log('\n\n');
    word = 'word=' + word;
    gender = 'gender=' + gender;
    account_type = 'type=' + account_type;

    res += createQuery([word, gender, account_type]);
    // console.log('URL :', res);
    return res;
}

function showModal(data) {
    changeToUpdateForm(data.id);
    // console.log('Data: ', data);
    $('#username').val(data.username);
    $('#name').val(data.name);
    $('#email').val(data.email);
    $('#phone').val(data.phone);
    $('#address').val(data.address);
    // console.log(data.gender, data.type);
    if (data.gender == null) {
        $('select[name=gender]').val("");
    }
    else {
        $('select[name=gender]').val(data.gender);
    }
    $('select[name=account_type]').val(data.type);
    $('.selectpicker').selectpicker('refresh');

    $('#btnShowModal').trigger("click");
}

function changeToAdditionForm() {
  $('#form-title').text('Tạo tài khoản');
  $('#myform').attr("action",  "/create-user");
  $('#username').val('');
  $('#name').val('');
  $('#email').val('');
  $('#phone').val('');
  $('#address').val('');
  $('#btnSubmit').text('Tạo');
  // change two combobox
}

function changeToUpdateForm(id) {
    $('#form-title').text('Sửa tài khoản');
    $('#myform').attr("action",  "/update-user?id=" + id);
    $('#btnSubmit').text('Cập nhật');
}

function changeCheckbox(obj) {
    // console.log('checkbox', obj);
    // console.log('start', $(obj).is(':checked'));
    var res = !$(obj).is(':checked');
    // console.log(res);
    $(obj).prop('checked', res);
    // console.log('end', $(obj).is(':checked'));
}

function validateUsername(username) {
    var illegalChars = /\W/; // allow letters, numbers, and underscores

    if (username === "") {
        $('#username-error').text("Bạn chưa nhập tên đăng nhập");
        return false;

    } else if (username.length > 20 || username.length < 4) {
        $('#username-error').text("Độ dài tên đăng nhập không hợp lệ(từ 5-20 kí tự)");
        return false;

    } else if (illegalChars.test(username)) {
        $('#username-error').text("Tên đăng nhập chứa kí tự không hợp lệ");
        return false;

    }
    return true;
}
function validatePhoneNumber(phone) {
    var stripped = phone.replace(/[\(\)\.\-\ ]/g, '');
    if (phone.length == 0) {
        return true;
    }
    else if (isNaN(parseInt(stripped))) {
        $('#phone-error').text("Số điện thoại chứa kí tự không hợp lệ");
        return false;
    } else if (!(stripped.length == 10)) {
        $('#phone-error').text("Số điện thoại không hợp lệ");
        return false;
    }
    return true;
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (email.length == 0) {
        return true;
    } else if (!re.test(String(email).toLowerCase())) {
        $('#email-error').text("Email không hợp lệ");
        return false;
    }
    return true;
}

function validateForm() {
    // validate user
    var username = $('#username').val().trim();
    if (validateUsername(username)) {
        $('#username').val(username);
        document.getElementById("username-error").style.display="none";
    } else {
        document.getElementById("username-error").style.display="block";
        return false;
    }
    // validate phone
    var phone = $('#phone').val().trim();
    if (validatePhoneNumber(phone)) {
        $('#phone').val(phone);
        document.getElementById("phone-error").style.display="none";
    } else {
        document.getElementById("phone-error").style.display="block";
        return false;
    }
    // validate email
    var email = $('#email').val().trim().toLowerCase();
    if (validateEmail(email)) {
        $('#email').val(email);
        document.getElementById("email-error").style.display="none";
    } else {
        document.getElementById("email-error").style.display="block";
        return false;
    }
    return true;
}


function sendAction(url, msg) {
    // $('#select-form').attr("action", url);
    $('#selected_id').val('');
    var str = "";

    $('#datatable tbody input:checked').each(function() {
        if (str != "") {
            str = str + "," + ($(this).attr('id')).split('-')[1];
        } else {
            str = str + ($(this).attr('id')).split('-')[1];
        }
    });

    $('#selected_id').val(str);

    $('#select-form').ajaxSubmit({
        url: url,
        type: 'post',
        success: function (data) {
            // console.log(data);
            if (data.status == 1) {
                // console.log('dang ky thanh cong');
                $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', msg);
                table.ajax.reload();
            } else {
                // console.log(data);
                $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', data.msg);
            }
        },
        error: function (e) {
            console.log('loi r', e);
        }
    });
}

function importUser(url) {
    // if ($('#btnUpload')[0].files.length > 0) {
    //     console.log('before', $('#btnUpload')[0].files);
    // } else {
    //     console.log('before', 'nothing');
    // }
    // clear input
    $('#form-upload').attr("action", url);
    // $('#btnUpload').empty();
    $('#btnUpload').trigger('click');
}

$(document).ready(function () {
    table = $('#datatable').DataTable({
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
                    if (data == 2) {
                        res = "Admin";
                    }
                    else if (data == 1){
                        res = "Giảng viên";
                    }

                    return res;
                    // return '<span class="label label-success">' + res + '</span>';
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

    $('#btnSearch').on('click', function (e) {
        e.preventDefault();
        // console.log("Tim kiem lai");
        let url = makeUrl();
        var table = $('#datatable').DataTable();
        table.ajax.url(url).load();
    });

    $('#btnAdd').click(function (e) {
        // console.log('clicked');
        changeToAdditionForm();
        $('#btnShowModal').trigger("click");
    });

    $('#btnSubmit').on('click', function (e) {
        // Validate input
        if (validateForm()) {
            $('#btnHideModal').trigger('click');
            // $('#myform').submit();
            $('#myform').ajaxSubmit({
              url: $('#myform').attr('action'),
              type: 'post',
              success: function (data) {
                  // console.log(data);
                  if (data.status == 0) {
                      // console.log('dang ky khong thanh cong');
                      $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', data.msg);
                  } else {
                      // console.log('dang ky thanh cong');
                      $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!','Đã tạo/sửa tài khoản thành công');
                      table.ajax.reload();
                  }
              },
              error: function (e) {
                  // console.log('loi r', e);
                  $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Lỗi từ chối từ server!');
              }
            });
        }
    });

    $('#checkbox-all').change(function (evt){
        // console.log(evt.target);
        var checked = $(this).is(':checked');
        // console.log(checked);
        var table= $(this).closest('table');
        $('td input:checkbox', table).prop('checked', checked);
    });

    $('#checkbox-all').on('click', function () {
        changeCheckbox(this);
    });

    $('#datatable thead tr').on('click', function (evt) {
      var obj = evt.target;
      // console.log('target:', obj);
      // console.log('attr:', $(obj).is(':checkbox'));
      if (!$(obj).is(':checkbox')) {
          var $cell=$(obj).closest('th');
          // console.log('td', $cell);
          if( $cell.index()>0){
          } else {
              var cb = $cell.find('[type=checkbox]');
              // console.log('checkbox', cb);
              changeCheckbox(cb);
              var checked = $(cb).is(':checked');
              // console.log(checked);
              var table= $(cb).closest('table');
              $('td input:checkbox', table).prop('checked', checked);
          }
      }
    });

    $('#datatable tbody').on('click', "tr", function (evt) {
        var obj = evt.target;
        // console.log('target:', obj);
        // console.log('attr:', $(obj).is(':checkbox'));

        if (!$(obj).is(':checkbox')) {
            var $cell=$(obj).closest('td');
            // console.log('td', $cell);
            if( $cell.index()>0){
                var row = $($cell).closest('tr');
                // console.log('click to row with course_id: ', table.row($(row)).data().id);
                var table = $('#datatable').DataTable();
                showModal(table.row($(row)).data());
            } else {
                var cb = $cell.find('[type=checkbox]');
                // console.log('checkbox', cb);
                changeCheckbox(cb);
            }
        }
    });

    $('#btnUpload').change(function () {
        if ($('#btnUpload')[0].files.length <= 0) return;
        // console.log($(this)[0].files);
        // console.log('after', $(this)[0].files);
        // $('#form-upload').submit();
        $('#form-upload').ajaxSubmit({
            url: $('#form-upload').attr('action'),
            type: 'post',
            beforeSend: function () {
                $.Notification.autoHideNotify('success', 'top right', 'Đang import dữ liệu...', 'Vui lòng chờ ít phút!', 3000000);
            },
            success: function (data) {
                // console.log(data);
                if (data.status == 0) {
                    // console.log('dang ky khong thanh cong');
                    $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', data.msg);
                    // console.log($("div:contains('Đang import dữ liệu...')"));
                    $("div:contains('Đang import dữ liệu...')")[1].remove();
                } else if (data.status == 1) {
                    // console.log('dang ky thanh cong');
                    $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', data.msg);
                    $("div:contains('Đang import dữ liệu...')")[1].remove();
                    table.ajax.reload();
                } else {
                    $.Notification.autoHideNotify('warning', 'top right', 'Thao tác thành công!', data.msg);
                    $("div:contains('Đang import dữ liệu...')")[1].remove();
                    table.ajax.reload();
                }
                $("#btnUpload").replaceWith($("#btnUpload").val('').clone(true));
                // console.log($('#btnUpload')[0].files.length);
            },
            error: function (e) {
                // console.log('loi r', e);
                $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Lỗi từ chối từ server!');
                $("#btnUpload").replaceWith($("#btnUpload").val('').clone(true));
                // console.log($('#btnUpload')[0].files.length);
            }
        });
    })
});
