<?php
include("../../conexionSimple.php");
$imgid=$_POST["imgidx"];
$usuarioID=$_POST["usidx"];
$sd=conectar();

$verificaAreax=sqlsrv_query($sd,"select * from archivosProveedores where imagenid = ".$imgid." ");
$verificaArea=sqlsrv_fetch_array($verificaAreax);
$obtieneDepx=sqlsrv_query($sd,"select * from cusuario where usuarioid = ".$verificaArea["usuarioidfk"]." ");
$obtieneDep=sqlsrv_fetch_array($obtieneDepx);

$valida=sqlsrv_query($sd,"select usuarioidfk from archivosProveedores where imagenid = ".$imgid."");
$validax = sqlsrv_fetch_array($valida);
$usuario=$validax["usuarioidfk"];
if($usuarioID==$usuario){
$imgx=sqlsrv_query($sd,"update archivosProveedores set estatus='4' where imagenid=".$imgid." ");
}
else{
	echo "usuarioDirefente";
	}
?>