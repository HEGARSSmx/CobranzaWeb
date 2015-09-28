<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("Location: /Cobranza/login.php");
}
$lEdit = FALSE;
$idAgente = filter_input(INPUT_GET, "idAgente");
$nombre = filter_input(INPUT_GET, "nombre");
$clave = filter_input(INPUT_GET, "clave");
$row = array();
$row['idAgente'] = '';
$row['nombre'] = '';
$row['clave'] = '';
$row['direccion'] = '';
$row['telefono'] = '';
$row['movil'] = '';
$row['email'] = '';
if ($idAgente != "") {
    include '../dataBaseClass/connection.php';
    $cDb = new DataBase();
    $result = $cDb->select(array("idAgente", "nombre", "clave", "direccion", "telefono", "movil", "email"), "agente", "idAgente = '$idAgente'", "", "");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $lEdit = TRUE;
    }
}
$cEncabezado = ($lEdit ? "Editando: " . $row['nombre'] : "Agregar agente");
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button
            <h1 class="modal-title"><?php echo $cEncabezado; ?></h1>
        </div>
        <div class="modal-body well" style="margin: 20px;">
            <form action="UpdateAgente.php" id="inputForm">
                <input class="hidden" name="nombreOriginal" value="<?php echo $nombre; ?>">
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputIdAgente">Id Agente:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control input-sm" id="inputIdAgente" name="idAgente" placeholder="Id del agente" readonly
                               value="<?php echo $idAgente; ?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputNombre">Nombre:</label>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control input-sm" id="inputNombre" name="nombre" placeholder="Nombre del agente" 
                               value="<?php echo $row['nombre']; ?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputClave">Clave:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control input-sm" id="inputClave" name="clave" placeholder="Clave del agente" 
                               value="<?php echo $row['clave']; ?>">             
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputDireccion">Direccion:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <textarea class="form-control input-sm" id="inputDireccion" name="direccion" placeholder="Direccion del agente"><?php echo $row['direccion']; ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputEmail">Email:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <input type="email" class="form-control input-sm" id="inputEmail" name="email" placeholder="Correo electronico" 
                               value="<?php echo $row['email']; ?>">             
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputTelefono">Telefono:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control input-sm" id="inputTelefono" name="telefono" placeholder="Telefono del agente" 
                               value="<?php echo $row['telefono']; ?>">             
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputMovil">Movil:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control input-sm" id="inputMovil" name="movil" placeholder="Telefono Movil del agente" 
                               value="<?php echo $row['movil']; ?>">             
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="progress" id="progress">
                <div class="progress-bar progress-bar-striped active" role="progressbar" style=" width: 100%;">Guardando</div>
            </div>
            <span id="mensaje"></span> 
            <button type="button" class="btn btn-primary" data-dissmiss="modal" id="btnGuardar">Guardar cambios</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#progress").hide();
        $("#btnGuardar").click(function (e) {
            $("#progress").show();
            var postData = $("#inputForm").serialize();
            $.ajax({
                type: 'POST',
                url: "/Cobranza/php/Catalogos/UpdateAgente.php",
                data: postData,
                cache: false,
                dataType: 'json',
                beforeSubmit: function () {
                    $("#mensaje").html("");
                    $("#progress").show();
                },
                success: function (data) {
                    $("#progress").hide();
                    if (data.correcto) {
                        muestraMensaje(data.mensaje, 'success');
                        $("#MyModal").modal('hide');

                    } else {
                        $("#mensaje").html("<span style='color:#cc0000'>Error:</span> " + data.mensaje);
                    }
                },
                error: function () {
                    $("#progress").hide();
                    $("#mensaje").html("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo</span> ");
                }
            });
        });
    });
</script>
