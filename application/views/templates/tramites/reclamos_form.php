<?php
$reclamos = array_reverse($reclamos);
for ($i = 0; $i < sizeof($reclamos); $i++) {
    ?>
    <div id="<?php echo "reclamo-item-". ($i+1); ?>" class="reclamo-item">
        <div class="form-group col-md-12">
            <label class="control-label">Reclamo Nro.</label>
            <div class="col-md-12">
                <input class="reclamo-id form-control readonly" type="text" value="<?php echo $reclamos[$i]->id; ?>">
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label">Fecha de Creación</label>
            <div class="col-md-12">
                <input class="reclamo-fecha-creacion form-control readonly fechas-input" type="text"  value="<?php echo $reclamos[$i]->fecha_creacion; ?>">
            </div>
        </div>

        <div class="form-group col-md-12">
            <label class="control-label">Reclamo</label>
            <div class="col-md-12">
                <textarea class="reclamo-texto form-control metadata" rows="7"><?php echo $reclamos[$i]->reclamo; ?></textarea>
            </div>
        </div>

        <footer>
            <button type="submit" class="guardar-reclamo-btn btn btn-primary">
                Guardar
            </button>
            <button type="button" class="eliminar-reclamo-btn btn btn-default">
                Eliminar
            </button>
            <button type="button" class="imprimir-reclamo-btn btn btn-default">
                Imprimir
            </button>
            <div class="save_waiting"><i class="fa fa-cog fa-spin"></i> Por favor, espere</div>
        </footer>
        <hr>
    </div>
    <?php
}
?>