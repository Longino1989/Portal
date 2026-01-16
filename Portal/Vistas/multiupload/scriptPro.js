// Elementos del DOM
var usuarioid=0; var doc='';
function lanzadera(documento,usuarioID){//alert(doc+"-"+usuarioid);
doc=documento;
usuarioid=usuarioID;
    traeDocAcuse(doc,usuarioid);
    traeDocFactura(doc,usuarioid);
    traeDocXml(doc,usuarioid);
}

const $inputArchivosAcuse = document.querySelector("#inputArchivosAcuse"),
    $btnEnviarAcuse = document.querySelector("#btnEnviarAcuse"),
    $estadoAcuse = document.querySelector("#estadoAcuse"),
    $docAcuse = document.querySelector("#documento"),
    $userAcuse = document.querySelector("#usuario");
$btnEnviarAcuse.addEventListener("click", async () => {
    const archivosParaSubirAcuse = $inputArchivosAcuse.files;
    const docAcusex = $docAcuse.value;
    const usuarioAcusex = $userAcuse.value;
    if (archivosParaSubirAcuse.length <= 0) {swal("Sin Acuse!","Seleccione un archivo tipo Acuse","warning",{button: "Aceptar"}); return false;
        // Si no hay archivos, no continuamos
    }
    // Preparamos el formdata
    const formData = new FormData();
    formData.append("docAcusex", docAcusex); //alert(docAcusex);
    formData.append("usuarioAcusex", usuarioAcusex); //alert(usuarioAcusex);
    // Agregamos cada archivo a "archivosAcuse[]". Los corchetes son importantes
    for (const archivoAcuse of archivosParaSubirAcuse) {
        formData.append("archivosAcuse[]", archivoAcuse);

        /*var arr1 = archivoAcuse.toString().split(" "); // Devuelve [object Object]
        alert(arr1[0]); return false;
        var ext = arr1[0].toString().split(".");
        alert(ext[1]); return false;
        var ext = archivoAcuse.split(".");
        alert(ext[0]+"-"+ext[1]); return false
        if (ext[1]!=pdf || ext[1]!=PDF){ 
            // extension is not allowed 
            $estadoAcuse.textContent = "Solo se permiten archivos PDF.";
            return false;
        }*/
    }
    
    // Los enviamos
    $estadoAcuse.textContent = "Enviando archivos Acuse...";
    const respuestaRaw = await fetch("./subirAcuse.php", {
        method: "POST",
        body: formData,
    });
    const respuesta = await respuestaRaw.json();
    // Puedes manejar la respuesta como tú quieras
    console.log({ respuesta });
    // Finalmente limpiamos el campo
    $inputArchivosAcuse.value = null;
    $estadoAcuse.textContent = "Archivos Acuse enviados";
    traeDocAcuse(doc,usuarioid);//{alert('Entra Funcion')}
    actualizaPagPrin(doc);
});


function traeDocAcuse(doc,usuarioid){//alert(doc+"-"+usuarioid);
    $.ajax({
   url: './traeArchivosAcuseProv.php',
   type: 'POST',
  async: true,
  data: 'docx='+doc+'&usuarioidx='+usuarioid,
  dataType: 'text',
  success: function Respuesta(result){//alert(result);
  document.getElementById('filesAcuse').innerHTML = result;
  /*document.getElementById('divBusqueda').style.display= 'block';*/
 },
  error: Error
  });
}


/*-----------------------------------------------------------------------*/
const $inputArchivosFactura = document.querySelector("#inputArchivosFactura"),
    $btnEnviarFactura = document.querySelector("#btnEnviarFactura"),
    $estadoFactura = document.querySelector("#estadoFactura"),
    $docFactura = document.querySelector("#documentoFactura"),
    $userFactura = document.querySelector("#usuarioFactura");
