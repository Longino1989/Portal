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

if (is_numeric($usuarioid)) {
    //echo " sesion activa", PHP_EOL;
} else {
    echo " sesion caducada, Actualizar pagina principar con F5 o cerrar y abrir sesion", PHP_EOL; return -1;
}

//echo $usuarioid."-".$doc."-".$estatus;
echo"
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Transferencia de archivos</title>
    <script type='text/javascript' src='js/jquery-1.4.4.min.js' ></script>
    <script type='text/javascript' src='js/jquery.datePicker.js'></script>
    <script type='text/javascript' src='../../PROVEEDORES/js/funcionesPro.js'></script>
    <script src = 'https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
    <link rel='stylesheet' href='estilosMultiupload.css'>
    <link rel='stylesheet' href='https://unpkg.com/bootstrap@4.1.0/dist/css/bootstrap.min.css'>
</head>
<body onload = 'lanzadera(".$doc.",".$usuarioid.")'>
    <div class='container'>
    <h2>Archivos del Documento <font color='".$color."'>".$doc."&nbsp;&nbsp;&nbsp;&nbsp;</font><font color='".$color."'>".$cancelado."</font> </h2>
        <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
            <p>
                <hr width=100% size=10 noshade='noshade' color='#142667'>
            </p>
                <fieldset class='border p-2'>
                <legend  class='w-auto'><h3>Transferir <STRONG>Acuses</STRONG></h3></legend>";
                if($estatus == 9 || $estatus == 10012){}else{echo"<div class='form-group'>
                    <input multiple type='file' class='form-control' id='inputArchivosAcuse'>
                    <br><br>
                    <button id='btnEnviarAcuse' class='btn btn-success'>Enviar</button><br>
                    <p></p>
                    <input id='documento' type='hidden' value=".$doc.">
                    <input id='usuario' type='hidden' value=".$usuarioid.">
                </div>";}
                echo"
                <div class='alert alert-info' id='estadoAcuse'></div>
                <fieldset class='border p-2'>
                <legend  class='w-auto'><h5>Acuses Transferidos</h5></legend>
                <ul id='filesAcuse' ></ul></fieldset>
                </fieldset>

                <p>
                <hr width=100% size=10 noshade='noshade' color='#142667'>
                </p>

                <fieldset class='border p-2'>
                <legend  class='w-auto'><h3>Transferir <STRONG>Facturas</STRONG></h3></legend>";
                if($estatus == 9 || $estatus == 10012){}else{
                    echo"<div class='form-group'>
                    <input multiple type='file' class='form-control' id='inputArchivosFactura'>
                    <br><br>
                    <button id='btnEnviarFactura' class='btn btn-success'>Enviar</button><br>
                    <p></p>
                    <input id='documentoFactura' type='hidden' value=".$doc.">
                    <input id='usuarioFactura' type='hidden' value=".$usuarioid.">
                </div>";
                }
                echo"
                <div class='alert alert-info' id='estadoFactura'></div>
                <fieldset class='border p-2'>
                <legend  class='w-auto'><h5>Facturas Transferidas</h5></legend>
                <ul id='filesFactura' ></ul></fieldset>
                <fieldset class='border p-2'>
                <legend  class='w-auto'><h5>Captura de Facturas</h5></legend>

                <div id='divTablaFacturas".$doc."'><table width='100%'>
                <tr>
                <th>Factura</th>
                <th>Importe</th>
                </tr>";
                $facx = sqlsrv_query($sd,"select * from tfacturaImporte where MovIDfk = ".$doc." order by fechaIngreso asc");
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
                if(isset($importeTotal)){$importeTotal = $importeTotal;}else{$importeTotal=0.00;}
                $bandera = $num + 1;
                $contador = $bandera +1;
                echo"</table>
                <hr>
                <table width='100%'>
                <tr><td>Importe Total:</td><td> $".$importeTotal."</td></tr></table></div>";
                //if($estatus == 9 || $estatus == 10012){}else{
                    echo"<!--<table id='tablaNuevoRegistro".$doc."' width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px; text-align: center;'>
                    <hr>
                    <tr>
                    <td><input placeholder='Ingresa Factura...' id='factura".$doc."".$bandera."' /></td>
                    <td><input placeholder='$0.00' id='importe".$doc."".$bandera."' onkeypress='mascara(this,cpf)'/></td>
                    <td><img src='imgs/guardarpequeno.bmp' id='guardarDatos".$doc."' style='cursor:pointer'; title='Guardar Factura e Importe' onclick='guardaFacturaImporte(".$doc.",factura".$doc."".$bandera.".value,importe".$doc."".$bandera.".value,".$bandera.");'/></td>
                    </tr>
                    </table>
                    <table width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px'>
                    <tr>
                          <td></td>
                          <td><input name='".$contador."' size='5' id='contadorInput".$doc."' maxlength='6' onFocus='agregarFila(\"".$doc."\");' value='nuevo' class='nuevoTR'/></td>
                    </tr>
                    
                    </table>-->";//}
                

            echo"
                <!--<button id='btnGuardaFac' class='btn btn-secondary btn-sm' onclick='enviaFacturas(1,\"".$doc."\");'>Enviar</button>-->
                </fieldset>
                </fieldset>

                <p>
                <hr width=100% size=10 noshade='noshade' color='#142667'>
                </p>

                <fieldset class='border p-2'>
                <legend  class='w-auto'><h3>Transferir <STRONG>XML</STRONG></h3></legend>";
                if($estatus == 9 || $estatus == 10012){}else{echo"<div class='form-group'>
                    <input multiple type='file' class='form-control' id='inputArchivosXml'>
                    <br><br>
                    <button id='btnEnviarXml' class='btn btn-success'>Enviar</button><br>
                    <p></p>
                    <input id='documentoXml' type='hidden' value=".$doc.">
                    <input id='usuarioXml' type='hidden' value=".$usuarioid.">
                </div>";}
                echo"
                <div class='alert alert-info' id='estadoXml'></div>
                <fieldset class='border p-2'>
                <legend  class='w-auto'><h5>XML Transferidos</h5></legend>
                <ul id='filesXml' ></ul></fieldset>
                </fieldset>
                
                <div class='card-body d-flex justify-content-between align-items-center'>
                <!--<button id='generaAcuse' class='btn btn-info btn-sm' onclick='enviaAcuse(\"".$doc."\")'>Envia Acuse</button>-->
                
                </div>
            </div>
        </div>
    </div>
    <script src='scriptPro.js'>
    </script>
</body>
</html>";
?>
