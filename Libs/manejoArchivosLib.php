<?php
function leerDirectorio($ruta, $carpId) {
	
	$cuenta = 0;	
	$decimales = 2; 
	$main = new mainClass();
	$fileClass = new fileClass('');
	
	if(is_dir($ruta)) {
	
		if($read = opendir($ruta)) {	
			
			while (false !== ($file = readdir($read))) {
			
				if($file != '.' && $file != '..') {
				
					$type = filetype($ruta.$file);					
					
					if($type == 'dir') {					
						
						$archivo .= $file.'/';
						
						if(isset($carpId[$file])) {
						
							$result[$cuenta]['idUser'] = $carpId[$file];
						}
						$result[$cuenta]['tipo'] = $type;
						
					} else {
						
						$posDot = strrpos($file, '.');						
						$extension = strtolower(substr($file, $posDot + 1));
						$result[$cuenta]['tipo'] = $fileClass->tipoArchivo($extension);
					}
					
					$peso = filesize($ruta.$file);
					$realSize = $fileClass->calculaPesoRealArchivo($peso, $decimales);					
					$result[$cuenta]['nombre'] = $file;					
					$result[$cuenta]['archivo'] = $file;
					$result[$cuenta]['peso'] = $realSize;
					//sort($result[$cuenta]['nombre']);
					$cuenta++;					
				}
			}
		}		
		closedir($read);
	}
	$fileClass->fileDestructor();
	return $result;
}

function iconosTipo($fileList, $iconos) {

	if(is_array($fileList)) {
	
		$result = $fileList;
		
		foreach($fileList as $key=>$val) {
			
			$result[$key]['icon'] = $iconos[$val['tipo']];
		}
	}
	return $result;	
}
?>