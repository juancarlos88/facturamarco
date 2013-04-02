<?php
include 'Config/facturaSMAConfig.php';

if ($_POST) {
    
    $post = $_POST;

    if (!empty($post['cli'])) {
        
        $facturaInfo = info_facturas('forma_pago', 'id_cliente = ' . $post['cli'] . ' ORDER BY id_factura DESC');
        $facturaPago = $facturaInfo[0]['forma_pago'];
        echo $facturaPago;
        
    } else {
        
        echo '';
    }
}
?>
