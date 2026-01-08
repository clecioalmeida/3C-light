
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
});