<?php
if (isset($cliente)) {
    $nombre = $cliente->nombre;
    $id = $cliente->id;
    $domicilio = $cliente->domicilio;
    $telefono = $cliente->telefono;
    $password = $cliente->password;
    $email = $cliente->email;
    $como_conocio = $cliente->como_nos_conocio;
    $saldo_inicial = $cliente->saldo_inicial;
} else {
    $nombre = "";
    $id = "";
    $domicilio = "";
    $telefono = "";
    $password = "";
    $email = "";
    $como_conocio = "";
    $saldo_inicial = "";
}
?>

<form id="form-datos" class="smart-form">
    <fieldset>
        <div class="row">
            <section class="col col-4">
                <label class="label">Nombre y Apellido</label>
                <label class="input">
                    <input type="text" id="cliente-nombre" class="cliente-metadata" value="<?php echo $nombre; ?>">
                </label>
            </section>
            <section class="col col-4">
                <label class="label">ID</label>
                <label class="input">
                    <input id="cliente-id" class="readonly cliente-metadata" type="text" readonly="readonly" value="<?php echo $id; ?>">
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-4">
                <label class="label">Domicilio</label>
                <label class="input">
                    <input id="cliente-domicilio" class="cliente-metadata" type="text" value="<?php echo $domicilio; ?>">
                </label>
            </section>
            <section class="col col-4">
                <label class="label">Tomo/Folio/Colegio</label>
                <label class="input">
                    <input id="cliente-tomo" class="cliente-metadata" type="text" >
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-4">
                <label class="label">Teléfono</label>
                <label class="input">
                    <input id="cliente-telefono" class="cliente-metadata" type="text" value="<?php echo $telefono; ?>">
                </label>
            </section>


            <section class="col col-4">
                <label class="label">Contraseña</label>
                <label class="input">
                    <input id="cliente-contrasena" class="cliente-metadata" type="text" value="<?php echo $password; ?>">
                </label>
            </section> 
        </div>
        <div class="row">
            <section class="col col-4">
                <label class="label">Email</label>
                <label class="input">
                    <input id="cliente-email" class=" cliente-metadata" type="text" value="<?php echo $email; ?>">
                </label>
            </section>

            <section class="col col-4">
                <label class="label">Cómo nos conoció</label>
                <label class="select">
                    <select id="cliente-conocio">
                        <option value="ninguno" <?php if($como_conocio === "")  echo 'selected="selected"'; ?>>Ninguno</option>
                        <option value="volante" <?php if($como_conocio === "volante") echo 'selected="selected"'; ?>>Volante</option>
                        <option value="recomendacion" <?php if($como_conocio === "recomendacion") echo 'selected="selected"'; ?>>Recomendación</option>
                        <option value="internet" <?php if($como_conocio === "internet") echo 'selected="selected"'; ?>>Internet</option>
                        <option value="otro" <?php if($como_conocio === "otro") echo 'selected="selected"'; ?>>Otro</option>
                    </select> <i></i> 
                </label>
            </section>

        </div>
        <div class="row">
            <section class="col col-4">
                <label class="label">Saldo Inicial</label>
                <label class="input">
                    <input id="cliente-saldo-inicial" class=" cliente-metadata" type="number" value="<?php echo $saldo_inicial; ?>">
                </label>
            </section>
        </div>
    </fieldset>
</form>
<footer class="col-md-12">
    <button id="guardar-cliente-btn" type="submit" class="btn btn-primary">
        Guardar
    </button>
    <button id="crear-cliente-btn" type="submit" class="btn btn-primary" style="display:none">
        Crear
    </button>
    <button id="cancelar-cliente-btn" type="button" class="btn btn-default">
        Cancelar
    </button>
    <button id="volver-cliente-btn" type="button" class="btn btn-default">
        Volver
    </button>
</footer>