<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("Location: /Cobranza/login.php");
}

include './dataBaseClass/connection.php';
$cDb = new DataBase();

$lEdit = FALSE;
$idCompania = filter_input(INPUT_GET, "idCompania");
$sQuery = "SELECT idTipo, nombre, 0 as marcado FROM TipoPoliza as cat ";
if ($idCompania != "") {
    $sQuery = "SELECT idTipo, nombre, if(EXISTS(SELECT idTipo FROM TipoPolizaCompania where idTipo = cat.idTipo AND idCompania = $idCompania),1,0) as marcado FROM TipoPoliza as cat ";
    $query = "SELECT * FROM Companias WHERE idCompania = $idCompania";
    $result = $cDb->query($query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $lEdit = TRUE;
    }
}
$cEncabezado = ($lEdit ? "Editando: " . $row['nombre'] : "Compañia Nueva");
$resultTipos = $cDb->query($sQuery);
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button
            <h1 class="modal-title"><?php echo $cEncabezado; ?></h1>
        </div>
        <div class="modal-body well" style="margin: 20px;">
            <form action="#" id="inputForm">
                <input type="hidden" id="IdCompania" name="IdCompania" value="<?php echo $idCompania; ?>">
                <div class="form-group">
                    <label class="control-label" for="inputNombre">Nombre:</label>
                    <input type="text" class="form-control input-sm" id="inputNombre" name="nombre" placeholder="Nombre" value="<?php echo $row['nombre']; ?>" required>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputDireccion">Direcci&oacute;n:</label>
                    <textarea maxlength="150" class="form-control input-sm" id="inputDireccion" name="direccion" placeholder="Dirección"><?php echo $row['direccion']; ?></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputTelefono">Tel&eacute;fono:</label>
                    <input type="tel" class="form-control input-sm" id="inputTelefono" placeholder="Telefono" name="telefono" value="<?php echo $row['telefono']; ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputPortal">Portal:</label>
                    <input type="url" class="form-control input-sm" pattern="https?://.+" id="inputPortal" placeholder="http://www.miportal.com" name="portal" value="<?php echo $row['portal']; ?>">
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">Tipos de p&oacute;lizas disponibles para usar con la compa&ntilde;&iacute;a</div>
                    <table id="tblTiposDisponibles" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Clave tipo de p&oacute;liza</th>
                                <th>Nombre tipo de p&oacute;liza</th>
                                <th>Disponible</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($resultTipos)) { ?>
                                <tr>
                                    <td><?php echo $row['idTipo'] ?></td>
                                    <td><?php echo $row['nombre'] ?></td>
                                    <td style="vertical-align: middle;"><input type="checkbox" class="checkbox checkbox-inline" id="disponible" name="chkTipoPoliza[]" value="<?php echo $row['idTipo']; ?>" <?php echo ($row['marcado'] == 1 ? "checked" : "") ?>></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="progress" id="progress">
                <div class="progress-bar progress-bar-striped active" role="progressbar" style=" width: 100%;">Guardando</div>
            </div>
            <button type="button" class="btn btn-primary" data-dissmiss="modal" id="btnGuardar" onclick="guardar()">Guardar</button>
        </div>
    </div>
</div>
<script>
    function validaDatos(){
        var nombre = $("#inputNombre").val();
        
        if(nombre===""){
            muestraMensaje("Debe de Capturar el Nombre de la compañia",'error');
            $("#inputNombre").focus();
            return false;
        }
        return true;
    }
    function guardar() {
        if (!validaDatos()){
            return;
        }
        $("#progress").show();
        var postData = $("#inputForm").serialize();
        $.ajax({
            type: 'POST',
            url: "/Cobranza/php/GuardaCompania.php",
            data: postData,
            cache: false,
            dataType: 'json',
            beforeSubmit: function () {
                $("#progress").show();
            },
            success: function (data) {
                $("#progress").hide();
                if (data.correcto) {
                    $("#MyModal").modal('hide');

                } else {
                    muestraMensaje(data.mensaje,'warning');
                }
            },
            error: function () {
                $("#progress").hide();
                muestraMensaje("Error Interno en el servidor, vuelva a intentarlo",'error');
            }
        });
    }
    $(document).ready(function () {
        $("#progress").hide();
    });
</script>
