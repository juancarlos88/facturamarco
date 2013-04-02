<?php

function logicaArchivo($arrayPost) {

    $post = $arrayPost;
    $errores = 0;
    $msjErrores = array();
        
    
    // LOGICA DE LOS DATOS.     
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', trim($post['correo']))) {
        
        $msjErrores['correo'] = 'El correo que ha ingresado es inválido.';
        $errores++;
    }
    
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', trim($post['correosalida']))) {
        
        $msjErrores['correosalida'] = 'El correo de salida que ha ingresado es inválido.';
        $errores++;
    }
    
    $result['post'] = $post;
    $result['numErrores'] = $errores;
    $result['msjErrores'] = $msjErrores;
    return $result;
}

function ordenaDatos($colsDb, $post) {

    if (is_array($colsDb) && is_array($post) && !empty($post)) {

        foreach ($colsDb as $key => $val) {

            $result[$val] = $post[$key];
        }        
        $result['fecha_alta'] = date('Y-m-d', time());
    }  
    
    return $result;
}

function enviarCorreoCli($resPost, $fcode, $rutaProyecto) {
    
    if (is_array($resPost)) {
        
        $mensaje = '<div style="width: 95%; margin: 10px auto; border:0px solid black; padding: 3px;">'.$resPost['comentario'];
        $mensaje .= '<br><b style="">Hacer 
            <a href="'.$rutaProyecto.'facturaPDF.php?fc='.$fcode.'" style="color:#227CCC; text-decoration:underline;" target="_blank">
                clic aquí
            </a> para descargar la factura</b>
            <br><br>
            <a href="'.$rutaProyecto.'facturaPDF.php?fc='.$fcode.'" target="_blank" title="Descargar PDF">
                <img src="' . $rutaProyecto . '/Imagenes/icono-pdf.png" alt="Descargar PDF" title="Descargar PDF">
                <br>
                <span style="color:#227CCC; text-decoration:underline;">Descargar PDF</span>
            </a>            
            </div>'; //echo $mensaje; break;
        
        //$from = 'mduran@estrategiasdigitales.com.mx'; // DE (CORREO)
        $from = $resPost['correosalida']; // DE (CORREO)
        $fromName = utf8_decode($resPost['nomsalida']); // DE (NOMBRE USUARIO CORROE)
        $to = $resPost['correo']; // CORREO
        $toName = utf8_decode($resPost['nombre']); // NOMBRE DEL USUARIO DEL CORREO
        $subject = utf8_decode($resPost['asunto']); // TITULO DEL CORREO
        $text = ''; // 
        $html = utf8_decode($mensaje); // MENSAJE HTML
        $attmFiles = ''; // ARCHIVOS ADJUNTOS 
        $replyto = ''; // EMAIL (RESPONDER A)
        $replyname = ''; // NOMBRE (RESPONDER A)

        SendMail($from, $fromName, // DE
                $to, $toName, // PARA
                $subject, $text, $html, $attmFiles, 
                $replyto, $replyname);
    }
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

$nomFormhid = 'enviarcorreo'; // FIJO PARA EL FORMULARIO
$nomSubmit = 'enviar'; // FIJO PARA EL FORMULARIO
$style = 'style="color: red; font-size:10pt;"';

 
// $idAcceso = $_SESSION['userdata']['id'];

// *********************** CONFIG SELECTS ***************************
$arraySelects = array();
$arrayNames = array();
$arrayOptGroup = array();
$arrayInfo = array();
$arrayIds = array();
$arrayIni = array();
$arrayMsj = array();
// ************************** FIN CONFIG ****************************

$colsDb = array();

if ($_GET) {
    // PROCESAMIENTO GET.
    $get = $_GET;
    $getForm = construyeGet($get);
    
    if($get['bmsj'] != '') {
        
        if($get['bmsj'] == 1) {
            
            $style = 'style="color: green; font-size:10pt;"';
            $msjErrores[0] = 'El correo se ha enviado al cliente.';
            
        } else if($get['bmsj'] == 2) {
            
            $style = 'style="color: green;"';
            $msjErrores[0] = 'Se ha actualizado correctamente el cliente.';
        }
    }   
    
    if ($get['fc'] != '') { 
        
        $fcode = $get['fc'];
    }
} 

if ($_POST['formhid'] == $nomFormhid) {

    if (isset($_POST[$nomSubmit])) {

        $tablaDb = 'cliente';
        $arrayPost = $_POST;
        $arrayOrder = array('asunto', 'correosalida', 'nomsalida', 'nombre', 'correo', 'comentario');
        $arrayObligatorios = array('asunto', 'nomsalida', 'correosalida', 'nombre', 'correo');
        $msjError = array('asunto'=>'Debe escribir el asunto.',
            'nomsalida'=>'Debe escribir el nombre de quién envia la factura.',
            'correosalida'=>'Debe escribir el correo de quién envia la factura.',
            'nombre'=>'Debe escribir el nombre.',
            'correo'=>'Debe escribir el email para enviar.');
        $charsPeligrosos = array('\\' => '');

        $resultValida = validaCampos($arrayPost, $arrayObligatorios, $msjError, $arrayOrder, $charsPeligrosos);
        $numErrores = $resultValida['numErrores'];
        $resPost = $resultValida['arrayLimpio'];
        $msjErrores = $resultValida['msjErrores'];

        if ($numErrores == 0) {

            $logicaInfo = logicaArchivo($resPost);
            $resPost = $logicaInfo['post'];
            $numErrores = $logicaInfo['numErrores'];
            $msjErrores = $logicaInfo['msjErrores'];
			
            if ($logicaInfo['numErrores'] == 0) {

                $datos = ordenaDatos($colsDb, $logicaInfo['post']);               

                if ($beditar == 1) {

                    //updateQueryCondicion($datos, $tablaDb, $condicion);
                    //$ruta = $_SERVER['PHP_SELF'] . '?bmsj=2';
                    
                } else {                    

                    // ENVIAR CORREO
                    enviarCorreoCli($resPost, $fcode, $rutaProyecto);
                    $idConsulta = insertarQueryCondicion($datos, $tablaDb);
                    $ruta = $_SERVER['PHP_SELF'] . '?fc='.$fcode.'&bmsj=1';
                }
                
                header('Location: '.$ruta);
                
            }
        } 
    } else if ($_POST['limpiar']) {

        unset($_POST);
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
} else {
    
    $resPost['asunto'] = 'Envio de factura.';
}

$selects = creaArraySelects($arraySelects, $arrayNames, $arrayInfo, $arrayIds, 
            $resPost, $arrayIni, $arrayMsj, $arrayOptGroup);
$mainClass->mainClassDest();
$htmlErrores = $htmlClass->construyeMensajesLista($msjErrores, $style); // MENSAJES
?>