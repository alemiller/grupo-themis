<div id="tabla-tramites">
    <div class="row">
      

            <div class="collapse navbar-collapse navbar-default">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="nuevo-item" href="javascript:void(0);">Nuevo Trámite</a>
                    </li>
                    <li>
                        <a class="borrar-item" href="javascript:void(0);">Borrar Trámite(s)</a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"> Cambiar Estado <b class="caret"></b> </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class='cambiar-estado-btn' data-estado='listo' href="javascript:void(0);">Listo</a>
                            </li>
                            <li>
                                <a class='cambiar-estado-btn' data-estado='retirado' href="javascript:void(0);">Retirado</a>
                            </li>
                           
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"> Reimprimir <b class="caret"></b> </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="reimprimir-btn" data-constancia="retiro" href="javascript:void(0);">Orden de Retiro</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"> Reenviar Email <b class="caret"></b> </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="reenviar-email-btn" data-email="listo" href="javascript:void(0);">Trámite Listo</a>
                            </li>
                            <li>
                                <a class="reenviar-email-btn" data-email="retirado" href="javascript:void(0);">Trámite Retirado</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li>
                        <a id="crear-orden-btn" href="javascript:void(0);">Crear Orden Tbjo.</a>
                    </li>
                    
                </ul>
                
                
            </div>

            <br>
     
    </div>
    <?php $this->load->view('templates/cliente/tramites/lista_tramites') ?>
    <?php $this->load->view('templates/cliente/tramites/detalle_tramite') ?>
</div>