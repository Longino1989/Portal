var usuarioID=0; //var result='';
function traeTabla(ordenCom,entradaCom,provID,estatusid,fechaIni,fechaFin,tipoFecha){//alert(ordenCom+"/"+entradaCom+"/"+provID+"/"+estatusid+"/"+fechaIni+"/"+fechaFin);
    //const startTime = performance.now();
    usuarioID=document.getElementById('imgUsuID').name;
    //usuarioID=usuario;
    if(ordenCom == '' || ordenCom == ' '){ordenCom = 0;}
    if(entradaCom == '' || entradaCom == ' '){entradaCom = 0;}
    $.ajax({
            url: 'php/cargaTablaCtas.php',
            type: 'POST',
            async: true,
            data: 'usuarioIDx='+usuarioID+'&ordenComx='+ordenCom+'&entradaComx='+entradaCom+'&provIDx='+provID+'&estatusidx='+estatusid+'&fechaInix='+fechaIni+'&fechaFinx='+fechaFin+'&tipoFechax='+tipoFecha,
            success: function Respuesta(result){// alert(result);
                var arr = result.split('||'); //alert(arr[1])
            document.getElementById('divTablaCuentasXpagar').innerHTML=(arr[0]);
                document.getElementById('spanEstatus').innerHTML=(arr[1]);
            //const duration = performance.now() - startTime;
            //console.log(`someMethodIThinkMightBeSlow took ${duration}ms`);
                },
    error: Error
    });					 
    };
    //Seleccionar Todos los Checkbox
    function marcar(){
    var checkbox = document.getElementById("confirmar");//alert(checkbox);
    var	form = document.forms["formElement"];//alert(form);
        if(checkbox.checked == true){
            for (i=0;i<form.elements.length;i++)
            {
                if(form.elements[i].type == "checkbox")form.elements[i].checked=1;
            }//alert(i);
        }else{
            for (i=0;i<form.elements.length;i++)
            {
            if(form.elements[i].type == "checkbox")form.elements[i].checked=0;
            }
        }
    }
function detalleDocumento(id){
    id = window.btoa(id);
    usuarioID = window.btoa(usuarioID);
        window.open("../PROVEEDORES/php/detalleDocumento.php?T3JkZW5Db21w="+id+"&dXNlclRhbWV4="+usuarioID,"VerDetalle","width=700,height=600,scrollbars=YES")
    }
function detallePdf(id){
    id = window.btoa(id);
    usuarioID = window.btoa(usuarioID);
        window.open("../PROVEEDORES/php/detallePdf.php?T3JkZW5Db21w="+id+"&dXNlclRhbWV4="+usuarioID,"VerDetalle","width=700,height=600,scrollbars=YES")
    }
