<?php
require ('permiso.php');
include('../../conexionSimple.php');
$sd=conectar();

$userid = $_POST["usuarioidx"];
$documento = $_POST["movIDx"];
$factura = $_POST["facturax"];
$importe = $_POST["importex"];
$contador = $_POST["contadorx"];

if($factura=='' || $factura==' '){echo"facturaVacia"; return -1;}
if($userid==0 || $userid=='' || $userid==' '){echo "sinUser"; return -1;}

//$formato = number_format($importe, 2, '.', ',');
//$formato = floatval(preg_replace("/[^0-9]/", "", $importe));
$formato = (double)filter_var($importe, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
//echo $formato."-".$var; return -1;

//echo $userid."-".$documento."-".$factura."-".$importe."-".$contador; return -1;
$revContx=sqlsrv_query($sd,"select * from tfacturaImporte where MovIDfk = ".$documento." and cont = ".$contador."");
$revCont=sqlsrv_fetch_array($revContx);
if($revCont["cont"]==$contador){
    $update = sqlsrv_query($sd,"update tfacturaImporte set factura = '".$factura."', importe = '".$formato."' where MovIDfk = ".$documento." and cont = ".$contador."");
}else{
    $insert = sqlsrv_query($sd,"insert into tfacturaImporte (factura,importe,MovIDfk,usuarioidfk,fechaIngreso,cont)values('".$factura."','".$formato."',".$documento.",".$userid.",GETDATE(),".$contador.")");
}

/*$valoresAntx=sqlsrv_query($sd,"select pr.estatusidfk, es.nombre as nombreEstatus, es.tarea_referente, pr.facturaProv, pr.importeFacProv from tprovIntelisis as pr
inner join cestatus as es on (es.estatusid=pr.estatusidfk)
where pr.MovID = '".$documento."'");
$valAnt=sqlsrv_fetch_array($valoresAntx);

if($valAnt["facturaProv"]=='' || $valAnt["facturaProv"]==' ' || $valAnt["facturaProv"]=='NULL' || $valAnt["facturaProv"]==NULL){$valAnt["facturaProv"]='SinValor';}
if($valAnt["importeFacProv"]=='' || $valAnt["importeFacProv"]==' ' || $valAnt["importeFacProv"]=='NULL' || $valAnt["importeFacProv"]==NULL){$valAnt["importeFacProv"]=0;}

$tablaCambios=sqlsrv_query($sd,"insert into tcambios(numeroDoc,ValorAnterior,valorNuevo,usuarioidfk,campo,fechaCambio)values(".$documento.",'".$valAnt["facturaProv"]."|".$valAnt["importeFacProv"]."','".$factura."|".$formato."',".$userid.",'facturaImporte',getdate())");
*/
$facx = sqlsrv_query($sd,"select * from tfacturaImporte where MovIDfk = ".$documento." order by fechaIngreso asc");

echo"||<table width='100%'>
                <tr>
                <th>Factura</th>
                <th>Importe</th>
                </tr>";
                $impTotal = 0;
                $num=0;
                while($rowFac = sqlsrv_fetch_array($facx)){
                    $num ++;
                    $impTotal = $impTotal + $rowFac["importe"];
                    $importeTotal = number_format($impTotal, 2, '.', ',');
                    $importe = number_format($rowFac["importe"], 2, '.', ',');
                    echo"<tr>
                    <td>".$num." ".$rowFac["factura"]."</td>
                    <td>$".$importe."</td>
                    </tr>";
                }
                echo"</table><hr>
                <table width='100%'>
                <tr><td>Importe Total:</td><td> $".$importeTotal."</td></tr></table>";

?>