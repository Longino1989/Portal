function guardaPass(userID,passActual,passNueva,confPass){//alert(userID+"-"+passActual+"-"+passNueva+"-"+confPass);
    if(passActual == '' || passActual == ' '){Swal.fire({title:"",text:"Escribe tu contraseña Actual!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}//alert('Escribe tu contraseña Actual!');
    if(passNueva == '' || passNueva == ' '){swal.fire({title:"",text:"Escribe tu Nueva contraseña!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}//alert('Escribe tu Nueva contraseña');
    if(confPass == '' || confPass == ' '){swal.fire({title:"",text:"Confirma tu Nueva contraseña!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}//alert('Confirma tu Nueva contraseña');
    $.ajax({
        url: './cambiaPassAuten.php',
        type: 'POST',
        async: true,
        data: 'userIDx='+userID+'&passActualx='+passActual+'&passNuevax='+passNueva+'&confPassx='+confPass,
        success: function Respuesta(result){//alert(result);
            if(result == '' || result == ' '){swal.fire({title:"Excelente",text:"Se cambio tu contraseña",icon:"success",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}).then((result) => { if(result.isConfirmed){document.location.href='../index.html';}});
        }else{
                if(result == 2){swal.fire({title:"Contraseña DEBIL!",text:"Ingresa al menos 8 caracteres",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"}); return false;}//alert('Contraseña corta. Ingresa al menos 8 caracteres');
                if(result == 0){swal.fire({title:"Incorrecta!",text:"Tu contraseña Actual es distinta.",icon:"error",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"});//alert('Tu contraseña actual es incorrecta!');
                    document.getElementById("passActualAuten").value = ""; return false;}
                if(result == 1){swal.fire({title:"",text:"Confirma tu nueva contraseña de manera correcta!",icon:"warning",confirmButtonText: "Aceptar",confirmButtonColor: "#142667"});//alert('Confirma tu nueva contraseña de manera correcta!'); 
                    document.getElementById("passNuevaAuten").value = "";
                    document.getElementById("confPassAuten").value = "";
                    return false;}
                }
        },
    error: Error
    });					 
    }
function limpiarPassAuten(){
    document.getElementById("passNuevaAuten").value = "";
    document.getElementById("confPassAuten").value = "";
    document.getElementById("passActualAuten").value = "";
    }