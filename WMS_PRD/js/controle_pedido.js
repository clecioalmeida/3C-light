
// CONSULTA NÚMEROS DE SÉRIE // 

$(document).ready(function(){
	$(document).on('click','#btnPesquisaPedidoNs',function(e){
		event.preventDefault();
		var nr_ped = $('#nr_pedido_ns').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_ns_pedido.php",
			method:"POST",
			data:{nr_ped:nr_ped},
			beforeSend:function(j){
				$("#retorno_ns").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retorno_ns').html(data);
			}
		});
	});

	$(document).on('click','#btnPesquisaDocmaterialNs',function(e){
		event.preventDefault();
		var nr_serie = $('#n_serie').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_ns_ns.php",
			method:"POST",
			data:{nr_serie:nr_serie},
			beforeSend:function(j){
				$("#retorno_ns").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retorno_ns').html(data);
			}
		});
	});

	$(document).on('click','#btnPesquisaProdutoNs',function(e){
		event.preventDefault();
		var ns_prd = $('#produto_ns').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_ns_prd.php",
			method:"POST",
			data:{ns_prd:ns_prd},
			beforeSend:function(j){
				$("#retorno_ns").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retorno_ns').html(data);
			}
		});
	});
});

// PESQUISA FINALIZADOS POR DATA //

$(document).ready(function(){
	$(document).on('click', '#btnConsStatusNs', function(){
		event.preventDefault();
		var nr_ped = $(this).val();
		var ns_ini = $('#ns_ini').val();
		var ns_fim = $('#ns_fim').val();
		$.post("data/movimento/modal/m_consulta_ns.php",{ns_ini:ns_ini,ns_fim:ns_fim,nr_ped:nr_ped},function(data){
			$('#retProdutoNs').html(data);
		});
	});

	$(document).on('click', '#btnInsNsPedido', function(){
		event.preventDefault();
		if( $('.checkPedNs:checked').length == 0 ){

			alert('Selecione pelo menos um número de série!');

		}else{

			var ns_ini = $(this).attr("data-nsini");
			var ns_fim = $(this).attr("data-nsfim");
			var nr_ped = $(this).val();
			var nserie = [];

			$('.checkPedNs:checked').each(function(){
				nserie.push($(this).val());
			});

			$.ajax
			({
				url:'data/movimento/ins_ns_pedido.php',
				method:'POST',
				data:{
					nserie:nserie,
					nr_ped:nr_ped,
					ns_fim:ns_fim,
					ns_ini:ns_ini
				},
				success:function(j)
				{
					alert(j);
					$('#retornoPedDtl').load('data/movimento/list_itens_pedido.php?search=',{dtl_ped:nr_ped});
				}
			});
		}
	});
});

$(document).ready(function(){
	$(document).on('click','#btnPesquisaDtFin',function(e){
		event.preventDefault();
		var dt_ini = $('#dt_ini').val();
		var dt_fim = $('#dt_fim').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_dt_fin.php",
			method:"POST",
			data:{dt_ini:dt_ini,dt_fim:dt_fim},
			beforeSend:function(j){
				$("#retornoConfEnd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoConfEnd').html(data);
			}
		});
	});
});

// INCLUIR COMPLEMENTO DE PRODUTOS //

