
$('#state').change(function(event){
	console.log(event.target.value);
	$.get('municipios/'+encodeURIComponent(event.target.value)+'',function(response,state){
		//console.log(response);
		$('#town').empty();
		$('#col').empty();
		$('#cp').empty();
		for(i=0;i<response.length;i++)
		{
			$('#town').append('<option value="'+response[i].municipio+'">'+response[i].municipio+'</option>');
		}
	});
});

$('#town').change(function(event){
	console.log(event.target.value);
	$.get('colonias/'+encodeURIComponent($('#state').val())+'/'+encodeURIComponent(event.target.value)+'',function(response,state){
		//console.log(response);
		$('#col').empty();
		$('#cp').empty();
		for(i=0;i<response.length;i++)
		{
			$('#col').append('<option value="'+response[i].asentamiento+'">'+response[i].asentamiento+'</option>');
		}
	});
});

$('#col').change(function(event){
	console.log(event.target.value);

	$.get('codpos/'+encodeURIComponent(event.target.value)+'/'+encodeURIComponent($('#town').val())+'/'+encodeURIComponent($('#state').val())+'',function(response,state){
		//console.log(response);
		$('#cp').empty();
		for(i=0;i<response.length;i++)
		{
			$('#cp').append('<option value="'+response[i].codigo+'">'+response[i].codigo+'</option>');
		}
	});
});

/*----------- Guarda Numero -----------------------*/
/*
$("#telefonoset_home").click(function(event) {
  $.get('savePhone/'+$("#numCliente").val()+'/'+ $("#homePhone").val()+'/'+"Tel Casa"+'/'+"1"+'',function(response,state){
		console.log(response);
	});
});

$("#telefonoset_work").click(function(event) {
  $.get('savePhone/'+$("#numCliente").val()+'/'+ $("#workPhone").val()+'/'+"Tel Oficina"+'/'+"2"+'',function(response,state){
		console.log(response);
	});
});

$("#telefonoset_ownCellPhone").click(function(event) {
  $.get('savePhone/'+$("#numCliente").val()+'/'+ $("#cellPhone").val()+'/'+"Cel Personal"+'/'+"3"+'',function(response,state){
		console.log(response);
	});
});

$("#telefonoset_workCellPhone").click(function(event) {
  $.get('savePhone/'+$("#numCliente").val()+'/'+ $("#workCellPhone").val()+'/'+"Cel Trabajo"+'/'+"4"+'',function(response,state){
		console.log(response);
	});
});

$("#telefonoset_new").click(function(event) {
	var tipo_tel;
	if($("#tipoNewNumber").val()!='')
	{
		if($("#tipoNewNumber").val()==1)
		{
			tipo_tel='Tel Casa';
		}
		else if ($("#tipoNewNumber").val()==2)
		{
			tipo_tel='Tel Oficina';
		}
		else if ($("#tipoNewNumber").val()==3)
		{
			tipo_tel='Cel Personal';
		}
		else
		{
			tipo_tel='Cel Trabajo';
		}

		$.get('savePhone/'+$("#numCliente").val()+'/'+ $("#newNumber").val()+'/'+tipo_tel+'/'+$("#tipoNewNumber").val()+'',function(response,state){
			console.log(response);
		});
	}
});
*/
/*----------- Guarda Numero -----------------------*/


/*---------		hijos    ---------------*/


/*---------		hijos    ---------------*/
