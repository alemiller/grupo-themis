$(document).on('click', '#add-reclamo-btn', function () {
    var item_count = $('.reclamo-item').length + 1;
    $('#reclamos-content').prepend('<div id="reclamo-item-' + item_count + '" class="reclamo-item"></div>');
    $("#reclamo-item-" + item_count).load(base_url + "assets/js/templates/reclamo.html", function () {
    });
});

$(document).on('click', '.crear-reclamo-btn', function () {

    var parent = $(this).parents('.reclamo-item');
    var data = {};
    data['reclamo'] = parent.find('.reclamo-texto').val();
    data['tramite_id'] = $('#tramite-id').val();

    var json = JSON.stringify(data);

    $.ajax({
        url: base_url + "index.php/reclamos/create",
        type: 'POST',
        dataType: 'json',
        data: "data=" + json,
        success: function (data) {

            if (data.status) {

                set_small_box_message("Creación", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);

                parent.find('.reclamo-id').val(data.reclamo.id);
                parent.find('.reclamo-fecha-creacion').val(data.reclamo.fecha_creacion);
                parent.find('.crear-reclamo-btn').hide();
                parent.find('.guardar-reclamo-btn').show();
                parent.find('.imprimir-reclamo-btn').removeAttr('disabled');
                parent.find('.eliminar-reclamo-btn').removeAttr('disabled');

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
});

$(document).on('click', '.guardar-reclamo-btn', function () {

    var parent = $(this).parents('.reclamo-item');
    var data = {};
    data['reclamo'] = parent.find('.reclamo-texto').val();
    var reclamo_id = parent.find('.reclamo-id').val();

    var json = JSON.stringify(data);

    $.ajax({
        url: base_url + "index.php/reclamos/update",
        type: 'POST',
        dataType: 'json',
        data: "id=" + reclamo_id + "&data=" + json,
        success: function (data) {

            if (data.status) {

                set_small_box_message("Guardar", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);

            } else {
                set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
            }
        }
    });
});

$(document).on('click', '.eliminar-reclamo-btn', function () {

    var parent = $(this).parents('.reclamo-item');
    var reclamo_id = parent.find('.reclamo-id').val();

    $.ajax({
        url: base_url + "index.php/reclamos/delete",
        type: 'POST',
        dataType: 'json',
        data: "id=" + reclamo_id,
        success: function (data) {

            if (data.status) {

                set_small_box_message("Eliminar", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
                parent.remove();
            } else {
                set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
            }
        }
    });
});

$(document).on('click', '.imprimir-reclamo-btn', function () {

    var parent = $(this).parents('.reclamo-item');
    var reclamo_id = parent.find('.reclamo-id').val();

    $.ajax({
        url: base_url + "index.php/reclamos/imprimir",
        type: 'POST',
        dataType: 'json',
        data: "id=" + reclamo_id,
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
});

function add_reclamos_form(reclamos) {

    reclamos.forEach(function (reclamo) {

        var item_count = $('.reclamo-item').length + 1;
        $('#reclamos-content').prepend('<div id="reclamo-item-' + item_count + '" class="reclamo-item"></div>');
        $("#reclamo-item-" + item_count).load(base_url + "assets/js/templates/reclamo.html", function () {
            
            $('#reclamo-item-' + item_count).find('.reclamo-id').val(reclamo.id);
            $('#reclamo-item-' + item_count).find('.reclamo-fecha-creacion').val(reclamo.fecha_creacion);
            $('#reclamo-item-' + item_count).find('.reclamo-texto').val(reclamo.reclamo);
            $('#reclamo-item-' + item_count).find('.crear-reclamo-btn').hide();
            $('#reclamo-item-' + item_count).find('.guardar-reclamo-btn').show();
            $('#reclamo-item-' + item_count).find('.eliminar-reclamo-btn').removeAttr('disabled');
            $('#reclamo-item-' + item_count).find('.imprimir-reclamo-btn').removeAttr('disabled');
        });

    })
}
