<div id="detalle-cliente" >

    <!-- row -->
    <div class="row">
        <article  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="well well-sm well-light col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                        <h3 id="cliente-title-name" >
                            <?php
                            if (isset($cliente)) {
                                echo $cliente->nombre;
                            }
                            ?>
                            <br>
                            <small></small></h3>
                    </div>
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8 text-align-right">
                        <button id="volver-lista-btn" type="submit" class="btn btn-default">
                            Volver
                        </button>

                    </div>
                </div>
                <div id="tabs" class="nav nav-tabs">
                    <ul>
                        <li>
                            <a data-toggle="tab" href="#tabs-datos" data-page="datos_personales">Datos Personales</a>
                        </li>
                        <li class="active">
                            <a data-toggle="tab" href="#tabs-tramites" data-page="tramites">Trámites</a>
                        </li>
                        <li>
                            <a id="ordenes-tab-btn" data-toggle="tab" href="#tabs-ordenes" data-page="ordenes">Ordenes Trabajo</a>
                        </li>
                        <li>
                            <a id="pagos-tab" data-toggle="tab" href="#tabs-pagos" data-page="pagos">Pagos</a>
                        </li>
                        <li>
                            <a id="cta-cte-tab-btn" data-toggle="tab" href="#tabs-cta" data-page="cta_cte">Cuenta Corriente</a>
                        </li>
                    </ul>
                    <div id="tabs-datos">
                        <?php $this->load->view('templates/cliente/datos_personales/tab_datos_personales') ?>
                    </div>
                    <div id="tabs-tramites">
                        <?php $this->load->view('templates/cliente/tramites/tab_tramites') ?>
                    </div>
                    <div id="tabs-ordenes">
                        <?php $this->load->view('templates/cliente/ordenes/tab_ordenes') ?>
                    </div>
                    <div id="tabs-pagos">
                        <?php $this->load->view('templates/cliente/pagos/tab_pagos') ?>
                    </div>
                    <div id="tabs-cta">
                        <div id="tabla-cta-cte">

                        </div>
                    </div>
                </div>

            </div>

        </article>
    </div>

</div>
<iframe id="impresion-content"></iframe>
<script type="text/javascript">
    loadScript("<?php echo base_url(); ?>assets/js/clientes.js", dt_1);

    function dt_1() {
        loadScript("<?php echo base_url(); ?>assets/js/tramites.js", dt_2);
    }

    function dt_2() {
        loadScript("<?php echo base_url(); ?>assets/js/pagos.js", dt_3);
    }

    function dt_3() {
        loadScript("<?php echo base_url(); ?>assets/js/ordenes.js", dt_4);
    }

    function dt_4() {
        loadScript("<?php echo base_url(); ?>assets/js/reclamos.js");
    }

    // DO NOT REMOVE : GLOBAL FUNCTIONS!

    $(document).ready(function () {

        id_cliente = null;
        pageSetUp();
        $('#tabs').tabs();

<?php if (!isset($cliente)) {
    ?>
            $("#guardar-cliente-btn").hide();
            $("#crear-cliente-btn").show();
            $("#tabs").tabs("option", "active", 0);
            page = 'datos_personales';
<?php } else {
    ?>
            $("#tabs").tabs("option", "active", 1);
            page = 'tramites';
            id_cliente = <?php echo $cliente->id; ?>
    <?php
}
?>

        /*
         * BASIC
         */
        tramites_table = $('#dt_tramites').dataTable({
            "sPaginationType": "bootstrap",
            "bLengthChange": false,
            "aaSorting": [],
            "aoColumnDefs": [{
                    "aTargets": [0],
                    "bSortable": false
                }]
        });



        pagos_table = $('#dt_pagos').dataTable({
            "sPaginationType": "bootstrap",
            "bLengthChange": false,
            "aaSorting": [],
            "aoColumnDefs": [{
                    "aTargets": [0],
                    "bSortable": false
                }]
        });

        /* END BASIC */

        /* Add the events etc before DataTables hides a column */
        $("#datatable_fixed_column thead input").keyup(function () {
            oTable.fnFilter(this.value, oTable.oApi._fnVisibleToColumnIndex(oTable.fnSettings(), $("thead input").index(this)));
        });

        $("#datatable_fixed_column thead input").each(function (i) {
            this.initVal = this.value;
        });
        $("#datatable_fixed_column thead input").focus(function () {
            if (this.className == "search_init") {
                this.className = "";
                this.value = "";
            }
        });
        $("#datatable_fixed_column thead input").blur(function (i) {
            if (this.value == "") {
                this.className = "search_init";
                this.value = this.initVal;
            }
        });


        var oTable = $('#datatable_fixed_column').dataTable({
            "sDom": "<'dt-top-row'><'dt-wrapper't><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
            //"sDom" : "t<'row dt-wrapper'<'col-sm-6'i><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'>>",
            "oLanguage": {
                "sSearch": "Search all columns:"
            },
            "bSortCellsTop": true
        });



        /*
         * COL ORDER
         */
        $('#datatable_col_reorder').dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "R<'dt-top-row'Clf>r<'dt-wrapper't><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
            "fnInitComplete": function (oSettings, json) {
                $('.ColVis_Button').addClass('btn btn-default btn-sm').html('Columns <i class="icon-arrow-down"></i>');
            }
        });

        /* END COL ORDER */

        /* TABLE TOOLS */
        $('#datatable_tabletools').dataTable({
            "sDom": "<'dt-top-row'Tlf>r<'dt-wrapper't><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
            "oTableTools": {
                "aButtons": ["copy", "print", {
                        "sExtends": "collection",
                        "sButtonText": 'Save <span class="caret" />',
                        "aButtons": ["csv", "xls", "pdf"]
                    }],
                "sSwfPath": "js/plugin/datatables/media/swf/copy_csv_xls_pdf.swf"
            },
            "fnInitComplete": function (oSettings, json) {
                $(this).closest('#dt_table_tools_wrapper').find('.DTTT.btn-group').addClass('table_tools_group').children('a.btn').each(function () {
                    $(this).addClass('btn-sm btn-default');
                });
            }
        });

        /* END TABLE TOOLS */

<?php
//Si hay un tramite seleccionado busca el tramite en la tabla y pagina hasta encontrarlo
if (isset($tramite_selected)) {
    ?>

            var id_tramite_seleced = <?php echo $tramite_selected->id; ?>;
            var row = tramites_table.fnGetNodes();
            var i = 0;

            $('.metadata').removeAttr('disabled');
            $('.footerButtons').find('button').removeAttr('disabled');

            row.forEach(function (item) {

                if ($(item).children('td:eq( 1 )').text() === id_tramite_seleced.toString()) {
                    var page_nbr = Math.ceil(((i + 1) / 10));

                    if (page_nbr > 0) {
                        tramites_table.fnPageChange((page_nbr - 1), true);
                    }
                    return true;
                }
                i++;
            });
    <?php
}
?>


    });


    $(document).on('click', '.ui-tabs-anchor', function () {
        page = $(this).attr('data-page');
    });





</script>

