var title_table;
var question_table;
var length_text = 30;
// function createQuery(params) {
//     let res = "";
//     params.forEach((query) => {
//         if (res === "") res += query;
//         else res += '&' + query;
//     });
//     return res;
// }
//
// function makeUrl() {
//     let res = "/search-user?";
//     /** GET NAME */
//     let word = $('#keyword').val().trim();
//     // console.log('name : ', name);
//
//     /** GET Account type */
//     let account_type = $('#account_type').val().trim() === "Tất cả" ? "all" : $('#account_type').val().trim();
//     // console.log('Account type : ', account_type);
//
//     /** GET GENDER */
//     let gender = $('#gender').val().trim() === "Tất cả" ? "all" : $('#gender').val().trim();
//     // console.log('gender : ', gender);
//
//     // console.log('\n\n');
//     word = 'word=' + word;
//     gender = 'gender=' + gender;
//     account_type = 'type=' + account_type;
//
//     res += createQuery([word, gender, account_type]);
//     // console.log('URL :', res);
//     return res;
// }

function showModal(data_row, type) {
    // console.log('Data: ', data);
    changeToUpdateForm(data_row.id, type);
    if (type === 'title') {
        $('#title').val(data_row.content);
        $('#btnTitleShowModal').trigger("click");
    } else {
        $('#question').val(data_row.content);
        $.ajax({
            url: "/loadtitle",
            beforeSend: function () {
                $.Notification.autoHideNotify('success', 'top right', 'Đang tải dữ liệu...', 'Vui lòng chờ ít phút!', 3000000);
            },
            success: function (data) {
                $("div:contains('Đang tải dữ liệu...')")[1].remove();

                $('#prevew_title').empty();
                $('#prevew_title').append('<option value="">Hãy chọn tiêu đề</option>');
                var index;
                for (index in data) {
                    var record = data[index];
                    // console.log(record);
                    $('#prevew_title').append('<option value="' + record.id + '">' + record.content + '</option>')
                }
                $('.selectpicker').selectpicker('refresh');
                $('#prevew_title').val(data_row.title.id);
                $('.selectpicker').selectpicker('render');
                $('#btnQuestionShowModal').trigger("click");
            },
            error: function (e) {
                // console.log(e);
                $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', e);
                $("div:contains('Đang tải dữ liệu...')")[1].remove();
            }
        });

    }
}

function changeToAdditionForm(type) {
    if (type === 'title') {
        $('#form-title').text('Tạo tiêu đề mới');
        $('#title-form').attr("action",  "/create-title");
        $('#title').val('');

        $('#title-form #btnSubmit').text('Tạo');
    } else {
        $('#form-title').text('Tạo câu hỏi mới');
        $('#question-form').attr("action",  "/create-question");
        $('#question').val('');

        $('#question-form #btnSubmit').text('Tạo');
    }
}

function changeToUpdateForm(id, type) {
    if (type === 'title') {
        $('#form-title').text('Sửa tiêu đề');
        $('#title-form').attr("action",  "/update-title?id=" + id);
        // $('#title').val('');

        $('#title-form #btnSubmit').text('Cập nhật');
    } else {
        $('#form-title').text('Sửa câu hỏi');
        $('#question-form').attr("action",  "/update-question?id=" + id);
        // $('#question').val('');

        $('#question-form #btnSubmit').text('Cập nhật');
    }
}

function changeCheckbox(obj) {
    // console.log('checkbox', obj);
    // console.log('start', $(obj).is(':checked'));
    var res = !$(obj).is(':checked');
    // console.log(res);
    $(obj).prop('checked', res);
    // console.log('end', $(obj).is(':checked'));
}

