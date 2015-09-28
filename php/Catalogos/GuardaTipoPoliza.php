<?php
session_start();
include '../dataBaseClass/connection.php';

$aDatos = array();

$id = filter_input(INPUT_POST, "IdTipo");

$aDatos['idTipo'] = $id;
$aDatos['nombre'] = filter_input(INPUT_POST, "nombre");
$aDatos['descripcion'] = filter_input(INPUT_POST, "descripcion");

$cDb = new DataBase();
$lCorrecto = $cDb->insert("TipoPoliza", $aDatos,TRUE);

$mensaje = "Datos del tipo de poliza guardados correctamente";
if(!$lCorrecto){
    $mensaje = "Error al tratar de guardar la informacion del tipo de poliza: " . $cDb->LastError;
}

echo json_encode(array('correcto' => $lCorrecto, 'mensaje' => $mensaje));