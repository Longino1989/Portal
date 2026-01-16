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
    <title>Reportes</title>
    <script type="text/javascript" src="./js/funcionesRep.js"></script>
    <script type="text/javascript" src="./js/jquery-1.4.4.min.js"></script>

    <!--<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.0.min.js"></script>-->

    <script src="../Vistas/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../Vistas/sweetalert2/dist/sweetalert2.min.css">
    <script type="text/javascript" src="./date/jquery.datePicker.js"></script>
    <link href="./date/datePicker.css" rel="stylesheet" type="text/css">
    <link href="./css/estilos.css" rel="stylesheet" type="text/css">
    <script src = "https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>
    <div id="contenedor">
<header class="visorbanner">
    <img id="imgUsuID" src="imgs/BannerReportes.jpg" class="slide" alt="Tamex" name="<?php echo $_SESSION["usid"]; ?>">
    <img class="slide3" src="imgs/secure_icon32.png" title="Configurar Contraseña" onClick='configContrasena(<?php echo $_SESSION["usid"]; ?>)' />
    <a	href="../auten/salir.php" ><img class="slide2" src="imgs/exit.png" title="Cerrar Sesion" /></a>
    
</header>
<nav>
    <!--<input type="search" id="buscaOrdenCompra" size="30" class="caja" placeholder="Buscar Orden Compra">
    <input type='search' id='buscaEntradaCompra' size='20' class='caja' placeholder='Entrada Compra'>-->
    Proveedor:
    <select id='selectProv'; required><?php
echo"
     <option value = '%'>Todos</option>";
while($prov = sqlsrv_fetch_array($proveedores)){
    echo"<option value=".$prov["proveedor"].">".$prov["NombrePoveedor"]."</option>";
}
        ?>
        </select>
        Estatus:
        <?php echo"<select id='selectEstatusRep'; multiple='multiple'; class='selectMultiple';>
            <option value='%'>Todos</option>";
        while($est=sqlsrv_fetch_array($estatus)){
            echo"<option value=".$est["estatusid"]." id='opciones".$est["estatusid"]."'>".$est["nombre"]."</option>";
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
        <input type="button" class="button buttonAzul" value="Buscar" onClick='traeReporteOC(selectProv.value,fechaIni.value,fechaFin.value,selectFecha.value);'">
    <input type="button" class="button buttonBlanco" value="Excel" onclick="reporteExcel(selectProv.value,fechaIni.value,fechaFin.value,selectFecha.value);">
</nav>
<section id="contenido">
    <div id="contenidoPrincipal" class="transp-block"><img class="transparent" src="../imgsinicio/kpi_19.png" alt="" /></div>
    <div id="cambiarContrasena" align = 'center'></div>
</section>
<!--<aside>
    <h2>publicidad</h2>
</aside>
<footer>
    <h2>pie de pagina</h2>
</footer>-->
    </div>
</body>
</html>