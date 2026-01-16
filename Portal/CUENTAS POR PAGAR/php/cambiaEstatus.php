<?php
require ('permiso.php');
include('../../conexionSimple.php');
$sd=conectar();
$userid = $_POST["usuarioIDx"];
$documento = $_POST["movIDx"];
$estatus = $_POST["valorEstatusx"];

//echo $userid."-".$documento."-".$estatus;
$valoresAntx=sqlsrv_query($sd,"select pr.estatusidfk, es.nombre as nombreEstatus, es.tarea_referente, pr.facturaProv, pr.importeFacProv from tprovIntelisis as pr
inner join cestatus as es on (es.estatusid=pr.estatusidfk)
where pr.MovID = '".$documento."'");
$valAnt=sqlsrv_fetch_array($valoresAntx);

$valoresNuex=sqlsrv_query($sd,"select nombre from cestatus where estatusid = ".$estatus."");
$valNuevo=sqlsrv_fetch_array($valoresNuex);

$tablaCambios=sqlsrv_query($sd,"insert into tcambios(numeroDoc,ValorAnterior,valorNuevo,usuarioidfk,campo,fechaCambio)values(".$documento.",'".$valAnt["nombreEstatus"]."','".$valNuevo["nombre"]."',".$userid.",'estatusEntComp',getdate())");

$update=sqlsrv_query($sd,"update tprovIntelisis set estatusidfk = ".$estatus." where MovID = ".$documento."");

?>