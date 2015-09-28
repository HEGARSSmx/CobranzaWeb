<?php

$tipo = filter_input(INPUT_POST, "function");

switch ($tipo) {
    case "getClienteById":
        getClienteById(intval(filter_input(INPUT_POST, "idCliente")));
        break;
    case "getDetallePaquete":
        $idPaquete = filter_input(INPUT_POST, "idPaquete");
        $tipoPoliza = filter_input(INPUT_POST, "tipoPoliza");
        getDetallePaquete($idPaquete, $tipoPoliza);
        break;
    case "getOrdenById":
        $idOrden = filter_input(INPUT_POST, "idOrden");
        getOrdenById($idOrden);
        break;
    case "getDetallePaqueteByOrden":
        $idOrden = filter_input(INPUT_POST, "idOrden");
        getDetallePaqueteByOrden($idOrden);
        break;
    case "getAgenteByIdAgente":
        $idAgente = filter_input(INPUT_POST, "idAgente");
        getAgenteByIdAgente($idAgente);
        break;
    default:
        break;
}

function getClienteById($idCliente) {
    $query = "SELECT * FROM cliente WHERE idCliente = $idCliente";
    include './dataBaseClass/connection.php';
    $cDb = new DataBase();
    $result = $cDb->query($query);
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
}

function getDetallePaquete($idPaquete, $tipoPoliza) {
    include './dataBaseClass/connection.php';
    $query = "SELECT cobertura FROM Paquete WHERE idPaquete = '$idPaquete' AND tipoPoliza = '$tipoPoliza'";
    $cDb = new DataBase();
    $result = $cDb->query($query);
    $regresa = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $regresa[] = $row['cobertura'];
    }
    echo json_encode($regresa);
}

function getDetallePaqueteByOrden($idOrden) {
    include './dataBaseClass/connection.php';
    $query = "SELECT * FROM OrdenTrabajoDetalle WHERE idOrden = '$idOrden'";
    $cDb = new DataBase();
    $result = $cDb->query($query);
    $regresa = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $regresa[] = $row;
    }
    echo json_encode($regresa);
}

function getOrdenById($idOrden) {
    $query = "SELECT * FROM OrdenTrabajo WHERE idOrden = $idOrden";
    include './dataBaseClass/connection.php';
    $cDb = new DataBase();
    $result = $cDb->query($query);
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
}

function getAgenteByIdAgente($idAgente) {
    $query = "SELECT * FROM agente WHERE idAgente = '$idAgente'";
    include './dataBaseClass/connection.php';
    $cDb = new DataBase();
    $result = $cDb->query($query);
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
}

function get_siteInfo($TcName){
//    Busca en la tabla de configuraciones el valor establecido
    $query = "SELECT valor,tipo FROM Configuracion WHERE idConfiguracion = '$TcName'";
    include_once './dataBaseClass/connection.php';
    $cDb = new DataBase();
    $result = $cDb->query($query);
    $row = mysqli_fetch_assoc($result);
    return $row["valor"];
}

function set_setting($TcNombre,$TcValor){
    
}