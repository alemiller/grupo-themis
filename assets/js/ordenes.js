namespace["ordenes"] = {

    get_by_id: function (id) {
        $(this).addClass('item-selected');
        $('#orden-detalle-content').html('');

        $.ajax({
            url: base_url + "index.php/ordenes/get_by_id",
            type: 'POST',
            data: "id=" + id,
            success: function (data) {
                if (data) {
                    $('#orden-detalle-content').html(data);
                } else {

                    set_small_message("Información", "Los trámites de esta Orden han sido borrados", "#dfb56c", "fa fa-warning fa-2x fadeInRight animated", 4000);
                }
            }
        });
    },
    delete: function () {

        var delete_items = new Array();
        var row = ordenes_table.fnGetNodes();

        row.forEach(function (item) {

            var that = $(item).find('.chbx-item');
            if (that.prop("checked")) {
                delete_items.push(parseInt(that.parents('.row-item').attr('id')));
            }
        });

        if (delete_items.length > 0) {

            $.ajax({
                url: base_url + "index.php/ordenes/delete",
                type: 'POST',
                dataType: 'json',
                data: "ids=" + delete_items,
                success: function (data) {

                    if (data.status) {

                        for (i = 0; i < delete_items.length; i++) {
                            row.forEach(function (item) {
                                if (parseInt($(item).attr('id')) === delete_items[i]) {
                                    ordenes_table.fnDeleteRow(ordenes_table.fnGetPosition(item));
                                }
                            });
                        }

                        reset_metadata();
                        $('.footerButtons').find('button').attr('disabled', 'disabled');

                        set_small_box_message("Eliminar orden(s)", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
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

        var row = ordenes_table.fnGetNodes();

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
    }
};


$(document).on('click', '.ordenes-clickeable-item', function () {

    $('#orden-detalle-content').html('');
    $('.row-item').removeClass('item-selected');
    $(this).parents('.row-item').addClass('item-selected');

    var item_id = $(this).parents('.row-item').attr('id');
    namespace[page].get_by_id(item_id);
});


$(document).on('click', '.imprimir-orden-btn', function () {

    var order_items = new Array();
    var row = ordenes_table.fnGetNodes();

    row.forEach(function (item) {

        var that = $(item).find('.chbx-item');
        if (that.prop("checked")) {
            order_items.push(parseInt(that.parents('.row-item').attr('id')));
        }
    });

    $.ajax({
        url: base_url + "index.php/ordenes/imprimir",
        type: 'POST',
        dataType: 'json',
        data: "id_cliente=" + id_cliente + "&order_items=" + order_items,
        success: function (data) {

            if (data.status) {

                if (typeof (data.url) !== 'undefined') {

                    $('#impresion-content').attr("src", data.url).load(function () {
                        document.getElementById('impresion-content').contentWindow.print();
                    });
                }

            } else {
                set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
            }
        }
    });
});


$(document).on('click', '.enviar-email-orden-btn', function () {

    var order_items = new Array();
    var row = ordenes_table.fnGetNodes();

    row.forEach(function (item) {

        var that = $(item).find('.chbx-item');
        if (that.prop("checked")) {
            order_items.push(parseInt(that.parents('.row-item').attr('id')));
        }
    });

    $.ajax({
        url: base_url + "index.php/ordenes/enviar_email",
        type: 'POST',
        dataType: 'json',
        data: "id_cliente=" + id_cliente + "&order_items=" + order_items,
        success: function (data) {

            if (data.status) {

                set_small_box_message("Enviar email(s)", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);

            } else {
                set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
            }
        }
    });
});