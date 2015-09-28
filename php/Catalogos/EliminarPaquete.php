<?php
session_start();
include '../dataBaseClass/connection.php';

$id = filter_input(INPUT_POST, "idPaquete");
$tipoPoliza = filter_input(INPUT_POST, "tipoPoliza");
$cobertura = filter_input(INPUT_POST, "cobertura");

$cDb = new DataBase();
$lCorrecto = $cDb->delete("Paquete", "idPaquete = '$id' AND tipoPoliza = '$tipoPoliza' AND cobertura = '$cobertura'");

$mensaje = "Datos del tipo de poliza eliminados correctamente";
if(!$lCorrecto){
    $mensaje = "Error al tratar de eliminar la informacion del tipo de poliza: " . $cDb->LastError;
}

echo json_encode(array('eliminado' => $lCorrecto,'mensaje' => $mensaje));
