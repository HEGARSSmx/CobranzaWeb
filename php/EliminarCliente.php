<?php
session_start();
include './dataBaseClass/connection.php';

$idCliente = filter_input(INPUT_POST, "idCliente");

$cDb = new DataBase();
$lCorrecto = $cDb->delete("cliente", "idCliente = $idCliente");

$mensaje = "Datos del cliente eliminados correctamente";
if(!$lCorrecto){
    $mensaje = $cDb->LastError;
}

echo json_encode(array('eliminado' => $lCorrecto,'mensaje' => $mensaje));
