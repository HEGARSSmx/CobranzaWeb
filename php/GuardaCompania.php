<?php
session_start();
include './dataBaseClass/connection.php';

$aDatos = array();

$idCompania = filter_input(INPUT_POST, "IdCompania");

$aDatos['nombre'] = filter_input(INPUT_POST, "nombre");
$aDatos['direccion'] = filter_input(INPUT_POST, "direccion");
$aDatos['telefono'] = filter_input(INPUT_POST, "telefono");
$aDatos['portal'] = filter_input(INPUT_POST, "portal");
$aTipos = array();
if(isset($_POST['chkTipoPoliza'])){
    $aTipos = $_POST['chkTipoPoliza'];
}
$cDb = new DataBase();

if($idCompania!=""){
    $sWhere = "idCompania = $idCompania";
    $lCorrecto = $cDb->update("Companias", $aDatos, $sWhere);
} else {
    $lCorrecto = $cDb->insert("Companias", $aDatos);
    $idCompania = strval($cDb->LastInsertedId);
    
}

$mensaje = "Datos de la compañia guardados correctamente";
if(!$lCorrecto){
    $mensaje = "Error al tratar de guardar la informacion de la compañia: " . mysqli_stmt_error($stmt);
}

if($lCorrecto){
    // Borramos los datos de los tipos de polizas y agregamos las nuevas seleccionadas
    $cDb->delete("TipoPolizaCompania", "idCompania = $idCompania");
    foreach ($aTipos as $value) {
        $aData = array();
        $aData['idCompania'] = $idCompania;
        $aData['idTipo'] = $value;
        $cDb->insert("TipoPolizaCompania", $aData, false);
    }
}
echo json_encode(array('correcto' => $lCorrecto, 'mensaje' => $mensaje));