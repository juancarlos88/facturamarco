<?php
function getAcceso($cols) {

    if ($cols != '') {

        $dbClass = new dbClass();
        $query = "SELECT $cols FROM acceso"; // echo $query;
        $result = $dbClass->runQuery($query);
    }
    return $result;
}

function infoAccesoCond($cols, $condicion) {

    if ($cols != '' && $condicion != '') {

        $dbClass = new dbClass();
        $query = "SELECT $cols FROM acceso WHERE $condicion"; // echo $query;
        $result = $dbClass->runQuery($query);
    }
    return $result;
}

function getAccesoCond($cols, $user, $pass) {

    if ($user != '' && $pass != '') {

        $dbClass = new dbClass();
        $query = "SELECT $cols FROM acceso WHERE 
			usuarioacceso='$user' AND passacceso='$pass'"; // echo $query;
        $result = $dbClass->runQuery($query);
    }
    return $result;
}

function infoClientes($cols, $inner, $condicion) {

    if ($cols != '' && $condicion != '') {

        $dbClass = new dbClass();
        $query = "SELECT $cols FROM cliente $inner WHERE ".$condicion;
        $result = $dbClass->runQuery($query);
    }
    return $result;
}

function infoConcepto($cols, $inner, $condicion) {

    if ($cols != '' && $condicion != '') {

        $dbClass = new dbClass();
        $query = "SELECT $cols FROM concepto $inner WHERE ".$condicion;
        $result = $dbClass->runQuery($query);
    }
    return $result;
}

function info_facturas($cols, $condicion = 1, $inner = '') {
    
    if($cols != '') {
        
        $dbClass = new dbClass();
        $query = "SELECT $cols FROM factura $inner WHERE ".$condicion; // echo $query;
        $result = $dbClass->runQuery($query);
    }
    return $result;
}

function info_facturas_flip($cols, $inner = '', $condicion = 1) {
    
    if($cols != '') {
        
        $dbClass = new dbClass();
        $query = "SELECT $cols FROM factura $inner WHERE ".$condicion; // echo $query;
        $result = $dbClass->runQuery($query);
    }
    return $result;
}

function info_conceptos($cols = '*', $condicion = 1, $inner = '') {
    
    if($cols != '') {
        
        $dbClass = new dbClass();
        $query = "SELECT $cols FROM concepto $inner WHERE ".$condicion; // echo '<br/> ---> '.$query;
        $result = $dbClass->runQuery($query);
    }
    return $result;
}
?>