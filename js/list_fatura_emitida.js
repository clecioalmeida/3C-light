$('#btnListFat').on('click', function(){
	if($('#nr_cte').val() == '' && $('#nr_fat').val() == '' && $('#dt_ini').val() == '' && $('#dt_fim').val() == ''){

		alert("Selecione pelo menos uma das opções de pesquisa.");

	}else if($('#nr_fat').val() != '' && $('#nr_cte').val() == '' && $('#dt_ini').val() == '' && $('#dt_fim').val() == ''){

		var nr_fat = $('#nr_fat').val();

		$('#tabela').load("data/faturamento/list_fatura_emitida.php?search=",{nr_fat:nr_fat});

	}else if($('#nr_fat').val() == '' && $('#nr_cte').val() != '' && $('#dt_ini').val() == '' && $('#dt_fim').val() == ''){

		var nr_cte = $('#nr_cte').val();

		$('#tabela').load("data/faturamento/list_fatura_emitida_cte.php?search=",{nr_cte:nr_cte});

	}else if($('#dt_ini').val() != '' && $('#dt_fim').val() != ''){

		var dt_ini =  $('#dt_ini').val();
		var dt_fim =  $('#dt_fim').val();
		
		$('#tabela').load("data/faturamento/list_fatura_emitida_dt.php?search=",{dt_ini:dt_ini,dt_fim:dt_fim});

	}
});