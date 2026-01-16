<?php
session_cache_limiter('private, must-revalidate');
session_cache_expire(60);
session_start();
$usuario=$_POST["usuario"];
$contrasena= base64_encode($_POST["contrasena"]);
//ini_set('display_errors', 1);

//$contrasena = base64_encode ( $contrasena2 );

//echo $usuario."-".$contrasena; return -1;

include('../conexionSimple.php');
$sd=conectar(); 

$consulta="select * from cusuario where usuario='".$usuario."' and contrasena='".$contrasena."' and estatusidfk=1";
$ejecuta=sqlsrv_query($sd,$consulta);
$verifica=sqlsrv_fetch_array($ejecuta);

//usuario y contraseña validos
				//se define una sesion y se guarda el dato session_start();
				$_SESSION['autenticado'] = 'si';
				$_SESSION['usuario'] = $_POST['usuario'];
				$_SESSION['nombre'] = $verifica['nombre']." ".$verifica['apellido_paterno'];
				$_SESSION['area']=$verifica['area'];
				$_SESSION['usid']=$verifica['usid'];
if($verifica["contrasena"]=='c2lzdGFtZXgyMDIy'){header ("Location: personalizaPass.php"); return;}
//echo $_SESSION['nombre']; return -1;
                ?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BIENVENIDO A PORTAL TAMEX</title>

<link rel="stylesheet" href="../css/estilosAuten.css">
<h1 class='h1'>Modulos</h1>
</head>

<body class="body">
<div class="divAuten">
<?php
//echo  "$verx"; return -1;

if($_SESSION['usid'] > 0){


if($_SESSION['area']=='Administrador'){
    echo"
    <ul class='estiloLista'>
   <li class='estiloLista estiloListaColor'><a href='../ADMINISTRADOR/index.php'><b>ADMINISTRADOR</b></a></li>
   <li class='estiloLista estiloListaColor'><a href='../CUENTAS POR PAGAR/index.php'><b>CUENTAS POR PAGAR </b></a></li>
   <li class='estiloLista estiloListaColor'><a href='../PROVEEDORES/index.php'><b>PROVEEDORES</b></a></li>
   <li class='estiloLista estiloListaColor'><a href='../REPORTES/index.php'><b>REPORTES</b></a></li>
   </ul>";
}


if($_SESSION['area']=='Cuentas por pagar'){header ("Location: ../CUENTAS POR PAGAR/index.php");}
if($_SESSION['area']=='Proveedores'){header ("Location: ../PROVEEDORES/index.php");}
if($_SESSION['area']=='Reportes'){header ("Location: ../REPORTES/index.php");}
}
else{
    header("Location: ../index.html");
}
//$sd=desconectar();
?>
</div>
</body>
</html>