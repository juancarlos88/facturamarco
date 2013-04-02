<?php
include 'Includes/despConceptoInc.php';
if(is_array($infoConcepto)) {
?>
<table style="width:89%; margin:0px auto;">
    <tr>
        <th style="width:10%;">Cantidad</th>
        <th style="width:40%;">Descripción</th>
        <th style="width:20%; text-align: right;">Precio unitario</th>
        <th style="width:20%; text-align: right;">Precio total</th>
        <th style="width:10%; text-align: right;">Editar</th>
        <th style="width:10%; text-align: right;">Eliminar</th>
    </tr>
<?php
    
    foreach($infoConcepto as $key=>$val) {
        
        $idConcepto = $val['id_concepto'];
        $cantidad = $val['cantidad'];
        $desc = $val['descripcion'];
        $precio = $val['precio_unitario'];
        $totalConcepto = number_format($cantidad * $precio, 2);
        
        $subtotal += $totalConcepto;
        $iva  = number_format($subtotal * 0.16, 2);
        $total = number_format($subtotal + $iva, 2);
        
        $editLink = $_SERVER['PHP_SELF'].'?fc='.$code.'&cc='.$idConcepto.'&bedit=1';
        $edittitle = 'Editar concepto';
        
        $delLink = $_SERVER['PHP_SELF'].'?fc='.$code.'&cc='.$idConcepto.'&bdel=1';
        $deltitle = 'Eliminar';
?>
    <tr>
        <td style="text-align: center; vertical-align: top;">
            <?php echo $cantidad;?>
        </td>
        <td style="text-align: left; vertical-align: top;">
            <?php echo $desc?>
        </td>
        <td style="text-align: right; vertical-align: top;">
            $ <?php echo number_format($precio, 2); ?>
        </td>
        <td style="text-align: right; vertical-align: top;">
            $ <?php echo $totalConcepto?>
        </td>
        <td style="text-align: right; vertical-align: top;">
            <a class="btn" href="<?php echo $editLink; ?>" title="<?php echo $edittitle; ?>">
                <i class="icon-pencil"></i>
            </a>
        </td>
        <td style="text-align: right; vertical-align: top;">
            <a class="btn btn-danger" href="<?php echo $delLink; ?>" title="<?php echo $deltitle; ?>" onClick="return confirmaEliminar();">
                <i class="icon-trash icon-white"></i>
            </a>
        </td>
    </tr>
<?php 
    }
?>
</table>
<?php
} 
?>