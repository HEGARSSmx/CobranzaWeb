<?php

session_start();
include './dataBaseClass/connection.php';

$aDatos = array();

$idOrden = filter_input(INPUT_POST, "idOrden");

$aDatos['idCompania'] = intval(filter_input(INPUT_POST, 'compania'));
$aDatos['movimientoSolicitado'] = filter_input(INPUT_POST, 'movimientoSolicitado');
$aDatos['idOrden'] = filter_input(INPUT_POST, 'idOrden');
$aDatos['ejecutivo'] = filter_input(INPUT_POST, 'ejecutivo');
$aDatos['ramo '] = filter_input(INPUT_POST, 'ramo');
$dFecha = filter_input(INPUT_POST, "fecha");
$aDatos['fecha'] = ($dFecha == "" ? NULL : $dFecha);
$aDatos['agente '] = filter_input(INPUT_POST, 'agente');
$aDatos['clave '] = (int) filter_input(INPUT_POST, 'clave');
$aDatos['moneda '] = filter_input(INPUT_POST, 'moneda');
$aDatos['formaPago '] = filter_input(INPUT_POST, 'formaPago');
$dFechaVigI = filter_input(INPUT_POST, "vigenciaInicio");
$aDatos['vigenciaInicio '] = ($dFechaVigI == "" ? NULL : $dFechaVigI);
$dFechaVigF = filter_input(INPUT_POST, "vigenciaFin");
$aDatos['vigenciaFin'] = ($dFechaVigF == "" ? NULL : $dFechaVigF);
$aDatos['idCliente'] = intval(filter_input(INPUT_POST, "idCliente"));
$aDatos['marca'] = filter_input(INPUT_POST, 'marca');
$aDatos['modelo'] = (int) filter_input(INPUT_POST, 'modelo');
$aDatos['amis'] = filter_input(INPUT_POST, 'amis');
$aDatos['placas'] = filter_input(INPUT_POST, 'placas');
$aDatos['noSerie'] = filter_input(INPUT_POST, 'noSerie');
$aDatos['noMotor'] = filter_input(INPUT_POST, 'noMotor');
$aDatos['color'] = filter_input(INPUT_POST, 'color');
$aDatos['conductor'] = filter_input(INPUT_POST, 'conductor');
$aDatos['edadConductor'] = (int) filter_input(INPUT_POST, 'edadConductor');
$aDatos['edoCivilConductor'] = filter_input(INPUT_POST, 'edoCivilConductor');
$aDatos['ubicacion'] = filter_input(INPUT_POST, 'ubicacion');
$aDatos['tipoCarga'] = filter_input(INPUT_POST, 'tipoCarga');
$aDatos['descripcionCarga'] = filter_input(INPUT_POST, 'descripcionCarga');
$aDatos['paquete'] = filter_input(INPUT_POST, 'idPaquete');
$aDatos['observaciones'] = filter_input(INPUT_POST, 'observaciones');
$cDb = new DataBase();
$lCorrecto = $cDb->insert("OrdenTrabajo", $aDatos, FALSE);


$aCobertura = array();
if (isset($_POST['cobertura'])) 
    $aCobertura = $_POST['cobertura'];

$aSumaAsegurada = array();
if (isset($_POST['sumaAsegurada'])) 
    $aSumaAsegurada = $_POST['sumaAsegurada'];

$aDeducible = array();
if (isset($_POST['deducible'])) 
    $aDeducible =  $_POST['deducible'];

$tamanio = count($aCobertura);
$i=0;
while ($i < $tamanio) {
    $aData = array();
    $aData['idOrden'] = $idOrden;
    $aData['cobertura'] = $aCobertura[$i];
    $aData['sumaAsegurada'] =floatval($aSumaAsegurada[$i]);
    $aData['deducible'] = floatval($aDeducible[$i]);    
    $cDb->insert("OrdenTrabajoDetalle", $aData, FALSE);
    $i++;    
}

$mensaje = "Datos de la orden de trabajo guardados correctamente";
if (!$lCorrecto) 
    $mensaje = "Error al tratar de guardar la informacion de la orden de trabajo: " . $cDb->LastError;

echo json_encode(array('correcto' => $lCorrecto, 'mensaje' => $mensaje));
