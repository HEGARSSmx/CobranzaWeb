<?php
$msjReturn = "";
$correcto = false;
$iIdFile = 0;
$tipoArchivo = filter_input(INPUT_POST, "tipoArchivo"); // Determina que tipo de archivo es 1= Expediente electronico del cliente
$idCliente = filter_input(INPUT_POST, "idCliente");
if (isset($_FILES['userfile'])) {
    $sNombre = $_FILES['userfile']['name'];
    $sType = $_FILES['userfile']['type'];
    $sFile = $_FILES['userfile']['tmp_name'];
    $iError = $_FILES['userfile']['error'];
    $iSize = intval($_FILES['userfile']['size']); 
    
    if($iError == UPLOAD_ERR_OK and $iSize > 0){
        // Guardamos en la base de datos
        $content = file_get_contents($sFile);
        include './dataBaseClass/connection.php';
        $aData = array();
        $aData['nombre'] = $sNombre;
        $aData['type'] = $sType;
        $aData['size'] = $iSize;
        $aData['content'] = $content;
        $aData['idCliente'] = $idCliente;
        
        $cDb = new DataBase();
        $cTabla = "";
        switch ($tipoArchivo) {
            case 1:
                $cTabla = "ExpedienteElectronico";
                break;
            case 2:
                $cTabla = "ComprobantePago";
            default:
                break;
        }
        
        $result = $cDb->insert($cTabla, $aData, false);
        if(!$result){
            $msjReturn = 'Error al grabar en la base de datos: ' . $cDb->LastError;
        } else {
            $msjReturn = 'Documento almacenado correctamente';
            $correcto = true;
            $iIdFile = $cDb->LastInsertedId;
        }  
    } else {
        $msjReturn = "El archivo no se cargo correctamente, intente de nuevo";
    }
} else {
    $msjReturn = "No se especifico un archivo para almacenar";
}
$return = array("correcto" => $correcto, "mensaje" => $msjReturn, "id" => $iIdFile);
echo json_encode($return);