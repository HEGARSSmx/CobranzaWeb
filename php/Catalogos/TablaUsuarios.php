<?php
session_start();
mb_internal_encoding('UTF-8');
 
$sIndexColumn = 'userId';
  
// DB table to use
$sTable = 'usuario';
  
 
// Input method (use $_GET, $_POST or $_REQUEST)
$input =& $_GET;
 
require '../DataTableMysql.php';
//echo json_encode('nada');
echo DataTablesJson($input,$sTable,$sIndexColumn);