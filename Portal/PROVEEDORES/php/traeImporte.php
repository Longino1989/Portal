<?php
include("../../conexionSimple.php");
$sd=conectar();
$documento = $_POST["movIDx"];

//echo "|".$documento."|"; return -1;

$importeTotalx = sqlsrv_query($sd,"select SUM(importe) sumaImporte from tfacturaImporte where MovIDfk = ".$documento."");
$rowImp=sqlsrv_fetch_array($importeTotalx);

$importeTotal = number_format($rowImp["sumaImporte"], 2, '.', ',');

echo"||$".$importeTotal."";
?>