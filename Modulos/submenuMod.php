<br>
<?php
if ($_GET['mn'] == 'cli') {
?>
<h3>Clientes</h3>
<ul>
    <li><a href="crea_cliente.php" title="Nuevo cliente">Nuevo cliente.</a></li>
    <li><a href="desp_clientes.php" title="Consulta">Consulta clientes.</a></li>
</ul>
<?php } else if ($_GET['mn'] == 'fac') { ?>
<h3>Facturas</h3>
<ul>
    <li><a href="crea_factura.php" title="Nuevo factura">Nueva factura.</a></li>
    <li><a href="desp_factura.php" title="Consulta">Consulta facturas.</a></li>
</ul>
<?php } ?>


