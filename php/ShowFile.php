<?php
session_start();
if (!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])) {
    header("Location: /Cobranza/index.php");
    exit();
}
$idFile = filter_input(INPUT_GET, "id");
if(isset($idFile)){
    $idFile = intval($idFile);
    if($idFile <= 0){
        die("El Id del Documento es incorrecto");
    } else {
        include './dataBaseClass/connection.php';
        $cDb = new DataBase();
        $result = $cDb->select(array("nombre","type","size","content"), "ExpedienteElectronico", "id=$idFile", "", "1");
        if($result){
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                header("Content-Type: " . $row['type']);
                header("Content-Length: " . $row['size']);
                header("Content-Disposition: inline; filename=".$row['nombre']);
                
                echo $row['content'];
            } else {
                echo 'No existe un documento con ese ID';
            }
            mysqli_free_result($result);
        }
    }
} else {
    echo 'No se especifico un archivo';
}