<h3>Envio de factura a cliente.</h3>
<?php echo $htmlErrores; ?>
<form action="<?php echo $_SERVER['PHP_SELF'].$getForm; ?>" method="POST">
    <table style="width:85%; margin:0px auto; border:0px solid; font-family: Verdana; font-size: 10pt;">
        <tr>    
            <td style="width:20%; margin-right: 0px;" align="right">Asunto:</td>
            <td style="width:80%;" align="left">
                <input type="text" name="asunto" value="<?php echo $resPost['asunto']; ?>" id="asunto" style="width:78%;">
            </tdnombre
        </tr>
        <tr>    
            <td style="width:20%; margin-right: 0px;" align="right">Nombre (De):</td>
            <td style="width:80%;" align="left">
                <input type="text" name="nomsalida" value="<?php echo $resPost['nomsalida']; ?>" id="nomsalida" style="width:78%;">
            </tdnombre
        </tr>
        <tr>    
            <td style="width:20%; margin-right: 0px;" align="right">Correo (De):</td>
            <td style="width:80%;" align="left">
                <input type="text" name="correosalida" value="<?php echo $resPost['correosalida']; ?>" id="correosalida" style="width:78%;">
            </tdnombre
        </tr>
        <tr>    
            <td style="width:20%; margin-right: 0px;" align="right">Nombre (Para):</td>
            <td style="width:80%;" align="left">
                <input type="text" name="nombre" value="<?php echo $resPost['nombre']; ?>" id="nombre" style="width:78%;">
            </tdnombre
        </tr>
        <tr>    
            <td align="right">Email (Para):</td>
            <td align="left">
                <input type="text" name="correo" value="<?php echo $resPost['correo']; ?>" id="correo" style="width:78%;">
            </td>
        </tr>        
        <tr>    
            <td style="vertical-align: top;" align="right">Comentarios:</td>
            <td style="vertical-align: top;" align="left">
                <textarea rows="8" cols="45" name="comentario" style="width:80%;"><?php echo $resPost['comentario']?></textarea>
            </td>
        </tr>
        <tr>    
            <td style="vertical-align: top;" align="right">
                &nbsp;
            </td>
            <td style="vertical-align: top;" align="left">
                <input type="hidden" name="formhid" value="<?php echo $nomFormhid; ?>">
                <input class="btn btn-primary" type="submit" name="<?php echo $nomSubmit; ?>" value="Enviar.">
            </td>
        </tr>
    </table>
</form>