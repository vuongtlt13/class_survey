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

function get_selected_classes() {
    $('#class_ids').val('');
    var class_ids = [];

    $('#datatable tbody input:checked').each(function() {
        class_ids.push(($(this).attr('id')).split('-')[1]);
    });

    return class_ids;
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
                console.log(data.msg);
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

function generate_template(index, class_ids, success, error) {
    if (index >= class_ids.length) {
        // console.log(success, error);
        if (error === 0) {
            $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', 'Generate khảo sát thành công!');
        } else {
            if (success === 0) {
                $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Generate khảo sát thất bại!');
            } else {
                $.Notification.autoHideNotify('warning', 'top right', 'Thao tác thành công!',
                    success.toString() + ' thành công, ' + error.toString() + ' thất bại!');
            }
        }
        document.getElementById("import-progress").style.display="none";
        document.getElementById("checkbox-all").checked = false;
        table.ajax.reload();
        return;
    }
    var class_id = class_ids[index];
    $('#class_ids').val(class_id);
    // $('#myform').submit();
    $.ajax({
        url: '/generate-class',
        type: 'post',
        data: {
            'selected_id': class_id,
        },
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            if (data.status == 1) {
                success++;
            } else {
                error++;
                // console.log(data.msg);
            }
            var progress = $('#progress_value');
            var current_val = progress.attr('aria-valuenow');
            current_val++;
            progress.attr('aria-valuenow', current_val);
            var percent = progress.attr('aria-valuenow') / progress.attr('aria-valuemax') * 100;
            progress.css('width', Math.floor(percent).toString() + '%');
            $('#progress-info').text((progress.attr('aria-valuenow')).toString() + '/' + (progress.attr('aria-valuemax')).toString());
            generate_template(index + 1, class_ids, success, error);
        },
        error: function (e) {
            // console.log(e);
            error++;
            var progress = $('#progress_value');
            var current_val = progress.attr('aria-valuenow');
            current_val++;
            progress.attr('aria-valuenow', current_val);
            var percent = progress.attr('aria-valuenow') / progress.attr('aria-valuemax') * 100;
            progress.css('width', Math.floor(percent).toString() + '%');
            $('#progress-info').text((progress.attr('aria-valuenow')).toString() + '/' + (progress.attr('aria-valuemax')).toString());
            generate_template(index + 1, class_ids, success, error);
        }
    });
}

function generateTemplate(type) {
    if (type == 'selected')  {
        var class_ids = get_selected_classes();
        var progress = $('#progress_value');
        progress.attr('aria-valuemax', class_ids.length);
        progress.attr('aria-valuenow', 0);
        progress.css('width', '0%');
        $('#progress-info').text((progress.attr('aria-valuenow')).toString() + '/' + (progress.attr('aria-valuemax')).toString());
        document.getElementById("import-progress").style.display="block";
        $.Notification.autoHideNotify('success', 'top right', 'Đang generate khảo sát...', 'Vui lòng đợi!');
        generate_template(0, class_ids, 0, 0);
    } else if (type == 'all') {
        $.ajax({
            url: '/getallclasses',
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                var class_ids = [];
                for (var i in data) {
                    class_ids.push(data[i].id);
                }
                // console.log(class_ids);
                var progress = $('#progress_value');
                progress.attr('aria-valuemax', class_ids.length);
                progress.attr('aria-valuenow', 0);
                progress.css('width', '0%');
                $('#progress-info').text((progress.attr('aria-valuenow')).toString() + '/' + (progress.attr('aria-valuemax')).toString());
                document.getElementById("import-progress").style.display="block";
                $.Notification.autoHideNotify('success', 'top right', 'Đang generate khảo sát...', 'Vui lòng đợi!');
                generate_template(0, class_ids, 0, 0);
            },
            error: function (e) {
                $.Notification.autoHideNotify('error', 'top right', 'Thao tác thất bại!',
                    'Không thể lấy danh sách lớp học');
            }
        });
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
        document.getElementById("import-progress").style.display="none";
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

                var progress = $('#progress_value');
                var current_val = progress.attr('aria-valuenow');
                current_val++;
                progress.attr('aria-valuenow', current_val);
                var percent = progress.attr('aria-valuenow') / progress.attr('aria-valuemax') * 100;
                progress.css('width', Math.floor(percent).toString() + '%');
                $('#progress-info').text((progress.attr('aria-valuenow')).toString() + '/' + (progress.attr('aria-valuemax')).toString());
                sendAjax(index + 1, files, success, error);

            },
            error: function (e) {
                console.log(e);
                error++;
                var progress = $('#progress_value');
                var current_val = progress.attr('aria-valuenow');
                current_val++;
                progress.attr('aria-valuenow', current_val);
                var percent = progress.attr('aria-valuenow') / progress.attr('aria-valuemax') * 100;
                progress.css('width', Math.floor(percent).toString() + '%');
                $('#progress-info').text((progress.attr('aria-valuenow')).toString() + '/' + (progress.attr('aria-valuemax')).toString());
                sendAjax(index + 1, files, success, error);
            }
        });
    };
}

