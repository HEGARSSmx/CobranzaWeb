<?php
session_start();
include '../dataBaseClass/connection.php';

$idAgente = filter_input(INPUT_POST, "idAgente");

$cDb = new DataBase();
$lCorrecto = $cDb->delete("agente", "idAgente = '$idAgente'");

$mensaje = "Datos del agente eliminados correctamente";
if(!$lCorrecto){
    $mensaje = "Error al tratar de eliminar la informacion del agente: " . $cDb->LastError;
}

echo json_encode(array('eliminado' => $lCorrecto,'mensaje' => $mensaje));