$(document).ready(function(){

	$(document).on('click', '#btnConsProdPedido', function(){
		event.preventDefault();
		var prod_cliente = $('#prod_cliente').val();
		$.ajax
		({
			url:"data/movimento/consulta_saldo_complemento.php",
			method:"POST",
			dataType:'json',
			data:{prod_cliente:prod_cliente},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					if(j[i].info == 0){

						$('#cod_produto').val(j[i].cod_produto);
						$('#prod_cliente').val(j[i].cod_prod_cliente);
						$('#nm_produto').val(j[i].nm_produto);
						$('#vl_saldo').val(j[i].saldo);
						$('#retSldPrd').html(j[i].texto).show();

					}else{

						$('#nm_produto').val("Produto não encontrado.");

					}

				}
			}
		});
		return false;
	});

	$(document).on('click', '#btnInsertPrdPedidoCompl', function(){
		event.preventDefault();
		var qtd 		= $('#prd_qtde').val();
		var ds_rua 		= $('#ds_rua').val();
		var ds_coluna 	= $('#ds_coluna').val();
		var ds_altura 	= $('#ds_altura').val();

		if(qtd == 0 || qtd == "" || ds_rua == "" || ds_coluna == "" || ds_altura == ""){

			alert("Preencha todos os campos.");

		}else{

			$.getJSON('data/movimento/ins_comp_prd.php?search=',{
				cod_produto: 	$('#prod_cliente').val(),
				nr_doc_comp: 	$('#nr_doc_comp').val(),
				nr_pedido: 		$('#prd_pedido').val(),
				nr_qtde_pedido: $('#prd_qtde').val(),
				nr_pedido: 		$('#prd_pedido').val(),
				ds_rua: 		$('#ds_rua').val(),
				ds_coluna: 		$('#ds_coluna').val(),
				ds_altura: 		$('#ds_altura').val(),
				ajax: 'true'}, function(j){

					for (var i = 0; i < j.length; i++) {

						if(j[i].info == "1"){

							alert("Complemento incluído com sucesso.");

						}else if(j[i].info == "4"){

							alert("Erro no cadastro!");

						}
					}
					return false;
				});
		}		
	});

	$(document).on('click','#btnPesqQtdPed',function(e){  
		event.preventDefault();
		var nr_peiddo = $(this).val();          
		$('#retModalColeta').load('data/movimento/modal/m_list_qtd_pedido.php?search=',{nr_peiddo:nr_peiddo});
	});

	$(document).on('click', '#btnDtlPedSep', function(){
		event.preventDefault();
		var dtl_ped = $(this).val();
		$.ajax
		({
			url:"edit_pedido.php",
			method:"POST",
			data:{dtl_ped:dtl_ped},
			success:function(data)
			{
				$('#infoSepara').html(data);
			}
		});
		return false
	});

	$(document).on('click','#btnCtrlTransp',function(){
		event.preventDefault();
		$("#retornoConfExp").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
		$('#retornoConfExp').load("data/movimento/list_tb_ctrl_transp.php");
	});

	$(document).on('click','#btnConsultaMesMinuta',function(){
		event.preventDefault();
		$.post("data/movimento/list_tb_ctrl_transp_dtl.php", $("#formMesMinuta").serialize(), function(data) {          
			$("#retTbControlTransp").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			$('#retTbControlTransp').html(data);
		});
	});

	$(document).on('click', '#btnConsPedReq', function(){
		event.preventDefault();
		var nr_matr = $('#ds_req').val();
		$.ajax
		({
			url:"data/movimento/consulta_almox.php",
			method:"POST",
			dataType:'json',
			data:{nr_matr:nr_matr},
			success:function(j)
			{

				if(j.info == 0){

					$('#nr_matricula').val(j.nr_matricula);
					$('#ds_req').val(j.ds_req);

				}else{

					$('#ds_req').val("Matrícula não encontrada.");

				}

			}
		});
		return false;
	});

	$(document).on('click','#btnUpdPedido',function(){
		var ins_rec = $(this).val();

		$.post("data/movimento/upd_pedido.php", $("#formUpdPedido").serialize(), function(data) {
			alert(data);
		});

	});

	$(document).on('click', '#btnFormCadPedido', function(){
		$.post("data/movimento/ins_pedido.php", $("#formCadPedido").serialize(), function(data) {
			alert(data);
			$('#retornoPed').load("data/movimento/pedido_sql_geral.php");
		});
	});
});

