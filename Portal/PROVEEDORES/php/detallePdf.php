<?php
include_once "../../vistas/dompdf/vendor/autoload.php";

$usuarioid = base64_decode($_GET["dXNlclRhbWV4"]);
$ID = base64_decode($_GET["T3JkZW5Db21w"]);

require ('permiso.php');
include('../../conexionSimple.php');
$sd=conectar();

$datosDocx=sqlsrv_query($sd,"select * from tprovIntelisis where MovID = ".$ID."");
$datosDoc=sqlsrv_fetch_array($datosDocx);
$estatus = $datosDoc["estatusidfk"];
if($estatus==10012){$movIDCancelada = "<font color='#FF5733'><s>".$ID."</s></font>";}else{$movIDCancelada = "<font color='#142567'>".$ID."</font>";}

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$nombreImagen = "../imgs/PDFBanner.jpeg";
$imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));

$html = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
</head>
<body>
<style>
    .heading { color: #142667; }

    table { border: 0.1px; 
      border-collapse: collapse; 
      width: 100%;} 
td { border: 0.1px;} 
colgroup { background-color : #211915; 
         text-align: center;}

  </style>

<img src ='".$imagenBase64."' width='730' height='200'/> 
<h1 align='right'>".$movIDCancelada."&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;</h1>

<table> 
<colgroup span='2'></colgroup> 
<tr> 
<td><b>Proveedor: </b></td> <td>".$datosDoc["NombrePoveedor"]."</td><td><b>Referencia: </b></td><td>".$datosDoc["Referencia"]."</td>
</tr>
<tr>
<td><b>Direccion: </b></td><td>".$datosDoc["Direccion"]."</td>
<td><b>Condicion: </b></td><td>".$datosDoc["Condicion"]."</td>
</tr>
<tr>
<td><b>Colonia: </b></td><td>".$datosDoc["Colonia"]."</td>
<td><b>LAB: </b></td><td>".$datosDoc[""]."</td>
</tr>
<tr>
<td><b>Delegacion:</b></td><td>".$datosDoc["Delegacion"]."</td>
<td><b>Almacen:</b></td><td>".$datosDoc["Almacen"]."</td>
</tr>
<tr>
<td><b>CP: </b></td><td>".$datosDoc["CodigoPostal"]."</td>
</tr> 
</table>
<hr style = 'background-color:#142667'>
<table align= 'center'>
<thead>
		   			<tr style='font-size:14px; color:black; font-weight: bold;' align= 'center'>
            <td>Parte</td>
            <td>Articulo</td>
            <td>Descripcion</td>
            <th>Costo</th>
            <td>Cantidad</td>
            <th>Descuento</th>
            <th>Importe</th>
            <th>Moneda</th>
            <th>Impuesto</th>
            </tr>
<thead>";
$color='#F2F6FE';
$datosParx=sqlsrv_query($sd,"select * from tpartidasXdocIntelisis where IDfk = ".$datosDoc["ID"]."");
$num=0;
while ($res = sqlsrv_fetch_array($datosParx)){
  if($color == '#F2F6FE'){$color = '#FAFBFC';}else{$color='#F2F6FE';}
  if($res["Importe"]=='' || $res["Importe"]==' ' || $res["Importe"]=='NULL' || $res["Importe"]==NULL){$res["Importe"]=0;}
	if($res["Costo"]=='' || $res["Costo"]==' ' || $res["Costo"]=='NULL' || $res["Costo"]==NULL){$res["Costo"]=0;}
	if($res["Descuento"]=='' || $res["Descuento"]==' ' || $res["Descuento"]=='NULL' || $res["Descuento"]==NULL){$res["Descuento"]=0;}
						$importe = number_format($res["Importe"], 2, '.', ',');
						$costo = number_format($res["Costo"], 2, '.', ',');						
						$descuento = number_format($res["Descuento"], 2, '.', ',');
  $num++;
  $html.="<tr style='font-size:12px; color:black; background-color: ".$color."'>
        <td align='center'>".$num."</td>
				<td align='center'>".$res["Articulo"]."</td>
        <td align='center'>".$res["Descripcion"]."</td>
        <td align='center'>$".$costo."</td>
				<td align='center'>".$res["Cantidad"]." ".$res["Unidad"]."</td>
        <td align='center'>$".$descuento."</td>
        <td align='center'>$".$importe."</td>
        <td align='center'>".$res["Moneda"]."</td>
        <td align='center'>".$res["Impuesto1"]."</td>
</tr>";
  }
$html.="
</table>
</body>
</html>";

$dompdf->loadHtml($html);
$dompdf->render();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=EntradaCompra-".$ID.".pdf");
echo $dompdf->output();


?>