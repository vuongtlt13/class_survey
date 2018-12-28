function validateForm(questions) {
    var is_ok = true;
    // console.log(questions, typeof (questions));
    for (var index = 0; index < questions.length; index++) {
        // console.log(questions[index]);
        var radioGroup = 'rate-' + questions[index].id;
        // console.log(radioGroup);
        // console.log(radioGroup, $('input[name=' + radioGroup + ']:checked').val());
        var value = $('input[name=' + radioGroup + ']:checked').val();
        // console.log('input[name=' + radioGroup ', value);
        if (value == null) {
            $('#' + questions[index].id).css('color', 'red');
            is_ok = false;
        } else {
            $('#' + questions[index].id).css('color', '#797979');
        }
    }
    if (!is_ok) {
        alert('Bạn chưa đánh giá hết! Hãy xem lại');
    }
    return is_ok;
}

$(document).ready(function () {
    // console.log($(questions));
    var ques = $(questions);
    $('#btnSubmit').on('click', function (evt) {
        // console.log($(this));
        evt.preventDefault();
        if (validateForm(ques)) {
            $('#survey-form').submit();
        }
    });
});