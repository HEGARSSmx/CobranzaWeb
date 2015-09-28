<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("Location: /Cobranza/login.php");
}
$lEdit = FALSE;
$id = filter_input(INPUT_GET, "idTipo");
if ($id != "") {
    include '../dataBaseClass/connection.php';
    $cDb = new DataBase();
    $result = $cDb->select(array("idTipo", "nombre", "descripcion"), "TipoPoliza", "", "", "");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $lEdit = TRUE;
    }
}
$cEncabezado = ($lEdit ? "Editando: " . $row['nombre'] : "Nuevo Tipo de Poliza");
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button
            <h1 class="modal-title"><?php echo $cEncabezado; ?></h1>
        </div>
        <div class="modal-body" style="margin: 20px;">
            <form action="GuardaTipoPoliza.php" id="inputForm">
                <div class="form-group">
                    <label class="control-label" for="inputId">Id:</label>
                    <input type="text" class="form-control input-sm" id="inputId" name="IdTipo" placeholder="Identificador del Tipo"
                           value="<?php echo $id; ?>" <?php echo ($lEdit ? "readonly" : ""); ?>>
                </div>

                <div class="form-group">
                    <label class="control-label" for="inputNombre">Nombre:</label>
                    <input type="text" class="form-control input-sm" id="inputNombre" name="nombre" placeholder="Nombre" value="<?php echo $row['nombre']; ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputDireccion">Descripci&oacute;n:</label>
                    <textarea maxlength="150" class="form-control input-sm" id="inputdescripcion" name="descripcion" placeholder="descripcion"><?php echo $row['descripcion']; ?></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="progress" id="progress">
                <div class="progress-bar progress-bar-striped active" role="progressbar" style=" width: 100%;">Guardando</div>
            </div>
            <span id="mensaje"></span> 
            <button type="button" class="btn btn-primary" data-dissmiss="modal" id="btnGuardar">Guardar</button>
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
                url: "/Cobranza/php/Catalogos/GuardaTipoPoliza.php",
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