$(document).ready(function(){

	$(document).on('click', '#btnConsNovoProdPedido', function(){
		event.preventDefault();
		var cod_cli = $('#prod_cliente').val();
		var cod_Ped = $(this).val();
		$.ajax
		({
			url:"data/movimento/consulta_saldo_estoque.php",
			method:"POST",
			dataType:'json',
			data:{cod_cli:cod_cli,cod_Ped:cod_Ped},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					if(j[i].info == 0){

						$('#cod_produto').val(j[i].cod_produto);
						$('#prod_cliente').val(j[i].cod_prod_cliente);
						$('#nm_produto').val(j[i].nm_produto);
						$('#vl_saldo').val(j[i].saldo);
						$('#retSldPrd').html(j[i].texto).show();
						$('#btnInsertPrdPedidoDtl').prop("disabled", false);

					}else if(j[i].info == 1){

						$('#retSldPrd').html(j[i].texto).show();
						$('#btnInsertPrdPedidoDtl').prop("disabled", true);

					}else if(j[i].info == 6){

						$('#retSldPrd').html(j[i].texto).show();
						$('#btnInsertPrdPedidoDtl').prop("disabled", true);

					}else{

						$('#retSldPrd').html(j[i].texto).show();
						$('#btnInsertPrdPedidoDtl').prop("disabled", true);

					}

				}
			}
		});
		return false;
	});

	$(document).on('click', '#btnInsertPrdPedidoDtl', function(){
		event.preventDefault();
		var qtd = $('#prd_qtde').val() != "" ? $("#prd_qtde").val() : 0;
		var sld = Number($('#vl_saldo').val());
		var sts = $(this).val();
		total = sld - qtd;
		console.log(total);

		if(sld < qtd){

			alert("Não há saldo para a quantidade solicitada.");
			console.log(sld);
			console.log(qtd);

		}else if(qtd == 0 || qtd == ""){

			alert("Quantidade solicitada não pode ser zero ou vazia.");

		}else{

			$.getJSON('data/movimento/list_produto_dtl.php?search=',{cod_produto: $('#prod_cliente').val(),nr_qtde_pedido: $('#prd_qtde').val(),nr_pedido: $('#prd_pedido').val(),ajax: 'true'}, function(j){

				for (var i = 0; i < j.length; i++) {

					if(j[i].info == "1"){

						alert("Um produto não pode constar duas vezes no mesmo pedido, mas você pode alterar quantidade do produto caso não tenha sido iniciado o picking.");

					}else if(j[i].info == "2"){

						alert("Não existe saldo suficiente para inclusão desse produto no pedido!");

					}else if(j[i].info == "0"){

						alert("A quantidade a reservar não pode ser zero!");

					}else if(j[i].info == "5"){

						alert("A quantidade solicitada não pode ser maior que o saldo!");


					}else if(j[i].info == "3"){

						$('#retornoPedDtl').load('data/movimento/list_itens_pedido.php?search=',{dtl_ped:j[i].nr_pedido});
						$.ajax
						({
							url:"data/movimento/resumo_pedido_ind.php",
							dataType:'json',
							data: {nr_ped:j[i].nr_pedido},
							method:"POST",
							success:function(j)
							{
								for (var i = 0; i < j.length; i++) {

									$('#tot_pedido').text(j[i].tot_pedido);
									$('#tot_col').text(j[i].tot_col);
									$('#tot_pend').text(j[i].tot_pend);
									$('#tot_conf').text(j[i].tot_conf);
								}
							}
						});

					}else if(j[i].info == "4"){

						alert("Erro no cadastro!");

					}
				}
				return false;
			});
		}		
	});

	$(document).on('click', '#btnUpdPrdPedidoQtde', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração da quantidade?")){
			var cod_ped = $(this).val();
			var nr_new_qtde_pedido = $('#nr_new_qtde_pedido').val();
			var nr_ped = $('#nrPedidoNewQtde').val();
			var nr_saldo_ped = $(this).closest('tr').find('#nr_saldo_upd').text();

			var nr_nova_qtde = nr_saldo_ped - nr_new_qtde_pedido;

			if(nr_nova_qtde < 0){

				alert("Quantidade solicitada é maior que a disponível.");

			}else{

				$.ajax
				({
					url:"data/movimento/upd_prd_pedido_qtde.php",
					method:"POST",
					data:{
						nr_new_qtde_pedido:nr_new_qtde_pedido,
						cod_ped:cod_ped
					},
					success:function(data)
					{

						alert(data);
						$('#retornoPedDtl').load('data/movimento/list_itens_pedido.php?search=',{dtl_ped:nr_ped});
						$.ajax
						({
							url:"data/movimento/resumo_pedido_ind.php",
							dataType:'json',
							data: {nr_ped:nr_ped},
							method:"POST",
							success:function(j)
							{
								for (var i = 0; i < j.length; i++) {

									$('#tot_pedido').text(j[i].tot_pedido);
									$('#tot_col').text(j[i].tot_col);
									$('#tot_pend').text(j[i].tot_pend);
									$('#tot_conf').text(j[i].tot_conf);
								}
							}
						});
					}
				});

			}
		}
		return false;
	});

	$(document).on('click', '#btnColPed', function(){
		event.preventDefault();
		if(confirm("Confirma o início da coleta?")){
			var start_col= $(this).val();
			$.ajax
			({
				url:"data/movimento/inicia_coleta.php",
				method:"POST",
				data:{
					start_col:start_col
				},
				success:function(data)
				{
					alert(data);
					$('#retornoPed').load('data/movimento/pedido_sql_geral.php');
				}
			});
		}
		return false;
	});

	$(document).on('click', '#btnDelProdPedido', function(){
		event.preventDefault();
		if(confirm("Confirma a exclusão do item de coleta?")){
			var cod_col = $(this).val();
			var nrPedidoProd = $('#nrPedidoProd').val();
			var nrPedidoProdItem = $('#nrPedidoProdItem').val();
			var sts = $(this).attr("data-status");
			$.ajax
			({
				url:"data/movimento/del_prd_pedido.php",
				method:"POST",
				data:{
					cod_col:cod_col,
					nrPedidoProd:nrPedidoProd,
					nrPedidoProdItem:nrPedidoProdItem
				},
				success:function(data)
				{
					alert(data);
					$('#retornoPedDtl').load('data/movimento/list_itens_pedido.php?search=',{dtl_ped:nrPedidoProd});
					$.ajax
					({
						url:"data/movimento/resumo_pedido_ind.php",
						dataType:'json',
						data: {nr_ped:nrPedidoProd},
						method:"POST",
						success:function(j)
						{
							for (var i = 0; i < j.length; i++) {

								$('#tot_pedido').text(j[i].tot_pedido);
								$('#tot_col').text(j[i].tot_col);
								$('#tot_pend').text(j[i].tot_pend);
								$('#tot_conf').text(j[i].tot_conf);
							}
						}
					});
				}
			});	
		}
		return false;
	});
});

