
/**
 * Created by home on 28/10/2017.
 */
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

            if (data.status == 1) {
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
            if (data.status == 1) {
                statusTd.append('<span class="label label-success">Hoạt động</span>');
            } else {
                statusTd.append('<span class="label label-danger">Khóa</span>');
            }

            $.getScript('/js/admin-action.js', function () {
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