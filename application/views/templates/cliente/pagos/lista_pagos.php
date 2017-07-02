
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

                    <table id="dt_pagos" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col-md-1"><input type="checkbox" id="select-all-items"></th>
                                <th>Nro Pago</th>
                                <th>Fecha</th>
                                <th>Detalle</th>
                                <th>Valor</th>
                       
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($cliente)) {

                                for ($i = 0; $i < sizeof($pagos); $i++) {
                                 
                                    $fecha_creacion = date('d-m-Y H:i', strtotime($pagos[$i]->fecha_creacion));
                                          
                                    $checkbox = "<td class='chbx-item-cell'><input type='checkbox' class='chbx-item' id='" . $pagos[$i]->id . "'></td>";
                                    $tramite_id = "<td class='pagos-clickeable-item'>" . $pagos[$i]->id . "</td>";
                                    $creacion = "<td class='pagos-clickeable-item'>" . $fecha_creacion . " hs.</td>";
                                    $detalle = "<td class='row-nombre pagos-clickeable-item'>" . $pagos[$i]->title . "</td>";
                                    $valor = "<td class='row-valor pagos-clickeable-item'>$ " . str_replace("-","",strval($pagos[$i]->valor)) . "</td>";
                                    

                                    echo "<tr class='row-item' id='" . $pagos[$i]->id . "'>" .
                                    $checkbox .
                                    $tramite_id .
                                    $creacion.
                                    $detalle.
                                    $valor .
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




