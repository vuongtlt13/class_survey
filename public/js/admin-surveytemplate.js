var template_table;
var length_text = 30;

function showModal(data_row) {
    // console.log('Data: ', data);
    changeToUpdateForm(data_row.id);
    $('#template').val(data_row.name);
    $('#btnTemplateShowModal').trigger("click");
}

function changeToAdditionForm() {
    $('#form-template').text('Tạo mẫu mới');
    $('#template-form').attr("action",  "/create-template");
    $('#template').val('');

    $('#template-form #btnSubmit').text('Tạo');
}

function changeToUpdateForm(id) {
    $('#form-template').text('Sửa tiêu đề');
    $('#template-form').attr("action",  "/update-template?id=" + id);
    // $('#template').val('');

    $('#template-form #btnSubmit').text('Cập nhật');
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
    // validate content
    var template = $('#template').val().trim();
    if (template === '') {
        document.getElementById("template-error").style.display="block";
        return false;
    } else {
        $('#template').val(template);
        document.getElementById("template-error").style.display="none";
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

function setDefault(evt) {
    // console.log(evt.target.nodeName);
    if (evt.target.nodeName === 'SPAN') return;
    // console.log('btn clicked');
    var row = $(evt.target).closest('tr');
    var data_row = template_table.row($(row)).data();
    $.ajax({
        url: '/set-default',
        type: 'post',
        data: {
            id: data_row.id,
        },
        success: function (data) {
            // console.log(data);
            if (data.status == 0) {
                $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', data.msg);
            } else {
                $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', data.msg);
                template_table.ajax.reload();
            }
        },
        error: function (e) {
            // console.log('loi r', e);
            $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Lỗi từ chối từ server!');
        }
    });
}

function loadTemplate(template_id, template_name) {
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
            $(".name_template").text(template_name);
            $(".name_template").attr('id', template_id);
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
                    '<span class="removable-question"><i style="color: red; padding-left: 5px" class="ion-close"></i></span></td>\n' +
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

function preview_template(evt) {
    var row = $(evt.target).closest('tr');
    var data_row = template_table.row($(row)).data();
    // get info of template
    loadTemplate(data_row.id, data_row.name);
}

function sendRemove(template_id, question_id, parent, template_name) {
    $.ajax({
        url: '/remove-question',
        type: 'post',
        data: {
            template_id: template_id,
            question_id: question_id,
        },
        success: function (data) {
            loadTemplate(template_id, template_name);
        },
        error: function (e) {
            console.log(e);
            loadTemplate(template_id, template_name);
        }
    })
}

function loadQuestion(template_id) {
    $.ajax({
        url: '/load-question?id=' + template_id,
        success: function (data) {
            // console.log(data);
            //remove old questions
            var selected_questions = $('#selected_questions');
            selected_questions.empty();
            selected_questions.multiSelect('refresh');
            // add options
            var oldTille = -1;

            for (var index in data) {
                var question = data[index];
                // console.log(question);
                if (question.title.id !== oldTille) {
                    // create new optgroup
                    var optgroup = '<optgroup id="optgroup-' + question.title.id + '" label="' + question.title.content + '"></optgroup>';
                    selected_questions.append(optgroup);
                    oldTille = question.title.id;
                }
                var last_optgroup = $('#optgroup-' + question.title.id);
                // create new option
                var option = '<option value="' + question.id + '">' + question.content + '</option>'
                last_optgroup.append(option);
            }
            selected_questions.multiSelect('refresh');
            $('#btnShowModal').trigger('click');
        },
        error: function (e) {
            console.log(e);
            return;
        }
    });
}

$(document).ready(function () {
    // template
    template_table = $('#template-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/get-template',
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
                    '<input id="template_checkbox-' + data + '" type ="checkbox">' +
                    '<label for="template_checkbox-' + data + '">' +
                    '</label>' +
                    '</div>';
            }
        },
        {
            targets: 1,
            render: function (data, type, row) {
                // console.log(data);
                if (data.length > length_text) {
                    return data.substring(0, length_text) + "...";
                }
                return data;
            }
        },
        {
            targets: 2,
            render: function (data, type, row) {
                if (data === 0) {
                    return '<button class="btn btn-icon waves-effect waves-light btn-primary w-xs"> Đặt mặc định </button>';
                }
                else return '<span class="label label-success">Mặc định</span>';
            }
        },
        {
            targets: 3,
            render: function (data, type, row) {
                return '<i style="font-size: 20px;" class="fa fa-eye"></i>';
            }
        }],
        columns: [
            { data: "id", name: "id", orderable: false, width: "5%"},
            { data: "name", name: "name", width: "50%"},
            { data: "is_default", name: "is_default"},
            { data: "id", name: "id"},
        ],
        pageLength: 15,
        searching: true,
        searchDelay: 400,
        lengthChange: false,
        language:{
            emptyTable:     "Không có dữ liệu trong bảng",
            info:           "_START_ đến _END_ trong tổng số _TOTAL_",
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

    $('#btnTemplateAdd').click(function (e) {
        // console.log('clicked');
        changeToAdditionForm();
        $('#btnTemplateShowModal').trigger("click");
    });

    $('#template-datatable thead tr').on('click', function (evt) {
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

    $('#template-datatable tbody').on('click', "tr", function (evt) {
        var obj = evt.target;
        // console.log('target:', obj);
        // console.log('attr:', $(obj).is(':checkbox'));

        if (!$(obj).is(':checkbox')) {
            var $cell=$(obj).closest('td');
            // console.log('td', $cell);
            if ($cell.index()>0){
                if ($cell.index() === 1) {
                    var row = $($cell).closest('tr');
                    // console.log('click to row with course_id: ', table.row($(row)).data().id);
                    showModal(template_table.row($(row)).data());
                } else if ($cell.index() === 2) {
                    setDefault(evt);
                } else if ($cell.index() === 3) {
                    preview_template(evt);
                }
            } else {
                var cb = $cell.find('[type=checkbox]');
                // console.log('checkbox', cb);
                changeCheckbox(cb);
            }
        }
    });

    $("#template-form").submit(function (e) {
        e.preventDefault();
        $('#template-form #btnSubmit').trigger('click');
    });

    $('#template-form #btnSubmit').on('click', function (e) {
        e.preventDefault();
        // Validate input
        if (validateForm('template')) {
            $('#template-form #btnHideModal').trigger('click');
            // $('#template-form').submit();
            $('#template-form').ajaxSubmit({
                url: $('#template-form').attr('action'),
                type: 'post',
                success: function (data) {
                    // console.log(data);
                    if (data.status == 0) {
                        $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', data.msg);
                    } else {
                        $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!','Đã tạo/sửa mẫu khảo sát thành công');
                        template_table.ajax.reload();
                    }
                },
                error: function (e) {
                    // console.log('loi r', e);
                    $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Lỗi từ chối từ server!');
                }
            });
        }
    });

    $('#btnTemplateDelete').on('click', function () {
        $('#template-selected_id').val('');
        var str = "";

        $('#template-datatable tbody input:checked').each(function() {
            if (str !== "") {
                str = str + "," + ($(this).attr('id')).split('-')[1];
            } else {
                str = str + ($(this).attr('id')).split('-')[1];
            }
        });

        $('#template-selected_id').val(str);
        // $('#template-select-form').submit();
        $('#template-select-form').ajaxSubmit({
            url: $('#template-select-form').attr('action'),
            type: 'post',
            success: function (data) {
                // console.log(data);
                if (data.status == 1) {
                    $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', 'Đã xóa tiêu đề thành công!');
                    document.getElementById("template-checkbox-all").checked = false;
                    template_table.ajax.reload();
                } else {
                    // console.log(data);
                    $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', data.msg);
                }
            },
            error: function (e) {
                console.log(e);
                $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', e);
            }
        });
    });

    $('#template-checkbox-all').change(function (evt){
        // console.log(evt.target);
        var checked = $(this).is(':checked');
        // console.log(checked);
        var table= $(this).closest('table');
        $('td input:checkbox', table).prop('checked', checked);
    });

    $('#template-checkbox-all').on('click', function () {
        changeCheckbox(this);
    });

    //all
    $('.dataTables_filter').addClass('my-search');
    $('.survey_content').on('click', 'span.removable-question', function (evt) {
        // console.log(evt.target);
        // console.log($(this).closest('td').attr('id'));
        var current_template = $(".name_template").attr('id');
        var template_name = $(".name_template").text();
        // console.log('template', current_template, 'question', $(this).closest('td').attr('id'));
        sendRemove(current_template, $(this).closest('td').attr('id'), evt.target, template_name);
    });

    $('#btnAddQuestion').on('click', function (evt) {
        var current_template = $(".name_template").attr('id');
        loadQuestion(current_template);
    });

    $('#question-form #btnSubmit').on('click', function (evt) {
        // console.log('submit');
        var values = $('#selected_questions').val();
        console.log(values);
        var current_template = $(".name_template").attr('id');
        var template_name = $(".name_template").text();
        // $('#question-form').submit();
        $.ajax({
            url: $('#question-form').attr('action'),
            type: 'post',
            data: {
                template_id: current_template,
                selected_questions: values,
            },
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                if (data.status == 0) {
                    $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', data.msg);
                } else {
                    $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', data.msg);
                    loadTemplate(current_template, template_name);
                }
                $('#question-form #btnHideModal').trigger('click');
            },
            error: function (e) {
                console.log('loi r', e);
                $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Lỗi từ chối từ server!');
                $('#question-form #btnHideModal').trigger('click');
            }
        });
    });
});
