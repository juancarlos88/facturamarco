<?php
session_start(); // INICIO DE SESIÓN.

/**
 *	************************************************************************
 * 					CLASES
 *	************************************************************************
 */
include './Clases/dbClass.php'; // CLASE PARA LA BASE DE DATOS.
include './Clases/mainClass.php'; // FUNCIONES GENERALES.
include './Clases/htmlClass.php'; // FUNCIONES GENERALES.
include './Clases/fileClass.php'; // FUNCIONES GENERALES.
include './Clases/pagingClass.php'; // FUNCIONES GENERALES.
include './Clases/funciones.php'; // FUNCIONES GENERALES.

/**
 *	************************************************************************
 * 					FUNCTIONS
 *	************************************************************************
 */
 include './Functions/busquedasFunc.php';
 include './Functions/loginFunc.php';  

/**
 *	************************************************************************
 * 					LIBS
 *	************************************************************************
 */
 include './Libs/formularioLib.php'; // FUNCIONES GENERALES
 include './Libs/manejoArchivosLib.php'; 
 include './Libs/monedaLetraLib.php';
 
/**
 *	********************************************************************************************
 * 										ARREGLOS CONFIGURACION
 *	********************************************************************************************
 */
$mesesLetra = array('01'=>'Enero', '02'=>'Febrero', '03'=>'Marzo', '04'=>'Abril' ,'05'=>'Mayo', 
	'06'=>'Junio', '07'=>'Julio', '08'=>'Agosto', '09'=>'Septiembre', '10'=>'Octubre', 
	'11'=>'Noviembre', '12'=>'Diciembre');
// ESTADOS DE LA REPUBLICA.
$mxEstados = array(         
	array('id' => 'MEX-AGS','value' => 'AGS', 'label' => 'Aguascalientes'),
	array('id' => 'MEX-BCN','value' => 'BCN', 'label' => 'Baja California Norte'),
	array('id' => 'MEX-BCS','value' => 'BCS', 'label' => 'Baja California Sur'),
	array('id' => 'MEX-CAM','value' => 'CAM', 'label' => 'Campeche'),
	array('id' => 'MEX-CHIS','value' => 'CHIS', 'label' => 'Chiapas'),
	array('id' => 'MEX-CHIH','value' => 'CHIH', 'label' => 'Chihuahua'),
	array('id' => 'MEX-COAH','value' => 'COAH', 'label' => 'Coahuila'),
	array('id' => 'MEX-COL','value' => 'COL', 'label' => 'Colima'),
	array('id' => 'MEX-DF','value' => 'DF', 'label' => 'Distrito Federal'),
	array('id' => 'MEX-DGO','value' => 'DGO', 'label' => 'Durango'),
	array('id' => 'MEX-GTO','value' => 'GTO', 'label' => 'Guanajuato'),
	array('id' => 'MEX-GRO','value' => 'GRO', 'label' => 'Guerrero'),
	array('id' => 'MEX-HGO','value' => 'HGO', 'label' => 'Hidalgo'),
	array('id' => 'MEX-JAL','value' => 'JAL', 'label' => 'Jalisco'),
	array('id' => 'MEX-EDM','value' => 'EDM', 'label' => 'Estado de México'),
	array('id' => 'MEX-MICH','value' => 'MICH', 'label' => 'Michoacán'),
	array('id' => 'MEX-MOR','value' => 'MOR', 'label' => 'Morelos'),
	array('id' => 'MEX-NAY','value' => 'NAY', 'label' => 'Nayarit'),
	array('id' => 'MEX-NL','value' => 'NL', 'label' => 'Nuevo León'),
	array('id' => 'MEX-OAX','value' => 'OAX', 'label' => 'Oaxaca'),
	array('id' => 'MEX-PUE','value' => 'PUE', 'label' => 'Puebla'),
	array('id' => 'MEX-QRO','value' => 'QRO', 'label' => 'Querétaro'),
	array('id' => 'MEX-QROO','value' => 'QROO', 'label' => 'Quintana Roo'),
	array('id' => 'MEX-SLP','value' => 'SLP', 'label' => 'San Luis Potosí'),
	array('id' => 'MEX-SIN','value' => 'SIN', 'label' => 'Sinaloa'),
	array('id' => 'MEX-SON','value' => 'SON', 'label' => 'Sonora'),
	array('id' => 'MEX-TAB','value' => 'TAB', 'label' => 'Tabasco'),
	array('id' => 'MEX-TAMPS','value' => 'TAMPS', 'label' => 'Tamaulipas'),
	array('id' => 'MEX-TLAX','value' => 'TLAX', 'label' => 'Tlaxcala'),
	array('id' => 'MEX-VER','value' => 'VER', 'label' => 'Veracruz'),
	array('id' => 'MEX-YUC','value' => 'YUC', 'label' => 'Yucatán'),
	array('id' => 'MEX-ZAC','value' => 'ZAC', 'label' => 'Zacatecas'),
);

