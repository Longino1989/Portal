<?php
require ('permiso.php');
include('../../conexionSimple.php');
$sd=conectar();

$userID = $_POST["userx"];

//echo $userID;
echo"    <fieldset>
<legend>Cambio de contraseña</legend>
<table align = 'center' style='width:50%;'> 
<colgroup span='1'></colgroup> 
<tr> 
<td class='tdDos'><b>Contraseña Actual:</b></td><td class='tdDos'><input type='password' class='cajaDos' size=20 id='passActual'></div></td>
</tr>
<tr>
<td class='tdDos'><b>Contraseña Nueva:</b></td><td class='tdDos'><input type='password' class='cajaDos' size=20 id='passNueva'></td>
</tr>
<tr>
<td class='tdDos'><b>Confirmar Contraseña:</b></td><td  class='tdDos'><input type='password' class='cajaDos' size=20 id='confPass'></td>
</tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr>
<td class='tdDos'><input type='button' id='limpiaPass' value='Limpiar' class='button buttonLimpiar' onclick='limpiarPass()'></td>
<td class='tdDos'><input type='button' id='cambiaPass' value='Guardar Cambios' class='button buttonVerde' onclick='guardaPass(".$userID.",passActual.value,passNueva.value,confPass.value)'></td>
</table>
</fieldset>";
?>