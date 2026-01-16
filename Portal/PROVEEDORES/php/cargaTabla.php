<?php
require ('permiso.php');
//session_start();
include('../../conexionSimple.php');
$sd=conectar();

$usuarioid = $_POST["usuarioIDx"];
$ordenC = $_POST["ordenCx"];
$entradaCom = $_POST["entradaComx"];
$estatus = $_POST["estatusx"];
$provID = $_POST["proveedorx"];
$fechaInicial = $_POST["fechaInix"];
$fechaFin = $_POST["fechaFinx"];
$tipoFecha = $_POST["tipoFechax"];

//echo $usuarioid."--".$ordenC."--".$entradaCom."--".$estatus."--".$provID."--".$fechaInicial."--".$fechaFin; return -1;
$datosUserx=sqlsrv_query($sd,"select * from cusuario where usid = ".$usuarioid."");
$datosUser=sqlsrv_fetch_array($datosUserx);
if($datosUser["area"] == 'Administrador'){

	if($ordenC != 0 || $entradaCom != 0){
		if($ordenC != 0){$busqRegistro=sqlsrv_query($sd,"select IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv,convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where IDOC like '%".$ordenC."%' and proveedor like '".$provID."' order by FechaEmision desc");}
		else{$busqRegistro=sqlsrv_query($sd,"select IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv,convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where MovID like '%".$entradaCom."%' and proveedor like '".$provID."'");}
	}else{
		if($fechaInicial == '' || $fechaFin == ''){
			$busqRegistro=sqlsrv_query($sd,"select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where estatusidfk like '".$estatus."' and proveedor like '".$provID."' order by FechaEmision desc, IDOC");
			//echo"Entra con estatus";
		}else{
			$busqRegistro=sqlsrv_query($sd,"select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu, convert(varchar(10),fechaPago,103) fechapago from tprovIntelisis
			where estatusidfk like '".$estatus."' and convert(char(10),".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicial."',120) AND convert(VARCHAR(10),'".$fechaFin."',120) and proveedor like '".$provID."'
			order by ".$tipoFecha." desc, IDOC");
			 //echo"Entra con fechas".$fechaInicial."--".$fechaFin;
		}
		
	}
}else{
	if($ordenC != 0 || $entradaCom != 0){
		if($ordenC != 0){$busqRegistro=sqlsrv_query($sd,"select IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv,convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where IDOC like '%".$ordenC."%' and proveedor = '".$datosUser["usuario"]."' order by FechaEmision desc");}
		else{$busqRegistro=sqlsrv_query($sd,"select IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv,convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where MovID like '%".$entradaCom."%'");}
	}else{
		if($fechaInicial == '' || $fechaFin == ''){
			$busqRegistro=sqlsrv_query($sd,"select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where estatusidfk like '".$estatus."' and proveedor = '".$datosUser["usuario"]."' order by FechaEmision desc, IDOC");
			//echo"Entra con estatus";
		}else{
			$busqRegistro=sqlsrv_query($sd,"select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,Condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu, convert(varchar(10),fechaPago,103) fechapago from tprovIntelisis
			where estatusidfk like '".$estatus."' and convert(char(10),".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicial."',120) AND convert(VARCHAR(10),'".$fechaFin."',120) and proveedor = '".$datosUser["usuario"]."'
			order by ".$tipoFecha." desc, IDOC");
			 //echo"Entra con fechas".$fechaInicial."--".$fechaFin;
		}
		
	}
}
echo"

<table id='tablaProv' border='0.8' cellspacing='1' cellpadding='5' align = 'center' style='width:100%; border:0px;'>
					<thead style='position: sticky; top: 0;'>
		   			<tr class='tituloTablas'>
					    <th align='center'>Orden de Compra</th>
					    <th align='center'>Documento</th>
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
						<th align='center'>Comentarios Proveedor</th>";
						if($estatus == '%' || $ordenC != 0 || $entradaCom != 0){echo"<th align='center'>Comentarios</th>";}
						else if($estatus == 9){}else{echo"
						<th align='center'>Comentarios</th>";}
						echo"<th align='center'>PDF</th>
						<th align='center'>Carga de Archivos</th>
					</tr> 
					</thead>";
					$color='#F2F6FE'; //#D6EAF8 #ABB2B9
					while ($res = sqlsrv_fetch_array($busqRegistro)){  
						$estatusDocx = sqlsrv_query($sd,"select * from cestatus where estatusid = ".$res["estatusidfk"]."");
						$estatusDoc = sqlsrv_fetch_array($estatusDocx);
						$nomEstatus = $estatusDoc["nombre"];
						$importeTotalx=sqlsrv_query($sd,"select SUM(importe) sumaImporte from tfacturaImporte where MovIDfk = ".$res["MovID"]."");
						$rowImp=sqlsrv_fetch_array($importeTotalx);

						$archivosAcux=sqlsrv_query($sd,"select COUNT(*) as num from archivosProveedores where factura = '".$res['MovID']."' and tipoArchivo = 'acuse' and estatusidfk = 3");
						$archivosAcu=sqlsrv_fetch_array($archivosAcux);
						if($archivosAcu['num']>0){$imgAcu="<img src='imgs/pdf.png' title='Archivo tipo Acuse'>&nbsp;&nbsp;&nbsp;";}else{$imgAcu="";}
						$archivosFacx=sqlsrv_query($sd,"select COUNT(*) as num from archivosProveedores where factura = '".$res['MovID']."' and tipoArchivo = 'factura' and estatusidfk = 3");
						$archivosFac=sqlsrv_fetch_array($archivosFacx);
						if($archivosFac['num']>0){$imgFac="<img src='imgs/pdf.png' title='Archivo tipo Factura'>&nbsp;&nbsp;&nbsp;";}else{$imgFac="";}
						$archivosXmlx=sqlsrv_query($sd,"select COUNT(*) as num from archivosProveedores where factura = '".$res['MovID']."' and tipoArchivo = 'xml' and estatusidfk = 3");
						$archivosXml=sqlsrv_fetch_array($archivosXmlx);
						if($archivosXml['num']>0){$imgXml="<img src='imgs/xml.png' title='Archivo tipo XML'>&nbsp;&nbsp;&nbsp;";}else{$imgXml="";}

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
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["FechaEmi"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Almacen"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Referencia"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>$".$valorOC."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>$".$valorEC."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["moneda"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Condicion"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'><span id='tdFechaIngreso".$res["MovID"]."'>".$nomDiaIngreso."<br> ".$fechaArchivo."</span></td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'><span id='tdFechaRevision".$res["MovID"]."'>".$nomDiaRev."<br> ".$fechaRevArchivo."</span></td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'><span id='tdFechaPago".$res["MovID"]."'>".$nomDiaPago."<br> ".$fechaPago."</span></td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'><span id='tdEstatus".$res["MovID"]."'>".$nomEstatus."</estatus></td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'><span id='tdImporteTotal".$res["MovID"]."'>$".$importeFacProv."</span></td>
				<td align='center'><textarea readonly style='border:none;background:#F5F5F5' value = ".$res["comentariosTamex"].">".$res["comentariosTamex"]."</textarea></td>
				<td align='center'><textarea readonly style='border:none;background:#F5F5F5' id='comProv".$res["MovID"]."'>".$res["comentariosProv"]."</textarea></td>";
				if(($estatus == '%' || $ordenC != 0 || $entradaCom != 0) && $res["estatusidfk"] == 9){echo"<td align='center'></td>";}
				if(($estatus == '%' || $ordenC != 0 || $entradaCom != 0) && $res["estatusidfk"] != 9){echo"<td align='center'><textarea placeholder='Escribe tus comentarios...' cols='20' rows='2.5' id='comentario".$res["MovID"]."'></textarea>
					<img src='imgs/guardarpequeno.bmp' id='".$res["MovID"]."' style='cursor:pointer'; title='Guardar Comentarios' onclick='guardaComentarioProv(comentario".$res["MovID"].".value,".$res["MovID"].");'/></td>";}
				else if($estatus == 9 || $res["estatusidfk"] == 9){}
				else{echo"<td align='center'><textarea placeholder='Escribe tus comentarios...' cols='20' rows='2.5' id='comentario".$res["MovID"]."'></textarea>
					<img src='imgs/guardarpequeno.bmp' id='".$res["MovID"]."' style='cursor:pointer'; title='Guardar Comentarios' onclick='guardaComentarioProv(comentario".$res["MovID"].".value,".$res["MovID"].");'/></td>";}
				echo"<td align='center'><input type='button' class='buttonDetalle' value='Ver PDF' title='PDF' onclick='detallePdf(".$res["MovID"].");'></td>";
				if($res["Condicion"]=='' || $res["Condicion"]==' ' || $res["Condicion"]=='NULL' || $res["Condicion"]==NULL || $res["Condicion"]=='          '){
					echo"<td align='center' class='spanDesactivado'><span id='spanSubMulti' disabled='disabled'>Ver/Cargar</span></td>";
				}else{
					echo"<td align='center' class='span'>".$imgAcu."".$imgFac."".$imgXml."<span id='spanSubMulti' title='Subir PDF-XML' class='spanhover' onClick='abrirMultiupload(".$res["MovID"].");'>Ver/Cargar</span></td>";
				}
				echo"
			</tr>";
				}
					

?>