<?php

Class htmlClass {

    function htmlClassDest() {
        
    }

    /*
     * **************************************************
     *                  HTML FUNCTIONS.
     * **************************************************
     */

    /**
     * Construye una forma de selects.
     * 
     * @param <string> $selectName Contiene el "name" que tendrá el select
     * @param <array> $select Contiene los valores y posiciones que contendrá las options del select
     * @param <string> $propertiesSelect Propiedads que queremos tenga el select, style, javascript, etc.
     * @param <valor> $selected Valor que llegó en le post, para saber cuál debe ir seleccionado
     * @param <string> $posCero Variable contiene el value de la primera posición del select.
     * @param <string> $valCero Valor que tendrá la primera posición del select
     */
    function creaSelects($selectName, $select, $propertiesSelect, $selected, $posCero, $valCero, $optGroup) {

        if (is_array($select)) {

            $result = '<select name="' . $selectName . '" ' . $propertiesSelect . '>';

            if ($valCero != '') {

                $result .= '<option value="' . $posCero . '"> ' .
                        $valCero .
                        ' </option>';
            }

            if ($optGroup != '') {

                $result .= '<optgroup label="' . $optGroup . '">';
            }

            foreach ($select as $key => $val) {

                $check = '';
                if ($selected == $key) {
                    $check = 'selected="selected"';
                }
                $result .= '<option value="' . $key . '" ' . $check . '>' .
                        $val .
                        '</option>';
            }
            
            if($optGroup != '') {
                
                $result .= '<optgroup/>';
            }
            
            $result .= '</select>';                      
        }
        return $result;
    }

    function creaSelectsAJAXCampo($selectName, $select, $propertieSelect, $selected, $posCero, $valCero, $ruta, $idCampoRes) {

        if (is_array($select)) {

            $result = '<select name="' . $selectName . '" id="' . $selectName . '" ' . $propertieSelect . '	onChange="busquedaAJAXCampo(document.getElementById(\'' . $selectName . '\').value, \'' . $ruta . '\', \'' . $idCampoRes . '\')">';
            $result .= '<option value="' . $posCero . '"> ' .
                    $valCero . ' </option>';

            foreach ($select as $key => $val) {

                $check = '';
                if ($selected == $key) {
                    $check = 'selected="selected"';
                }
                $result .= '<option value="' . $key . '" ' . $check . '>' .
                        $val . '</option>';
            }
            $result .= '</select>';
        }
        return $result;
    }

    /**
     * CONTRUYE MENSAJES EN FORMA DE LISTA.
     * 
     * @param <array> $array Contiene los mensajes. (una dimensión)
     * @param <string> $style Contiene el id, style, o javascript que tendrá el listado
     * @param <string> 
     */
    function construyeMensajesLista($array, $properties = '') {

        if (is_array($array)) {

            $result = '<ul ' . $properties . '>';

            foreach ($array as $key => $val) {

                $result .= '<li>' . $val . '</li>';
            }
            $result .= '</ul>';
        }
        return $result;
    }

    function construyeStringErrorJS($mensajesError) {

        if (is_array($mensajesError)) {

            $mensaje = '';
            $count = count($mensajesError);
            $cuenta = 1;

            foreach ($mensajesError as $key => $val) {

                $mensaje .= $val;
                if ($cuenta < $count) {
                    $mensaje .= '\n';
                }
                $cuenta++;
            }
            $result = '<script type="text/javascript">';
            $result .= "alert('" . $mensaje . "');";
            $result .= '</script>';
        }
        return $result;
    }

}

?>