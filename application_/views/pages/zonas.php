<script>
    arr = window.location.href.split('#');
    page = arr[arr.length - 1];
    if (page.indexOf('/') > -1) {
        page_tmp = page.split('/');
        page = page_tmp[0];
    }
</script>
<section id="widget-grid" class="">

    <div class="collapse navbar-collapse navbar-default navbar-custom">
        <ul class="nav navbar-nav">
            <li>
                <a id="nueva-clcase-btn" class="nuevo-item" href="javascript:void(0);">Nueva Zona</a>
            </li>
            <li>
                <a id="borrar-zona-btn" class="borrar-item" href="javascript:void(0);">Borrar Zona(s)</a>
            </li>
        </ul>
    </div> 
    <br>
    <div class="row">
        <article class="col-sm-8">

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

                        <table id="zonas-table" class="table table-striped table-bordered table-hover main-grid">
                            <thead>
                                <tr>
                                    <th class="col-md-1"><input type="checkbox" id="select-all-items"></th>
                                    <th>ID</th>
                                    <th>Nombre</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($zonas)) {

                                    for ($i = 0; $i < sizeof($zonas); $i++) {
                                        ?>
                                        <tr id="<?php echo $zonas[$i]->id; ?>" class="row-item">
                                            <td class='chbx-item-cell'><input type='checkbox' class='chbx-item'></td>
                                            <td class="clickeable-item"><?php echo $zonas[$i]->id; ?></td>
                                            <td class="row-nombre clickeable-item"><?php echo $zonas[$i]->nombre; ?></td> 
                                        </tr>

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


        </article>

        <article class="col-sm-4">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-10" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                    <h2 id="info_item_title" class='profile'></h2>
                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">
                        <div class="metadata">
                            <div class='form-group col-md-12'>
                                <label class=' control-label'>ID</label>
                                <div class='col-md-12'>
                                    <input id='zona-id' class='form-control metadata'  type='text' disabled="disabled" readonly="readonly"/>
                                </div>
                            </div>

                            <div class='form-group col-md-12'>
                                <label class=' control-label'>*Nombre</label>
                                <div class='col-md-12'>
                                    <input id='zona-nombre' class='form-control metadata mandatory'  type='text' disabled="disabled"/>
                                    <span class="mandatory-field-error error-message">Este campo es obligatorio</span>
                                </div>
                            </div>
                        </div>


                        <footer class='footerButtons butoons-content'>

                            <button id='guardar-item-btn' type="submit" class="btn btn-primary" disabled="true">
                                Guardar
                            </button>
                            <button id='crear-item-btn' type="submit" class="btn btn-primary" disabled="true" style="display: none">
                                Crear
                            </button>

                            <button id='cancelar-btn' type="button" class="btn btn-default"  disabled="true">
                                Cancelar
                            </button>
                            <div class="save_waiting"><i class="fa fa-cog fa-spin"></i> Por favor, espere</div>
                        </footer>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->
        </article>

    </div>
</section>
<script type="text/javascript">
    loadScript("<?php echo base_url(); ?>assets/js/zonas.js");

    // DO NOT REMOVE : GLOBAL FUNCTIONS!

    $(document).ready(function () {

        pageSetUp();

        /*
         * BASIC
         */
        zonas_table = $('#zonas-table').dataTable({
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
    });


    $('#tabs').tabs();



</script>