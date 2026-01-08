$('#insOpCte').on('change',function(){

	var fl_vg = $(this).find(':selected').attr("data-vg");

	var cidade = [];

	$('.checkboxRomaneio:checked').each(function(){
		cidade.push($(this).attr("data-cid"));
	});

	var destinos = [];
	$.each(cidade, function(i, elemento){
		if($.inArray(elemento, destinos) === -1) destinos.push(elemento);
	});

	if(destinos.length > 1 && fl_vg == "S"){

		alert("A operação selecionada não permite fracionado. Caso continue utilizando essa operação os CT-es não serão gerados corretamente. Selecione uma operação adequada ou selecione somente notas fiscais com o mesmo destino.");

	}
	return false;
});

$('input:checkbox[name="checkboxCte"]').on('change',function(){

	var fl_vg2 = $('#insOpCte').find(':selected').attr("data-vg");

	var cidade2 = [];

	$('.checkboxRomaneio:checked').each(function(){
		cidade2.push($(this).attr("data-cid"));
	});

	var destinos2 = [];
	$.each(cidade2, function(i, elemento){
		if($.inArray(elemento, destinos2) === -1) destinos2.push(elemento);
	});

	if(destinos2.length > 1 && fl_vg2 == "S"){

		alert("A operação selecionada não permite fracionado. Caso continue utilizando essa operação os CT-es não serão gerados corretamente. Selecione uma operação adequada ou selecione somente notas fiscais com o mesmo destino.");

	}

	return false;
});