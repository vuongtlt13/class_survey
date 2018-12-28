$('#btnEdit').on('click', function (e) {
    e.preventDefault();
    var isDisable = $('#form-name').prop("disabled");
    //console.log(isDisable);
    if (isDisable) {
        $('#form-name').prop("disabled", false);
        $('#form-phone').prop("disabled", false);
        $('#form-email').prop("disabled", false);
        $('#form-password').val('');
        $('#form-password').prop("disabled", false);
        $('#btnSave').prop("disabled", false);
        $('#form-address').prop("disabled", false);
        $('#form-gender').prop("disabled", false);
        $('#confirm-pass').prop("hidden", false);
        $('#btn-edit').text('Hủy');
        $('#form-course').prop("disabled", false);
        $('#form-major').prop("disabled", false);
        $('#form-degree').prop("disabled", false);
    } else {
        $('#form-name').prop("disabled", true);
        $('#form-phone').prop("disabled", true);
        $('#form-email').prop("disabled", true);
        $('#form-password').val('Khong xem dc dau');
        $('#form-password').prop("disabled", true);
        $('#btnSave').prop("disabled", true);
        $('#btn-edit').text('Thay đổi thông tin');
        $('#form-address').prop("disabled", true);
        $('#form-gender').prop("disabled", true);
        $('#confirm-pass').prop("hidden", true);
        $('#form-course').prop("disabled", true);
        $('#form-major').prop("disabled", true);
        $('#form-degree').prop("disabled", true);

    }
});

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
    // validate phone
    var phone = $('#form-phone').val().trim();
    if (validatePhoneNumber(phone)) {
        $('#form-phone').val(phone);
        document.getElementById("phone-error").style.display="none";
    } else {
        document.getElementById("phone-error").style.display="block";
        return false;
    }
    // validate email
    var email = $('#form-email').val().trim().toLowerCase();
    if (validateEmail(email)) {
        $('#form-email').val(email);
        document.getElementById("email-error").style.display="none";
    } else {
        document.getElementById("email-error").style.display="block";
        return false;
    }

    return true;
}


$('#btnSave').on('click', function (e) {
    if (validateForm()) {
        $('#myForm').submit();
    }
});