function reporteExcelCtas(ordenCom,entradaCom,provID,estatusid,fechaIni,fechaFin,tipoFecha){//alert(ordenCom+"--"+provID+"--"+estatusid+"--"+fechaIni+"--"+fechaFin);
        if(ordenCom == '' || ordenCom == ' '){ordenCom = 0;}
        if(entradaCom == '' || entradaCom == ' '){entradaCom = 0;}
        if(provID == 0){Swal.fire({title:"",text:"Selecciona un Proveedor!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
        window.open("php/reporteCuentasExcel.php?usuarioIDx="+usuarioID+"&ordenComx="+ordenCom+"&entradaComx="+entradaCom+"&provIDx="+provID+"&estatusidx="+estatusid+"&fechaInix="+fechaIni+"&fechaFinx="+fechaFin+"&tipoFechax="+tipoFecha,"ReporteExcelProv","width=500,height=400,top=50,left=50,scrollbars=YES")
        }
        function guardaComentarioTamex(comentario,movID){//alert(comentario + movID);
            if(comentario=='' || comentario == ' '){//swal("Campo Vacio!","Escribe un comentario", "warning", {button: "Aceptar"}); return false;
            Swal.fire({title:"Campo Vacio!",text:"Escribe un comentario",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
            $.ajax({
                    url: 'php/guardaComTamex.php',
                    type: 'POST',
                    async: true,
                    data:  'usuarioIDx='+usuarioID+'&comentariox='+comentario+'&movIDx='+movID,
                    success: function Respuesta(result){//alert(result);
                        var arr = result.split('||'); //alert(arr[1])
                        document.getElementById('comentarioTamex'+movID).value='';
                        document.getElementById('comTamex'+movID).value = arr[1]; 
                        },
            error: Error
            });
        }
        function abrirMultiupload(reporte){//alert(reporte);
            reporte = window.btoa(reporte);
            userCID = window.btoa(usuarioID);
            window.open("../Vistas/multiupload/indexCtas.php?dXNlclRhbWV4="+userCID+"&T3JkZW5Db21w="+reporte,"Multiupload","width=750,height=600,scrollbars=YES")
        }
        function cambiaEstatus(movID,valorEstatus,ordenCom,entradaCom,numProv,estatusTabla,fechaIni,fechaFin,tipoFecha){//alert(movID+"-"+valorEstatus+"-"+ordenCom+"-"+entradaCom+"-"+numProv+"-"+estatusTabla);
            if(ordenCom=='' || ordenCom==' '){ordenCom=0;}
            $.ajax({
                    url: 'php/cambiaEstatus.php',
                    type: 'POST',
                    async: true,
                    data:  'usuarioIDx='+usuarioID+'&movIDx='+movID+'&valorEstatusx='+valorEstatus,
                    success: function Respuesta(result){//alert(result);
                        if(result=='' || result==' '){//swal("Estatus","Guardado Correctamente!", "success", {button: "Aceptar"});
                        Swal.fire({title:"Excelente",text:"Estatus Guardado Correctamente!",icon:"success",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"});}else{
                            console.log(result);
                        }
                        traeTabla(ordenCom,entradaCom,numProv,estatusTabla,fechaIni,fechaFin,tipoFecha); //usuario,ordenCom,provID,estatusid
                        },
            error: Error
            });
        }
        function cambiaEstatusLista(estatusNuevo,numProv,estatusActual,fechaIni,fechaFin){//alert(estatusNuevo+"-"+numProv+"-"+estatusActual+"-"+fechaIni+"-"+fechaFin);
        var listaEntradas = '';
        var	form = document.forms["formElement"];//alert(form);
        if(form!=undefined || form!=''){//alert('hi');
            for (i=0;i<form.elements.length;i++){
                if(form.elements[i].type == "checkbox" && form.elements[i].checked==1){listaEntradas=(','+form.elements[i].name).concat(listaEntradas);
                    /*alert(listaEntradas);*/};
                }
        }else{alert('No hay Entrada de Compra seleccionada'); return false;}
            $.ajax({
                    url: 'php/cambiaEstatusLista.php',
                    type: 'POST',
                    async: true,
                    data:  'listaEntradasx='+listaEntradas+'&usuarioIDx='+usuarioID+'&estatusNuevox='+estatusNuevo+'&numProvx='+numProv+'&estatusActualx='+estatusActual,
                    success: function Respuesta(result){//alert(result);
                        if(result == 'vacia'){//swal("Lista Vacia!","Selecciona una o mas Entradas de Compra", "warning", {button: "Aceptar"}); return false;
                        Swal.fire({title:"Lista Vacia!",text:"Selecciona una o mas Entradas de Compra",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
                        if(result=='' || result==' '){//swal("Estatus","Entradas Cambiadas Correctamente!", "success", {button: "Aceptar"});
                        Swal.fire({title:"Excelente",text:"Entradas cambiadas correctamente!",icon:"success",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"});}else{
                            console.log(result);
                        }
                        ordenCom = ''; entradaCom = '';
                        traeTabla(ordenCom,entradaCom,numProv,estatusActual,fechaIni,fechaFin); //usuario,ordenCom,provID,estatusid
                        
                        },
            error: Error
            });
        }    
        function activaSelect(value)
		{
			if(value==true)
			{
				// habilitamos
				document.getElementById("estatusDoc").disabled=false;
			}else if(value==false){
				// deshabilitamos
				document.getElementById("estatusDoc").disabled=true;
			}
		}   
        /*function actualizaTabla(usuarioID,numProv){
            window.opener.traeTabla(usuarioID,numProv);
        }*/