// funciones del calendario


function ocultaDiv(fol){alert(fol);
	//div donde se mostrará calendario debe estar oculto
	//if(fol=='calendarioInicioST'){$('#calendarioInicioST').hide();}					   
	$('#calendario'+fol).hide();
};

function ocultaDiv2(fol){//alert(fol);
	$('#calendarioA'+fol).hide();
	$('#calendarioB'+fol).hide();
	$('#calendarioC'+fol).hide();
	$('#calendarioD'+fol).hide();
};

function update_calendar(fol2){//alert(fol2);
	var month = $('#calendar_mes'+fol2).attr('value');//alert(month);
	var year = $('#calendar_anio'+fol2).attr('value');//alert(year);
	//var fol = $(fol2).attr('value');alert(fol);

	var valores='month='+month+'&year='+year+'&fol='+fol2;
//alert(valores);
	$.ajax({
		url: 'php/setvalue.php',
		type: "GET",
		data: valores,
		success: function(datos){//alert(datos);
			$("#calendario_dias"+fol2).html(datos);//alert("#calendario_dias"+fol2);
		}
	});
}
function update_calendar2(fol2, label){//alert(fol2+' '+label);//alert(('#'+label+'calendar_mes'+fol2));
	var month = $('#calendar_mes'+label+'-'+fol2).attr('value');//alert(month);
	var year = $('#calendar_anio'+label+'-'+fol2).attr('value');//alert(year);
	//var fol = $(fol2).attr('value');alert(fol);

	var valores='month='+month+'&year='+year+'&fol='+fol2+'&label='+label;
//alert(valores);
	$.ajax({
		url: '../php/setvalue2.php',
		type: "GET",
		data: valores,
		success: function(datos){//alert(datos);
			$("#calendario_dias"+label+"-"+fol2).html(datos);
		}
	});
}
	
function set_date(date){//alert(date);
	var arr = date.split('||');
	//input text donde debe aparecer la fecha
	$('#txtFHRCalendario'+arr[1]).attr('value',arr[0]);
	show_calendar(arr[1]);
}
function set_date2(date){//alert(date);
	var arr = date.split('||');
	//input text donde debe aparecer la fecha
	if(arr[2]==1){$('#txtFolCalendarioA'+arr[1]).attr('value',arr[0]);}
	if(arr[2]==2){$('#txtFolCalendarioB'+arr[1]).attr('value',arr[0]);}
	if(arr[2]==3){$('#txtFolCalendarioC'+arr[1]).attr('value',arr[0]);}
	if(arr[2]==4){$('#txtFolCalendarioD'+arr[1]).attr('value',arr[0]);}
	//$('#txtFHRCalendario'+arr[1]).attr('value',arr[0]);//alert(arr[2]);
	show_calendar2(arr[1], arr[2]);
}

function show_calendar(fol){//alert(fol);
	//div donde se mostrará calendario
	$('#calendario'+fol).toggle(); 
}	
function show_calendar2(fol, label){//alert(fol+' '+label);
	//div donde se mostrará calendario
	if(label==1){$('#calendarioA'+fol).toggle();}
	if(label==2){$('#calendarioB'+fol).toggle();}
	if(label==3){$('#calendarioC'+fol).toggle();}
	if(label==4){$('#calendarioD'+fol).toggle();}
//	$('#calendario'+fol).toggle(); 
}	