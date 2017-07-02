namespace["tramites"] = {

    get_by_id: function (id) {
        var that = this;
        $(this).addClass('item-selected');

        $.ajax({
            url: base_url + "index.php/tramites/get_by_id",
            type: 'POST',
            dataType: 'json',
            data: "id=" + id,
            success: function (data) {

                that.set_data(data);

            }

        });
    },

    create: function () {

        var that = this;
        if (typeof (id_cliente) !== 'undefined' && id_cliente) {

            var json = this.get_data();

            $.ajax({
                url: base_url + "index.php/tramites/create",
                type: 'POST',
                dataType: 'json',
                data: "data=" + json,
                success: function (data) {

                    reset_footer_buttons();
                    if (data.status) {

                        var row_index = tramites_table.dataTable().fnAddData(["", data.data.id, format_datetime(data.data.fecha_creacion), data.data.caratula, capitalise(data.data.estado.replace('tramite', 'trámite')), '$' + data.data.total]);
                        tramites_table.fnSort([[1, 'desc']]);
                        var row = tramites_table.fnGetNodes(row_index);

                        $(row).addClass('item-selected row-item');
                        $(row).attr('id', data.data.id);
                        $(row).children('td:eq( 0 )').addClass('chbx-item-cell');
                        $(row).children('td:eq( 0 )').html("<input type='checkbox' class='chbx-item' id='" + data.data.id + "'>");
                        $(row).children('td:eq( 1 )').addClass('clickeable-item');
                        $(row).children('td:eq( 2 )').addClass('clickeable-item');
                        $(row).children('td:eq( 3 )').addClass('clickeable-item');
                        $(row).children('td:eq( 4 )').addClass('clickeable-item row-estado');
                        $(row).children('td:eq( 5 )').addClass('clickeable-item row-valor');

                        that.set_data(data.data);

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
        var item_id = $('#tramite-id').val();
        var json = this.get_data();

        $.ajax({
            url: base_url + "index.php/tramites/update",
            type: 'POST',
            dataType: 'json',
            data: "id=" + item_id + "&id_cliente=" + $('#cliente-id').val() + "&data=" + json,
            success: function (data) {

                reset_footer_buttons();
                if (data.status) {
                    that.set_data(data.data);
                    update_table();
                    set_small_box_message("Creación", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);

                    if (typeof (data.url) !== 'undefined' && data.url) {

                        $('#impresion-content').attr("src", data.url).load(function () {
                            document.getElementById('impresion-content').contentWindow.print();
                        });
                    }

                } else {
                    set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                }
            }
        });

    },

    delete: function () {

        var delete_items = new Array();
        var row = tramites_table.fnGetNodes();

        row.forEach(function (item) {

            var that = $(item).find('.chbx-item');
            if (that.prop("checked")) {
                delete_items.push(parseInt(that.parents('.row-item').attr('id')));
            }
        });

        if (delete_items.length > 0) {

            $.ajax({
                url: base_url + "index.php/tramites/delete",
                type: 'POST',
                dataType: 'json',
                data: "ids=" + delete_items,
                success: function (data) {

                    if (data.status) {

                        for (i = 0; i < delete_items.length; i++) {
                            row.forEach(function (item) {
                                if (parseInt($(item).attr('id')) === delete_items[i]) {
                                    tramites_table.fnDeleteRow(tramites_table.fnGetPosition(item));
                                }
                            });
                        }

                        reset_metadata();
                        $('.footerButtons').find('button').attr('disabled', 'disabled');

                        set_small_box_message("Eliminar tramite(s)", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
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

        var row = tramites_table.fnGetNodes();

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
        $('#tramite-id').val(data.id);
        $('#tramite-caratula').val(data.caratula);
        $('#tramite-clase').val(data.id_clase);
        $('#tramite-estado').val(data.estado);
        $('#tramite-subzona').val(data.id_subzona);
        $('#tramite-honorarios').val(data.honorarios);
        $('#tramite-sellado').val(data.sellado);


        if (data.fecha_creacion) {
            $('#tramite-fecha-creacion').val(format_date(data.fecha_creacion));
        }

        if (data.fecha_vencimiento) {
            $('#tramite-fecha-vto').datepicker('setDate', format_date(data.fecha_vencimiento));
        }

        if (data.fecha_audiencia) {
            $('#tramite-fecha-audiencia').datepicker('setDate', format_date(data.fecha_audiencia));
        }
        if (data.fecha_aviso) {
            $('#tramite-fecha-aviso').val(format_date(data.fecha_aviso));
        }

        if (data.fecha_retiro) {
            $('#tramite-fecha-retiro').val(format_date(data.fecha_retiro));
        }

        $('#tramite-corresponsales').val(data.id_corresponsal);
        $('#tramite-honorario-corresponsal').val(data.honorario_corresponsal);
        $('#tramite-observaciones').val(data.observaciones);
        $('#tramite-observaciones-cliente').val(data.observaciones_cliente);

    },
    get_data: function () {

        var tramite_data = {};
        tramite_data.id_cliente = id_cliente;
        tramite_data.caratula = $('#tramite-caratula').val();
        tramite_data.id_clase = $('#tramite-clase').val();
        tramite_data.estado = $('#tramite-estado').val();
        tramite_data.id_subzona = $('#tramite-subzona').val();
        tramite_data.honorarios = $('#tramite-honorarios').val();
        tramite_data.sellado = $('#tramite-sellado').val();

        if ($('#tramite-fecha-vto').val() !== '') {
            tramite_data.fecha_vencimiento = format_date_to_save($('#tramite-fecha-vto').val());
        }
        if ($('#tramite-fecha-audiencia').val() !== '') {
            tramite_data.fecha_audiencia = format_date_to_save($('#tramite-fecha-audiencia').val());
        }

        tramite_data.id_corresponsal = $('#tramite-corresponsales').val();
        tramite_data.honorario_corresponsal = $('#tramite-honorario-corresponsal').val();

        tramite_data.observaciones = $('#tramite-observaciones').val();
        tramite_data.observaciones_cliente = $('#tramite-observaciones-cliente').val();

        var json = JSON.stringify(tramite_data);

        return json;
    }
};


//TRAMITES ON CLIENTES

$(document).on('change', '#tramite-clase', function () {

    var duracion = $(this).find(":selected").attr('data-duracion');

    var someDate = new Date();
    someDate.setDate(someDate.getDate() + parseInt(duracion));

    var dd = someDate.getDate();
    var mm = someDate.getMonth() + 1;
    var y = someDate.getFullYear();

    var someFormattedDate = dd + '-' + mm + '-' + y;

    $('#tramite-fecha-vto').datepicker('setDate', someFormattedDate);

});

$(document).on('change', '#tramite-subzona', function () {
    $('#tramite-corresponsales option[data-subzona="' + $(this).val() + '"]').prop('selected', true);
});

$(document).on('click', '#crear-orden-btn', function () {

    var order_items = new Array();
    var row = tramites_table.fnGetNodes();

    row.forEach(function (item) {

        var that = $(item).find('.chbx-item');
        if (that.prop("checked")) {
            order_items.push(parseInt(that.parents('.row-item').attr('id')));
        }
    });

    if (order_items.length > 0) {

        $.ajax({
            url: base_url + "index.php/ordenes/create",
            type: 'POST',
            dataType: 'json',
            data: "id=" + id_cliente + "&order_items=" + JSON.stringify(order_items),
            success: function (data) {

                if (data.status) {

                    reset_metadata();
                    $('.footerButtons').find('button').attr('disabled', 'disabled');
                    set_small_box_message("Crear Orden", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);

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
    } else {
        set_small_box_error_message("Error!", "Por favor seleccione al menos un item para crear la Orden", "#C46A69", "fa fa-times fa-2x fadeInRight animated");
    }
});


$(document).on('click', '.cambiar-estado-btn', function () {

    var estado = $(this).attr('data-estado');
    var tramite_items = new Array();
    var row = tramites_table.fnGetNodes();

    row.forEach(function (item) {

        var that = $(item).find('.chbx-item');
        if (that.prop("checked")) {
            tramite_items.push(parseInt(that.parents('.row-item').attr('id')));
        }
    });

    if (tramite_items.length > 0) {

        $.ajax({
            url: base_url + "index.php/tramites/cambiar_estado",
            type: 'POST',
            dataType: 'json',
            data: "id_cliente=" + id_cliente + "&estado=" + estado + "&tramites=" + tramite_items,
            success: function (data) {

                if (data.status) {

                    row.forEach(function (item) {
                        var that = $(item).find('.chbx-item');
                        if (that.prop("checked")) {
                            $(item).find('.row-estado').text(capitalise(estado));
                        }
                    });

                    set_small_box_message("Cambiar estado", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);

                    if (typeof (data.url) !== 'undefined' && data.url) {

                        $('#impresion-content').attr("src", data.url).load(function () {
                            document.getElementById('impresion-content').contentWindow.print();
                        });
                    }

                } else {
                    set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                }
            }
        });
    } else {
        set_small_box_error_message("Error!", "Por favor seleccione al menos un item", "#C46A69", "fa fa-times fa-2x fadeInRight animated");
    }
});


$(document).on('click', '.reimprimir-btn', function () {

    var constancia = $(this).attr('data-constancia');
    var tramite_items = new Array();
    var row = tramites_table.fnGetNodes();

    row.forEach(function (item) {

        var that = $(item).find('.chbx-item');
        if (that.prop("checked")) {
            tramite_items.push(parseInt(that.parents('.row-item').attr('id')));
        }
    });

    if (tramite_items.length > 0) {

        $.ajax({
            url: base_url + "index.php/tramites/reimprimir",
            type: 'POST',
            dataType: 'json',
            data: "id_cliente=" + id_cliente + "&constancia=" + constancia + "&tramites=" + tramite_items,
            success: function (data) {

                if (data.status) {

                    if (typeof (data.url) !== 'undefined' && data.url) {

                        $('#impresion-content').attr("src", data.url).load(function () {
                            document.getElementById('impresion-content').contentWindow.print();
                        });
                    }

                } else {
                    set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                }
            }
        });
    } else {
        set_small_box_error_message("Error!", "Por favor seleccione al menos un item", "#C46A69", "fa fa-times fa-2x fadeInRight animated");
    }
});


$(document).on('click', '.reenviar-email-btn', function () {

    var email = $(this).attr('data-email');
    var tramite_items = new Array();
    var row = tramites_table.fnGetNodes();

    row.forEach(function (item) {

        var that = $(item).find('.chbx-item');
        if (that.prop("checked")) {
            tramite_items.push(parseInt(that.parents('.row-item').attr('id')));
        }
    });

    if (tramite_items.length > 0) {

        $.ajax({
            url: base_url + "index.php/tramites/reenviar_email",
            type: 'POST',
            dataType: 'json',
            data: "id_cliente=" + id_cliente + "&email=" + email + "&tramites=" + tramite_items,
            success: function (data) {

                if (data.status) {

                    set_small_box_message("Reenviar Email", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);

                } else {
                    set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                }
            }
        });
    } else {
        set_small_box_error_message("Error!", "Por favor seleccione al menos un item", "#C46A69", "fa fa-times fa-2x fadeInRight animated");
    }
});


$(document).on('click', '.codebar-btn', function () {

    var tramite_items = new Array();
    var row = tramites_table.fnGetNodes();

    row.forEach(function (item) {

        var that = $(item).find('.chbx-item');
        if (that.prop("checked")) {
            tramite_items.push(parseInt(that.parents('.row-item').attr('id')));
        }
    });

    if (tramite_items.length > 0) {

        $.ajax({
            url: base_url + "index.php/tramites/imprimir_codebar",
            type: 'POST',
            data: "tramites=" + tramite_items,
            success: function (data) {

                if (data.status) {



                } else {
                    set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
                }
            }
        });
    } else {
        set_small_box_error_message("Error!", "Por favor seleccione al menos un item", "#C46A69", "fa fa-times fa-2x fadeInRight animated");
    }
});

function update_table() {

    $('#info_item_title').text($('#tramite-nombre').val());
    $('.item-selected').children('.row-nombre').text($('#tramite-nombre').val());
    $('.item-selected').children('.row-estado').text(capitalise($('#tramite-estado').val().replace('en_tramite', 'En Trámite')));

    var valor = parseFloat($('#tramite-honorarios').val()) + parseFloat($('#tramite-sellado').val()) + parseFloat($('#tramite-honorario-corresponsal').val());

    $('.item-selected').children('.row-valor').text('$' + valor);
}

//END TRAMITES ON CLIENTES

//PAGE TRAMITES

$(document).on('click', '.search-chbx', function () {
    if ($(this).prop("checked")) {
        $(this).parents('.form-group').find('.metadata').removeAttr('disabled');
    } else {
        $(this).parents('.form-group').find('.metadata').attr('disabled', 'disabled');
        $(this).parents('.form-group').find('.metadata').val('');
    }
});


$(document).on('click', '#buscar-item-btn', function () {

    var search_items = {};
    $('.search-chbx').each(function () {
        if ($(this).prop('checked')) {

            if ($(this).hasClass('data-fecha')) {
                var item_id = $(this).attr('id');
                var fecha_desde = format_date_to_save($(this).parents('.form-group').find('.fecha-desde').val()) + " 00:00:00";
                var fecha_hasta = format_date_to_save($(this).parents('.form-group').find('.fecha-hasta').val()) + " 23:59:59";

                var item_value = new Array();
                item_value.push(fecha_desde, fecha_hasta);

            } else {
                var item_id = $(this).parents('.form-group').find('.metadata').attr('id');
                var item_value = $(this).parents('.form-group').find('.metadata').val();
            }

            search_items[item_id] = item_value;

        }
    });

    var criteria = JSON.stringify(search_items);

    $.ajax({
        url: base_url + "index.php/tramites/search",
        type: 'POST',
        data: "criteria=" + criteria,
        success: function (data) {

            if (data) {

                $('#search-result').html(data);

            } else {
                set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
            }
        }
    });

});


$(document).on('click', '.result-clickeable', function () {

    $('.row-item').removeClass('item-selected');
    $(this).parents('.row-item').addClass('item-selected');

    var tramite_id = $(this).parents('.row-item').attr('id');
    var cliente_id = $(this).parents('.row-item').attr('data-cliente');

    window.location.href = "main#clientes/get_by_id?id=" + cliente_id + "&tramite_id=" + tramite_id;
});