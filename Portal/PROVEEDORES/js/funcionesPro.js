var usuarioID=0; //var result='';
function cargaTabla(ordenC,entradaCom,estatus,proveedor,fechaIni,fechaFin,tipoFecha){//alert(ordenC+"--"+entradaCom+"--"+estatus+"--"+proveedor+"--"+fechaIni+"--"+fechaFin);
    usuarioID=document.getElementById('imgUsuID').name;
    //document.getElementById('buscarPro').disabled = true;
    //$('#buscarPro').attr('disabled', true);

//alert(proveedor);
    if(ordenC=='' || ordenC == ' '){ordenC=0;}
    if(entradaCom == '' || entradaCom == ' '){entradaCom = 0;}
    if(proveedor == '' || proveedor == ' '){Swal.fire({title:"",text:"Selecciona un Proveedor!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
    if(estatus == '' || estatus == ' '){Swal.fire({title:"",text:"Selecciona un Estatus!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
    $.ajax({
            url: 'php/cargaTabla.php',
            type: 'POST',
            async: true,
            data: 'usuarioIDx='+usuarioID+'&ordenCx='+ordenC+'&entradaComx='+entradaCom+'&estatusx='+estatus+'&proveedorx='+proveedor+'&fechaInix='+fechaIni+'&fechaFinx='+fechaFin+'&tipoFechax='+tipoFecha,
            success: function Respuesta(result){// alert(result);
            //document.getElementById('buscarPro').disabled = false;
           // $('#buscarPro').attr('disabled', false);
            document.getElementById('contenido').innerHTML=(result);
                },
    error: Error
    });					 
    }

function subirAcuseProv(reporte,usid){//alert(reporte+"-"+usid);//var arr = folio.split('-');
        window.open("../Vistas/uploader/indexAcuseProveedores.html?documento="+reporte+'-'+usuarioID,"VerImagenes","width=650,height=500,scrollbars=YES")
    }
        function subirFacturaProv(reporte,usid){//alert(reporte+"-"+usid);//var arr = folio.split('-');
            window.open("../Vistas/uploader/indexFacturaProveedores.html?documento="+reporte+'-'+usuarioID,"VerImagenes","width=650,height=500,scrollbars=YES")
            }
            function subirXmlProv(reporte,usid){//alert(reporte+"-"+usid);//var arr = folio.split('-');
                window.open("../Vistas/uploader/indexXmlProveedores.html?documento="+reporte+'-'+usuarioID,"VerImagenes","width=650,height=500,scrollbars=YES")
                }
function buscaFactura(factura){//alert(factura);
    //if(factura==''){factura = 1}
    $.ajax({
            url: 'php/cargaTabla.php',
            type: 'POST',
            async: true,
            data:  'usuarioIDx='+usuarioID+'&facturax='+factura,
            success: function Respuesta(result){//alert(result);
            document.getElementById('contenido').innerHTML+=result;
            
                },
    error: Error
    });
}
function detalleDocumento(id){
    id = window.btoa(id);
    usuarioID = window.btoa(usuarioID);
    window.open("php/detalleDocumento.php?T3JkZW5Db21w="+id+"&dXNlclRhbWV4="+usuarioID,"VerDetalle","width=700,height=600,scrollbars=YES")
}
function detallePdf(id){
    id = window.btoa(id);
    usuarioID = window.btoa(usuarioID);
    window.open("php/detallePdf.php?T3JkZW5Db21w="+id+"&dXNlclRhbWV4="+usuarioID,"VerDetalle","width=700,height=600,scrollbars=YES")
}
function reporteExcelPro(buscaordenC,entradaCom,estatus,proveedor,fechaIni,fechaFin,tipoFecha){//alert(buscaordenC+"-"+entradaCom+"-"+estatus+"--"+proveedor+"-"+fechaIni+"-"+fechaFin);
    if(buscaordenC=='' || buscaordenC == ' '){buscaordenC=0;}
    if(entradaCom=='' || entradaCom==' '){entradaCom=0;}
    if(estatus == '' || estatus == ' '){Swal.fire({title:"",text:"Selecciona un Estatus!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
    if(proveedor == ''){Swal.fire({title:"",text:"Selecciona un Proveedor!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
    if(usuarioID == 0){Swal.fire({title:"",text:"Da click en Buscar antes de exportar a Excel!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
    window.open("php/reporteProvExcel.php?usuarioIDx="+usuarioID+"&buscaordenCx="+buscaordenC+"&entradaComx="+entradaCom+"&estatusx="+estatus+"&proveedorx="+proveedor+"&fechaInix="+fechaIni+"&fechaFinx="+fechaFin+'&tipoFechax='+tipoFecha,"ReporteExcelProv","width=500,height=400,top=50,left=50,scrollbars=YES")
    }
function guardaComentarioProv(comentario,movID){//alert(comentario + movID);
    if(comentario == '' || comentario == ' '){swal("Campo Vacio!","Escribe un comentario","warning",{button: "Aceptar"}); return false;}
        $.ajax({
                url: 'php/guardaComentario.php',
                type: 'POST',
                async: true,
                data:  'usuarioIDx='+usuarioID+'&comentariox='+comentario+'&movIDx='+movID,
                success: function Respuesta(result){//alert(result);
                    var arr = result.split('||'); //alert(arr[1])
                    document.getElementById('comentario'+movID).value='';
                    document.getElementById('comProv'+movID).value = arr[1]; 
                    },
        error: Error
        });
    }
function abrirMultiupload(reporte){//alert(reporte);
        reporte = window.btoa(reporte);
        userID = window.btoa(usuarioID);
        window.open("../Vistas/multiupload/index.php?dXNlclRhbWV4="+userID+"&T3JkZW5Db21w="+reporte,"Multiupload","width=750,height=600,scrollbars=YES")
    }
function mascara(o,f){  
	v_obj=o;  
		v_fun=f;  
	setTimeout("execmascara()",1);
}  
function execmascara(){   
	v_obj.value=v_fun(v_obj.value);
}  
function cpf(v){     
	v=v.replace(/([^0-9\.]+)/g,'');
	v=v.replace(/^[\.]/,''); 
	v=v.replace(/[\.][\.]/g,''); 
	v=v.replace(/\.(\d)(\d)(\d)/g,'.$1$2'); 
	v=v.replace(/\.(\d{1,2})\./g,'.$1'); 
	v = v.toString().split('').reverse().join('').replace(/(\d{3})/g,'$1,');    
	v = v.split('').reverse().join('').replace(/^[\,]/,''); 
	return v;  
} 
function actualizaTabla(doc){//alert(doc);
    //var n=1;
    $.ajax({
        url: 'php/regresaValores.php',
        type: 'POST',
        async: true,
        data: 'docx='+doc,
        success: function resp(result){//alert(result);
        var arr = result.split('||');//alert(arr[1]);alert(arr[1]+"-"+arr[2]+"-"+arr[3]+"-"+arr[4];
            document.getElementById('tdFechaIngreso'+doc).innerHTML = arr[1];
            document.getElementById('tdFechaRevision'+doc).innerHTML = arr[2];
            document.getElementById('tdFechaPago'+doc).innerHTML = arr[3];
            document.getElementById('tdEstatus'+doc).innerHTML = arr[4];
        },
        error: Error
        });
    }
function actualizaImporte(movID){//alert(movID);
    $.ajax({
        url: 'php/traeImporte.php',
        type: 'POST',
        async: true,
        data: 'movIDx='+movID,
        success: function resp(result){//alert(result);
            var arr = result.split('||');//alert(arr[1])
            document.getElementById('tdImporteTotal'+movID).innerHTML = arr[1];
        },
        error: Error
        });
    }