function setPredefinedDates(value) {

    var today = new Date();

    switch (value) {

        case 'today':
            $('#start_date').datepicker("setDate", today);
            $('#start_date_val').datepicker("setDate", today);
            $('#end_date').datepicker("setDate", today);
            $('#end_date_val').datepicker("setDate", today);
            break;
        case 'month-to-date':
            var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
            $('#start_date').datepicker("setDate", firstDayOfMonth);
            $('#start_date_val').datepicker("setDate", firstDayOfMonth);
            $('#end_date').datepicker("setDate", today);
            $('#end_date_val').datepicker("setDate", today);
            break;
        case 'year-to-date':
            var firstDayOfYear = new Date(today.getFullYear(), 0, 1);
            $('#start_date').datepicker("setDate", firstDayOfYear);
            $('#start_date_val').datepicker("setDate", firstDayOfYear);
            $('#end_date').datepicker("setDate", today);
            $('#end_date_val').datepicker("setDate", today);
            break;
        case 'last-30-days':
            var fromThirty = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);
            $('#start_date').datepicker("setDate", fromThirty);
            $('#start_date_val').datepicker("setDate", fromThirty);
            $('#end_date').datepicker("setDate", today);
            $('#end_date_val').datepicker("setDate", today);
            break;
        case 'last-7-days':
            var fromSeven = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
            $('#start_date').datepicker("setDate", fromSeven);
            $('#start_date_val').datepicker("setDate", fromSeven);
            $('#end_date').datepicker("setDate", today);
            $('#end_date_val').datepicker("setDate", today);
            break;
        case 'all':
            $('#start_date').datepicker("setDate", new Date(2014, 0, 1));
            $('#start_date_val').datepicker("setDate", new Date(0));
            $('#end_date').datepicker("setDate", today);
            $('#end_date_val').datepicker("setDate", today);
            break;
    }
}

$(document).ready(function () {

    $('#ingresos-report-btn').on('click', function (event) {

        event.preventDefault();

        if ($('#start_date_val').val() === "" || $('#end_date_val').val() === "") {
            set_small_box_message('Revise los campos de fecha', 'Debe seleccionar fechas desde hasta', '#C46A69');
            return;
        }

        var start_date = format_date_to_save($('#start_date_val').val());
        var end_date = format_date_to_save($('#end_date_val').val());


        $('#btn_export_registered_users').attr('disabled', 'disabled');

        $.ajax({
            url: base_url + "index.php/estadisticas/ingresos_report",
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date
            }, beforeSend: function () {

                $('#ingresos_container').html('<h1 class="loadingMsg"><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
            },
            success: function (data) {

                $('#ingresos_container').html(data);
                $('#btn_export_registered_users').removeAttr('disabled');
            }

        });
    });
});


