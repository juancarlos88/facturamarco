<?php
include 'Includes/creaFacturaInc.php';
?>
<h3>Captura de Factura.</h3>
<p><strong>(*) Campos obligatorios.</strong></p>    
<?php 
echo $htmlErrores; 
?>
<form action="<?php echo $_SERVER['PHP_SELF'] . $getForm; ?>" method="POST">    
    <table style="width:98%; margin:0px auto; border:0px solid blue;">
        <tr>
            <td style="width:20%; text-align:right;">Número Factura:</td>
            <td style="width:80%; text-align: left;">
                <input type="text" name="fact" id="fact" value="<?php echo $resPost['fact']?>" style="width: 50%;"> *
            </td>
        </tr>
        <tr>
            <td style="width:20%; text-align: right;">Cliente:</td>
            <td style="width:80%; text-align: left;" style="width: 91%;">
                <?php echo $selects['clientes']; ?> * <img src="Imagenes/preloader_run.gif" alt="Cargando" id="loading">
            </td>
        </tr>
        <tr>
            <td style="width:20%; text-align: right;">Fecha:</td>
            <td style="width:80%; text-align: left;">
                <input type="text" name="fecha" id="fecha" value="<?php echo $resPost['fecha']?>" style="width: 50%;"> *
            </td>
        </tr>
        <tr>
            <td style="width:20%; text-align: right; vertical-align: top;">Forma pago:</td>
            <td style="width:80%; text-align: left;">
                <textarea name="formapago" cols="30" rows="8" style="width:85%;" id="formapago"><?php echo $resPost['formapago']?></textarea> *
            </td>
        </tr>
        <tr>
            <td style="width:20%; text-align: right;">
                <input type="hidden" name="formhid" value="<?php echo $nomFormhid;?>"/>
                <input class="btn btn-primary" type="submit" name="<?php echo $nomSubmit;?>" value="Guardar"/>
            </td>
            <td style="width:80%; text-align: left;">
                <input class="btn" type="submit" name="cancel" value="Cancelar">
                <?php echo $msjRegresar; ?>
            </td>
        </tr>
    </table>
</form>
<span id="pruebajuan"></span>
<script type="text/javascript">
    $(document).ready(function() {
        
        $('#formapago').bind('keyup', function() { alert('hi') } );;
        
        $('#loading').hide();
        $('#loading').ajaxStart(function() {
            
            $(this).show();
            
        }).ajaxStop(function() {
            
            $(this).hide();
        }); 
        $('#cli').change(function() {
           
           var cliente = $('#cli').val();  
           var ruta = 'getFormapago.php';
           var informacion = 'cli=' + cliente;
           
           var request = $.ajax({ 
                dataType: 'text',
                cache: false,
                url: ruta,
                type: 'POST',
                data:  informacion,
                beforeSend: function(objeto) {
                    // NO EXISTEN INSTRUCCIONES EN ESTE CASO                    
                },
                success: function(html) {
                    // NO EXISTEN INSTRUCCIONES EN ESTE CASO                    
                },
                error: function() {
                    // NO EXISTEN INSTRUCCIONES EN ESTE CASO
                    
                }
            }).done(function(htmlimprimir) {                        
                
                tinyMCE.activeEditor.setContent(htmlimprimir);
            });
        });
    });
</script>