function loadTemplate(template_id, class_name) {
    $.ajax({
        url: '/load-template?id=' + template_id,
        dataType: 'json',
        success: function (data) {
            var survey_content = $('.survey_content');
            // remove old view
            survey_content.empty();
            // draw preview
            // console.log(data);
            var oldTitle = -1;
            $(".subject_name").text(class_name);
            $(".subject_name").attr('id', template_id);
            for (var index in data) {
                // console.log(data[index]);
                var question = data[index];
                if (question.title.id !== oldTitle) {
                    // create new single content div
                    var single_content = '<div id="content_' + question.title.id + '" class="row single_content"></div>';
                    survey_content.append(single_content);
                    single_content = $('#content_' + question.title.id);
                    // console.log(single_content);
                    // add title area
                    var title_area = '<div class="" style="padding-left: 10px">\n' +
                        '                 <h4 id="' + question.title.id + '"><span style="color: red;">* </span>' + question.title.content + '</h4>\n' +
                        '            </div>';
                    single_content.append(title_area);

                    // add question area
                    var question_area = '<div class="question_area" style="padding-left: 20px">\n' +
                        '                                            <table class="table table-bordered">\n' +
                        '                                                <colgroup>\n' +
                        '    <col style="width:60%">\n' +
                        '    <col style="width:8%">\n' +
                        '    <col style="width:8%">\n' +
                        '    <col style="width:8%">\n' +
                        '    <col style="width:8%">\n' +
                        '    <col style="width:8%">\n' +
                        '  </colgroup><thead>\n' +
                        '                                                <th></th>\n' +
                        '                                                <th>1</th>\n' +
                        '                                                <th>2</th>\n' +
                        '                                                <th>3</th>\n' +
                        '                                                <th>4</th>\n' +
                        '                                                <th>5</th>\n' +
                        '                                                </thead>\n' +
                        '                                                <tbody>\n' +
                        '                                                </tbody>\n' +
                        '                                            </table>\n' +
                        '                                            <br>\n' +
                        '                                        </div>';
                    single_content.append(question_area);
                    // update oldTitle
                    oldTitle = question.title.id;
                }

                single_content = $('#content_' + question.title.id);
                var tbody_table = single_content.find('.question_area table tbody');
                // console.log(tbody_table[0]);
                // add question to tbody
                var new_tr = '<tr>\n' +
                    '                                                    <td class="white-space-normal" id="' + question.id + '">' + question.content +
                    '                                                    <td class="white-space-normal"><input type="radio" name="rate"/></td>\n' +
                    '                                                    <td class="white-space-normal"><input type="radio" name="rate"/></td>\n' +
                    '                                                    <td class="white-space-normal"><input type="radio" name="rate"/></td>\n' +
                    '                                                    <td class="white-space-normal"><input type="radio" name="rate"/></td>\n' +
                    '                                                    <td class="white-space-normal"><input type="radio" name="rate"/></td>\n' +
                    '                                                </tr>';
                tbody_table.append(new_tr);
            }
            // show preview
            document.getElementById("content_area").style.display="block";
        },
        error: function (e) {
            // console.log('loi r', e);
            $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Lỗi từ chối từ server!');
        }
    });
}

