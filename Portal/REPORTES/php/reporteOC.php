<?php
require ('permiso.php');
//session_start();
include('../../conexionSimple.php');
$sd=conectar();

$usuarioid = $_POST["usuarioIDx"];
//$ordenC = $_POST["ordenCx"];
//$entradaCom = $_POST["entradaComx"];
$proveedor = $_POST["proveedorx"];
$estatus = $_POST["selectedx"];
$fechaInicial = $_POST["fechaInix"];
$fechaFin = $_POST["fechaFinx"];
$tipoFecha = $_POST["tipoFechax"];

$arr = explode(',', $estatus);
if($arr[0]=='%'){$estatusCompleto = "estatusidfk like '%'";}else{$estatusCompleto = "estatusidfk in (".$estatus.")";}

//echo $usuarioid."--".$proveedor."-------".$estatus."--".$estatusCompleto."-------".$fechaInicial."--".$fechaFin; return -1;
/*if($ordenC != 0 || $entradaCom != 0){
	if($ordenC != 0){$busqRegistro=sqlsrv_query($sd,"select IDOC,Documento,proveedor,NombrePoveedor,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv,convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where IDOC like '%".$ordenC."%' order by FechaEmision desc");}
	else{$busqRegistro=sqlsrv_query($sd,"select IDOC,Documento,proveedor,NombrePoveedor,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv,convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where MovID like '%".$entradaCom."%'");}
}else{*/
	if($fechaInicial == '' || $fechaFin == ''){
		$busqRegistro=sqlsrv_query($sd,"select top(400) IDOC,Documento,proveedor,NombrePoveedor,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where ".$estatusCompleto." and proveedor like '".$proveedor."' order by FechaEmision desc, IDOC");
		//echo"Entra con estatus";
	}else{
		$busqRegistro=sqlsrv_query($sd,"select top(400) IDOC,Documento,proveedor,moneda,NombrePoveedor,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu, convert(varchar(10),fechaPago,103) fechapago from tprovIntelisis
		where ".$estatusCompleto." and proveedor like '".$proveedor."' and convert(char(10),".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicial."',120) AND convert(VARCHAR(10),'".$fechaFin."',120)
		 order by ".$tipoFecha." desc, IDOC");
		 //echo"Entra con fechas".$fechaInicial."--".$fechaFin;
	}
	
echo"

<table id='tablaProv' border='0.8' cellspacing='1' cellpadding='5' align= 'center' style='width:100%; border:0px;'>
					<thead style='position: sticky; top: 0;'>
		   			<tr class='tituloTablas'>
					    <th align='center'>Orden de Compra</th>
					    <th align='center'>Documento</th>
                        <th align='center'>Proveedor</th>
					    <th align='center'>Fecha Emision</th>
						<th align='center'>Almacen</th>
						<th align='center'>Referencia</th>
						<th align='center'>Valor OC</th>
						<th align='center'>Valor EC</th>
                        <th align='center'>Moneda</th>
						<th align='center'>Condicion</th>
						<th align='center'>Fecha Carga Archivo</th>
						<th align='center'>Fecha de Revision</th>
						<th align='center'>Fecha Aprox de Pago</th>
						<th align='center'>Estatus</th>
						<th align='center'>Importe Total</th>
						<th align='center'>Comentarios Tamex</th>
						<th align='center'>Comentarios Proveedor</th>
						<th align='center'>PDF</th>
						<th align='center'>Archivos Adjuntos</th>
					</tr> 
					</thead>";
					$color='#F2F6FE'; //#D6EAF8 #ABB2B9
					while ($res = sqlsrv_fetch_array($busqRegistro)){  
						$estatusDocx = sqlsrv_query($sd,"select * from cestatus where estatusid = ".$res["estatusidfk"]."");
						$estatusDoc = sqlsrv_fetch_array($estatusDocx);
						$nomEstatus = $estatusDoc["nombre"];
						$importeTotalx=sqlsrv_query($sd,"select SUM(importe) sumaImporte from tfacturaImporte where MovIDfk = ".$res["MovID"]."");
						$rowImp=sqlsrv_fetch_array($importeTotalx);

						$datArchx=sqlsrv_query($sd,"select convert(varchar(10),fecha,103) fechaIngresoDoc, convert(varchar(10),fechaRevision,103) fechaRevisionDoc, convert(varchar(10),fechaTenPago,103) fechaTenPago, nombreDiaIngreso, nombreDiaPago from archivosProveedores where factura = '".$res["MovID"]."' and estatusidfk = 3 order by fecha desc");
                        $datArch=sqlsrv_fetch_array($datArchx);
						if(isset($datArch["fechaIngresoDoc"])){$fechaArchivo = $datArch["fechaIngresoDoc"]; $nomDiaIngreso = $datArch["nombreDiaIngreso"];}else{$fechaArchivo = ''; $nomDiaIngreso = '';}
						if(isset($datArch["fechaRevisionDoc"])){$fechaRevArchivo = $datArch["fechaRevisionDoc"]; $nomDiaRev = 'MIERCOLES';}else{$fechaRevArchivo = ''; $nomDiaRev = '';}
						if(isset($datArch["fechaTenPago"])){$fechaPago = $datArch["fechaTenPago"]; $nomDiaPago = $datArch["nombreDiaPago"];}else{$fechaPago = ''; $nomDiaPago = '';}

						if($color == '#F2F6FE'){$color = '#FAFBFC';}else{$color='#F2F6FE';}//#E6F3EC--#B5D4C5 #ABB2B9
						if($res["estatusidfk"]==10012){$colorLetra='#FF5733';}else{$colorLetra = '#030100';}
						// notación francesa
					$valorOC = number_format($res["ImporteOC"], 2, '.', ',');
					$valorEC = number_format($res["ImporteEC"], 2, '.', ',');
					$importeFacProv = number_format($rowImp["sumaImporte"], 2, '.', ',');
                echo"<tr style='font-size:12px; color:".$colorLetra."; background-color: ".$color.";'>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["IDOC"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Documento"]."</td>
                <td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["proveedor"]." ".$res["NombrePoveedor"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["FechaEmi"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Almacen"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Referencia"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>$".$valorOC."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>$".$valorEC."</td>
                <td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["moneda"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Condicion"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$nomDiaIngreso."<br> ".$fechaArchivo."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$nomDiaRev."<br> ".$fechaRevArchivo."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$nomDiaPago."<br> ".$fechaPago."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'><span id='tdEstatus".$res["MovID"]."'>".$nomEstatus."</estatus></td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'><span id='tdImporteTotal".$res["MovID"]."'>$".$importeFacProv."</td>
				<td align='center'><textarea readonly style='border:none;background:#F5F5F5' value = ".$res["comentariosTamex"].">".$res["comentariosTamex"]."</textarea></td>
				<td align='center'><textarea readonly style='border:none;background:#F5F5F5' id='comProv".$res["MovID"]."'>".$res["comentariosProv"]."</textarea></td>
				<td align='center'><input type='button' class='buttonDetalle' value='Ver PDF' title='PDF' onclick='detallePdf(".$res["MovID"].");'></td>
				<td align='center' class='span'><span id='spanSubMulti' title='Ver PDF-XML' class='spanhover' onClick='abrirMultiupload(".$res["MovID"].");'>Ver Documentos</span></td>";
				}
				echo"
			</tr>";
					

?>