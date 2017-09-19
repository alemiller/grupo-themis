<?php
if (isset($tramite_selected)) {

    $item_tramite_id = $tramite_selected->id;
    $id_clase = $tramite_selected->id_clase;
    $id_subzona = $tramite_selected->id_subzona;
    $caratula = $tramite_selected->caratula;
    $honorarios = $tramite_selected->honorarios;
    $sellado = $tramite_selected->sellado;
    $estado = $tramite_selected->estado;
    $correo = $tramite_selected->correo;
    $nro_envio = $tramite_selected->nro_envio;
    $creado_por = $tramite_selected->creado_por;
    $actualizado_por = $tramite_selected->actualizado_por;
    $fecha_creacion = date('d-m-Y', strtotime($tramite_selected->fecha_creacion));

    if ($tramite_selected->fecha_actualizacion) {
        $fecha_actualizacion = date('d-m-Y', strtotime($tramite_selected->fecha_actualizacion));
    } else {
        $fecha_actualizacion = "";
    }
    if ($tramite_selected->fecha_vencimiento) {
        $fecha_vencimiento = date('d-m-Y', strtotime($tramite_selected->fecha_vencimiento));
    } else {
        $fecha_vencimiento = "";
    }
    if ($tramite_selected->fecha_audiencia) {
        $fecha_audiencia = date('d-m-Y', strtotime($tramite_selected->fecha_audiencia));
    } else {
        $fecha_audiencia = "";
    }
    if ($tramite_selected->fecha_retiro) {
        $fecha_retiro = date('d-m-Y', strtotime($tramite_selected->fecha_retiro));
    } else {
        $fecha_retiro = "";
    }
    if ($tramite_selected->fecha_aviso) {
        $fecha_aviso = date('d-m-Y', strtotime($tramite_selected->fecha_aviso));
    } else {
        $fecha_aviso = "";
    }
    if ($tramite_selected->fecha_envio) {
        $fecha_envio = date('d-m-Y', strtotime($tramite_selected->fecha_envio));
    } else {
        $fecha_envio = "";
    }

    $observacion_id = $tramite_selected->observacion_id;
    $observaciones_cliente = $tramite_selected->observaciones_cliente;
    $id_corresponsal = $tramite_selected->id_corresponsal;
    $honorario_corresponsal = $tramite_selected->honorario_corresponsal;
} else {
    $item_tramite_id = '';
    $id_clase = '';
    $id_subzona = '';
    $caratula = '';
    $honorarios = '';
    $sellado = '';
    $estado = '';
    $correo = '';
    $nro_envio = '';
    $creado_por = '';
    $actualizado_por = '';
    $fecha_creacion = '';
    $fecha_actualizacion = "";
    $fecha_vencimiento = "";
    $fecha_audiencia = "";
    $fecha_retiro = "";
    $fecha_aviso = "";
    $fecha_envio = "";
    $observacion_id = '';
    $observaciones_cliente = '';
    $id_corresponsal = '';
    $honorario_corresponsal = '';
}
?>

