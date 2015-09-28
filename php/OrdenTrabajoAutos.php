<?php
include './Header.php';
include './dataBaseClass/connection.php';
$cDb = new DataBase();
$queryCompanias = "SELECT C.idCompania,C.nombre FROM Companias AS C INNER JOIN TipoPolizaCompania AS T ON T.idCompania = C.idCompania WHERE T.idTipo = 'AUTOMOVIL'";
$resultCompanias = $cDb->query($queryCompanias);

$queryPaquetes = "SELECT idPaquete FROM Paquete WHERE tipoPoliza = 'AUTOMOVIL' GROUP BY idPaquete";
$resultPaquetes = $cDb->query($queryPaquetes);
?>
<script type="text/javascript" src="/Cobranza/js/OrdenTrabajo.js"></script>
<div class="main">
    <h1 class="page-header">Orden De Trabajo Automoviles</h1>
    <br>
    <button type="button" class="btn btn-primary" id="btnGuardar" onclick="GuardaOrdenTrabajo();">Guardar</button>
    <br>
    <br>
    <form id="inputForm">
        <div class="row">
            <div class= "col-md-2">
                <p class="text-right">
                    <label class="control-label" for="selCompania">Compa&ntilde;ia:</label>
                </p>
            </div>
            <div class="col-md-3">
                <select class="form-control input-sm" id="selCompania" name="compania">
                    <option value = "c">Seleccionar compa&ntilde;ia</option>
                    <?php while ($row = mysqli_fetch_array($resultCompanias)) { ?>
                        <option value = "<?php echo $row['idCompania']; ?>"> <?php echo $row['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class= "col-md-2">
                <p class="text-right">
                    <label class="control-label" for="inputMovimientoSolicitado">Movimiento solicitado:</label>
                </p>
            </div>
            <div class="col-md-3">
                <input type="text" name="movimientoSolicitado" class="form-control input-sm" id="inputMovimientoSolicitado" placeholder="Movimiento solicitado" value=" ">
            </div>
        </div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tabDatosGenerales" aria-controls="tabDatosGenerales" role="tab" data-toggle="tab">Datos generales</a></li>
            <li role="presentation"><a href="#tabDatosSolicitante" aria-controls="tabDatosSolicitante" role="tab" data-toggle="tab">Datos del solicitante</a></li>
            <li role="presentation"><a href="#tabConceptosYRiesgosACubrir" aria-controls="tabConceptosYRiesgosACubrir" role="tab" data-toggle="tab">Conceptos y riesgos a cubrir</a></li>
            <li role="presentation"><a href="#tabAltaPaquete" aria-controls="tabAltaPaquete" role="tab" data-toggle="tab">Alta paquete</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tabDatosGenerales">
                <br>
                <div class="row">
                    <div class= "col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputIdOrden">Orden:</label>
                        </p>
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="idOrden" class="form-control input-sm" id="inputIdOrden" placeholder="Orden">
                    </div>
                    <div class= "col-md-1">
                        <p class="text-right">
                            <label class="control-label" for="inputEjecutivo">Ejecutivo:</label>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="ejecutivo" class="form-control input-sm" id="inputEjecutivo" placeholder="Nombre del ejecutivo" value="">
                    </div>
                    <div class= "col-md-1">
                        <p class="text-right">
                            <label class="control-label" for="inputRamo">Ramo:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="ramo" class="form-control input-sm" id="inputRamo" placeholder="Ramo" value="">
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputFecha">Fecha:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="fecha" class="form-control input-sm" id="inputFecha" placeholder="Fecha" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputAgente">Agente:</label>
                        </p>
                    </div>
                    <div class="col-lg-5">
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" placeholder="Nombre del agente" name="agente" id="inputAgente" readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-sm" type="button" id="btnInfoAgente"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <p class="text-right">
                            <label class="control-label" for="inputClave">Clave:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="clave" class="form-control input-sm" id="inputClave" placeholder="Clave del agente" value="" readonly>
                    </div>
                    <div class="col-md-1">
                        <input type="hidden" name="idAgente" class="form-control input-sm" id="inputIdAgente" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputFormaPago">Forma de pago:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="formaPago" class="form-control input-sm" id="inputFormaPago" placeholder="Forma de pago" value="">
                    </div>
                    <div class="col-md-1">
                        <p class="text-right">
                            <label class="control-label" for="inputMoneda">Moneda:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="moneda" class="form-control input-sm" id="inputMoneda" placeholder="Moneda" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputVigenciaInicio">Vigencia de:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="vigenciaInicio" class="form-control input-sm" id="inputVigenciaInicio" placeholder="Inicio Vigencia" value="">
                    </div>
                    <div class="col-md-1">
                        <p class="text-center">
                            <label class="control-label" for="inputVigenciaFin">Hasta:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="vigenciaFin" class="form-control input-sm" id="inputVigenciaFin" placeholder="Fin Vigencia" value="">
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tabDatosSolicitante">
                <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <label class="control-label" for="inputIdCliente">Id cliente: </label>
                        </div>
                        <div class="col-lg-2">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm" placeholder="Id del cliente" name="idCliente" id="inputIdCliente" value="0" readonly>
                                <span class="input-group-btn">
                                    <button class="btn btn-info btn-sm" type="button" id="btnInfoClientes"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputCliente">Cliente:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="cliente" class="form-control input-sm" id="inputCliente" placeholder="Cliente" value="" disabled>
                    </div>
                    <div class="col-md-1">
                        <p class="text-right">
                            <label class="control-label" for="inputRFC">R.F.C.:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="rFC" class="form-control input-sm" id="inputRFC" placeholder="R.F.C." value="" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputDireccion">Direcci&oacute;n:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="direccion" class="form-control input-sm" id="inputDireccion" placeholder="Direccion" value="" disabled>
                    </div>
                    <div class="col-md-1">
                        <p class="text-right">
                            <label class="control-label" for="inputColonia">Colonia:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="colonia" class="form-control input-sm" id="inputColonia" placeholder="Colonia" value="" disabled>
                    </div>
                    <div class="col-md-1">
                        <p class="text-right">
                            <label class="control-label" for="inputCiudad">Ciudad:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="ciudad" class="form-control input-sm" id="inputCiudad" placeholder="Ciudad" value="" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputCodigoPostal">C&oacute;digo postal:</label>
                        </p>
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="codigoPostal" class="form-control input-sm" id="inputCodigoPostal" placeholder="Codigo postal" value="" disabled>
                    </div>
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputTelefonosFax">Tel&eacute;fonos/Fax:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="telefonosFax" class="form-control input-sm" id="inputTelefonosFax" placeholder="Telefonos/Fax" value="" disabled>
                    </div>
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputFechaNacimiento">Fecha de nacimiento:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="fechaNacimiento" class="form-control input-sm" id="inputFechaNacimiento" placeholder="Fecha de nacimiento" value="" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputGiroEmpresa">Giro de la empresa:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="giroEmpresa" class="form-control input-sm" id="inputGiroEmpresa" placeholder="Giro de la empresa" value="" readonly="">
                    </div>
                    <div class="col-md-1">
                        <p class="text-right">
                            <label class="control-label" for="inputEmail">E-mail:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="email" class="form-control input-sm" id="inputEmail" placeholder="e-mail" value="" disabled>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tabConceptosYRiesgosACubrir">
                <br>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputMarca">Marca:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="marca" class="form-control input-sm" id="inputMarca" placeholder="Marca" value=" ">
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputModelo">Modelo:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="modelo" class="form-control input-sm" id="inputModelo" placeholder="Modelo" value=" ">
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputAmis">Amis:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="amis" class="form-control input-sm" id="inputAmis" placeholder="Amis" value=" ">
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputPlacas">Placas:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="placas" class="form-control input-sm" id="inputPlacas" placeholder="Placas" value=" ">
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputNoSerie">No. de serie:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="noSerie" class="form-control input-sm" id="inputNoSerie" placeholder="No. de serie" value=" ">
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputNoMotor">No. de motor:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="noMotor" class="form-control input-sm" id="inputNoMotor" placeholder="No. de motor" value=" ">
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputColor">Color:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="color" class="form-control input-sm" id="inputColor" placeholder="Color" value=" ">
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputConductor">Conductor:</label>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="conductor" class="form-control input-sm" id="inputConductor" placeholder="Conductor" value=" ">
                    </div>
                    <div class="col-md-1">
                        <p class="text-right">
                            <label class="control-label" for="inputEdadConductor">Edad:</label>
                        </p>
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="edadConductor" class="form-control input-sm" id="inputEdadConductor" placeholder="Edad del conductor" value=" ">
                    </div>
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputEdoCivilConductor">Estado civil:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="edoCivilConductor" class="form-control input-sm" id="inputEdoCivilConductor" placeholder="Estado civil del conductor" value=" ">
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputUbicacion">Ubicaci&oacute;n:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="ubicacion" class="form-control input-sm" id="inputUbicacion" placeholder="Ubicacion" value=" ">
                    </div>
                </div>
                <div  class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputTipoCarga">Tipo de carga:</label>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="tipoCarga" class="form-control input-sm" id="inputTipoCarga" placeholder="Tipo de carga" value=" ">
                    </div>
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputDescripcionCarga">Descripci&oacute;n de la carga:</label>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <textarea maxlength="150" name="descripcionCarga" class="form-control input-sm" id="inputDescripcionCarga" placeholder="Descripcion de la carga" value=" "></textarea>
                    </div>
                </div>
            </div>
            <br>
            <div role="tabpanel" class="tab-pane" id="tabAltaPaquete">
                <br>
                <div class="row">
                    <div class= "col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="selPaquete">Paquete:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control input-sm" id="selPaquete" name="idPaquete" title="Seleccionar paquete" onchange="SeleccionaPaqueteCobertura()"  >
                            <option value = "x">Seleccionar paquete</option>
                            <?php while ($row = mysqli_fetch_array($resultPaquetes)) { ?>
                                <option value = "<?php echo $row['idPaquete']; ?>"> <?php echo $row['idPaquete']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <table id="tblOrdenTrabajoDetalle" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Coberturas amparadas</th>
                            <th>Suma asegurada</th>
                            <th>Deducible</th>
                        </tr>
                    </thead>
                </table>
                <div class="col-md-2">
                    <p class="text-right">
                        <label class="control-label" for="inputObservaciones">Observaciones:</label>
                    </p>
                </div>
                <div class="col-md-10">
                    <textarea maxlength="150" name="observaciones" class="form-control input-sm" id="inputObservaciones" placeholder="Observaciones" value=" "></textarea>
                </div>
            </div>
        </div>
    </form>
    <div class="progress" id="progress">
        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 100%;"></div>
    </div>
</div>
<script type='text/javascript'>
    $(document).ready(function () {
        $("#progress").hide();
        $("#btnInfoClientes").on("click", function (evt) {
            evt.preventDefault();
            MuestraModal.mostrar("/Cobranza/php/BuscaCliente.php");
        });
        $("#btnInfoAgente").on("click", function (evt) {
            evt.preventDefault();
            MuestraModal.mostrar("/Cobranza/php/BuscaAgente.php");
        });
        $("#btnInfoOrdenTrabajo").on("click", function (evt) {
            evt.preventDefault();
            MuestraModal.mostrar("/Cobranza/php/BuscaOrdenTrabajo.php");
        });
        $("#selPaquete").change(function () {
            SeleccionaPaquete();
        });
    });

    function DatosAgenteText() {
        $.ajax({
            type: 'POST',
            url: "/Cobranza/php/Funciones.php",
            data: "function=getAgenteByIdAgente&idAgente=" + $("#inputIdAgente").val(),
            cache: false,
            dataType: 'json',
            success: function (data) {
                $("#inputIdAgente").val(data.idAgente);
                $("#inputAgente").val(data.nombre);
                $("#inputClave").val(data.clave);
            },
            error: function (error) {
                muestraMensaje("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo: </span>" + error.status + ": " + error.responseText, "error");
            }
        });
    }

    function DatosClienteText() {
        $.ajax({
            type: 'POST',
            url: "/Cobranza/php/Funciones.php",
            data: "function=getClienteById&idCliente=" + $("#inputIdCliente").val(),
            cache: false,
            dataType: 'json',
            success: function (data) {
                $("#inputCliente").val(data.nombre + " " + data.paterno + " " + data.materno);
                $("#inputRFC").val(data.rfc);
                $("#inputDireccion").val(data.direccion);
                $("#inputColonia").val(data.colonia);
                $("#inputCiudad").val(data.ciudad);
                $("#inputCodigoPostal").val(data.codigoPostal);
                $("#inputTelefonosFax").val(data.telefono);
                $("#inputFechaNacimiento").val(data.nacimiento);
                $("#inputEmail").val(data.email);
                $("#inputGiroEmpresa").val(data.giroEmpresa);
            },
            error: function () {
                muestraMensaje("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo</span> ", "error");
            }
        });
    }

    function TablaSelPaqueteSumaAsegurada() {
        $("#tblOrdenTrabajoDetalle").find("tr:gt(0)").remove();
        $.ajax({
            type: 'POST',
            url: "/Cobranza/php/Funciones.php",
            data: "function=getDetallePaqueteByOrden&idOrden=" + $("#inputIdOrden").val(),
            cache: false,
            dataType: 'json',
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    var table = document.getElementById("tblOrdenTrabajoDetalle");
                    var rowCount = table.rows.length;
                    var row = table.insertRow(rowCount);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    cell1.innerHTML = '<input type="text" name="cobertura[]" id="txtCobertura" readonly class="form-control input-sm" value="' + data[i].cobertura + '">';//data[i];
                    cell2.innerHTML = '<input type="text" name="sumaAsegurada[]" id="txtSumaAsegurada" class="form-control input-sm" value="' + data[i].sumaAsegurada + '">';
                    cell3.innerHTML = '<input type="text" name="deducible[]" id="txtDeducible" class="form-control input-sm" value="' + data[i].deducible + '">';
                }
            },
            error: function () {
                muestraMensaje("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo</span> ", "error");
            }
        });
    }
</script>
