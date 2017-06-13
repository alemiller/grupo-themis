
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
                        <div id="transacciones-saldo">Saldo: $ <?php echo $saldo;?></div>
                    </div>

                    <table id="dt_transacciones" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <!--<th class="col-md-1"><input type="checkbox" id="select-all-items"></th>-->
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Detalle</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($transacciones)) {
                                error_log('esta el cliente');
                                for ($i = 0; $i < sizeof($transacciones); $i++) {
                                   
                                    $fecha_creacion = date('d-m-Y H:i', strtotime($transacciones[$i]->fecha_creacion));
                                    if($transacciones[$i]->tipo){
                                        $titulo = $transacciones[$i]->titulo;
                                    }else{
                                        $titulo = 'Trámite '. $transacciones[$i]->titulo;
                                    }
                                    
                                    $total = str_replace('-','- $',$transacciones[$i]->total);
                                    if(!strpos($total, "$")){
                                        $total = '$' . $total;
                                    }

//                                    $checkbox = "<td class='chbx-item-cell'><input type='checkbox' class='chbx-item' id='" . $transacciones[$i]->id . "'></td>";
                                    $id = "<td>" . $transacciones[$i]->id . "</td>";
                                    $caratula = "<td>" . $titulo . "</td>";
                                    $creacion = "<td>" . $fecha_creacion . " hs.</td>";
                                    $valor = "<td class='row-total-transaccion'>" . $total . "</td>";

                                    echo "<tr'>" .
                                    $id .
                                    $creacion .
                                    $caratula .
                                    $valor .
                                    "</tr>";
                                }
                            }else{
                                error_log('no esta seteado el cliente');
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

//    if(typeof(transacciones_table) !== 'undefined'){
//        transacciones_table.dataTable().fnDestroy();
//    }

    transacciones_table = $('#dt_transacciones').dataTable({
        "sPaginationType": "bootstrap",
        "bLengthChange": false,
        "aaSorting": [],
        "aoColumnDefs": [{
                "aTargets": [0],
                "bSortable": false
            }]
    });
</script>


