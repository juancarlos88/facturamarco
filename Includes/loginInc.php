<?php
function logicaArchivo($arrayPost) {
	
	$post = $arrayPost;
	$errores = 0;
	
	$usuario = getAccesoCond('*', $post['user'], $post['pass']);
	
	if(is_array($usuario)) {
		
		if($usuario[0]['bactivo'] == 'activo') {
			
			$_SESSION['userdata']['id'] = $usuario[0]['idacceso'];
			$_SESSION['userdata']['nombre'] = $usuario[0]['nombre'];
			$_SESSION['userdata']['activo'] = $usuario[0]['bactivo'];
			$_SESSION['userdata']['tipo'] = $usuario[0]['idtipoacceso'];
			// $_SESSION['userdata']['nombre'] = $usuario[0]['nombre'];
			
		} else {
		
			$errores++;
			$msjErrores['errorUserPass'] = 'El usuario que ha ingresado no existe.';
		}
		
	} else {
	
		$errores++;
		$msjErrores['errorUserPass'] = 'El usuario y/o contraseña que se han introducido son incorrectos.';
	}
	 
	$result['post'] = $post; 
	$result['msjErrores']  = $msjErrores;
	$result['numErrores'] = $errores;
	return $result;
}

function ordenaDatos($colsDb, $post) {
	
	foreach($colsDb as $key=>$val) {
	
		$result[$val] = $post[$key];
	}	
	return $result;
}

/** 
 * ********************************************************************************************
 * 							PROCESAMIENTO.
 * ********************************************************************************************
 */
$htmlClass = new htmlClass();	
$propertyMensaje = 'style="padding: 5px; list-style: none; font-weight: bold;"';
$nomFormhid = 'entrar';
if($_POST) {

	if($_POST['formhid'] == $nomFormhid) {
		
		if(isset($_POST['ingresar'])) {
			
			$tablaDb = '';
			$arrayPost = $_POST; 
			$arrayOrder = array('user', 'pass');
			$coslDb = array('user'=>'usuarioacceso', 'pass'=>'passacceso');
			$arrayObligatorios = array('user', 'pass');				
			$msjError = array('user'=>'Debe escribir su usuario.', 
				'pass'=>'Debe escribir su contraseña.');
			$charsPeligrosos = array('\\'=>'', '"'=>'', "'"=>'', '<'=>'', '>'=>'', '%'=>'', '?'=>'');
			
			$resultValida = validaCampos($arrayPost, $arrayObligatorios, $msjError, $arrayOrder, 
				$charsPeligrosos);
			$numErrores = $resultValida['numErrores'];
			$resPost = $resultValida['arrayLimpio'];
			$msjErrores = $resultValida['msjErrores'];

			if($numErrores==0) {
			
				$logicaInfo = logicaArchivo($resPost);
				$msjErrores = $logicaInfo['msjErrores'];
				$numErrores = $logicaInfo['numErrores'];
				// $resPost = $logicaInfo['post'];
				
				if($numErrores == 0) {								
				
					header('Location: desplegadorClientes.php');
					exit();					
					
				} else {
				
					$mensaje = $htmlClass->construyeMensajesLista($msjErrores, $propertyMensaje);
				}
				
			} else {
				
				$mensaje = $htmlClass->construyeMensajesLista($msjErrores, $propertyMensaje);
			}
		} 
	}	
} else {

	session_unset();
	session_destroy();
}
?>