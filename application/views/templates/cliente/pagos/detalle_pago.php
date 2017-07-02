<section class="col-md-4">
    <article >

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-10" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

            <header>
                <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                <h2 id="info_pago_title"></h2>

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
                <div class="widget-body">





                    <!-- widget div-->
                    <div class="pagos-metadata">


                        <div class="pagos-metadata">
                            <div class="form-group col-md-12">
                                <label class="control-label">Nro Pago</label>
                                <div class="col-md-12">
                                    <input id="pago-id" class="form-control readonly pagos-metadata" type="text" readonly="readonly">
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">Clase</label>
                                <div class="col-md-12">
                                    <select id="pago-clase" class="form-control pagos-metadata pago-mandatory" disabled="disabled">
                                        <option value="1" selected="selected">Efectivo</option>

                                    </select> <i></i> 
                                    <span class="pago-mandatory-field-error error-message">Este campo es obligatorio</span>
                                </div>
                            </div>
                            <div class='form-group col-md-12'>
                                <label class=' control-label'>Valor</label>
                                <div class='col-md-12'>
                                    <input id='pago-valor' class='form-control pagos-metadata pago-mandatory'  type='number' disabled="disabled" min="0"/>   
                                    <span class="pago-mandatory-field-error error-message">Este campo es obligatorio</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <br>
                    <footer class='pago-footer-buttons buttons-content'>

                        <button id='guardar-pago-btn' type="submit" class="btn btn-primary" disabled="true">
                            Guardar
                        </button>
                        <button id='crear-pago-btn' type="submit" class="btn btn-primary" disabled="true" style="display: none">
                            Crear
                        </button>

                        <button id='cancelar-pago-btn' type="button" class="btn btn-default"  disabled="true">
                            Cancelar
                        </button>
                        <div class="pago-save-waiting"><i class="fa fa-cog fa-spin"></i> Por favor, espere</div>
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