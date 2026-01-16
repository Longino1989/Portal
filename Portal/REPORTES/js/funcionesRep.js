var usuarioID=0; //var result='';
function traeReporteOC(proveedor,fechaIni,fechaFin,tipoFecha){//alert(proveedor+"--"+fechaIni+"--"+fechaFin);
    usuarioID=document.getElementById('imgUsuID').name;
    //var arr = $("#selectEstatusRep").val();
    //var sumaEstatus = arr.reduce((total, actual) => total + actual);
    var selected = [];
    for (var option of document.getElementById('selectEstatusRep').options)
    {
        if (option.selected) {
            selected.push(option.value);
        }
    }//alert(selected);
    //usuarioID=usuario;
    //if(ordenC=='' || ordenC == ' '){ordenC=0;}
    //if(entradaCom == '' || entradaCom == ' '){entradaCom = 0;}
    if(selected == '' || selected == ' '){selected = '%'}
    $.ajax({
        url: 'php/reporteOC.php',
        type: 'POST',
        async: true,
        data: 'usuarioIDx='+usuarioID+'&proveedorx='+proveedor+'&selectedx='+selected+'&fechaInix='+fechaIni+'&fechaFinx='+fechaFin+'&tipoFechax='+tipoFecha,
        success: function Respuesta(result){// alert(result);
        document.getElementById('contenidoPrincipal').innerHTML=(result);
        document.getElementById('contenidoPrincipal').style.display='block';
        document.getElementById('cambiarContrasena').style.display='none';
                },
    error: Error
    });					 
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
    function abrirMultiupload(reporte){//alert(reporte);
        reporte = window.btoa(reporte);
        userID = window.btoa(usuarioID);
        window.open("../Vistas/multiupload/indexCtas.php?dXNlclRhbWV4="+userID+"&T3JkZW5Db21w="+reporte,"Multiupload","width=750,height=600,scrollbars=YES")
    }
    function reporteExcel(proveedor,fechaIni,fechaFin,tipoFecha){//alert(ordenCom+"--"+entradaCom+"--"+proveedor+"--"+estatusid+"--"+fechaIni+"--"+fechaFin);
        //if(ordenCom == '' || ordenCom == ' '){ordenCom = 0;}
        //if(entradaCom == '' || entradaCom == ' '){entradaCom = 0;}
        var selected = [];
    for (var option of document.getElementById('selectEstatusRep').options)
    {
        if (option.selected) {
            selected.push(option.value);
        }
    }//alert(selected);
    if(selected == '' || selected == ' '){selected = '%'}
        if(proveedor == 0){Swal.fire({title:"",text:"Selecciona un Proveedor!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
        if(usuarioID == 0){Swal.fire({title:"",text:"Da click en Buscar antes de exportar a Excel!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
        window.open("php/reporteExcel.php?usuarioIDx="+usuarioID+"&proveedorx="+proveedor+"&selectedx="+selected+"&fechaInix="+fechaIni+"&fechaFinx="+fechaFin+"&tipoFechax="+tipoFecha,"ReporteExcelProv","width=500,height=400,top=50,left=50,scrollbars=YES")
    }
    function configContrasena(user){//alert(user);
        $.ajax({
            url: 'php/cambiaContrasena.php',
            type: 'POST',
            async: true,
            data: 'userx='+user,
            success: function Respuesta(result){//alert(result);
            document.getElementById('cambiarContrasena').innerHTML=(result);
            document.getElementById('cambiarContrasena').style.display='block';
            document.getElementById('contenidoPrincipal').style.display='none';
                    },
        error: Error
        });					 
        }
    function guardaPass(userID,passActual,passNueva,confPass){alert(userID+"-"+passActual+"-"+passNueva+"-"+confPass);
        if(passActual == '' || passActual == ' '){Swal.fire({title:"",text:"Escribe tu contraseña Actual!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
        if(passNueva == '' || passNueva == ' '){Swal.fire({title:"",text:"Escribe tu Nueva contraseña!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
        if(confPass == '' || confPass == ' '){Swal.fire({title:"",text:"Confirma tu Nueva contraseña!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
        $.ajax({
            url: 'php/guardaNuevaContrasena.php',
            type: 'POST',
            async: true,
            data: 'userIDx='+userID+'&passActualx='+passActual+'&passNuevax='+passNueva+'&confPassx='+confPass,
            success: function Respuesta(result){//alert(result);
                if(result == '' || result == ' '){Swal.fire({title:"Excelente",text:"Se cambio tu contraseña",icon:"success",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"});
            }else{
                    if(result == 2){Swal.fire({title:"Contraseña DEBIL!",text:"Ingresa al menos 8 caracteres",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}
                    if(result == 0){Swal.fire({title:"Incorrecta!",text:"Tu contraseña Actual es distinta.",icon:"error",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"});
                        document.getElementById("passActual").value = ""; return false;}
                    if(result == 1){Swal.fire({title:"",text:"Confirma tu nueva contraseña de manera correcta!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"});
                        document.getElementById("passNueva").value = "";
                        document.getElementById("confPass").value = "";
                        return false;}
                    }
            },
        error: Error
        });					 
        }
    function limpiarPass(){
        document.getElementById("passNueva").value = "";
        document.getElementById("confPass").value = "";
        document.getElementById("passActual").value = "";
        }

