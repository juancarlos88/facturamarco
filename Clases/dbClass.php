<?php

Class dbClass {

    var $link;
    var $host;
    var $user;
    var $pass;
    var $dbname;

    function dbClass() {

        if($_SERVER['HTTP_HOST'] == 'localhost:8080') {
            $this->host = 'localhost';
            $this->user = 'root';
            $this->pass = '';
            $this->dbname = 'facturasma';
            
        } else {
            $this->host = '50.63.108.64';
            $this->user = 'facturamarco';
            $this->pass = 'Factura1140!';
            $this->dbname = 'facturamarco';
        }
        
        
        $this->link = mysql_connect($this->host, $this->user, $this->pass) or die('NO SE PUDO CONCETAR AL SERVIDOR: <br/>' . mysql_error());
        mysql_select_db($this->dbname, $this->link) or die('NO SE ENCNOTRO LA BASE DE DATOS: <br/>' . mysql_error());
        mysql_query("SET NAMES 'utf8'");
    }
    
    function closeDbClass() {
        
    }

    function runQuery($query) {
        $res = mysql_query($query, $this->link) or die('NO SE PUDO EJECUTAR AL CONSULTA: <br/>' . $query . '<br>' . mysql_error());
        if ($res != 1) {
            while ($row = mysql_fetch_assoc($res)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    function numRegistros($resource) {
        $result = mysql_num_rows($resource);
        return $result;
    }

    function creaInsertQuery($tabla, $cols, $vals) {

        if ($tabla != '' && $cols != '' && $vals != '') {

            $result = "INSERT INTO " . $tabla . " (" . $cols . ") VALUES (" . $vals . ")";
        }
        return $result;
    }

    function creaUpdateQuery($tabla, $columnaValor) {

        if ($tabla != '' && $columnaValor != '') {

            $result = "UPDATE " . $tabla . " SET " . $columnaValor;
        }
        return $result;
    }

    function creaDeleteQuery($tabla, $condicion) {

        if ($tabla != '' && $condicion != '') {

            $result = 'DELETE FROM ' . $tabla . ' WHERE ' . $condicion;
        }
        return $result;
    }

    function escaparCharsDb($array) {

        if (is_array($array)) {

            foreach ($array as $key => $val) {

                $result[$key] = mysql_real_escape_string($val);
            }
        }
        return $result;
    }

}

?>