<?php
// revisamos si se manda el id del Cliente a ser modificado
session_start();
if (!isset($_SESSION['login_user'])) {
    header("Location: /Cobranza/login.php");
}
$lEdit = FALSE;
$idCliente = filter_input(INPUT_GET, 'idCliente');
$row = array();
$row['activo'] = 1;
$row['rfc'] = '';
$row['nombre'] = '';
$row['paterno'] = '';
$row['materno'] = '';
$row['nacimiento'] = '';
$row['direccion'] = '';
$row['entreCalles'] = '';
$row['colonia'] = '';
$row['ciudad'] = '';
$row['estado'] = '';
$row['codigoPostal'] = '';
$row['direccionEntrega'] = '';
$row['direccionCobro'] = '';
$row['comentario'] = '';
$row['telefono'] = '';
$row['fax'] = '';
$row['movil'] = '';
$row['email'] = '';
$row['contactoNombre'] = '';
$row['contactoTelefono'] = '';
$row['contactoMail'] = '';
$row['giroEmpresa'] = '';

if ($idCliente != "") {
    include './dataBaseClass/DB.php';
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    $query = "SELECT * FROM cliente WHERE idCliente = $idCliente";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $lEdit = TRUE;
    }
}
$cEncabezado = ($lEdit ? "Editando: " . $row['nombre'] . " " . $row['paterno'] . " " . $row['materno'] : "Cliente Nuevo");
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button
            <h1 class="modal-title"><?php echo $cEncabezado; ?></h1>
        </div>
        <div class="modal-body" style="margin: 20px;">
            <form action="GuardaCliente.php" id="inputForm">
                <input type="hidden" id="IdCliente" name="IdCliente" value="<?php echo $idCliente; ?>">
                <div class="form-group">
                    <label class="control-label" for="selTipo">Tipo:</label>
                    <select class="form-control input-sm" id="selTipo" name="tipo">
                        <?php
                        $sTipoSeleccionado = $row['tipo'];
                        $aTipos = array("Fisica" => "Fisica",
                            "Moral" => "Moral");
                        foreach ($aTipos as $key => $val) {
                            echo ($key == $sTipoSeleccionado) ? "<option selected=\"selected\" value=\"$key\">$val</option>" : "<option value=\"$key\">$val</option>";
                        }
                        ?>
                    </select>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="activo" id="chkActivo" <?php echo ($row['activo'] == 1 ? 'checked' : ''); ?>> Activo
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputGiroEmpresa">Giro de la empresa:</label>
                    <input type="text" name="giroEmpresa" class="form-control input-sm" id="inputGiroEmpresa" value="<?php echo $row['giroEmpresa']; ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputRfc">R.F.C.:</label>
                    <input type="text" name="rfc" class="form-control input-sm" id="inputRfc" placeholder="R.F.C." value="<?php echo $row['rfc']; ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputNombre">Nombre (Raz&oacute;n Social):</label>
                    <input type="text" name="nombre" class="form-control input-sm" id="inputNombre" placeholder="Nombre" value="<?php echo $row['nombre']; ?>">
                    <input type="text" name="paterno" class="form-control input-sm" id="inputPaterno" placeholder="Apellido Paterno" value="<?php echo $row['paterno']; ?>">
                    <input type="text" name="materno" class="form-control input-sm" id="inputMaterno" placeholder="Apellido Materno" value="<?php echo $row['materno']; ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputFechaNac">Fecha de nacimiento:</label>
                    <input type="date" name="nacimiento" class="form-control input-sm" id="inputFechaNac" value="<?php echo $row['nacimiento']; ?>">
                </div>
                <div role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tabDireccion" aria-controls="tabDireccion" role="tab" data-toggle="tab">Direcci&oacute;n</a></li>
                        <li role="presentation"><a href="#tabLocalizacion" aria-controls="tabLocalizacion" role="tab" data-toggle="tab">Localizaci&oacute;n</a></li>
                        <li role="presentation"><a href="#tabContacto" aria-controls="tabContacto" role="tab" data-toggle="tab">Contacto</a></li>
                        <li role="presentation"><a href="#tabOtros" aria-controls="tabOtros" role="tab" data-toggle="tab">Extras</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="tabDireccion">
                            <div class="form-group">
                                <label class="control-label" for="inputDireccion">Dirección:</label>
                                <textarea maxlength="150" name="direccion" class="form-control input-sm" id="inputDireccion" placeholder="Dirección"><?php echo $row['direccion']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputEntreCalles">Entre calles:</label>
                                <textarea maxlength="150" name="entreCalles" class="form-control input-sm" id="inputEntreCalles" placeholder="Entre Calles"><?php echo $row['entreCalles']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputColonia">Colonia:</label>
                                <input type="text" name="colonia" class="form-control input-sm" id="inputColonia" placeholder="Colonia" value="<?php echo $row['colonia']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputCiudad">Ciudad:</label>
                                <input type="text" name="ciudad" class="form-control input-sm" id="inputCiudad" placeholder="Ciudad" value="<?php echo $row['ciudad']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputEstado">Estado:</label>
                                <input type="text" name="estado" class="form-control input-sm" id="inputEstado" placeholder="Estado" value="<?php echo $row['estado']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputCp">C&oacute;digo postal:</label>
                                <input type="text" name="codigoPost" class="form-control input-sm" id="inputCp" placeholder="Codigo Postal" value="<?php echo $row['codigoPostal']; ?>">
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tabLocalizacion">
                            <div class="form-group">
                                <label class="control-label" for="inputTelefono">Tel&eacute;fono:</label>
                                <input type="tel" name="telefono" class="form-control input-sm" id="inputTelefono" placeholder="Telefono" value="<?php echo $row['telefono']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputFax">Fax:</label>
                                <input type="tel" name="fax" class="form-control input-sm" id="inputFax" placeholder="Fax" value="<?php echo $row['fax']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputMovil">M&oacute;vil/Nextel:</label>
                                <input type="text" name="movil" class="form-control input-sm" id="inputMovil" placeholder="Movil" value="<?php echo $row['movil']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputMail">E-Mail:</label>
                                <input type="email" name="email" class="form-control input-sm" id="inputMail" placeholder="E-Mail" value="<?php echo $row['email']; ?>">
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tabContacto">
                            <div class="form-group">
                                <label class="control-label" for="inputContactoNombre">Nombre:</label>
                                <input type="text" name="contactoNombre" class="form-control input-sm" id="inputContactoNombre" placeholder="Nombre del Contacto" value="<?php echo $row['contactoNombre']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputContactoTel">Tel&eacute;fono:</label>
                                <input type="tel" name="contactoTelefono" class="form-control input-sm" id="inputContactoTel" placeholder="Telefono del Contacto" value="<?php echo $row['contactoTelefono']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputContactoMail">E-Mail:</label>
                                <input type="email" name="contactoMail" class="form-control input-sm" id="inputContactoMail" placeholder="E-Mail del Contacto" value="<?php echo $row['contactoMail']; ?>">
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tabOtros">
                            <div class="form-group">
                                <label class="control-label" for="inputDireccionEntrega">Direcci&oacute;n de entrega</label>
                                <textarea class="form-control input-sm" name="direccionEntrega" id="inputDireccionEntrega" placeholder="Dirección de Entrega"><?php echo $row['direccionEntrega']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputDireccionCobro">Direcci&oacute;n de cobro:</label>
                                <textarea class="form-control input-sm" name="direccionCobro" id="inputDireccionCobro" placeholder="Dirección de Cobro"><?php echo $row['direccionCobro']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="inputComentarios">Comentarios:</label>
                                <textarea class="form-control input-sm" name="comentarios" id="inputComentarios" placeholder="Comentarios"><?php echo $row['comentario']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="progress" id="progress">
                <div class="progress-bar progress-bar-striped active" role="progressbar" style="width: 100%;"></div>
            </div>
            <button type="button" class="btn btn-primary" data-diss          miss="modal" id="btnGuardar">Guardar</button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#progress").hide();
        $("#btnGuardar").click(function () {
            var postData = $("#inputForm").serialize();

            $.ajax({
                type: 'POST',
                url: "/Cobranza/php/GuardaCliente.php",
                data: postData,
                cache: false,
                dataType: 'json',
                beforeSend: function () {
                    $("#progress").show();
                },
                success: function (data) {
                    $("#progress").hide();
                    if (data.correcto) {
                        $("#MyModal").modal('hide');

                    } else {
                        muestraMensaje("<span style='color:#cc0000'>Error:</span> " + data.mensaje, "warning");
                    }
                },
                error: function () {
                    $("#progress").hide();
                    muestraMensaje("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo</span> ", "error");
                }
            });
        });
    });
</script>