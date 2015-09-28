<?php
session_start();
include '../dataBaseClass/connection.php';

$aDatos = array();

$idAgente = filter_input(INPUT_POST, "idAgente");

$aDatos['nombre'] = filter_input(INPUT_POST, "nombre");
$aDatos['clave'] = filter_input(INPUT_POST, "clave");
$aDatos['direccion'] = filter_input(INPUT_POST, "direccion");
$aDatos['email'] = filter_input(INPUT_POST, "email");
$aDatos['telefono'] = filter_input(INPUT_POST, "telefono");
$aDatos['movil'] = filter_input(INPUT_POST, "movil");

$cDb = new DataBase();
if ($idAgente != ''){
    $lCorrecto = $cDb->update("agente", $aDatos, "idAgente = '$idAgente'");
} else {
    $lCorrecto = $cDb->insert("agente", $aDatos, false);
}

$mensaje = "Datos del agente guardados correctamente";
if(!$lCorrecto){
    $mensaje = "Error al tratar de guardar la informacion del agente: " . $cDb->LastError;
}

echo json_encode(array('correcto' => $lCorrecto, 'mensaje' => $mensaje));
