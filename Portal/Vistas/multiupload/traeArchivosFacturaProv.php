<?php
include("../../conexionSimple.php");
$documento=$_POST["docx"];
$usuarioID=$_POST["usuarioidx"];
//echo $documento; return -1;

$sd=conectar();
$datosUserx=sqlsrv_query($sd,"select * from cusuario where usid = ".$usuarioID."");
$datosUser=sqlsrv_fetch_array($datosUserx);

$imgx=sqlsrv_query($sd,"select pr.*, us.usuario from archivosProveedores as pr
inner join cusuario as us on(us.usid=pr.usuarioidfk)
where pr.factura=".$documento." and pr.estatusidfk=3 and pr.tipoArchivo = 'factura' ");
//$img = mssql_fetch_array($imgx);
echo "<ul id='ul".$documento."' style='list-style:none'>";
while($img = sqlsrv_fetch_array($imgx)){
$corta = explode('.',$img["nombre"]); $ext=end($corta);
	if($ext=='pdf'){
		echo "<li id='".$img["imagenid"]."'><img src='imgs/verifica.ico'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='imgs/pdf.png' ><a href='".$img["direccion"]."'>".$img["nombre"]."<br />&nbsp;&nbsp;&nbsp;<a target='_blank' href='".$img["direccion"]."'>Ver</a></li>";
	}else{
	
	echo"";}
 }
 echo "</ul>";
 //echo"<img src="../../../../../archivosPDFFactura/abajo.JPG"";

?>