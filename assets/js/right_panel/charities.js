$(document).on('click', '#save-charities-btn', function () {

    $('#charities_list').dataTable().fnClearTable();

    $('#charities-entries-table > tbody > tr').each(function () {
        if (!$(this).children('td').hasClass("dataTables_empty")) {
            var img = $(this).find('img').attr('src');
            var title = $(this).find('.charityName').text();
            var id = $(this).find('.charity-result-item').attr('id');

            $('#charities_list').dataTable().fnAddData([
                "<div data-id='" + id + "' class='imgFrame celebImg'><img class='mediaThum celebThumb'src='" + img + "'/></div>",
                title,
            ]);
        }
    });

    $('#charities-entries-table .charity-result-item').prop('checked', false);


    $("#charities_details").fadeOut(400, function () {
        $("#main-container").fadeIn();
    });


});

$(document).on('click', '#remove-charities', function () {
    $('.charity-result-item').each(function () {
        if (this.checked) {
            var id = $(this).attr('id');
            $('#' + id, charitiesTable.fnGetNodes()).prop('checked', false);
            $('#' + id, charitiesTable.fnGetNodes()).removeAttr('disabled');
            editedCharitiesTable.fnDeleteRow(editedCharitiesTable.fnGetPosition($(this).parents('tr')[0]));
        }

    });
    var order = 1;
    $('#charities-entries-table > tbody .charityOrder').each(function () {
        editedCharitiesTable.fnUpdate(order, editedCharitiesTable.fnGetPosition($(this).parents('tr')[0]), 0);
        $(this).text(order);
        order++;
    });
});

function initializeCharitiesTables() {
    
    charitiesTable = $('#charity-list').dataTable({
        "sPaginationType": "bootstrap",
        "bLengthChange": false
    });


    editedCharitiesTable = $('#charities-entries-table').dataTable({
        "bPaginate": false,
        "aoColumns": [
            {"sClass": "charityOrder"},
            {"sClass": ""},
            {"sClass": ""},
            {"sClass": "charityName"}
        ],
        "fnRowCallback": function (row, data, index) {
            //$('td', row).eq(0).text(index);
        },
        "fnCreatedRow": function (row, data, dataIndex) {
            $(row).attr('id', 'row-' + dataIndex);
        },
        "fnUpdateAjaxReqest": function () {
        }
    });

    editedCharitiesTable.rowReordering();

    charitiesFinalTable = $('#charities_list').dataTable({
        "bFilter": false,
        "bPaginate": false,
        "aoColumns": [
            {"sClass": ""},
            {"sClass": "charityName"},
        ],
    });


    $('#charities_details  #charitiesContent').find(".dataTables_info").closest('.col-sm-6').switchClass('col-sm-6', 'col-sm-12');
    $('#charities_details #charitiesContent').find(".dataTables_paginate").closest('.col-sm-6').switchClass('col-sm-6', 'col-sm-12');
    $('#charities_list_wrapper .dt-bottom-row').find(".dataTables_info").closest('.col-sm-6').switchClass('col-sm-6', 'col-sm-12');
    /* END BASIC */

}

$(document).on('click', '#insert-charities-item', function () {
    $('.charity-item:checked', charitiesTable.fnGetNodes()).each(function () {
        var img = $(this).parents('tr').children('td.celeThumbContent').children('div').children('img').attr('src');
        var title = $(this).parents('tr').children('td.charityTitle').text();
        var id = $(this).attr('id');
        fnClickAddCharityRow(img, title, id);
        this.checked = true;
        this.disabled = true;
    });
});

function fnClickAddCharityRow(img, title, id) {
    var charity = $('#charities-entries-table #' + id);
    if (charity.length == 0) {
        editedCharitiesTable.dataTable().fnAddData([
            $('#charities-entries-table .charityOrder').length,
            "<input type='checkbox' id='" + id + "' class='charity-result-item'>",
            "<div data-id='" + id + "' class='imgFrame celebImg'><img class='mediaThum celebThumb'src='" + img + "'/></div>",
            title,
        ]);
    }
}



$(document).on('click', '#select-all-result-charities-item', function () {

    if ($('#select-all-result-charities-item:checked').length > 0) {
        select_all = true;
    } else {
        select_all = false;
    }

    $('.charity-result-item').each(function () {
        if (this.checked) {
            if (!select_all) {
                this.checked = false;
            } else {
                this.checked = true;
            }

        } else {
            if (select_all) {
                this.checked = true;
            } else {
                this.checked = false;
            }
        }
    });

    if ($('.charity-result-item:checked').length > 0) {
        $('#remove-charities').removeAttr('disabled');
    } else {
        $('#remove-charities').attr('disabled', true);
    }
});


$(document).on('click', '.charity-result-item', function () {
    if ($('.charity-result-item:checked').length > 0) {
        $('#remove-charities').removeAttr('disabled');
    } else {
        $('#remove-charities').attr('disabled', true);
    }
});


$(document).on('click', '#select-all-charities', function () {

    if ($('#select-all-charities:checked').length > 0) {
        select_all = true;
    } else {
        select_all = false;
    }

    $('.charity-item').each(function () {
        if (this.checked) {
            if (!select_all) {
                this.checked = false;
            } else {
                this.checked = true;
            }

        } else {
            if (select_all) {
                this.checked = true;
            } else {
                this.checked = false;
            }
        }
    });


});

function reset_charities_table() {
    
    $("#edit-charities").removeAttr('disabled');
    $('#charities_list').dataTable().fnClearTable();
    $('#charities-entries-table').dataTable().fnClearTable();
    $('.charity-item', charitiesTable.fnGetNodes()).removeAttr('disabled');
    $('#select-all-charities').removeAttr('disabled');
    $('#select-all-charities').prop("checked", false);
    $('.charity-item', charitiesTable.fnGetNodes()).each(function () {
        this.checked = false;

    });
}


