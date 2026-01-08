$(document).ready(function(){

	$(document).on('click', '#btnPesqEstGeral', function(){
		event.preventDefault();

		$.post("data/armazem/locais_list_detalhe_geral.php", $("#formConsultaEstoqueGeral").serialize(), function(data) {
			
			$("#retornoEstGer").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			$('#retornoEstGer').html(data);

		});
		return false;
	});

	$(document).on('click', '#btnPesqEstBlqGeral', function(){
		event.preventDefault();

		$.post("data/armazem/locais_list_detalhe_bloq.php",
			function(data){
				$("#retornoBlqGer").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				$('#retornoBlqGer').html(data);
			});

		return false;
	});

	$(document).on('click', '#btnPesqEst', function(){
		event.preventDefault();

		var cod_prd = $('#cod_prod_est').val();

		if(cod_prd == ""){

			alert("Digite o código do produto.");

		}else{

			$.post("data/armazem/locais_list_detalhe_new.php", $("#formConsultaEstoque").serialize(), function(data) {

				$("#retornoEst").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				$('#retornoEst').html(data);

			});

		}
		return false;
	});

	$(document).on('click', '#btnFormHistPrd', function(){
		event.preventDefault();

		var histProd = $('#histProd').val();

		if(histProd == ""){

			alert("Digite o código do produto.");

		}else{

			$.post("data/movimento/list_hist_prod.php", $("#formListHistProd").serialize(), function(data) {

				$("#retornoHist").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				$('#retornoHist').html(data);

			});

		}
		return false;
	});

	$(document).on('click', '#btnPesqEstGeralEtq', function(){
		event.preventDefault();

		$('#responseEtq').hide();

		$.post("data/armazem/locais_list_detalhe_etq.php", $("#formConsultaEstoqueEtq").serialize(), function(data) {
			
			$("#retornoEtq").html("<img src='../css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			$('#retornoEtq').html(data);

		});
		return false;
	});

	$(document).on('click', '#btnPesqEstGeralEtqTrafo', function(){
		event.preventDefault();

		$('#responseEtqTrafo').hide();

		$.post("data/armazem/locais_list_detalhe_etq_trafo.php", $("#formConsultaEstoqueEtqTrafo").serialize(), function(data) {
			
			$("#retornoEtqTrafo").html("<img src='../css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			$('#retornoEtqTrafo').html(data);

		});
		return false;
	});

	$(document).on('click','#btnGeraEtqPrdEst',function(){
		event.preventDefault();
		if( $('.checkLocEtq:checked').length == 0 ){

			alert('Selecione pelo menos uma alocação!');

		}else if($('.checkLocEtq:checked').attr("data-qt") == ""){

			alert('Não há volume na alocação!');

		}else if($('.checkLocEtq:checked').attr("data-et") > 0){

			alert('Já existe etiqueta para esta locação!');

		}else{

			if(confirm("Confirma a criação das etiquetas?")){
				$('#btnGeraEtqPrdEst').prop("disabled", true);
				var cod_est = [];

				$('.checkLocEtq:checked').each(function(){
					cod_est.push($(this).val());

				});

				$.ajax
				({
					url:"data/armazem/ins_etq_est_prd.php",
					method:"POST",
					data:{
						cod_est:cod_est
					},
					beforeSend:function(e){
						$("#responseEtq").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
					},
					success:function(data){

						$('#responseEtq').html(data).show();
					}
				});
				$('#btnGeraEtqPrdEst').prop("disabled", false);
				return false;
			}
		}
	});

	$(document).on('click','#btnGeraEtqPrdEstTrafo',function(){
		event.preventDefault();
		if( $('.checkLocEtqTrafo:checked').length == 0 ){

			alert('Selecione pelo menos uma alocação!');

		}else if($('.checkLocEtqTrafo:checked').attr("data-qt") == ""){

			alert('Não há volume na alocação!');

		}else if($('.checkLocEtqTrafo:checked').attr("data-et") > 0){

			alert('Já existe etiqueta para esta locação!');

		}else{

			if(confirm("Confirma a criação das etiquetas?")){
				$('#btnGeraEtqPrdEstTrafo').prop("disabled", true);
				var cod_est = [];

				$('.checkLocEtqTrafo:checked').each(function(){
					cod_est.push($(this).val());

				});

				$.ajax
				({
					url:"data/armazem/ins_etq_est_prd_trafo.php",
					method:"POST",
					data:{
						cod_est:cod_est
					},
					beforeSend:function(e){
						$("#responseEtqTrafo").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
					},
					success:function(data){

						$('#responseEtqTrafo').html(data).show();
					}
				});
				$('#btnGeraEtqPrdEstTrafo').prop("disabled", false);
				return false;
			}
		}
	});

	$(document).on('click','#btnSaveEtqQtdLoc',function(e) {
		if(confirm("Confirma a inclusão das informações?")){
			event.preventDefault();
			var nr_vol = $(this).closest('tr').find('#nr_volume').val();
			var cod_est = $(this).val();
			$.ajax
			({  
				url:"data/armazem/upd_qtd_etq_est.php",  
				method:"POST",  
				data:{
					cod_est:cod_est,
					nr_vol:nr_vol
				},
				success:function(data)
				{

					alert(data);
				}  
			});         
			return false;
		}
	});

});