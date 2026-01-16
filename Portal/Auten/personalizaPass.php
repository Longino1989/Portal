<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Configurando Acceso</title>

<!--<script src = 'https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../Vistas/sweetalert2/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="../Vistas/sweetalert2/dist/sweetalert2.min.css">

<link rel='stylesheet' href='https://unpkg.com/bootstrap@4.1.0/dist/css/bootstrap.min.css'>
<link href="./css/estilos.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/jquery-1.4.4.min.js"></script>
</head>
<body>
<img src="imgs/kpi_19.png"; class="watermarked">
<div >
<div class="contenedor">
    <div class="hijo">
<fieldset class="border p-4"><legend class="w-auto">Cambio de Contraseña</legend>
<table width="80%">
<tr><td colspan="3"><b>Favor de cabiar su contraseña...</b></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td><b>Contraseña Actual:</b></td><td> <input type="password" id="passActualAuten" class="form-control"></td></tr>
<tr><td></td></tr>
<tr><td><b>Contraseña Nueva:</b></td><td> <input type="password" id="passNuevaAuten" class="form-control"></td></tr>
<tr><td></td></tr>
<tr><td><b>Confirma Contraseña:</b></td><td> <input type="password" id="confPassAuten" class="form-control"></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td><td><input type="submit" class="btn btn-success" style="float:right" value="Guardar" onclick="guardaPass(<?php echo $_SESSION["usid"]; ?>,passActualAuten.value,passNuevaAuten.value,confPassAuten.value);">
<input type="button" id="limpiaPass" value="Limpiar" style="float:left" class="btn btn-secondary"; onclick='limpiarPassAuten()'></td></tr>
</table>
</fieldset>
</div>
</div>
</div>
</body>
</html>