$iva = 0.16;
	
/*$arrayRemp = array('À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'à'=>'a', 
		'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 
		'Ö'=>'O', 'Ø'=>'O', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'0', 'È'=>'E',
		'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'Ç'=>'C', 'ç'=>'c',
		'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'Ù'=>'U', 
		'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ÿ'=>'y', 'Ñ'=>'N', 
		'ñ'=>'n');*/
$arrayRemp  = array('/(À|Á|Â|Ã|Ä|Å)/'=>'A', '/(à|á|â|ã|ä|å)/'=>'a', '/(Ò|Ó|Ô|Õ|Ö|Ø)/'=>'O', 
	'/(ò|ó|ô|õ|ö|ø)/'=>'o', '/(È|É|Ê|Ë)/'=>'E', '/(è|é|ê|ë)/'=>'e', '/(Ç)/'=>'C', '/(ç)/'=>'c', 
	'/(Ì|Í|Î|Ï)/'=>'I', '/(ì|í|î|ï)/'=>'i', '/(Ù|Ú|Û|Ü)/'=>'U', '/(ù|ú|û|ü)/'=>'u', 
	'/(ÿ)/'=>'y', '/(Ñ)/'=>'N', '/(ñ)/'=>'n');
	
$arrayRempSQL = array('/(A|À|Á|Â|Ã|Ä|Å)/'=>'(A|À|Á|Â|Ã|Ä|Å)', '/(a|à|á|â|ã|ä|å)/'=>'(a|à|á|â|ã|ä|å)', 
	'/(O|Ò|Ó|Ô|Õ|Ö|Ø)/'=>'(O|Ò|Ó|Ô|Õ|Ö|Ø)', '/(o|ò|ó|ô|õ|ö|ø)/'=>'(o|ò|ó|ô|õ|ö|ø)', 
	'/(E|È|É|Ê|Ë)/'=>'(E|È|É|Ê|Ë)', '/(e|è|é|ê|ë)/'=>'(e|è|é|ê|ë)', '/(Ç|C)/'=>'(Ç|C)', '/(ç|c)/'=>'(ç|c)', 
	'/(I|Ì|Í|Î|Ï)/'=>'(I|Ì|Í|Î|Ï)', '/(i|ì|í|î|ï)/'=>'(i|ì|í|î|ï)', '/(U|Ù|Ú|Û|Ü)/'=>'(U|Ù|Ú|Û|Ü)', 
	'/(u|ù|ú|û|ü)/'=>'(u|ù|ú|û|ü)', '/(ÿ|y)/'=>'(ÿ|y)', '/(Ñ|N)/'=>'(Ñ|N)', '/(ñ|n)/'=>'(ñ|n)');
	
