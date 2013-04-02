<?php
function arrayEstados($mxEstados) {

    if (is_array($mxEstados)) {

        foreach ($mxEstados as $key => $val) {

            $result[$val['label']] = $val['label'];
        }
    }
    return $result;
}

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

function ordenaDatos($colsDb, $post,$extra = 1) {

    if (is_array($colsDb) && is_array($post) && !empty($post)) {

        foreach ($colsDb as $key => $val) {

            $result[$val] = $post[$key];
        }
		if($extra == 1){
        $result['fecha_alta'] = date('Y-m-d', time());
		}else{
		$result['nombre'] = $post['name'];
		$result['apellido'] = $post['name'];
		$result['passwd'] = $post['rfc'];
		$result['falta'] = date('Y-m-d', time());
		$result['email'] = 'sin@email.com';
		$result['nivel'] = 2;
		$result['status'] = 1;
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

$nomFormhid = 'crearCliente'; // FIJO PARA EL FORMULARIO
$nomSubmit = 'enviar'; // FIJO PARA EL FORMULARIO
$style = 'style="color: red;"';

$estados = arrayEstados($mxEstados);

// $idAcceso = $_SESSION['userdata']['id'];

// *********************** CONFIG SELECTS ***************************
$arraySelects = array('estados');
$arrayNames = array('estados' => 'states');
$arrayOptGroup = array('estados'=>'Elige un estado.');
$arrayInfo = array('estados' => $estados);
$arrayIds = array('estados' => 'id="states" style="width: 91%;"');
$arrayIni = array('estados' => 0);
$arrayMsj = array('estados' => ' - ');
// ************************** FIN CONFIG ****************************

$colsDb = array('name'=>'razon_social', 'rfc'=>'rfc_cliente', 'street'=>'calle', 
    'ext'=>'num_ext', 'int'=>'num_int', 'col'=>'colonia', 'cp'=>'codigo_postal', 
    'del'=>'delegacion', 'states'=>'estado', 'country'=>'pais');
$colsDb1 = array('name'=>'empresa', 'rfc'=>'user');

if ($_GET) {
    // PROCESAMIENTO GET.
		
    $get = $_GET;
    $getForm = construyeGet($get);
    
	if(!empty($get['bedit']))
	{
        $cols = '*';
        $inner = '';
        $condicion = 'id_cliente = '.$get['fc'];
        $clientes = infoClientes($cols, $inner, $condicion);
        $arrayPost = ordenaDatos(array_flip($colsDb),$clientes[0],3);
        $beditar = 1; // echo ''.$beditar;
	}
	
    if($get['bmsj'] != '') {
        
        if($get['bmsj'] == 1) {
            
            $style = 'style="color: green;"';
            $msjErrores[0] = 'Se ha dado de alta correctamente el cliente.';
            
        } else if($get['bmsj'] == 2) {
            
            $style = 'style="color: green;"';
            $msjErrores[0] = 'Se ha actualizado correctamente el cliente.';
        }
    }    
} 

if ($_POST['formhid'] == $nomFormhid) {

    if (isset($_POST[$nomSubmit])) {

        $tablaDb = 'cliente';
		$tablaDb1 = 'usuarios';
        $arrayPost = $_POST;
// echo '<br/> -> POST -> '; print_r($_POST);
        $arrayOrder = array('name', 'rfc', 'street', 'ext', 'int', 'col', 'cp', 
            'country', 'states', 'del');
        $arrayObligatorios = array('name', 'rfc', 'street', 'col', 'cp', 
            'country', 'states', 'del');
        $msjError = array('name'=>'Debe escribir la razón social',
            'rfc'=>'Debe escribir el R.F.C.',
            'street'=>'Debe escribir la calle.',
            'col'=>'Debe escribir la colonia.',
            'cp'=>'Debe escribir el código postal.',
            'country'=>'Debe escrbir el país.', 
            'states'=>'Debe elegir un estado',
            'del'=>'Debe escribir una delegacion');
        $charsPeligrosos = array('\\' => '', '<'=>'', '>'=>'');

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

                $datos = ordenaDatos($colsDb, $logicaInfo['post']);
				//$datos1 = ordenaDatos($colsDb1, $logicaInfo['post'],2);
                
 // echo '<br/> -----4----- '; print_r($datos);     break;           

                if ($beditar == 1) {

                    updateQueryCondicion($datos, $tablaDb, $condicion);
                    $ruta = $_SERVER['PHP_SELF'] . '?bmsj=2';
                    
                } else {                    

                    $idConsulta = insertarQueryCondicion($datos, $tablaDb);
					//$idConsulta = insertarQueryCondicion($datos1, $tablaDb1);
                    $ruta = $_SERVER['PHP_SELF'] . '?bmsj=1';
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
            $arrayPost, $arrayIni, $arrayMsj, $arrayOptGroup);
$mainClass->mainClassDest();
$htmlErrores = $htmlClass->construyeMensajesLista($msjErrores, $style); // MENSAJES
?>