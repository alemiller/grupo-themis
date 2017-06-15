<?php
if (isset($tramite_selected)) {
    $tramite_selected_id = $tramite_selected->id;
} else {
    $tramite_selected_id = null;
}
?>
<section id="widget-grid" class="col-md-8">

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

                    <table id="dt_tramites" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col-md-1"><input type="checkbox" id="select-all-items"></th>
                                <th>ID</th>
                                <th>Creación</th>
                                <th>Caratula</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($cliente)) {

                                for ($i = 0; $i < sizeof($tramites); $i++) {
                                   
                                    if ($tramite_selected_id && $tramite_selected_id === $tramites[$i]->id) {
                                        $item_selected = 'item-selected';
                                       
                                    } else {
                                        $item_selected = '';
                                    }

                                    $fecha_creacion = date('d-m-Y H:i', strtotime($tramites[$i]->fecha_creacion));

                                    $checkbox = "<td class='chbx-item-cell'><input type='checkbox' class='chbx-item' id='" . $tramites[$i]->id . "'></td>";
                                    $tramite_id = "<td class='clickeable-item'>" . $tramites[$i]->id . "</td>";
                                    $caratula = "<td class='row-nombre clickeable-item'>" . $tramites[$i]->caratula . "</td>";
                                    $creacion = "<td class='clickeable-item'>" . $fecha_creacion . " hs.</td>";
                                    $estado = "<td class='row-estado clickeable-item'>" . ucwords(str_replace('en_tramite', 'en trámite', $tramites[$i]->estado)) . "</td>";

                                    echo "<tr class='row-item " . $item_selected . "' id='" . $tramites[$i]->id . "'>" .
                                    $checkbox .
                                    $tramite_id .
                                    $creacion .
                                    $caratula .
                                    $estado .
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




