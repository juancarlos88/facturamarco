<?php
include 'Includes/creaConceptoInc.php';
?>
<h3>Captura conceptos <?php echo $razonSocial;?></h3>
<p><strong>(*) Campos obligatorios.</strong></p>   
<?php echo $htmlErrores; ?>
<form action="<?php echo $_SERVER['PHP_SELF'].$getForm; ?>" method="POST">    
    <table style="width:98%; margin:0px auto; border:0px solid blue;">
        <tr>
            <td style="width:25%; text-align:right;">* Cantidad:</td>
            <td style="width:75%; text-align:left;">
                <input type="text" name="quantity" value="<?php echo $resPost['quantity'];?>">
            </td>            
        </tr>
        <tr>
            <td style="text-align:right;">* Precio:</td>
            <td style="text-align:left;">
                <div class="input-prepend">
                    <span class="add-on">$</span><input type="text" name="price" value="<?php echo $resPost['price'];?>">
                </div>
            </td>           
        </tr>
        <tr>
            <td style="text-align:right;">* Unidad:</td>
            <td style="text-align:left;">
                <input type="text" name="unidad" value="<?php echo $resPost['unidad'];?>">
            </td>            
        </tr>
        <tr>
            <td style="text-align:right; vertical-align:top;">Descripción:</td>
            <td style="text-align:left;">
                <textarea name="desc" cols="30" rows="8" style="width:96%;"><?php echo $resPost['desc']?></textarea>
            </td>            
        </tr>
        <tr>
            <td style="text-align:right;">
                <input type="hidden" name="formhid" value="<?php echo $nomFormhid;?>"/>
                <input class="btn btn-primary" type="submit" name="<?php echo $nomSubmit;?>" value="Guardar"/>
            </td>
            <td style="text-align:left;">                
                <button class="btn btn-info" name="verpdf" onClick="window.open('facturaPDF.php?fc=<?php echo $code;?>','_blank');">
                    <i class="icon-print icon-white"></i> Factura
                </button>
                <!-- <a href="crea_factura.php?fc=<?php echo $get['fc']?>&bedit=1">Editar Factura</a> -->
                <a class="fancybox fancybox.iframe btn btn-success" rel="fancybox" href="envia_correo.php?fc=<?php echo $get['fc']; ?>">
                    <i class="icon-envelope icon-white"></i> Enviar
                </a>
                <button class="btn" name="editarfactura" onclick="location.href='crea_factura.php?fc=<?php echo $get['fc']?>&bedit=1'">                
                    <i clasS="icon-pencil"></i> Editar
                </button>
                <input class="btn" type="button" name="regresar" value="Regresar" onclick="location.href='desp_factura.php'">
            </td>
        </tr>
    </table>
</form>