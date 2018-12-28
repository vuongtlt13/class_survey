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
    let res = "/search-class?";
    /** GET Keyword */
    let word = $('#keyword').val().trim();
    // console.log('word : ', word);

    // console.log('\n\n');
    word = 'word=' + word;

    res += createQuery([word]);
    // console.log('URL :', res);
    return res;
}

function changeCheckbox(obj) {
    // console.log('checkbox', obj);
    // console.log('start', $(obj).is(':checked'));
    var res = !$(obj).is(':checked');
    // console.log(res);
    $(obj).prop('checked', res);
    // console.log('end', $(obj).is(':checked'));
}

function validateForm() {
    $('#class_ids').val('');
    var str = "";

    $('#datatable tbody input:checked').each(function() {
        if (str != "") {
            str = str + "," + ($(this).attr('id')).split('-')[1];
        } else {
            str = str + ($(this).attr('id')).split('-')[1];
        }
    });

    $('#class_ids').val(str);
    return true;
}


function sendAction(url) {
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
                $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', data.msg);
                document.getElementById("checkbox-all").checked = false;
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

function importClass() {
    $('#btnUpload').trigger('click');
}

function extractInfo(rows) {
    var term = rows[4][0].split(' ')[5];
    var school_year = rows[4][0].split(' ')[2];
    var lecturer_code = rows[6][4];
    var class_code = rows[8][2];
    var subject_code = class_code.split(' ')[0];
    var subject_name = rows[9][2];
    var sotinchi = rows[8][5];
    var students = [];

    var index = 11;
    for (index; index < rows.length; index++) {
        var row = rows[index];
        if (Number.isInteger(row[0])) {
            students.push(row[1])
        }
    }
    return {
        'term': term,
        'school_year': school_year,
        'lecturer_code': lecturer_code,
        'subject_code': subject_code,
        'class_code': class_code,
        'students': students,
        'subject_name': subject_name,
        'sotinchi': sotinchi,
    }
}

function sendAjax(index, files, success, error) {
    if (index >= files.length) {
        if (error === 0) {
            $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', 'Tất cả lớp học thêm thành công!');
        } else {
            if (success === 0) {
                $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Thêm lớp học không thành công!');
            } else {
                $.Notification.autoHideNotify('warning', 'top right', 'Thao tác thành công!',
                    success.toString() + ' thành công, ' + error.toString() + ' thất bại!');
            }
        }
        // document.getElementById("import-progress").style.display="none";
        table.ajax.reload();
        return;
    }
    // console.log(files[index]);
    var file = files[index];
    var reader = new FileReader();
    reader.readAsArrayBuffer(file);
    reader.onload = function(e) {
        var data = new Uint8Array(reader.result);
        var wb = XLSX.read(data,{type:'array'});
        var sheet = wb.Sheets[wb.SheetNames[0]];
        var rows = XLSX.utils.sheet_to_json(sheet, {header:1});
        // console.log(rows);
        var postData=extractInfo(rows);
        // console.log(postData);
        $.ajax({
            url: '/import-class',
            type: 'post',
            data: postData,
            success: function (msg) {
                // console.log(msg);
                if (msg.status == 0) {
                    console.log(msg.msg);
                    error++;
                } else {
                    success++;
                }
                sendAjax(index + 1, files, success, error);

            },
            error: function (e) {
                console.log(e);
                error++;
                sendAjax(index + 1, files, success, error);
            }
        });
    };
}

function preview(class_id) {
    console.log('preview class', class_id);
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
            targets: -2,
            render: function (data, type, row) {
                // console.log(data);
                if (data == null) {
                    return '<span class="label label-danger"> Chưa tạo khảo sát</span>';
                } else {
                    return '<span class="label label-success"> Đã tạo khảo sát</span>';
                }
            }
        }],
        columns: [
            { data: "id", name: "id", orderable: false, width: "5%"},
            { data: "class_code", name: "class_code"},
            { data: "subject.name", name: "subject.name"},
            { data: "start_date", name: "start_date"},
            { data: "end_date", name: "end_date "},
            { data: "created_at", name: "created_at"},
            { data: "updated_at", name: "updated_at"},
            { data: "template_id", name: "template_id"},
            { data: "id", name: "id"},
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
                      $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', data.msg);
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
                preview(table.row($(row)).data().id);
            } else {
                var cb = $cell.find('[type=checkbox]');
                // console.log('checkbox', cb);
                changeCheckbox(cb);
            }
        }
    });
    
    $('#btnChange').on('click', function (evt) {
        $.ajax({
            url: '/getalltemplate',
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                // clean selectpicker
                var picker = $('#template_picker');
                picker.empty();
                for (var i in data) {
                    var template = data[i];
                    var option = '<option value="' + template.id + '">' + template.name + '</option>';
                    picker.append(option);
                }
                picker.selectpicker('refresh');
                $('#btnShowModal').trigger('click');
            },
            error: function (e) {
                console.log(e);
            }
        })    
    });
    
    $('#btnUpload').change(function () {
        if ($('#btnUpload')[0].files.length <= 0) return;
        // console.log($(this)[0].files);
        // console.log('after', $(this)[0].files);
        // $('#form-upload').submit();
        var files = $('#btnUpload')[0].files;
        // console.log(files);
        sendAjax(0, files, 0, 0);
    })
});
