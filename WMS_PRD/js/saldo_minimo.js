$(document).ready(function(){

	$(document).on('click', '#liSldMin', function(e){
		event.preventDefault();

		$.ajax
		({
			url:"data/produto/list_saldo_minimo.php",
			method:"POST",
			beforeSend:function(e){
				$("#retornoSldMin").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoSldMin').html(data);
			}
		});

		return false;
	});

	$(document).on('click', '#btnPesqPrdSldMin', function(e){
		event.preventDefault();

		$.ajax
		({
			url:"data/produto/list_saldo_minimo_dtl.php",
			method:"POST",
			data:{

				prd_cod:$('#prd_cod').val()

			},
			beforeSend:function(e){
				$("#retornoSldMin").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoSldMin').html(data);
			}
		});
		
		return false;
	});

	/*$(document).on('click', '#btnGerRep', function(e){
		event.preventDefault();
		if( $('.checkSldMin:checked').length == 0 ){

			alert('Selecione pelo menos um produto!');

		}else{

			var req = [];

			$('.checkSldMin:checked').each(function(){

				req.push($(this).val());

			});

			$.ajax
			({
				url:"data/produto/gera_saldo_minimo.php",
				method:"POST",
				data:{

					prd_cod:req

				},
				beforeSend:function(e){
					$("#retornoSldMin").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				},
				success:function(data)
				{
					$('#retornoSldMin').html(data);
				}
			});
		}
		
		return false;
	});*/

	$(document).on('click', '#btnGerRep', function(e){
		event.preventDefault();
		if( $('.checkSldMin:checked').length == 0 ){

			alert('Selecione pelo menos um produto!');

		}else{

			var req = [];

			$('.checkSldMin:checked').each(function(){

				req.push($(this).val());

			});

			$.ajax
			({
				url:"data/produto/modal/m_gera_saldo_minimo.php",
				method:"POST",
				data:{

					prd_cod:req

				},
				beforeSend:function(e){
					$("#retornoSldMin").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				},
				success:function(data)
				{
					$('#retornoSldMin').html(data);
				}
			});
		}
		
		return false;
	});

	$(document).on('click', '.btnFor', function(e){
		event.preventDefault();

		var cod_prd = $(this).closest('tr').find('td').data('prd');

		$.ajax
		({
			url:"data/produto/modal/m_ins_fornecedor.php",
			method:"POST",
			data:{
				cod_prd:cod_prd
			},
			success:function(data)
			{
				$('#retModalSldMin').html(data);
			}
		});

		return false;
	});

	$(document).on('click', '#btnCadFornecedorReq', function(){
		event.preventDefault();

		$.post("data/produto/ins_fornecedor_req.php", $("#formCadDestinatario").serialize(), function(data) {
			alert(data.info);
			$('.id_for'+data.cod_prd).val(data.id_for);
			$('.nm_for'+data.cod_prd).val(data.nm_fornecedor);
		}, "json");
		return false;
	});

	$(document).on('click', '.btnSaveItemReq', function(){
		event.preventDefault();

		var cod_prd 	= $(this).val();
		var qtd_rep 	= $('.qtd_rep'+cod_prd).val();
		var data_rep 	= $('.dt_rep'+cod_prd).val();
		var id_for 		= $('.cod_for'+cod_prd).val();

		$.ajax
		({
			url:"data/produto/ins_reposicao_item.php",
			method:"POST",
			dataType:'json',
			data:{

				qtd_rep:qtd_rep,
				data_rep:data_rep,
				cod_prd:cod_prd,
				id_for:id_for

			},
			success:function(f)
			{ 

				alert(f.info);
				$('.cod_for'+f.cod_prd).attr('data-item', f.id_item);

			}
		});

		return false;
	});

	$(document).on('click', '#btnCadReqCompra', function(){
		event.preventDefault();

		var nm_sol 	= $('#ds_solicitante').val();
		var nr_cr 	= $('#nr_cr').val();
		var dt_prev = $('#dt_previsto').val();
		var id_item = [];


		$('input[name="cod_fornecedor"]').each(function(){
			id_item.push($(this).attr("data-item"));
		});

		$.ajax
		({
			url:"data/produto/ins_reposicao.php",
			method:"POST",
			dataType:'json',
			data:{

				id_item:id_item,
				nm_sol:nm_sol,
				nr_cr:nr_cr,
				dt_prev:dt_prev

			},
			success:function(r)
			{ 

				alert(r.info);

			}
		});
		return false;
	});

	$(document).on('click', '#btnGerPend', function(){
		event.preventDefault();
		$('#retornoSldMin').load('data/produto/list_rep_pend.php');
	});

	$(document).on('click', '#btnPrdSemReq', function(){
		event.preventDefault();

		$.ajax
		({
			url:"data/produto/list_prd_pend.php",
			method:"POST",
			beforeSend:function(e){
				$("#retornoSldMin").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoSldMin').html(data);
			}
		});

		return false;
	});

	$(document).on('click', '#btnListPrd', function(){
		event.preventDefault();

		$.ajax
		({
			url:"data/produto/list_saldo_minimo.php",
			method:"POST",
			beforeSend:function(e){
				$("#retornoSldMin").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoSldMin').html(data);
			}
		});

		return false;
	});

	/*$(document).on('click', '#btnUpdReq', function(){
		event.preventDefault();

		var id_req 	= $(this).val();

		$.ajax
		({
			url:"data/produto/altera_requisicao.php",
			method:"POST",
            dataType:'json',
			data:{

				id_req:id_req

			},
			success:function(f)
			{ 

				alert(f.info);
				$('.cod_for'+f.cod_prd).attr('data-item', f.id_item);

			}
		});
		return false;
	});*/

	$(document).on('click', '#btnLibReq', function(){
		event.preventDefault();
		var id_item = [];
		var dt_prev = [];

		$('.checkRepPend:checked').each(function(){
			id_item.push($(this).attr("data-item"));
			dt_prev.push($(this).attr("data-prev"));
		});

		console.log(id_item, dt_prev);

		$.ajax
		({
			url:"data/produto/ins_recebimento_prev.php",
			method:"POST",
			dataType:'json',
			data:{

				id_item:id_item,
				dt_prev:dt_prev

			},
			success:function(r)
			{ 

				if(r.info == "0"){

					alert(r.id_rec);
					
					var id_rec = r.id_rec;

					$.ajax
					({
						url:"data/produto/ins_prd_recebimento_prev.php",
						method:"POST",
						dataType:'json',
						data:{

							id_item:id_item,
							dt_prev:dt_prev,
							id_rec:id_rec

						},
						success:function(r)
						{ 

							if(r.info == "0"){

								alert(r.id_rec);

							}else{

								alert(r.info);

							}

						}
					});


				}else{

					alert(r.info);

				}

			}
		});
		return false;
	});

});