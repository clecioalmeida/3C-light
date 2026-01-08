	$(document).ready(function(){
		$(document).on('click','#btnDelItem',function(){
			event.preventDefault();
			$('#btnDelItem').attr("disable");
			var delItem = $(this).val();
			$.ajax
			({
				url:"data/torre/exclui_item_torre.php",
				method:"POST",
				dataType:'json',
				data:{
					delItem:delItem
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {

						var id_torre_rt = j[i].id_torre;
						var id_parte_rt = j[i].id_parte;
						
						if(j[i].info == "0"){
							alert("Não é possível excluir itens com saldo em estoque!");
							$('#tabela').load('data/torre/consulta_torre_sql.php?search=',{id_torre:id_torre_rt, id_parte:id_parte_rt});
						}else if(j[i].info == "1"){
							alert("Item da torre excluido com sucesso!");
							$('#tabela').load('data/torre/consulta_torre_sql.php?search=',{id_torre:id_torre_rt, id_parte:id_parte_rt});
						}else if(j[i].info == "3"){
							alert("Erro na exclusão do item, por favor entre em contato com o suporte!");
							$('#tabela').load('data/torre/consulta_torre_sql.php?search=',{id_torre:id_torre_rt, id_parte:id_parte_rt});
						}
					}

					$('#btnDelItem').attr("enable");
				}
			});
			return false;
		});
	});

	$(document).on('click','#btnFormCadPeca', function(){
		event.preventDefault();
		$('#btnFormCadPeca').prop("disabled", true);
		var id_torre 			= $('#id_torre').val();
		var id_parte 			= $('#id_parte').val();
		var ds_descricao 		= $('#ds_descricao').val();
		var nr_identificacao 	= $('#nr_identificacao').val();
		var nr_comprimento 		= $('#nr_comprimento').val();
		var nr_peso_unit 		= $('#nr_peso_unit').val();
		var cod_cliente 		= $('#cod_cliente').val();
		var nr_posicao 			= $('#nr_posicao').val();
		var nr_qtde 			= $('#nr_qtde').val();
		$.ajax
		({
			url:"data/torre/ins_item_torre.php",
			method:"POST",
			dataType:'json',
			data:{
				id_torre:id_torre, 
				id_parte:id_parte, 
				ds_descricao:ds_descricao, 
				nr_identificacao:nr_identificacao, 
				nr_comprimento:nr_comprimento, 
				nr_peso_unit:nr_peso_unit, 
				cod_cliente:cod_cliente, 
				nr_posicao:nr_posicao, 
				nr_qtde:nr_qtde
			},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					var id_torre_rt = j[i].id_torre;
					var id_parte_rt = j[i].id_parte;

					if(j[i].info == "0"){

						$('#formCadPeca')[0].reset();
						$('#tabela').load('data/torre/consulta_torre_sql.php?search=',{id_torre:id_torre_rt, id_parte:id_parte_rt});
						$('#Novoitem').modal('show');
						$('#retModCadPecaOk').css("display", "block");
						$('#btnFormCadPeca').prop("disabled", false);

					}else if(j[i].info == "1"){

						$('#formCadPeca')[0].reset();
						$('#Novoitem').modal('show');
						$('#tabela').load('data/torre/consulta_torre_sql.php?search=',{id_torre:id_torre_rt, id_parte:id_parte_rt});
						$('#retModCadPecaOk').css("display", "block");
						$('#btnFormCadPeca').prop("disabled", false);

					}else if(j[i].info == "2"){

						$('#formCadPeca')[0].reset();
						$('#Novoitem').modal('show');
						$('#tabela').load('data/torre/consulta_torre_sql.php?search=',{id_torre:id_torre_rt, id_parte:id_parte_rt});
						$('#retModCadPecaOk').css("display", "block");
						$('#btnFormCadPeca').prop("disabled", false);

					}
				}					
			}
		});
		return false;
	});

	$(document).ready(function(){
		$(document).on('click', '#btnEditaPeca', function(){
			event.preventDefault();
			var id_item = $(this).val();
			$.ajax({
				url:"data/torre/edita_item.php",
				method:"POST",
				data:{id_item:id_item},
				success:function(data)
				{
					$('#dados').html(data);
				}
			});
			return false;
		});

		$(document).on('click', '#btnPesquisaItemTorre', function(){
			event.preventDefault();
			var ConsItemTorre = $('#ConsItemTorre').val();
			$.ajax({
				url:"data/torre/consulta_parte_peca.php",
				method:"POST",
				data:{ConsItemTorre:ConsItemTorre},
				success:function(data)
				{
					$('#tabela').html(data);
				}
			});
			return false;
		});

        $(document).on('click', '#btnFormEditaItem', function(){
        	event.preventDefault();
        	var id_peca = $('#id_peca').val();
        	var id_item = $('#id_item').val();
        	var id_parte = $('#id_parte').val();
        	var id_torre = $('#id_torre').val();
        	var ds_descricao = $('#ds_descricao').val();
        	var nr_posicao = $('#nr_posicao').val();
        	var nr_qtde = $('#nr_qtde').val();
        	var nr_peso_unit = $('#nr_peso_unit').val();
        	var nr_comprimento = $('#nr_comprimento').val();
        	var nr_identificacao = $('#nr_identificacao').val();
        	$.ajax({
        		url:"data/torre/upd_item.php",
        		method:"POST",
        		dataType:'json',
        		data:{
        			id_peca:id_peca,
        			id_item:id_item,
        			id_parte:id_parte,
        			id_torre:id_torre,
        			ds_descricao:ds_descricao,
        			nr_posicao:nr_posicao,
        			nr_qtde:nr_qtde,
        			nr_peso_unit:nr_peso_unit,
        			nr_comprimento:nr_comprimento,
        			nr_identificacao:nr_identificacao
        		},
        		success:function(j)
        		{
        			for (var i = 0; i < j.length; i++) {

        				if(j[i].info == "0"){

        					alert("Alteração realizada com sucesso!");

        				}else if(j[i].info == "1"){

        					alert("Erro na alteração, por favor entre em contato com o suporte.");

        				}else if(j[i].info == "2"){

        					alert("Alteração realizada com sucesso!");

        				}
        			}
        		}
        	});
        	return false;
        });

        $(document).on('click', '#btnEditaConjunto', function(){
        	var id_cnjt = $(this).val();
        	var id_parte = $('#id_parte').val();
        	$.ajax({
        		url:"data/torre/edita_conjunto.php",
        		method:"POST",
        		data:{
        			id_cnjt:id_cnjt,
        			id_parte:id_parte
        		},
        		success:function(data)
        		{
        			$('#dados').html(data);
        		}
        	});
        	return false;
        });

        $(document).on('click', '#btnFormEditaConjunto', function(){
        	$('#formEditaConjunto').ajaxForm({
        		target:'#conteudo',
        		url:'data/torre/upd_conjunto.php',
        		beforeSend:function(e){
        			$("#dados").html("<img src='includes/torres/js/loading9.gif'>");
        		}
        	});
        });

    });

	$(document).ready(function(){
		$(document).on('change', '#selectTipoTorre', function(){
			event.preventDefault();
			var id_torre = $(this).val();
			$.ajax({
				url:"data/torre/list_tipo_torre.php",
				method:"POST",
				data:{id_torre:id_torre},
				success:function(data)
				{
					$('#tabela').html(data);
				}
			});
		});

		$(document).on('change', '#btnConsConjunto', function(){
			event.preventDefault();
			var id_torre = $(this).val();
			$.ajax({
				url:"data/torre/consulta_conjunto_sql.php",
				method:"POST",
				data:{id_torre:id_torre},
				success:function(data)
				{
					$('#tabela').html(data);
				}
			});
			return false;
		});

		$(document).on('click', '#consultaTipo', function(){
			event.preventDefault();
			var id_torre = $(this).val();
			$.ajax({
				url:"data/torre/list_tipo_torre.php",
				method:"POST",
				data:{id_torre:id_torre},
				success:function(data)
				{
					$('#tabela').html(data);
				}
			});
			return false;
		});

		$(document).on('click', '#btnCadTipoTorre', function(){
			$('#tabela').load('data/torre/modal/m_ins_tipo.php');
			return false;
		});

		$(document).on('click', '#btnCadParte', function(){
			event.preventDefault();
			$('#tabelaItem').load('data/torre/modal/m_ins_conjunto.php');
			return false;
		});

		$(document).on('click', '#btnFormConjuntoTorre', function(){
			$('#formConjuntoTorre').ajaxForm({
				target:'#tabela',
				url:'data/torre/ins_parte.php',
				beforeSend:function(e){
					$("#tabela").html("<img src='includes/torres/js/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#idTipoTorre', function(){
			var idTipoTorre = $(this).val();
			$.ajax({
				url:"data/torre/edita_torre.php",
				method:"POST",
				data:{idTipoTorre:idTipoTorre},
				success:function(data)
				{
					$('#conteudo').html(data);
				}
			});
			return false;
		});

		$(document).on('click', '#btnDelTipoTorre', function(){
			var idTipoTorre = $(this).val();
			$.ajax({
				url:"data/torre/exclui_torre.php",
				method:"POST",
				data:{idTipoTorre:idTipoTorre},
				success:function(data)
				{
					$('#listTipo').html(data);
				}
			});
			return false;
		});

		$(document).on('click', '#btnConfDelTipoTorre', function(){
			var idTorre = $(this).val();
			$.ajax({
				url:"data/torre/exclui_torre_conf.php",
				method:"POST",
				data:{idTorre:idTorre},
				success:function(data)
				{
					$('#listTipo').html(data);
				}
			});
			return false;
		});

		$(document).on('click', '#consultaConjunto', function(){
			event.preventDefault();
			var id_torre = $(this).val();
			$.ajax({
				url:"data/torre/consulta_conjunto_sql.php",
				method:"POST",
				data:{id_torre:id_torre},
				beforeSend:function(e){
					$("#tabela").html("<img src='css/loading9.gif'>");
				},
				success:function(data)
				{
					$('#tabela').html(data);
				},
			});
			return false;
		});

		$('#CadastraConjunto').click(function(){
			$('#formCadTipo').ajaxForm({
				target:'#tabela',
				url:'data/torre/consulta_conjunto_sql2.php',
				beforeSend:function(e){
					$("#tabela").html("<img src='css/loading9.gif'>");
				}
			});
		});
	});

	$(document).ready(function(){
		$(document).on('click', '#btnCadastraConjunto', function(){
			var id_torre = $(this).val();
			$.ajax({
				url:"data/torre/modal/m_ins_conjunto.php",
				method:"POST",
				data:{id_torre:id_torre},
				success:function(data)
				{
					$('#tabelaItem').html(data);
				}
			});
		});

		$(document).on('change', '#id_torre_item', function(){
			event.preventDefault();
			if( $(this).val() ) {
				$('#id_parte_item').hide();
				$('.carregando').show();
				$.getJSON('data/torre/consulta_parte.php?search=',{id_torre: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a parte da Torre</option>'; 
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id + '">' + j[i].id +" - "+ j[i].parte + '</option>';
					}   
					$('#id_parte_item').html(options).show();
					$('.carregando').hide();
				});
			} else {
				$('#id_parte_item').html('<option value="">– Escolha parte da Torre –</option>');
			}
		});

		$(document).on('change', '#id_parte_item', function(){
			event.preventDefault();
			var id_parte = $(this).val();
			var id_torre = $('#id_torre_item').val();
			$.ajax({
				url:"data/torre/consulta_torre_sql.php",
				method:"POST",
				data:{id_torre:id_torre, id_parte:id_parte},
				success:function(data)
				{
					$('#tabela').html(data);
				}
			});
			return false;
		});

		$(document).on('click', '#btnCadItem', function(){
			event.preventDefault();
			var id_torre = $('#id_torre_item').val();
			var id_parte = $('#id_parte_item').val();
			$.ajax({
				url:"data/torre/modal/m_ins_item.php",
				method:"POST",
				data:{id_parte:id_parte, id_torre:id_torre},
				success:function(data)
				{
					$('#tabelaItem').html(data);
				}
			});
			return false;
		});
		/* -- Modelo -- */
		$(document).on('change', '#id_torre_ex', function(){
			event.preventDefault();
			if( $(this).val() ) {
				$('#id_parte_ex').hide();
				$('.carregando').show();
				$.getJSON('data/torre/consulta_parte.php?search=',{id_torre: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a parte da Torre</option>'; 
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id + '">' + j[i].id +" - "+ j[i].parte + '</option>';
					}   
					$('#id_parte_ex').html(options).show();
					$('.carregando').hide();
				});
			} else {
				$('#id_parte_ex').html('<option value="">Escolha parte da Torre</option>');
			}
		});
	});

	$(document).ready(function(){
		$(document).on('change', '#id_parte_ex', function(){
			event.preventDefault();
			if( $(this).val() ) {
				$('#id_item_ex').hide();
				$('.carregando').show();
				$.getJSON('data/torre/consulta_conjunto.php?search=',{id_parte: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a posição</option>'; 
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].cod_produto + '">' + j[i].nr_posicao +' | '+ j[i].nm_produto + '</option>';
					}   
					$('#id_item_ex').html(options).show();
					$('.carregando').hide();
				});
			} else {
				$('#id_item_ex').html('<option value="">Escolha a posição</option>');
			}
		});

		$(document).on('change', '#id_item_ex', function(){
			event.preventDefault();
			if( $(this).val() ) {
				$('#id_rua_ex').hide();
				$('.carregando').show();
				$.getJSON('data/torre/consulta_rua_exp.php?search=',{id_item_exp: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha o Endereço</option>'; 
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].cod_estoque + '" data-estoque="'+ j[i].cod_estoque +'\
						"data-rua="'+ j[i].ds_prateleira +'"data-coluna="'+ j[i].ds_coluna +'"data-altura="\
						'+ j[i].ds_altura +'">Endereço:' + j[i].ds_prateleira +' | '+ j[i].ds_coluna +' | '+ j[i].ds_altura +' |\
						 '+ j[i].ds_embalagem +' | Qtde:'+ j[i].nr_qtde + ' | Reserv.:'+ j[i].reservado + ' | Saldo:'+ j[i].saldo + '</option>';
					}   
					$('#id_rua_ex').html(options).show();
					$('.carregando').hide();
				});
			} else {
				$('#id_rua_ex').html('<option value="">Escolha o Endereço</option>');
			}
			return false;
		});

		$(document).on('change', '#id_torre_ex_fx', function(){
			event.preventDefault();
			if( $(this).val() ) {
				$('#id_parte_ex_fx').hide();
				$('.carregando').show();
				$.getJSON('data/torre/consulta_parte.php?search=',{id_torre: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a parte da Torre</option>'; 
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id + '">' + j[i].id +" - "+ j[i].parte + '</option>';
					}   
					$('#id_parte_ex_fx').html(options).show();
					$('.carregando').hide();
				});
			} else {
				$('#id_parte_ex_fx').html('<option value="">Escolha parte da Torre</option>');
			}
		});

		$(document).on('change', '#id_parte_ex_fx', function(){
			event.preventDefault();
			if( $(this).val() ) {
				$('#id_fx_ex').hide();
				$('.carregando').show();
				$.getJSON('data/torre/consulta_feixe_ex.php?search=',{id_parte: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha o feixe</option>'; 
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].cod_estoque + '">' + j[i].ds_prateleira +' | '+ j[i].ds_coluna +' | '+ j[i].ds_altura +' | '+ j[i].ds_embalagem +  '</option>';
					}   
					$('#id_fx_ex').html(options).show();
					$('.carregando').hide();
				});
			} else {
				$('#id_fx_ex').html('<option value="">Escolha o feixe</option>');
			}
		});

		$(document).on('click', '#btnInsPedidoFx', function(){
			if(confirm("Confirma a inclusão do produto?")){			
				$('#btnInsPedidoFx').prop("disabled", true);
				event.preventDefault();
				$('#tabela').hide();
				$('#aviso').hide();
				var cod_estoque_fx = $('#id_fx_ex').val();
				$.ajax
				({
					url:"data/torre/gera_pedido_fx.php",
					method:"POST",
					dataType:'json',
					data:{
						cod_estoque_fx:cod_estoque_fx
					},
					success:function(j)
					{
						for (var i = 0; i < j.length; i++) {
							if(j[i].info == "0"){

								var novo_pedido = j[i].novo_pedido;

								alert("Pedido criado com sucesso!");

								$('#info_produtos').load('data/torre/list_pedido_fx.php?search=',{novo_pedido:novo_pedido});

							}else if(j[i].info == "1"){

								alert(j[i].retorno);

							}
						}
					}
				});			
				$('#btnInsPedidoFx').prop("disabled", false);
			}
			return false;
		});

		$(document).on('click', '#btnInsPedido', function(){
			if(confirm("Confirma a inclusão do produto?")){			
				$('#btnInsPedido').prop("disabled", true);
				event.preventDefault();
				$('#tabela').hide();
				$('#aviso').hide();
				var id_parte_ex = $('#id_parte_ex').val();
				var id_item_ex = $('#id_item_ex').val();
				var nr_qtde = $('#nr_qtde').val();
				var cod_est = $('#id_rua_ex').find(':selected').attr("data-estoque");
				var cod_rua = $('#id_rua_ex').find(':selected').attr("data-rua");
				var cod_col = $('#id_rua_ex').find(':selected').attr("data-coluna");
				var cod_alt = $('#id_rua_ex').find(':selected').attr("data-altura");
				if(nr_qtde == ''){

					alert('Digite a quantidade!');

				}else{

					$.ajax
					({
						url:"data/torre/gera_pedido_torre.php",
						method:"POST",
						data:{
							id_parte_ex:id_parte_ex,
							id_item_ex:id_item_ex,
							nr_qtde:nr_qtde,
							cod_est:cod_est,
							cod_rua:cod_rua,
							cod_col:cod_col,
							cod_alt:cod_alt
						},
						success:function(j)
						{
							$('#info_produtos').html(j);
						}
					});

							
				}			
				$('#btnInsPedido').prop("disabled", false);
			}
			return false;
		});
		
		$(document).on('click', '#btnFinPedido', function(){
			var id_pedido = $(this).val();
			$.ajax({
				url:"data/torre/finaliza_pedido.php",
				method:"POST",
				data:{id_pedido:id_pedido},
				success:function(data)
				{
					$('#tabela').html(data);
				}
			});
			return false;
		});
		
		$(document).on('click', '#btnFinPedidoPend', function(){
			var id_pedido = $(this).val();
			$.ajax
			({
				url:"data/torre/finaliza_pedido_pendente.php",
				method:"POST",
				dataType:'json',
				data:{id_pedido:id_pedido},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {
						if(j[i].info == "0"){

							alert("Pedido criado com sucesso!");

						}else if(j[i].info == "1"){

							alert("Erro na criação do pedido!");

						}
					}
				}
			});
			return false;
		});
	});

	$(document).ready(function(){
		$(document).on('click', '#ConsSaldoTorre', function(){
			event.preventDefault();
			var id_torre_con = $('#id_torre_con').val();
			if(id_torre_con == ''){

				alert('Selecione a torre');

			} else {

				$.ajax
				({
					url:"data/torre/list_saldo_torre.php",
					method:"POST",
					data:{id_torre_con:id_torre_con},
					beforeSend:function(e){
						$("#tabela").html("<img src='css/loading9.gif'>");
					},
					success:function(data)
					{
						$("#tabela").html(data);
					}
				});
			}
		});
		
	    $(document).on('click', '#ConsSldTorreDtl', function(){
            event.preventDefault();
            var id_torre_sld = $('#id_torre_con').val();
            if(id_torre_sld == ''){

            	alert('Selecione a torre');

            } else {

            	$.ajax({
		            url:"data/torre/list_saldo_torre_estoque.php",
		            method:"POST",
		            data:{id_torre_sld:id_torre_sld},
		            beforeSend:function(e){
		            	$("#tabela").html("<img src='css/loading9.gif'>");
			        },
		            success:function(data)
		            {
		                $("#tabela").html(data);
		            }
	            });
            }
        });

		$(document).on('click', '#ConsSaldoPecas', function(){
			event.preventDefault();
			var id_pc_con = $('#id_torre_con').val();
			if(id_pc_con == ''){

				alert('Selecione a torre');

			} else {

				$.ajax({
					url:"data/torre/list_saldo_pc.php",
					method:"POST",
					data:{id_pc_con:id_pc_con},
					beforeSend:function(e){
						$("#tabela").html("<img src='css/loading9.gif'>");
					},
					success:function(data)
					{
						$("#tabela").html(data);
					}
				});
			}
			return false;
		});

		$(document).on('change', '#id_torre_con', function(){
			if( $(this).val() ) {
				$('#id_parte_con').hide();
				$.getJSON('data/torre/consulta_parte.php?search=',{id_torre: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a parte da Torre</option>'; 
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id + '">' + j[i].parte + '</option>';
					}   
					$('#id_parte_con').html(options).show();
					$('.carregando').hide();
				});
			} else {
				$('#id_parte_con').html('<option value="">Escolha parte da Torre</option>');
			}
		});

		$(document).on('click', '#ConsSalTorreDtl', function(){
			event.preventDefault();
			$('.carregando').show();
			var id_parte_con = $('#id_parte_con').val();
			if(id_parte_con == ''){

				alert('Selecione a parte');

			} else {

				$.ajax({
					url:"data/torre/list_saldo_torre_dtl.php",
					method:"POST",
					data:{id_parte_con:id_parte_con},
					beforeSend:function(e){
						$("#tabela").html("<img src='css/loading9.gif'>");
					},
					success:function(data)
					{
						$("#tabela").html(data);
					}
				});
			}
			return false;
		});

		$(document).on('click', '#btnDtlSalParte', function(){
			event.preventDefault();
			$('#btnDtlSalParte').prop("disabled", true);
			var id_parte_item = $(this).val();
			$.ajax({
				url:"data/torre/modal/m_saldo_item.php",
				method:"POST",
				data:{id_parte_item:id_parte_item},
				success:function(data)
				{
					$('#tabelaItem').html(data);
				}
			});
			$('#btnDtlSalParte').prop("disabled", false);
		});

		$(document).on('click', '#btnDtlSalMin', function(){
			event.preventDefault();
			var id_parte_item = $(this).val();
			$.ajax({
				url:"data/torre/modal/m_saldo_eminimo.php",
				method:"POST",
				data:{id_parte_item:id_parte_item},
				success:function(data)
				{
					$('#tabelaItem').html(data);
				}
			});
			return false;
		});

		$(document).on('click', '#btnDtlSalPeca', function(){
			event.preventDefault();
			var id_parte_item = $(this).val();
			$.ajax({
				url:"data/torre/modal/m_saldo_item.php",
				method:"POST",
				data:{id_parte_item:id_parte_item},
				success:function(data)
				{
					$('#tabelaItem').html(data);
				}
			});
		});
	});

	$(document).ready(function(){
		$(document).on('click','#btnPesqPedidoTorre',function(){
			event.preventDefault();
			$('#btnPesqPedidoTorre').prop("disabled", true);
			var pedido_torre = $('#nr_pedido').val();
			var status = $("input[name='pesqStatus']:checked").val();

			if(pedido_torre != '' && $('PesqStatusAberto').prop("checked")){

				alert("Se pesquisar pelo número do pedido, não selecione o status.");

			}else{

				$.ajax
				({
					url:'data/torre/list_pedido_pendente.php',
					method:'POST',
					data:{
						status:status,
						pedido_torre:pedido_torre
					},
					success:function(data){
						$('#info_pedidos').html(data);
					}
				});

			}
			$('#btnPesqPedidoTorre').prop("disabled", false);
			return false;
		});

		$(document).on('click', '#btnPrintPickingTorre', function(){
			var cod_pedido = $(this).val();
			$.ajax({
				url:"data/torre/relatorio/consulta_status.php",
				method:"POST",
				dataType:'json',
				data:{cod_pedido:cod_pedido},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {
						if(j[i].fl_status != 'A' && j[i].fl_status != 'C'){

							$.ajax
							({
								url:"data/torre/relatorio/picking_list_torre.php",
								method:"POST",
								data:{cod_pedido:cod_pedido},
								success:function(data)
								{
									$('#wid-id-0').html(data);
								}
							});

						}else{

							alert("É preciso iniciar a coleta para imprimir a Picking list.");
						}
					}
				}
			});
			return false;
		});
/*
		$(document).on('click', '#btnPesqPedidoPen', function(){
			event.preventDefault();
			var nr_pedido_pen = $('#nr_pedido_pen').val();
			$.ajax({
				url:"data/torre/list_pedido_pendente.php",
				method:"POST",
				data:{nr_pedido_pen:nr_pedido_pen},
				success:function(data)
				{
					$('#tabela').html(data);
				}
			});
			return false;
		});*/
	});

	$(document).ready(function(){
		$(document).on('click', '#RelSaldoTorre', function(){
			event.preventDefault();
			var id_torre_rel = $('#id_torre_rel').val();
			if(id_torre_rel == ''){

				alert('Selecione a torre');

			} else {

				$.ajax({
					url:"data/torre/modal/m_sel_parte.php",
					method:"POST",
					data:{id_torre_rel:id_torre_rel},
					beforeSend:function(e){
						$("#tabela").html("<img src='css/loading9.gif'>");
					},
					success:function(data)
					{
						$("#tabela").html(data);
					}
				});
			}
		});

		$(document).on('click', '#btnGeraRelSaldo', function(){
			event.preventDefault();
			if( $('.checkParte:checked').length == 0 ){

				alert('Selecione pelo menos um pedido!');

			}else{

				var parte = [];

				$('.checkParte:checked').each(function(){
					parte.push($(this).val());
				});

				$.ajax
				({
					url:'data/torre/list_parte_torre.php',
					method:'POST',
					data:{
						parte:parte
					},
					success:function(data)
					{
						$('#saldoItem').modal('hide');
						$("#retReport").html(data);
					}
				});
			}
		});
	});

	/* 41/01/19 - CONSULTA POSIÇÃO */

	$(document).ready(function(){
		$(document).on('click', '#ConsSaldoPosicao', function(){
			event.preventDefault();
			var id_torre_pos = $('#id_torre_pos').val();
			var nr_posicao = $('#nr_posicao').val();
			var nr_posicao_dig = $('#nr_posicao_dig').val();
			if(nr_posicao_dig == '' && id_torre_pos == ''){

				alert('Digite pelo menos a posição.');

			} else {

				$.ajax
				({
					url:"data/torre/list_saldo_pc_dtl.php",
					method:"POST",
					data:{
						nr_posicao:nr_posicao,
						id_torre_pos:id_torre_pos,
						nr_posicao_dig:nr_posicao_dig
					},
					beforeSend:function(e){
						$("#tabela").html("<img src='css/loading9.gif'>");
					},
					success:function(data)
					{
						$("#tabela").html(data);
					}
				});
			}
		});

		$(document).on('change', '#id_torre_pos', function(){
			event.preventDefault();
			if( $(this).val() ) {
				$('#nr_posicao_dig').hide();
				$('#nr_posicao').hide();
				$('.carregando').show();
				$.getJSON('data/torre/consulta_torre_posicao.php?search=',{id_torre_pos: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a posição</option>'; 
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].nr_posicao + '">' + j[i].nr_posicao + '</option>';
					}   
					$('#nr_posicao').html(options).show();
					$('.carregando').hide();
				});
			} else {
				$('#nr_posicao').html('<option value="">– Escolha a posição –</option>');
			}
		});
	});