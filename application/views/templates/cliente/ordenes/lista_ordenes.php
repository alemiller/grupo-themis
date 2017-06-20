
<section id="widget-grid" class="col-md-5">

    <!-- NEW WIDGET START -->
    <article  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blue" id="wid-id-0" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-collapsed="false" data-widget-togglebutton="false" data-widget-colorbutton="false">



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

                    <table id="dt_ordenes" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col-md-1"><input type="checkbox" id="select-all-items"></th>
                                <th>Nro.</th>
                                <th>Fecha de Creación</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($ordenes)) {
                        
                                for ($i = 0; $i < sizeof($ordenes); $i++) {
                                   
                                    $fecha_creacion = date('d-m-Y H:i', strtotime($ordenes[$i]->fecha_creacion));

                                    $checkbox = "<td class='chbx-item-cell'><input type='checkbox' class='chbx-item' id='" . $ordenes[$i]->id . "'></td>";
                                    $id = "<td class='ordenes-clickeable-item'>" . $ordenes[$i]->id . "</td>";
                                    $creacion = "<td class='ordenes-clickeable-item'>" . $fecha_creacion . " hs.</td>";


                                    echo "<tr id='". $ordenes[$i]->id. "' class='row-item'>" .
                                    $checkbox.
                                    $id .
                                    $creacion .

                                    "</tr>";
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

</section>


<script>

    ordenes_table = $('#dt_ordenes').dataTable({
        "sPaginationType": "bootstrap",
        "bLengthChange": false,
        "aaSorting": [],
        "aoColumnDefs": [{
                "aTargets": [0],
                "bSortable": false
            }]
    });
</script>


