<?php
/*
    https://parzibyte.me/blog
*/

$documento=$_POST["docFacturax"];
$user=$_POST["usuarioFacturax"];
include("../../conexionSimple.php");
$sd=conectar();

if (is_numeric($user)) {
    //echo " sesion activa";
} else {
    echo " sesion caducada, Actualizar pagina principar con F5 o cerrar y abrir sesion"; return -1;
}

//echo $documento."-----".$user;
//echo json_decode($documento);
//echo json_decode($user);
$datosx=sqlsrv_query($sd,"select condicion,estatusidfk from tprovIntelisis where MovID = ".$documento."");
$datos=sqlsrv_fetch_array($datosx);
$condicion=$datos["condicion"];
$estatus=$datos["estatusidfk"];
if($condicion == 'Contado')
{
    $resultado = str_replace("Contado", "0 Contado", $condicion);
    $numDias = explode(" ",$resultado);
}
else
{
    $numDias = explode(" ",$condicion);
}

$diaSemanax=sqlsrv_query($sd,"SELECT DATEPART(DW,GETDATE()) as numeroDia");
$diaSem=sqlsrv_fetch_array($diaSemanax);
//Domingo
if($diaSem["numeroDia"] == 1){$fechaRevx=sqlsrv_query($sd,"select convert(varchar,GETDATE()+3,120) diaRevision, convert(varchar,GETDATE()+3+".$numDias[0].",120) diaPago, DATEPART(DW,GETDATE()+3+".$numDias[0].") as numeroDiaPago");
    $fechaRev=sqlsrv_fetch_array($fechaRevx);
    $fechaRevision=$fechaRev["diaRevision"];
    $fechaPago=$fechaRev["diaPago"];
    $nombreDia='DOMINGO';
    if($fechaRev["numeroDiaPago"]==1){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,3,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==2){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,2,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==3){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,1,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==4){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,0,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==5){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,6,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==6){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,5,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==7){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,4,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}}
//Lunes
if($diaSem["numeroDia"] == 2){$fechaRevx=sqlsrv_query($sd,"select convert(varchar,GETDATE()+2,120) diaRevision, convert(varchar,GETDATE()+2+".$numDias[0].",120) diaPago, DATEPART(DW,GETDATE()+2+".$numDias[0].") as numeroDiaPago");
    $fechaRev=sqlsrv_fetch_array($fechaRevx);
    $fechaRevision=$fechaRev["diaRevision"];
    $fechaPago=$fechaRev["diaPago"];
    $nombreDia='LUNES';
    if($fechaRev["numeroDiaPago"]==1){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,3,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==2){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,2,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==3){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,1,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==4){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,0,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==5){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,6,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==6){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,5,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==7){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,4,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}}
//Martes
if($diaSem["numeroDia"] == 3){$fechaRevx=sqlsrv_query($sd,"select convert(varchar,GETDATE()+1,120) diaRevision, convert(varchar,GETDATE()+1+".$numDias[0].",120) diaPago, DATEPART(DW,GETDATE()+1+".$numDias[0].") as numeroDiaPago");
    $fechaRev=sqlsrv_fetch_array($fechaRevx);
    $fechaRevision=$fechaRev["diaRevision"];
    $fechaPago=$fechaRev["diaPago"];
    $nombreDia='MARTES';
    if($fechaRev["numeroDiaPago"]==1){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,3,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==2){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,2,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==3){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,1,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==4){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,0,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==5){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,6,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==6){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,5,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==7){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,4,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}}
//Miercoles
if($diaSem["numeroDia"] == 4){$fechaRevx=sqlsrv_query($sd,"select convert(varchar,GETDATE()+7,120) diaRevision, convert(varchar,GETDATE()+7+".$numDias[0].",120) diaPago, DATEPART(DW,GETDATE()+7+".$numDias[0].") as numeroDiaPago");
    $fechaRev=sqlsrv_fetch_array($fechaRevx);
    $fechaRevision=$fechaRev["diaRevision"];
    $fechaPago=$fechaRev["diaPago"];
    $nombreDia='MIERCOLES';
    if($fechaRev["numeroDiaPago"]==1){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,3,'".$fechaPago."'),120) nuevaFechaPago");
    $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
    $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
    if($fechaRev["numeroDiaPago"]==2){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,2,'".$fechaPago."'),120) nuevaFechaPago");
    $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
    $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
    if($fechaRev["numeroDiaPago"]==3){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,1,'".$fechaPago."'),120) nuevaFechaPago");
    $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
    $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
    if($fechaRev["numeroDiaPago"]==4){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,0,'".$fechaPago."'),120) nuevaFechaPago");
    $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
    $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
    if($fechaRev["numeroDiaPago"]==5){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,6,'".$fechaPago."'),120) nuevaFechaPago");
    $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
    $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
    if($fechaRev["numeroDiaPago"]==6){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,5,'".$fechaPago."'),120) nuevaFechaPago");
    $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
    $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
    if($fechaRev["numeroDiaPago"]==7){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,4,'".$fechaPago."'),120) nuevaFechaPago");
    $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
    $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
    }
//Jueves
if($diaSem["numeroDia"] == 5){$fechaRevx=sqlsrv_query($sd,"select convert(varchar,GETDATE()+6,120) diaRevision, convert(varchar,GETDATE()+6+".$numDias[0].",120) diaPago, DATEPART(DW,GETDATE()+6+".$numDias[0].") as numeroDiaPago");
    $fechaRev=sqlsrv_fetch_array($fechaRevx);
    $fechaRevision=$fechaRev["diaRevision"];
    $fechaPago=$fechaRev["diaPago"];
    $nombreDia='JUEVES';
    if($fechaRev["numeroDiaPago"]==1){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,3,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==2){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,2,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==3){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,1,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==4){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,0,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==5){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,6,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==6){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,5,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==7){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,4,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}}
