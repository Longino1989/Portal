<?php
/*$sqlsrv = new sqlsrv('localhost','sa','Lunes2189','tamex');

if($sqlsrv->connect_errno){
    echo 'Fallo la conexion' . $sqlsrv->connect_errno;
    die();
}*/

$contrasena = 'Lunes2189';
$usuario = "sa";
$nombreBaseDeDatos = "tamex";
# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
$rutaServidor = 'localhost';//192.168.11.235 201.163.60.50  tamexfluig.ddns.net\\MSSQLSERVER,1515
try {
    $sqlsrv = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $usuario, $contrasena);
    $sqlsrv->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Ocurrió un error con la base de datos: " . $e->getMessage();
}
?>