<?php

//require 'vendor/autoload.php';
include("../conexionSimple.php");
$sd=conectar();
require './phpSpreadSheet/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$canProvx=sqlsrv_query($sd,"select distinct(proveedor) from tprovIntelisis order by proveedor asc");
while($canProv=sqlsrv_fetch_array($canProvx)){

    $datosUserx=sqlsrv_query($sd,"select * from cusuario where usuario = '".$canProv["proveedor"]."'");
    $datosUser=sqlsrv_fetch_array($datosUserx);
    if(isset($datosUser["correo"])){$correo=$datosUser["correo"];}

    $revisaArchivosx=sqlsrv_query($sd,"select COUNT(*) canArchivos from archivosProveedores as ap
    inner join cusuario as cu on (cu.usid=ap.usuarioidfk)
    where cu.usuario = ".$canProv["proveedor"]." and convert(char(10),fecha,120) BETWEEN convert(VARCHAR(10),GETDATE(),120) AND convert(VARCHAR(10),GETDATE(),120)");
    $revArc=sqlsrv_fetch_array($revisaArchivosx);

if($revArc["canArchivos"] > 0){

$datosx=sqlsrv_query($sd,"select tp.IDOC,tp.MovID,tp.ImporteEC,tp.importeFacProv,tp.estatusidfk, es.nombre nombreEstatus,tp.proveedor,tp.NombrePoveedor,convert(varchar(10),tp.fechaPago,103) fechaPago from tprovIntelisis as tp
inner join cestatus as es on (es.estatusid=tp.estatusidfk)
where proveedor = ".$canProv["proveedor"]." and tp.estatusidfk not in (5,10012) and convert(char(10),tp.fechaArchivo,120) BETWEEN convert(VARCHAR(10),GETDATE(),120) AND convert(VARCHAR(10),GETDATE(),120) order by fechaPago asc");


$mail = new PHPMailer(true);

$cuerpo = "<!DOCTYPE html>
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
  <div id='contenedor' style='float:center; width: 100%;'>
    <div align= 'center'><img id='tamexito' src ='cid:tamexito' alt='Tamex' width='180' height='180' align='center'/></div><br>
    <div align= 'center'><p><h3>Se ha Generado el contra recibo con los siguientes datos:</h3></p></div>
</br>
<table align= 'center' style='width:60%;'>
<thead>
   <tr style='font-size:14px; color:#e7e7e7; background-color:#142667'>
	<th align='center'>O.C.</th>
	<th align='center'>E.C.</th>
	<th align='center'>Fecha Revision</th>
	<th align='center'>Fecha Pago</th>
	<th align='center'>Importe E.C.</th>
	<th align='center'>Importe Total</th>
    <th align='center'>Facturas e Importes</th>
    <th align='center'>Estatus</th>
	<th align='center'>Documentos</th>
</tr> 
</thead>";
$color='#F2F6FE';
while($datos = sqlsrv_fetch_array($datosx)){
    if($color == '#F2F6FE'){$color = '#FAFBFC';}else{$color='#F2F6FE';}
    $fechaRevx=sqlsrv_query($sd,"select top(1)convert(varchar(10),fechaRevision,103) fechaRev from archivosProveedores where factura = ".$datos["MovID"]." order by fechaRevision desc");
    $fechaRev=sqlsrv_fetch_array($fechaRevx);

    $impTotalx=sqlsrv_query($sd,"select SUM(importe) importeTotal from tfacturaImporte where MovIDfk = ".$datos["MovID"]."");
    $impTotal=sqlsrv_fetch_array($impTotalx);

    $canAcusex=sqlsrv_query($sd,"select COUNT(*) cantidadAcuse from archivosProveedores where factura = ".$datos["MovID"]." and tipoArchivo = 'acuse'");
    $canAcuse=sqlsrv_fetch_array($canAcusex);
    $canFacturax=sqlsrv_query($sd,"select COUNT(*) cantidadFactura from archivosProveedores where factura = ".$datos["MovID"]." and tipoArchivo = 'factura'");
    $canFactura=sqlsrv_fetch_array($canFacturax);
    $canXmlx=sqlsrv_query($sd,"select COUNT(*) cantidadXml from archivosProveedores where factura = ".$datos["MovID"]." and tipoArchivo = 'xml'");
    $canXml=sqlsrv_fetch_array($canXmlx);

    $importeEC = number_format($datos["ImporteEC"], 2, '.', ',');
    $importeT = number_format($impTotal["importeTotal"], 2, '.', ',');

$cuerpo.="<tr style='font-size:12px; color:black; background-color: ".$color.";'>
<td align='center'>".$datos["IDOC"]."</td>
<td align='center'>".$datos["MovID"]."</td>
<td align='center'>".$fechaRev["fechaRev"]."</td>
<td align='center'>".$datos["fechaPago"]."</td>
<td align='center'>$ ".$importeEC."</td>
<td align='center'>$ ".$importeT."</td>
<td align='center'>";
$facturaseImportes = sqlsrv_query($sd,"select * from tfacturaImporte where MovIDfk = ".$datos["MovID"]." order by fechaIngreso desc");
while($rowFac = sqlsrv_fetch_array($facturaseImportes)){
    $impFac = number_format($rowFac["importe"], 2, '.', ',');
$cuerpo.="<b>".$rowFac["factura"]."</b>&nbsp;&nbsp; <b>$".$impFac."</b> <br>";
}
$cuerpo.="</td><td align='center'>".$datos["nombreEstatus"]."</td>
<td align='center'>".$canAcuse["cantidadAcuse"].": Acuses<br>
    ".$canFactura["cantidadFactura"].": Facturas<br>
    ".$canXml["cantidadXml"].": Xml s</td>";
}
$cuerpo.="</table></div><br><br>
&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;<h3>Saludos de equipo Tamex.</h3><br>

<h3 align='center'><i>Este correo es solo informativo, favor de no responder</i></3>
</body>
</html>";

try {
    $mail->SMTPDebug = 2;  // Sacar esta línea para no mostrar salida debug
    $mail->isSMTP();
    $mail->Host = 'smtp.tamex.mx';  // Host de conexión SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'longino.giral@tamex.mx';                 // Usuario SMTP
    $mail->Password = 'lU0vz*796';                           // Password SMTP
    $mail->SMTPSecure = 'ssl';                            // Activar seguridad TLS
    $mail->Port = 465;  //587, 995                              // Puerto SMTP

    #$mail->SMTPOptions = ['ssl'=> ['allow_self_signed' => true]];  // Descomentar si el servidor SMTP tiene un certificado autofirmado
    #$mail->SMTPSecure = false;				// Descomentar si se requiere desactivar cifrado (se suele usar en conjunto con la siguiente línea)
    #$mail->SMTPAutoTLS = false;			// Descomentar si se requiere desactivar completamente TLS (sin cifrado)
 
    $mail->setFrom('longino.giral@tamex.mx');		// Mail del remitente
    $mail->addAddress($correo);     // Mail del destinatario
    //$mail->addAddress('israel.vital@tamex.mx');
    //$mail->AddBCC("viridiana.pacheco@tamex.mx");
 
    $mail->isHTML(true);
    $mail->AddEmbeddedImage('tamexito.jpeg', 'tamexito');
    $mail->Subject = 'Cuentas por Pagar TAMEX';  // Asunto del mensaje Sistema Tamex para: CONDUIT, S.A. DE C.V. (Correo de Prueba)
    $mail->Body    = $cuerpo;    // Contenido del mensaje (acepta HTML)
    //$mail->AltBody = 'Este es el contenido del mensaje en texto plano';    // Contenido del mensaje alternativo (texto plano)
 
    $mail->send();
    echo 'El mensaje ha sido enviado';
} catch (Exception $e) {
    echo 'El mensaje no se ha podido enviar, error: ', $mail->ErrorInfo;
}
}// Fin archivos > 0
}// Fin while