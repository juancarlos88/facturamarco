<?php include 'Includes/desp_cliente_inc.php'; ?>
<h3>Clientes capturados.</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
    <input class="search-query" type="text" name="cli" value="<?php echo $resGet['cli'] ?>" placeholder="Buscar"> <input class="btn btn-primary" type="submit" value="Buscar">
</form>
<!--  ################################# PAGINACION ############################### -->
<div class="pagination pagination-centered" style="margin:0px auto; border:0px solid blue;">   
    <ul>
        <?php if($pagesIni['ini']!='') {?>
        <li><?php echo $pagesIni['ini']; ?></li>
        <?php 
        }  
        if($pagesMid['ini']!='') {
        ?>
        <li><?php echo $pagesMid['ini']; ?></li>
        <?php 
        }
        echo $paginas; 
        if($pagesMid['fin']!='') {
        ?>
        <li><?php echo $pagesMid['fin']; ?></li>
        <?php 
        }
        if($pagesIni['fin']!='') {
        ?>
        <li><?php echo $pagesIni['fin']; ?></li>
        <?php } ?>   
    </ul>    
</div>
<!--  ################################# PAGINACION ############################### -->
<table class="table table-striped table-bordered" style="width: 100%; margin: 0px auto;">
    <tr>
        <th style="width: 16%">Fecha Alta</th>
        <th style="width: 16%">RFC</th>
        <th style="width: 48%">Cliente</th>
        <th style="width: 10%">Ver/Editar</th>
        <th style="width: 10%">Eliminar</th>
    </tr>
<?php 
    if (is_array($info)) {
        
        foreach ($info as $key=>$val) {
            
            $idFactura = $val['id_cliente'];
            $rfc = $val['rfc_cliente'];
            $fecha_alta = $val['fecha_alta'];
            $cliente = $val['razon_social'];                        
            $totalFac = number_format($val['total_fac'], 2);
            
            $editarURL = 'crea_cliente.php?fc='.$val['id_cliente'].'&bedit=1';
            $titleEditar = 'Editar';
            
            $eliminarURL = $_SERVER['PHP_SELF'].'?fc='.$val['id_cliente'].'&bdel=1';
            $titleEliminar = 'Eliminar';
?>
    <tr>
        <td style="width: 16%; text-align: center;"><?php echo $fecha_alta; ?></td>
        <td style="width: 16%; text-align: left;"><?php echo $rfc; ?></td>
        <td style="width: 48%; text-align: left;"><?php echo $cliente; ?></td>
        <td style="width: 10%; text-align: center;">
            <a class="btn" href="<?php echo $editarURL; ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>">
                <i class="icon-pencil"></i>
            </a>
        </td>
        <td style="width: 10%; text-align: center;">
            <a class="btn btn-danger" href="<?php echo $eliminarURL; ?>" title="<?php echo $titleEliminar; ?>" alt="<?php echo $titleEliminar; ?>" onClick="return confirmaEliminar('<?php echo $noFactura; ?>')">
                <i class="icon-trash icon-white"></i>
            </a>
        </td>
    </tr>
<?php 
    }
}
?>
</table>
<!--  ################################# PAGINACION ############################### -->
<div class="pagination pagination-centered" style="margin:0px auto; border:0px solid blue;">   
    <ul>
        <?php if($pagesIni['ini']!='') {?>
        <li><?php echo $pagesIni['ini']; ?></li>
        <?php 
        }  
        if($pagesMid['ini']!='') {
        ?>
        <li><?php echo $pagesMid['ini']; ?></li>
        <?php 
        }
        echo $paginas; 
        if($pagesMid['fin']!='') {
        ?>
        <li><?php echo $pagesMid['fin']; ?></li>
        <?php 
        }
        if($pagesIni['fin']!='') {
        ?>
        <li><?php echo $pagesIni['fin']; ?></li>
        <?php } ?>   
    </ul>
</div>
<!--  ################################# PAGINACION ############################### -->