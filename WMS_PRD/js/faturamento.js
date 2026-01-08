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


$(document).ready(function() {
	$("#checkboxTodosFat").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

	$('#tabela').load('data/faturamento/list_faturamento_pend_total.php');
	return false;
});

$(document).ready(function(){
	$(document).on('click', '#btnEmitFaturamento', function(){
		event.preventDefault();
		$('#btnEmitFaturamento').prop("disabled", true);
		var vlTotalFat 		= $('#vlTotalFat').val();
		var dt_emit 		= $('#dt_emit').val();
		var ini_per 		= $('#ini_per').val();
		var fim_per 		= $('#fim_per').val();
		var dt_vencimento 	= $('#dt_vencimento').val();
		var cod_cliente 	= $('#cod_cliente').val();
		var ds_obs_fat 		= $('#ds_obs_fat').val();
		var vlFreteLiquido 	= $('#vlFreteLiquido').val();
		var vlSeguro 		= $('#vlSeguro').val();
		var vlImposto 		= $('#vlImposto').val();
		if(dt_vencimento == ""){

			alert("Por favor insira um vencimento.");

		}else{

			if( $('.checkFatEmit:checked').length == 0 ){

				alert('Selecione pelo menos uma entrega!');

			}else{
				var val = [];

				$('.checkFatEmit:checked').each(function(){
					val.push($(this).val());

				});

				$.ajax
				({
					url:"data/faturamento/ins_fatura.php",
					method:"POST",
					dataType:'json',
					data:{
						dt_emit 		:dt_emit,
						ini_per 		:ini_per,
						fim_per 		:fim_per,
						dt_vencimento 	:dt_vencimento,
						cte 			:val,
						vlTotalFat 		:vlTotalFat,
						cod_cliente 	:cod_cliente,
						ds_obs_fat 		:ds_obs_fat,
						vlFreteLiquido 	:vlFreteLiquido,
						vlSeguro 		:vlSeguro,
						vlImposto 		:vlImposto
					},
					success:function(j)
					{
						for(var i=0;i < j.length;i++){
							if(j[i].info == "0"){

								alert('Fatura gerada com sucesso!');
								$('#conteudo').load('faturamento.php');

							}else{

								alert('Ocorreu um erro!');

							}
						}
					}
				});
			}
		}			
		return false;
		$('#btnEmitFaturamento').prop("disabled", false);
	});

	$(document).on('click', '#btnPrintFat', function(){
		var nr_fat = $(this).val();
		$.ajax
		({
			url:"data/faturamento/relatorio/gerar_fatura.php",
			method:"POST",
			data:{nr_fat:nr_fat},
			success:function(data)
			{
				$('#printFat').html(data);
			}
		});
	});

	$('#btnEmitFat').on('click',function(){
		if( $('.checkFat:checked').length == 0 ){
			alert('Selecione pelo menos uma entrega!');
		}else{
			var val = [];

			$('.checkFat:checked').each(function(){
				val.push($(this).val());

			});

			$.ajax
			({
				url:'emit_fat.php',
				method:'POST',
				data:{cte:val},
				success:function(data){
					$('#tabela').html(data);
				}
			});
		}
		return false;
	});
});