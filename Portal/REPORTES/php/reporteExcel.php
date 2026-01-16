<?php

require '../../vistas/phpSpreadSheet/vendor/autoload.php';
//require ('permiso.php');
include('../../nuevaConexion.php');

$user = $_GET["usuarioIDx"];
//$ordenCompra = $_GET["ordenComx"];
//$entradaCompra = $_GET["entradaComx"];
$proveedor = $_GET["proveedorx"];
$estatusid = $_GET["selectedx"];//if($estatusid == '%'){$estatusCompleto = "estatusidfk like '%'";}else{$estatusCompleto = "estatusidfk in (".$estatusid.")";}
$fechaInicial = $_GET["fechaInix"];
$fechaFin = $_GET["fechaFinx"];
$tipoFecha = $_GET["tipoFechax"];

$arr = explode(',', $estatusid);
if($arr[0]=='%'){$estatusCompleto = "tp.estatusidfk like '%'";}else{$estatusCompleto = "tp.estatusidfk in (".$estatusid.")";}
//$sd=conectar();
//echo $user."--".$proveedor."--".$estatusid."--".$estatusCompleto."--".$fechaInicial."--".$fechaFin; return -1;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/*if($ordenCompra != 0 || $entradaCompra != 0){
    if($ordenCompra != 0){$busqRegistro = $sqlsrv->query("select IDOC,Documento,proveedor,NombrePoveedor,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where IDOC like '%".$ordenCompra."%' order by FechaEmision desc, MovID");
        $facturas = $sqlsrv->query("select tf.*,tp.IDOC,tp.FechaEmision,tp.Referencia, cu.nombre nombreusuario, cu.usuario from tfacturaImporte as tf
        inner join cusuario as cu on (cu.usid=tf.usuarioidfk)
        inner join tprovIntelisis as tp on (tp.MovID=tf.MovIDfk)
        where tp.IDOC = ".$ordenCompra." order by tf.cont asc");
    }else{
        $busqRegistro = $sqlsrv->query("select IDOC,Documento,proveedor,NombrePoveedor,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where MovID like '%".$entradaCompra."%'");
        $facturas = $sqlsrv->query("select tf.*,tp.IDOC,tp.FechaEmision,tp.Referencia, cu.nombre nombreusuario, cu.usuario from tfacturaImporte as tf
        inner join cusuario as cu on (cu.usid=tf.usuarioidfk)
        inner join tprovIntelisis as tp on (tp.MovID=tf.MovIDfk)
        where tf.MovIDfk = ".$entradaCompra." order by tf.cont asc");    
    }
}else{*/
    if($fechaInicial == '' || $fechaFin == ''){
        $busqRegistro = $sqlsrv->query("select top(400) IDOC,Documento,proveedor,NombrePoveedor,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis as tp where ".$estatusCompleto." and proveedor like '".$proveedor."' order by FechaEmision desc, IDOC");

        $facturas = $sqlsrv->query("select tf.*,tp.IDOC,tp.FechaEmision,tp.Referencia, cu.nombre nombreusuario, cu.usuario,tp.moneda,tp.TasaImpuesto from tfacturaImporte as tf
        inner join cusuario as cu on (cu.usid=tf.usuarioidfk)
        inner join tprovIntelisis as tp on (tp.MovID=tf.MovIDfk)
        where tp.proveedor like '".$proveedor."' and ".$estatusCompleto." order by tp.IDOC"); 
    }else{
        $busqRegistro = $sqlsrv->query("select top(400) IDOC,Documento,proveedor,moneda,NombrePoveedor,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu, convert(varchar(10),fechaPago,103) fechapago from tprovIntelisis as tp where ".$estatusCompleto." and proveedor like '".$proveedor."' and convert(char(10),".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicial."',120) AND convert(VARCHAR(10),'".$fechaFin."',120) order by ".$tipoFecha." desc, IDOC");
        $facturas = $sqlsrv->query("select tf.*,tp.IDOC,tp.FechaEmision,tp.Referencia, cu.nombre nombreusuario, cu.usuario,tp.moneda,tp.TasaImpuesto from tfacturaImporte as tf
        inner join cusuario as cu on (cu.usid=tf.usuarioidfk)
        inner join tprovIntelisis as tp on (tp.MovID=tf.MovIDfk)
        where tp.proveedor like '".$proveedor."' and ".$estatusCompleto." and convert(char(10),tp.".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicial."',120) AND convert(VARCHAR(10),'".$fechaFin."',120) order by tp.".$tipoFecha." desc, tp.IDOC"); 
    }
//$PDO_Intelisis = $sentencia->fetchAll(PDO::FETCH_OBJ);


//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet(0);
$hojaActiva->setTitle("Documento");
$excel -> getProperties()
                ->setTitle("Reporte de Proveedores")
                ->setLastModifiedBy("Sistema Tamex")
                ->setCreator("Sistema Tamex")
                ->setDescription("Reporte generado del modulo Reportes")
                ->setCategory("Reportes");

//$excel->getDefaultStyle()->getFont('A1:F1')->setSize(18);

$hojaActiva->getStyle('A1:Q1')->getFill()->setFillType(Fill::FILL_SOLID)
->getStartColor()->setARGB('142667');

$hojaActiva->getStyle('A1:Q1')->getFont()->setSize(14)->setName('Arial')->getColor()->setARGB('e7e7e7');

$hojaActiva->getColumnDimension('A')->setWidth(10);
$hojaActiva->setCellValue('A1', 'Orden de Compra');
$hojaActiva->getColumnDimension('B')->setWidth(25);
$hojaActiva->setCellValue('B1', 'Documento');
$hojaActiva->getColumnDimension('C')->setWidth(25);
$hojaActiva->setCellValue('C1', 'Proveedor');
$hojaActiva->getColumnDimension('D')->setWidth(15);
$hojaActiva->setCellValue('D1', 'Fecha Emision');
$hojaActiva->getColumnDimension('E')->setWidth(20);
$hojaActiva->setCellValue('E1', 'Almacen');
$hojaActiva->getColumnDimension('F')->setWidth(30);
$hojaActiva->setCellValue('F1', 'Referencia');
$hojaActiva->getColumnDimension('G')->setWidth(25);
$hojaActiva->setCellValue('G1', 'Valor O.C.');
$hojaActiva->getColumnDimension('H')->setWidth(25);
$hojaActiva->setCellValue('H1', 'Valor E.C.');
$hojaActiva->getColumnDimension('I')->setWidth(15);
$hojaActiva->setCellValue('I1', 'Moneda');
$hojaActiva->getColumnDimension('J')->setWidth(25);
$hojaActiva->setCellValue('J1', 'Condicion');
$hojaActiva->getColumnDimension('K')->setWidth(20);
$hojaActiva->setCellValue('K1', 'Fecha Carga Archivos');
$hojaActiva->getColumnDimension('L')->setWidth(15);
$hojaActiva->setCellValue('L1', 'Fecha de Revision');
$hojaActiva->getColumnDimension('M')->setWidth(20);
$hojaActiva->setCellValue('M1', 'Fecha Aprox de Pago');
$hojaActiva->getColumnDimension('N')->setWidth(20);
$hojaActiva->setCellValue('N1', 'Importe Total');
$hojaActiva->getColumnDimension('O')->setWidth(15);
$hojaActiva->setCellValue('O1', 'Estatus');
$hojaActiva->getColumnDimension('P')->setWidth(20);
$hojaActiva->setCellValue('P1', 'Comentarios Tamex');
$hojaActiva->getColumnDimension('Q')->setWidth(25);
$hojaActiva->setCellValue('Q1', 'Comentarios Proveedor');
//->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

//$spreadsheet->getActiveSheet()->getStyle('A1:D4')
    //->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

//setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Para crear siguiente hoja
$hojaActiva3 = $excel->createSheet(1);

// Generale el nombre de hoja para que confirmes que tienes la hoja creada
$hojaActiva3->setTitle('Partidas'); 
$hojaActiva3->getStyle('A1:L1')->getFill()->setFillType(Fill::FILL_SOLID)
->getStartColor()->setARGB('142667');
$hojaActiva3->getStyle('A1:L1')->getFont()->setSize(14)->setName('Arial')->getColor()->setARGB('e7e7e7');

$hojaActiva3->getColumnDimension('A')->setWidth(15);
$hojaActiva3->setCellValue('A1', 'Orden Compra');
$hojaActiva3->getColumnDimension('B')->setWidth(15);
$hojaActiva3->setCellValue('B1', 'Entrada Compra');
$hojaActiva3->getColumnDimension('C')->setWidth(15);
$hojaActiva3->setCellValue('C1', 'Articulo');
$hojaActiva3->getColumnDimension('D')->setWidth(25);
$hojaActiva3->setCellValue('D1', 'Descripcion');
$hojaActiva3->getColumnDimension('E')->setWidth(25);
$hojaActiva3->setCellValue('E1', 'Origen');
$hojaActiva3->getColumnDimension('F')->setWidth(15);
$hojaActiva3->setCellValue('F1', 'Costo');
$hojaActiva3->getColumnDimension('G')->setWidth(15);
$hojaActiva3->setCellValue('G1', 'Cantidad');
$hojaActiva3->getColumnDimension('H')->setWidth(15);
$hojaActiva3->setCellValue('H1', 'Descuento');
$hojaActiva3->getColumnDimension('I')->setWidth(15);
$hojaActiva3->setCellValue('I1', 'Importe');
$hojaActiva3->getColumnDimension('J')->setWidth(20);
$hojaActiva3->setCellValue('J1', 'Moneda');
$hojaActiva3->getColumnDimension('K')->setWidth(15);
$hojaActiva3->setCellValue('K1', 'Impuesto');
$hojaActiva3->getColumnDimension('L')->setWidth(20);
$hojaActiva3->setCellValue('L1', 'Descripcion Extra');

$fila=2;
$num=2;
while($datos = $busqRegistro->fetch(PDO::FETCH_ASSOC)){
    $estatusDocx = $sqlsrv->query("select * from cestatus where estatusid = ".$datos["estatusidfk"]."");
    $estatusDoc = $estatusDocx->fetch(PDO::FETCH_ASSOC);
    $nomEstatus = $estatusDoc["nombre"];
    $importeTotalx = $sqlsrv->query("select SUM(importe) sumaImporte from tfacturaImporte where MovIDfk = ".$datos["MovID"]."");
	$rowImp = $importeTotalx->fetch(PDO::FETCH_ASSOC);

    $datosArchivos = $sqlsrv->query("select convert(varchar(10),fecha,103) fechaIngresoDoc, convert(varchar(10),fechaRevision,103) fechaRevisionDoc, convert(varchar(10),fechaTenPago,103) fechaTenPago, nombreDiaIngreso, nombreDiaPago from archivosProveedores where factura = ".$datos["MovID"]." and estatusidfk = 3 order by fecha desc");
    $rowArchivo = $datosArchivos->fetch(PDO::FETCH_ASSOC);
    if(isset($rowArchivo["fechaIngresoDoc"])){$fechaArchivo = $rowArchivo["fechaIngresoDoc"]; $nomDiaIngreso = $rowArchivo["nombreDiaIngreso"];}else{$fechaArchivo = ''; $nomDiaIngreso = '';}
    if(isset($rowArchivo["fechaRevisionDoc"])){$fechaRevArchivo = $rowArchivo["fechaRevisionDoc"]; $nomDiaRev = 'MIERCOLES';}else{$fechaRevArchivo = ''; $nomDiaRev = '';}
    if(isset($rowArchivo["fechaTenPago"])){$fechaPago = $rowArchivo["fechaTenPago"]; $nomDiaPago = $rowArchivo["nombreDiaPago"];}else{$fechaPago = ''; $nomDiaPago = '';}

    $valorOC = number_format($datos["ImporteOC"], 2, '.', ',');
	$valorEC = number_format($datos["ImporteEC"], 2, '.', ',');
    $importeFac = number_format($rowImp["sumaImporte"], 2, '.', ',');
    //$facturaImporte = $datos["facturaProv"]. PHP_EOL .$importeFac;
        $excel->getDefaultStyle()->getFont('A'.$fila.':Q'.$fila,)->setName('Arial')->setSize(12);
        $hojaActiva->setCellValue('A'.$fila, $datos["IDOC"]);
        $hojaActiva->setCellValue('B'.$fila, $datos["Documento"]);
        $hojaActiva->setCellValue('C'.$fila, $datos["proveedor"]." ".$datos["NombrePoveedor"]);
        $hojaActiva->setCellValue('D'.$fila, $datos["FechaEmi"]);
        $hojaActiva->setCellValue('E'.$fila, $datos["Almacen"]);
        $hojaActiva->setCellValue('F'.$fila, $datos["Referencia"]);
        $hojaActiva->setCellValue('G'.$fila, "$ ".$valorOC);
        $hojaActiva->setCellValue('H'.$fila, "$ ".$valorEC);
        $hojaActiva->setCellValue('I'.$fila, $datos["moneda"]);
        $hojaActiva->setCellValue('J'.$fila, $datos["condicion"]);
        $hojaActiva->setCellValue('K'.$fila, $nomDiaIngreso." ".$fechaArchivo);
        $hojaActiva->setCellValue('L'.$fila, $nomDiaRev." ".$fechaRevArchivo);
        $hojaActiva->setCellValue('M'.$fila, $nomDiaPago." ".$fechaPago);
        $hojaActiva->setCellValue('N'.$fila, "$ ".$importeFac);
        $hojaActiva->setCellValue('O'.$fila, $nomEstatus);
        $hojaActiva->setCellValue('P'.$fila, $datos["comentariosTamex"]);
        $hojaActiva->setCellValue('Q'.$fila, $datos["comentariosProv"]);
        

        $partidas = $sqlsrv->query("select td.*,tp.Documento,tp.IDOC,tp.MovID from tpartidasXdocIntelisis as td 
        inner join tprovIntelisis as tp on (tp.ID=td.IDfk)
        where td.IDfk = ".$datos["ID"]."");
        if($fila == 2){$fila3=$num;}else
        {$fila3 = $fila3 + 1;}        
        while ($res = $partidas->fetch(PDO::FETCH_ASSOC)){
            if($res["Importe"]=='' || $res["Importe"]==' ' || $res["Importe"]=='NULL' || $res["Importe"]==NULL){$res["Importe"]=0;}
						if($res["Costo"]=='' || $res["Costo"]==' ' || $res["Costo"]=='NULL' || $res["Costo"]==NULL){$res["Costo"]=0;}
						if($res["Descuento"]=='' || $res["Descuento"]==' ' || $res["Descuento"]=='NULL' || $res["Descuento"]==NULL){$res["Descuento"]=0;}
                        $importe = number_format($res["Importe"], 2, '.', ',');
						$costo = number_format($res["Costo"], 2, '.', ',');						
						$descuento = number_format($res["Descuento"], 2, '.', ',');
        $excel->getDefaultStyle()->getFont('A'.$fila3.':L'.$fila3,)->setName('Arial')->setSize(12);
        $hojaActiva3->setCellValue('A'.$fila3, $res["IDOC"]);
        $hojaActiva3->setCellValue('B'.$fila3, $res["MovID"]);
        $hojaActiva3->setCellValue('C'.$fila3, $res["Articulo"]);
        $hojaActiva3->setCellValue('D'.$fila3, $res["Descripcion"]);
        $hojaActiva3->setCellValue('E'.$fila3, $res["Origen"]);
        $hojaActiva3->setCellValue('F'.$fila3, '$ '.$costo);
        $hojaActiva3->setCellValue('G'.$fila3, $res["Cantidad"]." ".$res["Unidad"]);
        $hojaActiva3->setCellValue('H'.$fila3, '$ '.$descuento);
        $hojaActiva3->setCellValue('I'.$fila3, '$ '.$importe);
        $hojaActiva3->setCellValue('J'.$fila3, $res["Moneda"]);
        $hojaActiva3->setCellValue('K'.$fila3, $res["Impuesto1"]);
        $hojaActiva3->setCellValue('L'.$fila3, $res["DescripcionExtra"]);
        $fila3++;
        }
        $fila++;
}


// Para crear siguiente hoja
$hojaActiva2 = $excel->createSheet(2);

// Generale el nombre de hoja para que confirmes que tienes la hoja creada
$hojaActiva2->setTitle('Facturas'); 
$hojaActiva2->getStyle('A1:M1')->getFill()->setFillType(Fill::FILL_SOLID)
->getStartColor()->setARGB('142667');
$hojaActiva2->getStyle('A1:M1')->getFont()->setSize(14)->setName('Arial')->getColor()->setARGB('e7e7e7');

$hojaActiva2->getColumnDimension('A')->setWidth(20);
$hojaActiva2->setCellValue('A1', 'Factura');
$hojaActiva2->getColumnDimension('B')->setWidth(15);
$hojaActiva2->setCellValue('B1', 'Importe');
$hojaActiva2->getColumnDimension('C')->setWidth(25);
$hojaActiva2->setCellValue('C1', 'Orden Compra');
$hojaActiva2->getColumnDimension('D')->setWidth(25);
$hojaActiva2->setCellValue('D1', 'Entrada Compra');
$hojaActiva2->getColumnDimension('E')->setWidth(20);
$hojaActiva2->setCellValue('E1', 'Usuario');
$hojaActiva2->getColumnDimension('F')->setWidth(30);
$hojaActiva2->setCellValue('F1', 'Fecha Captura');
$hojaActiva2->getColumnDimension('G')->setWidth(30);
$hojaActiva2->setCellValue('G1', 'Moneda');
$hojaActiva2->getColumnDimension('H')->setWidth(30);
$hojaActiva2->setCellValue('H1', 'Impuesto');
$hojaActiva2->getColumnDimension('I')->setWidth(30);
$hojaActiva2->setCellValue('I1', 'Total Imp Retenidos');
$hojaActiva2->getColumnDimension('J')->setWidth(30);
$hojaActiva2->setCellValue('J1', 'Total Imp Trasladados');
$hojaActiva2->getColumnDimension('K')->setWidth(38);
$hojaActiva2->setCellValue('K1', 'uuid');
$hojaActiva2->getColumnDimension('L')->setWidth(38);
$hojaActiva2->setCellValue('L1', 'RFC Emisor');
$hojaActiva2->getColumnDimension('M')->setWidth(38);
$hojaActiva2->setCellValue('M1', 'Nombre Emisor');

$fila2=2;
while($rowFac = $facturas->fetch(PDO::FETCH_ASSOC)){
    $importeFactura = number_format($rowFac["importe"], 2, '.', ',');
    $totalImpRet = number_format($rowFac["totalImpRet"], 2, '.', ',');
    $totalImpTras = number_format($rowFac["totalImpTras"], 2, '.', ',');
    $excel->getDefaultStyle()->getFont('A'.$fila2.':M'.$fila2,)->setName('Arial')->setSize(12);
        $hojaActiva2->setCellValue('A'.$fila2, $rowFac["factura"]);
        $hojaActiva2->setCellValue('B'.$fila2, '$ '.$importeFactura);
        $hojaActiva2->setCellValue('C'.$fila2, $rowFac["IDOC"]);
        $hojaActiva2->setCellValue('D'.$fila2, $rowFac["MovIDfk"]);
        $hojaActiva2->setCellValue('E'.$fila2, $rowFac["nombreusuario"]);
        $hojaActiva2->setCellValue('F'.$fila2, $rowFac["fechaIngreso"]);
        $hojaActiva2->setCellValue('G'.$fila2, $rowFac["moneda"]);
        $hojaActiva2->setCellValue('H'.$fila2, $rowFac["TasaImpuesto"]);
        $hojaActiva2->setCellValue('I'.$fila2, '$ '.$totalImpRet);
        $hojaActiva2->setCellValue('J'.$fila2, '$ '.$totalImpTras);
        $hojaActiva2->setCellValue('K'.$fila2, $rowFac["uuid"]);
        $hojaActiva2->setCellValue('L'.$fila2, $rowFac["rfcEmisor"]);
        $hojaActiva2->setCellValue('M'.$fila2, $rowFac["nombreEmisor"]);
        $fila2++;
}

// redirect output to client browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporteOCyEC.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($excel, 'Xlsx');
$writer->save('php://output');
exit;

/*$spreadsheet->getProperties()->setCreator("Sistema Tamex")->setTitle("Documentos");

$spreadsheet->setActiveSheetIndex(0);
$hojaActiva = $spreadsheet->getActiveSheet();

$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
$spreadsheet->getDefaultStyle()->getFont('A1')->setSize(14);

$hojaActiva->getColumnDimension('A1')->setWidth(20);
$hojaActiva->getColumnDimension('B1')->setWidth(10);
$hojaActiva->getColumnDimension('D1')->setWidth(250);*/





/*$writer = new Xlsx($spreadsheet);
$writer->save('reporteDocumento.xlsx');*/
