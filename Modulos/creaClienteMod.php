<?php
include 'Includes/creaClienteInc.php';
?>
<form action="<?php echo $_SERVER['PHP_SELF'].$getForm; ?>" method="POST">
    <h3>Captura de clientes.</h3>
    <p><strong>(*) Campos obligatorios.</strong></p>    
    <?php echo $htmlErrores; ?>
    <table style="width:98%; margin:0px auto; border:0px solid blue;">
        <tr>
            <td style="width: 30%; text-align:right;">Nombre o Raz&oacute;n Social:</td>
            <td style="width: 70%; text-align:left;">
                <input type="text" name="name" value="<?php echo $arrayPost['name'] ?>" style="width: 90%;"/> *
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">RFC:</td>
            <td  style="text-align:left;">
                <input type="text" name="rfc" value="<?php echo $arrayPost['rfc'] ?>" style="width: 90%;"/> *
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">Calle:</td>
            <td style="text-align:left;">
                <input type="text" name="street" value="<?php echo $arrayPost['street'] ?>" style="width: 90%;"/> *
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">No. Exterior:</td>
            <td style="text-align:left;">
                <input type="text" name="ext" value="<?php echo $arrayPost['ext'] ?>" style="width: 90%;"/>
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">No. Interior:</td>
            <td style="text-align:left;">
                <input type="text" name="int" value="<?php echo $arrayPost['int'] ?>" style="width: 90%;"/>
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">Colonia:</td>
            <td style="text-align:left;">
                <input type="text" name="col" value="<?php echo $arrayPost['col'] ?>" style="width: 90%;"/> *
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">C&oacute;digo Postal:</td>
            <td style="text-align:left;">
                <input type="text" name="cp" value="<?php echo $arrayPost['cp'] ?>" style="width: 90%;"/> *
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">País</td>
            <td style="text-align:left;">
                <input type="text" name="country" value="<?php echo $arrayPost['country'] ?>" style="width: 90%;"/> *
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">Estado:</td>
            <td style="text-align:left;"><?php echo $selects['estados']; ?> *</td>
        </tr>
        <tr>
            <td style="text-align:right;">Delegación / Municipio:</td>
            <td>
                <input type="text" name="del" value="<?php echo $arrayPost['del'] ?>" style="width: 90%;"/> *
            </td>
        </tr>        
        <tr>
            <td align="right">
                <input type="hidden" name="formhid" value="<?php echo $nomFormhid;?>"/>
                <input class="btn btn-primary" type="submit" name="<?php echo $nomSubmit;?>" value="Guardar"/>
            </td>
            <td align="left">
                <input class="btn" type="button" name="cancel" value="Clientes" onclick="location.href='desp_clientes.php'">
            </td>
        </tr>
    </table>
</form>