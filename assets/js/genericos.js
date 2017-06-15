var namespace = new Array();

$(document).on('click', '.nuevo-item', function () {

    $('.row-item').removeClass('item-selected');
    $('.row-item').removeClass('new-object-row');
    $('.metadata').removeAttr('disabled');
    $('.metadata').find('input').val('');
    $('.metadata').find('select').val(null);
    $('.metadata').find('textarea').val('');
    $('#info_item_title').text('');

    if ($('#tramite-estado').length > 0) {
        $('#tramite-estado').val('en_tramite');
    }
    
    if ($('#pago-clase').length > 0) {
        $('#pago-clase').val('1');
    }

    $('#guardar-item-btn').hide();
    $('#crear-item-btn').show();
    $('.footerButtons').find('button').removeAttr('disabled');
});

$(document).on('click', '.clickeable-item', function () {

    $('.row-item').removeClass('item-selected');
    $(this).parents('.row-item').addClass('item-selected');
    $('.metadata').removeAttr('disabled');
    $('.footerButtons').find('button').removeAttr('disabled');

    var item_id = $(this).parents('.row-item').attr('id');
    namespace[page].get_by_id(item_id);
});


$(document).on('click', '#crear-item-btn', function () {

    var flag = validate_form();

    if (flag) {
        $('.footerButtons').find('button').attr('disabled', 'disabled');
        $('.save_waiting').show();
        namespace[page].create();
    }else{
        set_small_box_error_message("Error!", "Complete los campos obligatorios", "#C46A69", "fa fa-times fa-2x fadeInRight animated");
    }
});

$(document).on('click', '.borrar-item', function () {
    namespace[page].delete();
});

$(document).on('click', '#guardar-item-btn', function () {

    var flag = validate_form();

    if (flag) {
        $('.footerButtons').find('button').attr('disabled', 'disabled');
        $('.save_waiting').show();
        namespace[page].update();
    }
});

$(document).on('click', '#cancelar-btn', function () {
    reset_metadata();
    $('.footerButtons').find('button').attr('disabled', 'disabled');
    $('#guardar-item-btn').show();
    $('#crear-item-btn').hide();
    $('.save_waiting').hide();
});

$(document).on('click', '#select-all-items', function () {

    if ($('#select-all-items:checked').length > 0) {
        var select_all = true;
    } else {
        var select_all = false;
    }
    namespace[page].select_all(select_all);

});

$(document).on('focus', '.mandatory', function () {
    $(this).removeClass('field-error');
    $(this).siblings('.mandatory-field-error').hide();
});

