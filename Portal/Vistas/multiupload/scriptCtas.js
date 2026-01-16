/*
    https://parzibyte.me/blog
*/
// Elementos del DOM
var usuarioid=0; var doc='';
function lanzadera(documento,usuarioID){//alert(doc+"-"+usuarioid);
doc=documento;
usuarioid=usuarioID;
    traeDocAcuse(doc,usuarioid);
    traeDocFactura(doc,usuarioid);
    traeDocXml(doc,usuarioid);
}


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