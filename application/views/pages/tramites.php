<section class="col-md-3">
    <article >

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-10" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

            <header>
                <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                <h2>Buscar</h2>

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

                                                    <label class="control-label"><input type="checkbox" class="search-chbx"> Nro Trámite</label>
                                                    <div class="col-md-12">
                                                        <input id="id" class="form-control metadata" type="text" value="" disabled="disabled">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="control-label"><input type="checkbox" class="search-chbx"> Clase</label>
                                                    <div class="col-md-12">
                                                        <select id="id_clase" class="form-control metadata" disabled="disabled">
                                                            <option value="none" selected="selected">Ninguna</option>
                                                            <?php
                                                            if (isset($clases_tramite)) {
                                                                for ($i = 0; $i < sizeof($clases_tramite); $i++) {


                                                                    echo "<option value='" . $clases_tramite[$i]->id . "'>" . $clases_tramite[$i]->nombre . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select> <i></i> 

                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label"><input type="checkbox" class="search-chbx"> Estado</label>
                                                    <div class="col-md-12 select">
                                                        <select id="estado" class="form-control metadata" disabled="disabled">
                                                            <option value="en_tramite">En trámite</option>
                                                            <option value="listo">Listo</option>
                                                            <option value="retirado">Retirado</option>
                                                        </select> <i></i> 
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label"><input type="checkbox" class="search-chbx"> Sub-zona</label>
                                                    <div class="col-md-12 select">
                                                        <select id="id_subzona" class="form-control metadata" disabled="disabled">
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
                                                    <label class="control-label"><input id="fecha_creacion" type="checkbox" class="search-chbx data-fecha"> Fecha de Creación</label>

                                                    <br>
                                                    <div class="col-md-12">    
                                                        <label class="control-label">Desde</label>
                                                        <input id="fecha_creacion_desde" name="mydate" class="form-control datepicker metadata fecha-desde" type="text"  data-dateformat="dd-mm-yy" disabled="disabled" value="">
                                                    </div>
                                                    <br>

                                                    <div class="col-md-12">
                                                        <label class="control-label">Hasta</label>
                                                        <input id="fecha_creacion_hasta" name="mydate" class="form-control datepicker metadata fecha-hasta" type="text" data-dateformat="dd-mm-yy" disabled="disabled" value="">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="control-label"><input id="fecha_vencimiento" type="checkbox" class="search-chbx data-fecha"> Fecha de Vencimiento</label>
                                                    <div class="col-md-12">    
                                                        <label class="control-label">Desde</label>
                                                        <input id="fecha_vencimiento_desde" name="mydate" class="form-control datepicker metadata fecha-desde" type="text"  data-dateformat="dd-mm-yy" disabled="disabled" value="">
                                                    </div>
                                                    <br>

                                                    <div class="col-md-12">
                                                        <label class="control-label">Hasta</label>
                                                        <input id="fecha_vencimiento_hasta" name="mydate" class="form-control datepicker metadata fecha-hasta" type="text" data-dateformat="dd-mm-yy" disabled="disabled" value="">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <label class="control-label"><input id="fecha_audiencia" type="checkbox" class="search-chbx data-fecha"> Fecha de Audiencia</label>
                                                    <div class="col-md-12">    
                                                        <label class="control-label">Desde</label>
                                                        <input id="ffecha_audiencia_desde" name="mydate" class="form-control datepicker metadata fecha-desde" type="text"  data-dateformat="dd-mm-yy" disabled="disabled" value="">
                                                    </div>
                                                    <br>

                                                    <div class="col-md-12">
                                                        <label class="control-label">Hasta</label>
                                                        <input id="fecha_audiencia_hasta" name="mydate" class="form-control datepicker metadata fecha-hasta" type="text" data-dateformat="dd-mm-yy" disabled="disabled" value="">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <label class="control-label"><input id="fecha_aviso" type="checkbox" class="search-chbx data-fecha"> Fecha de Aviso</label>
                                                    <div class="col-md-12">    
                                                        <label class="control-label">Desde</label>
                                                        <input id="fecha_aviso_desde" name="mydate" class="form-control datepicker metadata fecha-desde" type="text"  data-dateformat="dd-mm-yy" disabled="disabled" value="">
                                                    </div>
                                                    <br>

                                                    <div class="col-md-12">
                                                        <label class="control-label">Hasta</label>
                                                        <input id="fecha_aviso_hasta" name="mydate" class="form-control datepicker metadata fecha-hasta" type="text" data-dateformat="dd-mm-yy" disabled="disabled" value="">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <label class="control-label"><input id="fecha_retiro" type="checkbox" class="search-chbx data-fecha"> Fecha de Retiro</label>
                                                    <div class="col-md-12">    
                                                        <label class="control-label">Desde</label>
                                                        <input id="fecha_retiro_desde" name="mydate" class="form-control datepicker metadata fecha-desde" type="text"  data-dateformat="dd-mm-yy" disabled="disabled" value="">
                                                    </div>
                                                    <br>

                                                    <div class="col-md-12">
                                                        <label class="control-label">Hasta</label>
                                                        <input id="fecha_retiro_hasta" name="mydate" class="form-control datepicker metadata fecha-hasta" type="text" data-dateformat="dd-mm-yy" disabled="disabled" value="">
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
                                                    <label class="control-label"><input type="checkbox" class="search-chbx"> Corresponsal</label>
                                                    <div class="col-md-12 select">
                                                        <select id="id_corresponsal" class="form-control metadata" disabled="disabled">
                                                            <option value="none" selected="selected">Ninguno</option>
                                                            <?php
                                                            if (isset($corresponsales)) {
                                                                for ($i = 0; $i < sizeof($corresponsales); $i++) {


                                                                    echo "<option value='" . $corresponsales[$i]->id . "'>" . $corresponsales[$i]->nombre . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
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

                        <button id='buscar-item-btn' type="submit" class="btn btn-primary">
                            Buscar
                        </button>

                        <button id='cancelar-btn' type="button" class="btn btn-default">
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

<section id="search-result" class="col-md-9">

</section>

<script type="text/javascript">
    loadScript("<?php echo base_url(); ?>assets/js/tramites.js");

    $(document).ready(function () {

        pageSetUp();
    })
</script>