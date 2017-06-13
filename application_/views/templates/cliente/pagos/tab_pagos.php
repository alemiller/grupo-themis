<div id="tabla-pagos">
    <div class="row">
      

            <div class="collapse navbar-collapse navbar-default">
                <ul class="nav navbar-nav">
                    <li>
                        <a id="nuevo-pago" href="javascript:void(0);">Nuevo Pago</a>
                    </li>
                    <li>
                        <a id="borrar-pago" href="javascript:void(0);">Borrar Pago(s)</a>
                    </li>
                    
                </ul>
                
                
            </div>

            <br>
     
    </div>
    <?php $this->load->view('templates/cliente/pagos/lista_pagos') ?>
    <?php $this->load->view('templates/cliente/pagos/detalle_pago') ?>
</div>


