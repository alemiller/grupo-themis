namespace["zonas"] = {

    get_by_id: function (id) {
        $(this).addClass('item-selected');

        $.ajax({
            url: base_url + "index.php/zonas/get_by_id",
            type: 'POST',
            dataType: 'json',
            data: "id=" + id,
            success: function (data) {

                $('#info_item_title').text(data.nombre);
                $('#zona-id').val(data.id);
                $('#zona-nombre').val(data.nombre);
            }

        });
    },

    create: function () {

        var zona_data = {};
        zona_data.nombre = $('#zona-nombre').val();

        var json = JSON.stringify(zona_data);

        $.ajax({
            url: base_url + "index.php/zonas/create",
            type: 'POST',
            dataType: 'json',
            data: "data=" + json,
            success: function (data) {

                var row_index = zonas_table.dataTable().fnAddData(["", data.data.id, data.data.nombre]);
                zonas_table.fnSort([[1, 'desc']]);
                var row = zonas_table.fnGetNodes(row_index);

                $(row).addClass('row-item');
                $(row).attr('id', data.data.id);
                $(row).children('td:eq( 0 )').addClass('chbx-item-cell');
                $(row).children('td:eq( 0 )').html("<input type='checkbox' class='chbx-item' id='" + data.data.id + "'>");
                $(row).children('td:eq( 2 )').addClass('row-nombre');


                $('#info_item_title').text(data.data.nombre);
                $('#zona-id').val(data.data.id);

                reset_footer_buttons();
                if (data.status) {
                    set_small_box_message("Creación", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
                } else {
                    set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                }
            }
        });
    },

    update: function () {

        var zona_data = {};
        var item_id = parseInt($('#zona-id').val());
        zona_data.nombre = $('#zona-nombre').val();

        var json = JSON.stringify(zona_data);

        $.ajax({
            url: base_url + "index.php/zonas/update",
            type: 'POST',
            dataType: 'json',
            data: "id=" + item_id + "&data=" + json,
            success: function (data) {
                update_table();
                reset_footer_buttons();
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
        var row = zonas_table.fnGetNodes();

        row.forEach(function (item) {

            var that = $(item).find('.chbx-item');
            if (that.prop("checked")) {
                delete_items.push(parseInt(that.parents('.row-item').attr('id')));
            }
        });

        if (delete_items.length > 0) {

            $.ajax({
                url: base_url + "index.php/zonas/delete",
                type: 'POST',
                dataType: 'json',
                data: "ids=" + delete_items,
                success: function (data) {

                    if (data.status) {

                        for (i = 0; i < delete_items.length; i++) {
                            row.forEach(function (item) {
                                if (parseInt($(item).attr('id')) === delete_items[i]) {
                                    zonas_table.fnDeleteRow(zonas_table.fnGetPosition(item));
                                }
                            });
                        }

                        reset_metadata();
                        $('.footerButtons').find('button').attr('disabled', 'disabled');

                        set_small_box_message("Eliminar zona(s)", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
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

        var row = zonas_table.fnGetNodes();

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

function update_table() {
    $('#info_item_title').text($('#zona-nombre').val());
    $('.item-selected').children('.row-nombre').text($('#zona-nombre').val());
}

