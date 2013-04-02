<?php

/**
 * ********************************************************************
 * 				PAGINACIÓN PARA CUALQUIER PROYECTO.
 * @author - JCRC
 * @version - 2.0
 * @date - 26/03/2012
 * ********************************************************************
 */
Class pagingClass {

    var $total;
    var $maxDisplay;
    var $maxPaging;
    var $lastPage;
    var $ini;
    var $fin;

    /**
     * 	SE COMIENZA LA PAGINACION, Y SE ABRE LA CLASE.
     * 
     * @param $totalRows <int> Número total de renglones encontrados en la búsqueda.
     * @param $maxDisplay <int> Número máximo de renglones a desplegar por página.
     * @param $maxPaging <int> Cantidad de páginas se mostrarán.
     */
    function pagingClass($totalRows, $maxDisplay, $maxPaging) {

        $this->total = $totalRows;
        $this->page = $pageGet;
        $this->lastPage = ceil($totalRows / $maxDisplay);
        $this->maxPaging = $maxPaging;
        if ($this->lastPage < $maxPaging) {

            $this->maxPaging = $this->lastPage;
        }
    }

    function desctPagingClass() {
        
    }

    function validaGet($get) {

        $resultGet = 1;

        if ($get == '' || $get == 1) {

            $resultGet = 1;
        } else if ($get > $this->lastPage) {

            $resultGet = $this->lastPage;
        } else {

            $resultGet = $get;
        }
        $this->page = $resultGet;
        return $resultGet;
    }

    /**
     * 	REALIZA LAS OPERACIONES NECESARIAS PARA SABER QUE NÚMEROS DEBE DESPLEGAR LA PAGINACION. 
     */
    function calculaPaginacion() {

        $mitad = $this->maxPaging / 2;
        $mitadMax = $this->lastPage - $mitad;

        if ($mitad > $this->page) {

            $ini = 1;
            $fin = $this->maxPaging;
        } else if ($mitad <= $this->page && $mitadMax >= $this->page) {

            $ini = $this->page - $mitad;
            $fin = $this->page + $mitad;
        } else {

            $ini = $this->lastPage - $this->maxPaging + 1;
            $fin = $this->lastPage;
        }
        if ($ini < 1) {

            $ini = 1;
        }
        $this->ini = ceil($ini);
        $this->fin = floor($fin);
    }

    /**
     * 	CONSTRUYE MENSAJES DE INICIO Y FIN DE LA PAGINACION.
     * 
     * @param $mensajeIni <string> Mensaje, imagen, palabras, simbolo que queremos que tenga el inicio.
     * @param $mensajeFin <string> Mensaje, imagen, palabras, simbolo que queremos que tenga el fin
     * @param $ruta <string> Ruta completa de donde queremos que nos lleve la paginacion.
     * @param $idGet <string> id (variable) que queremos tenga el get de la paginación.
     * @param $simbolo <string> Símbolo que queremos tenga el get '&' o '?'.	 
     */
    function linkPaginacionIniFin($mensajeIni, $mensajeFin, $ruta, $idGet, $simbolo, $classLink = '') {

        $result = array('ini' => '', 'fin' => '');

        // LINK PARA PAGINA UNO
        if ($this->page > 1) {

            if ($mensajeIni == '') {

                $mensajeIni = '«';
            }
            $result['ini'] = '<a href="' . $ruta . $simbolo . $idGet . '=1" title="P&aacute;gina 1" ' . $classLink . '>' . $mensajeIni . '</a> ';
        }

        // LINK PARA PAGINA 2
        if ($this->page < $this->lastPage) {

            if ($mensajeFin == '') {

                $mensajeFin = '»';
            }
            $result['fin'] = ' <a href="' . $ruta . $simbolo . $idGet . '=' . $this->lastPage . '" title="P&aacute;gina ' . 
                    $this->lastPage . '" ' . $classLink . '>' . $mensajeFin . '</a>';
        }
        return $result;
    }

    /**
     * 	CONSTRUYE MENSAJES DE SIGUIENTE Y ANTERIOR DE LA PAGINACION
     * 
     * @param $mensajeIni <string> ;Mensaje, imagen, palabras, simbolo que queremos que tenga el siguiente.
     * @param $mensajeFin <string> Mensaje, imagen, palabras, simbolo que queremos que tenga el anterior.
     * @param $ruta <string> Ruta completa de donde queremos que nos lleve la paginacion.
     * @param $idGet <string> id (variable) que queremos tenga el get de la paginación.
     * @param $simbolo <string> Símbolo que queremos tenga el get '&' o '?'.	 
     */
    function linkSigAnt($mensajeSig, $mensajeAnt, $ruta, $idGet, $simbolo, $classLink = '') {

        $result = array('ini' => '', 'fin' => '');

        // LINK PARA PAGINA UNO
        if ($this->page > 1) {

            if ($mensajeSig == '') {

                $mensajeSig = ' < ';
            }
            $anterior = $this->page - 1;
            $result['ini'] = '<a href="' . $ruta . $simbolo . $idGet . '=' . $anterior . '" title="P&aacute;gina ' . 
                    $anterior . '" ' . $classLink . '>' . $mensajeSig . '</a>';
        }

        // LINK PARA PAGINA 2
        if ($this->page < $this->lastPage) {

            if ($mensajeAnt == '') {

                $mensajeAnt = ' > ';
            }
            $siguiente = $this->page + 1;
            $result['fin'] = ' <a href="' . $ruta . $simbolo . $idGet . '=' . $siguiente . '" title="P&aacute;gina ' . 
                    $siguiente . '" ' . $classLink . '>' . $mensajeAnt . '</a>';
        }
        return $result;
    }

    /**
     * 	CREA LA NUMERACIÓN QUE TENDRÁ LA PAGINACIÓN.
     * 
     * @param $ruta <string> Ruta completa de donde queremos que nos lleve la paginacion.
     * @param $idGet <string> id (variable) que queremos tenga el get de la paginación.
     * @param $simbolo <string> Símbolo que queremos tenga el get '&' o '?'.	 
     */
    function creaPaginasSimple($ruta, $idGet, $simbolo) {

        for ($pag = $this->ini; $pag <= $this->fin; $pag++) {

            if ($pag == $this->page) {

                $result .= ' ' . $pag . ' ';
            } else {

                $result .= '<a href="' . $ruta . $simbolo . $idGet . '=' . $pag . '" title="P&aacute;gina ' . 
                        $pag . '"> ' . $pag . ' </a>';
            }
        }
        return $result;
    }

    function creaPaginaTableTd($ruta, $idGet, $simbolo) {

        for ($pag = $this->ini; $pag <= $this->fin; $pag++) {

            if ($pag == $this->page) {

                $result .= '<td> ' . $pag . ' </td>';
            } else {

                $result .= '<td> 
                    <a href="' . $ruta . $simbolo . $idGet . '=' . $pag . '" title="P&aacute;gina ' . 
                        $pag . '"> ' . $pag . ' </a>
                </td>';
            }
        }
        return $result;
    }
    
    function creaPaginaTableLi($ruta, $idGet, $simbolo, $classActive = '', $classLink = '') {

        for ($pag = $this->ini; $pag <= $this->fin; $pag++) {

            if ($pag == $this->page) {

                $result .= '<li ' . $classActive . '><a href="#N" ' . $classLink . '> ' . $pag . ' </a></li>';
                
            } else {

                $result .= '<li> 
                    <a href="' . $ruta . $simbolo . $idGet . '=' . $pag . '" title="P&aacute;gina ' . 
                        $pag . '"  ' . $classLink . '> ' . $pag . ' </a>
                </li>';
            }
        }
        return $result;
    }

}

?>