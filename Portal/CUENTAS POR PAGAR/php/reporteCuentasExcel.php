<?php

require '../../vistas/phpSpreadSheet/vendor/autoload.php';
//require ('permiso.php');
include('../../nuevaConexion.php');

$user = $_GET["usuarioIDx"];
$ordenCompra = $_GET["ordenComx"];
$entradaCompra = $_GET["entradaComx"];
$proveedor = $_GET["provIDx"];
$estatusid = $_GET["estatusidx"];
$fechaInicio = $_GET["fechaInix"];
$fechaFin = $_GET["fechaFinx"];
$tipoFecha = $_GET["tipoFechax"];
//$sd=conectar();
//echo $user."--".$ordenCompra."--".$entradaCompra."--".$proveedor."--".$estatusid."--".$fechaInicio."--".$fechaFin; return -1;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

if($ordenCompra != 0 || $entradaCompra != 0){
    if($ordenCompra != 0){$busqRegistro = $sqlsrv->query("select IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where IDOC like '%".$ordenCompra."%' order by FechaEmision desc, MovID");
        $facturas = $sqlsrv->query("select tf.*,tp.IDOC,tp.FechaEmision,tp.Referencia, cu.nombre nombreusuario, cu.usuario, tp.moneda,tp.TasaImpuesto,tp.moneda,tp.TasaImpuesto from tfacturaImporte as tf
        inner join cusuario as cu on (cu.usid=tf.usuarioidfk)
        inner join tprovIntelisis as tp on (tp.MovID=tf.MovIDfk)
        where tp.IDOC = ".$ordenCompra." order by tf.cont asc");
    }else{
        $busqRegistro = $sqlsrv->query("select IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where MovID like '%".$entradaCompra."%'");
        $facturas = $sqlsrv->query("select tf.*,tp.IDOC,tp.FechaEmision,tp.Referencia, cu.nombre nombreusuario, cu.usuario, tp.moneda,tp.TasaImpuesto from tfacturaImporte as tf
        inner join cusuario as cu on (cu.usid=tf.usuarioidfk)
        inner join tprovIntelisis as tp on (tp.MovID=tf.MovIDfk)
        where tf.MovIDfk = ".$entradaCompra." ");    
    }
}else{
    if($fechaInicio == '' || $fechaFin == ''){
        if($estatusid != 9){
            $busqRegistro = $sqlsrv->query("select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where proveedor like '".$proveedor."' and estatusidfk like '".$estatusid."' and estatusidfk not in(9) order by FechaEmision desc, IDOC");
            $facturas = $sqlsrv->query("select tf.*,tp.IDOC,tp.FechaEmision,tp.Referencia, cu.nombre nombreusuario, cu.usuario, tp.moneda,tp.TasaImpuesto from tfacturaImporte as tf
            inner join cusuario as cu on (cu.usid=tf.usuarioidfk)
            inner join tprovIntelisis as tp on (tp.MovID=tf.MovIDfk)
            where tp.proveedor like '".$proveedor."' and tp.estatusidfk like '".$estatusid."' and tp.estatusidfk != 9 order by tp.IDOC"); 
        }else{
            $busqRegistro = $sqlsrv->query("select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where proveedor like '".$proveedor."' and estatusidfk = 9 order by FechaEmision desc, IDOC");
            $facturas = $sqlsrv->query("select tf.*,tp.IDOC,tp.FechaEmision,tp.Referencia, cu.nombre nombreusuario, cu.usuario, tp.moneda,tp.TasaImpuesto from tfacturaImporte as tf
            inner join cusuario as cu on (cu.usid=tf.usuarioidfk)
            inner join tprovIntelisis as tp on (tp.MovID=tf.MovIDfk)
            where tp.proveedor like '".$proveedor."' and tp.estatusidfk = 9 order by tf.cont asc"); 
        }
        }else{
            if($estatusid != 9){
            $busqRegistro = $sqlsrv->query("select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where proveedor like '".$proveedor."' and estatusidfk like '".$estatusid."' and estatusidfk not in(9) and convert(char(10),".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicio."',120) AND convert(VARCHAR(10),'".$fechaFin."',120) order by ".$tipoFecha." desc, IDOC");
            $facturas = $sqlsrv->query("select tf.*,tp.IDOC,tp.FechaEmision,tp.Referencia, cu.nombre nombreusuario, cu.usuario, tp.moneda,tp.TasaImpuesto from tfacturaImporte as tf
            inner join cusuario as cu on (cu.usid=tf.usuarioidfk)
            inner join tprovIntelisis as tp on (tp.MovID=tf.MovIDfk)
            where tp.proveedor like '".$proveedor."' and tp.estatusidfk like '".$estatusid."' and tp.estatusidfk != 9 and convert(char(10),tp.".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicio."',120) AND convert(VARCHAR(10),'".$fechaFin."',120) order by ".$tipoFecha." desc, tp.IDOC"); 
            }else{
            $busqRegistro = $sqlsrv->query("select top(400) IDOC,Documento,moneda,Almacen,Referencia,comentariosTamex,comentariosProv,MovID,ID,ImporteOC,ImporteEC,condicion,estatusidfk,facturaProv,importeFacProv, convert(varchar(10),FechaEmision,103) FechaEmi, convert(varchar(10),fechaIngreso,103) fechaIngre,convert(varchar(10),fechaActualizacion,103) fechaActu from tprovIntelisis where proveedor like '".$proveedor."' and estatusidfk = 9 and convert(char(10),".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicio."',120) AND convert(VARCHAR(10),'".$fechaFin."',120) order by ".$tipoFecha." desc, IDOC");
            $facturas = $sqlsrv->query("select tf.*,tp.IDOC,tp.FechaEmision,tp.Referencia, cu.nombre nombreusuario, cu.usuario, tp.moneda,tp.TasaImpuesto from tfacturaImporte as tf
            inner join cusuario as cu on (cu.usid=tf.usuarioidfk)
            inner join tprovIntelisis as tp on (tp.MovID=tf.MovIDfk)
            where tp.proveedor like '".$proveedor."' and tp.estatusidfk = 9 and convert(char(10),tp.".$tipoFecha.",120) BETWEEN convert(VARCHAR(10),'".$fechaInicio."',120) AND convert(VARCHAR(10),'".$fechaFin."',120) order by ".$tipoFecha." desc, tf.cont asc");
        }
    }
}
//$PDO_Intelisis = $sentencia->fetchAll(PDO::FETCH_OBJ);


//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet(0);
$hojaActiva->setTitle("Documento");
$excel -> getProperties()
                ->setTitle("Reporte Cuentas por Pagar")
                ->setLastModifiedBy("Sistema Tamex")
                ->setCreator("Sistema Tamex")
                ->setDescription("Reporte Generado para Cuentas X Pagar")
                ->setCategory("Cuentas");

//$excel->getDefaultStyle()->getFont('A1:F1')->setSize(18);

$hojaActiva->getStyle('A1:P1')->getFill()->setFillType(Fill::FILL_SOLID)
->getStartColor()->setARGB('142667');

$hojaActiva->getStyle('A1:P1')->getFont()->setSize(14)->setName('Arial')->getColor()->setARGB('e7e7e7');

$hojaActiva->getColumnDimension('A')->setWidth(10);
$hojaActiva->setCellValue('A1', 'Orden de Compra');
$hojaActiva->getColumnDimension('B')->setWidth(25);
$hojaActiva->setCellValue('B1', 'Documento');
$hojaActiva->getColumnDimension('C')->setWidth(15);
$hojaActiva->setCellValue('C1', 'Fecha Emision');
$hojaActiva->getColumnDimension('D')->setWidth(20);
$hojaActiva->setCellValue('D1', 'Almacen');
$hojaActiva->getColumnDimension('E')->setWidth(30);
$hojaActiva->setCellValue('E1', 'Referencia');
$hojaActiva->getColumnDimension('F')->setWidth(25);
$hojaActiva->setCellValue('F1', 'Valor O.C.');
$hojaActiva->getColumnDimension('G')->setWidth(25);
$hojaActiva->setCellValue('G1', 'Valor E.C.');
$hojaActiva->getColumnDimension('H')->setWidth(25);
$hojaActiva->setCellValue('H1', 'Moneda');
$hojaActiva->getColumnDimension('I')->setWidth(15);
$hojaActiva->setCellValue('I1', 'Condicion');
$hojaActiva->getColumnDimension('J')->setWidth(20);
$hojaActiva->setCellValue('J1', 'Fecha Carga Archivos');
$hojaActiva->getColumnDimension('K')->setWidth(15);
$hojaActiva->setCellValue('K1', 'Fecha de Revision');
$hojaActiva->getColumnDimension('L')->setWidth(20);
$hojaActiva->setCellValue('L1', 'Fecha Aprox de Pago');
//$hojaActiva->getColumnDimension('L')->setWidth(20);
//$hojaActiva->setCellValue('L1', 'Factura Prov');
$hojaActiva->getColumnDimension('M')->setWidth(20);
$hojaActiva->setCellValue('M1', 'Importe Total');
$hojaActiva->getColumnDimension('N')->setWidth(15);
$hojaActiva->setCellValue('N1', 'Estatus');
$hojaActiva->getColumnDimension('O')->setWidth(20);
$hojaActiva->setCellValue('O1', 'Comentarios Tamex');
$hojaActiva->getColumnDimension('P')->setWidth(25);
$hojaActiva->setCellValue('P1', 'Comentarios Proveedor');
//->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

//$spreadsheet->getActiveSheet()->getStyle('A1:D4')
    //->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

//setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

$fila=2;

while($datos = $busqRegistro->fetch(PDO::FETCH_ASSOC)){
    $estatusDocx = $sqlsrv->query("select * from cestatus where estatusid = ".$datos["estatusidfk"]."");
    $estatusDoc = $estatusDocx->fetch(PDO::FETCH_ASSOC);
    $nomEstatus = $estatusDoc["nombre"];
    $importeTotalx = $sqlsrv->query("select SUM(importe) sumaImporte from tfacturaImporte where MovIDfk = ".$datos["MovID"]."");
	$rowImp = $importeTotalx->fetch(PDO::FETCH_ASSOC);

    $datosArchivos = $sqlsrv->query("select convert(varchar(10),fecha,103) fechaIngresoDoc, convert(varchar(10),fechaRevision,103) fechaRevisionDoc, convert(varchar(10),fechaTenPago,103) fechaTenPago, nombreDiaIngreso, nombreDiaPago from archivosProveedores where factura = '".$datos["MovID"]."' and estatusidfk = 3 order by fecha desc");
    $rowArchivo = $datosArchivos->fetch(PDO::FETCH_ASSOC);
    if(isset($rowArchivo["fechaIngresoDoc"])){$fechaArchivo = $rowArchivo["fechaIngresoDoc"]; $nomDiaIngreso = $rowArchivo["nombreDiaIngreso"];}else{$fechaArchivo = ''; $nomDiaIngreso = '';}
    if(isset($rowArchivo["fechaRevisionDoc"])){$fechaRevArchivo = $rowArchivo["fechaRevisionDoc"]; $nomDiaRev = 'MIERCOLES';}else{$fechaRevArchivo = ''; $nomDiaRev = '';}
    if(isset($rowArchivo["fechaTenPago"])){$fechaPago = $rowArchivo["fechaTenPago"]; $nomDiaPago = $rowArchivo["nombreDiaPago"];}else{$fechaPago = ''; $nomDiaPago = '';}

    $valorOC = number_format($datos["ImporteOC"], 2, '.', ',');
	$valorEC = number_format($datos["ImporteEC"], 2, '.', ',');
    $importeFac = number_format($rowImp["sumaImporte"], 2, '.', ',');
    //$facturaImporte = $datos["facturaProv"]. PHP_EOL .$importeFac;
        $excel->getDefaultStyle()->getFont('A'.$fila.':P'.$fila,)->setName('Arial')->setSize(12);
        $hojaActiva->setCellValue('A'.$fila, $datos["IDOC"]);
        $hojaActiva->setCellValue('B'.$fila, $datos["Documento"]);
        $hojaActiva->setCellValue('C'.$fila, $datos["FechaEmi"]);
        $hojaActiva->setCellValue('D'.$fila, $datos["Almacen"]);
        $hojaActiva->setCellValue('E'.$fila, $datos["Referencia"]);
        $hojaActiva->setCellValue('F'.$fila, "$ ".$valorOC);
        $hojaActiva->setCellValue('G'.$fila, "$ ".$valorEC);
        $hojaActiva->setCellValue('H'.$fila, $datos["moneda"]);
        $hojaActiva->setCellValue('I'.$fila, $datos["condicion"]);
        $hojaActiva->setCellValue('J'.$fila, $nomDiaIngreso." ".$fechaArchivo);
        $hojaActiva->setCellValue('K'.$fila, $nomDiaRev." ".$fechaRevArchivo);
        $hojaActiva->setCellValue('L'.$fila, $nomDiaPago." ".$fechaPago);
        //$hojaActiva->setCellValue('L'.$fila, $datos["facturaProv"]);
        $hojaActiva->setCellValue('M'.$fila, "$ ".$importeFac);
        $hojaActiva->setCellValue('N'.$fila, $nomEstatus);
        $hojaActiva->setCellValue('O'.$fila, $datos["comentariosTamex"]);
        $hojaActiva->setCellValue('P'.$fila, $datos["comentariosProv"]);
        $fila++;
}


// Para crear siguiente hoja
$hojaActiva2 = $excel->createSheet(1);

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
header('Content-Disposition: attachment;filename="reporteCuentasDoc.xlsx"');
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
