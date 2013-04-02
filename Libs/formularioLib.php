<?php

function validaCampos($arrayPost, $arrayObligatorios, $msjError, $arrayOrder, $charsPeligrosos) {

    $main = new mainClass();

    $arrayPost = $main->arrayOrder($arrayPost, $arrayOrder);
    $arrayPost = $main->eliminarCacacteresEspeciales($arrayPost, $charsPeligrosos);
    $erroresOblig = $main->validaCamposObligatorios($arrayPost, $arrayObligatorios);
    $arrayMsjsError = $main->creaMensajesError($erroresOblig, $msjError);
    $erroresTot = $main->sumaErroresTotales($arrayMsjsError);

    $result['numErrores'] = $erroresTot;
    $result['msjErrores'] = $arrayMsjsError;
    $result['arrayLimpio'] = $arrayPost;
    return $result;
}

function insertarQueryCondicion($arrayValores, $tabla) {

    $main = new mainClass();
    $dbClass = new dbClass();
    $arrayReplace = array('\r\n', '\n', '\r');

    $vals = $main->creaArrayNoVacio($arrayValores);
    $vals = $dbClass->escaparCharsDb($vals);
    $vals = $main->sustituyeCharsArray($vals, $arrayReplace, '<br/>');
    $cols = $main->creaArrayCols($vals);
    $valores = $main->arrayCaracteresIniFin($vals, "'", "'");
    $columnas = $main->creaArrayStringFin($cols, ',');
    $valores = $main->creaArrayStringFin($valores, ',');
    $query = $dbClass->creaInsertQuery($tabla, $columnas, $valores);
// echo '<br/>-- '.$query;
    $dbClass->runQuery($query);
    $result = mysql_insert_id();
    return $result;
}

function updateQueryCondicion($arrayValores, $tabla, $condicion) {

    $main = new mainClass();
    $dbClass = new dbClass();
    $arrayReplace = array('\r\n', '\n', '\r');

    $vals = $dbClass->escaparCharsDb($arrayValores);
    $vals = $main->sustituyeCharsArray($vals, $arrayReplace, '<br/>');
    $cols = $main->creaArrayCols($vals);
    $valores = $main->arrayCaracteresIniFin($vals, "'", "'");
    $colsVals = $main->creaArrayPosicionesString($cols, $valores, '=');
    $colsValores = $main->creaArrayStringFin($colsVals, ',');
    $query = $dbClass->creaUpdateQuery($tabla, $colsValores);
    $queryUpdate = $query . ' WHERE ' . $condicion;
// echo '<br/>-UPDATE- '.$queryUpdate;
    $dbClass->runQuery($queryUpdate);
    return $result;
}

function stringBusquedaAND($arrayPost) {

    if (is_array($arrayPost)) {

        $main = new mainClass();
        $dbClass = new dbClass();

        $array = $main->creaArrayNoVacioCero($arrayPost);
        $arrayReplace = array('\r\n', '\n', '\r');

        $vals = $dbClass->escaparCharsDb($array);
        $vals = $main->sustituyeCharsArray($vals, $arrayReplace, '<br/>');
        $cols = $main->creaArrayCols($vals);
        $valores = $main->arrayCaracteresIniFin($vals, "'", "'");
        $colsVals = $main->creaArrayPosicionesString($cols, $valores, '=');
        $colsValores = $main->creaArrayStringFin($colsVals, ' AND ');  // AND

        return $colsValores;
    }
}

function creaDeleteQuery($tabla, $condicion) {

    $dbClass = new dbClass();
    $queryDel = $dbClass->creaDeleteQuery($tabla, $condicion); // echo $queryDel;
    $dbClass->runQuery($queryDel);
    $dbClass->closeDbClass();
}

function condMultipleOpc($columna, $opciones) {

    if (is_array($opciones) AND !empty($opciones)) {

        $totalOpc = count($opciones);
        $contador = 1;        
        $result = $columna . ' IN (';

        foreach ($opciones as $llave => $opcion) {

            $result .= "'".$opcion."'";

            if ($contador < $totalOpc) {
                $result .= ',';
            } 
            $contador++;
        }
        $result .= ')';
    } 
    return $result;
}

/**
 * 	========= REVISA QUE LOS CHECKBOX ESTÉN PUESTOS
 */
function revisaChecks($arrayChecks, $post) {

    if (is_array($arrayChecks)) {

        foreach ($arrayChecks as $key => $val) {

            if (isset($post[$val]) && $post[$val] != '') {

                $result[$val] = 'checked="checked"';
            } else {

                $result[$val] = '';
            }
        }
    }
    return $result;
}

function revisaRadios($arrayRadios, $post) {

    $result = $arrayRadios;
    if (is_array($arrayRadios) && is_array($post)) {

        foreach ($arrayRadios as $key => $val) {

            if (isset($post[$key]) && $post[$key] != '') {

                foreach ($val as $key2 => $val2) {

                    if ($post[$key] == $key2) {

                        $result[$key][$key2] = 'checked="checked"';
                    } else {

                        $result[$key][$key2] = '';
                    }
                }
            }
        }
    }
    return $result;
}

function creaArraySelects($arraySelects, $arrayNames, $arrayInfo, $arrayIds, 
            $resPost, $arrayIni, $arrayMsj, $arrayOptGroup = FALSE) {

    if (is_array($arraySelects)) {

        $htmlClass = new htmlClass();

        foreach ($arraySelects as $key => $val) {

            if (is_array($arrayInfo[$val])) {

                $result[$val] = $htmlClass->creaSelects($arrayNames[$val], 
                        $arrayInfo[$val], $arrayIds[$val], $resPost[$arrayNames[$val]], 
                        $arrayIni[$val], $arrayMsj[$val], $arrayOptGroup[$val]);
            }
        }
    }
    return $result;
}

function construyeGet($array) {

    if (is_array($array)) {

        $mainClass = new mainClass();
        $newArray = $mainClass->creaArrayNoVacioCero($array);

        if (is_array($newArray)) {

            $sum = 1;
            $total = count($newArray);

            foreach ($newArray as $key => $val) {

                if ($sum == 1) {
                    $result = '?';
                }
                $result .= $key . '=' . $val;

                if ($sum < $total) {

                    $result .='&';
                }
                $sum++;
            }
        }
    }
    return $result;
}

?>