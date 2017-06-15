function validate_form() {

    var flag = true;

    $('.mandatory').each(function () {
        if ($(this).val() === "" || !$(this).val()) {
            $(this).addClass('field-error');
            $(this).siblings('.mandatory-field-error').show();
            flag = false;
        }
    });

    return flag;
}

function reset_metadata() {

    $('.row-item').removeClass('item-selected');
    $('.row-item').removeClass('new-object-row');
    $('.metadata').attr('disabled', 'disabled');
    $('.metadata').find('input').val('');
    $('.metadata').find('select').val(null);
    $('#info_item_title').text('');
}

function reset_footer_buttons() {

    $('.footerButtons').find('button').removeAttr('disabled');
    $('#guardar-item-btn').show();
    $('#crear-item-btn').hide();
    $('.save_waiting').hide();
}

function set_small_box_message(title, message, color, animation, timeout) {

    $.smallBox({
        title: title,
        content: "<i class='fa fa-info-circle fa-lg'></i> <i>&nbsp;" + message + "</i>",
        color: color,
        iconSmall: animation,
        timeout: timeout

    });
}

function set_small_message(title, message, color, animation, timeout) {

    $.smallBox({
        title: title,
        content: "<i class='fa fa-info-circle fa-lg'></i> <i>&nbsp;" + message + "</i>",
        color: color,
        iconSmall: animation,
        timeout: timeout

    });
}

function set_small_box_error_message(title, message, color, animation) {

    $.smallBox({
        title: title,
        content: "<i class='fa fa-info-circle fa-lg'></i> <i>&nbsp;" + message + "</i>",
        color: color,
        iconSmall: animation
    });
}

function format_date(date) {
    var step1_tmp = date.split(" ");
    var step2_tmp = step1_tmp[0].split("-");

    return step2_tmp[2] + '-' + step2_tmp[1] + '-' + step2_tmp[0];
}

function format_date_to_save(date) {
    var step1_tmp = date.split(" ");
    var step2_tmp = step1_tmp[0].split("-");

    return step2_tmp[2] + '-' + step2_tmp[1] + '-' + step2_tmp[0];
}

function format_datetime(date) {
    var step1_tmp = date.split(" ");
    var step2_tmp = step1_tmp[0].split("-");

    return step2_tmp[2] + '-' + step2_tmp[1] + '-' + step2_tmp[0] + ' ' + step1_tmp[1];
}


function capitalise(text) {

    var res = [];
    var tokens = text.replace("_", " ").split(" ");

    for (i = 0, len = tokens.length; i < len; i++) {
        component = tokens[i];
        res.push(component.substring(0, 1).toUpperCase());
        res.push(component.substring(1));
        res.push(" "); // put space back in
    }
    var text_return = res.join("");

    return text_return;

}