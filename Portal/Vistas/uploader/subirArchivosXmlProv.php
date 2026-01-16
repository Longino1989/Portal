<?php
$folio=$_GET["foliox"];
$usuarioID=$_GET["usidx"];
include("../../conexionSimple.php");
$sd=conectar();
//$uploaddir = './uploads/';
//echo $folio; return -1;
//if($selectx["estatusidfk"]!=76){
//$sef=str_replace("![a-zA-Z0-9-]","",$_FILES['uploadfile']['name']);

$sef = trim($sef);

$sef = strtr($_FILES['uploadfile']['name'], "áéíóúÁÉÍÓÚñÑç", "aeiouAEIOUnNc");
$sef = preg_replace("/¡|¿|\?|!|\^|'|,|;|\|:|@|#|\$|%|&|\"|€|¬|~|_|\+|´| `|¨|\*|\/|\||\\||\[|\]|\(|\)|\{|\}/","",$sef);
//$sef = preg_replace('/¡|¿|\?|!|\^|"|,|;|\|:|@|#|\$|%|&|\"|€|¬|~|_|\+|´| `|¨|\*|\/|\||\\||\[|\]|\(|\)|\{|\}/',"",$sef);
$sef = preg_replace("/( - |- | -| )/","-",$sef);
$sef = preg_replace("/-{2,}/","-",$sef);
$sef = preg_replace("/^-+|-+$|^\.+|\.+$/","",$sef);
$sef=str_replace('Ó','O',$sef);



$uploaddir = '../../../archivosXML/'.$folio; 
$nombre=$folio.basename($sef);
$re=sqlsrv_query($sd,"select * from archivosProveedores where nombre='".$nombre."' ");
$num_rows = sqlsrv_num_rows($re);
//echo $num_rows; return -1;
if($num_rows>0){
	while($num_rows!=0){$num=$num+1;
	$nombre=$folio."-".$num.basename($sef);
		$re=sqlsrv_query($sd,"select * from archivosProveedores where nombre='".$nombre."' ");
        $num_rows = sqlsrv_num_rows($re);
	$nombre=$folio."-".$num.basename($sef);
	$uploaddir = '../../../archivosXML/'.$folio."-".$num;}
	
	}
$file = $uploaddir . basename($sef);

if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
//$file=str_replace('"','',$file);
//$file=str_replace('Ó','O',$file);

$in=sqlsrv_query($sd,"INSERT INTO archivosProveedores(factura,nombre,direccion,estatus,fecha,usuarioidfk,tipoArchivo) VALUES(".$folio.",'".$nombre."','".$file."','3',GETDATE(),".$usuarioID.",'xml')");

  echo "success,,".$nombre; 
} else {
	echo "error";
}
//}else{echo 1;}
?>