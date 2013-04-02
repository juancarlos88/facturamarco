<?php
/**
 * *****************************************************************************
 *                               PROCESAMIENTO.
 * *****************************************************************************
 */
if($_GET) {
    
    $get = $_GET;
    if($get['fc'] != '') {
        
        $code = $get['fc'];
        $cols = '*';
        $inner = 'con JOIN factura fac ON con.id_factura = fac.id_factura';
        $condicion = "fac.code_factura='" . $code . "'";
        $infoConcepto = infoConcepto($cols, $inner, $condicion);        
    }    
    
    if($get['bdel'] == 1) {
        
        if( ! empty($get['cc'])) {
            
            $idConcepto = $get['cc'];
            creaDeleteQuery('concepto', 'id_concepto='.$idConcepto);
            header('Location: '.$_SERVER['PHP_SELF'].'?fc='.$code);
        }
    }
}
?>
