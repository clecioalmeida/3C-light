$('#btnListCont').on('click', function(){
	if($('#nr_contrato').val() == '' && $('#dt_ini').val() == '' && $('#dt_fim').val() == ''){

		alert("Selecione pelo menos uma das opções de pesquisa.");

	}else if($('#nr_contrato').val() != '' && $('#dt_ini').val() == '' && $('#dt_fim').val() == ''){

		var nr_contrato = $('#nr_contrato').val();

		$('#contrato').load("data/operacao/list_contrato_cont.php?search=",{nr_contrato:nr_contrato});

	}else if($('#dt_ini').val() != '' && $('#dt_fim').val() != ''){

		var dt_ini =  $('#dt_ini').val();
		var dt_fim =  $('#dt_fim').val();
		$('#contrato').load("data/operacao/list_contrato_dt.php?search=",{dt_ini:dt_ini,dt_fim:dt_fim});

	}
});