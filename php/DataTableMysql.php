<?php

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
 * no need to edit below this line
 */

/**
 * Character set to use for the MySQL connection.
 * MySQL will return all strings in this charset to PHP (if the data is stored correctly in the database).
 */
function DataTablesJson($input, $sTable, $sIndexColumn) {

    /**
     * MySQL connection
     */
    include_once filter_input(INPUT_SERVER, 'CONTEXT_DOCUMENT_ROOT') . '/php/dataBaseClass/DB.php';
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    if (mysqli_connect_error()) {
        die('Error connecting to MySQL server (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }

    /**
     * Paging
     */
    $sLimit = "";
    if (isset($input['start']) && $input['length'] != '-1') {
        $sLimit = " LIMIT " . intval($input['start']) . ", " . intval($input['length']);
    }
    
    /*
     * Obtenemos los nombres de las columnas pasados por DataTables
     */
    $aDtColumns = $input['columns'];
    $aColumns = array();
    foreach ($aDtColumns as &$valor){
        if(isset($valor['data']) && $valor['data'] != ""){
            $aColumns[] = $valor['data'];
        }
    }

    /**
     * Ordering
     */
    $aOrderingRules = array();
    if (isset($input['order'])) {
        $aOrder = $input['order'];
        $iSortingCols = intval($aOrder['0']['column']);
        $aOrderingRules = $aColumns[intval($iSortingCols)] . " " . $aOrder['0']['dir'];
    }

    if (!empty($aOrderingRules)) {
        $sOrder = " ORDER BY " . $aOrderingRules;
    } else {
        $sOrder = "";
    }


    /**
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $iColumnCount = count($aColumns);
    $aSearch = $input['search'];
    if (isset($aSearch['value']) && $aSearch['value'] != "") {
        $aFilteringRules = array();
        $cValorBusqueda = $aSearch['value'];
        for ($i = 0; $i < $iColumnCount; $i++) {
            if (isset($input['columns'][$i]['searchable']) && $input['columns'][$i]['searchable'] == 'true') {
                $aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . $cValorBusqueda . "%'";
            }
        }
        if (!empty($aFilteringRules)) {
            $aFilteringRules = array('(' . implode(" OR ", $aFilteringRules) . ')');
        }
    }

// Individual column filtering
    for ($i = 0; $i < $iColumnCount; $i++) {
        if (isset($input['columns[' . $i . '][search][value]']) && $input['columns[' . $i . '][searchable]'] == 'true' && $input['columns[' . $i . '][search][value]'] != '') {
            $aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . mysqli_real_escape_string($input['columns[' . $i . '][search][value]']) . "%'";
        }
    }

    if (!empty($aFilteringRules)) {
        $sWhere = " WHERE " . implode(" AND ", $aFilteringRules);
    } else {
        $sWhere = "";
    }


    /**
     * SQL queries
     * Get data to display
     */
    $aQueryColumns = array();
    foreach ($aColumns as $col) {
        if ($col != ' ') {
            $aQueryColumns[] = $col;
        }
    }

    $sQuery = "SELECT SQL_CALC_FOUND_ROWS `" . implode("`, `", $aQueryColumns) . "`
    FROM `" . $sTable . "`" . $sWhere . $sOrder . $sLimit;

    $rResult = mysqli_query($db, $sQuery);

// Data set length after filtering
    $sQuery = "SELECT FOUND_ROWS()";
    $rResultFilterTotal = $db->query($sQuery) or die($db->error);
    list($iFilteredTotal) = $rResultFilterTotal->fetch_row();

// Total data set length
    $sQuery = "SELECT COUNT(`" . $sIndexColumn . "`) FROM `" . $sTable . "`";
    $rResultTotal = $db->query($sQuery) or die($db->error);
    list($iTotal) = $rResultTotal->fetch_row();


    /**
     * Output
     */
    $output = array(
        "draw" => intval($input['draw']),
        "recordsTotal" => $iTotal,
        "recordsFiltered" => $iFilteredTotal,
        "data" => array(),
    );

    while ($aRow = $rResult->fetch_assoc()) {
        $row = array();
        for ($i = 0; $i < $iColumnCount; $i++) {
            if ($aColumns[$i] != ' ') {
                // General output
                $row[$aColumns[$i]] = $aRow[$aColumns[$i]];
            }
        }
        $output['data'][] = $row;
    }

    return json_encode($output);
}