$btnEnviarFactura.addEventListener("click", async () => {
    const docFacturax = $docFactura.value;
    const usuarioFacturax = $userFactura.value;
    const archivosParaSubirFactura = $inputArchivosFactura.files;
    if (archivosParaSubirFactura.length <= 0) {swal("Sin Factura!","Seleccione un archivo tipo Factura","warning",{button: "Aceptar"}); return false;
        // Si no hay archivos, no continuamos
    }
    // Preparamos el formdata
    const formData = new FormData();
    formData.append("docFacturax", docFacturax); 
    formData.append("usuarioFacturax", usuarioFacturax); 
    // Agregamos cada archivo a "archivosFactura[]". Los corchetes son importantes
    for (const archivoFactura of archivosParaSubirFactura) {
        formData.append("archivosFactura[]", archivoFactura);
    }
    // Los enviamos
    $estadoFactura.textContent = "Enviando archivos Factura...";
    const respuestaRaw = await fetch("./subirFactura.php", {
        method: "POST",
        body: formData,
    });
    const respuesta = await respuestaRaw.json();
    // Puedes manejar la respuesta como tú quieras
    console.log({ respuesta });
    // Finalmente limpiamos el campo
    $inputArchivosFactura.value = null;
    $estadoFactura.textContent = "Archivos Factura enviados";
    traeDocFactura(doc,usuarioid);
    actualizaPagPrin(doc);
});

function traeDocFactura(doc,usuarioid){//alert(doc+"-"+usuarioid);
    $.ajax({
   url: './traeArchivosFacturaProv.php',
   type: 'POST',
  async: true,
  data: 'docx='+doc+'&usuarioidx='+usuarioid,
  dataType: 'text',
  success: function Respuesta(result){//alert(result);
  document.getElementById('filesFactura').innerHTML = result;
  /*document.getElementById('divBusqueda').style.display= 'block';*/
 },
  error: Error
  });
}


/*-----------------------------------------------------------------------*/
const $inputArchivosXml = document.querySelector("#inputArchivosXml"),
    $btnEnviarXml = document.querySelector("#btnEnviarXml"),
    $estadoXml = document.querySelector("#estadoXml"),
    $docXml = document.querySelector("#documentoXml"),
    $userXml = document.querySelector("#usuarioXml");
$btnEnviarXml.addEventListener("click", async () => {
    const docXmlx = $docXml.value;
    const usuarioXmlx = $userXml.value;
    const archivosParaSubirXml = $inputArchivosXml.files;
    if (archivosParaSubirXml.length <= 0) {swal("Sin XML!","Seleccione un archivo tipo Xml","warning",{button: "Aceptar"}); return false;
        // Si no hay archivos, no continuamos
    }
    // Preparamos el formdata
    const formData = new FormData();
    formData.append("docXmlx", docXmlx); 
    formData.append("usuarioXmlx", usuarioXmlx);
    // Agregamos cada archivo a "archivosXml[]". Los corchetes son importantes
    for (const archivoXml of archivosParaSubirXml) {
        formData.append("archivosXml[]", archivoXml);
    }
    // Los enviamos
    $estadoXml.textContent = "Enviando archivos Xml...";
    const respuestaRaw = await fetch("./subirXml.php", {
        method: "POST",
        body: formData,
    });
    const respuesta = await respuestaRaw.json();
    // Puedes manejar la respuesta como tú quieras
    console.log({ respuesta });
    // Finalmente limpiamos el campo
    $inputArchivosXml.value = null;
    $estadoXml.textContent = "Archivos Xml enviados";
    traeDocXml(doc,usuarioid);
    actualizaPagPrin(doc);
    actualizaImporteTabla(doc);
    actualizaDivFacturas(doc);
});

function traeDocXml(doc,usuarioid){//alert(doc+"-"+usuarioid);
    $.ajax({
   url: './traeArchivosXmlProv.php',
   type: 'POST',
  async: true,
  data: 'docx='+doc+'&usuarioidx='+usuarioid,
  dataType: 'text',
  success: function Respuesta(result){//alert(result);
  document.getElementById('filesXml').innerHTML = result;
  /*document.getElementById('divBusqueda').style.display= 'block';*/
 },
  error: Error
  });
}



