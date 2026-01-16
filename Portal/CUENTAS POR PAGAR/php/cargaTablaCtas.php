<?php
require ('permiso.php');
//session_start();
include('../../conexionSimple.php');
$sd=conectar();

$usuarioid = $_POST["usuarioIDx"];
$ordenCompra = $_POST["ordenComx"];
$entradaCompra = $_POST["entradaComx"];
$valor = $_POST["provIDx"];
$estatusid = $_POST["estatusidx"];
$fechaInicio = $_POST["fechaInix"];
$fechaFin = $_POST["fechaFinx"];
$tipoFecha = $_POST["tipoFechax"];

//echo $usuarioid."-".$ordenCompra."-".$entradaCompra."-".$valor."-".$estatusid."-".$fechaInicio."-".$fechaFin."-".$tipoFecha; //return -1;
if($ordenCompra != 0 || $entradaCompra != 0){
	if($ordenCompra != 0){$busqRegistro=sqlsrv_query($sd,"select IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where IDOC like '%".$ordenCompra."%' order by FechaEmision desc, MovID");
		//$obtEstOCx=sqlsrv_query($sd,"select estatusidfk from tprovIntelisis where IDOC like '%".$ordenCompra."%'");
		//$obtEstOC=sqlsrv_fetch_array($obtEstOCx);
	}else{
		$busqRegistro=sqlsrv_query($sd,"select IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where MovID like '%".$entradaCompra."%'");
		//$obtEstECx=sqlsrv_query($sd,"select estatusidfk from tprovIntelisis where MovID like '%".$entradaCompra."%'");
		//$obtEstEC=sqlsrv_fetch_array($obtEstECx);
		}

echo"<table id='tableID' class='display' border='0.8' cellspacing='1' cellpadding='5' align= 'center' style='width:100%; border:0px;'>
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
	<th align='center'>Importe Total</th>
	<th align='center'>Comentarios Proveedor</th>
	<th align='center'>Comentarios Tamex</th>
	<th align='center'>Comentarios</th>
	<th align='center'>PDF</th>
	<th align='center'>Archivos Adjuntos</th>
	<th align='center'>Estatus</th>
</tr> 
</thead>";
$color='#F2F6FE'; 
while ($res = sqlsrv_fetch_array($busqRegistro)){  
	$datArchx=sqlsrv_query($sd,"select convert(varchar(10),fecha,103) fechaIngresoDoc, convert(varchar(10),fechaRevision,103) fechaRevisionDoc, convert(varchar(10),fechaTenPago,103) fechaTenPago, nombreDiaIngreso, nombreDiaPago from archivosProveedores where factura = '".$res["MovID"]."' and estatusidfk = 3 order by fecha desc");
	$datArch=sqlsrv_fetch_array($datArchx);
	if(isset($datArch["fechaIngresoDoc"])){$fechaArchivo = $datArch["fechaIngresoDoc"]; $nomDiaIngreso = $datArch["nombreDiaIngreso"];}else{$fechaArchivo = ''; $nomDiaIngreso = '';}
	if(isset($datArch["fechaRevisionDoc"])){$fechaRevArchivo = $datArch["fechaRevisionDoc"]; $nomDiaRev = 'MIERCOLES';}else{$fechaRevArchivo = ''; $nomDiaRev = '';}
	if(isset($datArch["fechaTenPago"])){$fechaPago = $datArch["fechaTenPago"]; $nomDiaPago = $datArch["nombreDiaPago"];}else{$fechaPago = ''; $nomDiaPago = '';}
	$importeTotalx=sqlsrv_query($sd,"select SUM(importe) sumaImporte from tfacturaImporte where MovIDfk = ".$res["MovID"]."");
	$rowImp=sqlsrv_fetch_array($importeTotalx);

	if($color == '#F2F6FE'){$color = '#FAFBFC';}else{$color='#F2F6FE';}//#E6F3EC--#B5D4C5
	if($res["estatusidfk"]==10012){$colorLetra='#FF5733';}else{$colorLetra = '#030100';}
	// notación francesa
$valorOC = number_format($res["ImporteOC"], 2, '.', ',');
$valorEC = number_format($res["ImporteEC"], 2, '.', ',');
$importeFac = number_format($rowImp["sumaImporte"], 2, '.', ',');
echo"<tr style='font-size:12px; color:".$colorLetra."; background-color: ".$color.";'>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["IDOC"]."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Documento"]."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["FechaEmi"]."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Almacen"]."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Referencia"]."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>$".$valorOC."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>$".$valorEC."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["moneda"]."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["condicion"]."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$nomDiaIngreso."<br>".$fechaArchivo."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$nomDiaRev."<br>".$fechaRevArchivo."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$nomDiaPago."<br>".$fechaPago."</td>
<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>$".$importeFac."</td>
<td align='center'><textarea readonly style='border:none;background:#F5F5F5' id='comProv".$res["MovID"]."'>".$res["comentariosProv"]."</textarea></td>
<td align='center'><textarea readonly style='border:none;background:#F5F5F5' id='comTamex".$res["MovID"]."'>".$res["comentariosTamex"]."</textarea></td>";
if($res["estatusidfk"] == 9){echo"<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'></td>";}else{echo"
<td align='center'><textarea placeholder='Escribe tus comentarios...' cols='20' rows='2.5' id='comentarioTamex".$res["MovID"]."'></textarea>
<img src='imgs/guardarpequeno.bmp' id='".$res["MovID"]."' style='cursor:pointer'; title='Guardar' onclick='guardaComentarioTamex(comentarioTamex".$res["MovID"].".value,".$res["MovID"].");'/></td>";}
echo"<td align='center'; class='span'><span id spanVerPdf class='spanhover' title='Ver PDF' onclick='detallePdf(".$res["MovID"].");'>Ver PDF</span></td>
<td align='center'; class='span'><span id='spanSubMulti' title='Multiarchivos PDF-XML' class='spanhover' onClick='abrirMultiupload(".$res["MovID"].");'>Ver Archivos</span></td>
";
if($res["estatusidfk"] == 9){
echo"<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>Pagada</td>";
}else{
echo"<td align='center'><div class='sidebar-box'><select id='estatusDoc'; class='selectPequeno' onchange='cambiaEstatus(".$res["MovID"].",this.value,".$ordenCompra.",".$entradaCompra.",\"".$valor."\",\"".$estatusid."\",\"".$fechaInicio."\",\"".$fechaFin."\",\"".$tipoFecha."\");'>";
if($res["estatusidfk"] == 5){
	echo"<option value='5'>Pendiente</option>";
	echo"</select></div></td>";
	}
if($res["estatusidfk"] == 6){
	echo"<option value='7'>Autorizada</option>
		 <option value='8' selected>Denegada</option>
		 <option value='6' selected>Revision</option>";
	echo"</select></div></td>";
	}
if($res["estatusidfk"] == 7){
	echo"<option value='7' selected>Autorizada</option>
	 	 <option value='9'>Pagada</option>
	 	 <option value='10'>Parcial</option>";
	echo"</select></div></td>";
}
if($res["estatusidfk"] == 8){
	echo"<option value='7'>Autorizada</option>
	 	 <option value='8' selected>Denegada</option>";
	echo"</select></div></td>";
}
if($res["estatusidfk"] == 10){
	echo"<option value='9'>Pagada</option>
	 	 <option value='10' selected>Parcial</option>";
	echo"</select></div></td>";
	}
if($res["estatusidfk"] == 10012){
	echo"<option value='10012'>Cancelada</option>";
	echo"</select></div></td>";
		}
}
echo"</tr>";
}
echo"</table>||";}
//Fin if $ordenCompra; $entradaCompra;
else{
	if($estatusid != 9){
		if($fechaInicio == '' || $fechaFin == ''){
			$busqRegistro=sqlsrv_query($sd,"select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where proveedor like '".$valor."' and estatusidfk like '".$estatusid."' and estatusidfk not in(9) order by FechaEmision desc, IDOC");
		}else{
			$busqRegistro=sqlsrv_query($sd,"select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where 
			proveedor like '".$valor."' and estatusidfk like '".$estatusid."' and estatusidfk not in(9) and convert(char(10),".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicio."',120) AND convert(VARCHAR(10),'".$fechaFin."',120) order by ".$tipoFecha." desc, IDOC");
		}
		
	}else{
		if($fechaInicio == '' || $fechaFin == ''){
			$busqRegistro=sqlsrv_query($sd,"select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where proveedor like '".$valor."' and estatusidfk = 9 order by FechaEmision desc, IDOC");
		}else{
			$busqRegistro=sqlsrv_query($sd,"select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where 
			proveedor like '".$valor."' and estatusidfk = 9 and convert(char(10),".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicio."',120) AND convert(VARCHAR(10),'".$fechaFin."',120) order by ".$tipoFecha." desc, IDOC");
		}
	
	}
	
echo"<form name='f1' id='formElement'>
<table id='tableID' class='display' border='0.8' cellspacing='1' cellpadding='5' align= 'center' style='width:100%; border:0px;'>
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
						<th align='center'>Importe Total</th>
						<th align='center'>Comentarios Proveedor</th>
                        <th align='center'>Comentarios Tamex</th>";
						if($estatusid != 9){
							echo"<th align='center'>Comentarios</th>";
						}
						echo"
						<th align='center'>PDF</th>
						<th align='center'>Archivos Adjuntos</th>
						<th align='center'>Estatus</th>";
						if($estatusid == '%' || $estatusid == 9 || $estatusid == 5 || $estatusid == 10012){
							echo"";
						}else{
							echo"<th>Marcar: <input type='checkbox' id='confirmar' onchange='activaSelect(this.checked)' name=0 onclick='marcar()'></th>";
						}
					echo"</tr> 
					</thead>";
					$color='#F2F6FE'; 
					while ($res = sqlsrv_fetch_array($busqRegistro)){  
                        $datArchx=sqlsrv_query($sd,"select convert(varchar(10),fecha,103) fechaIngresoDoc, convert(varchar(10),fechaRevision,103) fechaRevisionDoc, convert(varchar(10),fechaTenPago,103) fechaTenPago, nombreDiaIngreso, nombreDiaPago from archivosProveedores where factura = '".$res["MovID"]."' and estatusidfk = 3 order by fecha desc");
                        $datArch=sqlsrv_fetch_array($datArchx);
                        if(isset($datArch["fechaIngresoDoc"])){$fechaArchivo = $datArch["fechaIngresoDoc"]; $nomDiaIngreso = $datArch["nombreDiaIngreso"];}else{$fechaArchivo = ''; $nomDiaIngreso = '';}
						if(isset($datArch["fechaRevisionDoc"])){$fechaRevArchivo = $datArch["fechaRevisionDoc"]; $nomDiaRev = 'MIERCOLES';}else{$fechaRevArchivo = ''; $nomDiaRev = '';}
						if(isset($datArch["fechaTenPago"])){$fechaPago = $datArch["fechaTenPago"]; $nomDiaPago = $datArch["nombreDiaPago"];}else{$fechaPago = ''; $nomDiaPago = '';}
						$importeTotalx=sqlsrv_query($sd,"select SUM(importe) sumaImporte from tfacturaImporte where MovIDfk = ".$res["MovID"]."");
						$rowImp=sqlsrv_fetch_array($importeTotalx);
						if($estatusid == 5){
							$estatusx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (".$estatusid.") order by nombre");
						}
						if($estatusid == 6){
							$estatusx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (7,8,".$estatusid.") order by nombre");
						}
						if($estatusid == 7){
							$estatusx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (9,10,".$estatusid.") order by nombre");
						}
						if($estatusid == 8){
							$estatusx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (7,".$estatusid.") order by nombre");
						}
						if($estatusid == 9){
							$estatusx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (".$estatusid.") order by nombre");
						}
						if($estatusid == 10){
							$estatusx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (9,".$estatusid.") order by nombre");
						}
						if($estatusid == 10012){
							$estatusx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (".$estatusid.") order by nombre");
						}
						if($estatusid == '%'){
							$estatusx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid like '".$estatusid."' and estatusid not in (5) order by nombre");
						}

						if($color == '#F2F6FE'){$color = '#FAFBFC';}else{$color='#F2F6FE';}//#E6F3EC--#B5D4C5
						if($res["estatusidfk"]==10012){$colorLetra='#FF5733';}else{$colorLetra = '#030100';}
						// notación francesa
					$valorOC = number_format($res["ImporteOC"], 2, '.', ',');
					$valorEC = number_format($res["ImporteEC"], 2, '.', ',');
					$importeFac = number_format($rowImp["sumaImporte"], 2, '.', ',');
                echo"<tr style='font-size:12px; color:".$colorLetra."; background-color: ".$color.";'>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["IDOC"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Documento"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["FechaEmi"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Almacen"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["Referencia"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>$".$valorOC."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>$".$valorEC."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["moneda"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$res["condicion"]."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$nomDiaIngreso."<br>".$fechaArchivo."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$nomDiaRev."<br>".$fechaRevArchivo."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>".$nomDiaPago."<br>".$fechaPago."</td>
				<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>$".$importeFac."</td>
                <td align='center'><textarea readonly style='border:none;background:#F5F5F5' id='comProv".$res["MovID"]."'>".$res["comentariosProv"]."</textarea></td>
				<td align='center'><textarea readonly style='border:none;background:#F5F5F5' id='comTamex".$res["MovID"]."'>".$res["comentariosTamex"]."</textarea></td>";
				if($estatusid != 9){
					echo"<td align='center'><textarea placeholder='Escribe tus comentarios...' cols='20' rows='2.5' id='comentarioTamex".$res["MovID"]."'></textarea>
					<img src='imgs/guardarpequeno.bmp' id='".$res["MovID"]."' style='cursor:pointer'; title='Guardar' onclick='guardaComentarioTamex(comentarioTamex".$res["MovID"].".value,".$res["MovID"].");'/></td>";
				}echo"
				<td align='center'; class='span'><span id spanVerPdf class='spanhover' title='Ver PDF' onclick='detallePdf(".$res["MovID"].");'>Ver PDF</span></td>
				<td align='center'; class='span'><span id='spanSubMulti' title='Multiarchivos PDF-XML' class='spanhover' onClick='abrirMultiupload(".$res["MovID"].");'>Ver Archivos</span></td>
				";
				if($estatusid == 9){
					echo"<td align='center' style='cursor:pointer;' title='Click para ver Detalle'; onclick='detalleDocumento(".$res["ID"].");'>Pagada</td>";
				}else{
					if($res["estatusidfk"] == 10012){$disable = 'disabled';}{$disable='';}
				echo"<td align='center'><div class='sidebar-box'><select id='estatusDoc'; class='selectPequeno' ".$disable." onchange='cambiaEstatus(".$res["MovID"].",this.value,".$ordenCompra.",".$entradaCompra.",\"".$valor."\",\"".$estatusid."\",\"".$fechaInicio."\",\"".$fechaFin."\",\"".$tipoFecha."\");'>";
				if($estatusid == '%' && $res["estatusidfk"] == 5){
					echo"<option value='5'>Pendiente</option>";
					echo"</select></div></td>";
					}
				if($estatusid == '%' && $res["estatusidfk"] == 6){
					echo"<option value='7'>Autorizada</option>
						 <option value='8' selected>Denegada</option>
						 <option value='6' selected>Revision</option>";
					echo"</select></div></td>";
					}
				if($estatusid == '%' && $res["estatusidfk"] == 7){
					echo"<option value='7' selected>Autorizada</option>
						 <option value='9'>Pagada</option>
						 <option value='10'>Parcial</option>";
					echo"</select></div></td>";
				}
				if($estatusid == '%' && $res["estatusidfk"] == 8){
					echo"<option value='7'>Autorizada</option>
						 <option value='8' selected>Denegada</option>";
					echo"</select></div></td>";
					}
				if($estatusid == '%' && $res["estatusidfk"] == 10){
					echo"<option value='9'>Pagada</option>
						 <option value='10' selected>Parcial</option>";
					echo"</select></div></td>";
						}
				if($estatusid == '%' && $res["estatusidfk"] == 10012){
					echo"<option value='10'>Cancelada</option>";
					echo"</select></div></td>";
								}
				if($estatusid != '%'){
					while($estatus=sqlsrv_fetch_array($estatusx)){
						if($estatus["estatusid"]==$res["estatusidfk"]){$selected="selected";}else{$selected="";}
						echo"<option value=".$estatus["estatusid"]." ".$selected.">".$estatus["nombre"]."</option>";
					}
						echo"</select></div></td>";
						if($estatusid == 6 || $estatusid == 7 || $estatusid == 8 || $estatusid == 10){
							echo"<td align='center';><input type='checkbox' onchange='activaSelect(this.checked)'; name='".$res["MovID"]."'></td>";
						}
				}
			}
			echo"</tr>";
				}
				echo"</table></form>||";
				if($estatusid == 6 || $estatusid == 7 || $estatusid == 8 || $estatusid == 10){
					if($estatusid == 6){
						$estatusGeneralx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (7,8,".$estatusid.") order by nombre");
					}
					if($estatusid == 7){
						$estatusGeneralx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (9,10,".$estatusid.") order by nombre");
					}
					if($estatusid == 8){
						$estatusGeneralx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (7,".$estatusid.") order by nombre");
					}
					if($estatusid == 10){
						$estatusGeneralx=sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' and estatusid in (9,".$estatusid.") order by nombre");
					}
				echo"Nuevo: <select id='estatusDoc'; name='estatusDoc'; class='selectPequeno' disabled onchange='cambiaEstatusLista(this.value,\"".$valor."\",\"".$estatusid."\",\"".$fechaInicio."\",\"".$fechaFin."\");'>";
				while($estGen=sqlsrv_fetch_array($estatusGeneralx)){
					if($estatusid == $estGen["estatusid"]){$selected="selected";}else{$selected="";}
					echo"<option value=".$estGen["estatusid"]." ".$selected.">".$estGen["nombre"]."</option>";
				}
					echo"</select>";
				}
			}
?>