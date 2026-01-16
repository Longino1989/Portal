<?php
require ('permiso.php');
include('../../conexionSimple.php');
$sd=conectar();

$usuarioid = $_POST["usuarioIDx"];
$comentario = $_POST["comentariox"];
$movID = $_POST["movIDx"];
$horas='0:00';

//echo $usuarioid."+".$comentario."+".$movID; return -1;
$userx=sqlsrv_query($sd,"select * from cusuario where usid = ".$usuarioid."");
$user=sqlsrv_fetch_array($userx);
$comx=sqlsrv_query($sd,"select comentariosProv from tprovIntelisis where MovID = ".$movID."");
$com=sqlsrv_fetch_array($comx);
if($com["comentariosProv"]=='' || $com["comentariosProv"]==' '){$cc="comentariosProv=' - ".$user["usuario"].": '+Convert(varchar(17), GETDATE()+'".$horas."', 13)+ ' ".$comentario."'";
}else{$cc="comentariosProv=comentariosProv+'
 - ".$user["usuario"].": '+Convert(varchar(17), GETDATE()+'".$horas."', 13)+ ' ".$comentario."'";
}
$guardaCom=sqlsrv_query($sd,"update tprovIntelisis set ".$cc." where MovID = ".$movID."");

$NuevoComx=sqlsrv_query($sd,"select comentariosProv from tprovIntelisis where MovID = ".$movID."");
$Ncom=sqlsrv_fetch_array($NuevoComx);

echo "||".$Ncom["comentariosProv"]."";

?>