function actualizaPagPrin(doc){//alert(doc);
    window.opener.actualizaTabla(doc);
    //window.close();
    }
    function agregarFila(doc){//alert(doc); //return false;
        var conv = document.getElementById('contadorInput'+doc).name;
        var con = parseInt(conv); 
        var con2 = con+1;
        var d1 = con; d2 ='<input id="factura'+doc+''+conv+'" placeholder="Ingresa Factura..." name="'+doc+''+conv+'" />'; d3='<input id="importe'+doc+''+conv+'" placeholder="$0.00" name="'+doc+''+conv+'" onkeypress="mascara(this,cpf)"/>'; d4='<img src="imgs/guardarpequeno.bmp" id="guardarDatos'+doc+''+conv+'" style="cursor:pointer"; title="Guardar Factura e Importe" onclick="guardaFacturaImporte('+doc+',factura'+doc+''+conv+'.value,importe'+doc+''+conv+'.value,'+conv+');"/>';   
        var table = document.getElementById('tablaNuevoRegistro'+doc); 
        var row = table.insertRow(-1);
        row.id='rowEnt'+con;
    $.ajax({
      url: '',
      type: 'POST',
      async: true,
      data: '',
      dataType: "text",
      success: function Respuesta(result){//d9=result
      //celNum = row.insertCell(-1);  text1 = d1;  celNum.innerHTML=text1;
      celFac = row.insertCell(-1);  text2 = d2;  celFac.innerHTML=text2;
      celImp = row.insertCell(-1);  text3 = d3;  celImp.innerHTML=text3;
      celGua = row.insertCell(-1);  text4 = d4;  celGua.innerHTML=text4;
      document.getElementById('contadorInput'+doc).name=con2;
      //document.getElementById('clavePedido'+doc+conv).focus();
      },
      error: Error
     });
    }

    function guardaFacturaImporte(movID,factura,importe,contador){//alert(usuarioid+"-"+movID+"-"+factura+"-"+importe+"-"+contador);
    if(factura=='' || factura==' '){swal("Campos Vacios!","Ingresa factura valida", "warning", {button: "Aceptar"}); return false;}
    if(importe=='' || importe==' '){swal("Campos Vacios!","Ingresa el importe de la factura", "warning", {button: "Aceptar"}); return false;}
    /*var tam = factura.length;
    for(i=0;i<tam;i++){
        if(!isNaN(val[i]) && val[i] != " ")
        document.getElementById("factura"+movID).value='';
        }*/
        $.ajax({
                url: '../../PROVEEDORES/php/guardaDatosDoc.php',
                type: 'POST',
                async: true,
                data:  'usuarioidx='+usuarioid+'&movIDx='+movID+'&facturax='+factura+'&importex='+importe+'&contadorx='+contador,
                success: function Respuesta(result){//alert(result);
                    if(result == 'sinUser'){alert('Error por falta de usuarioid'); return -1;}
                    var arr = result.split('||'); //alert(arr[2]);
                    document.getElementById('divTablaFacturas'+movID).innerHTML = arr[1];
                    actualizaImporteTabla(movID);
                    //if(result=='facturaVacia'){swal("Campos Vacios!","Ingresa factura valida", "warning", {button: "Aceptar"}); return false;}
                    //if(result=='' || result==' '){swal("Datos","Guardados Correctamente", "success", {button: "Aceptar"});}

                    //else{
                      //  alert('Error al guardar'); return false;
                    //}
                    },
        error: Error
        });
    }
    function actualizaImporteTabla(movID){//alert(doc);
        window.opener.actualizaImporte(movID);
        //window.close();
        }
        function actualizaDivFacturas(movID){//alert(movID);
            $.ajax({
                url: '../../PROVEEDORES/php/traeTablaFacturas.php',
                type: 'POST',
                async: true,
                data: 'movIDx='+movID,
                success: function resp(result){//alert(result);
                        var arr = result.split('||'); //alert(arr[1]);
                    document.getElementById('divTablaFacturas'+movID).innerHTML = arr[1];
                },
                error: Error
                });
            }
function enviaAcuse(movID){alert(movID);
        $.ajax({
        url: './validaArchivosAdjuntos.php',
        type: 'POST',
        async: true,
        data: 'movIDx='+movID+'&usuarioidx='+usuarioid,
        dataType: 'text',
        success: function Respuesta(result){alert(result);
            if(result == 'sinAcuse'){swal("Sin ACUSE!","Seleccione un archivo tipo Acuse","warning",{button: "Aceptar"})}
            if(result == 'sinFactura'){swal("Sin XML!","Seleccione un archivo tipo Xml","warning",{button: "Aceptar"})}
            if(result == 'sinXml'){console.log({ sinXml });}
            if(result == 'completo'){console.log({ Completo });}
            console.log({ result });
        },
        error: Error
        });
        }