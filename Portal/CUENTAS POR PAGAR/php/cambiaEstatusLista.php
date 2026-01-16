<?php
require ('permiso.php');
include('../../conexionSimple.php');
$sd=conectar();
$listaEntrada = $_POST["listaEntradasx"];
$estatusNuevo = $_POST["estatusNuevox"];
$proveedor = $_POST["numProvx"];
$userid = $_POST["usuarioIDx"];
$estatusActual = $_POST["estatusActualx"];

//echo $listaEntrada."-".$estatusNuevo."-".$proveedor."-".$userid."-".$estatusActual; return -1;

if($listaEntrada == ',0' || $listaEntrada == ' '){echo'vacia'; return -1;}

$lista1 = str_replace(",0", "", $listaEntrada);

$arr = explode(',', $lista1);
//echo count($arr);
for($i=1; $i<count($arr); $i++){
    //echo $arr[$i] . " ";

    $valoresAntx=sqlsrv_query($sd,"select pr.estatusidfk, es.nombre as nombreEstatus, es.tarea_referente, pr.facturaProv, pr.importeFacProv from tprovIntelisis as pr
    inner join cestatus as es on (es.estatusid=pr.estatusidfk)
    where pr.MovID = '".$arr[$i]."'");
    $valAnt=sqlsrv_fetch_array($valoresAntx);

    $valoresNuex=sqlsrv_query($sd,"select nombre from cestatus where estatusid = ".$estatusNuevo."");
    $valNuevo=sqlsrv_fetch_array($valoresNuex);

    $tablaCambios=sqlsrv_query($sd,"insert into tcambios(numeroDoc,ValorAnterior,valorNuevo,usuarioidfk,campo,fechaCambio)values(".$arr[$i].",'".$valAnt["nombreEstatus"]."','".$valNuevo["nombre"]."',".$userid.",'estatusEntComp',getdate())");

    $update=sqlsrv_query($sd,"update tprovIntelisis set estatusidfk = ".$estatusNuevo." where MovID = ".$arr[$i]."");
}


?>