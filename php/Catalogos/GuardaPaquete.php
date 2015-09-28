<?php
session_start();
include '../dataBaseClass/connection.php';

$aDatos = array();

$aDatos['idPaquete'] = filter_input(INPUT_POST, "idPaquete");
$aDatos['tipoPoliza'] = filter_input(INPUT_POST, "tipoPoliza");
$aDatos['cobertura'] = filter_input(INPUT_POST, "cobertura");

$cDb = new DataBase();
$lCorrecto = $cDb->insert("Paquete", $aDatos, FALSE);

$mensaje = "Datos del tipo de poliza guardados correctamente";
if(!$lCorrecto){
    $mensaje = "Error al tratar de guardar la informacion del tipo de poliza: " . $cDb->LastError;
}

echo json_encode(array('correcto' => $lCorrecto, 'mensaje' => $mensaje));
?>
