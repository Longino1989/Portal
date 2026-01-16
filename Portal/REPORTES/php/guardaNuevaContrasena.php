<?php
require ('permiso.php');
include('../../conexionSimple.php');
$sd=conectar();

$userID = $_POST["userIDx"];
$passActual = $_POST["passActualx"];
$passNueva = $_POST["passNuevax"];
$confPass = $_POST["confPassx"];

//echo $userID."-".$passActual."-".$passNueva."-".$confPass;

$countCaracteres = strlen($passNueva);
if($countCaracteres < 8){echo"2"; return -1;}

$passNew = base64_encode($passNueva);
$passOld = base64_encode($passActual);

$datosx=sqlsrv_query($sd,"select * from cusuario where usid = ".$userID."");
$datos=sqlsrv_fetch_array($datosx);

//$passBase = base64_decode($datos["contrasena"]);

if($datos["contrasena"]==$passOld){
    if($passNueva==$confPass){
$updPass =sqlsrv_query($sd,"update cusuario set contrasena = '".$passNew."' where usid = ".$userID."");
    }else{echo"1";}

}else{echo"0";}

?>