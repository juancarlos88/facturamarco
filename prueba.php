<?php 

include 'Config/facturaSMAConfig.php';

function pdf_create($html, $filename='', $stream=TRUE) {
    
    require_once("Clases/dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}

function generaHTMLPDF($rutaProyecto) {
    $code = $_GET['fc'];
    $cols = '*, count(id_factura) as total';
    $inner = 'cli JOIN factura fac ON fac.id_cliente=cli.id_cliente';
    $condicion = "fac.code_factura='" . $code . "'";
    $informacion = infoClientes($cols, $inner, $condicion);
    $info = $informacion[0];
    $total = $info['total'];

    // INFO CLIENTE 
    $idCliente = $info['id_cliente'];
    $razonSocial = $info['razon_social'];
    $rfc = $info['rfc_cliente'];
    $calle = $info['calle'];
    $numExt = $info['num_ext'];
    $numInt = $info['num_int'];
    $colonia = $info['colonia'];
    $cp = $info['codigo_postal'];
    $delegacion = $info['delegacion'];
    $estado = $info['estado'];
    $pais = $info['pais'];

    // FACTURA
    $idFactura = $info['id_factura'];
    $numFactura = $info['num_factura'];
    $fechaFact = date('d-m-Y', strtotime($info['fecha_altaf']));
    $codigo = $info['code_factura'];

    // CONCEPTO
    $colsCon = '*';
    $innerCon = '';
    $condicionCon = 'id_factura=' . $idFactura;
    $infoCon = infoConcepto($colsCon, $innerCon, $condicionCon);
    // echo 'CONCEPTO'; print_r($infoCon);
    
    $archiveName = 'factura_'.$razonSocial;
    $subtotal = 0;
    $totalIva = 0;
    $total = 0;
    
    $subtotalLetra = '';
    
    
    $html = '<html>        
        <head>
            
            <style type="text/css">
                table {font-size:14px;}
            </style>
        </head>
        <body>
        <table style="width: 100%; font-family: Verdana;" border="0">
            <tr>
                <td style="text-align: left; width: 30%;">
                    <img src="'.$rutaProyecto.'Imagenes/factura-cuadroSMA.jpg">
                </td>
                <td valign="bottom" style="text-align: right; width: 70%;">                    
                    Fecha: '.$fechaFact.'<br><br>
                    <span style="border: 1px solid black; padding: 2px 15px 2px 15px; background-color: #BDBDBD;">
                        Factura '.$numFactura.'
                    </span>
                </td>
            </tr>
            <tr>
                <td valign="top" style="font-size: 12px;">
                    <b>SMA Estrategias Digitales, S.A. de C.V.</b>
                    <br>R.F.C. SED030528-664
                    <br>
                    <br>Calzada de Tlalpan No. 2410 Int. 101 A
                    <br>Col. Avante Deleg. Coyoacán.
                    <br>C.P. 04460
                    <br>México D.F.
                    <br>Teléfono y Fax: 5549-6105
                    <br>www.estrategiasdigitales.com.mx
                </td>
                <td valign="top" style="border: 1px solid black;">                    
                    <div style="width:100%; background-color:#BDBDBD; margin:0px 0px; padding: 2px 0px 2px 0px;">
                        Datos del cliente
                    </div>  
                    <div style="width: 80%; margin: 0px auto; border: 0px solid;">
                        <br>'.$razonSocial.'
                        <br>'.$calle.' '.$numExt.' - '.$numInt.'
                        <br>Col. '.$colonia.', Deleg. '.$delegacion.' 
                        <br>'.$pais.', '.$estado.' C.P. '.$cp.'
                        <br>'.$rfc.'
                    </div>
                </td>
            </tr>
        </table>
        <br>
        <table style="width: 100%; font-family: Verdana;" border="0" cellspacing="0">
            <tr style="background-color:#BDBDBD;">
                <th style="width: 10%;">Cantidad</th>
                <th style="width: 50%;">Descripción</th>
                <th style="width: 20%; text-align:right;">Precio unitario</th>
                <th style="width: 20%; text-align:right;">Precio total</th>
            </tr>';
    if(is_array($infoCon)) {
        
        foreach($infoCon as $key=>$val) {
            
            $cantidad = $val['cantidad'];
            $descripcion = $val['descripcion'];
            $precio = number_format($val['precio_unitario'], 2);
            $totalConcepto = number_format($cantidad * $precio, 2);
            
            $subtotal += $cantidad * $precio;
            
            $html .= '<tr>
                <td style="text-align: center; padding: 10px 0px 10px 0px;">'.$cantidad.'</td>
                <td style="text-align: left; padding: 10px 0px 10px 0px;">'.$descripcion.'</td>
                <td style="text-align: right; padding: 10px 0px 10px 0px;">$'.$precio.'</td>
                <td style="text-align: right; padding: 10px 0px 10px 0px;">$'.$totalConcepto.'</td>
            </tr>';
        }
    }
    $totalIva = $subtotal * $iva;
    $total = $totalIva + $subtotal;
    
    $subtotalLetra = convertirLetras($total);
    
    $html .= '</table>
        <table style="width: 100%; font-family: Verdana;" border="0" cellspacing="0">
            <tr>
                <td style="width:20%"><img src="'.$rutaProyecto.'Imagenes/factura-codigo.jpg" alt="codigo"></td>
                <td style="width:50%">
                    <p>
                        <span style="background-color:#BDBDBD; padding: 1px 30px 1px 10px;">
                            Importe letra.                        
                        </span><br>('.ucfirst($subtotalLetra).')
                    </p>
                    <p>
                    <span style="background-color:#BDBDBD;  padding: 1px 30px 1px 10px;">
                        Forma pago.
                    </span><br>Contado
                    </p>
                    <span style="font-size: 10px;">
                    Debe(mos) y pagaré(mos) incondicionalmente a SMA ESTRATEGIAS
                    DIGITALES, S.A. DE C.V. la cantidad estipulada en el neto a 
                    pagar de la presente factura. De no verificarse el pago de 
                    la misma a su vencimiento, pagaré(mos) además intereses
                    moratorios a razón de:
                    _________________________________________________________
                    </span>
                </td>
                <td style="width:30%; vertical-align: top;">
                    <table style="width:100%;  border: 1px solid black;" cellspacing="0">
                        <tr>
                            <th style="width:40%; background-color:#BDBDBD; text-align: right;  padding: 5px 0px 5px 0px;">
                            Subtotal:&nbsp;&nbsp;
                            </th>
                            <td style="widht:60%; text-align:right;">    
                                $'.number_format($subtotal, 2).'
                            </td>
                        </tr>
                        <tr>
                            <th style="width:40%; background-color:#BDBDBD; text-align: right;  padding: 5px 0px 5px 0px;">
                            IVA:&nbsp;&nbsp;
                            </th>
                            <td style="widht:60%; text-align:right;">    
                                $'.number_format($totalIva, 2).'
                            </td>
                        </tr>
                        <tr>
                            <th style="width:40%; background-color:#BDBDBD; text-align: right;  padding: 5px 0px 5px 0px;">
                            Subtotal:&nbsp;&nbsp;
                            </th>
                            <td style="widht:60%; text-align:right;">    
                                $'.number_format($total, 2).'
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </body>
        </html>
    ';    
    return $html;
    //echo utf8_decode($html);
    /*$ruta = $_SERVER['DOCUMENT_ROOT'].'/SMAFactura/';    
    $fp = fopen($ruta.'creaPDF.html', 'w+');
    fwrite($fp, $html);
    fclose($fp);*/ 
    }
    if (isset($_GET['fc']) && $_GET['fc'] != '') {
    $html  = generaHTMLPDF($rutaProyecto);
    pdf_create(' ******************* ', 'archiveName', TRUE);
    
}
?>