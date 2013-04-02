<?php

include 'Config/facturaSMAConfig.php';

/**
 * Funcion que crea un pdf por medio de html (DOMPDF - Google).
 * 
 * @param string $html - HTML que queremos que se imprima en el PDF.
 * @param string $filename - Nombre del archivo con el que queremos se exporte.
 * @param boolean $stream - Condicion TRUE / FALSE para saber si queremos que se exporte
 * @param boolean $pagina - Condicion si queremos que se exporte en el navegador (TRUE) 
 *          o descargarlo(FALSE)
 * @return string 
 *//*
function pdf_create($html) {

    require_once("Clases/MPDF54/mpdf.php");    
    
    $mpdf=new mPDF(); 
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    exit;
}*/

function pdf_create($html, $filename='', $stream=TRUE, $pagina = FALSE) {
    
    require_once("Clases/dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    
    if ($stream) {
        
        if ($pagina) {
            $attachment = array("Attachment" => 0);
        }
        $dompdf->stream($filename.".pdf", $attachment);
    } else {
        return $dompdf->output(array('compress'=>0));
    }
}

function creaHeader($fechaFact, $numFactura, $razonSocial, $calle, $numExt, $numInt, $colonia,
        $delegacion, $pais, $estado, $cp, $rfc, $estadosArray) {

    $html = '<html>        
        <head>            
            <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
            <style type="text/css">
                table {font-size: 12px; font-family: \'helvetica\'; width: 100%;}
                body {                    
                    background-repeat:no-repeat;
                    background-position: center;
                }
            </style>
        </head>
        <body>
        <table border="0">
            <tr>
                <td style="text-align: left; width: 30%;">
                    <!-- <img src="Imagenes/factura-cuadroSMA.jpg"> -->
                </td>
                <td valign="bottom" style="text-align: right; width: 70%;">                    
                    Fecha: '.$fechaFact.'<br>
                    Lugar de expedición: México D.F.
                        <br>                    <br>
                    <div style="width: 100%; border: 1px solid black; padding: 2px 15px 2px 15px; background-color: #BDBDBD; float: right;">
                        Factura  <strong>'.$numFactura.'</strong>                        
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top" style="font-size: 11px;">
                    <b>MARCO ANTONIO DURAN RAMIREZ</b>
                    <br>R.F.C. DURM700119UP7
                    <br>
                    <br>Calle Retorno 49 Num. Ext : 26
                    <br>Col. Avante Deleg. Coyoacán.
                    <br>C.P. 04460
                    <br>México D.F.                    
                </td>
                <td valign="top" style="border: 1px solid black;">                    
                    <div style="width:100%; background-color:#BDBDBD; margin:0px 0px; padding: 2px 0px 2px 0px;">
                        Datos del cliente
                    </div>  
                    <div style="width: 80%; margin: 0px auto; border: 0px solid;">
                        <br>'.$razonSocial.'
                        <br>'.$calle.' '.$numExt.' '.$numInt.'
                        <br>Col. '.$colonia.', '.$delegacion.' 
                        <br><!--'.$pais.', -->'.$estado.' C.P. '.$cp.'
                        <br>R.F.C. '.$rfc.'
                    </div>
                </td>
            </tr>
        </table>
        <br>';
    return $html;
}

function creaConceptos($infoCon) {        

    $result = array();
    $totalInfo = count($infoCon);
    $totalMuestra = 10;
    $totalAgrega = $totalMuestra - $totalInfo;
    
    $html = '<table style="height: 500px; font-size: 11px;" border="0" cellspacing="0" >
            <tr style="background-color:#BDBDBD;">
                <td style="height: 0px; width: 10%; text-align:center; "><strong>Cantidad</strong></td>
                <td style="height: 0px; width: 10%; text-align:center; "><strong>Unidad</strong></td>
                <td style="height: 0px; width: 40%; text-align:center; "><strong>Descripción</strong></td>
                <td style="height: 0px; width: 20%; text-align:right; "><strong>Precio unitario</strong></td>
                <td style="height: 0px; width: 20%; text-align:right; "><strong>Precio total</strong></td>
            </tr>';
    if(is_array($infoCon)) {

        foreach($infoCon as $key=>$val) {

            $cantidad = $val['cantidad'];
            $unidad = $val['unidad'];
            $descripcion = $val['descripcion'];
            $precio = $val['precio_unitario'];
            $totalConcepto = $cantidad * $precio;

            $subtotal += $cantidad * $precio;
            
            $html .= '<tr>
                <td valign="top" style="text-align: center; padding: 5px 0px 0px 0px;"><p>'.$cantidad.'</p></td>
                <td valign="top" style="text-align: center; padding: 5px 0px 0px 0px;"><p>'.$unidad.'</p></td>
                <td valign="top" style="text-align: left; padding: 5px 0px 0px 0px;">'.$descripcion.'</td>
                <td valign="top" style="text-align: right; padding: 5px 0px 0px 0px;"><p>$'.number_format($precio, 2).'</p></td>
                <td valign="top" style="text-align: right; padding: 5px 0px 0px 0px;"><p>$'.number_format($totalConcepto, 2).'</p></td>
            </tr>';
        }
    }
    
    if($totalAgrega > 0) {
        
        for($i = 0; $i<$totalAgrega; $i++) {
            
            $html .= '<tr>
                <td valign="top" style="text-align: center; padding: 5px 0px 0px 0px;">&nbsp;</td>
                <td valign="top" style="text-align: left; padding: 5px 0px 0px 0px;">&nbsp;</td>
                <td valign="top" style="text-align: right; padding: 5px 0px 0px 0px;">&nbsp;</p></td>
                <td valign="top" style="text-align: right; padding: 5px 0px 0px 0px;">&nbsp;</td>
            </tr>';
        }
    }
    
    $html .= '</table>';

    $result['html'] = $html;
    $result['subtotal'] = $subtotal;
    return $result;
}

function creaFooter($subtotal, $iva, $formapago) {

    $totalIva = $subtotal * $iva;
    $total = $totalIva + $subtotal;
    $subtotalLetra = convertirLetras($total);

    $html .= '<table border="0" cellspacing="0">
            <tr>
                <td style="width:15%; vertical-align:top;"><img src="Imagenes/factura-codigo.png" alt="codigo" width="120"></td>
                <td style="width:50%; vertical-align:top;">                    
                    <span style="background-color:#BDBDBD; padding: 5px 50px 5px 25px; margin: 0px;">
                        Importe letra.                        
                    </span><br>('.ucfirst($subtotalLetra).')                    
                    <p>
                    <span style="background-color:#BDBDBD;  padding: 5px 50px 5px 25px;">
                        Forma pago.
                    </span>
                    <!--<br>Contado
                    </p>
                    <span style="font-size: 10px; text-align: justify;">
                    Debe(mos) y pagaré(mos) incondicionalmente a MARCO ANTONIO
                    DURÁN RAMIREZ la cantidad estipulada en el neto a 
                    pagar de la presente factura. De no verificarse el pago de 
                    la misma a su vencimiento, pagaré(mos) además intereses
                    moratorios a razón de:
                    _________________________________________________________
                    </span>-->'.$formapago.'
                </td>
                <td style="width:35%; vertical-align:top;">
                    <table style="width:100%; border:1px solid black;" cellspacing="0" width="100%">
                        <tr>
                            <th style="width:40%; background-color:#BDBDBD; text-align: right;  padding: 5px 0px 5px 0px;">
                            Subtotal:&nbsp;&nbsp;
                            </th>
                            <td style="width:60%; text-align:right;">    
                                $'.number_format($subtotal, 2).'
                            </td>
                        </tr>
                        <tr>
                            <th style="width:40%; background-color:#BDBDBD; text-align: right;  padding: 5px 0px 5px 0px;">
                            IVA:&nbsp;&nbsp;
                            </th>
                            <td style="width:60%; text-align:right;">    
                                $'.number_format($totalIva, 2).'
                            </td>
                        </tr>
                        <tr>
                            <th style="width:40%; background-color:#BDBDBD; text-align: right;  padding: 5px 0px 5px 0px;">
                            Subtotal:&nbsp;&nbsp;
                            </th>
                            <td style="width:60%; text-align:right;">    
                                $'.number_format($total, 2).'
                            </td>
                        </tr>                       
                    </table>
                    <table border="0" cellspacing="0">
                        <tr>
                            <td style="font-size:9px; border: 1px solid black;text-align:justify;">
                                Folios del 121 al 150, Número de Aprobación SICOFI: 23575866.                                 
                                <b>Régimen General de Ley Persona Moral</b>.
                                <br>
                                La producción apócrifa de este comprobante constituye un delito 
                                en los términos de las disposiciones fiscales
                                <br>
                                Este comprobante tendrá una vigencia de dos años contados a 
                                partir de la fecha aprobación de la asignación de folios, la cual es 
                                07/07/2012;<br>
                                <table style="font-size:8px; width: 100%">
                                <tr>
                                <td style="width: 50%; text-align:center;">
                                    Efectos fiscales al pago
                                </td>
                                <td style="width: 50%; text-align:center;">
                                    Pago en una sola Exhibición.
                                </td>
                                </tr>                                
                                </table>                                
                            </td>                            
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </body>
        </html>'; 
    return $html; 
}
/**
 * ************************************************************************
 * 				PROCESAMIENTO.
 * ************************************************************************
 */
if (isset($_GET['fc']) && $_GET['fc'] != '') {

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
    $formapago = $info['forma_pago'];
    $fechaFact = date('d-m-Y', strtotime($info['fecha_altaf']));
    $codigo = $info['code_factura'];

    // CONCEPTO
    $colsCon = '*';
    $innerCon = '';
    $condicionCon = 'id_factura=' . $idFactura;
    $infoCon = infoConcepto($colsCon, $innerCon, $condicionCon);    
    
    $mainClass = new mainClass();
    $nombre[0]['nombre'] = $razonSocial;
    $arraySearch = array(' ', '.', ',', "'");
    $nombre = $mainClass->sustituyeRegularExp($nombre, $arrayRemp);     
    $archiveName = 'factura_'.str_replace($arraySearch, '', $nombre[0]['nombre']);    
    
    $estadosArray = $mxEstados; // VARIABLE CONFIGURACION
    
    $header = creaHeader($fechaFact, $numFactura, $razonSocial, $calle, $numExt, $numInt, $colonia,
            $delegacion, $pais, $estado, $cp, $rfc, $estadosArray);    
    $concepto = creaConceptos($infoCon);        
    $subtotal = $concepto['subtotal'];     
    $footer = creaFooter($subtotal, $iva, $formapago);
    
    $html = $header . $concepto['html'] . $footer;
    
    //$debug = TRUE;
    if($debug) {
        
        echo $html;
        
    } else {
        
        pdf_create(utf8_decode($html), $archiveName, TRUE, TRUE);
    }
}
?>