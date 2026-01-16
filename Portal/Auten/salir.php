<?php
session_start();
$seid=session_id();
$_SESSION = array();
session_destroy();
include('../conexionSimple.php');
$sd=conectar();
//$sd->conectar();
//$sesionidx=sqlsrv_query($sd,"select top(1)* from sesiones where sesionid='".$seid."' order by fecha desc");
//$sesionid=sqlsrv_fetch_array($sesionidx);
//$nr=sqlsrv_num_rows($sesionidx);
//if($nr==1){$up=sqlsrv_query($sd,"update sesiones set fechaCierre=GETDATE() where id=".$sesionid["id"]." ");}
//$sd->desconectar();
header("Location: ../index.html");
?>