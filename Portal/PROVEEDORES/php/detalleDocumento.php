<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
	</head>
	<body>
</body>
</html>
<?php
$usuarioid = base64_decode($_GET["dXNlclRhbWV4"]);
$ID = base64_decode($_GET["T3JkZW5Db21w"]);

require ('permiso.php');
include('../../conexionSimple.php');
$sd=conectar();

//echo $usuarioid." ".$ID

$datosPartida=sqlsrv_query($sd,"select td.*,tp.Documento from tpartidasXdocIntelisis as td 
inner join tprovIntelisis as tp on (tp.ID=td.IDfk)
where td.IDfk = ".$ID."");
echo"
<table id='tablaDetalle' border='0.8' cellspacing='1' cellpadding='5' align= 'center' style='width:100%; border:0px;'>
					<thead>
		   			<tr class='tituloTablas'>
					<th align='Center'>No.</th>
					    <th align='center'>Articulo</th>
					    <th align='center'>Descripcion</th>
						<th align='center'>Origen</th>
						<th align='center'>Costo</th>
						<th align='center'>Cantidad</th>
						<th align='center'>Descuento</th>
						<th align='center'>Importe</th>
						<th align='center'>Moneda</th>						
						<th align='center'>Impuesto</th>
						<th align='center'>Descripcion Extra</th>
					</tr> 
					</thead>";
					$color='#F2F6FE'; 
					$num=0;
					while ($res = sqlsrv_fetch_array($datosPartida)){  
						$num ++;
						if($color == '#F2F6FE'){$color = '#FAFBFC';}else{$color='#F2F6FE';}
						if($res["Importe"]=='' || $res["Importe"]==' ' || $res["Importe"]=='NULL' || $res["Importe"]==NULL){$res["Importe"]=0;}
						if($res["Costo"]=='' || $res["Costo"]==' ' || $res["Costo"]=='NULL' || $res["Costo"]==NULL){$res["Costo"]=0;}
						if($res["Descuento"]=='' || $res["Descuento"]==' ' || $res["Descuento"]=='NULL' || $res["Descuento"]==NULL){$res["Descuento"]=0;}
						$importe = number_format($res["Importe"], 2, '.', ',');
						$costo = number_format($res["Costo"], 2, '.', ',');						
						$descuento = number_format($res["Descuento"], 2, '.', ',');
                	echo"<tr style='font-size:14px; color:black; background-color: ".$color."'>
							<td align='center'>".$num."</td>
							<td align='center'>".$res["Articulo"]."</td>
							<td align='center'>".$res["Descripcion"]."</td>
							<td align='center'>".$res["Origen"]."</td>
							<td align='center'>$".$costo."</td>
							<td align='center'>".$res["Cantidad"]." ".$res["Unidad"]."</td>
							<td align='center'>$".$descuento."</td>							
							<td align='center'>$".$importe."</td>
							<td align='center'>".$res["Moneda"]."</td>
							<td align='center'>".$res["Impuesto1"]."</td>
							<td align='center'>".$res["DescripcionExtra"]."</td>
						</tr>";
                    }
?>