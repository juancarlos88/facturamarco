<?php
function revisaLogin($session, $posicion, $ruta) {

	if(!isset($session[$posicion]) && $session[$posicion] != $valor) {
		header('Location: '.$ruta);
		exit();
	}
}
function revisaTipoPermiso($arrayPermisos, $ruta, $sessionTipo) {

	if(!in_array($sessionTipo, $arrayPermisos)) {
		header('Location: '.$ruta);
		exit(); 		
	} 
}

function revisaSession($session, $posicion, $ruta) {

	if(!isset($session[$posicion])) {
		
		header('Location: '.$ruta);
		exit(); 		
	}
}
?>