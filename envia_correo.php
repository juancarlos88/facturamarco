<?php
include 'Config/facturaSMAConfig.php';
ob_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Enviar correo</title>        
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>        
        <script type="text/javascript" src="Jquery/bootstrap/js/bootstrap.min.js"></script>
        <link type="text/css" href="Jquery/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link type="text/css" href="Jquery/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
        
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
        <style type="text/css">
            #main {                 
                
                margin: 0px auto; 
                padding: 5px 0px 20px 0px; 
                font-family: verdana;
            }
        </style>
    </head>
    <body>
        <div id="main">
            <?php
            include 'Includes/enviacorreoInc.php';
            include 'Modulos/enviacorreoMod.php';
            ?>
        </div>
    </body>
</html>
<?php ob_end_flush(); ?>