function validateForm(type) {
    if (type === 'title') {
        // validate content
        var title = $('#title').val().trim();
        if (title === '') {
            document.getElementById("title-error").style.display="block";
            return false;
        } else {
            $('#title').val(title);
            document.getElementById("title-error").style.display="none";
        }
        return true;
    } else {
        // validate content
        var question = $('#question').val().trim();
        if (question === '') {
            document.getElementById("question-error").style.display="block";
            return false;
        } else {
            $('#question').val(question);
            document.getElementById("question-error").style.display="none";
        }

        // validate title
        var qtitle = $('#prevew_title').val();
        if (qtitle == "") {
            document.getElementById("prevew_title-error").style.display="block";
            return false;
        } else {
            document.getElementById("prevew_title-error").style.display="none";
        }
        return true;
    }
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
    question_table = $('#question-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/get-question',
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
                    '<input id="question_checkbox-' + data + '" type ="checkbox">' +
                    '<label for="question_checkbox-' + data + '">' +
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
                    // console.log(data);
                    if (data.length > length_text) {
                        return data.substring(0, length_text) + "...";
                    }
                    return data;
                }
            }],
        columns: [
            { data: "id", name: "id", orderable: false, width: "5%"},
            { data: "title.content", name: "title.content", width: "40%"},
            { data: "content", name: "content"},
        ],
        pageLength: 15,
        searching: true,
        searchDelay: 400,
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
    // Title
    title_table = $('#title-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/get-title',
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
                    '<input id="title_checkbox-' + data + '" type ="checkbox">' +
                    '<label for="title_checkbox-' + data + '">' +
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
        }],
        columns: [
            { data: "id", name: "id", orderable: false, width: "5%"},
            { data: "content", name: "content"},
        ],
        pageLength: 15,
        searching: true,
        searchDelay: 400,
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

    $('#btnTitleAdd').click(function (e) {
        // console.log('clicked');
        changeToAdditionForm('title');
        $('#btnTitleShowModal').trigger("click");
    });

    $('#title-datatable thead tr').on('click', function (evt) {
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

    $('#title-datatable tbody').on('click', "tr", function (evt) {
        var obj = evt.target;
        // console.log('target:', obj);
        // console.log('attr:', $(obj).is(':checkbox'));

        if (!$(obj).is(':checkbox')) {
            var $cell=$(obj).closest('td');
            // console.log('td', $cell);
            if( $cell.index()>0){
                var row = $($cell).closest('tr');
                // console.log('click to row with course_id: ', table.row($(row)).data().id);
                showModal(title_table.row($(row)).data(), 'title');
            } else {
                var cb = $cell.find('[type=checkbox]');
                // console.log('checkbox', cb);
                changeCheckbox(cb);
            }
        }
    });

    $("#title-form").submit(function (e) {
        e.preventDefault();
        $('#title-form #btnSubmit').trigger('click');
    });

    $('#title-form #btnSubmit').on('click', function (e) {
        e.preventDefault();
        // Validate input
        if (validateForm('title')) {
            $('#title-form #btnHideModal').trigger('click');
            // $('#title-form').submit();
            $('#title-form').ajaxSubmit({
                url: $('#title-form').attr('action'),
                type: 'post',
                success: function (data) {
                    // console.log(data);
                    if (data.status == 0) {
                        $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', data.msg);
                    } else {
                        $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!','Đã tạo/sửa tiêu đề thành công');
                        title_table.ajax.reload();
                        question_table.ajax.reload();
                    }
                },
                error: function (e) {
                    // console.log('loi r', e);
                    $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Lỗi từ chối từ server!');
                }
            });
        }
    });

    $('#btnTitleDelete').on('click', function () {
        $('#title-selected_id').val('');
        var str = "";

        $('#title-datatable tbody input:checked').each(function() {
            if (str !== "") {
                str = str + "," + ($(this).attr('id')).split('-')[1];
            } else {
                str = str + ($(this).attr('id')).split('-')[1];
            }
        });

        $('#title-selected_id').val(str);
        // $('#title-select-form').submit();
        $('#title-select-form').ajaxSubmit({
            url: $('#title-select-form').attr('action'),
            type: 'post',
            success: function (data) {
                // console.log(data);
                if (data.status == 1) {
                    $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', 'Đã xóa tiêu đề thành công!');
                    title_table.ajax.reload();
                    question_table.ajax.reload();
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

    $('#title-checkbox-all').change(function (evt){
        // console.log(evt.target);
        var checked = $(this).is(':checked');
        // console.log(checked);
        var table= $(this).closest('table');
        $('td input:checkbox', table).prop('checked', checked);
    });

    $('#title-checkbox-all').on('click', function () {
        changeCheckbox(this);
    });

    //question


    $('#btnQuestionAdd').click(function (e) {
        // console.log('clicked');
        // load_title
        $.ajax({
            url: "/loadtitle",
            beforeSend: function () {
                $.Notification.autoHideNotify('success', 'top right', 'Đang tải dữ liệu...', 'Vui lòng chờ ít phút!', 3000000);
            },
            success: function (data) {
                $("div:contains('Đang tải dữ liệu...')")[1].remove();

                $('#prevew_title').empty();
                $('#prevew_title').append('<option value="">Hãy chọn tiêu đề</option>');
                var index;
                for (index in data) {
                    var record = data[index];
                    // console.log(record);
                    $('#prevew_title').append('<option value="' + record.id + '">' + record.content + '</option>')
                }
                $('.selectpicker').selectpicker('refresh');
                changeToAdditionForm('question');
                $('#btnQuestionShowModal').trigger("click");
            },
            error: function (e) {
                // console.log(e);
                $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', e);
                $("div:contains('Đang tải dữ liệu...')")[1].remove();
            }
        });
    });

    $('#question-datatable thead tr').on('click', function (evt) {
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

    $('#question-datatable tbody').on('click', "tr", function (evt) {
        var obj = evt.target;
        // console.log('target:', obj);
        // console.log('attr:', $(obj).is(':checkbox'));

        if (!$(obj).is(':checkbox')) {
            var $cell=$(obj).closest('td');
            // console.log('td', $cell);
            if( $cell.index()>0){
                var row = $($cell).closest('tr');
                // console.log('click to row with course_id: ', table.row($(row)).data().id);
                showModal(question_table.row($(row)).data(), 'question');
            } else {
                var cb = $cell.find('[type=checkbox]');
                // console.log('checkbox', cb);
                changeCheckbox(cb);
            }
        }
    });

    $("#question-form").submit(function (e) {
        e.preventDefault();
        $('#question-form #btnSubmit').trigger('click');
    });

    $('#question-form #btnSubmit').on('click', function (e) {
        e.preventDefault();
        // Validate input
        if (validateForm('question')) {
            $('#question-form #btnHideModal').trigger('click');
            // $('#title-form').submit();
            $('#question-form').ajaxSubmit({
                url: $('#question-form').attr('action'),
                type: 'post',
                success: function (data) {
                    // console.log(data);
                    if (data.status == 0) {
                        $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', data.msg);
                    } else {
                        $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!','Đã tạo/sửa câu hỏi thành công');
                        question_table.ajax.reload();
                    }
                },
                error: function (e) {
                    // console.log('loi r', e);
                    $.Notification.autoHideNotify('error', 'top right', 'Có lỗi xảy ra!', 'Lỗi từ chối từ server!');
                }
            });
        }
    });

    $('#btnQuestionDelete').on('click', function () {
        $('#question-selected_id').val('');
        var str = "";

        $('#question-datatable tbody input:checked').each(function() {
            if (str !== "") {
                str = str + "," + ($(this).attr('id')).split('-')[1];
            } else {
                str = str + ($(this).attr('id')).split('-')[1];
            }
        });

        $('#question-selected_id').val(str);
        // $('#question-select-form').submit();
        $('#question-select-form').ajaxSubmit({
            url: $('#question-select-form').attr('action'),
            type: 'post',
            success: function (data) {
                // console.log(data);
                if (data.status == 1) {
                    $.Notification.autoHideNotify('success', 'top right', 'Thao tác thành công!', 'Đã xóa câu hỏi thành công!');
                    question_table.ajax.reload();
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

    $('#question-checkbox-all').change(function (evt){
        // console.log(evt.target);
        var checked = $(this).is(':checked');
        // console.log(checked);
        var table= $(this).closest('table');
        $('td input:checkbox', table).prop('checked', checked);
    });

    $('#question-checkbox-all').on('click', function () {
        changeCheckbox(this);
    });
    //all
    $('.dataTables_filter').addClass('my-search');
});
