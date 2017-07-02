

<section id="widget-grid" class="">

    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-md-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-sortable" id="wid-id-1" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget" style="position: relative; opacity: 1;">

                <header role="heading"><div class="jarviswidget-ctrls" role="menu"></div>

                    <span class="widget-icon"> <i class="fa fa-filter"></i> </span>
                    <h2><strong>Ingresos. Elija un período</strong></h2>				
                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>

                </header>

                <!-- widget div-->
                <div role="content">

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">

                        <form>

                            <div class="row">

                                <div class="col-sm-2">

                                    <div class="form-group">

                                        <label>Desde:</label>
                                        <div class="input-group">
                                            <input id="start_date" type="text" name="mydate" placeholder="Date from" class="form-control" >
                                            <input id="start_date_val" type="hidden" />
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">

                                        <label>Hasta:</label>
                                        <div class="input-group">
                                            <input id="end_date" type="text" name="mydate" placeholder="Date to" class="form-control" >
                                            <input id="end_date_val" type="hidden" />
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <label>Filtros predefinidos:</label>
                                    <div class="btn-group">
                                        <a href="javascript:setPredefinedDates('today');" class="btn btn-default">Hoy</a>
                                        <a href="javascript:setPredefinedDates('last-7-days');" class="btn btn-default">Ultimos 7 días</a>
                                        <a href="javascript:setPredefinedDates('month-to-date');" class="btn btn-default">Mes actual</a>
                                        <a href="javascript:setPredefinedDates('last-30-days');" class="btn btn-default">Ultimos 30 días</a>
                                        <a href="javascript:setPredefinedDates('year-to-date');" class="btn btn-default">Año actual</a>
                                        <a href="javascript:setPredefinedDates('all');" class="btn btn-default">Todos</a>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions">

                                <div class="row">
                                    <div class="col-md-12">
                                        <button id="ingresos-report-btn" class="btn btn-primary" type="submit">
                                            <i class="fa fa-cog"></i>
                                            Generar
                                        </button>
                                        <!--                                        <button id="btn_export_registered_users" class="btn btn-primary" disabled="disabled">
                                                                                    <i class="fa fa-save"></i>
                                                                                    Export to Excel
                                                                                </button>-->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </article>

        <div id="ingresos_container" class="col-md-12">

        </div>    
    </div>
</section>

<div class="jarviswidget" id="wid-id-6" data-widget-togglebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-collapsed="false">

    <header>
        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
        <h2>Trámites</h2>

    </header>

    <!-- widget div-->
    <div>

        <!-- widget edit box -->
        <div class="jarviswidget-editbox">
            <!-- This area used as dropdown edit box -->

        </div>
        <!-- end widget edit box -->

        <!-- widget content -->
        <div class="widget-body no-padding">

            <div id="donut-graph" class="chart no-padding"></div>

        </div>
        <!-- end widget content -->

    </div>
    <!-- end widget div -->

</div>

<script src="<?php echo base_url(); ?>assets/js/plugin/morris/raphael.2.1.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugin/morris/morris.min.js"></script>

<script>

    loadScript("<?php echo base_url(); ?>assets/js/estadisticas.js");


    $(document).ready(function () {

        pageSetUp();


        if ($('#donut-graph').length) {
            Morris.Donut({
                element: 'donut-graph',
                data: [
<?php
$item = '';
for ($i = 0; $i < sizeof($count_tramites); $i++) {
    if ($i !== 0) {
        $item .= ",";
    }
    $item .= "{value:" . $count_tramites[$i]->total . ",label:'" . ucwords(str_replace('_', ' ', $count_tramites[$i]->estado)) . "'}";
}
echo $item;
?>

                ],
                formatter: function (x) {
                    return x;
                }
            });
        }


        $('#start_date').datepicker({
            showButtonPanel: true,
            dateFormat: 'dd-mm-yy',
            prevText: '&lt;',
            nextText: '&gt;',
            altField: '#start_date_val',
            altFormat: 'dd-mm-yy'
        });

        $('#end_date').datepicker({
            showButtonPanel: true,
            dateFormat: 'dd-mm-yy',
            prevText: '&lt;',
            nextText: '&gt;',
            altField: '#end_date_val',
            altFormat: 'dd-mm-yy'
        });
    });
</script>