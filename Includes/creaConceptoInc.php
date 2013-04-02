<?php
function logicaArchivo($arrayPost) {

    $post = $arrayPost;
    $errores = 0;
    $msjErrores = array();
    
    // LOGICA DE LOS DATOS. 
    
    $result['post'] = $post;
    $result['numErrores'] = $errores;
    $result['msjErrores'] = $msjErrores; 
    return $result;
}

function ordenaDatos($colsDb, $post, $idFactura) {

    if (is_array($colsDb) && is_array($post) && !empty($post)) {

        foreach ($colsDb as $key => $val) {

            $result[$val] = $post[$key];
        }  
        $result['id_factura'] = $idFactura;
    }      
    return $result;
}

/**
 * ********************************************************************************************
 * 							PROCESAMIENTO.
 * ********************************************************************************************
 */
// ============== 		REVISIÓN DE PERMISOS POR TIPO USUARIO 		==============
/*$rutaIndex = 'index.php';
$rutaDesplegador = 'desplegadorClientes.php';
$arrayPermisos = array(1, 2, 3);
$activoVar = 'activo';
$tipo = $_SESSION['userdata']['tipo'];
revisaSession($_SESSION, 'userdata', $rutaIndex);
revisaLogin($_SESSION['userdata'], 'activo', $rutaIndex, $activoVar);
revisaTipoPermiso($arrayPermisos, $rutaDesplegador, $tipo);*/
// ============== 		FIN DE REVISIÓN 		==============

$htmlClass = new htmlClass();
$mainClass = new mainClass();

$nomFormhid = 'creaFactura'; // FIJO PARA EL FORMULARIO
$nomSubmit = 'enviar'; // FIJO PARA EL FORMULARIO
$style = 'style="color: red;"';

// $idAcceso = $_SESSION['userdata']['id'];

// *********************** CONFIG SELECTS ***************************
//$clientesInfo = infoClientes('id_cliente, razon_social', '','1');
//$clientes = $mainClass->creaArrayPosiciones($clientesInfo, 'id_cliente', 'razon_social');
$arraySelects = array();
$arrayNames = array();
$arrayOptGroup = array();
$arrayInfo = array();
$arrayIds = array();
$arrayIni = array();
$arrayMsj = array();
// ************************** FIN CONFIG ****************************

$colsDb = array('quantity'=>'cantidad', 'price'=>'precio_unitario',
    'desc'=>'descripcion', 'unidad' => 'unidad');

if ($_GET) {
    // PROCESAMIENTO GET.
    $get = $_GET;
    $getForm = construyeGet($get);
    if($get['fc'] != '') {    
        
        $code = $get['fc'];
        $cols = 'cli.razon_social, fac.id_factura';
        $inner = 'cli JOIN factura fac ON fac.id_cliente=cli.id_cliente';
        $condicion = "fac.code_factura='" . $code . "'";
        $infoCliente = infoClientes($cols, $inner, $condicion);
        
        if(is_array($infoCliente)) {
            
            $bguardar = 1;
            $razonSocial = '('.$infoCliente[0]['razon_social'].')';
            $idFactura = $infoCliente[0]['id_factura'];
            
        } else {
            
            $msjErrores[0] = 'No existe el cliente.';
        }
    }
    
    if($get['bmsj'] == 1) {
        
        $msjErrores[0] = 'Se ha agregado el concepto correctamente.';
        $style = 'style="color: green;"';
    }
    
    if($get['bmsj'] == 3) {
        
        $msjErrores[0] = 'Se ha actualizado el concepto correctamente.';
        $style = 'style="color: green;"';
    }
    
    if ($get['bedit'] == 1 AND $get['cc'] != '') {
        
        $beditar = 1;
        $concepto = info_conceptos('*', 'id_concepto='.$get['cc']);
        $idFactura = $concepto[0]['id_factura'];
        $idConcepto = $get['cc'];
        $resPost = ordenaDatos(array_flip($colsDb), $concepto[0], $idFactura);
    }
}

if ($_POST['formhid'] == $nomFormhid && $bguardar == 1) {

    if (isset($_POST[$nomSubmit])) {

        $tablaDb = 'concepto';
        $arrayPost = $_POST;
// echo '<br/> -> POST -> '; print_r($_POST);
        $arrayOrder = array('quantity', 'unidad', 'price', 'desc');
        $arrayObligatorios = array('quantity', 'price');
        $msjError = array('quantity'=>'Debes escribir la cantidad.',
            'price'=>'Debes escribir el precio.');
        $charsPeligrosos = array('\\' => '');

        $resultValida = validaCampos($arrayPost, $arrayObligatorios, $msjError, $arrayOrder, $charsPeligrosos);
        $numErrores = $resultValida['numErrores'];
        $resPost = $resultValida['arrayLimpio'];
        $msjErrores = $resultValida['msjErrores'];
// echo '<br/> -----2----- '; print_r($resultValida); 
        if ($numErrores == 0) {

            $logicaInfo = logicaArchivo($resPost);
            $resPost = $logicaInfo['post'];
            $numErrores = $logicaInfo['numErrores'];
            $msjErrores = $logicaInfo['msjErrores'];
// echo '<br/> -----3----- '; print_r($logicaInfo); 			
            if ($logicaInfo['numErrores'] == 0) {

                $datos = ordenaDatos($colsDb, $resPost, $idFactura);                
//echo '<br/> -----4----- '; print_r($datos);     break;           

                if ($beditar == 1) {
                    
                    $condicion = 'id_concepto='.$idConcepto.' AND id_factura='.$idFactura;
                    updateQueryCondicion($datos, $tablaDb, $condicion);
                    $ruta = $_SERVER['PHP_SELF'] . '?fc='.$code.'&bmsj=3';
                    
                } else {                    

                    $idConsulta = insertarQueryCondicion($datos, $tablaDb);
                    $ruta = $_SERVER['PHP_SELF'].'?fc='.$code.'&bmsj=1';
                }                
                header('Location: '.$ruta);                
            }
        }        
    } else if ($_POST['limpiar']) {

        unset($_POST);
        $ruta = $_SERVER['PHP_SELF'] . '?fc=' . $code;
        header('Location: ' . $ruta);
        
    } else if ($_POST['verpdf']) {
        
        //header('Location: facturaPDF.php?fc='.$code);
    }
}

$selects = creaArraySelects($arraySelects, $arrayNames, $arrayInfo, $arrayIds, 
            $resPost, $arrayIni, $arrayMsj, $arrayOptGroup);
$mainClass->mainClassDest();
$htmlErrores = $htmlClass->construyeMensajesLista($msjErrores, $style); // MENSAJES
?>