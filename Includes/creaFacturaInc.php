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

function ordenaDatos($colsDb, $post, $beditar) {

    if (is_array($colsDb) && is_array($post) && !empty($post)) {

        foreach ($colsDb as $key => $val) {

            $result[$val] = $post[$key];
        }        
        $result['fecha_altaf'] = fecha_mysql($post['fecha']);
        
        if ($beditar != 1) {
            $md5Codigo = md5($post['fact'] . date('YmdHis',time()) . fecha_mysql($post['fecha']));
            $result['code_factura'] = $md5Codigo;
        }
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
$clientesInfo = infoClientes('id_cliente, razon_social', '',"bactivo='activo'");
$clientes = $mainClass->creaArrayPosiciones($clientesInfo, 'id_cliente', 'razon_social');
$arraySelects = array('clientes');
$arrayNames = array('clientes' => 'cli');
$arrayOptGroup = array('clientes'=>'Elige un cliente.');
$arrayInfo = array('clientes' => $clientes);
$arrayIds = array('clientes' => 'id="cli" style="width: 51%;"');
$arrayIni = array('clientes' => 0);
$arrayMsj = array('clientes' => ' - ');
// ************************** FIN CONFIG ****************************

$colsDb = array('cli'=>'id_cliente', 'fact'=>'num_factura', 'formapago'=>'forma_pago');

if ($_GET) {
    // PROCESAMIENTO GET.
    $get = $_GET;
    $getForm = construyeGet($get);
    
    
    if ($get['bedit'] == 1) {
        
        $beditar = 1;
        $facturas = info_facturas('*', "code_factura='".$get['fc']."'");
        $idFactura = $facturas[0]['id_factura'];       
        $resPost = ordenaDatos(array_flip($colsDb), $facturas[0], 1);
        $resPost['fecha'] = date('d-m-Y', strtotime($facturas[0]['fecha_altaf']));
        $condicion = 'id_factura='.$idFactura;
        $msjRegresar = '<a class="btn" href="crea_concepto.php?fc='.$get['fc'].'&bedit=1">Regresar.</a>';
    }   
    
    
    if($get['bmsj'] == 2) {
        
        $msjErrores[0] = 'Se ha actualizado la factura correctamente.';
        $style = 'style="color: green;"';
        $msjRegresar = '<a class="btn" href="crea_concepto.php?fc='.$get['fc'].'&bedit=1">Regresar.</a>';
    }
} 

if ($_POST['formhid'] == $nomFormhid) {

    if (isset($_POST[$nomSubmit])) {

        $tablaDb = 'factura';
        $arrayPost = $_POST;
// echo '<br/> -> POST -> '; print_r($_POST);
        $arrayOrder = array('fact', 'cli', 'fecha', 'formapago');
        $arrayObligatorios = array('fact', 'cli','fecha', 'formapago');
        $msjError = array('fact'=>'Debe escribir un número de factura',
            'cli'=>'Debe elegir un cliente.',
            'fecha'=>'Debes elegir una fecha.',
            'formapago' => 'Debes escribir la forma de pago.');
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

                $datos = ordenaDatos($colsDb, $logicaInfo['post'], $beditar);
                
// echo '<br/> -----4----- '; print_r($datos);  // break;

                if ($beditar == 1) {

                    updateQueryCondicion($datos, $tablaDb, $condicion);                    
                    $ruta = $_SERVER['PHP_SELF'] . '?fc='.$get['fc'].'&bedit=1&bmsj=2';
                    
                } else {                    

                    $idConsulta = insertarQueryCondicion($datos, $tablaDb);
                    $ruta = 'crea_concepto.php?fc='.$datos['code_factura'];
                }
                
                header('Location: '.$ruta);
                
            }
        }        
    } else if ($_POST['limpiar']) {

        unset($_POST);
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
}

$selects = creaArraySelects($arraySelects, $arrayNames, $arrayInfo, $arrayIds, 
            $resPost, $arrayIni, $arrayMsj, $arrayOptGroup);
$mainClass->mainClassDest();
$htmlErrores = $htmlClass->construyeMensajesLista($msjErrores, $style); // MENSAJES
?>