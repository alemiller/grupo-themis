
<!-- NEW WIDGET START -->
<article class="col-xs-8 col-sm-18 col-md-8 col-lg-8 no-padding">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
            <h2>Gráfico Ingresos</h2>

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

                <div id="saleschart" class="chart"></div>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->


<section id="widget-grid" class="col-md-4 no-padding">

    <!-- NEW WIDGET START -->
    <article  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blue" id="wid-id-0" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-collapsed="false" data-widget-togglebutton="false" data-widget-colorbutton="false">

            <header>
                <span class="widget-icon"> <i class="fa fa-dollar"></i> </span>
                <h2>Total de Ingresos</h2>

            </header>

            <!-- widget div-->
            <div>

                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                    <!-- This area used as dropdown edit box -->

                </div>
                <!-- end widget edit box -->

                <!-- widget content -->
                <div class="widget-body" style="text-align: center;">
                    <p>
                        <?php
                        $first_item = $ingresos[0];
                        $last_item = $ingresos[sizeof($ingresos) - 1];

                        $total = 0;
                        for ($i = 0; $i < sizeof($ingresos); $i++) {
                            $total += abs($ingresos[$i]->valor);
                        }
                        ?>
                    <h5>Período</h5>
                    <h5><?php echo date('d-m-Y', strtotime($first_item->fecha)); ?> al <?php echo date('d-m-Y', strtotime($last_item->fecha)); ?></h5>

                    <h4><b><?php echo 'Total: $ ' . $total; ?></b></h4>
                    </p>
                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
    </article>
</section>


<script src="<?php echo base_url(); ?>assets/js/plugin/flot/jquery.flot.cust.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugin/flot/jquery.flot.resize.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugin/flot/jquery.flot.fillbetween.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugin/flot/jquery.flot.orderBar.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugin/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugin/flot/jquery.flot.tooltip.js"></script>

<script type="text/javascript">
    // PAGE RELATED SCRIPTS

    /* chart colors default */
    var $chrt_border_color = "#efefef";
    var $chrt_grid_color = "#DDD"
    var $chrt_main = "#E24913";
    /* red       */
    var $chrt_second = "#6595b4";
    /* blue      */
    var $chrt_third = "#FF9F01";
    /* orange    */
    var $chrt_fourth = "#7e9d3a";
    /* green     */
    var $chrt_fifth = "#BD362F";
    /* dark red  */
    var $chrt_mono = "#000";

    $(document).ready(function () {

        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        pageSetUp();

        /* sales chart */

        if ($("#saleschart").length) {
<?php
error_log('ingresos: ' . json_encode($ingresos));
$items = array();
for ($i = 0; $i < sizeof($ingresos); $i++) {

    $item = array();
    array_push($item, intval(strtotime($ingresos[$i]->fecha) . '000'));
    array_push($item, abs($ingresos[$i]->valor));

    array_push($items, $item);
}
error_log('items :' . json_encode($items));
?>

            var d = <?php echo json_encode($items); ?>;

            for (var i = 0; i < d.length; ++i)
                d[i][0] += 60 * 60 * 1000;

            function weekendAreas(axes) {
                var markings = [];
                var d = new Date(axes.xaxis.min);
                // go to the first Saturday
                d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
                d.setUTCSeconds(0);
                d.setUTCMinutes(0);
                d.setUTCHours(0);
                var i = d.getTime();
                do {
                    // when we don't set yaxis, the rectangle automatically
                    // extends to infinity upwards and downwards
                    markings.push({
                        xaxis: {
                            from: i,
                            to: i + 2 * 24 * 60 * 60 * 1000
                        }
                    });
                    i += 7 * 24 * 60 * 60 * 1000;
                } while (i < axes.xaxis.max);

                return markings;
            }

            var options = {
                xaxis: {
                    mode: "time",
                    tickLength: 5
                },
                series: {
                    lines: {
                        show: true,
                        lineWidth: 1,
                        fill: true,
                        fillColor: {
                            colors: [{
                                    opacity: 0.1
                                }, {
                                    opacity: 0.15
                                }]
                        }
                    },
                    //points: { show: true },
                    shadowSize: 0
                },
                selection: {
                    mode: "x"
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: $chrt_border_color,
                    borderWidth: 0,
                    borderColor: $chrt_border_color,
                },
                tooltip: true,
                tooltipOpts: {
                    content: "Los ingresos el <b>%x</b> fueron <span>$%y</span>",
                    dateFormat: "%d-%0m-%0y",
                    defaultTheme: false
                },
                colors: [$chrt_second],

            };

            var plot = $.plot($("#saleschart"), [d], options);
        }
        ;
    });
</script>