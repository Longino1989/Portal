var usuarioID=0;var seleccionada='',nueva_seleccionada=''; var tope=0; var a1=new Array(); var maxPestanas = 10; var comPendiente=0; var paisID=0;
// JavaScript Document
var idioma=0;
function usuario(pais,idiomas){//alert(idiomas);
usuarioID=document.getElementById('imgUsuID').name;
paisID=pais;
idioma=idiomas;
//document.getElementById('dir').innerHTML='CALL CENTER'+paisID;
var n=1;
if(usuarioID!='1'  && usuarioID!='51'){
$.ajax({
   url: 'php/cierraSesionCC.php',
   type: 'POST',
   async: true,
   data: 'nx='+n+'&usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){},
   error: Error
   });}
}


function editaRequerimiento(folio,requerimiento,area,solicito,fecsol,fecval,fecpro,feccom,estatus,obs,fecini,Porcentaje)
{//alert("funciones requ"+' '+folio+' '+requerimiento+' '+area+' '+solicito+' '+fecsol+' '+fecval+' '+fecpro+' '+feccom+' '+estatus+' '+obs+' '+fecini+' '+Porcentaje);


		if(requerimiento==''){alert('Captura el requerimiento'); return -1;}
		
  $.ajax({
  url: '../php/GuardaRequerimiento.php',
  type: 'POST',
  async: true,
  data: 'foliox='+folio+'&requerimientox='+requerimiento+'&areax='+area+'&solicitox='+solicito+'&fecsolx='+fecsol+'&fecvalx='+fecval+'&fecprox='+fecpro+'&feccomx='+feccom+'&estatusx='+estatus+'&obsx='+obs+'&fecinix='+fecini+'&Porcentajex='+Porcentaje,
  dataType: "text",
  success: function Respuesta(result){//alert(result);
  		
  		if(result == 1)
		{
			alert("Datos guardados correctamente");
			window.opener.busquedaReporteReq();
			
		}
		else
			alert("else" +'-'+result);
		
		},
  error: Error
});
}

function traeUsuario(Area){//alert(Area);
//if(Area=='%'){var combo='<select style="font-size:10px" id="selectSubfallaRF" ><option value="%">TODAS</option></select>';
//			   document.getElementById('spanSubfallaRF').innerHTML=combo;
//}else{
 $.ajax({
  url: '../php/traeUsuario.php',
  type: 'POST',
  async: true,
  data: 'Areax='+Area,
  success: function resp(result){//alert(result);
	document.getElementById('spanSubfallaRF').innerHTML=result;
  },
  error: Error
 });//}
}

function editaIncidencia(folio,requerimiento,area,solicito,realizo,fecsol,fecval,fecpro,feccom,estatus,obs)
{//alert("funciones req"+' '+folio+' '+requerimiento+' '+area+' '+solicito+' '+realizo+' '+fecsol+' '+fecval+' '+fecpro+' '+estatus+' '+obs);

if(requerimiento==''){alert('Captura el requerimiento'); return -1;}
		
  $.ajax({
  url: '../php/EditaIncidencia.php',
  type: 'POST',
  async: true,
  data: 'foliox='+folio+'&requerimientox='+requerimiento+'&areax='+area+'&solicitox='+solicito+'&realizox='+realizo,
  dataType: "text",
  success: function Respuesta(result){//alert(result);
  		
  		if(result == 1)
		{
			alert("Datos guardados correctamente");
			window.opener.busquedaReporteInc();
			
		}
		else
			alert("else" +'-'+result);
		
		},
  error: Error
});
}

function agregaProgramadorReq(numreq,idprog){//alert ("entrssa"+'-'+numreq+'-'+idprog );
	var n=2;
	$.ajax({
  url: '../php/buscaProgramadorReq2.php',
  type: 'POST',
  async: true,
  data: 'numreqx='+numreq+'&idprogx='+idprog,
  dataType: "text",
  success: function Respuesta(result){//alert (result);
	   var arr = result.split('|||');
	  document.getElementById('divProgAsig').innerHTML = arr[0]; 
	  document.getElementById('divProg').innerHTML = arr[1];},
	  //document.getElementById('busquedaSeriesInput').value="";
  error: Error
  });
}


function cancelarProgramador(numreq,idprog){//alert("aqui"+numreq+'-'+idprog);
//var n=2;
	$.ajax({
  url: '../php/cancelarProg.php',
  type: 'POST',
  async: true,
  data: 'numreqx='+numreq+'&idprogx='+idprog,
  dataType: "text",
  success: function Respuesta(result){//alert(result); var arr = result.split('||');
	 var arr = result.split('|||');
	  document.getElementById('divProgAsig').innerHTML = arr[0]; 
	  document.getElementById('divProg').innerHTML = arr[1];},
	  
  error: Error
  });
}


