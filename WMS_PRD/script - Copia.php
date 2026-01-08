<script type="text/javascript">

	/*- Chamadas de menu -*/
	$(document).ready(function(){
	/*--- DASHBOARD ---*/

		$('#dashOcupa').click(function(e){
			event.preventDefault();
			$('#conteudo').load('dash_ocupa_estoque.php');
		});


	/*--- fim DASHBOARD ---*/

	/*--- EMPRESA ---*/
	

		$('#cadTeste').click(function(e){
			event.preventDefault();
			$('#conteudo').load('teste.php');
		});

		$('#empresa').click(function(e){
			event.preventDefault();
			$('#conteudo').load('empresa.php');
		});

		$('#cadUsuarios').click(function(e){
			event.preventDefault();
			$('#conteudo').load('usuarios.php');
		});

		$('#btnLoadProfile').click(function(e){
			event.preventDefault();
			$('#conteudo').load('data/empresa/profile.php');
		});

		$('#cadCargos').click(function(e){
			event.preventDefault();
			$('#conteudo').load('cargos.php');
		});

		$('#cadDeptos').click(function(e){
			event.preventDefault();
			$('#conteudo').load('depto.php');
		});

		/*--- Fim EMPRESA ---*/

		/*--- ENTIDADES ---*/

		$('#cadCliente').click(function(e){
			event.preventDefault();
			$('#conteudo').load('cliente.php');
		});

		$('#cadDestinatario').click(function(e){
			event.preventDefault();
			$('#conteudo').load('destinatario.php');
		});

		/*--- Fim ENTIDADES ---*/

		/*--- Armazém ---*/

		$('#cadGalpao').click(function(e){
			event.preventDefault();
			$('#conteudo').load('galpao.php');
		});

		$('#cadLocal').click(function(e){
			event.preventDefault();
			$('#conteudo').load('local.php');
		});

		$('#cadDoca').click(function(e){
			event.preventDefault();
			$('#conteudo').load('doca.php');
		});

		$('#ConsEstoque').click(function(e){
			event.preventDefault();
			$('#conteudo').load('consulta_estoque.php');
		});

		/*--- Fim Armazém ---*/

		/*--- Produtos ---*/

		$('#cadProduto').click(function(e){
			event.preventDefault();
			$('#conteudo').load('produto.php');
		});

		$('#cadKit').click(function(e){
			event.preventDefault();
			$('#conteudo').load('produto_kit.php');
		});

		$('#cadComp').click(function(e){
			event.preventDefault();
			$('#conteudo').load('componente.php');
		});

		$('#ConsNs').click(function(e){
			event.preventDefault();
			$('#conteudo').load('n_serie.php');
		});

		$('#CadAval').click(function(e){
			event.preventDefault();
			$('#conteudo').load('aval.php');
		});

		$('#CadGrupo').click(function(e){
			event.preventDefault();
			$('#conteudo').load('grupo.php');
		});

		$('#CadSgrupo').click(function(e){
			event.preventDefault();
			$('#conteudo').load('sgrupo.php');
		});

		/*--- Fim Produtos ---*/

		/*--- Recebimento ---*/

		$('#cadRecebimento').click(function(e){
			event.preventDefault();
			$('#conteudo').load('recebimento.php');
		});

		
		/*--- Fim Recebimento ---*/

		/*--- Movimento ---*/

		$('#cadAloc').click(function(e){
			event.preventDefault();
			$('#conteudo').load('alocacao.php');
		});

		$('#cadTransf').click(function(e){
			event.preventDefault();
			$('#conteudo').load('movimenta.php');
		});

		/*--- Fim Movimento ---*/
		/*--- Movimento - Pedidos ---*/

		$('#cadPed').click(function(e){
			event.preventDefault();
			$('#conteudo').load('pedido.php');
		});

		$('#NovoPed').on('click',function(e){
			event.preventDefault();
			$('#conteudo').load('novo_pedido.php');
		});

		$('#btnInsNovoPed').on('click', function(e){
			event.preventDefault();
			$('#conteudo').load('novo_pedido_sql.php');
		});

		/*--- Fim Pedidos ---*/

		/*--- Coletas ---*/

		$('#ConsCol').click(function(e){
			event.preventDefault();
			$('#conteudo').load('coleta.php');
		});

		/*--- Fim Coletas ---*/

		/*--- Expedição ---*/

		$('#CadExped').click(function(e){
			event.preventDefault();
			$('#conteudo').load('expede.php');
		});

		/*--- Fim Coletas ---*/

		/*--- Torres ---*/
		
		$('#CadTorreTipo').click(function(e){
			event.preventDefault();
			$('#conteudo').load('cadastro_torre_tipo.php');
		});

		$('#CadTorreParte').click(function(e){
			event.preventDefault();
			$('#conteudo').load('cadastro_torre_parte.php');
		});

		$('#CadTorreItem').click(function(e){
			event.preventDefault();
			$('#conteudo').load('cadastro_torre_item.php');
		});

		$('#CadExpTorre').click(function(e){
			event.preventDefault();
			$('#conteudo').load('exp_torre.php');
		});

		/*--- Fim Torres ---*/

		/*---Inventário ---*/

		$('#cadParam').click(function(e){
			event.preventDefault();
			$('#conteudo').load('inv_param.php');
		});

		$('#ConsProg').click(function(e){
			event.preventDefault();
			$('#conteudo').load('inv_prog.php');
		});

		$('#ConsTar').click(function(e){
			event.preventDefault();
			$('#conteudo').load('inv_tar.php');
		});

		/*--- Fim Inventário ---*/

		/*- Chamadas de modal -*/
		$(document).on('click', '#btnDtlEmpresa', function(){
			var dtl_empresa = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/dtl_empresa.php",
				    method:"POST",
				    data:{dtl_empresa:dtl_empresa},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnUpdEmpresa', function(){
			var upd_empresa = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/upd_empresa.php",
				    method:"POST",
				    data:{upd_empresa:upd_empresa},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnInsTask', function(){
		    $('#formCadTask').ajaxForm({
		        target:'#retorno_task',
		        url:'data/empresa/ins_task.php',
		        beforeSend:function(e){
		            $("#retorno_task").html("<img src='css/loading9.gif'>");
		        }
		    });
		});

		$(document).on('click', '#btnFimTask', function(){
			var id_task = $(this).val();
				$.ajax({
				    url:"data/empresa/fin_task.php",
				    method:"POST",
				    data:{id_task:id_task},
				    success:function(data)
				    {
				        $('#retorno_task').html(data);
				    }
				});
			});

		$(document).on('click', '#btnUpdPass', function(){
			var id_user = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/m_upd_pass.php",
				    method:"POST",
				    data:{id_user:id_user},
				    success:function(data)
				    {
				        $('#retorno_task').html(data);
				    }
				});
			});

		$(document).on('click', '#btnFormUpdPass', function(){
		    $('#formUpdPass').ajaxForm({
		        target:'#retorno_task',
		        url:'data/empresa/upd_pass.php',
		        beforeSend:function(e){
		            $("#retorno_task").html("<img src='css/loading9.gif'>");
		        }
		    });
		});

		$(document).on('click', '#btnUpdTask', function(){
			var id_task = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/m_upd_task.php",
				    method:"POST",
				    data:{id_task:id_task},
				    success:function(data)
				    {
				        $('#retorno_task').html(data);
				    }
				});
			});

		$(document).on('click', '#btnFormUpdTask', function(){
		    $('#formUpdTask').ajaxForm({
		        url:'data/empresa/upd_task.php',
		        success:function(data)
				    {
				    	$('#upd_task').modal('hide');
				        $('#retorno_task').html(data);
				    }
		    });
		});

		/*-- Usuários --*/

		$(document).on('click', '#btnNewUser', function(){
			var ins_usuario = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/ins_usuario.php",
				    method:"POST",
				    data:{ins_usuario:ins_usuario},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnCadUsuario', function(){
		    $('#formCadUsuario').ajaxForm({
		        target:'#retorno',
		        url:'data/empresa/ins_user.php',
		        beforeSend:function(e){
		            $("#retorno").html("<img src='css/loading9.gif'>");
		        }
		    });
		});

		$(document).on('click', '#btnDtlUser', function(){
			var dtl_usuario = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/dtl_usuario.php",
				    method:"POST",
				    data:{dtl_usuario:dtl_usuario},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnUpdUser', function(){
			var upd_usuario = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/upd_usuario.php",
				    method:"POST",
				    data:{upd_usuario:upd_usuario},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		/*- Fim usuários -*/
		/*- Cargos -*/

		$(document).on('click', '#btnNewCargo', function(){
			var ins_cargo = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/m_ins_cargo.php",
				    method:"POST",
				    data:{ins_cargo:ins_cargo},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnCadCargo', function(){
		    $('#formCadCargo').ajaxForm({
		        target:'#retorno',
		        url:'data/empresa/modal/ins_cargo.php',
		        beforeSend:function(e){
		            $("#retorno").html("<img src='css/loading9.gif'>");
		        }
		    });
		});

		$(document).on('click', '#btnDtlCargo', function(){
			var dtl_cargo = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/dtl_cargo.php",
				    method:"POST",
				    data:{dtl_cargo:dtl_cargo},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		/*- Fim cargos -*/

		/*- Departamentos -*/

		$(document).on('click', '#btnNewDepto', function(){
			var ins_depto = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/m_ins_depto.php",
				    method:"POST",
				    data:{ins_depto:ins_depto},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnCadDepto', function(){
		    $('#formCadDepto').ajaxForm({
		        target:'#retorno',
		        url:'data/empresa/ins_depto.php',
		        beforeSend:function(e){
		            $("#retorno").html("<img src='css/loading9.gif'>");
		        }
		    });
		});

		$(document).on('click', '#btnDtlDepto', function(){
			var dtl_depto = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/dtl_depto.php",
				    method:"POST",
				    data:{dtl_depto:dtl_depto},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnUpdDepto', function(){
			var upd_depto = $(this).val();
				$.ajax({
				    url:"data/empresa/modal/m_upd_depto.php",
				    method:"POST",
				    data:{upd_depto:upd_depto},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#SubUpdDepto', function(){
		    $('#formUpdDepto').ajaxForm({
		        target:'#retorno',
		        url:'data/empresa/upd_depto.php',
		        beforeSend:function(e){
		            $("#retorno").html("<img src='css/loading9.gif'>");
		        }
		    });
		});

		/*- Fim departamentos -*/

		/*- Clientes -*/

		$(document).on('click', '#btnDtlCliente', function(){
			var dtl_cliente = $(this).val();
				$.ajax({
				    url:"data/entidade/modal/m_dtl_cliente.php",
				    method:"POST",
				    data:{dtl_cliente:dtl_cliente},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnUpdCliente', function(){
			var upd_cliente = $(this).val();
				$.ajax({
				    url:"data/entidade/modal/m_upd_cliente.php",
				    method:"POST",
				    data:{upd_cliente:upd_cliente},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnUsrCliente', function(){
			var usr_cliente = $(this).val();
				$.ajax({
				    url:"data/entidade/modal/m_usr_cliente.php",
				    method:"POST",
				    data:{usr_cliente:usr_cliente},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnDtlUsrCliente', function(){
			var dtl_usr_cliente = $(this).val();
				$.ajax({
				    url:"data/entidade/modal/m_dtl_usr_cliente.php",
				    method:"POST",
				    data:{dtl_usr_cliente:dtl_usr_cliente},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		/*- Fim Clientes -*/

		/*- Destinatários -*/

		$(document).on('click', '#btnDtlDestinatario', function(){
			var dtl_destinatario = $(this).val();
				$.ajax({
				    url:"data/entidade/modal/m_dtl_destinatario.php",
				    method:"POST",
				    data:{dtl_destinatario:dtl_destinatario},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnUpdDestinatario', function(){
			var upd_destinatario = $(this).val();
				$.ajax({
				    url:"data/entidade/modal/m_upd_destinatario.php",
				    method:"POST",
				    data:{upd_destinatario:upd_destinatario},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnNewDestinatario', function(){
			var ins_destinatario = $(this).val();
				$.ajax({
				    url:"data/entidade/modal/m_ins_destinatario.php",
				    method:"POST",
				    data:{ins_destinatario:ins_destinatario},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnCadDestinatario', function(){
		    $('#formCadDestinatario').ajaxForm({
		        target:'#retorno',
		        url:'data/entidade/ins_destinatario.php',
		        beforeSend:function(e){
		            $("#retorno").html("<img src='css/loading9.gif'>");
		        }
		    });
		});

		/*- Fim Destinatários -*/

		/*- Galpão -*/

		$(document).on('click', '#btnUpdGalpao', function(){
			var upd_galpao = $(this).val();
				$.ajax({
				    url:"data/armazem/modal/m_upd_galpao.php",
				    method:"POST",
				    data:{upd_galpao:upd_galpao},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnNewGalpao', function(){
			var ins_galpao = $(this).val();
				$.ajax({
				    url:"data/armazem/modal/m_ins_galpao.php",
				    method:"POST",
				    data:{ins_galpao:ins_galpao},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnCadGalpao', function(){
		    $('#formCadGalpao').ajaxForm({
		        target:'#retorno',
		        url:'data/armazem/ins_galpao.php',
		        beforeSend:function(e){
		            $("#retorno").html("<img src='css/loading9.gif'>");
		        }
		    });
		});

		$(document).on('click', '#btnUpdLocal', function(){
			var upd_local = $(this).val();
				$.ajax({
				    url:"data/armazem/modal/m_upd_local.php",
				    method:"POST",
				    data:{upd_local:upd_local},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnNewLocal', function(){
			var ins_local = $(this).val();
				$.ajax({
				    url:"data/armazem/modal/m_ins_local.php",
				    method:"POST",
				    data:{ins_local:ins_local},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnNewDoca', function(){
			var ins_doca = $(this).val();
				$.ajax({
				    url:"data/armazem/modal/m_ins_doca.php",
				    method:"POST",
				    data:{ins_doca:ins_doca},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});
		
		$(document).on('click', '#btnConsultaEstoque', function(){
			$('#formConsultaEstoque').ajaxForm({
				target:'#locais',
				url:'data/armazem/locais_list_detalhe.php',
				beforeSend:function(e){
					$("#locais").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnPesquisaProjeto', function(){
			$('#formPesquisaProjeto').ajaxForm({
				target:'#locais',
				url:'data/armazem/projeto_list_detalhe.php',
				beforeSend:function(e){
					$("#locais").html("<img src='css/loading9.gif'>");
				}
			});
		});


		/*- Fim Galpão -*/

		/*- Produtos -*/

		$(document).on('click', '#btnPesquisaCodigo', function(){
			$('#formPesquisaProduto').ajaxForm({
				target:'#info_produtos',
				url:'data/produto/produtos_list_sql.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnPesquisaNome', function(){
			$('#formPesquisaProduto').ajaxForm({
				target:'#info_produtos',
				url:'includes/forms/produtos/produtos_list_sql.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnNovoProduto', function(){
			var ins_produto = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_ins_produto.php",
				    method:"POST",
				    data:{ins_produto:ins_produto},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnFormNovoProduto', function(){
			$('#formNovoProduto').ajaxForm({
				target:'#info_produtos',
				url:'data/produto/ins_produto.php',
				beforeSend:function(e){
					$("#retorno").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnUpdProduto', function(){
			var upd_produto = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_upd_produto.php",
				    method:"POST",
				    data:{upd_produto:upd_produto},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnDtlProduto', function(){
			var dtl_produto = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_dtl_produto.php",
				    method:"POST",
				    data:{dtl_produto:dtl_produto},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnNovoKit', function(){
			var ins_kit = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_ins_kit.php",
				    method:"POST",
				    data:{ins_kit:ins_kit},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnFormNovoKit', function(){
			$('#formNovoKit').ajaxForm({
				target:'#info_produtos',
				url:'data/produto/ins_kit.php',
				beforeSend:function(e){
					$("#retorno").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnDtlKit', function(){
			var dtl_kit = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_dtl_kit.php",
				    method:"POST",
				    data:{dtl_kit:dtl_kit},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnUpdKit', function(){
			var upd_kit = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_upd_kit.php",
				    method:"POST",
				    data:{upd_kit:upd_kit},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnFormUpdKit', function(){
			$('#formUpdKit').ajaxForm({
				target:'#info_produtos',
				url:'data/produto/upd_kit.php',
				beforeSend:function(e){
					$("#retorno").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnProdKit', function(){
			var prod_kit = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_produto_kit.php",
				    method:"POST",
				    data:{prod_kit:prod_kit},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnNovoProdutoKit', function(){
            e.preventDefault()
            var id_kit = $('#id_kit').val();
	        var cod_estoque = $('#cod_estoque').val();
	        var quantidade = $('#quantidade').val();
	            $.ajax({
	                url:"data/produto/ins_kit_produto.php",
	                method:"POST",
	                data:{cod_estoque:cod_estoque, quantidade:quantidade, id_kit:id_kit},
	                success:function(data)
	            	{
	                   	$('#formNovoKitProduto')[0].reset();
	                   	$('#kit_produto').modal('show');
	                   	$('#produtoKit').load('data/produto/modal/m_produto_kit_sql.php')
	                 }
                });
               	return false;
            });

		$(document).on('click', '#btnVarKit', function(){
			var var_kit = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_var_kit.php",
				    method:"POST",
				    data:{var_kit:var_kit},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnNovoVarKit', function(){
            e.preventDefault()
            var id_kit = $('#id_kit').val();
	        var cod_estoque = $('#cod_estoque').val();
	        var cod_estoque_sbst = $('#cod_estoque_sbst').val();
	            $.ajax({
	                url:"data/produto/ins_kit_var.php",
	                method:"POST",
	                data:{cod_estoque:cod_estoque, cod_estoque_sbst:cod_estoque_sbst, id_kit:id_kit},
	                success:function(data)
	            	{
	                   	$('#formNovoKitVar')[0].reset();
	                   	$('#kit_var').modal('show');
	                   	$('#varKit').load('data/produto/modal/m_var_kit_sql.php')
	                 }
                });
               	return false;
            });

		$(document).on('click', '#btnNovoComp', function(){
			var ins_comp = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_ins_comp.php",
				    method:"POST",
				    data:{ins_comp:ins_comp},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnFormNovoComp', function(){
			$('#formNovoComp').ajaxForm({
				target:'#retorno',
				url:'data/produto/ins_comp.php',
				beforeSend:function(e){
					$("#retorno").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnDtlComp', function(){
		var dtl_comp = $(this).val();
			$.ajax({
				url:"data/produto/modal/m_dtl_componente.php",
				method:"POST",
				data:{dtl_comp:dtl_comp},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnUpdComp', function(){
			var upd_comp = $(this).val();
				$.ajax({
					url:"data/produto/modal/m_upd_componente.php",
					method:"POST",
					data:{upd_comp:upd_comp},
					success:function(data)
					{
					    $('#retorno').html(data);
					}
				});
			});

		$(document).on('click', '#btnProdComp', function(){
			var prod_comp = $(this).val();
				$.ajax({
					url:"data/produto/modal/m_produto_comp.php",
					method:"POST",
					data:{prod_comp:prod_comp},
					success:function(data)
					{
					    $('#retorno').html(data);
					}
				});
			});

		$(document).on('click', '#btnNovoProdutoComp', function(){
            e.preventDefault()
            var prod_comp = $('#prod_comp').val();
	        var cod_produto = $('#cod_produto').val();
	        var nr_qtde_comp = $('#nr_qtde_comp').val();
	            $.ajax({
	                url:"data/produto/ins_comp_produto.php",
	                method:"POST",
	                data:{cod_produto:cod_produto, nr_qtde_comp:nr_qtde_comp, prod_comp:prod_comp},
	                success:function(data)
	            	{
	                   	$('#formNovoCompProduto')[0].reset();
	                   	$('#comp_produto').modal('show');
	                   	$('#produtoComp').load('data/produto/modal/m_produto_comp_sql.php')
	                 }
                });
               	return false;
            });

		$(document).on('click', '#btnPesquisaNs', function(){
			$('#formPesquisaNs').ajaxForm({
				target:'#info_produtos',
				url:'data/produto/ns_list_sql.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnHistNs', function(){
			var hist_ns = $(this).val();
				$.ajax({
					url:"data/produto/modal/m_hist_ns.php",
					method:"POST",
					data:{hist_ns:hist_ns},
					success:function(data)
					{
					    $('#retorno').html(data);
					}
				});
			});

		$(document).on('click', '#btnUpdAval', function(){
			var upd_aval = $(this).val();
				$.ajax({
					url:"data/produto/modal/m_upd_aval.php",
					method:"POST",
					data:{upd_aval:upd_aval},
					success:function(data)
					{
					    $('#retorno').html(data);
					}
				});
			});

		$(document).on('click', '#btnFormUpdAval', function(){
			$('#formUpdAval').ajaxForm({
				target:'#info_produtos',
				url:'data/produto/upd_aval.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnNovoAval', function(){
			var ins_aval = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_ins_aval.php",
				    method:"POST",
				    data:{ins_aval:ins_aval},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnFormNovoAval', function(){
			$('#formNovoAval').ajaxForm({
				target:'#retorno',
				url:'data/produto/ins_aval.php',
				beforeSend:function(e){
					$("#retorno").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnNovoGrupo', function(){
			var ins_grupo = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_ins_grupo.php",
				    method:"POST",
				    data:{ins_grupo:ins_grupo},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnFormNovoGrupo', function(){
			$('#formNovoGrupo').ajaxForm({
				target:'#retorno',
				url:'data/produto/ins_grupo.php',
				beforeSend:function(e){
					$("#retorno").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnUpdGrupo', function(){
			var upd_grupo = $(this).val();
				$.ajax({
					url:"data/produto/modal/m_upd_grupo.php",
					method:"POST",
					data:{upd_grupo:upd_grupo},
					success:function(data)
					{
					    $('#retorno').html(data);
					}
				});
			});

		$(document).on('click', '#btnFormUpdGrupo', function(){
			$('#formUpdGrupo').ajaxForm({
				target:'#info_produtos',
				url:'data/produto/upd_grupo.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnNovoSgrupo', function(){
			var ins_sgrupo = $(this).val();
				$.ajax({
				    url:"data/produto/modal/m_ins_sgrupo.php",
				    method:"POST",
				    data:{ins_sgrupo:ins_sgrupo},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnFormNovoSgrupo', function(){
			$('#formNovoSgrupo').ajaxForm({
				target:'#retorno',
				url:'data/produto/ins_sgrupo.php',
				beforeSend:function(e){
					$("#retorno").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnUpdSgrupo', function(){
			var upd_sgrupo = $(this).val();
				$.ajax({
					url:"data/produto/modal/m_upd_sgrupo.php",
					method:"POST",
					data:{upd_sgrupo:upd_sgrupo},
					success:function(data)
					{
					    $('#retorno').html(data);
					}
				});
			});

		$(document).on('click', '#btnFormUpdGrupo', function(){
			$('#formUpdGrupo').ajaxForm({
				target:'#info_produtos',
				url:'data/produto/upd_sgrupo.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnSolRep', function(){
			var sol_rep = $(this).val();
				$.ajax({
				    url:"data/produto/modal/sol_rep_produto.php",
				    method:"POST",
				    data:{sol_rep:sol_rep},
				    success:function(data)
				    {
				        $('#rep_kit').modal('show');
				    }
				});
			});

		/*- Fim Produtos -*/

		/*- Recebimento -*/

		$(document).on('click', '#btnNovoRec', function(){
			var ins_rec = $(this).val();
				$.ajax({
				    url:"data/recebimento/modal/m_ins_recebimento.php",
				    method:"POST",
				    data:{ins_rec:ins_rec},
				    success:function(data)
				    {
				        $('#retorno').html(data);
				    }
				});
			});

		$(document).on('click', '#btnFormNovoRec', function(){
			$('#formNovoRec').ajaxForm({
				target:'#retorno',
				url:'data/produto/ins_recebimento.php',
				beforeSend:function(e){
					$("#retorno").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnDtlRec', function(){
		var dtl_rec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_dtl_recebimento.php",
				method:"POST",
				data:{dtl_rec:dtl_rec},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnUpdRec', function(){
		var upd_rec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_upd_recebimento.php",
				method:"POST",
				data:{upd_rec:upd_rec},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnFormUpdRec', function(){
			$('#formUpdRec').ajaxForm({
				target:'#info_produtos',
				url:'data/recebimento/upd_rec.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnNfRec', function(){
		var nf_rec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_nf_recebimento.php",
				method:"POST",
				data:{nf_rec:nf_rec},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnFormNovoNfRec', function(){
            e.preventDefault()
            var cod_rec = $('#cod_rec').val();
	        var nr_fisc_ent = $('#nr_fisc_ent').val();
	        var dt_emis_ent = $('#dt_emis_ent').val();
	        var nr_cfop_ent = $('#nr_cfop_ent').val();
	        var tp_vol_ent = $('#tp_vol_ent').val();
	        var vl_tot_nf_ent = $('#vl_tot_nf_ent').val();
	        var base_icms_ent = $('#base_icms_ent').val();
	        var vl_icms_ent = $('#vl_icms_ent').val();
	        var chavenfe = $('#chavenfe').val();
	        var ds_obs_nf = $('#ds_obs_nf').val();
	            $.ajax({
	                url:"data/recebimento/ins_nf_recebimento.php",
	                method:"POST",
	                data:{cod_rec:cod_rec, nr_fisc_ent:nr_fisc_ent, dt_emis_ent:dt_emis_ent, nr_cfop_ent:nr_cfop_ent, tp_vol_ent:tp_vol_ent, vl_tot_nf_ent:vl_tot_nf_ent, base_icms_ent:base_icms_ent, vl_icms_ent:vl_icms_ent, chavenfe:chavenfe, ds_obs_nf:ds_obs_nf},
	                success:function(data)
	            	{
	                   	$('#formNovoNfRec')[0].reset();
	                   	$('#nf_recebimento').modal('show');
	                   	$('#retornoNf').load('data/recebimento/modal/m_nf_recebimento_sql.php')
	                 }
                });
               	return false;
            });

		$(document).on('click', '#btnModalXml', function(){
		var xml_rec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_xml_recebimento.php",
				method:"POST",
				data:{xml_rec:xml_rec},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnDtlNfrec', function(){
			var dtl_nfrec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_dtl_nf_recebimento.php",
				method:"POST",
				data:{dtl_nfrec:dtl_nfrec},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnUpdNfrec', function(){
			var upd_nfrec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_upd_nf_recebimento.php",
				method:"POST",
				data:{upd_nfrec:upd_nfrec},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnFormUpdNfRecebimento', function(){
			$('#formUpdNfRecebimento').ajaxForm({
				target:'#info_produtos',
				url:'data/recebimento/upd_nf_rec.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnDelNfrec', function(){
			var del_nfrec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_del_nf_recebimento.php",
				method:"POST",
				data:{del_nfrec:del_nfrec},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnFormDelNfRecebimento', function(){
			$('#formDelNfRecebimento').ajaxForm({
				target:'#info_produtos',
				url:'data/recebimento/del_nf_rec.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnProdRec', function(){
			var prod_nfrec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_prod_nf_recebimento.php",
				method:"POST",
				data:{prod_nfrec:prod_nfrec},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('change', '#produto_nf', function(){
            var id_nf = $(this).val();
	            $.ajax({
	                url:"data/recebimento/consulta_nf.php",
	                method:"POST",
	                data:{id_nf:id_nf},
	                success:function(data)
	            	{
	                   	$('#formNf').load('data/recebimento/modal/m_prod_nf_recebimento_sql.php')
	                 }
                });
               	return false;
            });

		$(document).on('click', '#btnFormNovoProdRec', function(){
            e.preventDefault()
            var cod_nf_entrada = $('#cod_nf_entrada').val();
	        var cod_prod_cliente = $('#cod_prod_cliente').val();
	        var nr_qtde = $('#nr_qtde').val();
	        var vl_unit = $('#vl_unit').val();
	        var nr_peso_ent = $('#nr_peso_ent').val();
	        var estado_produto = $('#estado_produto').val();
	            $.ajax({
	                url:"data/recebimento/ins_prd_recebimento.php",
	                method:"POST",
	                data:{cod_nf_entrada:cod_nf_entrada, cod_prod_cliente:cod_prod_cliente, nr_qtde:nr_qtde, vl_unit:vl_unit, nr_peso_ent:nr_peso_ent, estado_produto:estado_produto},
	                success:function(data)
	            	{
	                   	$('#formNovoProdRec')[0].reset();
	                   	$('#retornoPrd').load('data/recebimento/modal/m_prd_recebimento_sql.php')
	                 }
                });
               	return false;
            });

		$(document).on('click', '#btnFimRec', function(){
			var fim_rec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_finalizar_recebimento.php",
				method:"POST",
				data:{fim_rec:fim_rec},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});
		/*- Fim Recebimento -*/

		/*- Movimentação -*/

		$(document).on('click', '#btnFormalocarCod', function(){
			$('#formAlocCod').ajaxForm({
				target:'#info_produtos',
				url:'data/movimento/alocar_list_sql.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnFormalocarNome', function(){
			$('#formAlocCod').ajaxForm({
				target:'#info_produtos',
				url:'data/movimento/alocar_list_sql.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnAlocMan', function(){
			var cod_estoq = $(this).val();
			$.ajax({
				url:"data/movimento/modal/m_aloca_destino.php",
				method:"POST",
				data:{cod_estoq:cod_estoq},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});
        
            $(document).on('change', '#cmbarmaz', function(){
                if( $(this).val() ) {
                    $('#cmbrua').hide();
                    //$('.carregando').show();
                    $.getJSON('data/movimento/consulta_rua.php?search=',{id_galpao: $(this).val(), ajax: 'true'}, function(j){
                        var options = '<option value="">Escolha a rua</option>'; 
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
                        }   
                        $('#cmbrua').html(options).show();
                        //$('.carregando').hide();
                    });
                } else {
                    $('#cmbrua').html('<option value="">Escolha a rua</option>');
                }
            });

            $(document).on('change', '#cmbrua', function(){
                if( $(this).val() ) {
                    $('#cmbcoluna').hide();
                    //$('.carregando').show();
                    $.getJSON('data/movimento/consulta_coluna.php?search=',{id_rua: $(this).val(), ajax: 'true'}, function(j){
                        var options = '<option value="">Escolha a coluna</option>'; 
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
                        }   
                        $('#cmbcoluna').html(options).show();
                        //$('.carregando').hide();
                    });
                } else {
                    $('#cmbcoluna').html('<option value="">Escolha a coluna</option>');
                }
            });

            $(document).on('change', '#cmbcoluna', function(){
                if( $(this).val() ) {
                    $('#cmbaltura').hide();
                    //$('.carregando').show();
                    $.getJSON('data/movimento/consulta_altura.php?search=',{id_coluna: $(this).val(), ajax: 'true'}, function(j){
                        var options = '<option value="">Escolha a altura</option>'; 
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].altura + '">'  + j[i].altura + '</option>';
                        }   
                        $('#cmbaltura').html(options).show();
                        //$('.carregando').hide();
                    });
                } else {
                    $('#cmbaltura').html('<option value="">Escolha a altura</option>');
                }
            });

        $(document).on('click', '#btnFormAlocacao', function(){
			$('#formAlocacao').ajaxForm({
				target:'#info_produtos',
				url:'data/movimento/ins_alocacao.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnNovons', function(){
			var cod_estoq = $(this).val();
			$.ajax({
				url:"data/movimento/modal/m_ins_ns.php",
				method:"POST",
				data:{cod_estoq:cod_estoq},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnFormMovPrd', function(){
			$('#formMovPrd').ajaxForm({
				target:'#info_produtos',
				url:'data/movimento/mov_list_sql.php',
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click', '#btnMovDest', function(){
			$('#formMovDest').ajaxForm({
				target:'#retorno',
				url:'data/movimento/modal/m_mov_destino.php',
				beforeSend:function(e){
					$("#retorno").html("<img src='css/loading9.gif'>");
				}
			});
		});
		/*- Fim Movimentação -*/

		/*- Movimentação  - Pedidos -*/

		$(document).on('click', '#btnDtlPed', function(){
			var dtl_ped = $(this).val();
			$.ajax({
				url:"data/movimento/modal/m_dtl_pedido.php",
				method:"POST",
				data:{dtl_ped:dtl_ped},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnUpdPed', function(){
			var upd_ped= $(this).val();
			$.ajax({
				url:"data/movimento/modal/m_upd_pedido.php",
				method:"POST",
				data:{upd_ped:upd_ped},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnDelPed', function(){
			var del_ped= $(this).val();
			$.ajax({
				url:"data/movimento/modal/m_del_pedido.php",
				method:"POST",
				data:{del_ped:del_ped},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnNsPed', function(){
			var ns_ped= $(this).val();
			$.ajax({
				url:"data/movimento/consulta_ns_sql.php",
				method:"POST",
				data:{ns_ped:ns_ped},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnColPed', function(){
			var col_ped= $(this).val();
			$.ajax({
				url:"data/movimento/libera_coleta.php",
				method:"POST",
				data:{col_ped:col_ped},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnFormCadPedido', function(){
            event.preventDefault()
            var nm_cliente = $('#nm_cliente').val();
	        var nm_solicitante = $('#nm_solicitante').val();
	        var cod_cliente = $('#cod_cliente').val();
	        var ds_modalidade = $('#ds_modalidade').val();
	        var fl_tipo = $('#fl_tipo').val();
	        var ds_frete = $('#ds_frete').val();
	        var d_limite = $('#d_limite').val();
	        var h_limite = $('#h_limite').val();
	        var ds_obs_sac = $('#ds_obs_sac').val();
	        var ds_doca = $('#ds_doca').val();
	        var nr_pedido = $('#nr_pedido').val();
	            $.ajax({
	                url:"data/movimento/upd_pedido.php",
	                method:"POST",
	                data:{nm_cliente:nm_cliente, nm_solicitante:nm_solicitante, cod_cliente:cod_cliente, ds_modalidade:ds_modalidade, fl_tipo:fl_tipo, ds_frete:ds_frete, d_limite:d_limite, h_limite:h_limite, ds_obs_sac:ds_obs_sac, ds_doca:ds_doca, nr_pedido:nr_pedido},
	                success:function(data)
	            	{
	                   	$('#prd_pedido').load('novo_pedido_sql.php')
	                 }
                });
               	return false;
            });

		$(document).on('click', '#btnInsProdPed', function(){
			var nr_pedido = $(this).val();
			$.ajax({
				url:"data/movimento/modal/m_ins_prd_pedido.php",
				method:"POST",
				data:{nr_pedido:nr_pedido},
				success:function(data)
				{
				    $('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnConsultaProduto', function(){
		    $('#formInsPrdPedido').ajaxForm({
		        target:'#res_produto',
		        url:'data/movimento/ins_prd_pedido.php',
		        beforeSend:function(e){
		            $("#res_produto").html("<img src='css/loading9.gif'>");
		        }
		    });
		});

		$(document).on('click', '#btnInsertPrdPedido', function(){
            event.preventDefault();
            var cod_prod_cliente = $('#cod_prod_cliente').val();
	        var nr_pedido = $('#nr_pedido').val();
	            $.ajax({
	                url:"data/movimento/ins_prd_pedido_coleta.php",
	                method:"POST",
	                data:{cod_prod_cliente:cod_prod_cliente, nr_pedido:nr_pedido},
	                success:function(data)
	            	{
	            		$('#formInsPrdPedido')[0].reset();
	                   	$('#prd_pedido').modal('show')
	                 }
                });
               	return false;
            });

		$(document).on('change', '#cod_cliente_pedido', function(){
            if( $(this).val() ) {
                $('#cnpjDest').hide();
                $.getJSON('data/movimento/consulta_cliente.php?search=',{cod_cliente_pedido: $(this).val(),ajax: 'true'}, function(j){
                    for (var i = 0; i < j.length; i++) {
                    	var options = '<input type="text" class="form-control" id="id_cnpj_dest" value="' + j[i].nr_cnpj_cpf + '">';
                    }   
                    $('#cnpjDest').html(options).show();
                 });
            } else {
                 $('#cnpjDest').html('<input type="text" class="form-control" id="id_cnpj_dest" value="">');
            }
        });

        $(document).on('change', '#cod_cliente_pedido', function(){
            if( $(this).val() ) {
                $('#ieDest').hide();
                $.getJSON('data/movimento/consulta_cliente.php?search=',{cod_cliente_pedido: $(this).val(),ajax: 'true'}, function(j){
                    for (var i = 0; i < j.length; i++) {
                    	var options = '<input type="text" class="form-control" id="id_ie_dest" value="' + j[i].ds_ie_rg + '">';
                    }   
                    $('#ieDest').html(options).show();
                 });
            } else {
                 $('#ieDest').html('<input type="text" class="form-control" id="id_ie_dest" value="">');
            }
        });
		/*- Fim Pedidos -*/

		/*- Coletas -*/

		$(document).on('click', '#btnFormListColeta', function(){
			$('#formListColeta').ajaxForm({
				target:'#infoColeta',
				url:'data/movimento/list_coleta.php',
				beforeSend:function(e){
					$("#infoColeta").html("<img src='css/loading9.gif'>");
				}
			});
		});

		/*- Fim Coletas -*/


		/*- Torres -*/

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
               	return false;
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
	        $('#tabela').load('data/torre/modal/m_ins_conjunto.php');
	        return false;
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
	                success:function(data)
	            	{
	                   	$('#tabela').html(data);
	                 }
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
		                        options += '<option value="' + j[i].id + '">' + j[i].parte + '</option>';
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
	                   	$('#tabela').html(data);
	                 }
                });
               	return false;
            });

        $(document).on('click', '#btnFormCadPeca', function(){
            event.preventDefault();
            var id_torre = $('#id_torre').val();
            var id_parte = $('#id_parte').val();
            var ds_descricao = $('#ds_descricao').val();
            var nr_comprimento = $('#nr_comprimento').val();
            var nr_peso_unit = $('#nr_peso_unit').val();
            var nr_posicao = $('#nr_posicao').val();
            var nr_qtde = $('#nr_qtde').val();
            var cod_cliente = $('#cod_cliente').val();
            var nr_identificacao = $('#nr_identificacao').val();
	            $.ajax({
	                url:"data/torre/ins_item_torre.php",
	                method:"POST",
	                data:{id_parte:id_parte, id_torre:id_torre, ds_descricao:ds_descricao, nr_comprimento:nr_comprimento, nr_peso_unit:nr_peso_unit, nr_posicao:nr_posicao, nr_qtde:nr_qtde, cod_cliente:cod_cliente, nr_identificacao:nr_identificacao},
	                success:function(data)
	            	{
	            		$('#tabela').load('data/torre/consulta_torre_sql.php');
	            		$('#formCadPeca').trigger("reset");
	                   	$('#Novoitem').modal('show');	                   	
	                 }
                });
               	return false;
            });

        $(document).on('change', '#id_torre_ex', function(){
		    event.preventDefault();
		    if( $(this).val() ) {
		        $('#id_parte_ex').hide();
		        $('.carregando').show();
		        $.getJSON('data/torre/consulta_parte.php?search=',{id_torre: $(this).val(), ajax: 'true'}, function(j){
		            var options = '<option value="">Escolha a parte da Torre</option>'; 
		            for (var i = 0; i < j.length; i++) {
		                 options += '<option value="' + j[i].id + '">' + j[i].parte + '</option>';
		            }   
		           	$('#id_parte_ex').html(options).show();
		            $('.carregando').hide();
		        });
		    } else {
		        $('#id_parte_ex').html('<option value="">Escolha parte da Torre</option>');
		    }
		});

        $(document).on('change', '#id_parte_ex', function(){
		    event.preventDefault();
		    if( $(this).val() ) {
		        $('#id_item_ex').hide();
		        $('.carregando').show();
		        $.getJSON('data/torre/consulta_conjunto.php?search=',{id_parte: $(this).val(), ajax: 'true'}, function(j){
		            var options = '<option value="">Escolha a peça</option>'; 
		            for (var i = 0; i < j.length; i++) {
		                 options += '<option value="' + j[i].cod_produto + '">' + j[i].nr_posicao +'|'+ j[i].nm_produto + '</option>';
		            }   
		           	$('#id_item_ex').html(options).show();
		            $('.carregando').hide();
		        });
		    } else {
		        $('#id_item_ex').html('<option value="">Escolha a peça</option>');
		    }
		});

		$(document).on('click', '#btnInsPedido', function(){
            event.preventDefault();
            var id_torre_ex = $('#id_torre_ex').val();
            var id_parte_ex = $('#id_parte_ex').val();
            var id_item_ex = $('#id_item_ex').val();
            var nr_qtde = $('#nr_qtde').val();
            if(nr_qtde == ''){

            	alert('Digite a quantidade!');

            } else {

            	$.ajax({
		            url:"data/torre/gera_pedido.php",
		            method:"POST",
		            data:{id_parte_ex:id_parte_ex, id_torre_ex:id_torre_ex, id_item_ex:id_item_ex, nr_qtde:nr_qtde},
		            success:function(data)
		            {
		                $('#tabela').html(data);
		            }
	            });
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

		/*- Fim Torres -*/
	});

/*- Inventário -*/
	$(document).ready(function() {
	    
		$(document).on('click', '#btnformStartContTar', function(){
	        var id_tar = $(this).val();
	        $.ajax({
	            url:"data/inventario/inv_conf.php",
	            method:"POST",
	            data:{id_tar:id_tar},
	            success:function(data)
	            {
	                $('#infoTarefas').html(data);
	                $('#conf_cadastro').modal('show');
	            }
	        });
	    });

		$(document).on('click', '#btnFinTarefa', function(){
	        var id_tar = $(this).val();
	        $.ajax({
	            url:"data/inventario/valida_conf_cego.php",
	            method:"POST",
	            data:{id_tar:id_tar},
	            success:function(data)
	            {
	                console.log(data);
	                //$('#conf_cadastro').modal('show');
	            }
	         });
	     });

	    function tarefas(tarefas)
	    {
	        var page = "data/inventario/gera_tarefa.php";
	        $.ajax
	        ({
	            type: 'POST',
	            dataType: 'html',
	            url: page,
	            beforeSend: function () {
	                $("#info").html("Carregando...");
	            },
	            data: {id_galpao: id_galpao, nr_inv: nr_inv,id_produto: id_produto,id_rua_inicio: id_rua_inicio,id_rua_fim: id_rua_fim},
	            success: function (msg)
	            {
	                $("#info").html(msg);
	            }
	        });
	    }

	    $('#btnGerar').click(function () {
	        tarefas($("#id_galpao").val(),$("#nr_inv").val(),$("#id_produto").val(),$("#id_rua_inicio").val(),$("#id_rua_fim").val())
	    });
	});

	$(function(){
        
            $(document).on('change', '#id_inv', function(){
                if( $(this).val() ) {
                    $('#inv_rua').hide();
                    //$('.carregando').show();
                    $.getJSON('data/inventario/consulta_rua_inv.php?search=',{id_inv: $(this).val(), id_galpao_inv: $('#id_galpao_inv').val(), ajax: 'true'}, function(j){
                        var options = '<option value="">Escolha a rua</option>'; 
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
                        }   
                        $('#inv_rua').html(options).show();
                        //$('.carregando').hide();
                    });
                } else {
                    $('#inv_rua').html('<option value="">Escolha a rua</option>');
                }
            });

            $(document).on('change', '#inv_rua', function(){
                if( $(this).val() ) {
                    $('#inv_mod').hide();
                    //$('.carregando').show();
                    $.getJSON('data/inventario/consulta_coluna_inv.php?search=',{id_rua: $(this).val(), id_galpao_inv: $('#id_galpao_inv').val(), ajax: 'true'}, function(j){
                        var options = '<option value="">Escolha a coluna</option>'; 
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
                        }   
                        $('#inv_mod').html(options).show();
                        //$('.carregando').hide();
                    });
                } else {
                    $('#inv_mod').html('<option value="">Escolha a coluna</option>');
                }
            });

            $(document).on('change', '#inv_mod', function(){
                if( $(this).val() ) {
                    $('#inv_alt').hide();
                    //$('.carregando').show();
                    $.getJSON('data/inventario/consulta_altura.php?search=',{id_coluna: $(this).val(), id_galpao_inv: $('#id_galpao_inv').val(), ajax: 'true'}, function(j){
                        var options = '<option value="">Escolha a altura</option>'; 
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].altura + '">'  + j[i].altura + '</option>';
                        }   
                        $('#inv_alt').html(options).show();
                        //$('.carregando').hide();
                    });
                } else {
                    $('#inv_alt').html('<option value="">Escolha a altura</option>');
                }
            });
        });

	$(function(){
        
        $(document).on('change', '#id_torre', function(){
            if( $(this).val() ) {
                $('#id_pos').hide();
                $.getJSON('data/inventario/consulta_pos_inv.php?search=',{id_torre: $(this).val(), ajax: 'true'}, function(j){
                    var options = '<option value="">Escolha a posição</option>'; 
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].id + '">' + j[i].nr_posicao + '</option>';
                    }   
                    $('#id_pos').html(options).show();
                 });
            } else {
                 $('#id_pos').html('<option value="">Escolha a posição</option>');
            }
        });

        $(document).on('change', '#id_pos', function(){
            if( $(this).val() ) {
                $('#tarProduto').hide();
                $.getJSON('data/inventario/consulta_inv_produto.php?search=',{id_pos: $(this).val(), id_torre: $('#id_torre').val(),ajax: 'true'}, function(j){
                    for (var i = 0; i < j.length; i++) {
                    	var options = '<input type="text" class="form-control" id="nm_produto" name="" value="' + j[i].nm_produto + '" readonly="true">';
                    	options += '<input type="hidden" class="form-control" id="id_produto" name="id_produto" value="' + j[i].cod_produto + '">';
                    }   
                    $('#tarProduto').html(options).show();
                 });
            } else {
                 $('#tarProduto').html('<input type="text" class="form-control" id="id_produto" name="id_produto" value="" readonly="true">');
            }
        });
    });

    $(document).on('click', '#btnFormCadTar', function(){
		$('#formCadTar').ajaxForm({
		    target:'#infoTarefas',
		    url:'data/inventario/ins_tar_inv.php',
		    beforeSend:function(e){
		        $("#infoTarefas").html("<img src='css/loading9.gif'>");
		    }
		});
	});

/*- fim Inventário -*/
</script>