namespace["pagos"] = {

    get_by_id: function (id) {
        var that = this;
        $(this).addClass('item-selected');

        $.ajax({
            url: base_url + "index.php/pagos/get_by_id",
            type: 'POST',
            dataType: 'json',
            data: "id=" + id,
            success: function (data) {

                that.set_data(data);

            }

        });
        $('#pdf-iframe').attr("src", 'http://localhost/grupo-themis/uploads/tramite_listo.php').load(function () {
            document.getElementById('pdf-iframe').contentWindow.print();
        });
    },

    create: function () {

        var that = this;
        if (typeof (id_cliente) !== 'undefined' && id_cliente) {

            var json = this.get_data();

            $.ajax({
                url: base_url + "index.php/pagos/create",
                type: 'POST',
                dataType: 'json',
                data: "data=" + json,
                success: function (data) {

                    var row_index = pagos_table.dataTable().fnAddData(["", data.data.id, format_datetime(data.data.fecha_creacion), data.data.title, capitalise(data.data.valor.toString().replace('-', ''))]);
                    pagos_table.fnSort( [ [1,'desc'] ] );
                    var row = pagos_table.fnGetNodes(row_index);

                    $(row).addClass('item-selected row-item');
                    $(row).attr('id', data.data.id);
                    $(row).children('td:eq( 0 )').addClass('chbx-item-cell');
                    $(row).children('td:eq( 0 )').html("<input type='checkbox' class='chbx-item' id='" + data.data.id + "'>");
                    $(row).children('td:eq( 1 )').addClass('clickeable-item');
                    $(row).children('td:eq( 2 )').addClass('clickeable-item');
                    $(row).children('td:eq( 3 )').addClass('clickeable-item');
                    $(row).children('td:eq( 4 )').addClass('clickeable-item row-valor');

                    that.set_data(data.data);
                    reset_pagos_footer_buttons();
                    if (typeof (data.url) !== 'undefined') {

                        $('#impresion-content').attr("src", data.url).load(function () {
                            document.getElementById('impresion-content').contentWindow.print();
                        });
                    }
                    if (data.status) {
                        set_small_box_message("Creación", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
                    } else {
                        set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                    }
                }
            });
        } else {
            set_small_box_error_message("Error!", "Debe crear el usuario", "#C46A69", "fa fa-times fa-2x fadeInRight animated");
        }
    },

    update: function () {

        var that = this;
        var item_id = $('#pago-id').val();
        var json = this.get_data();

        $.ajax({
            url: base_url + "index.php/pagos/update",
            type: 'POST',
            dataType: 'json',
            data: "id=" + item_id + "&id_cliente=" + $('#cliente-id').val() + "&data=" + json,
            success: function (data) {
                that.set_data(data.data);
                update_table();
                reset_pagos_footer_buttons();
                if (data.status) {
                    set_small_box_message("Creación", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
                } else {
                    set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                }
            }
        });

    },

    delete: function () {

        var delete_items = new Array();
        var row = pagos_table.fnGetNodes();

        row.forEach(function (item) {

            var that = $(item).find('.chbx-item');
            if (that.prop("checked")) {
                delete_items.push(parseInt(that.parents('.row-item').attr('id')));
            }
        });

        if (delete_items.length > 0) {

            $.ajax({
                url: base_url + "index.php/pagos/delete",
                type: 'POST',
                dataType: 'json',
                data: "ids=" + delete_items,
                success: function (data) {

                    if (data.status) {

                        for (i = 0; i < delete_items.length; i++) {
                            row.forEach(function (item) {
                                if (parseInt($(item).attr('id')) === delete_items[i]) {
                                    pagos_table.fnDeleteRow(pagos_table.fnGetPosition(item));
                                }
                            });
                        }

                        reset_pagos_metadata();
                        $('.pago-footer-buttons').find('button').attr('disabled', 'disabled');

                        set_small_box_message("Eliminar pago(s)", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
                    } else {
                        set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                    }
                }
            });
        } else {
            set_small_box_error_message("Error!", "Por favor seleccione al menos un item para borrar", "#C46A69", "fa fa-times fa-2x fadeInRight animated");
        }
    },

    select_all: function (select_all) {

        var row = pagos_table.fnGetNodes();

        row.forEach(function (item) {

            var that = $(item).find('.chbx-item');
            if (that.prop("checked")) {

                if (!select_all) {
                    that.prop("checked", false);
                } else {
                    that.prop("checked", true);
                }
            } else {
                if (select_all) {
                    that.prop("checked", true);
                } else {
                    that.prop("checked", false);
                }
            }
        });
    },

    set_data: function (data) {

        $('#info_item_title').text(data.caratula);
        $('#pago-id').val(data.id);
        $('#pago-valor').val(data.valor.replace('-', ''));
        $('#pago-clase').val(data.tipo);


    },
    get_data: function () {

        var pago_data = {};
        pago_data.id_cliente = id_cliente;
        pago_data.valor = parseFloat("-" + $('#pago-valor').val());
        pago_data.tipo = $('#pago-clase').val();

        var json = JSON.stringify(pago_data);
        console.log('pago data: ', json);
        return json;

    }
};


function update_table() {

    $('#info_item_title').text($('#pago-nombre').val());
    $('.item-selected').children('.row-nombre').text($('#pago-nombre').val());
    $('.item-selected').children('.row-estado').text(capitalise($('#pago-estado').val().replace('en_pago', 'En Trámite')));
}

$(document).on('click', '#nuevo-pago', function () {

    $('.row-item').removeClass('item-selected');
    $('.row-item').removeClass('new-object-row');
    $('.pagos-metadata').removeAttr('disabled');
    $('.pagos-metadata').find('input').val('');
    $('.pagos-metadata').find('select').val(null);
    $('.pagos-metadata').find('textarea').val('');
    $('#info_item_title').text('');

    $('#pago-clase').val('1');

    $('#guardar-pago-btn').hide();
    $('#crear-pago-btn').show();
    $('.pago-footer-buttons').find('button').removeAttr('disabled');
});

$(document).on('click', '.clickeable-item', function () {

    $('.row-item').removeClass('item-selected');
    $(this).parents('.row-item').addClass('item-selected');
    $('.pagos-metadata').removeAttr('disabled');
    $('.pago-footer-buttons').find('button').removeAttr('disabled');

    var item_id = $(this).parents('.row-item').attr('id');
    namespace[page].get_by_id(item_id);
});


$(document).on('click', '#crear-pago-btn', function () {

    var flag = validate_pagos_form();

    if (flag) {
        $('.pago-footer-buttons').find('button').attr('disabled', 'disabled');
        $('.pago-save-waiting').show();
        namespace[page].create();
    }
});

$(document).on('click', '#borrar-pago', function () {
    namespace[page].delete();
});

$(document).on('click', '#guardar-pago-btn', function () {

    var flag = validate_pagos_form();

    if (flag) {
        $('.pago-footer-buttons').find('button').attr('disabled', 'disabled');
        $('.pago-save-waiting').show();
        namespace[page].update();
    }
});

$(document).on('click', '#cancelar-pago-btn', function () {
    reset_pagos_metadata();
    $('.pago-footer-buttons').find('button').attr('disabled', 'disabled');
    $('#guardar-pago-btn').show();
    $('#crear-pago-btn').hide();
    $('.pago-save-waiting').hide();
});


$(document).on('focus', '.pago-mandatory', function () {
    $(this).removeClass('field-error');
    $(this).siblings('.pago-mandatory-field-error').hide();
});

function validate_pagos_form() {

    var flag = true;

    $('.pago-mandatory').each(function () {
        if ($(this).val() === "" || !$(this).val()) {
            $(this).addClass('field-error');
            $(this).siblings('.pago-mandatory-field-error').show();
            flag = false;
        }
    });

    return flag;
}

function reset_pagos_metadata() {

    $('.row-item').removeClass('item-selected');
    $('.row-item').removeClass('new-object-row');
    $('.pagos-metadata').attr('disabled', 'disabled');
    $('.pagos-metadata').find('input').val('');
    $('.pagos-metadata').find('select').val(null);
    $('#info_item_title').text('');
}

function reset_pagos_footer_buttons() {

    $('.pago-footer-buttons').find('button').removeAttr('disabled');
    $('#guardar-pago-btn').show();
    $('#crear-pago-btn').hide();
    $('.pago-save-waiting').hide();
}

