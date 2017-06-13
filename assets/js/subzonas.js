namespace["subzonas"] = {

    get_by_id: function (id) {
        $(this).addClass('item-selected');

        $.ajax({
            url: base_url + "index.php/subzonas/get_by_id",
            type: 'POST',
            dataType: 'json',
            data: "id=" + id,
            success: function (data) {

                $('#info_item_title').text(data.nombre);
                $('#subzona-id').val(data.id);
                $('#subzona-nombre').val(data.nombre);
                $('#id_zona').val(data.id_zona);
            }

        });
    },

    create: function () {

        var subzona_data = {};
        subzona_data.nombre = $('#subzona-nombre').val();
        subzona_data.id_zona = $('#id_zona').val();

        var json = JSON.stringify(subzona_data);

        $.ajax({
            url: base_url + "index.php/subzonas/create",
            type: 'POST',
            dataType: 'json',
            data: "data=" + json,
            success: function (data) {

                var row_index = subzonas_table.dataTable().fnAddData(["", data.data.id, data.data.nombre]);
                var row = subzonas_table.fnGetNodes(row_index);

                $(row).addClass('row-item');
                $(row).attr('id', data.data.id);
                $(row).children('td:eq( 0 )').addClass('chbx-item-cell');
                $(row).children('td:eq( 0 )').html("<input type='checkbox' class='chbx-item' id='" + data.data.id + "'>");
                $(row).children('td:eq( 2 )').addClass('row-nombre');


                $('#info_item_title').text(data.data.nombre);
                $('#subzona-id').val(data.data.id);

                reset_footer_buttons();
                if (data.status) {
                    set_small_box_message("Creación", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
                } else {
                    set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                }
            }
        });
    },

    update: function (id) {

        var subzona_data = {};
        var item_id = parseInt($('#subzona-id').val());
        subzona_data.nombre = $('#subzona-nombre').val();
        subzona_data.id_zona = $('#id_zona').val();

        var json = JSON.stringify(subzona_data);

        $.ajax({
            url: base_url + "index.php/subzonas/update",
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
        var row = subzonas_table.fnGetNodes();

        row.forEach(function (item) {

            var that = $(item).find('.chbx-item');
            if (that.prop("checked")) {
                delete_items.push(parseInt(that.parents('.row-item').attr('id')));
            }
        });

        if (delete_items.length > 0) {

            $.ajax({
                url: base_url + "index.php/subzonas/delete",
                type: 'POST',
                dataType: 'json',
                data: "ids=" + delete_items,
                success: function (data) {

                    if (data.status) {

                        for (i = 0; i < delete_items.length; i++) {
                            row.forEach(function (item) {
                                if (parseInt($(item).attr('id')) === delete_items[i]) {
                                    subzonas_table.fnDeleteRow(subzonas_table.fnGetPosition(item));
                                }
                            });
                        }

                        reset_metadata();
                        $('.footerButtons').find('button').attr('disabled', 'disabled');

                        set_small_box_message("Eliminar subzona(s)", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
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

        var row = subzonas_table.fnGetNodes();

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
    $('#info_item_title').text($('#subzona-nombre').val());
    $('.item-selected').children('.row-nombre').text($('#subzona-nombre').val());
}

