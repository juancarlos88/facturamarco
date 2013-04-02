<?php

Class mainClass {

    function mainClassDest() {
        
    }

    function arrayOrder($arreglo, $arregloPos) {

        if (is_array($arregloPos) && is_array($arreglo)) {

            foreach ($arregloPos as $key => $val) {

                $result[$val] = $arreglo[$val];
            }
        }
        return $result;
    }

    function creaArrayNoVacio($array) {

        if (is_array($array)) {

            foreach ($array as $key => $val) {

                if ($val != '') {

                    $result[$key] = $val;
                }
            }
        }
        return $result;
    }

    function creaArrayNoVacioCero($array) {

        if (is_array($array)) {

            foreach ($array as $key => $val) {

                if ($val != '' && $val != '0') {

                    $result[$key] = $val;
                }
            }
        }
        return $result;
    }

    function creaArrayCols($array) {

        if (is_array($array)) {

            foreach ($array as $key => $val) {

                $result[$key] = $key;
            }
        }
        return $result;
    }

    function arrayCaracteresIniFin($array, $simboloIni, $simboloFin) {

        if (is_array($array)) {

            foreach ($array as $key => $val) {

                $result[$key] = $simboloIni . $val . $simboloFin;
            }
        }
        return $result;
    }

    function creaArrayPosicionesString($arrayPosiciones, $arrayValores, $simbolo) {

        if (is_array($arrayPosiciones) && is_array($arrayValores)) {

            foreach ($arrayPosiciones as $key => $val) {

                if (isset($arrayValores[$val])) {

                    $result [$key] = $key . $simbolo . $arrayValores[$val];
                }
            }
        }
        return $result;
    }

    function creaArrayStringFin($array, $simbolo) {

        if (is_array($array)) {

            $totalPos = count($array);
            $cont = 1;

            foreach ($array as $key => $val) {

                if ($cont < $totalPos) {

                    $result .= $val . $simbolo;
                } else {

                    $result .= $val;
                }
                $cont++;
            }
        }
        return $result;
    }

    function validaCamposObligatorios($post, $arrayObligatorios) {

        if (is_array($post) && is_array($arrayObligatorios)) {

            foreach ($arrayObligatorios as $key => $val) {

                if ($post[$val] == '' || $post[$val] == '0') {

                    $error[$val] = 1;
                }
            }
        }
        return $error;
    }

    function creaMensajesError($erroresObligatorios, $mensajesError) {

        if (is_array($erroresObligatorios)) {

            foreach ($erroresObligatorios as $key => $val) {

                $mensajes[$key] = $mensajesError[$key];
            }
        }
        return $mensajes;
    }

    function sumaErroresTotales($arrayMsjErrores) {

        if (is_array($arrayMsjErrores) && !empty($arrayMsjErrores)) {

            foreach ($arrayMsjErrores as $key => $val) {

                if ($val != '') {

                    $errores++;
                }
            }
        }
        return $errores;
    }

    function creaStringArray($array, $simbolo) {

        if (is_array($array) && !empty($array)) {

            foreach ($array as $key => $val) {

                $string .= $val . $simbolo;
            }
        }
        return $string;
    }

    /**
     * Crea un array con bidimensional, de acuerdo a las posiciones que se 
     * le hayan enviado.
     * 
     * @param array $array - Arreglo tridimensional, con los valores que necesitamos.
     * @param string $posKey - Posicions que ir� en la key.
     * @param string $posVal - Posicion que ir� en el value.
     * @return array
     * @author JCRC 
     */
    function creaArrayPosiciones($array, $posKey, $posVal) {

        if (is_array($array)) {

            foreach ($array as $key => $val) {

                $result[$val[$posKey]] = $val[$posVal];
            }
        }
        return $result;
    }

    function eliminarCacacteresEspeciales($array, $arrayChars) {

        if (is_array($array)) {

            foreach ($array as $key => $val) {

                foreach ($arrayChars as $key2 => $val2) {

                    $array[$key] = str_replace($key2, $val2, $array[$key]);
                }
            }
        }
        return $array;
    }

    function sustituyeCharsArray($array, $arrayChars, $replace) {

        if (is_array($array) && is_array($arrayChars)) {

            foreach ($array as $key => $val) {

                $result[$key] = str_replace($arrayChars, $replace, $val);
            }
        }
        return $result;
    }

    function sustituyeRegularExp($array, $reemplazo) {

        if (is_array($array) && is_array($reemplazo)) {

            $result = $array;

            foreach ($result as $key => $val) {

                $string = $val;

                foreach ($reemplazo as $key2 => $val2) {

                    $string = preg_replace($key2, $val2, $string);
                }
                $result[$key] = $string;
            }
        }
        return $result;
    }

}

?>