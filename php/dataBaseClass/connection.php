<?php

class DataBase {

    // Propiedades
    public $link;
    public $LastError = "";
    public $LastInsertedId = 0;

    private function connect() {
        include_once filter_input(INPUT_SERVER, 'CONTEXT_DOCUMENT_ROOT') . '/php/dataBaseClass/DB.php';
        $this->link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    }

    private function disconnect() {
        mysqli_close($this->link);
    }

    private function formatValue($value) {
        $sReturn = "";
        $sType = gettype($value);
        switch ($sType) {
            case "integer":
                $sReturn = strval($value);
                break;
            case "double":
                $sReturn = strval($value);
                break;
            case "string":
                $sReturn = mysqli_real_escape_string($this->link, trim($value));
                $sReturn = "'" . $sReturn . "'";
                break;
            case "boolean":
                $sReturn = $value;
                break;
            case "NULL":
                $sReturn = 'NULL';
                break;
            default:
                $sReturn = "";
                break;
        }
        return $sReturn;
    }

    public function insert($sTable, $aData, $lUseReplace) {
        if (!isset($lUseReplace)) {
            $lUseReplace = false;
        }
        $this->LastError = "";
        $this->connect();
        $afields = array();
        $aValues = array();
        foreach (array_keys($aData) as $index => $key) {
            $afields[] = $key;
            $aValues[] = $this->formatValue($aData[$key]);
        }
        $sPrefix = ($lUseReplace ? "REPLACE" : "INSERT");
        
        $query = $sPrefix . " INTO $sTable" . "(" . implode(",", $afields) . ")" . " VALUES(" . implode(",", $aValues) . ")";

        $result = mysqli_query($this->link, $query);
        if (!$result) {
            $this->LastError = "Error al tratar de Insertar el Registro: " . mysqli_error($this->link);
        }
        $this->LastInsertedId = mysqli_insert_id($this->link);
        $this->disconnect();
        return empty($this->LastError);
    }

    public function update($sTable, $aData, $sWhere) {
        $this->LastError = "";
        $this->connect();
        $aUpdates = array();
        foreach (array_keys($aData) as $index => $key) {
            $sValue = $this->formatValue($aData[$key]);
            $aUpdates[] = "$key = $sValue";
        }
        $query = "UPDATE $sTable SET " . implode(",", $aUpdates);

        if (!empty($sWhere)) {
            $query = $query . " WHERE " . $sWhere;
        }
        $result = mysqli_query($this->link, $query);
        if (!$result) {
            $this->LastError = "Error al tratar de actualizar los datos: " . mysqli_error($this->link);
        }
        $this->disconnect();
        return empty($this->LastError);
    }

    public function select($aFields, $sTable, $sWhere, $sOrder, $sLimit) {
        $query = "SELECT " . implode(",", $aFields);
        $query = $query . " FROM " . $sTable;
        if ($sWhere != "") {
            $query = $query . " WHERE " . $sWhere;
        }
        if ($sOrder != "") {
            $query = $query . " ORDER BY " . $sOrder;
        }
        if ($sLimit != "") {
            $query = $query . " LIMIT " . $sLimit;
        }
        $this->LastError = "";
        $this->connect();
        $result = mysqli_query($this->link, $query);
        if (!$result) {
            $this->LastError = "Error al tratar de realizar la consulta" . mysqli_error($this->link);
        }
        $this->disconnect();
        return $result;
    }

    public function query($sQuery){
        $this->LastError = "";
        $this->connect();
        $result = mysqli_query($this->link, $sQuery);
        if(!$result){
            $this->LastError = "Error en la ejecucion de la consulta: " . mysqli_error($this->link);
        }
        $this->disconnect();
        return $result;
    }
    
    public function delete($sTable, $sWhere){
        $this->LastError = "";
        if(empty($sTable)){
            $this->LastError = "No se selecciono una Tabla para eliminar los registros";
            return FALSE;
        }
        if(empty($sWhere)){
            $this->LastError = "No se puede eliminar registros de la tabla si no se especifica una clausula";
            return FALSE;
        }
        $query = "DELETE FROM " . $sTable . " WHERE " . $sWhere;
        $this->connect();
        $result = mysqli_query($this->link, $query);
        if(!$result){
            $this->LastError = "Error al tratar de eliminar el registro en [". $sTable . "]: " . mysqli_error($this->link);
        }
        $this->disconnect();
        return $result;
    }
}
