<?php
    
function ordenaDatos($colsDb, $post) {

    foreach ($colsDb as $key => $val) {

        $result[$val] = $post[$key];
    }

    return $result;
}

/**
 * ********************************************************************************************
 * 							PROCESAMIENTO.
 * ********************************************************************************************
 */

$mainClass = new mainClass();
$htmlClass = new htmlClass();

$propertyMensaje = 'style="margin:0px 20px; text-align:left;"'; // FIJO

//  USUARIO


$arraySelects = array();
$arrayNames = array();
$arrayIds = array();
$arrayIni = array();
$arrayIniMsj = array();

// $arrayInfo['gestores'] = $mainClass->creaArrayPosiciones($gestores, 'id', 'codigo');



//  ***************** VARS PAGINACION ******************
$inner['all'] = ' AS cli'; 
$total = infoClientes('count(id_cliente) as total', $inner['all'], '1'); 
$totalRows = $total[0]['total'];
$maxDisplay = 25;
$maxPaging = 10;
$getPage = 1;

$mensajeSig = '&rarr;';
$mensajeAnt = '&larr;';

$mensajeIni = '';
$mensajeFin = '';

$ruta = $_SERVER['PHP_SELF'];
$idGet = 'page';
$simbolo = '?';
$limit = $maxDisplay;
$offset = 0;
// ********************* FIN VARS PAGINACION ********************

$colsBusqueda = "*, DATE_FORMAT(fecha_alta, '%d-%m-%Y') AS fecha_alta";
//$inner = $inner['all'];
$condicion = " bactivo = 'activo' ORDER BY razon_social ASC LIMIT " . $limit . ' OFFSET ' . $offset;
$info = infoClientes($colsBusqueda, $inner['all'], $condicion);

if ($_GET) {

    // PROCESAMIENTO GET.
    $get = $_GET;
    $condicion = "bactivo = 'activo'";

    $arrayOrder = array('cli');
    $colsGet = array('cli' => 'razon_social');
    // $charsPeligrosos = array('\\'=>'', '<'=>'', '>'=>'');			
    $resultValida = validaCampos($get, $arrayObligatorios, $msjError, $arrayOrder, array('<' => '', '>' =>''));
    $numErrores = $resultValida['numErrores'];
    $resGet = $resultValida['arrayLimpio']; 
    $msjErrores = $resultValida['msjErrores'];
    $getForm = construyeGet($resGet);
    
    if ($get['bdel'] == 1) {
        
        $idCliente = $get['fc'];
        $array['bactivo'] = 'desactivado';
        // desactivamos al cliente
        updateQueryCondicion($array, 'cliente', 'id_cliente = ' . $idCliente);
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
    
    //$newArrayGet = ordenaDatos($colsGet, $resGet);
    //$condicion = stringBusquedaAND($newArrayGet);
    
    if ($resGet['cli'] != '') {
        
        $condicion = "bactivo = 'activo' AND razon_social LIKE '%" . $resGet['cli'] . "%' COLLATE utf8_general_ci ";
    }
    
    
    // *************************** PAGINACION *************************
    if ($get[$idGet] != '') {

        $getPage = $get[$idGet]; // PAGINACION
        $offset = $limit * ($getPage - 1); // PAGINACION
    }
    
    if ($getForm != '') {

        $simbolo = '&'; // PAGINACION
        $ruta .= $getForm; // PAGINACION
    }
    
    if ($condicion  == '') {
        
        $condicion = "bactivo = 'activo'";
    }
    
    $total = infoClientes('count(id_cliente) as total', $inner['all'], $condicion);

    if ($getPage != '') {

        $offset = $limit * ($getPage - 1); // PAGINACION		        
    }

    $condicion .= ' ORDER BY razon_social ASC LIMIT ' . $limit . ' OFFSET ' . $offset;
    $info = infoClientes($colsBusqueda, $inner['all'], $condicion);
    $totalRows = $total[0]['total'];
    // *************************** PAGINACION *************************    
} 

// *************************** PAGINACION *************************
$pageClass = new pagingClass($totalRows, $maxDisplay, $maxPaging);
$getPage = $pageClass->validaGet($get[$idGet]);
$pageClass->calculaPaginacion();
$pagesIni = $pageClass->linkPaginacionIniFin($mensajeIni, $mensajeFin, $ruta, $idGet, $simbolo, 'style="color:#2F96B4; font-weight:normal;"');
$pagesMid = $pageClass->linkSigAnt($mensajeAnt, $mensajeSig, $ruta, $idGet, $simbolo, 'style="color:#2F96B4; font-weight:normal;"');
$paginas = $pageClass->creaPaginaTableLi($ruta, $idGet, $simbolo, 'class="active"', 'style="color:#2F96B4; font-weight:normal;"');
// *


$selects = creaArraySelects($arraySelects, $arrayNames, $arrayInfo, $arrayIds, $resPost, $arrayIni, $arrayIniMsj);
?>