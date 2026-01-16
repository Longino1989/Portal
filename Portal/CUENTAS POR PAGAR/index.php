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
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuentas por Pagar</title>
    <script type="text/javascript" src="./js/funcionesCtas.js"></script>
    <!--<script type="text/javascript" src="./js/jquery-1.4.4.min.js"></script>!-->
    <!--<script type="text/javascript" src="./date/jquery.datePicker.js"></script>
    <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>-->
    <script src="../Vistas/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../Vistas/sweetalert2/dist/sweetalert2.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script type="text/javascript" src="./date/jquery.js"></script>
    <link href="./date/datePicker.css" rel="stylesheet" type="text/css">
    <link href="./css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="contenedor">
<header class="visorbanner">
<img id="imgUsuID" src="imgs/BannerCuentas.jpg" class="slide" alt="Tamex" name="<?php echo $_SESSION["usid"]; ?>">
    <a	href="../auten/salir.php" ><img class="slide2" src="imgs/exit.png" title="Cerrar Sesion" /></a>
</header>
<nav>
<div id="divContenidoCuentasXpagar">
    <div id='divFiltrosCuentasXpagar'>
        <input type='search' id='ordenCompra' size='20' class='caja'  placeholder='Orden Compra'>
        <input type='search' id='entradaCompra' size='20' class='caja' placeholder='Entrada Compra'>
       
Proveedor:<select id='selectProv'; required><?php
echo"<option value = '%'>Todos</option>";
while($prov = sqlsrv_fetch_array($proveedores)){
    echo"<option value=".$prov["proveedor"].">".$prov["proveedor"]."- ".$prov["NombrePoveedor"]."</option>";
}
        ?>
        </select>
        Estatus:<select id='selectEstatus'; required><?php
        echo"<option value = '%'>Todos</option>";
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
        Inicio:<input type="date" id="fechaIni" class="calendar">
        Fin:<input type="date" id="fechaFin" class="calendar">
        <input type='button' value='Buscar' class='button buttonAzul' onclick='traeTabla(ordenCompra.value,entradaCompra.value,selectProv.value,selectEstatus.value,fechaIni.value,fechaFin.value,selectFecha.value);'>
        <input type='button' class='button buttonBlanco' value='Excel' onclick='reporteExcelCtas(ordenCompra.value,entradaCompra.value,selectProv.value,selectEstatus.value,fechaIni.value,fechaFin.value,selectFecha.value);'>
        <span id='spanEstatus'></span>
    </div>
    
    </div>
</nav>
<section id="contenido">
<div id="divTablaCuentasXpagar" class="transp-block"><img class="transparent" src="../imgsinicio/kpi_19.png" alt="" /></div>
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