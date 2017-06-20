$(document).on('click', '.cliente-item', function () {

    container.html('<h1 class="loadingMsg"><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
    window.location.href = "main#clientes/get_by_id?id=" + $(this).attr('id');

});

$(document).on('click', '#nuevo-cliente-btn', function () {
    window.location.href = "main#clientes/new_client";
});

$(document).on('submit', '#search-by-tramite-form', function (event) {
    event.preventDefault();
    var tram_id = $('#search-tramite-id').val();
    $.ajax({
        url: base_url + "index.php/tramites/get_by_id",
        type: 'POST',
        dataType: 'json',
        data: "id=" + tram_id,
        success: function (data) {
            if (data) {

                if (typeof (data.id_cliente) !== 'undefined') {
                    window.location.href = "main#clientes/get_by_id?id=" + data.id_cliente + "&tramite_id=" + tram_id;
                } else {
                    set_small_message("Información", "No existe el trámite buscado", "#dfb56c", "fa fa-warning fa-2x fadeInRight animated", 4000);
                }


            } else {
                set_small_box_error_message("Error!", "Se produjo un error interno", "#C46A69", "fa fa-times fa-2x fadeInRight animated");
            }
        }
    });

});


$(document).on('click', '#crear-cliente-btn', function () {

    var cliente_data = {};

    cliente_data.nombre = $('#cliente-nombre').val();
    cliente_data.domicilio = $('#cliente-domicilio').val();
    cliente_data.telefono = $('#cliente-telefono').val();
    cliente_data.email = $('#cliente-email').val();
    cliente_data.password = $('#cliente-contrasena').val();
    cliente_data.conocio = $('#cliente-conocio').val();
    cliente_data.saldo_inicial = $('#cliente-saldo-inicial').val();

    var json = JSON.stringify(cliente_data);

    $.ajax({
        url: base_url + "index.php/clientes/create",
        type: 'POST',
        dataType: 'json',
        data: "data=" + json,
        success: function (data) {
            if (data.status) {

                id_cliente = data.data.id;
                $('#cliente-id').val(data.data.id);
                $('#cliente-title-name').html(data.data.nombre);
                $("#crear-cliente-btn").hide();
                $("#guardar-cliente-btn").show();
                set_small_box_message("Creación", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);


            } else {
                set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
            }
        }
    });

});


$(document).on('click', '#guardar-cliente-btn', function () {

    var cliente_data = {};

    cliente_data.nombre = $('#cliente-nombre').val();
    cliente_data.domicilio = $('#cliente-domicilio').val();
    cliente_data.telefono = $('#cliente-telefono').val();
    cliente_data.email = $('#cliente-email').val();
    cliente_data.password = $('#cliente-contrasena').val();
    cliente_data.conocio = $('#cliente-conocio').val();
    cliente_data.saldo_inicial = $('#cliente-saldo-inicial').val();

    var json = JSON.stringify(cliente_data);
    console.log(cliente_data);
    $.ajax({
        url: base_url + "index.php/clientes/update",
        type: 'POST',
        dataType: 'json',
        data: "data=" + json + "&id=" + $('#cliente-id').val(),
        success: function (data) {
            if (data.status) {
                set_small_box_message("Actualización", data.msg, "#659265", "fa fa-check fa-2x fadeInRight animated", 4000);
            } else {
                set_small_box_error_message("Error!", data.msg, "#C46A69", "fa fa-times fa-2x fadeInRight animated");
            }
        }
    });

});


$(document).on('click', '#cancelar-cliente-btn', function () {
    reset_cliente_form();
});

$(document).on('click', '#volver-cliente-btn', function () {

    container.html('<h1 class="loadingMsg"><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
    window.location.href = "main#clientes";
});

$(document).on('click', '#volver-lista-btn', function () {

    container.html('<h1 class="loadingMsg"><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
    window.location.href = "main#clientes";
});


function reset_cliente_form() {
    $("#cliente-title-name").text("");
    $(".cliente-metadata").val("");
    $('#cliente-conocio').val("ninguno");
}


$(document).on('click', '#ordenes-tab-btn', function () {

    if (typeof (id_cliente) !== "" && id_cliente) {
        $('#orden-detalle-content').html('');
        $('#tabla-ordenes').html('<h1 class="loadingMsg"><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
        $.ajax({
            url: base_url + "index.php/ordenes/list_ordenes",
            type: 'POST',
            data: "id_cliente=" + id_cliente,
            success: function (data) {
                $('#tabla-ordenes').html(data);
            }
        });
    }

});

$(document).on('click', '#cta-cte-tab-btn', function () {

    if (typeof (id_cliente) !== "" && id_cliente) {

        $('#tabla-cta-cte').html('<h1 class="loadingMsg"><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
        $.ajax({
            url: base_url + "index.php/cta_cte/get_transacciones",
            type: 'POST',
            data: "id=" + id_cliente,
            success: function (data) {
                $('#tabla-cta-cte').html(data);
            }
        });
    }


});