<section class="col-md-4">
    <article >

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-10" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

            <header>
                <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                <h2 id="info_item_title"></h2>

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
                                                    <label class="control-label">ID</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-id" class="form-control readonly metadata" type="text" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Carátula</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-caratula" class="form-control metadata mandatory" type="text" disabled="disabled">
                                                    <span class="mandatory-field-error error-message">Este campo es obligatorio</span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Clase</label>
                                                    <div class="col-md-12">
                                                        <select id="tramite-clase" class="form-control metadata mandatory" disabled="disabled">
                                                            <option value="none" selected="selected">Ninguna</option>
                                                            <?php
                                                            if (isset($clases_tramite)) {
                                                                for ($i = 0; $i < sizeof($clases_tramite); $i++) {
                                                                    echo "<option value='" . $clases_tramite[$i]->id . "' data-duracion='". $clases_tramite[$i]->duracion."'>" . $clases_tramite[$i]->nombre . "</option>";
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
                                                            <option value="en_tramite" selected="selected">En trámite</option>
                                                            <option value="listo">Listo</option>
                                                            <option value="retirado">Retirado</option>
                                                        </select> <i></i> 
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
                                                                    echo "<option value='" . $subzonas[$i]->id . "'>" . $subzonas[$i]->nombre . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select> <i></i> 
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Honorarios</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-honorarios" class="form-control metadata" type="text" disabled="disabled">
                                                    </div>
                                                </div> 

                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Sellado</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-sellado" class=" form-control metadata" type="text" disabled="disabled">
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
                                                        <input id="tramite-fecha-creacion" class="form-control readonly fechas-input" type="text" disabled="disabled">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Fecha de Vencimiento</label>
                                                    <div class="col-md-12">
                                                        <input id='tramite-fecha-vto' type="text" name="mydate" placeholder="Seleccione una fecha" class="form-control datepicker metadata fechas-input" data-dateformat="dd-mm-yy" disabled="disabled">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Fecha de Audiencia</label>
                                                    <div class="col-md-12">
                                                        <input id='tramite-fecha-audiencia' type="text" name="mydate" placeholder="Seleccione una fecha" class="form-control datepicker metadata fechas-input" data-dateformat="dd-mm-yy" disabled="disabled">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Fecha de Aviso</label>
                                                    <div class="col-md-12">
                                                        <input id='tramite-fecha-aviso' type="text" name="mydate" placeholder="Seleccione una fecha" class="form-control datepicker metadata fechas-input" data-dateformat="dd-mm-yy" disabled="disabled">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Fecha de Retiro</label>
                                                    <div class="col-md-12">
                                                        <input id='tramite-fecha-retiro' type="text" name="mydate" placeholder="Seleccione una fecha" class="form-control datepicker metadata" data-dateformat="dd-mm-yy" disabled="disabled">
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
                                                                    echo "<option value='" . $corresponsales[$i]->id . "' data-subzona='". $corresponsales[$i]->id_subzona ."'>" . $corresponsales[$i]->nombre . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Honorario corresponsal</label>
                                                    <div class="col-md-12">
                                                        <input id="tramite-honorario-corresponsal" class=" form-control metadata" type="text" disabled="disabled">
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
                                                        <textarea id="tramite-observaciones" class="form-control metadata" type="text" disabled="disabled"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Observaciones Cliente</label>
                                                    <div class="col-md-12">
                                                        <textarea id="tramite-observaciones-cliente" class="form-control metadata" type="text" disabled="disabled"></textarea>
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