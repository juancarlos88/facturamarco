<?php
function calculaTotal($facs) {
    
    if(is_array($facs)) {
        
        $result = $facs; 
        
        foreach ($facs as $key=>$val) {

            $precio = info_conceptos('cantidad, precio_unitario, id_factura', 'id_factura='.$val['id_factura']);

            if(is_array($precio)) {                
            
                foreach ($precio as $key2=>$val2) {

                    $result[$key]['total_fac'] += ($val2['precio_unitario'] * $val2['cantidad']);
                }
            }
        }
    }
    return $result;
}

/**
 * ********************************************************************************************
 * 							PROCESAMIENTO.
 * ********************************************************************************************
 */

/*$cols = '*';
$inner = 'fac JOIN cliente cli ON fac.id_cliente=cli.id_cliente';
$condicion = '1' . $condGet['factura'] . $condGet['cliente'];
$condicion .= ' ORDER BY fac.num_factura DESC, fac.fecha_altaf DESC ';
$facs = info_facturas($cols, $condicion, $inner); 
$facs = calculaTotal($facs);*/

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
$inner['all'] = ' AS fac LEFT JOIN cliente cli ON fac.id_cliente=cli.id_cliente'; 
$total = info_facturas_flip('count(id_factura) as total', $inner['all'], '1'); 
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

$colsBusqueda = "*";
//$inner = $inner['all'];
$condicion = ' 1 ORDER BY num_factura DESC LIMIT ' . $limit . ' OFFSET ' . $offset;
$info = info_facturas_flip($colsBusqueda, $inner['all'], $condicion);

if ($_GET) {
    
    $get = $_GET;
    
    // PROCESAMIENTO GET.
    $get = $_GET;
    $condicion = "1";

    $arrayOrder = array('cli', 'num');
    $colsGet = array('cli' => 'razon_social', 'num' => 'num_social');
    // $charsPeligrosos = array('\\'=>'', '<'=>'', '>'=>'');			
    $resultValida = validaCampos($get, $arrayObligatorios, $msjError, $arrayOrder, array('<' => '', '>' =>''));
    $numErrores = $resultValida['numErrores'];
    $resGet = $resultValida['arrayLimpio']; 
    $msjErrores = $resultValida['msjErrores'];
    $getForm = construyeGet($resGet);
    
    //$newArrayGet = ordenaDatos($colsGet, $resGet);
    //$condicion = stringBusquedaAND($newArrayGet);
    
    if ($get['bdel']) {
        
        if ($get['fc'] !== '') {        

            $code_factura = $get['fc'];
            $infoFac = info_facturas('id_factura', "code_factura='".$code_factura."'");
            $idFactura = $infoFac[0]['id_factura'];
            $idConcepto = $get['cc'];
            creaDeleteQuery('factura', 'id_factura='.$idFactura);
            creaDeleteQuery('concepto', 'id_factura='.$idFactura);
            header('Location: '.$_SERVER['PHP_SELF']);
        }
    }
    
    if ($resGet['cli'] != '') {
        
        $condicion .= " AND cli.razon_social LIKE '%" . $resGet['cli'] . "%' COLLATE utf8_general_ci ";
    }
    
    if ($resGet['num'] != '') {
        
        $condicion .= " AND fac.num_factura LIKE '%" . $resGet['num'] . "%' COLLATE utf8_general_ci ";
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
        
        $condicion = 1;
    }
    
    $total = info_facturas_flip('count(id_factura) as total', $inner['all'], $condicion);

    if ($getPage != '') {

        $offset = $limit * ($getPage - 1); // PAGINACION		        
    }

    $condicion .= ' ORDER BY num_factura DESC LIMIT ' . $limit . ' OFFSET ' . $offset;
    $info = info_facturas_flip($colsBusqueda, $inner['all'], $condicion);
    $totalRows = $total[0]['total'];
    // *************************** PAGINACION *************************
}

$info = calculaTotal($info); 

// *************************** PAGINACION *************************
$pageClass = new pagingClass($totalRows, $maxDisplay, $maxPaging);
$getPage = $pageClass->validaGet($get[$idGet]);
$pageClass->calculaPaginacion();
$pagesIni = $pageClass->linkPaginacionIniFin($mensajeIni, $mensajeFin, $ruta, $idGet, $simbolo, 'style="color:#2F96B4; font-weight:normal;"');
$pagesMid = $pageClass->linkSigAnt($mensajeAnt, $mensajeSig, $ruta, $idGet, $simbolo, 'style="color:#2F96B4; font-weight:normal;"');
//$paginas = $pageClass->creaPaginaTableTd($ruta, $idGet, $simbolo, 'class="active"', 'style="color:#2F96B4; font-weight:normal;"');
$paginas = $pageClass->creaPaginaTableLi($ruta, $idGet, $simbolo, 'class="active"', 'style="color:#2F96B4; font-weight:normal;"');
// ************************* FIN PAGINACION ***********************

$selects = creaArraySelects($arraySelects, $arrayNames, $arrayInfo, $arrayIds, $resPost, $arrayIni, $arrayIniMsj);

?>