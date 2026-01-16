<?php
require ('permiso.php');
include("../../conexionSimple.php");
$sd=conectar();

$documento = $_POST["movIDx"];
$userID = $_POST["usuarioidx"];

//echo $userID."--".$documento; return -1;

$rowsAcusex = sqlsrv_query($sd,"select COUNT(*) numacuse from archivosProveedores where factura = ".$documento." and estatusidfk = 3 and tipoArchivo = 'acuse'");
$rowAcuse = sqlsrv_fetch_array($rowsAcusex);
if($rowAcuse["numacuse"] >= 1){$acuse = 'Acuse';}else{$acuse = 'sinAcuse'; echo $acuse;}

$rowsFacturasx = sqlsrv_query($sd,"select COUNT(*) numfactura from archivosProveedores where factura = ".$documento." and estatusidfk = 3 and tipoArchivo = 'factura'");
$rowFactura = sqlsrv_fetch_array($rowsFacturasx);
if($rowFactura["numfactura"] >= 1){$factura = 'Factura';}else{$factura = 'sinFactura'; echo $factura;}

$rowsXmlx = sqlsrv_query($sd,"select COUNT(*) numxml from archivosProveedores where factura = ".$documento." and estatusidfk = 3 and tipoArchivo = 'xml'");
$rowXml = sqlsrv_fetch_array($rowsXmlx);
if($rowXml["numxml"] >= 1){$xml = 'xml';}else{$xml = 'sinXml'; echo $xml;}

if($acuse == 'Acuse' && $factura == 'Factura' && $xml == 'xml'){echo json_encode(true);}else{
    echo json_encode(false);
}

?>