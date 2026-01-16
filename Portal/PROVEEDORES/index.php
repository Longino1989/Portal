<?php
require ('php/permiso.php');
//session_cache_limiter('private, must-revalidate');
//session_cache_expire(60);
//session_start();
include('../conexionSimple.php');
$sd=conectar();
//echo $_SESSION['usid']; return -1;
$proveedores = sqlsrv_query($sd,"select distinct proveedor, NombrePoveedor from tprovIntelisis order by NombrePoveedor");
$estatus = sqlsrv_query($sd,"select * from cestatus where tarea_referente = 'entradaCompra' order by nombre");
$datosUserx=sqlsrv_query($sd,"select * from cusuario where usid = ".$_SESSION["usid"]."");
$datosUser=sqlsrv_fetch_array($datosUserx);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Proveedores</title>
    <script type="text/javascript" src="./js/funcionesPro.js"></script>
    <script type="text/javascript" src="./js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="./date/jquery.datePicker.js"></script>
    <link href="./date/datePicker.css" rel="stylesheet" type="text/css">
    <link href="./css/estilos.css" rel="stylesheet" type="text/css">
    <!--<script src = "https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
    <script src="../Vistas/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../Vistas/sweetalert2/dist/sweetalert2.min.css">
</head>
<body>
    <div id="contenedor" aling = 'center'>
<header class="visorbanner">
    <img id="imgUsuID" src="imgs/Banner.jpeg" class="slide" alt="Tamex" name="<?php echo $_SESSION["usid"]; ?>">
    <a	href="../auten/salir.php" ><img class="slide2" src="imgs/exit.png" title="Cerrar Sesion" /></a>
</header>
<nav>
    <input type="search" id="buscaordenC" size="30" class="caja" placeholder="Orden Compra">
    <input type='search' id='entradaCompra' size='20' class='caja' placeholder='Entrada Compra'>
    <?php
    if($datosUser["area"]=='Administrador'){
        echo"</select>
        <select id='selectProv'; required>
        <option value='' disabled selected>Proveedor...</option>";
        while($prov = sqlsrv_fetch_array($proveedores)){
        echo"<option value=".$prov["proveedor"].">".$prov["NombrePoveedor"]."</option>";
    }
    echo"</select>";
        }
        
       echo"Estatus:<select id='selectEstatusPro'; required>";
        echo"<option value='' disabled selected>Estatus...</option>
             <option value = '%'>Todos</option>";
        while($est=sqlsrv_fetch_array($estatus)){
            echo"<option value=".$est["estatusid"].">".$est["nombre"]."</option>";
        }
        
        
        ?>
        </select>
        Tipo fecha:
        <select id='selectFecha'>
            <option value='FechaEmision'>Emision</option>
            <option value='fechaPago'>Pago</option>
            <option value='fechaRevision'>Revision</option>
        </select>
        Inicio: <input type="date" id="fechaIni" class="calendar">
        Fin: <input type="date" id="fechaFin" class="calendar"><?php
        if($datosUser["area"]=='Administrador'){
            echo"<input type='button' id='buscarPro' class='button buttonAzul' value='Buscar' onClick='cargaTabla(buscaordenC.value,entradaCompra.value,selectEstatusPro.value,selectProv.value,fechaIni.value,fechaFin.value,selectFecha.value);'>
            <input type='button' class='button buttonBlanco' value='Excel' onclick='reporteExcelPro(buscaordenC.value,entradaCompra.value,selectEstatusPro.value,selectProv.value,fechaIni.value,fechaFin.value,selectFecha.value);'>";
        }else{
            echo"<input type='button' id='buscarPro' class='button buttonAzul' value='Buscar' onClick='cargaTabla(buscaordenC.value,entradaCompra.value,selectEstatusPro.value,1,fechaIni.value,fechaFin.value,selectFecha.value);'>
            <!--<input type='button' class='button buttonVerde' value='Limpiar' onclick='();'>
            <input type='button' class='button buttonCielo' value='Pdf Consolidado' onclick='();'>-->
            <input type='button' class='button buttonBlanco' value='Excel' onclick='reporteExcelPro(buscaordenC.value,entradaCompra.value,selectEstatusPro.value,1,fechaIni.value,fechaFin.value,selectFecha.value);'>";
        }?>
        
</nav>
<section id="contenido">  <img class="transparent" src="../imgsinicio/kpi_19.png" alt="" /> 
</section>
<!--<aside>
    <h2>publicidad</h2>
</aside>-->
<footer>
    <h2>pie de pagina</h2>
</footer>
    </div>
</body>
</html>