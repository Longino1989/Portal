<?php
$doc = base64_decode($_GET["T3JkZW5Db21w"]);
$usuarioid = base64_decode($_GET["dXNlclRhbWV4"]);
include("../../conexionSimple.php");
$sd=conectar();

$obtValx=sqlsrv_query($sd,"select tp.MovID,tp.estatusidfk,ce.nombre nombreEstatus from tprovIntelisis as tp
inner join cestatus as ce on (ce.estatusid=tp.estatusidfk)
where tp.MovID = ".$doc."");
$rowVal = sqlsrv_fetch_array($obtValx);
$estatus = $rowVal["estatusidfk"];
if($estatus==10012){$cancelado = "CANCELADA (Favor de buscar la nueva E.C.)"; $color="#FF5733";}else{$cancelado=''; $color="#142567";}

$facx = sqlsrv_query($sd,"select * from tfacturaImporte where MovIDfk = ".$doc." order by fechaIngreso asc");

//echo $usuarioid."-".$doc;
echo"
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Transferencia de archivos</title>
    <script type='text/javascript' src='js/jquery-1.4.4.min.js' ></script>
    <script type='text/javascript' src='js/ajaxupload.3.5.js' ></script>
    <link rel='stylesheet' href='https://unpkg.com/bootstrap@4.1.0/dist/css/bootstrap.min.css'>
    <script type='text/javascript' >

    </script>
</head>
<body onload = 'lanzadera(".$doc.",".$usuarioid.");'>
    <div class='container'>
    <h2>Archivos del Documento <font color='".$color."'>".$doc."&nbsp;&nbsp;&nbsp;&nbsp;".$cancelado."</font> </h2>
        <div class='row'>
            <div class='col-10'>
            <p>
                <hr width=100% size=10 noshade='noshade' color='#142667'>
            </p>
                <fieldset class='border p-2'>
                <legend  class='w-auto'><h3><STRONG>Acuses</STRONG></h3></legend>
                
                <div class='form-group'>
                </div>
                <ul id='filesAcuse' ></ul>
                </fieldset>

                <p>
                <hr width=100% size=10 noshade='noshade' color='#142667'>
                </p>

                <fieldset class='border p-2'>
                <legend  class='w-auto'><h3> <STRONG>Facturas</STRONG></h3></legend>
                
                <div class='form-group'>
                </div>
                <ul id='filesFactura' ></ul>
                <fieldset class='border p-2'>
                <legend  class='w-auto'><h5>Facturas Capturadas</h5></legend>
                <div id='divTablaFacturas".$doc."'><table width='100%'>
                <tr>
                <th>Factura</th>
                <th>Importe</th>
                </tr>";
                $impTotal = 0;
                while($rowFac = sqlsrv_fetch_array($facx)){
                    $impTotal = $impTotal + $rowFac["importe"];
                    $importeTotal = number_format($impTotal, 2, '.', ',');
                    $importe = number_format($rowFac["importe"], 2, '.', ',');
                    echo"<tr>
                    <td>".$rowFac["factura"]."</td>
                    <td>$".$importe."</td>
                    </tr>";
                }if(isset($importeTotal)){$importeTotal = $importeTotal;}else{$importeTotal=0.00;}
                echo"</table>
                <hr>
                <table width='100%'>
                <tr><td>Importe Total:</td><td> $".$importeTotal."</td></tr></table></div>
                </fieldset>

                <p>
                <hr width=100% size=10 noshade='noshade' color='#142667'>
                </p>

                <fieldset class='border p-2'>
                <legend  class='w-auto'><h3> <STRONG>XML</STRONG></h3></legend>
                
                <div class='form-group'>
                </div>
                <ul id='filesXml' ></ul>
                </fieldset>
            </div>
        </div>
    </div>
    <script src='scriptCtas.js'></script>
</body>
</html>";

?>