<?php
session_start();
include filter_input(INPUT_SERVER, 'CONTEXT_DOCUMENT_ROOT') . "/php/dataBaseClass/DB.php";
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$UserName = filter_input(INPUT_POST, 'username');
$Password = filter_input(INPUT_POST, 'password');
$inicioSesion = false;
$idUsuario = 0;
$mensaje = "";
if (!empty($UserName) && !empty($Password)) {
    $TcEmail = mysqli_real_escape_string($db, $UserName);
    $TcPwd = md5(mysqli_real_escape_string($db, $Password));

    $result = mysqli_query($db, "SELECT userId FROM usuario WHERE email = '$TcEmail' AND password = '$TcPwd'");
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($count == 1) {
        $_SESSION['login_user'] = $row['userId'];
        $inicioSesion = TRUE;
    } else {
        // no coinciden los datos de inicio de sesion
        $mensaje = "Los datos de registro son incorrectos";
        $inicioSesion = false;
    }
    $return = array("inicioSesion" => $inicioSesion,
        "mensaje" => $mensaje);
    echo json_encode($return);
}
exit();