//Viernes
if($diaSem["numeroDia"] == 6){$fechaRevx=sqlsrv_query($sd,"select convert(varchar,GETDATE()+5,120) diaRevision, convert(varchar,GETDATE()+5+".$numDias[0].",120) diaPago, DATEPART(DW,GETDATE()+5+".$numDias[0].") as numeroDiaPago");
    $fechaRev=sqlsrv_fetch_array($fechaRevx);
    $fechaRevision=$fechaRev["diaRevision"];
    $fechaPago=$fechaRev["diaPago"];
    $nombreDia='VIERNES';
    if($fechaRev["numeroDiaPago"]==1){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,3,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==2){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,2,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==3){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,1,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==4){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,0,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==5){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,6,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==6){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,5,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==7){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,4,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}}
//Sabado
if($diaSem["numeroDia"] == 7){$fechaRevx=sqlsrv_query($sd,"select convert(varchar,GETDATE()+4,120) diaRevision, convert(varchar,GETDATE()+4+".$numDias[0].",120) diaPago, DATEPART(DW,GETDATE()+4+".$numDias[0].") as numeroDiaPago");
    $fechaRev=sqlsrv_fetch_array($fechaRevx);
    $fechaRevision=$fechaRev["diaRevision"];
    $fechaPago=$fechaRev["diaPago"];
    $nombreDia='SABADO';
    if($fechaRev["numeroDiaPago"]==1){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,3,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==2){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,2,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==3){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,1,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==4){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,0,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==5){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,6,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==6){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,5,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}
        if($fechaRev["numeroDiaPago"]==7){$obtenerFechaPago = sqlsrv_query($sd,"select CONVERT(varchar, DATEADD(DAY,4,'".$fechaPago."'),120) nuevaFechaPago");
        $obtFechaPago = sqlsrv_fetch_array($obtenerFechaPago);
        $nuevaFechaPago = $obtFechaPago["nuevaFechaPago"];}}

$conteo = count($_FILES["archivosFactura"]["name"]);
for ($i = 0; $i < $conteo; $i++) {

    //$sef = trim($sef);

$sef = strtr($_FILES['archivosFactura']['name'][$i], "áéíóúÁÉÍÓÚñÑç", "aeiouAEIOUnNc");
$sef = preg_replace("/¡|¿|\?|!|\^|'|,|;|\|:|@|#|\$|%|&|\"|€|¬|~|_|\+|´| `|¨|\*|\/|\||\\||\[|\]|\(|\)|\{|\}/","",$sef);
//$sef = preg_replace('/¡|¿|\?|!|\^|"|,|;|\|:|@|#|\$|%|&|\"|€|¬|~|_|\+|´| `|¨|\*|\/|\||\\||\[|\]|\(|\)|\{|\}/',"",$sef);
$sef = preg_replace("/( - |- | -| )/","-",$sef);
$sef = preg_replace("/-{2,}/","-",$sef);
$sef = preg_replace("/^-+|-+$|^\.+|\.+$/","",$sef);
$sef=str_replace('Ó','O',$sef);

    //echo json_decode($conteo); return -1;
    $uploaddir = '../../../archivosPDFFactura/'.$documento;
    $nombre=$documento.basename($sef);

    $re=sqlsrv_query($sd,"select * from archivosProveedores where nombre='".$nombre."' ");
$num_rows = sqlsrv_num_rows($re);
//echo $num_rows; return -1;
if($num_rows>0){
	while($num_rows!=0){$num=$num+1;
	$nombre=$documento."-".$num.basename($sef);
		$re=sqlsrv_query($sd,"select * from archivosProveedores where nombre='".$nombre."' ");
        $num_rows = sqlsrv_num_rows($re);
	$nombre=$documento."-".$num.basename($sef);
	$uploaddir = '../../../archivosPDFFactura/'.$documento."-".$num;}
	
	}
$file = $uploaddir . basename($sef);

//$nombreArchivo = $_FILES["archivosFactura"]["tmp_name"][$i];
if(move_uploaded_file($_FILES['archivosFactura']['tmp_name'][$i], $file)){
    $in=sqlsrv_query($sd,"INSERT INTO archivosProveedores(factura,nombre,direccion,estatusidfk,fecha,usuarioidfk,tipoArchivo,fechaRevision,fechaTenPago,nombreDiaIngreso,nombreDiaPago) 
    VALUES(".$documento.",'".$nombre."','".$file."','3',GETDATE(),".$user.",'factura',convert(varchar,'".$fechaRevision."',120), convert(varchar,'".$nuevaFechaPago."',120),'".$nombreDia."','MIERCOLES')");
$updFechaPago = sqlsrv_query($sd,"update tprovIntelisis set fechaPago = convert(varchar,'".$nuevaFechaPago."',120), fechaRevision = convert(varchar,'".$fechaRevision."',120), fechaArchivo = convert(varchar,GETDATE(),120) where MovID = ".$documento."");
    }
}
if($estatus == 5){
    $update=sqlsrv_query($sd,"update tprovIntelisis set estatusidfk = 6 where MovID = ".$documento."");
}
// Responder al cliente
echo json_encode(true);