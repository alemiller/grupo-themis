namespace["usuarios"] = {

    get_by_id: function (id) {
        $(this).addClass('item-selected');

        $.ajax({
            url: base_url + "index.php/usuarios/get_by_id",
            type: 'POST',
            dataType: 'json',
            data: "id=" + id,
            success: function (data) {

                $('#info_item_title').text(data.username);
                $('#usuario-id').val(data.id);
                $('#usuario-username').val(data.username);
                $('#usuario-password').val(data.password);
                $('#usuario-repetir-password').val('');
                if (typeof (data.confirm_password) !== "undefined") {
                    $('#usuario-repetir-password').val(data.confirm_password);
                } else {
                    $('#usuario-password').attr('disabled', 'disabled');
                }
                $('#usuario-type').val(data.type);

            }

        });
    },

    create: function () {

        if ($('#usuario-password').val() === $('#usuario-repetir-password').val()) {

            var usuario_data = {};
            usuario_data.username = $('#usuario-username').val();
            usuario_data.password = $('#usuario-password').val();
            usuario_data.type = $('#usuario-type').val();


            var json = JSON.stringify(usuario_data);

            $.ajax({
                url: base_url + "index.php/usuarios/create",
                type: 'POST',
                dataType: 'json',
                data: "data=" + json,
                success: function (data) {

                    var row_index = usuarios_table.dataTable().fnAddData(["", data.data.id, data.data.username, data.data.type]);
                    usuarios_table.fnSort([[1, 'desc']]);
                    var row = usuarios_table.fnGetNodes(row_index);

                    $(row).addClass('row-item');
                    $(row).attr('id', data.data.id);
                    $(row).children('td:eq( 0 )').addClass('chbx-item-cell');
                    $(row).children('td:eq( 0 )').html("<input type='checkbox' class='chbx-item' id='" + data.data.id + "'>");
                    $(row).children('td:eq( 1 )').addClass('clickeable-item');
                    $(row).children('td:eq( 2 )').addClass('clickeable-item row-username');
                    $(row).children('td:eq( 3 )').addClass('clickeable-item row-type');


                    $('#info_item_title').text(data.data.username);
                    $('#usuario-id').val(data.data.id);

                    reset_footer_buttons();
                    if (data.status) {
                        set_small_box_message("Creación", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
                    } else {
                        set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                    }
                }
            });
        } else {
            $('.footerButtons').find('button').removeAttr('disabled');
            $('.save_waiting').hide();
            set_small_box_error_message("Error!", 'Los passwords ingresados deben coincidir', "#C46A69", "fa fa-times fa-2x fadeInRight animated");
        }
    },

    update: function () {

        if ($('#usuario-password').val() === $('#usuario-repetir-password').val()) {

            var usuario_data = {};
            var item_id = parseInt($('#usuario-id').val());
            usuario_data.username = $('#usuario-username').val();
            usuario_data.password = $('#usuario-password').val();
            usuario_data.type = $('#usuario-type').val();

            var json = JSON.stringify(usuario_data);

            $.ajax({
                url: base_url + "index.php/usuarios/update",
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
        } else {
            reset_footer_buttons();
            set_small_box_error_message("Error!", 'Los passwords ingresados deben coincidir', "#C46A69", "fa fa-times fa-2x fadeInRight animated");
        }
    },
    delete: function () {

        var delete_items = new Array();
        var row = usuarios_table.fnGetNodes();

        row.forEach(function (item) {

            var that = $(item).find('.chbx-item');
            if (that.prop("checked")) {
                delete_items.push(parseInt(that.parents('.row-item').attr('id')));
            }
        });

        if (delete_items.length > 0) {

            $.ajax({
                url: base_url + "index.php/usuarios/delete",
                type: 'POST',
                dataType: 'json',
                data: "ids=" + delete_items,
                success: function (data) {

                    if (data.status) {

                        for (i = 0; i < delete_items.length; i++) {
                            row.forEach(function (item) {
                                if (parseInt($(item).attr('id')) === delete_items[i]) {
                                    usuarios_table.fnDeleteRow(usuarios_table.fnGetPosition(item));
                                }
                            });
                        }

                        reset_metadata();
                        $('.footerButtons').find('button').attr('disabled', 'disabled');

                        set_small_box_message("Eliminar usuario(s)", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
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

        var row = usuarios_table.fnGetNodes();

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
    $('#info_item_title').text($('#usuario-username').val());
    $('.item-selected').children('.row-username').text($('#usuario-username').val());
}

