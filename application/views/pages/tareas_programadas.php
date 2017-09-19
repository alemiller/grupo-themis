
<div id="tabla-clientes">

    <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-x" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false" role="widget">

        <!-- widget div-->
        <div>

            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->

            </div>
            <!-- end widget edit box -->

            <!-- widget content -->
            <div class="widget-body no-padding">
                <div class="widget-body-toolbar">

                </div>

                <table id="dt_basic" class="table table-striped table-bordered table-hover">
                    <thead >
                        <tr style="background-color:lightblue;">
                            <th>ID Cliente</th>
                            <th>Cliente</th>
                            <th>Email</th>
                            <th></th>

                        </tr>
                    <thead>
                    <tbody>
                        <?php
                        if (isset($tramites)) {

                            for ($i = 0; $i < sizeof($tramites); $i++) {
                                if ($i !== 0) {
                                    ?>
                                    <tr style="background-color:lightblue;">
                                        <th>ID Cliente</th>
                                        <th>Cliente</th>
                                        <th>Email</th>
                                        <th></th>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <tr id="<?php echo $tramites[$i]->cliente->id; ?>" class="cliente-item">
                                    <td><?php echo $tramites[$i]->cliente->id; ?></td>
                                    <td><?php echo $tramites[$i]->cliente->nombre; ?></td>
                                    <td><?php echo $tramites[$i]->cliente->email; ?></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ecf3f8;font-style: italic;">
                                    <td>ID Tramite</td>
                                    <td>Carátula</td>
                                    <td>Fecha Aviso</td>
                                    <td>Valor</td>
                                </tr>
                                <?php
                                for ($t = 0; $t < sizeof($tramites[$i]->tramites); $t++) {
                                    ?>
                                    <tr>
                                        <td><?php echo $tramites[$i]->tramites[$t]->id; ?></td>
                                        <td><?php echo $tramites[$i]->tramites[$t]->caratula; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($tramites[$i]->tramites[$t]->fecha_aviso)); ?></td>
                                        <td><?php echo "$" . $tramites[$i]->tramites[$t]->total; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                        }
                        ?>


                    </tbody>
                </table>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>

</div>


<script type="text/javascript">
    loadScript("<?php echo base_url(); ?>assets/js/clientes.js");

    // DO NOT REMOVE : GLOBAL FUNCTIONS!

    $(document).ready(function () {

        pageSetUp();

        /*
         * BASIC
         */
        clientes_table = $('#dt_basic').dataTable({
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
//clientes_table.fnPageChange(2,true);




    });
</script>