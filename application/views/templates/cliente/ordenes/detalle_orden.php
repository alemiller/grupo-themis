<?php 
if (isset($orden->tramites) && $orden->tramites) {

    ?>
    <section id="widget-grid" class="col-md-7">

        <!-- NEW WIDGET START -->
        <article  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blue" id="wid-id-0" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-collapsed="false" data-widget-togglebutton="false" data-widget-colorbutton="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2><?php echo 'Orden Nro. ' . $orden->orden->id; ?> - Detalle de Trámites</h2>

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


                        <table id="dt_detalle_orden" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>

                                    <th>Nro.</th>
                                    <th>Fecha de Creación</th>
                                    <th>Carátula</th>
                                    <th>Clase</th>
                                    <th>Estado</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < sizeof($orden->tramites); $i++) {

                                    $fecha_creacion = date('d-m-Y', strtotime($orden->tramites[$i]->fecha_creacion));
                                    $id = "<td>" . $orden->tramites[$i]->id . "</td>";
                                    $creacion = "<td >" . $fecha_creacion . "</td>";
                                    $caratula = "<td >" . $orden->tramites[$i]->caratula . "</td>";
                                    $clase = "<td >" . $orden->tramites[$i]->nombre . "</td>";
                                    $estado = "<td >" . ucwords(str_replace('en_tramite', 'en trámite', $orden->tramites[$i]->estado)). "</td>";

                                    echo "<tr>" .
                                    $id .
                                    $creacion .
                                    $caratula .
                                    $clase .
                                    $estado .
                                    "</tr>";
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
    <?php
}
?>