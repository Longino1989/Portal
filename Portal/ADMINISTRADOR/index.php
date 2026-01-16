<?php
session_cache_limiter('private, must-revalidate');
session_cache_expire(60);
session_start();
include('../conexionSimple.php');
//$sd=conectar(); 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<TITLE>MODULO DE ADMINISTRADOR</TITLE>
    <link href="date/datePicker.css" rel="stylesheet" type="text/css">
<link type="text/css" href="css/basico.css"  rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/estiloMenu.css" />
<link rel="stylesheet" type="text/css" href="css/basicoAct.css">
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="date/date.js"></script>
<script type="text/javascript" src="date/jquery.datePicker.js"></script>
<script type="text/javascript" src="js/calendario/jquery.functions.js"></script>

    </head>

<body onload="usuario();">
<h1>MODULO DE ADMINISTRADOR</h1>
</body>

</html>