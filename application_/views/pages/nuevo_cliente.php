<div id="detalle-cliente" >

    <!-- row -->
    <div class="row">
        <article  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="well well-sm well-light col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                        <h3 id="cliente-title-name" >
                            <?php echo $cliente->cliente->nombre; ?>
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
                            <a data-toggle="tab" href="#tabs-datos">Datos Personales</a>
                        </li>
                        <li class="active">
                            <a data-toggle="tab" href="#tabs-tramites">Trámites</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#tabs-cta">Cuenta Corriente</a>
                        </li>
                    </ul>
                    <div id="tabs-datos">
                        <?php $this->load->view('templates/tab_datos_personales') ?>

                    </div>
                    <div id="tabs-tramites">
                        <?php $this->load->view('templates/tab_tramites') ?>
                    </div>
                    <div id="tabs-cta">
                        <p>
                            Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.
                        </p>
                    </div>
                </div>

            </div>

        </article>
    </div>

</div>

<script type="text/javascript">
    loadScript("<?php echo base_url(); ?>assets/js/clientes.js");

    // DO NOT REMOVE : GLOBAL FUNCTIONS!

    $(document).ready(function () {

        reset_cliente_form();
        $("#guardar-cliente-btn").hide();
        $("#crear-cliente-btn").show();

        pageSetUp();

        /*
         * BASIC
         */
        tramites_table = $('#dt_tramites').dataTable({
            "sPaginationType": "bootstrap",
            "bLengthChange": false,
            "aaSorting": []
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
    });


    $('#tabs').tabs();



</script>