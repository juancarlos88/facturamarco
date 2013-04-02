<?php
ob_start();
include 'Config/facturaSMAConfig.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Concepto - .::Factura electr&oacute;nica::.</title>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>        
        <script type="text/javascript" src="Jquery/bootstrap/js/bootstrap.min.js"></script>
        <link type="text/css" href="Jquery/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link type="text/css" href="Jquery/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
        
        <link type="text/css" href="CSS/general.css" rel="stylesheet" />
        
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
        <!-- 
        **************************************
                        Fancybox
        **************************************
        -->        
        <script type="text/javascript" src="Jquery/Fancybox/jquery.fancybox.pack.js"></script>
        <link rel="stylesheet" type="text/css" href="Jquery/Fancybox/jquery.fancybox.css" media="screen" />
        <script type="text/javascript">
            $(document).ready(function() {
                $("a[rel*=fancybox]").fancybox({
                    'hideOnContentClick': true,
                    'autoSize': false,
                    'width': (screen.width*0.9),
                    'height': (screen.height*0.5),                    
                    helpers:  {
                        title:  'Enviar Correo'                   
                    }
                });
            });
        </script>
        <!-- 
        **************************************
                        Fancybox 
        **************************************
        -->               
        <script type="text/javascript">
            function confirmaEliminar() {                
                
                if (confirm('¿Está seguro que desea eliminar el concepto?')) {
                    
                    return true;
                    
                } else {
                    
                    return false;
                }
            }
        </script>
    </head>
    <body>
        <div class="container sombras">
            <div class="row-fluid">
                <div Class="span12">
                    <img src="http://www.estrategiasdigitales.com.mx/images/i-head2.gif" title="Estrategias">
                    <?php include 'Modulos/menuMod.php'; ?>
                    <div class="contenido">
                    <?php include 'Modulos/creaConceptoMod.php'; ?>
                    <br>
                    <?php include 'Modulos/despConceptoMod.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>