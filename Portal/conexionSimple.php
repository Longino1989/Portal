<?php

global $con;

function conectar(){
    $serverName='localhost';
    $conectionInfo=array("Database"=>"tamex","UID"=>"sa","PWD"=>"Lunes2189","CharacterSet"=>"UTF-8");
$con = sqlsrv_connect($serverName,$conectionInfo);

    if($con){
        return $con; echo"Conexion exitosa";
    }else{
        echo"Fallo la conexion";
    }

}

function desconectar(){
    //$desc = sqlsrv_close("tamex","sa","Lunes2189");
    $serverName='localhost';
    $conectionInfo=array("Database"=>"tamex","UID"=>"sa","PWD"=>"Lunes2189","CharacterSet"=>"UTF-8");
    sqlsrv_close('resource', '$conectionInfo');
    }
?>