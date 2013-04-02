<?php include 'Includes/desp_factura_inc.php'; ?>
<h3>Facturas creadas.</h3>
<div class="pull-right">
    <form action="<?php echo $_SERVER['PHP_SELF'] . $getForm;?>" method="GET" clasS="form-search">        
        Cliente <input type="text" name="cli" value="<?php echo $resGet['cli']; ?>" class="input-medium search-query" placeholder="Cliente..."> 
        Factura <input type="text" name="num" value="<?php echo $resGet['num']; ?>" class="input-medium search-query" placeholder="No. Factura...">
        <button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> Buscar</button>
    </form>
</div>
<div class="clearfix"></div>
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
<table class="table table-striped  table-bordered" style="width: 100%; margin: 0px auto;">
    <tr>
        <th style="width: 10%; text-align:center;">No. Factura.</th>
        <th style="width: 10%; text-align:center;">Fecha.</th>
        <th style="width: 40%; text-align:center;">Cliente</th>
        <th style="width: 10%; text-align:center;">Total</th>
        <th style="width: 10%; text-align:center;">Total IVA</th>
        <th style="width: 10%; text-align:center;">Ver/Editar</th>
        <th style="width: 10%; text-align:center;">Eliminar</th>
    </tr>
<?php 
    if (is_array($info)) {
        
        foreach ($info as $key=>$val) {
            
            $idFactura = $val['id_factura'];
            $noFactura = $val['num_factura'];
            $fecha = date('d-m-Y', strtotime($val['fecha_altaf']));
            $cliente = $val['razon_social'];                        
            $totalFac = $val['total_fac'];
            $totalIVA = $totalFac * 1.16;
            
            $editarURL = 'crea_concepto.php?fc='.$val['code_factura'].'&bedit=1';
            $titleEditar = 'Editar';
            
            $eliminarURL = $_SERVER['PHP_SELF'].'?fc='.$val['code_factura'].'&bdel=1';
            $titleEliminar = 'Eliminar';
?>
    <tr>
        <td style="width: 10%; text-align: center;"><?php echo $noFactura; ?></td>
        <td style="width: 10%; text-align: left;"><?php echo $fecha; ?></td>
        <td style="width: 40%; text-align: left;"><?php echo $cliente; ?></td>
        <td style="width: 20%; text-align: right;">$ <?php echo number_format($totalFac, 2); ?></td>
        <td style="width: 20%; text-align: right;">$ <?php echo number_format($totalIVA, 2); ?></td>
        <td style="width: 10%; text-align: center;">
            <a href="<?php echo $editarURL; ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" class="btn">
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