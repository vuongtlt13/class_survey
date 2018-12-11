function doAjax(e) {
    let dataRow = table.row($(e.target.closest('tr'))).data();
    // console.log('run ajax', dataRow);
    $.ajax({
        url: '/admin-manage/changestatus',
        type: 'post',
        data: {
            adminId: dataRow.id,
        },
        dataType:'json',
        error: function (e) {
            console.log('loi r', e);
        },
        success: function (data) {
            // console.log('thanh cong', typeof data, data);
            // console.log('status', data.status);
            dataRow.status = data.status;

            let actionTd = $(e.target.closest('td'));
            actionTd.empty();

            if (data.status == 0) {
                actionTd.append('<button class="btnLock btn btn-danger waves-effect waves-light btn-xs">' +
                    'Lock ' +
                    '</button> ');
            } else {
                actionTd.append('<button class="btnUnlock btn btn-success waves-effect waves-light btn-xs">' +
                    'Active ' +
                    '</button>');
            }
            /** **/
            let statusTd = actionTd.prevAll('td:first');
            statusTd.empty();
            if (data.status == 0) {
                statusTd.append('<span class="label label-success">Hoạt động</span>');
            } else {
                statusTd.append('<span class="label label-danger">Khóa</span>');
            }

            $.getScript('/js/admin-user-ajax.js', function () {
                // console.log('script loaded');
            });
        }
    });
}

$('.btnLock').on('click', function (e) {
    doAjax(e);
});

$('.btnUnlock').on('click', function (e) {
    doAjax(e);
});

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

function changeToUpdateForm() {
  $('#form-title').text('Sửa tài khoản');
  $('#myform').attr("action",  "/update-user");
  $('#btnSubmit').text('Cập nhật');
  // change two combobox
}

function changeCheckbox(obj) {
    // console.log('checkbox', obj);
    // console.log('start', $(obj).is(':checked'));
    var res = !$(obj).is(':checked');
    // console.log(res);
    $(obj).prop('checked', res);
    // console.log('end', $(obj).is(':checked'));
}

$(document).ready(function () {
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
          $('#myform').submit();
        }
    });

    $('#checkbox-all').on('click', function (evt) {
        var checked = $(evt.target).is(':checked');
        // console.log(checked);
        var table= $(evt.target).closest('table');
        $('td input:checkbox',table).prop('checked', checked);
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
});
