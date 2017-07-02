namespace["corresponsales"] = {

    get_by_id: function (id) {
        $(this).addClass('item-selected');

        $.ajax({
            url: base_url + "index.php/corresponsales/get_by_id",
            type: 'POST',
            dataType: 'json',
            data: "id=" + id,
            success: function (data) {

                $('#info_item_title').text(data.nombre);
                $('#corresponsal-id').val(data.id);
                $('#corresponsal-nombre').val(data.nombre);
                $('#corresponsal-domicilio').val(data.domicilio);
                $('#corresponsal-telefono').val(data.telefono);
                $('#corresponsal-email').val(data.email);
                $('#corresponsal-tomo-folio-colegio').val(data.tomo_folio_colegio);
                $('#corresponsal-observaciones').val(data.observaciones);
                $('#id_subzona').val(data.id_subzona);
            }

        });
    },

    create: function () {

        var corresponsal_data = {};
        corresponsal_data.nombre = $('#corresponsal-nombre').val();
        corresponsal_data.domicilio = $('#corresponsal-domicilio').val();
        corresponsal_data.telefono = $('#corresponsal-telefono').val();
        corresponsal_data.email = $('#corresponsal-email').val();
        corresponsal_data.tomo_folio_colegio = $('#corresponsal-tomo-folio-colegio').val();
        corresponsal_data.observaciones = $('#corresponsal-observaciones').val();
        corresponsal_data.id_subzona = $('#id_subzona').val();

        var json = JSON.stringify(corresponsal_data);

        $.ajax({
            url: base_url + "index.php/corresponsales/create",
            type: 'POST',
            dataType: 'json',
            data: "data=" + json,
            success: function (data) {

                var row_index = corresponsales_table.dataTable().fnAddData(["", data.data.id, data.data.nombre]);
                corresponsales_table.fnSort( [ [1,'desc'] ] );
                var row = corresponsales_table.fnGetNodes(row_index);

                $(row).addClass('row-item');
                $(row).attr('id', data.data.id);
                $(row).children('td:eq( 0 )').addClass('chbx-item-cell');
                $(row).children('td:eq( 0 )').html("<input type='checkbox' class='chbx-item' id='" + data.data.id + "'>");
                $(row).children('td:eq( 1 )').addClass('clickeable-item');
                $(row).children('td:eq( 2 )').addClass('clickeable-item row-nombre');


                $('#info_item_title').text(data.data.nombre);
                $('#corresponsal-id').val(data.data.id);

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

        var corresponsal_data = {};
        var item_id = parseInt($('#corresponsal-id').val());
        corresponsal_data.nombre = $('#corresponsal-nombre').val();
        corresponsal_data.domicilio = $('#corresponsal-domicilio').val();
        corresponsal_data.telefono = $('#corresponsal-telefono').val();
        corresponsal_data.email = $('#corresponsal-email').val();
        corresponsal_data.tomo_folio_colegio = $('#corresponsal-tomo-folio-colegio').val();
        corresponsal_data.observaciones = $('#corresponsal-observaciones').val();
        corresponsal_data.id_subzona = $('#id_subzona').val();

        var json = JSON.stringify(corresponsal_data);

        $.ajax({
            url: base_url + "index.php/corresponsales/update",
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
        var row = corresponsales_table.fnGetNodes();

        row.forEach(function (item) {

            var that = $(item).find('.chbx-item');
            if (that.prop("checked")) {
                delete_items.push(parseInt(that.parents('.row-item').attr('id')));
            }
        });

        if (delete_items.length > 0) {

            $.ajax({
                url: base_url + "index.php/corresponsales/delete",
                type: 'POST',
                dataType: 'json',
                data: "ids=" + delete_items,
                success: function (data) {

                    if (data.status) {

                        for (i = 0; i < delete_items.length; i++) {
                            row.forEach(function (item) {
                                if (parseInt($(item).attr('id')) === delete_items[i]) {
                                    corresponsales_table.fnDeleteRow(corresponsales_table.fnGetPosition(item));
                                }
                            });
                        }

                        reset_metadata();
                        $('.footerButtons').find('button').attr('disabled', 'disabled');

                        set_small_box_message("Eliminar corresponsal(s)", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
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

        var row = corresponsales_table.fnGetNodes();

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
    $('#info_item_title').text($('#corresponsal-nombre').val());
    $('.item-selected').children('.row-nombre').text($('#corresponsal-nombre').val());
}

