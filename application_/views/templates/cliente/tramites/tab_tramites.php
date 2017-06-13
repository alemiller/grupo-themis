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
                    <li>
                        <a id="crear-orden-btn" href="javascript:void(0);">Crear Orden Tbjo.</a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"> Imprimir <b class="caret"></b> </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0);">Action</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Another action</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Something else here</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Separated link</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">One more separated link</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                
                
            </div>

            <br>
     
    </div>
    <?php $this->load->view('templates/cliente/tramites/lista_tramites') ?>
    <?php $this->load->view('templates/cliente/tramites/detalle_tramite') ?>
</div>