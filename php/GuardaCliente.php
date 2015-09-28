<?php

session_start();

include './dataBaseClass/connection.php';

$aDatos = array();

// datos principales
$cIdCliente = filter_input(INPUT_POST, "IdCliente");
$aDatos['tipo'] = filter_input(INPUT_POST, "tipo");
$aDatos['activo'] = (filter_input(INPUT_POST, "activo")== "on" ? TRUE : FALSE);
$aDatos['giroEmpresa'] = filter_input(INPUT_POST, "giroEmpresa");
$aDatos['rfc'] = filter_input(INPUT_POST, "rfc");
$aDatos['nombre'] = filter_input(INPUT_POST, "nombre");
$aDatos['paterno'] = filter_input(INPUT_POST, "paterno");
$aDatos['materno'] = filter_input(INPUT_POST, "materno");
$dFecNac = filter_input(INPUT_POST, "nacimiento");
$aDatos['nacimiento'] = ($dFecNac == "" ? NULL : $dFecNac);

//Pestaña de Direccion
$aDatos['direccion'] = filter_input(INPUT_POST, "direccion");
$aDatos['entreCalles'] = filter_input(INPUT_POST, "entreCalles");
$aDatos['colonia'] = filter_input(INPUT_POST, "colonia");
$aDatos['ciudad'] = filter_input(INPUT_POST, "ciudad");
$aDatos['estado'] = filter_input(INPUT_POST, "estado");
$aDatos['codigoPostal'] = filter_input(INPUT_POST, "codigoPost");

// Pestaña de Localizacion
$aDatos['telefono'] = filter_input(INPUT_POST, "telefono");
$aDatos['fax'] = filter_input(INPUT_POST, "fax");
$aDatos['movil'] = filter_input(INPUT_POST, "movil");
$aDatos['email'] = filter_input(INPUT_POST, "email");

// Pestaña de Contacto
$aDatos['contactoNombre'] = filter_input(INPUT_POST, "contactoNombre");
$aDatos['contactoTelefono'] = filter_input(INPUT_POST, "contactoTelefono");
$aDatos['contactoMail'] = filter_input(INPUT_POST, "contactoMail");

// Pestaña Extras
$aDatos['direccionEntrega'] = filter_input(INPUT_POST, "direccionEntrega");
$aDatos['direccionCobro'] = filter_input(INPUT_POST, "direccionCobro");
$aDatos['comentario'] = filter_input(INPUT_POST, "comentarios");

$cDb = new DataBase();

if ($cIdCliente != "") {
    $sWhere = "idCliente = $cIdCliente";
    $actualizado = $cDb->update("cliente", $aDatos, $sWhere);
} else {
    $actualizado = $cDb->insert("cliente", $aDatos);
}

$Mensaje = "Datos del Cliente Guardados Correctamente";
if (!$actualizado) {
    $Mensaje = $cDb->LastError;
}

$return = array("correcto" => $actualizado, "mensaje" => $Mensaje);
echo json_encode($return);
