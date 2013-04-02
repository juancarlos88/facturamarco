<?php 
include 'Includes/loginInc.php';
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	<table border="0" align="center" cellpadding="0" cellspacing="0" class="comun">
	  <tr>
		<td class="tabla_cabeza"><p align="center" class="h3">Introduce un usuario y contrase&ntilde;a</p></td>
	  </tr>	  
	  <tr>
		<td align="left" class="tabla_cuerpo">
			<?php echo $mensaje; ?>
			<table border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td align="left"><p>Usuario: </p></td>
				<td align="left"><input type="text" name="user" id="user" value="<?php echo $resPost['user']; ?>"></td>
			  </tr>
			  <tr>
				<td align="left"><p>Contrase&ntilde;a:&nbsp;</p></td>
				<td align="left"><input type="password" name="pass" id="pass"></td>
			  </tr>
		  </table>
		<div align="right">
		  <input type="hidden" name="formhid" value="<?php echo $nomFormhid; ?>">
		  <input type="submit" name="ingresar" id="ingresar" value="Ingresar">
		</div>		
		</td>
	  </tr>
	</table>
</form>
