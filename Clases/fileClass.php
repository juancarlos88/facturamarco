<?php

Class fileClass {

    var $size;
    var $type;
    var $name;

    function fileClass($file) {

        $this->size = $file['size'];
        $this->type = $file['type'];
        $this->name = $file['name'];
        // $this->errors = 0;
    }

    function fileDestructor() {
        
    }

    function validaArchivo($arrayType, $size, $mensajes) {

        $errores = 0;
        if ($this->name != '') {

            if (!in_array($this->type, $arrayType)) {

                // ERROR TIPO ARCHIVO						
                $msjErrores['type'] = $mensajes['type'];
                $errores++;
            }
            // echo $this->size . ' > '.$size;
            if ($this->size > $size) {

                // ERROR TAMA�O DEL ARCHIVO			
                $msjErrores['size'] = $mensajes['size'];
                $errores++;
            }
        } else {

            $msjErrores['name'] = $mensajes['name'];
            $errores++;
        }
        $result['numErrores'] = $errores;
        $result['msjErrores'] = $msjErrores;
        return $result;
    }

    function extensionNombre() {

        $main = new mainClass;
        $arrayRemp = array('/(À|Á|Â|Ã|Ä|Å)/' => 'A', '/(à|á|â|ã|ä|å)/' => 'a', '/(Ò|Ó|Ô|Õ|Ö|Ø)/' => 'O',
            '/(ò|ó|ô|õ|ö|ø)/' => 'o', '/(È|É|Ê|Ë)/' => 'E', '/(è|é|ê|ë)/' => 'e', '/(Ç)/' => 'C', '/(ç)/' => 'c',
            '/(Ì|Í|Î|Ï)/' => 'I', '/(ì|í|î|ï)/' => 'i', '/(Ù|Ú|Û|Ü)/' => 'U', '/(ù|ú|û|ü)/' => 'u',
            '/(ÿ)/' => 'y', '/(Ñ)/' => 'N', '/(ñ)/' => 'n');
        $posDot = strrpos($this->name, '.');
        $extension = strtolower(substr($this->name, $posDot + 1));
        $name['name'] = substr($this->name, 0, $posDot);
        $nombre = $main->sustituyeRegularExp($name, $arrayRemp);
        $result['extension'] = $extension;
        $result['nombre'] = $nombre['name'];
        return $result;
    }

    function calculaPesoRealArchivo($peso, $decimales) {

        $realSize = 0;

        if ($peso > 0) {

            $clase = array(" Bytes", " KB", " MB", " GB", " TB");
            $realSize = round($peso / pow(1024, ($i = floor(log($peso, 1024)))), $decimales) . $clase[$i];
        }
        return $realSize;
    }

    function tipoArchivo($extension) {

        switch ($extension) {

            case 'jpg':
            case 'gif':
            case 'png':
            case 'bmp':
                $result = 'imagen';
                break;
            case 'doc':
            case 'docx':
                $result = 'word';
                break;
            case 'xls':
            case 'xlsx':
                $result = 'excel';
                break;
            case 'ppt':
            case 'pptx':
                $result = 'powerpoint';
                break;
            case 'pdf':
                $result = 'pdf';
                break;
            case 'txt':
                $result = 'txt';
                break;
            // PODR�A HABER M�S CASOS			
        }
        return $result;
    }

}

?>