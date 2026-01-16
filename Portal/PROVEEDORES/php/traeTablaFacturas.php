<?php
require ('permiso.php');
include('../../conexionSimple.php');
$sd=conectar();

$documento = $_POST["movIDx"];

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