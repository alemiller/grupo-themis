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

                <table id="search-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <!--<th class="col-md-1"><input type="checkbox" id="select-all-items"></th>-->
                        
                            <th>Nro.</th>
                            <th>Creación</th>
                            <th>Cliente</th>
                            <th>Caratula</th>
                            <th>Clase</th>
                            <th>Estado</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < sizeof($tramites); $i++) {


                            $fecha_creacion = date('d-m-Y', strtotime($tramites[$i]->fecha_creacion));

//                                    $checkbox = "<td class='chbx-item-cell'><input type='checkbox' class='chbx-item' id='" . $tramites[$i]->id . "'></td>";
                           
                            $tramite_id = "<td class='result-clickeable'>" . $tramites[$i]->id . "</td>";
                            $creacion = "<td class='result-clickeable'>" . $fecha_creacion . "</td>";
                            $cliente = "<td class='result-clickeable'>" . $tramites[$i]->nombre . "</td>";
                            $caratula = "<td class='row-nombre result-clickeable'>" . $tramites[$i]->caratula . "</td>";
                            $clase = "<td class='row-nombre result-clickeable'>" . $tramites[$i]->clase_tramite . "</td>";
                            $estado = "<td class='row-estado result-clickeable'>" . ucwords(str_replace('en_tramite', 'en trámite', $tramites[$i]->estado)) . "</td>";
                            $valor = "<td class='row-valor result-clickeable'>$" . $tramites[$i]->total . "</td>";
                           

                            echo "<tr class='row-item' id='" . $tramites[$i]->id . "' data-cliente='" . $tramites[$i]->id_cliente."'>" .
                           
                            $tramite_id .
                            $creacion .
                            $cliente .
                            $caratula .
                            $clase .
                            $estado .
                            $valor .
                             
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

<script>


    search_table = $('#search-table').dataTable({
        "sPaginationType": "bootstrap",
        "bLengthChange": false,
        "aaSorting": [],
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        }
    });



</script>