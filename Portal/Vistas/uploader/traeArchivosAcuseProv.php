<?php
include("../../conexionSimple.php");
$folio=$_POST["foliox"];
$usuarioID=$_POST["usidx"];
//echo $folio; return -1;

$sd=conectar();
$datosUserx=sqlsrv_query($sd,"select * from cusuario where usid = ".$usuarioID."");
$datosUser=sqlsrv_fetch_array($datosUserx);

$imgx=sqlsrv_query($sd,"select pr.*, us.usuario from archivosProveedores as pr
inner join cusuario as us on(us.usid=pr.usuarioidfk)
where pr.factura=".$folio." and pr.estatus=3 and (us.usuario = '".$datosUser["usuario"]."' or us.usuario = 'admin') and pr.tipoArchivo = 'acuse' ");
//$img = mssql_fetch_array($imgx);
echo "<ul id='ul".$folio."' style='list-style:none'>";
while($img = sqlsrv_fetch_array($imgx)){
$corta = explode('.',$img["nombre"]); $ext=end($corta);
	if($ext=='pdf'){
		echo "<li id='".$img["imagenid"]."'><img src='imgs/verifica.ico'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='imgs/pdf.png' ><a href='".$img["direccion"]."'>".$img["nombre"]."<br />&nbsp;&nbsp;&nbsp;<a target='_blank' href='".$img["direccion"]."'>Ver</a></li>";
	}else{
	
	echo"";}
 }
 echo "</ul>";
 //echo"<img src="../../../../../archivosPDFAcuse/abajo.JPG"";

?>