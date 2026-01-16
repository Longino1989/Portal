<?php
session_start();
include('../conexionSimple.php');
$sd=conectar(); 

//$usuarioID=$_GET["usuarioIDx"];

$micarpeta = '../carpetaCreadaXPHP';
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
?>