<section class="col-md-4">
    <article >

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-10" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

            <header>
                <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                <h2 id="info_item_title"><?php echo $caratula; ?></h2>

                <div class="widget-toolbar hidden-phone">

                </div>

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



                    <div class="jarviswidget well transparent" id="wid-id-9" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

                        <!-- widget div-->
                        <div class="metadata">

                            <div class="widget-body">

                                <div class="panel-group smart-accordion-default" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#informacion-tab"> <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i> Información </a></h4>
                                        </div>
                                        <div id="informacion-tab" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Nro Trámite</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-id" class="form-control readonly metadata" type="text" readonly="readonly" value="<?php echo $item_tramite_id; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">*Carátula</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-caratula" class="form-control metadata mandatory" type="text" disabled="disabled" value="<?php echo $caratula; ?>">
                                                        <span class="mandatory-field-error error-message">Este campo es obligatorio</span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">*Clase</label>
                                                    <div class="col-md-12">
                                                        <select id="tramite-clase" class="form-control metadata mandatory" disabled="disabled">
                                                            <option value="none" selected="selected">Ninguna</option>
                                                            <?php
                                                            if (isset($clases_tramite)) {
                                                                for ($i = 0; $i < sizeof($clases_tramite); $i++) {
                                                                    if ($id_clase === $clases_tramite[$i]->id) {
                                                                        $clase_selected = 'selected="selected"';
                                                                    } else {
                                                                        $clase_selected = '';
                                                                    }

                                                                    echo "<option value='" . $clases_tramite[$i]->id . "' data-duracion='" . $clases_tramite[$i]->duracion . "' " . $clase_selected . ">" . $clases_tramite[$i]->nombre . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select> <i></i> 
                                                        <span class="mandatory-field-error error-message">Este campo es obligatorio</span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Estado</label>
                                                    <div class="col-md-12 select">
                                                        <select id="tramite-estado" class="form-control metadata" disabled="disabled">
                                                            <option value="en_tramite" <?php if ($estado === "" || $estado === "en_tramite") echo 'selected="selected"'; ?>>En trámite</option>
                                                            <option value="enviado" <?php if ($estado === "enviado") echo 'selected="selected"'; ?>>Enviado</option>
                                                            <option value="listo" <?php if ($estado === "listo") echo 'selected="selected"'; ?>>Listo</option>
                                                            <option value="retirado" <?php if ($estado === "retirado") echo 'selected="selected"'; ?>>Retirado</option>
                                                        </select> <i></i> 
                                                    </div>
                                                </div>
                                                <div id="tramite-enviado-content">
                                                    <div class="form-group col-md-12">
                                                        <label class="control-label">Correo</label>
                                                        <div class="col-md-12">
                                                            <input id="tramite-correo" class="form-control metadata" type="text" disabled="disabled" value="<?php echo $correo; ?>">

                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="control-label">Nro. Envío</label>
                                                        <div class="col-md-12">
                                                            <input id="tramite-nro-envio" class="form-control metadata" type="text" disabled="disabled" value="<?php echo $nro_envio; ?>">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Sub-zona</label>
                                                    <div class="col-md-12 select">
                                                        <select id="tramite-subzona" class="form-control metadata" disabled="disabled">
                                                            <option value="none" selected="selected">Ninguna</option>
                                                            <?php
                                                            if (isset($subzonas)) {
                                                                for ($i = 0; $i < sizeof($subzonas); $i++) {

                                                                    if ($id_subzona === $subzonas[$i]->id) {
                                                                        $subzona_selected = 'selected="selected"';
                                                                    } else {
                                                                        $subzona_selected = '';
                                                                    }
                                                                    echo "<option value='" . $subzonas[$i]->id . "' " . $subzona_selected . ">" . $subzonas[$i]->nombre . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select> <i></i> 
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Honorarios</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-honorarios" class="form-control metadata" type="text" disabled="disabled" value="<?php echo $honorarios; ?>">
                                                    </div>
                                                </div> 

                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Sellado</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-sellado" class=" form-control metadata" type="text" disabled="disabled" value="<?php echo $sellado; ?>">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#fechas-tab" class="collapsed"> <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i> Fechas </a></h4>
                                        </div>
                                        <div id="fechas-tab" class="panel-collapse collapse">
                                            <div class="panel-body">

                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Fecha de Creación</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-fecha-creacion" class="form-control readonly fechas-input" type="text" disabled="disabled" value="<?php echo $fecha_creacion; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Fecha de Vencimiento</label>
                                                    <div class="col-md-12">
                                                        <input id='tramite-fecha-vto' type="text" name="mydate" placeholder="Seleccione una fecha" class="form-control datepicker metadata fechas-input" data-dateformat="dd-mm-yy" disabled="disabled" value="<?php echo $fecha_vencimiento; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Fecha de Audiencia</label>
                                                    <div class="col-md-12">
                                                        <input id='tramite-fecha-audiencia' type="text" name="mydate" placeholder="Seleccione una fecha" class="form-control datepicker metadata fechas-input" data-dateformat="dd-mm-yy" disabled="disabled" value="<?php echo $fecha_audiencia; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Fecha de Aviso</label>
                                                    <div class="col-md-12">
                                                        <input id='tramite-fecha-aviso' type="text" name="mydate" placeholder="Seleccione una fecha" class="form-control fechas-input readonly" disabled="disabled"  value="<?php echo $fecha_aviso; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Fecha de Envío</label>
                                                    <div class="col-md-12">
                                                        <input id='tramite-fecha-envio' type="text" name="mydate" placeholder="Seleccione una fecha" class="form-control fechas-input" disabled="disabled"  value="<?php echo $fecha_envio; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Fecha de Retiro</label>
                                                    <div class="col-md-12">
                                                        <input id='tramite-fecha-retiro' type="text" name="mydate" placeholder="Seleccione una fecha" class="form-control fechas-input readonly" disabled="disabled" value="<?php echo $fecha_retiro; ?>">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#corresponsal-tab" class="collapsed"> <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i> Corresponsal </a></h4>
                                        </div>
                                        <div id="corresponsal-tab" class="panel-collapse collapse">
                                            <div class="panel-body">

                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Corresponsal</label>
                                                    <div class="col-md-12 select">
                                                        <select id="tramite-corresponsales" class="form-control metadata" disabled="disabled">
                                                            <option value="none" selected="selected">Ninguno</option>
                                                            <?php
                                                            if (isset($corresponsales)) {
                                                                for ($i = 0; $i < sizeof($corresponsales); $i++) {

                                                                    if ($id_corresponsal === $corresponsales[$i]->id) {
                                                                        $corresponsal_selected = 'selected="selected"';
                                                                    } else {
                                                                        $corresponsal_selected = '';
                                                                    }
                                                                    echo "<option value='" . $corresponsales[$i]->id . "' data-subzona='" . $corresponsales[$i]->id_subzona . "' " . $corresponsal_selected . ">" . $corresponsales[$i]->nombre . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Honorario corresponsal</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-honorario-corresponsal" class=" form-control metadata" type="text" disabled="disabled" value="<?php echo $honorario_corresponsal; ?>">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#observaciones-tab" class="collapsed"> <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i> Observaciones </a></h4>
                                        </div>
                                        <div id="observaciones-tab" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Observaciones</label>
                                                    <div class="col-md-12">
                                                        <select id="tramite-observaciones" class="form-control metadata" disabled="disabled">
                                                            <option value="none" selected="selected">Ninguna</option>
                                                            <?php
                                                            if (isset($tramite_observaciones)) {
                                                                for ($i = 0; $i < sizeof($tramite_observaciones); $i++) {

                                                                    if ($observacion_id === $tramite_observaciones[$i]->id) {
                                                                        $observacion_selected = 'selected="selected"';
                                                                    } else {
                                                                        $observacion_selected = '';
                                                                    }
                                                                    echo "<option value='" . $tramite_observaciones[$i]->id . "'" . $observacion_selected . ">" . $tramite_observaciones[$i]->texto . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Observaciones Cliente</label>
                                                    <div class="col-md-12">
                                                        <textarea id="tramite-observaciones-cliente" class="form-control metadata" type="text" disabled="disabled" rows="7"><?php echo $observaciones_cliente; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#reclamos-tab" class="collapsed"> <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i> Reclamos </a></h4>
                                        </div>
                                        <div id="reclamos-tab" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <?php 
                                                if(isset($reclamos) && sizeof($reclamos) > 0){
                                                    $disabled = "";
                                                }else{
                                                    $disabled = 'disabled="disable"';
                                                }
                                                ?>
                                                <button id="add-reclamo-btn" class="btn btn-default btn-sm" <?php echo $disabled ?>>Agregar Reclamo</button>
                                                
                                                <div id="reclamos-content"></div>
                                                    <?php
                                                     if(isset($reclamos) && sizeof($reclamos) > 0){
                                                         $this->load->view('templates/tramites/reclamos_form',array('reclamos' => $reclamos));
                                                     }
                                                    ?>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#historial-tab" class="collapsed"> <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i> Historial </a></h4>
                                        </div>
                                        <div id="historial-tab" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Creado por</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-creado-por" class=" form-control metadata readonly" type="text" disabled="disabled" readonly="readonly" value="<?php echo $creado_por; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Actualizado por</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-actualizado-por" class="form-control metadata readonly" type="text" disabled="disabled" readonly="readonly" value="<?php echo $actualizado_por; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Última actualización</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-fecha-actualizacion" class="form-control readonly fechas-input" type="text" disabled="disabled" value="<?php echo $fecha_actualizacion; ?>">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <br>
                    <footer class='footerButtons buttons-content'>

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
                    <br>
                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->
    </article>
</section>


