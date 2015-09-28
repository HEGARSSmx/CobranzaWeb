<?php
if (!session_id()) {
    session_start();
}
if (!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])) {
    header("Location: /Cobranza/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Seguros Santos Guzman</title>
        
        <link href="/Cobranza/css/bootstrap.min.css" rel="stylesheet">
        <link href="/Cobranza/css/dashboard.css" rel="stylesheet">
        <link href="/Cobranza/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/Cobranza/css/dataTables.tableTools.css" rel="stylesheet">
        <link href="/Cobranza/css/animate.css" rel="stylesheet">
        <link href="../css/jquery.datetimepicker.css" rel="stylesheet">

        <script src="/Cobranza/js/jquery.min.js"></script>
        <script src="/Cobranza/js/bootstrap.min.js"></script>
        <script src="/Cobranza/js/ventanaModal.js"></script>
        <script src="/Cobranza/js/jquery.dataTables.min.js"></script>
        <script src="/Cobranza/js/dataTables.bootstrap.js"></script>
        <script src="/Cobranza/js/dataTables.tableTools.js"></script>
        <script src="/Cobranza/js/waitProcessing.js"></script>
        <script src="../js/jquery.datetimepicker.js"></script>
        
        <script type="text/javascript" src="/Cobranza/js/noty/packaged/jquery.noty.packaged.min.js"></script>
        <script type="text/javascript" src="/Cobranza/js/noty/themes/bootstrap.js"></script>
        <script type="text/javascript" src="/Cobranza/js/hegarss.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <a class="navbar-brand" href="/Cobranza/php/Dashboard.php"><span class="glyphicon glyphicon-home"></span> Cobranza</a> </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/Cobranza/php/Dashboard.php">Resumen</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Cat&aacute;logos <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/Cobranza/php/ListadoClientes.php">Clientes</a></li>
                                <li><a href="/Cobranza/php/ListadoCompanias.php">Compa&ntilde;&iacute;as</a></li>
                                <li><a href="/Cobranza/php/Catalogos/ListadoTiposPoliza.php">Tipos de P&oacute;liza</a></li>
                                <li><a href="/Cobranza/php/Catalogos/ListadoUsuarios.php">Usuarios</a></li>
                                <li><a href="/Cobranza/php/Catalogos/ListadoPaquetes.php">Paquetes</a></li>
                                <li><a href="/Cobranza/php/Catalogos/ListadoAgentes.php">Agentes</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Operaci&oacute;n <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/Cobranza/php/OrdenTrabajoAutosListado.php">Ordenes de trabajo Atomoviles</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Herramientas <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/Cobranza/php/ActualizacionesSvn.php">Actualizaciones</a></li>
                            </ul>
                        </li>
                        <li><a href="/Cobranza/php/Logout.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="MyModal" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false"> 
            <!-- Contenido de la ventana Modal a Mostrar--> 
        </div>