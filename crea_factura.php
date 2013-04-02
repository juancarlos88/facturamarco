<?php
ob_start();
include 'Config/facturaSMAConfig.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        
        <title>Crea factura .:: FACTURA MARCO ::.</title>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>        
        <script type="text/javascript" src="Jquery/bootstrap/js/bootstrap.min.js"></script>
        <link type="text/css" href="Jquery/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link type="text/css" href="Jquery/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
        
        <script type="text/javascript" src="Jquery/jquery.js"></script>        
        <!-- 
        ========================================================================
                                    DATEPICKER
        ========================================================================
         -->        
        <link type="text/css" href="Jquery/minicalendario/jquery.ui.all.css" rel="stylesheet" />
        <script type="text/javascript" src="Jquery/minicalendario/jquery.ui.core.js"></script>
        <script type="text/javascript" src="Jquery/minicalendario/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="Jquery/minicalendario/jquery.ui.datepicker.js"></script>

        <script type="text/javascript">
            $(function() { 
                $('#fecha').datepicker({
                    changeMonth: true,
                    changeYear: true
                });
            });   
        </script>
         <!--
        ========================================================================
                                 FIN DATEPICKER
        ========================================================================
         -->
         <!-- 
        **************************************
                        TinyMCE 
        **************************************
        -->        
        <script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript"> 
            tinyMCE.init({
                mode : "textareas",
                theme : "simple"
            });
        </script>
        <!-- 
        **************************************
                      Fin TinyMCE 
        **************************************
        -->  
        <title>Crea facturas .::Factura electr&oacute;nica::.</title>
        
        <link type="text/css" href="CSS/general.css" rel="stylesheet" />
        
    </head>
    <body>
        <div class="container sombras">
            <div class="row-fluid">                
                <div Class="span12">
                    <img src="http://www.estrategiasdigitales.com.mx/images/i-head2.gif" title="Estrategias">
                    <?php 
                    include 'Modulos/menuMod.php'; 
                    ?>
                    <div class="contenido">
                        <?php
                        include 'Modulos/creaFacturaMod.php'; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>