$(document).ready(function(){

	$(document).on('click', '#btnPrintCol', function(){
		var cod_pedido = $(this).val();
		$.ajax({
			url:"data/movimento/relatorio/consulta_status.php",
			method:"POST",
			dataType:'json',
			data:{cod_pedido:cod_pedido},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					$.ajax
					({
						url:"data/movimento/relatorio/picking_list.php",
						method:"POST",
						data:{cod_pedido:cod_pedido},
						success:function(data)
						{
							$('#retornoPed').html(data);
						}
					});
				}
			}
		});
		return false;
	});

	$(document).on('click', '#btnPrintReq', function(){
		var cod_pedido = $(this).val();
		$.ajax
		({
			url:"data/movimento/relatorio/consulta_status.php",
			method:"POST",
			dataType:'json',
			data:{cod_pedido:cod_pedido},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					$.ajax
					({
						url:"data/movimento/relatorio/list_req.php",
						method:"POST",
						data:{cod_pedido:cod_pedido},
						success:function(data)
						{
							$('#retornoPed').html(data);
						}
					});
				}
			}
		});
		return false;
	});

	$(document).on('click', '#btnDtlPed', function(){
		event.preventDefault();
		var dtl_ped = $(this).val();
		$.ajax
		({
			url:"edit_pedido.php",
			method:"POST",
			data:{dtl_ped:dtl_ped},
			success:function(data)
			{
				$('#retornoPed').html(data);
			}
		});
		return false
	});

	$(document).on('click', '#btnEstSepPrd', function(){
		event.preventDefault();
		if(confirm("Confirma o estorno da separação? Todos as quantidades separadas serão estornadas.")){


			$.post("data/movimento/upd_est_sep.php",{nr_ped:$(this).val(),fl_st:$(this).attr("data-sts")},function(data){

				alert(data);

				$('#retornoPedDtl').load('data/movimento/list_itens_pedido.php?search=',{dtl_ped:nr_ped});

			});
		}

		return false;
	});

	$(document).on('click', '#btnDelProdPedidoSep', function(){
		event.preventDefault();
		if(confirm("Confirma a exclusão do item separado?")){
			var nrPedidoProdSep = $('#nrPedidoProdSep').val();
			var cod_conf = $(this).val();
			var cod_col = $(this).attr("data-col");
			var nrPedidoProdItem = $(this).attr("data-prd");
			$.ajax
			({
				url:"data/movimento/del_prd_pedido_conf.php",
				method:"POST",
				data:{
					cod_conf:cod_conf,
					cod_col:cod_col,
					nrPedidoProdSep:nrPedidoProdSep,
					nrPedidoProdItem:nrPedidoProdItem
				},
				success:function(data)
				{
					alert(data);
					$('#retornoPedConf').load('data/movimento/list_end_pedido.php?search=',{dtl_ped:nrPedidoProdSep});
					$.ajax
					({
						url:"data/movimento/resumo_pedido_ind.php",
						dataType:'json',
						data: {nr_ped:nrPedidoProdSep},
						method:"POST",
						success:function(j)
						{
							for (var i = 0; i < j.length; i++) {

								$('#tot_pedido').text(j[i].tot_pedido);
								$('#tot_col').text(j[i].tot_col);
								$('#tot_pend').text(j[i].tot_pend);
								$('#tot_conf').text(j[i].tot_conf);
							}
						}
					});
				}
			});	
		}
		return false;
	});

	$(document).on('click', '#btnPesquisaStatusPed', function(){
		event.preventDefault();

		$.post("data/movimento/pedido_sql_status.php",{ds_status:$('#ds_status').val()},function(data){

			$('#retornoPed').html(data);

		});

		return false;
	});
});