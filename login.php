<?php
session_start();
// Obtenemos los datos de inicio de sesion proporcionados
$UserName = filter_input(INPUT_POST, 'email');
$Password = filter_input(INPUT_POST, 'password');

// Intentamos hacer la conexion con la base de datos
include filter_input(INPUT_SERVER, 'CONTEXT_DOCUMENT_ROOT') . "/php/dataBaseClass/DB.php";
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$inicioSesion = false;
$idUsuario = 0;
$mensaje = "";
if(mysqli_connect_errno()){
  $mensaje = "<div class='alert alert-danger' role='alert'>Error en la conexi&oacute;n con la base de datos: " . mysqli_connect_error() . "</div>";
  goto inicio_de_sesion;
}
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
        $mensaje = "<div class='alert alert-danger' role='alert'>Los datos de registro son incorrectos</div>";
        $inicioSesion = false;
    }
}
inicio_de_sesion:
if($inicioSesion){
  header("Location: php/Dashboard.php");
  exit();
}
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>Seguros Santos Guzman</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/signin.css" rel="stylesheet" type="text/css">
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/ventanaModal.js" type="text/javascript"></script>
    </head>
    <body>
      <section class="container">
        <section class="login-form">
          <form method="post" action="login.php" role="login">
            <center><h2>Inicio de Sesi&oacute;n</h2></center>
            <div class="row">
              <div class="col-xs-12">
                <input type="email" name="email" placeholder="Correo Electr&oacute;nico" required class="form-control"/>
                <span class="glyphicon glyphicon-user"></span>
              </div>
              <div class="col-xs-12">
                <input type="password" name="password" placeholder="Contrase&ntilde;a" required class="form-control" />
                <span class="glyphicon glyphicon-lock"></span>
              </div>
            </div>
            <?php echo $mensaje; ?>
            <button type="submit" name="go" class="btn btn-block"><span class="glyphicon glyphicon-ok"></span></button>
          </form>
          <center><p class="text-muted bg-primary" style="font-size:10;">HEGAR Soluciones en Sistemas S. de R.L. Todos los derechos reservados 2015</p></center>
        </section>
      </section>
    </body>
</html>
