<?php
/**
 * Script:    DataTables server-side script for PHP 5.2+ and MySQL 4.1+
 * Notes:     Based on a script by Allan Jardine that used the old PHP mysql_* functions.
 *            Rewritten to use the newer object oriented mysqli extension.
 * Copyright: 2010 - Allan Jardine (original script)
 *            2012 - Kari Söderholm, aka Haprog (updates)
 * License:   GPL v2 or BSD (3-point)
 */
session_start();
mb_internal_encoding('UTF-8');
 
/**
 * Array of database columns which should be read and sent back to DataTables. Use a space where
 * you want to insert a non-database field (for example a counter or static image)
 */
//$aColumns = array( 'idCliente', 'rfc', 'nombre', 'direccion' );
  
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'idCliente';
  
// DB table to use
$sTable = 'cliente';
  
 
// Input method (use $_GET, $_POST or $_REQUEST)
$input =& $_GET;
 
require('DataTableMysql.php');
//echo json_encode('nada');
echo DataTablesJson($input,$sTable,$sIndexColumn);