$arrayPaises = array('Afganistán' , 'Albania' , 'Alemania' , 'Andorra' , 'Angola' , 
	'Antigua y Barbuda' , 'Antillas Holandesas' , 'Arabia Saudí' , 'Argelia' , 'Argentina' , 
	'Armenia' , 'Aruba' , 'Australia' , 'Austria' , 'Azerbaiyán' , 'Bahamas' , 'Bahrein' , 
	'Bangladesh' , 'Barbados' , 'Bélgica' , 'Belice' , 'Benín' , 'Bermudas' , 'Bielorrusia' , 
	'Bolivia' , 'Botswana' , 'Bosnia' , 'Brasil' , 'Brunei' , 'Bulgaria' , 'BurkinaFaso' , 
	'Burundi' , 'Bután' , 'Cabo Verde' , 'Camboya' , 'Camerún' , 'Canadá' , 'Chad' , 'Chile' , 
	'China' , 'Chipre' , 'Colombia' , 'Comoras' , 'Congo' , 'Corea del Norte' , 'Corea del Sur' , 
	'Costa de Marfil' , 'Costa Rica' , 'Croacia' , 'Cuba' , 'Dinamarca' , 'Dominica' , 'Dubai' , 
	'Ecuador' , 'Egipto' , 'El Salvador' , 'Emiratos Árabes Unidos' , 'Eritrea' , 'Eslovaquia' , 
	'Eslovenia' , 'España' , 'Estados Unidos de América' , 'Estonia' , 'Etiopía' , 'Fiyi' , 
	'Filipinas' , 'Finlandia' , 'Francia' , 'Gabón' , 'Gambia' , 'Georgia' , 'Ghana' , 'Grecia' , 
	'Guam' , 'Guatemala' , 'Guayana Francesa' , 'Guinea-Bissau' , 'Guinea Ecuatorial' , 'Guinea' , 
	'Guyana' , 'Granada' , 'Haití' , 'Honduras' , 'HongKong' , 'Hungría' , 'Holanda' , 'India' , 
	'Indonesia' , 'Irak' , 'Irán' , 'Irlanda' , 'Islandia' , 'Islas Caimán' , 'Islas Marshall' , 
	'Islas Pitcairn' , 'Islas Salomón' , 'Israel' , 'Italia' , 'Jamaica' , 'Japón' , 'Jordania' , 
	'Kazajstán' , 'Kenia' , 'Kirguistán' , 'Kiribati' , 'Kósovo' , 'Kuwait' , 'Laos' , 'Lesotho' , 
	'Letonia' , 'Líbano' , 'Liberia' , 'Libia' , 'Liechtenstein' , 'Lituania' , 'Luxemburgo' , 
	'Macedonia' , 'Madagascar' , 'Malasia' , 'Malawi' , 'Maldivas' , 'Malí' , 'Malta' , 
	'Marianas del Norte' , 'Marruecos' , 'Mauricio' , 'Mauritania' , 'México' , 'Micronesia' , 
	'Mónaco' , 'Moldavia' , 'Mongolia' , 'Montenegro' , 'Mozambique' , 'Myanmar' , 'Namibia' , 
	'Nauru' , 'Nepal' , 'Nicaragua' , 'Níger' , 'Nigeria' , 'Noruega' , 'NuevaZelanda' , 'Omán' , 
	'OrdendeMalta' , 'Países Bajos' , 'Pakistán' , 'Palestina' , 'Palau' , 'Panamá' , 
	'Papúa Nueva Guinea' , 'Paraguay' , 'Perú' , 'Polonia' , 'Portugal' , 'Puerto Rico' , 'Qatar' , 
	'Reino Unido' , 'República Centro africana' , 'República Checa' , 'República del Congo' , 
	'República Democrática del Congo' , 'República Dominicana' , 'Ruanda' , 'Rumania' , 'Rusia' , 
	'Sáhara Occidental' , 'SaintKitts-Nevis' , 'Samoa Americana' , 'Samoa' , 'San Marino' , 
	'Santa Lucía' , 'Santo Tomé y Príncipe' , 'San Vicente y las Granadinas' , 'Senegal' , 
	'Serbia' , 'Seychelles' , 'Sierra Leona' , 'Singapur' , 'Siria' , 'Somalia' , 'SriLanka' , 
	'Sudáfrica' , 'Sudán' , 'Suecia' , 'Suiza' , 'Suazilandia' , 'Tailandia' , 'Taiwán' , 
	'Tanzania' , 'Tayikistán' , 'Tíbet' , 'TimorOriental' , 'Togo' , 'Tonga' , 'Trinidad y Tobago' , 
	'Túnez' , 'Turkmenistán' , 'Turquía' , 'Tuvalu' , 'Ucrania' , 'Uganda' , 'Uruguay' , 'Uzbequistán' , 
	'Vanuatu' , 'Vaticano' , 'Venezuela' , 'Vietnam' , 'Wallis y Futuna' , 'Yemen' , 'Yibuti' , 
	'Zambia' , 'Zaire' , 'Zimbabwe');


//$rutaProyecto = 'http://192.168.1.91/SMAFactura/';
$url = $_SERVER['SERVER_NAME'];
$page = $_SERVER['PHP_SELF'];
$rutaProyecto = "http://".$url.str_replace(basename($page) , '', $page);// echo $rutaProyecto;
?>