function preview(data) {
    // console.log(data);
    // console.log('preview class', class_id);
    loadTemplate(data.template_id, data.subject.name);
    $('#btnPreviewClass').trigger('click');

}

function generate_class(index, class_ids, success, error) {
    if (index >= class_ids.length) {
        // console.log(success, error);
        if (error === 0) {
            $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', 'Generate khảo sát thành công!');
        } else {
            if (success === 0) {
                $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Generate khảo sát thất bại!');
            } else {
                $.Notification.autoHideNotify('warning', 'top right', 'Thao tác thành công!',
                    success.toString() + ' thành công, ' + error.toString() + ' thất bại!');
            }
        }
        document.getElementById("import-progress").style.display="none";
        table.ajax.reload();
        return;
    }
    var class_id = class_ids[index];
    $('#class_ids').val(class_id);
    // $('#myform').submit();
    $('#myform').ajaxSubmit({
        url: $('#myform').attr('action'),
        type: 'post',
        success: function (data) {
            // console.log(data);
            if (data.status == 1) {
                success++;
            } else {
                error++;
                console.log(data.msg);
            }
            var progress = $('#progress_value');
            var current_val = progress.attr('aria-valuenow');
            current_val++;
            progress.attr('aria-valuenow', current_val);
            var percent = progress.attr('aria-valuenow') / progress.attr('aria-valuemax') * 100;
            progress.css('width', Math.floor(percent).toString() + '%');
            $('#progress-info').text((progress.attr('aria-valuenow')).toString() + '/' + (progress.attr('aria-valuemax')).toString());
            generate_class(index + 1, class_ids, success, error);
        },
        error: function (e) {
            error++;
            console.log(e);
            var progress = $('#progress_value');
            var current_val = progress.attr('aria-valuenow');
            current_val++;
            progress.attr('aria-valuenow', current_val);
            var percent = progress.attr('aria-valuenow') / progress.attr('aria-valuemax') * 100;
            progress.css('width', Math.floor(percent).toString() + '%');
            $('#progress-info').text((progress.attr('aria-valuenow')).toString() + '/' + (progress.attr('aria-valuemax')).toString());
            generate_class(index + 1, class_ids, success, error);
        }
    });
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
            { data: "created_at", name: "created_at"},
            { data: "updated_at", name: "updated_at"},
            { data: "template_id", name: "template_id"},
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
        var class_ids = get_selected_classes();
        $('#btnHideModal').trigger('click');
        var progress = $('#progress_value');
        progress.attr('aria-valuemax', class_ids.length);
        progress.attr('aria-valuenow', 0);
        progress.css('width', '0%');
        $('#progress-info').text((progress.attr('aria-valuenow')).toString() + '/' + (progress.attr('aria-valuemax')).toString());
        document.getElementById("import-progress").style.display="block";
        generate_class(0, class_ids, 0, 0);
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
                preview(table.row($(row)).data());
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
        var progress = $('#progress_value');
        progress.attr('aria-valuemax', files.length);
        progress.attr('aria-valuenow', 0);
        progress.css('width', '0%');
        $('#progress-info').text((progress.attr('aria-valuenow')).toString() + '/' + (progress.attr('aria-valuemax')).toString());
        document.getElementById("import-progress").style.display="block";
        sendAjax(0, files, 0, 0);
    })

    $('#keyword').on("keyup", function(evt) {
        // console.log($(this).val());
        $('#btnSearch').trigger('click');
    });
});
