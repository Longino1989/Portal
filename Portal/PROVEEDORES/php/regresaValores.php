<?php 
include("../../conexionSimple.php");
$sd=conectar();

$documento = $_POST["docx"];

//echo $documento; //return -1;
    
$query = sqlsrv_query($sd,"select convert(varchar(10),ar.fecha,103) fechaIng, ar.nombreDiaIngreso, convert(varchar(10),ar.fechaRevision,103) fechaRev, convert(varchar(10),ar.fechaTenPago,103) fechaPago, ar.nombreDiaPago, pr.MovID, est.nombre nombreEstatus from tprovIntelisis as pr
inner join archivosProveedores as ar on (ar.factura=pr.MovID)
inner join cestatus as est on (est.estatusid=pr.estatusidfk)
where pr.MovID = '".$documento."' and ar.estatusidfk = 3 order by ar.fecha desc");
//
$row = sqlsrv_fetch_array($query);
$fechaIngreso = $row["nombreDiaIngreso"]."<br>".$row["fechaIng"];
if($row["fechaRev"]=='' || $row["fechaRev"]==' ' || $row["fechaRev"]=='NULL' || $row["fechaRev"]==NULL){$fechaRevision = "".$row["fechaRev"];}else{$fechaRevision = "MIERCOLES <br>".$row["fechaRev"];}
$fechaPago = $row["nombreDiaPago"]."<br>".$row["fechaPago"];
if($row["nombreEstatus"]=='' || $row["nombreEstatus"]==' ' || $row["nombreEstatus"]=='NULL' || $row["nombreEstatus"]==NULL){$row["nombreEstatus"]='Pendiente';}
echo "||".$fechaIngreso."||".$fechaRevision."||".$fechaPago."||".$row["nombreEstatus"]."";
?>