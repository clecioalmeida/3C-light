<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$fl_nivel = $_SESSION["fl_nivel"];
}
?>
<script type="text/javascript">
	/*- Chamadas de menu -*/
	$(document).ready(function(){
		var nivel = "<?php echo $fl_nivel; ?>";
		/*--- DASHBOARD ---*/

		$('#cadEnd').click(function(e){
			event.preventDefault();
			$('#conteudo').load('endereco.php');			
		});

		/*--- ACESSOS COORDENAÇÃO ---*/

		$('#dashEstoque').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#dashEstoque').prop("disabled", true);
				alert("Você não tem acesso a esse menu.");
			}else{
				$('#conteudo').load('dash_estoque.php');
			}
		});

		$('#dashOcupa').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#dashOcupa').prop("disabled", true);
				alert("Você não tem acesso a esse menu.");
			}else{
				$('#conteudo').load('dash_ocupa_estoque_new.php');
			}
		});

		$('#insVlrEst').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#insVlrEst').prop("disabled", true);
				alert("Você não tem acesso a esse menu.");
			}else{
				$('#conteudo').load('importa_valor.php');
			}
		});

		$('#insTpPrd').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#insTpPrd').prop("disabled", true);
				alert("Você não tem acesso a esse menu.");
			}else{
				$('#conteudo').load('importa_tipo_produto.php');
			}
		});

		/*$('#recImpFor').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#recImpFor').prop("disabled", true);
				alert("Você não tem acesso a esse menu.");
			}else{
				$('#conteudo').load('importa_grupo.php');
			}
		});*/

		/*--- fim DASHBOARD ---*/

		/*--- EMPRESA ---*/

		$('#empresa').click(function(e){
			event.preventDefault();
			if(nivel >= '3'){

				$('#conteudo').load('empresa.php');

			}else{

				alert("Você não tem acesso a esse módulo.");

			}
		});

		$('#cadUsuarios').click(function(e){
			event.preventDefault();
			if(nivel <= '4'){
				$('#cadUsuarios').prop("disabled", true);
				alert("Você não tem acesso a esse menu.");
			}else{
				$('#conteudo').load('usuarios.php');
			}
		});

		$('#cadUsuariosExt').click(function(e){
			event.preventDefault();
			$('#conteudo').load('usuarios_ext.php');
			$('#tabCadUserExt').load('data/empresa/list_usuario_ext.php');
		});

		$('#btnLoadProfile').click(function(e){
			event.preventDefault();
			$('#conteudo').load('data/empresa/profile.php');
		});

		$('#cadCargos').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#cadCargos').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('cargos.php');
			}
		});

		$('#CadNfs').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#CadNfs').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('nf_saida.php');
			}
		});

		$('#cadDeptos').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#cadDeptos').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('depto.php');
			}
		});

		/*--- Fim EMPRESA ---*/

		/*--- ENTIDADES ---*/

		$('#cadCliente').click(function(e){
			event.preventDefault();
			if(nivel < '3'){
				$('#cadCliente').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('cliente.php');
			}
		});

		$('#cadDestinatario').click(function(e){
			event.preventDefault();
			if(nivel < '2'){
				$('#cadDestinatario').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('destinatario.php');
			}
		});

		$('#cadFornecedor').click(function(e){
			event.preventDefault();
			if(nivel < '2'){
				$('#cadFornecedor').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('fornecedor.php');
			}
		});

		$('#cadInvImp').click(function(e){
			event.preventDefault();
			if(nivel < '2'){
				$('#cadInvImp').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('importa_inv_sistema.php');
			}
		});

		$('#estPedCol').click(function(e){
			event.preventDefault();
			if(nivel < '2'){
				$('#estPedCol').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('estorna_coleta.php');
				$('#estPedCol').prop("disabled", false);
			}
		});

		/*--- Fim ENTIDADES ---*/

		/*--- Armazém ---*/

		$('#cadGalpao').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#cadGalpao').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('galpao.php');
			}
		});

		$('#cadLocal').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#cadLocal').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('local.php');
			}
		});

		$('#cadDoca').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#cadDoca').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('doca.php');
			}
		});

		$('#listEtq').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#listEtq').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('etiq_arm.php');
			}
		});

		$('#ConsEstoque').click(function(e){
			event.preventDefault();
			$('#conteudo').load('consulta_estoque.php');
		});

		/*--- Fim Armazém ---*/

		/*--- Produtos ---*/

		$('#cadProduto').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#cadProduto').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('produto_new.php');
			}
		});

		$('#cadKit').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#cadKit').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('produto_kit.php');
			}
		});

		$('#cadComp').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#cadComp').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('componente.php');
			}
		});

		$('#ConsNs').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#ConsNs').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('n_serie.php');
			}
		});

		$('#CadAval').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#CadAval').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('aval.php');
			}
		});

		$('#CadGrupo').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#CadGrupo').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('grupo.php');
			}
		});

		$('#CadSgrupo').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#CadSgrupo').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('sgrupo.php');
			}
		});

		/*--- Fim Produtos ---*/

		/*--- Recebimento ---*/

		$('#RecPend').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#RecPend').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('recebimento.php');
			}
		});

		$('#linkRec').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#linkRec').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('recebimento.php');
			}
		});

		$('#RecFin').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#RecFin').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('recebimento_fin.php');
			}
		});


		/*--- Fim Recebimento ---*/

		/*--- Movimento ---*/

		$('#cadAloc').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#cadAloc').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('alocacao_new.php');
			}
		});

		$('#linkAloca').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#linkAloca').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('alocacao_new.php');
			}
		});

		$('#cadTransf').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#cadTransf').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('movimenta.php');
			}
		});

		$('#cadTransfFeixe').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#cadTransfFeixe').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('movimenta_feixe.php');
			}
		});

		$('#linkTransf').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#linkTransf').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('movimenta.php');
			}
		});

		$('#cadNc').click(function(e){
			event.preventDefault();
			if(nivel <= '4'){
				$('#cadNc').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('produto_nc.php');
			}
		});

		/*--- Fim Movimento ---*/
		/*--- Movimento - Pedidos ---*/

		$('#cadPed').click(function(e){
			event.preventDefault();
			$('#conteudo').load('controle_pedido.php');
		});

		$('#linkPed').click(function(e){
			event.preventDefault();
			$('#conteudo').load('controle_pedido.php');
		});

		$('#NovoPed').on('click',function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#NovoPed').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('novo_pedido.php');
			}
		});

		$('#btnInsNovoPed').on('click', function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#btnInsNovoPed').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('novo_pedido_sql.php');
			}
		});

		/*--- Fim Pedidos ---*/

		/*--- Coletas ---*/

		$('#ConsCol').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#ConsCol').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('coleta.php');
			}
		});

		$('#linkCol').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#linkCol').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('coleta.php');
			}
		});

		/*--- Fim Coletas ---*/

		/*--- Expedição ---*/

		$('#CadExped').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#CadExped').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('expede.php');
			}
		});

		$('#linkExp').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#linkExp').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('expede.php');
			}
		});

		$('#gerOnda').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#gerOnda').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('onda.php');
			}
		});

		$('#consOnda').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#consOnda').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('consulta_onda.php');
			}
		});

		/*--- Fim Expedição ---*/

		/*--- Expedição ---*/

		$('#ConsMin').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#ConsMin').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('minuta.php');
			}
		});

		/*--- Torres ---*/

		$('#CadTorreTipo').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#CadTorreTipo').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('cadastro_torre_tipo.php');
			}
		});

		$('#linkCadTor').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#linkCadTor').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('cadastro_torre_tipo.php');
			}
		});

		$('#CadTorreParte').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#CadTorreParte').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('cadastro_torre_parte.php');
			}
		});

		$('#linkCadPart').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#linkCadPart').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('cadastro_torre_parte.php');
			}
		});

		$('#CadTorreItem').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#CadTorreItem').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('cadastro_torre_item.php');
			}
		});

		$('#linkCadPeca').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#linkCadPeca').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('cadastro_torre_item.php');
			}
		});

		$('#CadExpTorre').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#CadExpTorre').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('exp_torre.php');
			}
		});

		$('#CadExpFeixe').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#CadExpFeixe').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('exp_feixe.php');
			}
		});

		$('#PedTorrePen').click(function(e){
			event.preventDefault();
			$('#conteudo').load('pedido_pendente_torre.php');
		});

		$('#linkTorPed').click(function(e){
			event.preventDefault();
			if(nivel <= '2'){
				$('#linkTorPed').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('pedido_pendente_torre.php');
			}
		});

		$('#linkConsAnalit').click(function(e){
			event.preventDefault();
			$('#conteudo').load('consulta_torre.php');
		});

		$('#ConsTorComp').click(function(e){
			event.preventDefault();
			$('#conteudo').load('consulta_torre.php');
		});

		$('#ConsTorDtl').click(function(e){
			event.preventDefault();
			$('#conteudo').load('consulta_torre_detalhe.php');
		});

		$('#ConsTorPos').click(function(e){
			event.preventDefault();
			$('#conteudo').load('consulta_posicao.php');
		});

		$('#RepTorSaldo').click(function(e){
			event.preventDefault();
			$('#conteudo').load('rel_saldo_torre.php');
		});

		$('#RepTorSaldoDtl').click(function(e){
			event.preventDefault();
			$('#conteudo').load('rel_saldo_torre_dtl.php');
		});

		$('#RepTorSldEstoque').click(function(e){
			event.preventDefault();
			$('#conteudo').load('consulta_torre_dtl.php');
		});

		/*--- Fim Torres ---*/

		/*---Inventário ---*/

		$('#cadParam').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#cadParam').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('inv_param.php');
			}
		});

		$('#ConsProg').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#ConsProg').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('inv_prog.php');
			}
		});

		$('#ConsTar').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#ConsTar').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('inv_tarefa.php');
			}
		});

		$('#PrintTar').click(function(e){
			event.preventDefault();
			if(nivel <= '3'){
				$('#PrintTar').prop("disabled", true);
				alert('Você não tem acesso a esse menu!');
			}else{
				$('#conteudo').load('print_tarefa.php');
			}
		});

		$('#HistInv').click(function(e){
			event.preventDefault();
			$('#conteudo').load('hist_inv.php');
		});

		$('#linkHistInv').click(function(e){
			event.preventDefault();
			$('#conteudo').load('hist_inv.php');
		});

		/*--- Fim Inventário ---*/

		/*--- Qualidade ---*/

		$(document).ready(function(){
			var nivel = "<?php echo $fl_nivel; ?>";
			$('#GesQld').click(function(e){
				event.preventDefault();
				if(nivel <= '3'){
					$('#GesQld').prop("disabled", true);
					alert('Você não tem acesso a esse menu!');
				}else{
					$('#conteudo').load('ocorrencias_new.php');
				}
			});
		});

		/*--- Fim Qualidade ---*/

		/*---Relatórios ---*/

		$('#RepMovEstoque').click(function(e){
			event.preventDefault();
			$('#conteudo').load('rep_estoque.php');
		});

		$('#RepSalEstoque').click(function(e){
			event.preventDefault();
			$('#conteudo').load('sal_estoque.php');
		});

		$('#linkConsSaldo').click(function(e){
			event.preventDefault();
			$('#conteudo').load('sal_estoque.php');
		});

		$('#consEstoqueProd').click(function(e){
			event.preventDefault();
			$('#conteudo').load('cons_estoque.php');
			//$('#conteudo').load('cons_estoque_prod.php');
		});

		$('#linkConsEstoq').click(function(e){
			event.preventDefault();
			$('#conteudo').load('estoque.php');
		});

		$('#consProdNc').click(function(e){
			event.preventDefault();
			$('#conteudo').load('cons_prod_nc.php');
		});

		$('#consHisProd').click(function(e){
			event.preventDefault();
			$('#conteudo').load('cons_hist_prod.php');
		});

		$('#linkHistProd').click(function(e){
			event.preventDefault();
			$('#conteudo').load('cons_hist_prod.php');
		});

		$('#RepGiroEstoque').click(function(e){
			event.preventDefault();
			$('#conteudo').load('giro_estoque.php');
		});

		$('#linkConsInd').click(function(e){
			event.preventDefault();
			$('#conteudo').load('dashboard.php');
		});

		$('#linkPrd').click(function(e){
			event.preventDefault();
			$('#conteudo').load('produto_new.php');
		});

		/*--- Contratos ---*/

		$('#cadContrato').click(function(e){
			event.preventDefault();
			$('#conteudo').load('contrato.php');
		});

		/*--- Manuseio ---*/

		$('#cadManuseio').click(function(e){
			event.preventDefault();
			$('#conteudo').load('manuseio.php');
		});
		/*--- Manuseio ---*/

		$('#CadEmbalagem').click(function(e){
			event.preventDefault();
			$('#conteudo').load('embalagem.php');
		});
		/*--- Fechamento ---*/

		$('#apSaldoMensal').click(function(e){
			event.preventDefault();
			$('#conteudo').load('fechamento.php');
		});

		/*- Chamadas de modal -*/

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
			$.ajax
			({
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
			$.ajax
			({
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
			$.ajax
			({
				url:"data/empresa/modal/m_upd_task.php",
				method:"POST",
				data:{id_task:id_task},
				success:function(data){
					$('#retorno_task').html(data);
				}
			});
		});

		$(document).on('click', '#btnFormUpdTask', function(){
			$('#formUpdTask').ajaxForm({
				url:'data/empresa/upd_task.php',
				success:function(data){
					$('#upd_task').modal('hide');
					$('#retorno_task').html(data);
				}
			});
		});

		/*-- Usuários --*/

		$(document).on('click', '#btnNewUser', function(){
			var ins_usuario = $(this).val();
			$.ajax
			({
				url:"data/empresa/modal/ins_usuario.php",
				method:"POST",
				data:{ins_usuario:ins_usuario},
				success:function(data)
				{
					$('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnNewUserExt', function(){
			$('#retorno').load("data/empresa/modal/m_ins_usuario_ext.php");
		});
		
		$(document).on('click', '#btnListUserExt', function(){
			$('#tabCadUserExt').load("data/empresa/list_usuario_ext.php");
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
			$.ajax
			({
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
			$.ajax
			({
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
			$.ajax
			({
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
			$.ajax
			({
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
			$.ajax
			({
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
			$.ajax
			({
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
			$.ajax
			({
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
			$.ajax
			({
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
			$.ajax
			({
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
			$.ajax
			({
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
			$.ajax
			({
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
					$('#retornoConf').html(data);
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

		$(document).on('click', '#btnNovoProduto', function(){
			$('#btnNovoProduto').prop("disabled", true);
			event.preventDefault();
			var ins_produto = $(this).val();
			$.ajax
			({
				url:"data/produto/modal/m_ins_produto.php",
				method:"POST",
				data:{ins_produto:ins_produto},
				success:function(data)
				{
					$('#retModalPrd').html(data);
					$('#btnNovoProduto').prop("disabled", false);
				}
			});
			return false;
		});

		$(document).on('click', '#btnFormNovoProduto', function(){
			event.preventDefault();
			$.post("data/produto/ins_produto.php", $("#formNovoProduto").serialize(), function(data) {
				alert(data);
			});
			return false;
		});

		$(document).on('click', '#btnUpdProduto', function(){
			var upd_produto = $(this).val();
			$.ajax({
				url:"data/produto/modal/m_upd_produto.php",
				method:"POST",
				data:{upd_produto:upd_produto},
				success:function(data)
				{
					$('#retModalPrd').html(data);
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
					$('#retModalPrd').html(data);
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
				data:{
					cod_estoque:cod_estoque,
					quantidade:quantidade,
					id_kit:id_kit
				},
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
				data:{
					cod_estoque:cod_estoque,
					cod_estoque_sbst:cod_estoque_sbst,
					id_kit:id_kit
				},
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
				data:{
					cod_produto:cod_produto,
					nr_qtde_comp:nr_qtde_comp,
					prod_comp:prod_comp
				},
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
			$.ajax
			({
				url:"ins_recebimento.php",
				method:"POST",
				data:{ins_rec:ins_rec},
				success:function(data)
				{
					$('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnNovaNfe', function(){
			var ins_rec = $(this).val();
			$.ajax
			({
				url:"ins_recebimento_nf.php",
				method:"POST",
				data:{ins_rec:ins_rec},
				success:function(data)
				{
					$('#retornoNfe').html(data);
				}
			});
		});

		$(document).on('click', '#btnDtlRec', function(){
			var dtl_rec = $(this).val();
			$.ajax
			({
				url:"dtl_recebimento.php",
				method:"POST",
				data:{dtl_rec:dtl_rec},
				success:function(data)
				{
					$('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnUpdRecConf', function(){
			var upd_rec = $(this).val();
			$.ajax
			({
				url:"dtl_recebimento.php",
				method:"POST",
				data:{upd_rec:upd_rec},
				success:function(data)
				{
					$('#retornoConf').html(data);
				}
			});
		});

		$(document).on('change', '#nm_user_recebido_por', function(){
			$('#nm_user_autorizado_por').hide();
			$.getJSON('data/recebimento/consulta_conferente.php', {ajax: 'true'}, function(j){
				var options = '<option value="">Escolha o conferente</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].cod_cliente + '">' + j[i].nm_cliente + '</option>';
				}
				$('#nm_user_autorizado_por').html(options).append();
			});
		});

		$(document).on('click', '#btnUpdRec', function(){
			var upd_rec = $(this).val();
			$.ajax
			({
				url:"edit_recebimento.php",
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
				target:'#retornoOr',
				url:'data/recebimento/upd_rec.php',
				beforeSend:function(e){
					$("#retornoOr").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$(document).on('click','#btnUpdRecebimento',function(){
			var ins_rec = $(this).val();
			if($('#nr_fisc_ent').val() == '' || $('#dt_emis_ent').val() == '' || $('#nr_cfop_ent').val() == '' || $('#tp_vol_ent').val() == '' || $('#qtd_vol_ent').val() == '' || $('#nr_peso_ent').val() == '' || $('#id_rem').val() == '' || $('#id_dest').val() == '' || $('#vl_tot_nf_ent').val() == '' || $('#vl_tot_nf_ent').val() == '' || $('#base_icms_ent').val() == '' || $('#vl_icms_ent').val() == ''){

				alert("Todos os campos são obrigatórios.");

			}else{

				$.post("data/recebimento/upd_rec.php", $("#formUpdRec").serialize(), function(data) {
					alert(data);
					$('#retorno').load('data/recebimento/list_recebimento.php');
				});

			}
		});

		$(document).on('click', '#btnNfRec', function(){
			var nf_rec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_nf_recebimento.php",
				method:"POST",
				data:{nf_rec:nf_rec},
				success:function(data)
				{
					$('#retornoOr').html(data);
				}
			});
		});

		$(document).on('click','#btnInsNfRec',function(){
			var ins_rec = $(this).val();
			if($('#nr_fisc_ent').val() == '' || $('#dt_emis_ent').val() == ''){

				alert("Campo número da nota e data de emissão são obrigatórios.");

			}else{

				$.post("data/recebimento/ins_nf_recebimento.php", $("#formNovoNfRec").serialize(), function(data) {
					alert(data);
					$('#retornoNfe').load("ins_recebimento_nf.php?search=",{ins_rec:ins_rec});
				});

			}
		});

		/*$(document).on('click', '#btnInsNfRec', function(){
			event.preventDefault();
			$('#btnInsNfRec').prop("disabled", true);
			if(confirm("Confirma a inclusão da nota fiscal?")){
				var cod_rec 				= $('#cod_rec').val();
				var nr_fisc_ent 						= $('#nr_fisc_ent').val();
				var dt_emis_ent 			= $('#dt_emis_ent').val();
				var nr_cfop_ent 	= $('#nr_cfop_ent').val();
				var nr_volume_previsto 			= $('#nr_volume_previsto').val();
				var nm_transportadora 			= $('#nm_transportadora').val();
				var nm_motorista 				= $('#nm_motorista').val();
				var nm_placa 					= $('#nm_placa').val();
				var dt_recebimento_real 		= $('#dt_recebimento_real').val();
				var ds_obs 						= $('#obs').val();
				var nr_insumo 					= $('#nr_insumo').val();
				$.ajax
				({
					url:"data/recebimento/ins_recebimento.php",
					method:"POST",
					dataType:'json',
					data:{
						nm_fornecedor 				:nm_fornecedor,
						tp_rec 						:tp_rec,
						nr_peso_previsto 			:nr_peso_previsto,
						dt_recebimento_previsto 	:dt_recebimento_previsto,
						nr_volume_previsto 			:nr_volume_previsto,
						nm_transportadora 			:nm_transportadora,
						nm_motorista 				:nm_motorista,
						nm_placa 					:nm_placa,
						dt_recebimento_real 		:dt_recebimento_real,
						ds_obs 						:ds_obs,
						nr_insumo 					:nr_insumo
					},
					success:function(j)
					{
						for (var i = 0; i < j.length; i++) {
							if(j[i].info == 0){
								alert("OR cadastrada com sucesso!");
								$('#cad_nfe').show();
								$('#btnNovaNfe').val(j[i].id_rec);
							}else{
								alert("Erro no cadastro!");
							}
						}
					}
				});
			$('#btnInsNfRec').prop("disabled", false);
			}
		});*/

		/*$(document).on('click', '#btnFormNovoNfRec', function(){
			event.preventDefault();
			$('#btnFormNovoNfRec').prop("disabled", true);
			if(confirm("Tem certeza que deseja inserir a nota fiscal?")){
				if($('#nr_fisc_ent').val() == '' || $('#dt_emis_ent').val() == '' || $('#dt_emis_ent').val() == '' || $('#nr_cfop_ent').val() == '' || $('#tp_vol_ent').val() == '' || $('#qtd_vol_ent').val() == '' || $('#nr_peso_ent').val() == '' || $('#id_rem').val() == '' || $('#id_dest').val() == '' || $('#vl_tot_nf_ent').val() == '' || $('#vl_tot_nf_ent').val() == '' || $('#base_icms_ent').val() == '' || $('#vl_icms_ent').val() == ''){

					alert("Todos os campos são obrigatórios.");

				}else{

					var nr_fisc_ent = $('#nr_fisc_ent').val();
					var cod_rec = $('#cod_rec').val();

					$.ajax
					({
						type: 'POST',
						dataType: 'json',
						url: 'data/recebimento/consulta_nf_rec.php',
						data: {
							nr_fisc_ent:nr_fisc_ent,
							cod_rec:cod_rec
						},
						success: function (j)
						{
							for (var i = 0; i < j.length; i++) {
								var info = j[i].info;
								if(info == 1){

									alert("Essa nota fiscal já existe nessa OR!");

								}else{

									$.getJSON('data/recebimento/ins_nf_recebimento.php?search=',{
										cod_rec: $('#cod_rec').val(),
										nr_fisc_ent: $('#nr_fisc_ent').val(),
										dt_emis_ent: $('#dt_emis_ent').val(),
										nr_cfop_ent: $('#nr_cfop_ent').val(),
										tp_vol_ent: $('#tp_vol_ent').val(),
										qtd_vol_ent: $('#qtd_vol_ent').val(),
										nr_peso_ent: $('#nr_peso_ent').val(),
										id_rem: $('#id_rem').val(),
										id_dest: $('#id_dest').val(),
										vl_tot_nf_ent: $('#vl_tot_nf_ent').val(),
										base_icms_ent: $('#base_icms_ent').val(),
										vl_icms_ent: $('#vl_icms_ent').val(),
										chavenfe: $('#chavenfe').val(),
										ds_obs_nf: $('#ds_obs_nf').val(),
										fl_status: $('#fl_status').val(),
										ajax: 'true'}, function(j){
											for (var i = 0; i < j.length; i++) {
												var options = '<tr>\
												<td style="text-align: center; width: 5px"><button type="submit" id="btnDtlNfrec" class="btn btn-primary btn-xs" value="'+ j[i].cod_nf_entrada +'">Detalhe</button></td>\
												<td style="text-align: center; width: 5px"><button type="submit" id="btnUpdNfrec" class="btn btn-primary btn-xs" value="'+ j[i].cod_nf_entrada +'">Alterar</button></td>\
												<td style="text-align: center; width: 5px"><button type="submit" id="btnDelNfrec" class="btn btn-primary btn-xs" value="'+ j[i].cod_nf_entrada +'">Excluir</button></td>\
												<td style="text-align: center; width: 5px"><button type="submit" id="btnProdNfrec" class="btn btn-primary btn-xs" value="'+ j[i].cod_nf_entrada +'">Produtos</button></td>\
												<td>' + j[i].nr_fisc_ent + '</td>\
												<td>' + j[i].nm_fornecedor + '</td>\
												<td>' + j[i].nr_peso_ent + '</td>\
												<td style="text-align: right;">' + j[i].qtd_vol_ent + '</td>\
												<td style="text-align: right;">' + j[i].tp_vol_ent + '</td>\
												<td style="text-align: right;">' + j[i].vl_tot_nf_ent + '</td>\
												</tr>';
											}
											$('#retNfRec').append(options);
											$('#formNovoNfRec')[0].reset();
										});
								}
							}
						}
					});
				}
			}
			$('#btnFormNovoNfRec').prop("disabled", false);
		});*/

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

		$(document).on('click', '#btnDtlNfRec', function(){
			event.preventDefault();
			var dtl_nfrec = $(this).val();
			$.ajax
			({
				url:"data/recebimento/dtl_nf_recebimento.php",
				method:"POST",
				data:{dtl_nfrec:dtl_nfrec},
				success:function(data)
				{
					$('#retornoNfe').html(data);
				}
			});
		});

		$(document).on('click', '#btnUpdNfRec', function(){
			event.preventDefault();
			var upd_nfrec = $(this).val();
			$.ajax
			({
				url:"data/recebimento/upd_nf_recebimento.php",
				method:"POST",
				data:{upd_nfrec:upd_nfrec},
				success:function(data)
				{
					$('#retornoNfe').html(data);
				}
			});
		});

		$(document).on('click', '#btnFormUpdNfRecebimento', function(){
			event.preventDefault();
			var id_nf 			= $(this).val();
			var nr_fisc_ent 	= $('#nr_fisc_ent').val();
			var dt_emis_ent 	= $('#dt_emis_ent').val();
			var nr_cfop_ent 	= $('#nr_cfop_ent').val();
			var qtd_vol_ent 	= $('#qtd_vol_ent').val();
			var nr_peso_ent 	= $('#nr_peso_ent').val();
			var tp_vol_ent 		= $('#tp_vol_ent').val();
			var vl_tot_nf_ent 	= $('#vl_tot_nf_ent').val();
			var base_icms_ent 	= $('#base_icms_ent').val();
			var vl_icms_ent 	= $('#vl_icms_ent').val();
			var chavenfe 		= $('#chavenfe').val();
			var ds_obs_nf 		= $('#ds_obs_nf').text();
			$.ajax
			({
				type: 'POST',
				dataType: 'json',
				url: 'data/recebimento/upd_nf_rec.php',
				data: {
					id_nf 			:id_nf,
					nr_fisc_ent 	:nr_fisc_ent,
					dt_emis_ent 	:dt_emis_ent,
					nr_cfop_ent 	:nr_cfop_ent,
					qtd_vol_ent 	:qtd_vol_ent,
					nr_peso_ent 	:nr_peso_ent,
					tp_vol_ent 		:tp_vol_ent,
					vl_tot_nf_ent 	:vl_tot_nf_ent,
					base_icms_ent 	:base_icms_ent,
					vl_icms_ent 	:vl_icms_ent,
					chavenfe 		:chavenfe,
					ds_obs_nf 		:ds_obs_nf
				},
				success: function (j)
				{
					for (var i = 0; i < j.length; i++) {
						if(j[i].info == "0"){

							alert("Registro alterado com sucesso!");

						}else if(j[i].info == "1"){

							alert("Erro no registro!");

						}else if(j[i].info == "2"){

							alert("Os campos não podem estar vazios!");

						}
					}
				}
			});
		});
/*
		$(document).on('click', '#btnDelPrdNfrec', function(){
			var del_nfrec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_del_prd_nf_recebimento.php",
				method:"POST",
				data:{del_nfrec:del_nfrec},
				success:function(data)
				{
				    $('#retornoOr').html(data);
				}
			});
		});
		*/
		$(document).on('click', '#btnFormDelNfRecebimento', function(){
			event.preventDefault();
			var item_nf = $(this).val();
			var nf_rec = $(this).attr("data-or");
			$.ajax
			({
				type: 'POST',
				dataType: 'json',
				url: 'data/recebimento/del_item_nf_rec.php',
				beforeSend: function () {
					$("#info").html("Carregando...");
				},
				data: {
					item_nf:item_nf
				},
				success: function (j)
				{
					for (var i = 0; i < j.length; i++) {
						var info = j[i].info;						
						$('#askDelItemNfItem').hide();						
						$('#retDelItemNFOR').html(info);
						$('#retornoNfe').load('data/recebimento/list_rec_nfe.php?search=',{nf_rec:nf_rec});
					}
				}
			});
		});

		$(document).on('click', '#btnFormConfDelNfRec', function(){
			var item_nf = $(this).val();
			$.ajax
			({
				type: 'POST',
				dataType: 'json',
				url: 'data/recebimento/del_nf_prd_rec.php',
				beforeSend: function () {
					$("#info").html("Carregando...");
				},
				data: {
					id_nf:id_nf
				},
				success: function (j)
				{
					for (var i = 0; i < j.length; i++) {
						var info = j[i].info;
						$('#askDelNfItem').hide();
						$('#retDelNFOR').append(info);
					}
				}
			});
		});

		$(document).on('click', '#btnProdRec', function(){
			event.preventDefault();
			var prod_nfrec = $(this).val();
			$.ajax({
				url:"data/recebimento/ins_prod_nf_recebimento.php",
				method:"POST",
				data:{prod_nfrec:prod_nfrec},
				success:function(data)
				{
					$('#retorno').html(data);
				}
			});
			return false;
		});

		$(document).on('change', '#produto_nf', function(){
			event.preventDefault();
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

		$(document).on('click', '#btnFormPesqProdRec', function(){
			event.preventDefault();
			$('#retornoNfRec').load('data/recebimento/modal/m_pesq_prd_rec.php');
		});

		$(document).on('click', '#btnFormPesqProdName', function(){
			event.preventDefault();
			var new_cod_produto = $('#n_cod_produto').val();
			var new_cod_prod_cliente = $('#n_cod_prod_cliente').val();
			var new_nm_produto = $('#n_nm_produto').val();
			$.ajax
			({
				url:"data/recebimento/consulta_prd_rec.php",
				method:"POST",
				dataType:'json',
				data:{
					new_cod_produto:new_cod_produto,
					new_cod_prod_cliente:new_cod_prod_cliente,
					new_nm_produto:new_nm_produto
				},
				success:function(prd)
				{
					for (var i = 0; i < prd.length; i++) {

						if(prd[i].info == "0"){

							$('#retPesqPrdRec').html("Produto não encontrado!");

						}else if(prd[i].info == "2"){

							$('#retPesqPrdRec').html("Foi encontrado mais de um registro. Entre em contato com \
								o suporte para analisar o resultado.");

						}else{

							$('#retPesProdName').append( '<tr class="tdPesq">\
								<td id="dt_cod_produto" id="codProduto">' + prd[i].cod_produto + '</td>\
								<td id="dt_cod_prod_cliente" data_cli="' + prd[i].cod_prod_cliente + '">' + prd[i].cod_prod_cliente + '</td>\
								<td id="dt_nm_produto" data_nm="' + prd[i].nm_produto + '">' + prd[i].nm_produto + '</td>\
								<td style="text-align: center; width: 5px"><button type="submit" id="btnIinsNfrecTeste" class="btn btn-primary btn-xs" value="' + prd[i].cod_produto + '">Inserir</button></td>\
								</tr>');

							$('#retPesqPrdRec').hide();
						}
					}
				}
			});
			return false;
		});

		$(document).on('click', '#btnIinsNfrecTeste', function(){
			event.preventDefault();
			$('#retPesqPrd').hide();

			var cod_produto = $(this).val();

			$.ajax
			({
				url:"data/recebimento/consulta_prd_rec_dtl.php",
				method:"POST",
				dataType:'json',
				data:{
					cod_produto:cod_produto
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {
						$('#formNovoProdRec input[name=cod_produto]').attr('value', j[i].cod_produto);
						$('#formNovoProdRec input[name=cod_prod_cliente]').attr('value', j[i].cod_prod_cliente);
					}

					$('#updEnd').modal('hide');
				}
			});
			return false;
		});

		$(document).on('click', '#btnInsPrdNfRec', function(){
			//event.preventDefault();
			$('#btnInsPrdNfRec').prop("disabled", true);
			if(confirm("Tem certeza que deseja inserir esse produto?")){
				var cod_nf_entrada = $('#produto_nf').val();
				var cod_produto = $('#cod_produto').val();
				var cod_prod_cliente = $('#cod_prod_cliente').val();
				var nr_qtde = $('#nr_qtde').val();
				var vl_unit = $('#vl_unit').val();
				var nr_peso_ent = $('#nr_peso_ent').val();
				var estado_produto = $('#estado_produto').val();
				$.ajax
				({
					url:"data/recebimento/ins_nf_prd_rec.php",
					method:"POST",
					dataType:"json",
					data:{
						cod_nf_entrada:cod_nf_entrada,
						cod_produto:cod_produto,
						cod_prod_cliente:cod_prod_cliente,
						nr_qtde:nr_qtde,
						vl_unit:vl_unit,
						nr_peso_ent:nr_peso_ent,
						estado_produto:estado_produto
					},
					success:function(j)
					{
						for (var i = 0; i < j.length; i++) {
							if(j[i].info == "0"){
								alert("Produto já existe na Nota Fiscal!");
							}else if(j[i].info == "2"){

								alert("Produto não existe no cadastro. Faça o cadastro e inclua na ordem de recebimento.");

							}else{
								$('#retProdNfItem').append('<tr>\
									<td style="text-align: center; width: 5px"><button type="submit" id="btnUpdPrdNfrec" class="btn btn-primary btn-xs" value="'+ j[i].cod_nf_entrada_item +'">Alterar</button></td>\
									<td>\
									<a href="data/recebimento/relatorio/list_etq_rec.php?cod_produto='+ j[i].cod_prod_cliente +'" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-primary btn-xs" value="">Etq</button></a>\
									</td>\
									<td style="text-align: center; width: 5px"><button type="submit" id="btnDelPrdNfrec" class="btn btn-primary btn-xs" value="'+ j[i].cod_nf_entrada_item +'">Excluir</button></td>\
									<td style="text-align: center; width: 5px"><button type="submit" id="btnNsPrdrec" class="btn btn-primary btn-xs" value="'+ j[i].cod_nf_entrada +'">N.Série</button></td>\
									<td>' + j[i].cod_nf_entrada_item + '</td>\
									<td>' + j[i].nr_fisc_ent + '</td>\
									<td>' + j[i].produto + '</td>\
									<td>' + j[i].nm_produto + '</td>\
									<td style="text-align: right;">' + j[i].estado + '</td>\
									<td style="text-align: right;">' + j[i].nr_qtde + '</td>\
									<td style="text-align: right;">' + j[i].vl_unit + '</td>\
									<td style="text-align: right;">' + j[i].nr_peso_unit + '</td>\
									</tr>');

								alert("Produto cadastrado!");
							}
						}
						$('#formNovoProdRec')[0].reset();
					}
				});
			}
			$('#btnInsPrdNfRec').prop("disabled", false);
			return false;
		});

		$(document).on('click', '#btnFimRec', function(){
			var cod_rec = $(this).val();
			$('#btnFimRec').prop("disabled", true);
			$.ajax
			({
				url:"data/recebimento/valida_fim_rec.php",
				method:"POST",
				dataType:'json',
				data:{
					cod_rec:cod_rec
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {
						if(j[i].info == 0){
							alert("OR finalizada!");
						}else{
							alert("Não foi possível finalizar a OR!");
						}
					}
					$('#btnFimRec').prop("disabled", false);
				}
			});
		});

		$(document).on('click', '#btnPrintRec', function(){
			var cod_rec = $(this).val();
			$.ajax({
				url:"data/recebimento/relatorio/ordem_recebimento.php",
				method:"POST",
				data:{cod_rec:cod_rec},
				success:function(data)
				{
					$('#retorno').html(data);
				}
			});
		});

		/*$('#retExpEnd1').hide();
		$(document).on('click', '#btnPrintRecFin', function(){
			event.preventDefault();
			var cod_rec = $(this).val();
			$.ajax
			({
				url:"data/recebimento/relatorio/cons_end_aloc.php",
				method:"POST",
				dataType:'json',
				data:{cod_rec:cod_rec},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {
						if(j[i].ds_galpao == 1){
							var retorno = "Atenção: Os produtos dessa OR ainda não foram endereçados!";
							$('#retFinORPrint').show();
							$('#retFinORPrint').html(retorno);
						}else{
							$('#retExpEnd1').hide();
							$.ajax
							({
								url:"data/recebimento/relatorio/ordem_alocacao.php",
								method:"POST",
								data:{cod_rec:cod_rec},
								success:function(data)
								{
									$('#wid-id-0').html(data);
								}
							});
						}
					}
				}
			});
		});*/

		$(document).on('click', '#btnListConfRec', function(){
			event.preventDefault();
			$('#info_conferencia').load('data/recebimento/list_conf_rec.php');
		});

		/*- Fim Recebimento -*/

		/*- Movimentação -*/

		$(document).on('click', '#btnFormalocarCod', function(){
			event.preventDefault();

			var cod_rec = $('#cod_rec').val();
			var cod_prd = $('#cod_prd').val();

			$.ajax
			({
				url:"data/movimento/alocar_list_sql.php",
				method:"POST",
				data:{cod_prd:cod_prd,cod_rec:cod_rec},
				success:function(j)
				{
					$('#info_aloca').html(j);
				}
			});
			return false;

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
			event.preventDefault();
			var cod_estoq = $(this).val();
			$.ajax({
				url:"data/movimento/modal/m_aloca_destino.php",
				method:"POST",
				data:{cod_estoq:cod_estoq},
				success:function(data)
				{
					$('#info_aloca').html(data);
				}
			});
			return false;
		});

		$(document).on('change', '#cmbarmaz', function(){
			if( $(this).val() ) {
				$('#cmbrua').hide();
				$.getJSON('data/movimento/consulta_rua.php?search=',{id_galpao: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a rua</option>';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
					}
					$('#cmbrua').html(options).show();
				});
			} else {
				$('#cmbrua').html('<option value="">Escolha a rua</option>');
			}
		});

		$(document).on('change', '#cmbrua', function(){
			if( $(this).val() ) {
				$('#cmbcoluna').hide();
				$.getJSON('data/movimento/consulta_coluna.php?search=',{id_rua: $(this).val(), id_galpao: $('#cmbarmaz').val(),ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a coluna</option>';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
					}
					$('#cmbcoluna').html(options).show();
				});
			} else {
				$('#cmbcoluna').html('<option value="">Escolha a coluna</option>');
			}
		});

		$(document).on('change', '#cmbcoluna', function(){
			if( $(this).val() ) {
				$('#cmbaltura').hide();
				$.getJSON('data/movimento/consulta_altura.php?search=',{id_coluna: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a altura</option>';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].altura + '">'  + j[i].altura + '</option>';
					}
					$('#cmbaltura').html(options).show();
				});
			} else {
				$('#cmbaltura').html('<option value="">Escolha a altura</option>');
			}
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
			event.preventDefault();
			var nm_movimenta = $('#nm_movimenta').val();
			var cod_movimenta = $('#cod_movimenta').val();
			var local = $('#local').val();
			if($('#nm_movimenta').val() != '' && $('#cod_movimenta').val() != ''){

				alert("Preecha somente o Código do produto ou a descrição do produto.");

			}else if($('#nm_movimenta').val() == '' && $('#cod_movimenta').val() == ''){

				alert("Preecha o código do produto ou a descrição do produto");

			}else{

				$.ajax
				({
					url:"data/movimento/mov_list_sql.php",
					method:"POST",
					data:{
						nm_movimenta:nm_movimenta,
						cod_movimenta:cod_movimenta,
						local:local
					},
					success:function(data){

						$('#info_produtos').html(data);
					}
				});

			}

			return false;
		});

		// $(document).on('click', '#btnMovDestino', function(){
		// 	event.preventDefault();
		// 	$('#btnMovDestino').prop("disabled", true);
		// 	var cod_estoque = $(this).val();
		// 	var nr_qtde = $('#nr_qtde').val();
		// 	$.ajax({
		// 		url:"data/movimento/modal/m_mov_destino.php",
		// 		method:"POST",
		// 		data:{cod_estoque:cod_estoque, nr_qtde:nr_qtde},
		// 		success:function(data)
		// 		{
		// 			$('#retMovimenta').html(data);
		// 		}
		// 	});
		// 	$('#btnMovDestino').prop("disabled", false);
		// 	return false;
		// });

		$(document).on('click', '#btnFormAlocacao', function(){
			event.preventDefault();
			var cod_estoque 		= $('#cod_estoque').val();
			var nr_qtde 			= $('#nr_qtde_new').val();
			var nr_qtde_old 		= $('#nr_qtde_old').val();
			var ds_galpao 			= $('#idGalpaoNew').val();
			var ds_rua 				= $('#idRuaNew').val();
			var ds_coluna 			= $('#idColNew').val();
			var ds_altura 			= $('#idAlturaNew').val();
			var cod_produto 		= $('#cod_produto').val();
			var produto 			= $('#produto').val();
			var cod_prod_cliente 	= $('#cod_prod_cliente').val();
			var nr_or 				= $('#nr_or').val();
			var ds_ano 				= $('#ds_ano').val();
			var n_serie 			= $('#n_serie').val();
			var ds_fabr 			= $('#ds_fabr').val();
			var ds_lp 				= $('#ds_lp').val();
			var ds_enr 				= $('#ds_enr').val();

			if($('#nr_qtde_new').val() == ''){

				alert("Digite a quantidade que será movimentada.");

			}else{

				$('#btnFormAlocacao').prop("disabled", true);
				$.ajax
				({
					url:"data/movimento/transf_alocacao.php",
					method:"POST",
					dataType:'json',
					data:{
						cod_estoque 		:cod_estoque,
						nr_qtde 			:nr_qtde,
						nr_qtde_old 		:nr_qtde_old,
						ds_galpao 			:ds_galpao,
						ds_rua 				:ds_rua,
						ds_coluna 			:ds_coluna,
						ds_altura 			:ds_altura,
						cod_produto 		:cod_produto,
						nr_or 				:nr_or,
						cod_prod_cliente 	:cod_prod_cliente,
						produto 			:produto,
						ds_ano 			    :ds_ano,
						n_serie 			:n_serie,
						ds_fabr 			:ds_fabr,
						ds_lp 			    :ds_lp,
						ds_enr 			    :ds_enr,
					},
					success:function(j)
					{
						for (var i = 0; i < j.length; i++) {

							if(j[i].info == "1"){

								alert("Ocorreu um erro na alocação. Por favor verifique se todos os campos foram preenchidos e se a quantidade solicitada na alocação.");

							}else if(j[i].info == "0"){

								alert("Alocação realizada com sucesso!");
								$('#nr_qtde_old').val(j[i].n_qtde);
								$('#retTbPrdTransf').load('data/movimento/tb_prd_transf.php?search=',{cod_estoque:cod_estoque});

							}else if(j[i].info == "2"){

								alert("A quantidade a transferir não pode ser maior que a quantidade original.");

							}else if(j[i].info == "4"){

								alert("Existe reserva para esse produto e posição! Faça a transferência somente após finalizar o pedido.");

							}

						}

						$('#btnFormAlocacao').prop("disabled", false);
					}
				});

			}		
			return false;
		});
		/*- Fim Movimentação -*/

		/*- Movimentação  - Pedidos -*/

		$(document).on('click', '#btnUpdPed', function(){
			var upd_ped= $(this).val();

			$.ajax
			({
				url:"data/movimento/modal/m_upd_pedido.php",
				method:"POST",
				data:{
					upd_ped:upd_ped
				},
				success:function(data)
				{
					$('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnDelPed', function(){
			if(confirm("Confirma a exclusão do pedido? Essa ação excluirá definitivamente o pedido, os produtos do pedido e os dados importados do SAP.")){
				var del_ped= $(this).val();

				$.ajax
				({
					url:"data/movimento/modal/m_del_pedido.php",
					method:"POST",
					dataType:'json',
					data:{
						del_ped:del_ped
					},
					success:function(j)
					{
						for (var i = 0; i < j.length; i++) {

							if(j[i].info == "1"){

								alert("Não é possível excluir um pedido com coleta iniciada.");

							}else if(j[i].info == "0"){

								alert("Pedido excluído.");
								$('#retornoPed').load('data/movimento/pedido_sql_geral.php');

							}else if(j[i].info == "2"){

								alert("Ocorreu um erro na exclusão do pedido. Entre em contato com o suporte!");
							}

						}
					}
				});
			}
		});

		$(document).on('click', '#btnNsPed', function(){
			var ns_ped= $(this).val();

			$.ajax
			({
				url:"data/movimento/consulta_ns_sql.php",
				method:"POST",
				data:{
					ns_ped:ns_ped
				},
				success:function(data)
				{
					$('#retorno').html(data);
				}
			});
		});

		/*$(document).on('click', '#btnColPed', function(){
			var col_ped= $(this).val();

			$.ajax
			({
				url:"data/movimento/libera_coleta.php",
				method:"POST",
				data:{
					col_ped:col_ped
				},
				success:function(data)
				{
					$('#retorno').html(data);
				}
			});
		});

		$(document).on('click', '#btnColPed', function(){
			var col_ped= $(this).val();

			$.ajax
			({
				url:"data/movimento/inicia_coleta_new.php",
				method:"POST",
				data:{
					col_ped:col_ped
				},
				success:function(data)
				{
					$('#retorno').html(data);
				}
			});
		});*/

		$(document).on('click', '#btnEndCol', function(){
			if(confirm("Confirma a finalização do pedido?")){
				var fin_col = $(this).val();
				var sts = $(this).attr("data-st");

				$.ajax
				({
					url:"data/movimento/atualiza_saldo.php",
					method:"POST",
					dataType:'json',
					data:{
						fin_col:fin_col
					},
					success:function(j)
					{

						for (var i = 0; i < j.length; i++) {

							if(j[i].info == "0"){

								alert("Pedido finalizado.");
								$('#retornoPed').load('data/movimento/pedido_sql_geral.php');

							}else if(j[i].info == "1"){

								alert("Não foi possível finalizar o pedido.");

							}else if(j[i].info == "2"){

								alert("Pedido já foi finalizado.");

							}

						}
					}
				});
			}
		});

		$(document).on('click', '#btnExpPed', function(){
			event.preventDefault();
			var nr_pedido= $(this).val();
			$.ajax
			({
				url:"data/movimento/cons_status_pedido.php",
				method:"POST",
				dataType:'json',
				data:{
					nr_pedido:nr_pedido
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {

						if(j[i].info == "1"){

							alert("Só é possível finalizar o pedido após a conferência.");

						}else if(j[i].info == "0"){

							alert("Pedido liberado para expedição.");

						}

					}
				}
			});
		});

		/*$(document).on('click', '#btnFormCadPedido', function(){
			event.preventDefault();
			var nm_solicitante 		= $('#nm_solicitante').val();
			var cod_cliente 		= $('#cod_cliente').val();
			var cod_destinatario 	= $('#cod_destinatario').val();
			var ds_modalidade 		= $('#ds_modalidade').val();
			var fl_tipo 			= $('#fl_tipo').val();
			var ds_frete 			= $('#ds_frete').val();
			var d_limite 			= $('#d_limite').val();
			var h_limite 			= $('#h_limite').val();
			var ds_obs_sac 			= $('#ds_obs_sac').val();
			var ds_doca 			= $('#ds_doca').val();
			var id_contrato 		= $('#id_contrato').val();
			var nm_usuario 			= $('#nm_usuario').val();
			$.ajax
			({
				url:"data/movimento/ins_pedido.php",
				method:"POST",
				dataType:'json',
				data:{
					nm_solicitante:nm_solicitante,
					cod_cliente:cod_cliente,
					cod_destinatario:cod_destinatario,
					ds_modalidade:ds_modalidade,
					fl_tipo:fl_tipo,
					ds_frete:ds_frete,
					d_limite:d_limite,
					h_limite:h_limite,
					ds_obs_sac:ds_obs_sac,
					ds_doca:ds_doca,
					id_contrato:id_contrato,
					nm_usuario:nm_usuario
				},
				success:function(j)
				{

					for (var i = 0; i < j.length; i++) {

						if(j[i].info == "1"){

							alert("Erro no cadastro!");


						}else if(j[i].info == "0"){

							$('#prd_pedido').html('<h2 style="margin-left: 10px;background-color: #2F4F4F;color: white">\
								Pedido gerado número: '+ j[i].pedido +'  </h2><br />');
							$('#btnFormCadPedido').hide();

						}

					}
				}
			});
			return false;
		});*/

		$(document).on('click', '#btnFormUpdPed', function(){
			event.preventDefault();
			var nr_pedido = $('#nr_pedido').val();
			var nm_aprovacao = $('#nm_aprovacao').val();
			var cod_cliente = $('#cod_cliente').val();
			var ds_modalidade = $('#ds_modalidade').val();
			var fl_tipo = $('#fl_tipo').val();
			var ds_frete = $('#ds_frete').val();
			var dt_limite = $('#dt_limite').val();
			var hr_limite = $('#hr_limite').val();
			var ds_obs = $('#ds_obs').val();
			var ds_doca = $('#ds_doca').val();

			$.ajax
			({
				url:"data/movimento/upd_pedido.php",
				method:"POST",
				data:{
					nr_pedido:nr_pedido,
					nm_aprovacao:nm_aprovacao,
					cod_cliente:cod_cliente,
					ds_modalidade:ds_modalidade,
					fl_tipo:fl_tipo,
					ds_frete:ds_frete,
					dt_limite:dt_limite,
					hr_limite:hr_limite,
					ds_obs:ds_obs,
					ds_doca:ds_doca
				},
				success:function(data)
				{
					$('#conteudo').load('pedido.php');
				}
			});
			return false;
		});

		$(document).on('click', '#btnFormFinPedido', function(){
			event.preventDefault();
			var nr_pedido = $('#nr_pedido').val();

			$.ajax
			({
				url:"data/movimento/fin_pedido.php",
				method:"POST",
				data:{nr_pedido:nr_pedido},
				success:function(data)
				{
					$('#prd_pedido').load('data/movimento/success_fin_pedido.php')
				}
			});

			return false;
		});

		/*$(document).on('change', '#prod_cliente', function(){
			$("#prd_qtde").prop("disabled", true);
			if( $(this).val() ) {
				$('#prd_estoque').hide();
				$('#prd_reservado').hide();
				$('#prd_saldo').hide();
				$.getJSON('data/movimento/consulta_saldo_estoque.php?search=',{cod_prod_cliente: $(this).val(),ajax: 'true'}, function(j){
					for (var i = 0; i < j.length; i++) {

						var saldo_prd = j[i].saldo-j[i].reservado;
						if(saldo_prd < 0){
							saldo_prd = 0;
						}

						var res_prd = 'Reservado: '+j[i].reservado+' Estoque: '+j[i].saldo+' Saldo: '+saldo_prd;

						//var estoque = '<input type="text" class="form-control" id="prdEstoque" value="' + j[i].saldo + '" readonly="true">';
						//var reservado = '<input type="text" class="form-control" id="prdReservado" value="' + j[i].reservado + '" readonly="true">';
						//var saldo = '<input type="text" class="form-control" id="prdReservado" value="' + saldo_prd + '" readonly="true">\
						//<input type="hidden" class="form-control" id="prdProduto" value="' + j[i].cod_produto + '" readonly="true">';
					}
					$('#retSldPrd').html(res_prd).show();
					//$('#prd_reservado').html(reservado).show();
					//$('#prd_saldo').html(saldo).show();
				});
			} else {
				$('#prd_estoque').html('<input type="text" class="form-control" id="prdEstoque" value="">');
			}
			$("#prd_qtde").prop("disabled", false);
		});*/

		$(document).on('change', '#cod_wms', function(){
			$("#prd_qtde").prop("disabled", true);
			if( $(this).val() ) {
				$('#prd_estoque').hide();
				$('#prd_reservado').hide();
				$('#prd_saldo').hide();
				$.getJSON('data/movimento/consulta_saldo_estoque.php?search=',{cod_wms: $(this).val(),ajax: 'true'}, function(j){
					for (var i = 0; i < j.length; i++) {

						var saldo_prd = j[i].saldo-j[i].reservado;
						if(saldo_prd < 0){
							saldo_prd = 0;
						}

						var estoque = '<input type="text" class="form-control" id="prdEstoque" value="' + j[i].saldo + '" readonly="true">';
						var reservado = '<input type="text" class="form-control" id="prdReservado" value="' + j[i].reservado + '" readonly="true">';
						var saldo = '<input type="text" class="form-control" id="prdReservado" value="' + saldo_prd + '" readonly="true">\
						<input type="hidden" class="form-control" id="prdProduto" value="' + j[i].cod_produto + '" readonly="true">';
					}
					$('#prd_estoque').html(estoque).show();
					$('#prd_reservado').html(reservado).show();
					$('#prd_saldo').html(saldo).show();
				});
			} else {
				$('#prd_estoque').html('<input type="text" class="form-control" id="prdEstoque" value="">');
			}
			$("#prd_qtde").prop("disabled", false);
		});

		$(document).on('click', '#btnDtlProdPedido', function(){
			event.preventDefault();
			var dtl_produto = $(this).val();

			$.ajax
			({
				url:"data/produto/modal/m_dtl_produto.php",
				method:"POST",
				data:{
					dtl_produto:dtl_produto
				},
				success:function(data)
				{
					$('#retDtlProduto').html(data);
				}
			});
			return false;
		});

		$(document).on('change', '#produto_nf', function(){
			event.preventDefault();
			var cod_nfEntrada = $(this).val();

			$.ajax
			({
				url:"data/recebimento/consulta_item_nf_rec.php",
				method:"POST",
				dataType:'json',
				data:{
					cod_nfEntrada:cod_nfEntrada
				},
				success:function(j)
				{
					$('.odd').hide();
					for(var i=0;i < j.length;i++){
						$('#retProdNfItem').append('<tr>\
							<td style="text-align: center; width: 5px"><button type="submit" id="btnUpdPrdNfrec" class="btn btn-primary btn-xs" value="'+ j[i].cod_nf_entrada_item +'">Alterar</button>\
							<input type="hidden" id="fl_status" name="fl_status" value="'+ j[i].fl_status +'"\
							</td>\
							<td>\
							<a href="data/recebimento/relatorio/list_etq_rec.php?cod_produto='+ j[i].produto +'" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-primary btn-xs" value="">Etq</button></a>\
							</td>\
							<td style="text-align: center; width: 5px"><button type="submit" id="btnDelPrdNfrec" class="btn btn-primary btn-xs" value="'+ j[i].cod_nf_entrada_item +'">Excluir</button></td>\
							<td style="text-align: center; width: 5px"><button type="submit" id="btnNsPrdrec" class="btn btn-primary btn-xs" value="'+ j[i].cod_nf_entrada +'">N.Série</button></td>\
							<td>' + j[i].cod_nf_entrada_item + '</td>\
							<td>' + j[i].nr_fisc_ent + '</td>\
							<td>' + j[i].cod_produto + '</td>\
							<td>' + j[i].nm_produto + '</td>\
							<td style="text-align: right;">' + j[i].estado + '</td>\
							<td style="text-align: right;">' + j[i].nr_qtde + '</td>\
							<td style="text-align: right;">' + j[i].vl_unit + '</td>\
							<td style="text-align: right;">' + j[i].nr_peso_unit + '</td>\
							</tr>\
							');
					}
				}
			});
			return false;
		});

		/*$(document).on('click', '#btnUpdPrdNfrec', function(){
			event.preventDefault();
			var id_nfItem = $(this).val();
			var fl_status = $('#fl_status').val();

			if(fl_status == 'A'){

				$.ajax
				({
					url:"data/recebimento/modal/m_upd_item_nf.php",
					method:"POST",
					data:{
						id_nfItem:id_nfItem
					},
					success:function(data)
					{
						$('#retornoOr').html(data);
					}
				});
			}else{

				alert("O produto já foi liberado para conferência.");

			}
			return false;
		});*/

		$(document).on('click', '#btnSaveUpdPrdRec', function(){
			event.preventDefault();
			var nr_qtde = $('#nr_qtde_new').val();
			var vlr_unit = $('#vlr_unit').val();
			var nr_peso_unit = $('#nr_peso_unit').val();
			var estado_produto = $('#estado_produto_new').val();
			var id_nfItem = $('#id_nfItem').val();
			console.log(estado_produto);
			$.ajax
			({
				url:"data/recebimento/upd_prd_nf_rec.php",
				method:"POST",
				dataType:'json',
				data:{
					nr_qtde:nr_qtde,
					vlr_unit:vlr_unit,
					nr_peso_unit:nr_peso_unit,
					estado_produto:estado_produto,
					id_nfItem:id_nfItem
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {
						if(j[i].info == 0){
							alert("Produto alterado com sucesso!");
						}else{
							alert("Erro no cadastro!");
						}
					}
				}
			});
			return false;
		});

		$(document).on('click', '#btnNsPrdrec', function(){
			event.preventDefault();
			var id_nfItem = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_ins_ns.php",
				method:"POST",
				data:{id_nfItem:id_nfItem},
				success:function(data)
				{
					$('#retornoPrd').html(data);
				}
			});
			return false;
		});


		$(document).on('click', '#btnListEtq', function(){
			event.preventDefault();
			var cod_rec = $(this).val();
			$.ajax({
				url:"data/recebimento/modal/m_list_prd_rec.php",
				method:"POST",
				data:{cod_rec:cod_rec},
				success:function(data)
				{
					$('#retornoNfRec').html(data);
				}
			});
			return false;
		});

		$(document).on('click', '#btnUpdQtdeProdPedido', function(){
			event.preventDefault();
			var cod_ped = $(this).val();
			$.ajax
			({
				url:"data/movimento/upd_prd_pedido.php",
				method:"POST",
				data:{
					cod_ped:cod_ped
				},
				success:function(data)
				{
					$('#retModalPedDtl').html(data);
				}
			});
			
			return false;
		});

		$(document).on('click', '#btnInsertPrdPedido', function(){
			event.preventDefault();
			var cod_prod_cliente = $('#cod_produto').val();
			var nr_pedido = $('#nr_pedido').val();
			var nr_qtde_pedido = $('#nr_qtde_pedido').val();
			$.ajax({
				url:"data/movimento/ins_prd_pedido_coleta.php",
				method:"POST",
				data:{
					cod_prod_cliente:cod_prod_cliente,
					nr_pedido:nr_pedido, nr_qtde_pedido:nr_qtde_pedido
				},
				success:function(data)
				{
					$('#formInsPrdPedido')[0].reset();
					$('#prd_pedido').modal('show')
				}
			});
			return false;
		});

		$(document).on('change', '#cod_destinatario', function(){
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

		$(document).on('change', '#cod_destinatario', function(){
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
			event.preventDefault();
			var listColeta = $('#listColeta').val();
			$.ajax
			({
				url:"data/movimento/list_coleta.php",
				method:"POST",
				data:{listColeta:listColeta},
				beforeSend:function(e){
					$("#infoColeta").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				},
				success:function(data)
				{
					$('#infoColeta').html(data);
					$.ajax
					({
						url:"data/movimento/list_coleta_qtd.php",
						method:"POST",
						dataType:'json',
						data:{listColeta:listColeta},
						success:function(j)
						{
							var pedido = new Array();
							$('.progresso').each( function( i,v ){
								pedido[i] = $('.pedidoCol').val();
							});
							console.log(pedido);


							for (var i = 0; i < j.length; i++) {
								var nr_pedido = j[i].nr_pedido;
								console.log(nr_pedido);
								if(nr_pedido == $('#pedidoCol').val()){

									$('.progress').html('<div class="progress progress-sm">\
										<div class="progress-bar bg-color-redLight" style="width:'+j[i].percentual+'%"></div>\
										</div>');
									$('percent').html('<span id="percent">'+j[i].percentual+'%</span>');

								}else{
								}

							}
						}
					});
				}
			});
		});

		$(document).on('click', '#btnListConfPicking', function(){
			event.preventDefault();
			$('#info_conferencia').load('data/movimento/list_conf_ped.php');
		});

		$(document).on('click', '#btnListConfAloc', function(){
			event.preventDefault();
			$('#info_conferencia').load('data/movimento/list_aloc_pend.php');
		});

		$(document).on('click', '#btnListConfExp', function(){
			event.preventDefault();
			$('#info_conferencia').load('data/movimento/list_exp_pend.php');
		});

		/*- Fim Coletas -*/
	});

/*- Inventário -*/
$(document).ready(function() {
	var nivel = "<?php echo $fl_nivel; ?>";
	$(document).on('click', '#btnTarefas', function(){
		event.preventDefault();
		id_usr = $('#user_tar').val();
		
		if(id_usr == ""){

			$.post("data/inventario/list_tar_inv.php",
				function(data){
					$('#infoTarefas').html(data);
				});

		}else{

			$.post("data/inventario/list_tar_inv_user.php",{id_usr:id_usr},
				function(data){
					$('#infoTarefas').html(data);
				});

		}
		return false;
	});
	
	$(document).on('click', '#btnCompTarPend', function(){
		event.preventDefault();

		$('#infoTarefas').load("data/inventario/list_tar_inv_comp.php");

		return false;
	});

	$(document).on('click', '#btnEncTarConf', function(){
		event.preventDefault();
		var id_usr 	= $('#user_tar').val();

		if(id_usr == ""){

			alert("Selecione um conferente.");

		}else{

			if(confirm("Tem certeza que deseja encerrar todas as tarefas desse conferente?")){

				$("#btnEncTarConf").prop("disabled", true);

				$.post("data/inventario/valida_conf_cego_usr.php",{id_usr:id_usr},
					function(data){
						alert(data);
						$('#infoTarefas').load("data/inventario/list_tar_inv_user.php",{id_usr:id_usr});
					});
				$("#btnEncTarConf").prop("disabled", false);

			}

		}
		return false;
	});

	$(document).on('click', '#btnNewTar', function(){
		$('#invTar').load('data/inventario/modal/m_ins_tar.php');
	});

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

	$(document).on('click', '#btnHistTar', function(){
		var id_inv = $('#SelHistInv').val();
		var dtInitHistTar = $('#dtInitHistTar').val();
		var dtFinHistTar = $('#dtFinHistTar').val();

		if(id_inv != '' && dtInitHistTar != '' && dtFinHistTar != ''){

			$.ajax
			({
				url:"data/inventario/list_hist_tar.php",
				method:"POST",
				data:{
					
					id_inv:id_inv,
					dtInitHistTar:dtInitHistTar,
					dtFinHistTar:dtFinHistTar

				},
				beforeSend:function(e){
					$("#infoTarefas").html("<img src='css/loading9.gif'>");
				},
				success:function(data)
				{
					$('#infoTarefas').html(data);
				}
			});

		}else{

			alert("Digite a tarefa ou os campos inventário e período!");

		}
	});

	$(document).on('click', '#btnHistInvFin', function(){
		var id_inv = $('#SelHistInv').val();
		var dtInitHistTar = $('#dtInitHistTar').val();
		var dtFinHistTar = $('#dtFinHistTar').val();
		var SelInvRua = $('#SelInvRua').val();
		var SelInvColuna = $('#SelInvColuna').val();
		var SelIdTArefa = $('#SelIdTArefa').val();

		if(id_inv == '' || dtInitHistTar == ''|| dtFinHistTar == ''){
			alert("Selecione o inventário e o período que deseja consultar!");
		}else{
			$.ajax
			({
				url:"data/inventario/list_hist_tar_dia.php",
				method:"POST",
				data:{
					id_inv:id_inv,
					dtInitHistTar:dtInitHistTar,
					dtFinHistTar:dtFinHistTar,
					SelInvRua:SelInvRua,
					SelInvColuna:SelInvColuna,
					SelIdTArefa:SelIdTArefa
				},
				beforeSend:function(e){
					$("#infoTarefas").html("<img src='css/loading9.gif'>");
				},
				success:function(data)
				{
					$('#infoTarefas').html(data);
				}
			});
		}
	});

	$(document).on('click', '#btnHistInvOcor', function(){
		var id_inv = $('#SelHistInv').val();
		$.ajax({
			url:"data/inventario/list_hist_tar_nc.php",
			method:"POST",
			data:{id_inv:id_inv},
			beforeSend:function(e){
				$("#infoTarefas").html("<img src='css/loading9.gif'>");
			},
			success:function(data)
			{
				$('#infoTarefas').html(data);
			}
		});
	});

	$(document).on('click', '#btnDtlTarDia', function(){
		var dt_create = $(this).val();
		$.ajax({
			url:"data/inventario/modal/m_dtl_tar_dia.php",
			method:"POST",
			data:{dt_create:dt_create},
			success:function(data)
			{
				$('#infoTarefasDia').html(data);
			}
		});
	});

	$(document).on('click', '#btnFinTarefa', function(){
		if(confirm("Tem certeza que deseja finalizar a tarefa?")){
			$("#btnFinTarefa").prop("disabled", true);
			var id_tar = $(this).val();
			$.ajax
			({
				url:"data/inventario/valida_conf_cego.php",
				method:"POST",
				data:{id_tar:id_tar},
				success:function(data)
				{
					$("#btnFinTarefa").prop("disabled", false);
					$('#conteudo').load('inv_tarefa.php');
				}
			});
		}
	});
});

$(function(){
	$(document).on('change', '#id_inv', function(){
		if( $(this).val() ) {
			$('#inv_rua').hide();
			$.getJSON('data/inventario/consulta_rua_inv.php?search=',{id_inv: $(this).val(), id_galpao_inv: $('#id_inv').find(':selected').attr("data-inv"), ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a rua</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
				}
				$('#inv_rua').html(options).show();

			});
		} else {
			$('#inv_rua').html('<option value="">Escolha a rua</option>');
		}
	});

	$(document).on('change', '#inv_rua', function(){
		if( $(this).val() ) {
			$('#inv_mod').hide();

			$.getJSON('data/inventario/consulta_coluna_inv.php?search=',{id_rua: $(this).val(), id_galpao_inv: $('#id_inv').find(':selected').attr("data-inv"), ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a coluna</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
				}
				$('#inv_mod').html(options).show();

			});
		} else {
			$('#inv_mod').html('<option value="">Escolha a coluna</option>');
		}
	});

	$(document).on('change', '#inv_mod', function(){
		if( $(this).val() ) {
			$('#inv_alt').hide();

			$.getJSON('data/inventario/consulta_altura.php?search=',{id_rua: $('#inv_rua').val(), id_coluna: $(this).val(), id_galpao_inv: $('#id_inv').find(':selected').attr("data-inv"), ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a altura</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].altura + '">'  + j[i].altura + '</option>';
				}
				$('#inv_alt').html(options).show();

			});
		} else {
			$('#inv_alt').html('<option value="">Escolha a altura</option>');
		}
	});
});

$(document).on('click', '#btnFormCadTar', function(){
	event.preventDefault();
	$("#btnFormCadTar").prop("disabled", true);
	var id_inv 			= $('#id_inv').val();
	var id_galpao_inv 	= $('#id_inv').find(':selected').attr("data-inv");
	var dt_tarefa 		= $('#dt_tarefa').val();
	var inv_rua 		= $('#inv_rua').val();
	var inv_mod 		= $('#inv_mod').val();
	var inv_alt 		= $('#inv_alt').val();
	var id_produto 		= $('#id_produto').val();
	var conf1 			= $('#conf1').val();
	var conf2 			= $('#conf2').val();
	var qtde1 			= $('#qtde1').val();
	var qtde2 			= $('#qtde2').val();
	var qtde3 			= $('#qtde3').val();
	var nr_vol 			= $('#nr_vol').val();

	if(id_galpao_inv != '' || dt_tarefa != '' || inv_rua != '' || inv_mod != '' || inv_alt != '' || id_produto != '' || qtde1 != '' || qtde2 != ''){
		$('.carregando').show();
		$.ajax({
			url:"data/inventario/ins_tar_inv.php",
			method:"POST",
			data:{
				id_inv:id_inv,
				id_galpao_inv:id_galpao_inv,
				dt_tarefa:dt_tarefa,
				inv_rua:inv_rua,
				inv_mod:inv_mod,
				inv_alt:inv_alt,
				id_produto:id_produto,
				conf1:conf1,
				conf2:conf2,
				qtde1:qtde1,
				qtde2:qtde2,
				qtde3:qtde3,
				nr_vol:nr_vol
			},
			success:function(data)
			{
				$('#confirma').html(data);

				/*for (var i = 0; i < j.length; i++) {
					$('#confirma').html('<h3 style="background-color: #B22222;color:white">Tarefa: '+j[i].id+', local: '+j[i].id_rua+j[i].id_coluna+j[i].id_altura+'</h3>');
				}*/
				var codigo = "";
				$('.carregando').hide();
				$('#qtde1').val("");
				$('#qtde2').val("");
				$('#qtde3').val("");
				$('#nr_vol').val("");
			}
		});

	}else{

		alert("Digite todas as informações!");

	}
	$("#btnFormCadTar").prop("disabled", false);

	return false;
});

$(document).ready(function(){
	var nivel = "<?php echo $fl_nivel; ?>";
	$(document).on('click', '#btnEditTar', function(){
		var id_tar = $(this).val();
		$.ajax({
			url:"data/inventario/modal/m_upd_embalagem.php",
			method:"POST",
			data:{id_tar:id_tar},
			success:function(data)
			{
				$('#tarefas').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#btnSaveUpdEmbalagem', function(){
		$('#btnSaveUpdEmbalagem').prop("disabled", true);
		var id_tar = $('#id_tarefa').val();
		var ds_embalagem = $('#ds_embalagem').val();
		$.ajax
		({
			url:"data/inventario/upd_embalagem.php",
			method:"POST",
			dataType:'json',
			data:{
				id_tar:id_tar,
				ds_embalagem:ds_embalagem
			},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {
					if(j[i].info == 0){
						alert("Embalagem alterada com sucesso!");
					}else{
						alert("Erro no cadastro!");
					}
				}
			}
		});
		$('#btnSaveUpdEmbalagem').prop("disabled", false);
		return false;
	});

	$(document).on('click', '#btnformEditTar', function(){
		var id_tar = $(this).val();
		$.ajax({
			url:"data/inventario/modal/m_upd_tar.php",
			method:"POST",
			data:{id_tar:id_tar},
			success:function(data)
			{
				$('#retornoTarefas').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#btnDelTarefa', function(){
		var id_tar = $(this).val();
		$.ajax({
			url:"data/inventario/modal/m_del_tar.php",
			method:"POST",
			data:{id_tar:id_tar},
			success:function(data)
			{
				$('#retornoTarefas').html(data);
			}
		});
	});

	$(document).on('click', '#btnDelTarefaConf', function(){
		var id_tar = $(this).val();
		$.ajax({
			url:"data/inventario/del_tar.php",
			method:"POST",
			data:{id_tar:id_tar},
			success:function(data)
			{
				$('#invTar').html(data);
			}
		});
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnNewInventario', function(){
		event.preventDefault()
		var ds_tipo 			= $('#ds_tipo').val();
		var dt_inicio 			= $('#datainicio').val();
		var dt_fim 				= $('#dt_fim').val();
		var id_galpao 			= $('#progInvGlp').val();
		var id_rua_inicio 		= $('#id_rua_inicio').val();
		var id_rua_fim 			= $('#id_rua_fim').val();
		var id_coluna_inicio 	= $('#id_coluna_inicio').val();
		var id_coluna_fim 		= $('#id_coluna_fim').val();
		var id_altura_inicio 	= $('#id_altura_inicio').val();
		var id_altura_fim 		= $('#id_altura_fim').val();
		var id_grupo 			= $('#id_grupo').val();
		var id_sub_grupo 		= $('#id_sub_grupo').val();
		var id_produto 			= $('#cod_produto').val();

		if(ds_tipo != '' && dt_inicio != '' && dt_fim != ''){
			$.getJSON('data/inventario/consulta_inventario.php?search=',{
				ds_tipo:ds_tipo, 
				dt_inicio:dt_inicio,
				dt_fim:dt_fim,
				id_galpao:id_galpao,
				id_rua_inicio:id_rua_inicio,
				id_rua_fim:id_rua_fim,
				id_coluna_inicio:id_coluna_inicio,
				id_coluna_fim:id_coluna_fim,
				id_altura_inicio:id_altura_inicio,
				id_altura_fim:id_altura_fim,
				id_grupo:id_grupo,
				id_sub_grupo:id_sub_grupo,
				id_produto:id_produto,
				ajax: 'true'}, function(j){

					for (var i = 0; i < j.length; i++) {

						if(j[i].info == 1){

							alert("Já existe inventário ativo com esses parâmetros.");

						}else{

							$.ajax
							({
								url:"data/inventario/ins_prog.php",
								method:"POST",
								dataType:'json',
								data:{
									ds_tipo:ds_tipo,
									dt_inicio:dt_inicio,
									dt_fim:dt_fim,
									id_galpao:id_galpao,
									id_rua_inicio:id_rua_inicio,
									id_rua_fim:id_rua_fim,
									id_coluna_inicio:id_coluna_inicio,
									id_coluna_fim:id_coluna_fim,
									id_altura_inicio:id_altura_inicio,
									id_altura_fim:id_altura_fim,
									id_grupo:id_grupo,
									id_sub_grupo:id_sub_grupo,
									id_produto:id_produto
								},
								success:function(k)
								{
									for (var i = 0; i < k.length; i++) {

										if(k[i].info == 0){

											alert("Não esqueça de se planejar!O inventário não poderá ser ativado se houver alguma movimentação pendente e quando o inventário for ativado as movimentações serão bloqueadas.");

										}else if(k[i].info == 1){

											alert("Ocorreu um erro! Entre em contato com o suporte.");

										}
									}
								}
							});
						}
					}
				});
		}else{

			alert("É necessário selecionar o tipo, as datas do inventário e o armazém!!!");

		}
		return false;
	});
});

$(document).ready(function(){
	var nivel = "<?php echo $fl_nivel; ?>";
	$(document).on('click', '#btnProdNaoIdent', function(){
		$('#invTar').load('data/inventario/modal/m_prod_tar.php');
	});

	$(document).on('click', '#btnFormCadProdTar', function(){
		event.preventDefault()
		$("#btnFormCadProdTar").prop("disabled", true);
		var id_inv = $('#id_inv').val();
		var id_galpao_inv = $('#id_galpao_inv').val();
		var inv_rua = $('#inv_rua').val();
		var inv_mod = $('#inv_mod').val();
		var inv_alt = $('#inv_alt').val();
		var id_torre = $('#id_torre').val();
		var ds_embalagem = $('#ds_embalagem').val();
		var ds_detalhe = $('#ds_detalhe').val();
		var conf1 = $('#conf1').val();
		var conf2 = $('#conf2').val();
		var qtde1 = $('#qtde1').val();
		var qtde2 = $('#qtde2').val();
		var qtde3 = $('#qtde3').val();
		$.ajax
		({
			url:"data/inventario/ins_tar_prod.php",
			method:"POST",
			dataType:'json',
			data:{
				id_inv:id_inv,
				id_galpao_inv:id_galpao_inv,
				inv_rua:inv_rua,
				inv_mod:inv_mod,
				inv_alt:inv_alt,
				id_torre:id_torre,
				ds_embalagem:ds_embalagem,
				ds_detalhe:ds_detalhe,
				conf1:conf1,
				conf2:conf2,
				qtde1:qtde1,
				qtde2:qtde2,
				qtde3:qtde3
			},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {
					$('#confirma').html('<h3 style="background-color: #B22222;color:white">Tarefa: '+j[i].id+', local: '+j[i].id_rua+j[i].id_coluna+j[i].id_altura+'</h3>');
				}
				var codigo = "";
				$('.carregando').hide();
				$('#nova_tarefa').modal('show');
				$("#btnFormCadProdTar").prop("disabled", false);
			}
		});
		return false;
	});

	$(document).on('click', '#btnFormUpdTar', function(){
		event.preventDefault();
		var id_tar = $(this).val();
		var conf1 = $('#conf1').val();
		var conf2 = $('#conf2').val();
		var qtde1 = $('#qtde1').val();
		var qtde2 = $('#qtde2').val();
		var qtde3 = $('#qtde3').val();
		var nr_volume = $('#nr_volume').val();
		var id_produto = $('#id_produto').val();
		$.ajax
		({
			url:"data/inventario/upd_inv_tar.php",
			method:"POST",
			data:{
				id_tar:id_tar,
				conf1:conf1,
				conf2:conf2,
				qtde1:qtde1,
				qtde2:qtde2,
				qtde3:qtde3,
				nr_volume:nr_volume,
				id_produto:id_produto
			},
			success:function(data)
			{
				$('#edita_tarefa').modal('hide');
				$('#infoTarefas').load('data/inventario/list_tar_inv.php');
			}
		});
		return false;
	});

	$(function(){
		$(document).on('focusout', '#id_pos', function(){
			if( $(this).val() ) {
				$('#idParteTar').hide();
				$.getJSON('data/inventario/consulta_parte_inv.php?search=',{id_pos: $(this).val(), id_torre: $('#id_torre').val(), ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a parte</option>';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id + '">'  + j[i].parte + '</option>';
					}
					$('#idParteTar').html(options).show();
				});
			} else {
				$('#idParteTar').html('<option value="">Escolha a parte</option>');
			}
		});
		return false;
	});

	$(function(){
		$(document).on('click', '#id_inv_upd', function(){
			if( $(this).val() ) {
				$('#inv_rua_upd').hide();
				$.getJSON('data/inventario/consulta_rua_inv.php?search=',
				{
					id_inv: $(this).val(), 
					id_galpao_inv: $('#id_galpao_inv').val(), 
					ajax: 'true'}, function(j)
					{
					var options = '<option value="">Escolha a rua</option>';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
					}
					$('#inv_rua_upd').html(options).show();
				});
			} else {
				$('#inv_rua_upd').html('<option value="">Escolha a rua</option>');
			}
		});

		$(document).on('click', '#inv_rua_upd', function(){
			if( $(this).val() ) {
				$('#inv_mod_upd').hide();
				$.getJSON('data/inventario/consulta_coluna_inv.php?search=',
				{
					id_rua: $(this).val(), 
					id_galpao_inv: $('#id_galpao_inv').val(), 
					ajax: 'true'}, function(j)
					{
					var options = '<option value="">Escolha a coluna</option>';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
					}
					$('#inv_mod_upd').html(options).show();
				});
			} else {
				$('#inv_mod_upd').html('<option value="">Escolha a coluna</option>');
			}
		});

		$(document).on('click', '#inv_mod_upd', function(){
			if( $(this).val() ) {
				$('#inv_alt_upd').hide();
				$.getJSON('data/inventario/consulta_altura.php?search=',
				{
					id_coluna: $(this).val(), 
					id_rua: $('#inv_rua_upd').val(), 
					id_galpao_inv: $('#id_galpao_inv').val(), 
					ajax: 'true'}, function(j){
					var options = '<option value="">Escolha a altura</option>';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].altura + '">'  + j[i].altura + '</option>';
					}
					$('#inv_alt_upd').html(options).show();
				});
			} else {
				$('#inv_alt_upd').html('<option value="">Escolha a altura</option>');
			}
		});
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnDelImgOcor', function(){
		if(confirm("Confirma a exclusão da imagem?")){
			var id_img = $(this).val();
			var id_ocor = $('#idOcor').val();
			$.ajax
			({
				url:"data/qualidade/del_img.php",
				method:"POST",
				data:{id_img:id_img},
				success:function(data)
				{
					alert(data);
					$('#gallery').load("data/qualidade/list_img.php?search=",{id_ocor:id_ocor});
				}
			});
		}
	});
});

/*--- Transporte ---*/

$(document).ready(function(){
	var nivel = "<?php echo $fl_nivel; ?>";
	$('#ConEntrPend').click(function(e){
		event.preventDefault();
		if(nivel <= '2'){
			$('#ConEntrPend').prop("disabled", true);
			alert('Você não tem acesso a esse menu!');
		}else{
			$('#conteudo').load('monitora_pend.php');
		}
	});
});

$(document).ready(function(){
	var nivel = "<?php echo $fl_nivel; ?>";
	$('#linkConf').click(function(e){
		event.preventDefault();
		if(nivel <= '3'){
			$('#linkConf').prop("disabled", true);
			alert('Você não tem acesso a esse menu!');
		}else{
			$('#conteudo').load('conf_pendente.php');
		}
	});
});

$(document).ready(function(){
	var nivel = "<?php echo $fl_nivel; ?>";
	$('#ConsConf').click(function(e){
		event.preventDefault();
		if(nivel <= '3'){
			$('#ConsConf').prop("disabled", true);
			alert('Você não tem acesso a esse menu!');
		}else{
			$('#conteudo').load('conf_pendente.php');
		}
	});
});

/*--- Alteração de endereço de coleta ---*/

$(document).ready(function(){
	$(document).on('click', '#btnUpdPedCol', function(){
		event.preventDefault();
		var id_pedido = $(this).val();
		$.ajax({
			url:"data/movimento/modal/m_upd_pedido_coleta.php",
			method:"POST",
			data:{id_pedido:id_pedido},
			success:function(data)
			{
				$('#retPicking').html(data);
			}
		});
	});

	$(document).on('click', '#btnUpdEndPrdPed', function(){
		event.preventDefault();
		var cod_col = $(this).val();
		$.ajax({
			url:"data/movimento/modal/m_upd_end_pedido_coleta.php",
			method:"POST",
			data:{cod_col:cod_col},
			success:function(data)
			{
				$('#retUpdEnd').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#btnUpdEndPedCons', function(){
		event.preventDefault();
		$("#btnUpdEndPedCons").prop("disabled", true);
		var nr_pedido = $(this).val();
		var cod_produto = $('#cod_produto').val();
		var ds_galpao = $('#cmbarmaz').val();
		var ds_prateleira = $('#cmbrua').val();
		var ds_coluna = $('#cmbcoluna').val();
		var ds_altura = $('#cmbaltura').val();
		var nr_qtde = $('#nr_new_qtde').val();
		$.ajax({
			url:"data/movimento/valida_novo_end.php",
			method:"POST",
			dataType:'json',
			data:{nr_pedido:nr_pedido, cod_produto:cod_produto, ds_galpao:ds_galpao, ds_prateleira:ds_prateleira, ds_coluna:ds_coluna, ds_altura:ds_altura, nr_qtde:nr_qtde},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {
					if(j[i].produto){
						var options = '<tr>\
						<td style="text-align: center;">' + j[i].produto + '</td>\
						<td style="text-align: rigth;">' + j[i].ds_galpao + '</td>\
						<td style="text-align: rigth;">' + j[i].ds_prateleira + '</td>\
						<td style="text-align: rigth;">' + j[i].ds_coluna + '</td>\
						<td style="text-align: rigth;">' + j[i].ds_altura + '</td>\
						<td style="text-align: rigth;">' + j[i].reservado + '</td>\
						<td style="text-align: rigth;">' + j[i].saldo + '\
						<input type="hidden" id="cod_col" value="' + j[i].cod_col + '"></td>\
						</tr>';
						$('#retValNewEnd').append(options);
					}else{

						var info = j[i].info;
						$('#retValInfo').html(info);
					}
				}
			}
		});
		$("#btnUpdEndPedCons").prop("disabled", false);
		return false;
	});

	$(document).on('click', '#btnUpdEndPedSave', function(){
		event.preventDefault();
		$("#btnUpdEndPedSave").prop("disabled", true);
		var cod_col = $('#cod_col').val();
		var id_pedido = $('#id_pedido').val();
		var cod_produto = $('#cod_prod').val();
		var ds_galpao = $('#galpao_upd').val();
		var ds_prateleira = $('#rua_upd').val();
		var ds_coluna = $('#coluna_upd').val();
		var ds_altura = $('#altura_upd').val();
		var nr_qtde = $('#nr_new_qtde').val();
		var nr_qtde_new = $('#nr_qtde_new_col').val();
		var nr_qtde_old = $('#nr_qtde_old').val();
		var fl_status = $('#fl_status').val();
		var cod_estoque = $('#cod_estoque').val();

		var teste = Number(nr_qtde_new)+Number(nr_qtde);

		if(ds_galpao == "" || ds_prateleira == "" || ds_coluna == "" || ds_altura == "" || nr_qtde == "" || nr_qtde_new == ""){

			alert("Todos os campos devem ser preenchidos.");

		}else if(teste != nr_qtde_old){

			alert("A quantidade final do produto é diferente que a quantidade solicitada no pedido.");

		}else if(fl_status != 'M'){

			alert("A conferência já foi finalizada, não é possível alterar o pedido.");

		}else{

			$.ajax
			({
				url:"data/movimento/consulta_conferencia.php",
				method:"POST",
				dataType:'json',
				data:{
					cod_produto:cod_produto,
					id_pedido:id_pedido
				},
				success:function(l)
				{
					for (var i = 0; i < l.length; i++) {

						if(l[i].info == 0){
							$.ajax
							({
								url:"data/movimento/upd_novo_end_pedido.php",
								method:"POST",
								dataType:'json',
								data:{
									cod_col:cod_col,
									cod_produto:cod_produto,
									ds_galpao:ds_galpao,
									ds_prateleira:ds_prateleira,
									ds_coluna:ds_coluna,
									ds_altura:ds_altura,
									nr_qtde:nr_qtde,
									id_pedido:id_pedido,
									nr_qtde_new:nr_qtde_new,
									nr_qtde_old:nr_qtde_old,
									cod_estoque:cod_estoque
								},
								success:function(j)
								{
									for (var i = 0; i < j.length; i++) {

										if(j[i].info == "0"){
											alert("Pedido alterado.");
										}else if(j[i].info == "2"){
											alert("Produto não existe no endereço selecionado!");
										}else{

											alert("Erro no cadastro!");
										}
									}
								}
							});
						}else if(l[i].info == 1){
							alert("Já existem quantidades coletadas desse produto!");
						}else{

							alert("Erro no cadastro!");
						}
					}
				}
			});
		}
		$("#btnUpdEndPedSave").prop("disabled", false);
		return false;
	});

	$('#retValInfo').hide();
	$( '#btnFinPedCol').on('click', function() {
		event.preventDefault();
		var pedido = $(this).val();
		$.ajax({
			url:"data/movimento/fin_conf_pedido.php",
			method: "POST",
			dataType:'json',
			data:{pedido:pedido},
			success:function(j){
				for(var i=0;i < j.length;i++){
					var info = j[i].info;
					if(info == 1){
						$('#retValInfo').show();
						$('#retValInfo').html("Pedido finalizado com sucesso!");

					}else{
						$('#retValInfo').show();
						$('#retValInfo').html(info);

					}
				}
			}
		});
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnFormNfSaida', function(){
		var nfsaida = $('#nfsaida').val();
		$.ajax({
			url:"data/movimento/nf_saida_sql.php",
			method:"POST",
			data:{nfsaida:nfsaida},
			success:function(j)
			{
				$('#infoNfSaida').html(j);
			}
		});
	});

	$(document).on('click', '#btnPrintMin', function(){
		var cod_minuta = $(this).val();
		$.ajax({
			url:"data/movimento/relatorio/minuta_list.php",
			method:"POST",
			data:{cod_minuta:cod_minuta},
			success:function(data)
			{
				$('#wid-id-0').html(data);
			}
		});
	});

	/*- GERAR MINUTA -*/

	$(document).on('click', '#btnGerarMinuta', function(){
		event.preventDefault();
		if( $('.nr_pedido:checked').length == 0 ){

			alert('Selecione pelo menos um pedido!');

		}else{

			var val = [];

			$('.nr_pedido:checked').each(function(){
				val.push($(this).val());
			});

			$.ajax
			({
				url:'data/movimento/cons_pedido_minuta.php',
				method:'POST',
				//dataType:'json',
				data:{
					nr_pedido:val
				},
				success:function(j)
				{
					if(j=="1"){

						alert("Já existe minuta para os pedidos selecionados!");

					}else{

						$('#retornoExpede').load('data/movimento/modal/m_ins_minuta.php');

					}
				}
			});
		}
	});

	$(document).on('click','#btnSaveMinuta',function(){
		event.preventDefault();
		if(confirm("Tem certeza que deseja gerar romaneio com os pedidos selecionados?")){
			$("#btnSaveMinuta").prop("disabled", true);
			if( $('.checkPedRom:checked').length == 0 ){
				alert('Selecione pelo menos um pedido!');
			}else{

				var dt_minuta 		= $('#dt_minuta').val();
				var hr_minuta 		= $('#hr_minuta').val();
				var nr_placa 		= $('#nr_placa').val();
				var ds_transporte 	= $('#ds_transporte').val();
				var ds_tipo 		= $('#ds_tipo').val();
				var ds_obs 			= $('#ds_obs').val();
				var val 			= [];

				$('.checkPedRom:checked').each(function(){
					val.push($(this).val());
				});

				$.ajax
				({
					url:'data/movimento/ins_romaneio.php',
					method:'POST',
					dataType:'json',
					data:{
						nr_pedido: 		val,
						dt_minuta: 		dt_minuta,
						hr_minuta: 		hr_minuta,
						nr_placa: 		nr_placa,
						ds_transporte: 	ds_transporte,
						ds_tipo: 		ds_tipo,
						ds_obs: 		ds_obs
					},
					success:function(j)
					{
						for (var i = 0; i < j.length; i++) {
							if(j[i].info == "0"){
								alert("Romaneio gerado com sucesso!");
								$('#retInsMinuta').html('<div class="col-sm-6">\
									<span>\
									<h4 style="background-color:#00FF7F"><bold>MINUTA GERADA N.o '+j[i].minuta+'</bold></h4>\
									</span>\
									</div>').show();
								$("#cod_min").val(j[i].minuta);
								$("#btnPrintMinuta").prop("disabled", false);
							}else if(j[i].info == "2"){
								alert("Erro na inclusão do romaneio!");
							}else if(j[i].info == "1"){
								alert("Erro");
							}
						}
					}
				});
			}
			$("#btnSaveMinuta").prop("disabled", false);
		}
		return false;
	});

	$(document).on('click', '#btnFinExp', function(){
		if(confirm("Tem certeza que deseja finalizar a expedição?")){
			var nr_pedido = $(this).val();
			$.ajax
			({
				url:"data/movimento/cons_pedido_minuta.php",
				method:"POST",
				dataType:'json',
				data:{nr_pedido:nr_pedido},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {
						if(j[i].info == "0"){
							alert("Não existe minuta para esse pedido!");
						}else if(j[i].info == "1"){
							$.ajax
							({
								url:"data/movimento/fim_exp.php",
								method:"POST",
								data:{nr_pedido:nr_pedido},
								success:function(data)
								{
									$('#retExp').html(data);
								}
							});
						}
					}
				}
			});
			return false;
		}
	});
});

/* --- Picking por onda -- */

$(document).ready(function(){
	$(document).on('click', '#btnFormListColetaOnda', function(){
		event.preventDefault();
		var listColetaOnda = $('#listColetaOnda').val();
		$.ajax
		({
			url:"data/movimento/list_coleta_onda.php",
			method:"POST",
			data:{listColetaOnda:listColetaOnda},
			beforeSend:function(e){
				$("#infoColetaOnda").html("<img src='css/loading9.gif'>");
			},
			success:function(data)
			{
				$('#infoColetaOnda').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#btnGeraColetaOndaPrd', function(){
		if(confirm("Tem certeza que deseja gerar onda com os pedidos selecionados?")){
			var onda = [];

			$('.checkboxOnda:checked').each(function(){
				onda.push($(this).val());
			});

			if( $('.checkboxOnda:checked').length == 0 ){
				alert('Selecione pelo menos um pedido!');
			}else{
				$.ajax({
					url:"data/movimento/inicia_coleta_onda.php",
					method:"POST",
					data:{
						onda:onda
					},
					success:function(data)
					{
						console.log(data);
					}
				});
			}
		}
		return false;
	});

	$(document).on('click', '#btnFormConsultaOnda', function(){
		event.preventDefault();
		var listOnda = $('#listOnda').val();
		$.ajax
		({
			url:"data/movimento/list_onda.php",
			method:"POST",
			data:{listOnda:listOnda},
			beforeSend:function(e){
				$("#infoOnda").html("<img src='css/loading9.gif'>");
			},
			success:function(data)
			{
				$('#infoOnda').html(data);
			}
		});
		return false;
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnConsDtlOnda', function(){
		event.preventDefault();
		var idOnda = $(this).val();
		$.ajax
		({
			url:"data/movimento/consulta_dtl_onda.php",
			method:"POST",
			dataType:'json',
			data:{idOnda:idOnda},
			beforeSend:function(e){
				$("#aguarde").html("<img src='css/loading9.gif'>");
			},
			success:function(j)
			{
				$("#aguarde").hide();
				for (var i = 0; i < j.length; i++) {
					$('#tarefasOnda').append('<tr class="odd gradeX">\
						<td style="text-align: center">'+j[i].id+'</td>\
						<td style="text-align: right">'+j[i].ds_apelido+'</td>\
						<td style="text-align: right">'+j[i].ds_prateleira+'</td>\
						<td style="text-align: right">'+j[i].nr_qtde_col+'</td>\
						<td style="text-align: center">\
						<button type="submit" class="btn btn-primary btn-xs" id="btnPrintOnda" value="'+j[i].id+'" style="width: 80px">Imprimir</button>\
						<button type="submit" class="btn btn-primary btn-xs" id="btnConsPrdOnda" value="" style="width: 80px">Produtos</button>\
						<button type="submit" class="btn btn-primary btn-xs" id="btnConsPedOnda" value="" style="width: 80px">Pedidos</button>\
						<input type="hidden" id="ds_galpao" value="'+j[i].ds_galpao+'">\
						<input type="hidden" id="ds_prateleira" value="'+j[i].ds_prateleira+'">\
						</td>\
						</tr>');

					$(".consulta_onda").prop("disabled", true);
				}
			}
		});
		return false;
	});

	$(document).on('click', '#btnPrintOnda', function(){
		var nr_onda = $(this).val();
		var ds_galpao = $('#ds_galpao').val();
		var ds_prateleira = $('#ds_prateleira').val();
		$.ajax
		({
			url:"data/movimento/relatorio/picking_list_onda.php",
			method:"POST",
			data:{
				nr_onda:nr_onda,
				ds_galpao:ds_galpao,
				ds_prateleira:ds_prateleira
			},
			success:function(data)
			{
				$('#widget-grid').html(data);
			}
		});
		return false;
	});
});

/* --- Produtos não conforme --- */

$(document).ready(function(){
	$(document).on('click', '#btnListProdutoNc', function(){
		event.preventDefault();
		var consProdutoNc = $('#consProdutoNc').val();
		$.ajax
		({
			url:"data/movimento/list_produto_nc.php",
			method:"POST",
			data:{consProdutoNc:consProdutoNc},
			beforeSend:function(e){
				$("#infoProdutoNc").html("<img src='css/loading9.gif'>");
			},
			success:function(data)
			{
				$('#infoProdutoNc').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#btnInsProdNc', function(){
		event.preventDefault();
		$('#retInsModal').load('data/movimento/modal/m_ins_prd_nc.php');
		return false;
	});

	$(document).on('click', '#btnPesqProdNc', function(){
		event.preventDefault();
		var produtoNc = $('#produtoNc').val();
		var idGalpao = $('#cmbarmaz').val();
		var idRua = $('#cmbrua').val();
		var idColuna = $('#cmbcoluna').val();
		var idAltura = $('#cmbaltura').val();
		$.ajax
		({
			url:"data/movimento/cons_local_prod_nc.php",
			method:"POST",
			dataType:'json',
			data:{
				produtoNc:produtoNc,
				idGalpao:idGalpao,
				idRua:idRua,
				idColuna:idColuna,
				idAltura:idAltura
			},
			beforeSend:function(e){
				$("#retPesqProdNc").html("<img src='css/loading9.gif'>");
			},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {
					if(j[i].produto){
						var options = '<tr>\
						<td id="codProduto" style="text-align: rigth;">' + j[i].produto + '</td>\
						<td style="text-align: rigth;">' + j[i].cod_prod_cliente + '</td>\
						<td style="text-align: left;">' + j[i].nm_produto + '</td>\
						<td style="text-align: rigth;">' + j[i].ds_apelido + j[i].ds_prateleira + j[i].ds_coluna + j[i].ds_altura +'</td>\
						<td id="nr_qtde_old" style="text-align: rigth;">' + j[i].nr_qtde + '</td>\
						<td style="text-align: center;"><input type="text" id="nr_qtde_nc" name="nr_qtde_nc"></td>\
						<input type="hidden" id="codEstoque" value="' + j[i].cod_estoque + '">\
						</tr>';
						$('#retPesqProdNc').html(options);
						$('.produto').show();
					}else{

						alert("Produto não se encontra nessa locação.");
					}
				}
			}
		});
		return false;
	});

	$(document).on('change', '#cmbarmaz_new', function(){
		if( $(this).val() ) {
			$('#cmbrua_new').hide();
			$.getJSON('data/movimento/consulta_rua.php?search=',{id_galpao: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a rua</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
				}
				$('#cmbrua_new').html(options).show();
			});
		} else {
			$('#cmbrua_new').html('<option value="">Escolha a rua</option>');
		}
	});
});
$(document).ready(function(){
	$(document).on('change', '#cmbrua_new', function(){
		if( $(this).val() ) {
			$('#cmbcoluna_new').hide();
			$.getJSON('data/movimento/consulta_coluna.php?search=',{id_rua: $(this).val(), id_galpao: $('#cmbarmaz_new').val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a coluna</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
				}
				$('#cmbcoluna_new').html(options).show();
			});
		} else {
			$('#cmbcoluna_new').html('<option value="">Escolha a coluna</option>');
		}
	});

	$(document).on('change', '#cmbcoluna_new', function(){
		if( $(this).val() ) {
			$('#cmbaltura_new').hide();
			$.getJSON('data/movimento/consulta_altura.php?search=',{id_coluna: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a altura</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].altura + '">'  + j[i].altura + '</option>';
				}
				$('#cmbaltura_new').html(options).show();
			});
		} else {
			$('#cmbaltura_new').html('<option value="">Escolha a altura</option>');
		}
	});

	$(document).on('click', '#btnInsNewPrdNc', function(){
		event.preventDefault();
		var codEstoque = $('#codEstoque').val();
		var nr_qtde_nc = $('#nr_qtde_nc').val();
		var nr_qtde_old = $('#nr_qtde_old').text();
		var codProduto = $('#codProduto').text();
		var idGalpaoNew = $('#cmbarmaz_new').val();
		var idRuaNew = $('#cmbrua_new').val();
		var idColunaNew = $('#cmbcoluna_new').val();
		var idAlturaNew = $('#cmbaltura_new').val();
		var motivoNc = $('#motivoNc').val();

		if(nr_qtde_nc > nr_qtde_old){

			alert("Quantidade a transferir não pode ser maior que a quantidade alocada!");

		}else{

			$.ajax
			({
				url:"data/movimento/upd_prd_nc.php",
				method:"POST",
				dataType:'json',
				data:{
					codEstoque:codEstoque,
					nr_qtde_nc:nr_qtde_nc,
					codProduto:codProduto,
					nr_qtde_old:nr_qtde_old,
					idGalpaoNew:idGalpaoNew,
					idRuaNew:idRuaNew,
					idColunaNew:idColunaNew,
					idAlturaNew:idAlturaNew,
					motivoNc:motivoNc
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {
						if(j[i].info == "0"){
							alert("Produto e quantidade transferida para não-conforme!");
						}else if(j[i].info == "1"){
							alert("Erro na inclusão de produto não conforme!");
						}else if(j[i].info == "3"){
							alert("Erro na inclusão da ocorrência!");
						}
					}
				}
			});

		}
		return false;
	});
});

/* --- Alteração de projetos --- */

$(document).ready(function(){
	$(document).on('click', '#btnUpdProject', function(){
		event.preventDefault();
		$('#btnUpdProject').prop("disabled", true);
		var cod_estoque = $(this).val();
		$.ajax
		({
			url:"data/movimento/modal/m_upd_projeto.php",
			method:"POST",
			data:{cod_estoque:cod_estoque},
			success:function(data)
			{
				$('#retornoLocais').html(data);
				$('#btnUpdProject').prop("disabled", false);
			}
		});
		return false;
	});

	$(document).on('click', '#btnSaveNewProject', function(){
		event.preventDefault();
		$('#btnSaveNewProject').prop("disabled", true);
		var new_project = $('#new_project').val();
		var cod_estoque_proj = $('#cod_estoque_proj').val();
		$.ajax
		({
			url:"data/movimento/upd_projeto.php",
			method:"POST",
			dataType:'json',
			data:{
				new_project:new_project,
				cod_estoque_proj:cod_estoque_proj
			},
			success:function(j)
			{
				for(var i=0;i < j.length;i++)
				{
					var info = j[i].info;
					if(info == "0"){

						alert("Projeto alterado com sucesso!");

					}else{

						alert("Erro! Entre em contato com o suporte.");

					}
				}
				$('#btnSaveNewProject').prop("disabled", false);
			}
		});
		return false;
	});
});

/* --- Exclusão de projetos --- */
$(document).ready(function(){
	$(document).on('click', '#btnDelProject', function(){
		event.preventDefault();
		$('#btnDelProject').prop("disabled", true);
		var cod_estoque = $(this).val();
		$.ajax
		({
			url:"data/movimento/modal/m_del_projeto.php",
			method:"POST",
			data:{cod_estoque:cod_estoque},
			success:function(data)
			{
				$('#retornoLocais').html(data);
				$('#btnDelProject').prop("disabled", false);
			}
		});
		return false;
	});

	$(document).on('click', '#btnSaveDelProject', function(){
		event.preventDefault();
		$('#btnSaveDelProject').prop("disabled", true);
		var cod_estoque_proj = $(this).val();
		$.ajax
		({
			url:"data/movimento/del_projeto.php",
			method:"POST",
			dataType:'json',
			data:{
				cod_estoque_proj:cod_estoque_proj
			},
			success:function(j)
			{
				for(var i=0;i < j.length;i++)
				{
					var info = j[i].info;
					if(info == "0"){

						alert("Projeto deletado com sucesso!");

					}else{

						alert("Erro! Entre em contato com o suporte.");

					}
				}
				$('#btnSaveDelProject').prop("disabled", false);
			}
		});
		return false;
	});
});
/* --- Cadastro de instruções de entrega --- */
$(document).ready(function(){
	$(document).on('click', '#btnInsInstrucao', function(){
		event.preventDefault();
		$('#btnInsInstrucao').prop("disabled", true);
		var cod_cliente = $(this).val();
		$.ajax
		({
			url:"data/entidade/modal/m_ins_instrucao.php",
			method:"POST",
			data:{cod_cliente:cod_cliente},
			success:function(data)
			{
				$('#retorno').html(data);
				$('#btnInsInstrucao').prop("disabled", false);
			}
		});
		return false;
	});

	$(document).on('click', '#btnInsInst', function(){
		event.preventDefault();
		$('#btnInsInst').prop("disabled", true);
		var nr_pedido = $(this).val();
		$.ajax
		({
			url:"data/movimento/modal/m_ins_instrucao_pedido.php",
			method:"POST",
			data:{nr_pedido:nr_pedido},
			success:function(data)
			{
				$('#retorno').html(data);
				$('#btnInsInst').prop("disabled", false);
			}
		});
		return false;
	});

	$(document).on('click', '#btnSaveInstrucao', function(){
		event.preventDefault();
		$('#btnSaveInstrucao').prop("disabled", true);
		var cliente = $('#id_cliente').val();
		var destinatario = $('#id_destinatario').val();
		var instrucao = $('#ds_instrucao').val();
		$.ajax
		({
			url:"data/entidade/ins_instrucao.php",
			method:"POST",
			dataType:'json',
			data:{
				cliente:cliente,
				destinatario:destinatario,
				instrucao:instrucao
			},
			success:function(j)
			{
				for(var i=0;i < j.length;i++)
				{
					var info = j[i].info;
					if(info == "0"){

						alert("Instrução cadastrada com sucesso!");

					}else{

						alert("Erro! Entre em contato com o suporte.");

					}
				}
				$('#btnSaveInstrucao').prop("disabled", false);
			}
		});
		return false;
	});

	$(document).on('click', '#btnSaveInst', function(){
		event.preventDefault();
		$('#btnSaveInst').prop("disabled", true);
		var cliente = $('#id_cliente').val();
		var destinatario = $('#id_destinatario').val();
		var instrucao = $('#ds_instrucao').val();
		var pedido = $('#nr_pedido').val();
		$.ajax
		({
			url:"data/entidade/ins_instrucao.php",
			method:"POST",
			dataType:'json',
			data:{
				cliente:cliente,
				destinatario:destinatario,
				instrucao:instrucao,
				pedido:pedido
			},
			success:function(j)
			{
				for(var i=0;i < j.length;i++)
				{
					var info = j[i].info;
					if(info == "0"){

						alert("Instrução cadastrada com sucesso!");

					}else{

						alert("Erro! Entre em contato com o suporte.");

					}
				}
				$('#btnSaveInst').prop("disabled", false);
			}
		});
		return false;
	});
});

/* --- MINUTAS --- */
$(document).ready(function(){
	$(document).on('click', '#btnConsMin', function(){
		event.preventDefault();
		var minuta = $(this).val();
		$.ajax
		({
			url:"data/movimento/minuta_list.php",
			method:"POST",
			data:{minuta:minuta},
			success:function(data)
			{
				$('#info').html(data);
			}
		});
		return false;
	});
});

/* --- CONTRATO --- */
$(document).ready(function(){
	$(document).on('click','#btnInsContrato',function(){
		event.preventDefault();
		$('#btnInsContrato').prop("disabled", true);
		$('#info_contrato').load("data/contrato/modal/m_ins_contrato.php");
		$('#btnInsContrato').prop("disabled", false);
	});

	$(document).on('click','#btnSaveContrato',function(){
		event.preventDefault();
		$('#btnSaveContrato').prop("disabled", true);
		var id_cliente = $('#id_cliente').val();
		var ds_descricao = $('#ds_descricao').val();
		var dt_aprova = $('#dt_aprova').val();
		var ds_manuseio = $('#ds_manuseio').val();
		var vlr_mov = $('#vlr_mov').val();
		var nr_franquia_mov = $('#nr_franquia_mov').val();
		var dt_vencto = $('#dt_vencto').val();
		$.ajax
		({
			url:"data/contrato/ins_contrato.php",
			method:"POST",
			dataType:'json',
			data:{
				id_cliente:id_cliente,
				ds_descricao:ds_descricao,
				dt_aprova:dt_aprova,
				ds_manuseio:ds_manuseio,
				vlr_mov:vlr_mov,
				nr_franquia_mov:nr_franquia_mov,
				dt_vencto:dt_vencto
			},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {
					if(j[i].info == 0){
						alert("Contrato cadastrado com sucesso!");
					}else{
						alert("Erro no cadastro!");
					}
				}
				$('#btnSaveContrato').prop("disabled", false);
			}
		});
		return false;
	});

	$(document).on('click','#btnPesqContrato',function(){
		event.preventDefault();
		$('#btnPesqContrato').prop("disabled", true);
		var cnpj = $('#cnpj').val();
		var rSocial = $('#rSocial').val();
		$.ajax
		({
			url:"data/contrato/list_contrato.php",
			method:"POST",
			data:{
				cnpj:cnpj,
				rSocial:rSocial
			},
			success:function(data)
			{
				$('#retorno').html(data);
				$('#btnPesqContrato').prop("disabled", false);
			}
		});
		return false;
	});

	$(document).on('change', '#cod_cliente', function(){
		if( $(this).val() ) {
			$('#id_contrato').hide();
			$.getJSON('data/movimento/consulta_contrato.php?search=',{cod_cliente: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">Contrato</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id + '">' + j[i].ds_descricao + '</option>';
				}
				$('#id_contrato').html(options).show();
			});
		} else {
			$('#id_contrato').html('<option value="">Contrato</option>');
		}
	});
});

/* --- MANUSEIO --- */
$(document).ready(function(){
	$(document).on('click','#btnFormListManuseio',function(){
		event.preventDefault();
		$('#btnFormListManuseio').prop("disabled", true);
		var listManuseio = $('#listManuseio').val();
		$.ajax
		({
			url:"data/movimento/list_manuseio.php",
			method:"POST",
			data:{
				listManuseio:listManuseio
			},
			success:function(data)
			{
				$('#infoManuseio').html(data);
				$('#btnFormListManuseio').prop("disabled", false);
			}
		});
		return false;
	});

	$(document).on('click','#btnStartMan',function(){
		event.preventDefault();
		$('#btnStartMan').prop("disabled", true);
		var nr_pedido = $(this).val();
		var produto = $('#produto').text();
		var nr_qtde = $('#nr_qtde').text();
		$.getJSON('data/movimento/consulta_status_man.php?search=',{nr_pedido:nr_pedido, ajax: 'true'}, function(k){
			for (var i = 0; i < k.length; i++) {
				if(k[i].info == "0"){

					alert("Pedido com reembalagem já iniciada.");

				}else{

					$.ajax
					({
						url:"data/movimento/modal/m_inicia_manuseio.php",
						method:"POST",
						data:{
							nr_pedido:nr_pedido,
							produto:produto,
							nr_qtde:nr_qtde
						},
						success:function(data)
						{
							$('#retManuseio').html(data);
						}
					});
				}
			}
		});
		$('#btnStartMan').prop("disabled", false);
		return false;
	});

	$(document).on('click','#btnInitManuseio',function(){
		event.preventDefault();
		$('#btnInitManuseio').prop("disabled", true);
		if(confirm("Tem certeza que deseja gerar reembalagem?")){
			var nr_pedido = $('#nr_pedido').val();
			var nr_qtde_emb = $('#nr_qtde_emb').val();
			var id_embalagem = $('#id_embalagem').val();
			var produto = $('#produto').text();
			var nr_qtde = $('#nr_qtde').text();
			if(nr_qtde_emb == "" || id_embalagem == ""){
				alert("Por favor preencha todos os campos.");
			}else{
				$.ajax
				({
					url:"data/movimento/inicia_manuseio.php",
					method:"POST",
					dataType:'json',
					data:{
						nr_pedido:nr_pedido,
						nr_qtde_emb:nr_qtde_emb,
						id_embalagem:id_embalagem,
						produto:produto,
						nr_qtde:nr_qtde
					},
					success:function(j)
					{
						for(var i=0;i < j.length;i++){
							$('#retInsManuseio').append('<tr>\
								<td>' + j[i].id + '</td>\
								<td>' + j[i].nr_pedido + '</td>\
								<td>' + j[i].produto + '</td>\
								<td>' + j[i].ds_tipo + '</td>\
								<td style="text-align: right;">' + j[i].qtd_vol + '</td>\
								<td style="text-align: right;">' + j[i].total + '</td>\
								</tr>\
								');
						}
					}
				});
			}
		}
		$('#btnInitManuseio').prop("disabled", false);
		return false;
	});

	$(document).on('click','#btnPrintMan',function(){
		event.preventDefault();
		$('#btnPrintMan').prop("disabled", true);
		var nr_pedido = $(this).val();
		$.getJSON('data/movimento/consulta_status_man.php?search=',{nr_pedido:nr_pedido, ajax: 'true'}, function(k){
			for (var i = 0; i < k.length; i++) {
				if(k[i].info == "0"){

					$.ajax
					({
						url:"data/movimento/relatorio/packing_list.php",
						method:"POST",
						data:{
							nr_pedido:nr_pedido
						},
						success:function(data)
						{
							$('#infoManuseio').html(data);
						}
					});

				}else{

					alert("Inicie a reembalagem antes de imprimir.");
				}
			}
		});
		$('#btnPrintMan').prop("disabled", false);
		return false;
	});

	$(document).on('click','#btnPrintManEtq',function(){
		event.preventDefault();
		$('#btnPrintManEtq').prop("disabled", true);
		var nr_pedido = $(this).val();
		$.getJSON('data/movimento/consulta_status_man.php?search=',{nr_pedido:nr_pedido, ajax: 'true'}, function(k){
			for (var i = 0; i < k.length; i++) {
				if(k[i].info == "0"){

					$.ajax
					({
						url:"data/movimento/modal/m_list_etq_emb.php",
						method:"POST",
						data:{
							nr_pedido:nr_pedido
						},
						success:function(data)
						{
							$('#MretornoEtq').html(data);
						}
					});

				}else{

					alert("Inicie a reembalagem antes de imprimir.");
				}
			}
		});
		$('#btnPrintManEtq').prop("disabled", false);
		return false;
	});
});

/* --- EMBALAGEM --- */
$(document).ready(function(){
	$(document).on('click','#btnFormListEmbalagem',function(){
		event.preventDefault();
		$('#btnFormListEmbalagem').prop("disabled", true);
		var listEmbalagem = $('#listEmbalagem').val();
		$.ajax
		({
			url:"data/produto/list_embalagem.php",
			method:"POST",
			data:{
				listEmbalagem:listEmbalagem
			},
			success:function(data)
			{
				$('#infoEmbalagem').html(data);
			}
		});
		$('#btnFormListEmbalagem').prop("disabled", false);
		return false;
	});

	$(document).on('click','#btnNovaEmbalagem',function(){
		event.preventDefault();
		$('#btnNovaEmbalagem').prop("disabled", true);
		$('#retEmbalagem').load("data/produto/modal/m_ins_embalagem.php");
		$('#btnNovaEmbalagem').prop("disabled", false);
	});

	$(document).on('change', '#id_cliente_emb', function(){
		if( $(this).val() ) {
			$('#id_contrato_emb').hide();
			$.getJSON('data/movimento/consulta_contrato.php?search=',{cod_cliente: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">Contrato</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id + '">' + j[i].ds_descricao + '</option>';
				}
				$('#id_contrato_emb').html(options).show();
			});
		} else {
			$('#id_contrato_emb').html('<option value="">Contrato</option>');
		}
	});

	$(document).on('click','#btnSaveEmbalagem',function(){
		event.preventDefault();
		$('#btnSaveEmbalagem').prop("disabled", true);
		var id_cliente_emb = $('#id_cliente_emb').val();
		var id_contrato_emb = $('#id_contrato_emb').val();
		var ds_descricao = $('#ds_descricao').val();
		var nr_cubado = $('#nr_cubado').val();
		var nr_peso = $('#nr_peso').val();
		var nr_comprimento = $('#nr_comprimento').val();
		var nr_largura = $('#nr_largura').val();
		var nr_altura = $('#nr_altura').val();
		$.ajax
		({
			url:"data/produto/ins_embalagem.php",
			method:"POST",
			dataType:'json',
			data:{
				id_cliente_emb:id_cliente_emb,
				id_contrato_emb:id_contrato_emb,
				ds_descricao:ds_descricao,
				nr_cubado:nr_cubado,
				nr_peso:nr_peso,
				nr_comprimento:nr_comprimento,
				nr_largura:nr_largura,
				nr_altura:nr_altura
			},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {
					if(j[i].info == 0){
						alert("Embalagem cadastrada com sucesso!");
					}else{
						alert("Erro no cadastro!");
					}
				}
			}
		});
		$('#btnSaveEmbalagem').prop("disabled", false);
		return false;
	});
});

/* --- CONSULTAS --- */
$(document).ready(function(){
	$(document).on('click','#btnPesquisaPedido',function(){
		event.preventDefault();
		$('#btnPesquisaPedido').prop("disabled", true);
		var nr_pedido = $('#nr_pedido').val();
		var statusA = $('#PesqStatusAberto:checked').val();
		var statusC = $('#PesqStatusColeta:checked').val();
		var statusE = $('#PesqStatusExpede:checked').val();

		if(nr_pedido != '' && $('PesqStatusAberto').prop("checked")){

			alert("Se pesquisar o pedido, não selecione o status.");

		}else{

			$.ajax
			({
				url:'data/movimento/pedido_status.php',
				method:'POST',
				data:{
					statusA:statusA,
					statusC:statusC,
					statusE:statusE,
					nr_pedido:nr_pedido
				},
				success:function(data){
					$('#retornoPed').html(data);
				}
			});

		}
		$('#btnPesquisaPedido').prop("disabled", false);
		return false;
	});
/*
	$(document).on('click','#btnPesquisaPedido',function(){
		event.preventDefault();
       	$('#btnPesquisaPedido').prop("disabled", true);
	    var nr_pedido = $('#nr_pedido').val();
	    $.ajax
	    ({
	        url:"data/movimento/pedido_sql.php",
	        method:"POST",
	        data:{
	           	nr_pedido:nr_pedido
	        },
	        success:function(data)
	        {
	        	$('#info_pedidos').html(data);
	        }
	    });
	    $('#btnPesquisaPedido').prop("disabled", false);
	    return false;
	});
	*/
});

$(document).ready(function(){
	$(document).on('click', '#btnQuebraCol', function(){
		event.preventDefault();
		var quebra_col= $(this).val();
		$.ajax
		({
			url:"data/movimento/modal/m_ins_quebra.php",
			method:"POST",
			//dataType:'json',
			data:{
				quebra_col:quebra_col
			},
			success:function(data)
			{
				$('#retPicking').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#btnInsQuebraPrdPed', function(){
		event.preventDefault();
		var cod_col= $(this).val();
		$.ajax
		({
			url:"data/movimento/modal/m_ins_quebra_prd.php",
			method:"POST",
			//dataType:'json',
			data:{
				cod_col:cod_col
			},
			success:function(j)
			{
				$('#retUpdEnd').html(j);
			}
		});
		return false;
	});

	$(document).on('click', '#btnQuebraSave', function(){
		$('#btnQuebraSave').prop("disabled", true);
		if(confirm("Tem certeza que deseja registrar quebra de estoque?")){
			event.preventDefault();
			var cod_estoque= $('#cod_estoque').val();
			var nr_new_qtde= $('#nr_new_qtde').val();
			var cod_col= $('#cod_col').val();
			var id_pedido= $('#id_pedido').val();
			var cod_prod= $('#cod_prod').val();
			$.ajax
			({
				url:"data/movimento/consulta_status_quebra.php",
				method:"POST",
				dataType:'json',
				data:{
					nr_pedido:id_pedido
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {
						if(j[i].info == 0){
							$.ajax
							({
								url:"data/movimento/quebra_pedido.php",
								method:"POST",
								dataType:'json',
								data:{
									cod_col:cod_col,
									cod_estoque:cod_estoque,
									nr_new_qtde:nr_new_qtde,
									id_pedido:id_pedido,
									cod_prod:cod_prod
								},
								success:function(k)
								{
									for (var i = 0; i < k.length; i++) {
										if(k[i].info == 0){

											alert("Quebra de estoque registrada. Uma ocorrência foi gerada automaticamente!");

										}else{

											alert("Ocorreu um erro! Entre em contato com o suporte.");

										}
									}
								}
							});
						}else{

							alert("Só é possível informar quebra de pedidos com coleta iniciada!");
						}
					}
					$('#btnQuebraSave').prop("disabled", false);
				}
			});
		}
		return false;
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnAtivaInv', function(){
		$('#btnAtivaInv').prop("disabled", true);
		if(confirm("Tem certeza que deseja ativar o inventário?")){
			event.preventDefault();
			var cod_inv= $(this).val();
			$.getJSON('data/inventario/consulta_status_inv.php?search=',{cod_inv:cod_inv,ajax: 'true'}, function(j){

				for (var i = 0; i < j.length; i++) {

					if(j[i].info == 1){

						alert("Somente inventários com status AGENDADO podem ser iniciados.");

					}else{

						$.getJSON('data/inventario/consulta_pedido.php?search=',{cod_inv:cod_inv,ajax: 'true'}, function(l){

							for (var i = 0; i < l.length; i++) {

								if(l[i].info == 0){

									alert("Existem pedidos em aberto para essas posições ou produtos.");

								}else{

									$.ajax
									({
										url:"data/inventario/ativa_inventario.php",
										method:"POST",
										dataType:'json',
										data:{
											cod_inv:cod_inv
										},
										success:function(k)
										{
											for (var i = 0; i < k.length; i++) {
												if(k[i].info == 0){

													alert("Inventário ativado. A partir de agora não poderão ser gerados produtos para os endereços ou produtos selecionados!");

												}else{

													alert("Ocorreu um erro! Entre em contato com o suporte.");

												}
											}
										}
									});
								}
							}
						});
					}
				}
			});
		}
		$('#btnAtivaInv').prop("disabled", false);
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnGeraTarefa', function(){
		$('#btnGeraTarefa').prop("disabled", true);
		event.preventDefault();
		var nr_inv= $(this).val();
		$.getJSON('data/inventario/consulta_tarefa.php?search=',{nr_inv:nr_inv,ajax: 'true'}, function(j){
			for (var i = 0; i < j.length; i++) {

				if(j[i].info == 0){

					alert("Já existem tarefas para este inventário!");

				}else{

					$.ajax
					({
						url:"data/inventario/gera_tarefa.php",
						method:"POST",
						dataType:'json',
						data:{
							nr_inv:nr_inv
						},
						beforeSend:function(s)
						{
							$("#retorno_2").html("<img src='css/loading9.gif'>");
						},
						success:function(j)
						{
							if(j[i].info == 0){

								alert("Tarefas geradas com sucesso!");

							}else{

								alert("Erro! Contate o suporte.");

							}
						}
					});
				}
			}
		});
		$('#btnGeraTarefa').prop("disabled", false);
		return false;
	});$(document).on('change', '#selInvTar', function(){
		if( $(this).val() ) {
			$('#selRuaInvTar').hide();
			$.getJSON('data/inventario/consulta_rua.php?search=',{id_inv: $(this).val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a rua</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id_rua + '">'  + j[i].id_rua + '</option>';
				}
				$('#selRuaInvTar').html(options).show();
			});
		} else {
			$('#selRuaInvTar').html('<option value="">Escolha a rua</option>');
		}
	});

	$(document).on('change', '#selRuaInvTar', function(){
		if( $(this).val() ) {
			$('#selColInvTar').hide();
			$.getJSON('data/inventario/consulta_coluna.php?search=',{id_inv: $('#selInvTar').val(),id_rua: $(this).val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a coluna</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id_coluna + '">'  + j[i].id_coluna + '</option>';
				}
				$('#selColInvTar').html(options).show();
			});
		} else {
			$('#selColInvTar').html('<option value="">Escolha a coluna</option>');
		}
	});

	$(document).on('change', '#selColInvTar', function(){
		if( $(this).val() ) {
			$('#selAltInvTar').hide();
			$.getJSON('data/inventario/consulta_altura_tar.php?search=',{id_inv: $('#selInvTar').val(),id_rua: $('#selRuaInvTar').val(),id_col: $(this).val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a altura</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id_altura + '">'  + j[i].id_altura + '</option>';
				}
				$('#selAltInvTar').html(options).show();
			});
		} else {
			$('#selAltInvTar').html('<option value="">Escolha a altura</option>');
		}
	});

	$(document).on('click', '#btnPrintTarInv', function(){
		event.preventDefault();
		$('#btnPrintTarInv').prop("disabled", true);
		var id_inv = $('#selInv').val();
		var id_rua = $('#selRuaInv').val();
		var id_col = $('#selColInvTar').val();
		var id_alt = $('#selAltInvTar').val();
		if(id_inv == "" || id_rua == "" || id_col == "" || id_alt == ""){

			alert("Por favor selecione todos os campos!");

		}else{

			$.ajax
			({
				url:"data/inventario/relatorio/tarefas_list.php",
				method:"POST",
				data:{
					id_inv:id_inv,
					id_rua:id_rua,
					id_col:id_col,
					id_alt:id_alt
				},
				success:function(data)
				{
					$('#infoTarefas').html(data);
				}
			});

		}
		$('#btnPrintTarInv').prop("disabled", false);
		return false;
	});
});

/* --- TRANSFERÊNCIA DE TORRES --- */

$(document).ready(function(){

	$(document).on('change', '#selGalpaoTorre', function(){
		if( $(this).val() ) {
			$('#selRuaTorre').hide();
			$.getJSON('data/movimento/consulta_rua.php?search=',{id_galpao: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a rua</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
				}
				$('#selRuaTorre').html(options).show();
			});
		} else {
			$('#selRuaTorre').html('<option value="">Escolha a rua</option>');
		}
	});

	$(document).on('change', '#selRuaTorre', function(){
		if( $(this).val() ) {
			$('#selModTorre').hide();
			$.getJSON('data/movimento/consulta_modulo.php?search=',{id_rua: $(this).val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha o módulo</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
				}
				$('#selModTorre').html(options).show();
			});
		} else {
			$('#selModTorre').html('<option value="">Escolha o módulo</option>');
		}
	});

	$(document).on('change', '#selRuaTorreFx', function(){
		if( $(this).val() ) {
			$('#selModTorreFx').hide();
			$.getJSON('data/movimento/consulta_modulo.php?search=',{id_rua: $(this).val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha o módulo</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
				}
				$('#selModTorreFx').html(options).show();
			});
		} else {
			$('#selModTorreFx').html('<option value="">Escolha o módulo</option>');
		}
	});

	$(document).on('change', '#selModTorre', function(){
		if( $(this).val() ) {
			$('#selFeixe').hide();
			$.getJSON('data/movimento/consulta_feixe.php?search=',{id_modulo: $(this).val(),id_rua: $('#selRuaTorre').val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha o feixe</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].ds_embalagem + '">'  + j[i].ds_embalagem + '</option>';
				}
				$('#selFeixe').html(options).show();
			});
		} else {
			$('#selFeixe').html('<option value="">Escolha o feixe</option>');
		}
	});

	$(document).on('change', '#selModTorreFx', function(){
		if( $(this).val() ) {
			$('#selFeixeFx').hide();
			$.getJSON('data/movimento/consulta_feixe_fx.php?search=',{id_modulo: $(this).val(),id_rua: $('#selRuaTorreFx').val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha o feixe</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option class="data" value="' + j[i].ds_embalagem + '" data-torre="'+ j[i].id_torre +'" data-parte="'+ j[i].id_parte +'">'  + j[i].ds_embalagem +" | "+ j[i].id_torre +" - "+ j[i].ds_torre +" - "+ j[i].ds_tensao +" - "+ j[i].ds_circuito +" - "+ j[i].ds_tipo +" | "+ j[i].id_parte +" - "+ j[i].parte + '</option>';
				}
				$('#selFeixeFx').html(options).show();
			});
		} else {
			$('#selFeixeFx').html('<option value="">Escolha o feixe</option>');
		}
	});

	$(document).on('click', '#btnListProdTorre', function(){
		event.preventDefault();
		var selRuaTorre = $('#selRuaTorre').val();
		var selModTorre = $('#selModTorre').val();
		var selFeixe = $('#selFeixe').val();
		if($('#selRuaTorre').val() == ''){

			alert("Selecione a rua.");

		}else{

			$.ajax
			({
				url:"data/movimento/mov_list_torre_sql.php",
				method:"POST",
				data:{
					selRuaTorre:selRuaTorre,
					selModTorre:selModTorre,
					selFeixe:selFeixe
				},
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				},
				success:function(data){

					$('#info_produtos').html(data);
				}
			});
		}
		return false;
	});

	$(document).on('click', '#btnMovTorreDestino', function(){
		event.preventDefault();
		var cod_estoque = $(this).val();
		var nr_qtde = $('#nr_qtde').val();
		$.ajax({
			url:"data/movimento/modal/m_mov_torre_destino.php",
			method:"POST",
			data:{cod_estoque:cod_estoque, nr_qtde:nr_qtde},
			success:function(data)
			{
				$('#retMovimenta').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#btnMovTorre', function(){
		event.preventDefault();
		if(confirm("Tem certeza que deseja transferir essa quantidade?")){
			$('#btnMovTorre').prop("disabled", true);
			var cod_estoque = $('#cod_estoque').val();
			var nr_qtde = $('#nr_qtde_new').val();
			var nr_qtde_old = $('#nr_qtde_old').val();
			var ds_galpao = $('#cmbarmaz').val();
			var ds_rua = $('#cmbrua').val();
			var ds_coluna = $('#cmbcoluna').val();
			var ds_altura = $('#cmbaltura').val();
			var id_aval = $('#id_aval').val();
			var ds_projeto = $('#ds_projeto').val();
			var ds_embalagem = $('#ds_embalagem').val();
			var ds_projeto_new = $('#ds_projeto_new').val();
			var ds_embalagem_new = $('#ds_embalagem_new').val();
			var cod_produto = $('#cod_produto').val();
			var nr_nf_entrada = $('#nr_nf_entrada').val();
			var id_tar = $('#id_tar').val();

			if(nr_qtde == ''){

				alert("Digite a quantidade a transferir!");

			}else{

				$.ajax
				({
					url:"data/movimento/transf_torre.php",
					method:"POST",
					dataType:'json',
					data:{
						cod_estoque:cod_estoque,
						nr_qtde:nr_qtde,
						nr_qtde_old:nr_qtde_old,
						ds_galpao:ds_galpao,
						ds_rua:ds_rua,
						ds_coluna:ds_coluna,
						ds_altura:ds_altura,
						id_aval:id_aval,
						ds_projeto:ds_projeto,
						ds_embalagem:ds_embalagem,
						ds_projeto_new:ds_projeto_new,
						ds_embalagem_new:ds_embalagem_new,
						cod_produto:cod_produto,
						nr_nf_entrada:nr_nf_entrada,
						id_tar:id_tar
					},
					success:function(j)
					{
						for (var i = 0; i < j.length; i++) {

							if(j[i].info == "1"){

								alert("Ocorreu um erro na alocação. Por favor verifique se todos os campos foram preenchidos e se a quantidade solicitada na alocação.");

							}else if(j[i].info == "0"){

								alert("Alocação realizada com sucesso!");
								$('#reg_table').load("data/movimento/modal/list_aloc_modal.php?search=" ,{id_galpao: $(this).val()});

							}else if(j[i].info == "2"){

								alert("A quantidade a transferir não pode ser maior que a quantidade original.");

							}else if(j[i].info == "4"){

								alert("Existe reserva para esse produto e posição! Faça a transferência somente após finalizar o pedido.");

							}
						}
					}
				});
			}
		}
		$('#btnMovTorre').prop("disabled", false);
		return false;
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnMovFeixe', function(){
		event.preventDefault();
		if(confirm("Tem certeza que deseja transferir essa quantidade?")){
			$('#btnMovFeixe').prop("disabled", true);
			var feixe_rua 		= $('#feixe_rua').val();
			var feixe_mod 		= $('#feixe_mod').val();
			var id_feixe 		= $('#id_feixe').val();
			var ds_galpao 		= $('#cmbarmaz').val();
			var ds_rua 			= $('#cmbrua').val();
			var ds_coluna 		= $('#cmbcoluna').val();
			var ds_altura 		= $('#cmbaltura').val();
			var torre_feixe 	= $('#torre_feixe').val();
			var parte_feixe 	= $('#parte_feixe').val();

			$.ajax
			({
				url:"data/movimento/transf_feixe.php",
				method:"POST",
				dataType:'json',
				data:
				{
					feixe_rua:feixe_rua,
					feixe_mod:feixe_mod,
					id_feixe:id_feixe,
					ds_galpao:ds_galpao,
					ds_rua:ds_rua,
					ds_coluna:ds_coluna,
					ds_altura:ds_altura,
					torre_feixe:torre_feixe,
					parte_feixe:parte_feixe
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {

						if(j[i].info == "1"){

							alert("Ocorreu um erro na alocação. Por favor verifique se todos os campos foram preenchidos e se a quantidade solicitada na alocação.");

						}else if(j[i].info == "0"){

							alert("Alocação realizada com sucesso!");

						}else if(j[i].info == "2"){

							alert("Ocorreu um erro na alocação.");

						}
					}
				}
			});
		}
		$('#btnMovFeixe').prop("disabled", false);
		return false;
	});

	$(document).on('click', '#btnListProdFeixe', function(){
		event.preventDefault();
		var selRuaFeixe = $('#selRuaTorreFx').val();
		var selModFeixe = $('#selModTorreFx').val();
		var selFeixe = $('#selFeixeFx').val();
		var id_torre_fx = $('#selFeixeFx').find(':selected').attr('data-torre');
		var id_parte_fx = $('#selFeixeFx').find(':selected').attr('data-parte');
		if($('#selRuaTorreFx').val() == ''){

			alert("Selecione a rua.");

		}else{

			$.ajax
			({
				url:"data/movimento/mov_list_feixe_sql.php",
				method:"POST",
				data:{
					selRuaFeixe:selRuaFeixe,
					selModFeixe:selModFeixe,
					selFeixe:selFeixe,
					id_torre_fx:id_torre_fx,
					id_parte_fx:id_parte_fx
				},
				beforeSend:function(e){
					$("#info_produtos").html("<img src='css/loading9.gif'>");
				},
				success:function(data){

					$('#info_produtos').html(data);
				}
			});
		}
		return false;
	});

	$(document).on('click', '#btnMovFeixeDestino', function(){
		event.preventDefault();
		var feixe_rua 	= $('#feixe_rua').val();
		var feixe_mod 	= $('#feixe_mod').val();
		var id_feixe 	= $('#id_feixe').val();
		var torre_fx 	= $('#torre_fx').val();
		var parte_fx 	= $('#parte_fx').val();
		$.ajax
		({
			url:"data/movimento/modal/m_mov_feixe_destino.php",
			method:"POST",
			data:
			{
				feixe_rua:feixe_rua,
				feixe_mod:feixe_mod,
				id_feixe:id_feixe,
				torre_fx:torre_fx,
				parte_fx:parte_fx
			},
			success:function(data)
			{
				$('#retMovimenta').html(data);
			}
		});
		return false;
	});
});

$(document).ready(function(){
	$(document).on('change', '#galpao_upd', function(){
		if( $(this).val() ) {
			$('#rua_upd').hide();
			$.getJSON('data/movimento/consulta_rua_upd.php?search=',{id_galpao: $(this).val(), cod_prod: $('#cod_prod').val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a rua</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
				}
				$('#rua_upd').html(options).show();
			});
		} else {
			$('#rua_upd').html('<option value="">Escolha a rua</option>');
		}
	});

	$(document).on('change', '#rua_upd', function(){
		if( $(this).val() ) {
			$('#coluna_upd').hide();
			$.getJSON('data/movimento/consulta_coluna_upd.php?search=',{id_rua: $(this).val(), id_galpao: $('#galpao_upd').val(),cod_prod: $('#cod_prod').val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a coluna</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
				}
				$('#coluna_upd').html(options).show();
			});
		} else {
			$('#coluna_upd').html('<option value="">Escolha a coluna</option>');
		}
	});

	$(document).on('change', '#coluna_upd', function(){
		if( $(this).val() ) {
			$('#altura_upd').hide();
			$.getJSON('data/movimento/consulta_altura_upd.php?search=',{id_coluna: $(this).val(), cod_prod: $('#cod_prod').val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a altura</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].altura + '">'  + j[i].altura + '</option>';
				}
				$('#altura_upd').html(options).show();
			});
		} else {
			$('#altura_upd').html('<option value="">Escolha a altura</option>');
		}
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnApSaldoMensal', function(){
		event.preventDefault();
		$('#relatorio').load('data/gerenciamento/mensal.php');
	});

	$(document).on('click', '#btnConsApMensal', function(){
		event.preventDefault();
		var selMesAp = $('#selMesAp').val();
		$.ajax({
			url:"data/movimento/list_apuracao.php",
			method:"POST",
			data:{selMesAp:selMesAp},
			success:function(data)
			{
				$('#retAp').html(data);
			}
		});
		return false;
	});
});

/* --- NOVA CONSULTA HISTÓRICO DE INVENTÁRIO --- */

$(document).ready(function(){
	$(document).on('change', '#SelHistInv', function(){
		if( $(this).val() ) {
			$('#SelInvRua').hide();
			$.getJSON('data/inventario/consulta_rua_hist.php?search=',{id_inv: $(this).val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a rua</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id_rua + '">' + j[i].id_rua + '</option>';
				}
				$('#SelInvRua').html(options).show();
			});
		} else {
			$('#SelInvRua').html('<option value="">Escolha a rua</option>');
		}
	});

	$(document).on('change', '#SelInvRua', function(){
		if( $(this).val() ) {
			$('#SelInvColuna').hide();
			$.getJSON('data/inventario/consulta_coluna_hist.php?search=',{id_rua: $(this).val(),id_inv: $('#SelHistInv').val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a coluna</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id_coluna + '">' + j[i].id_coluna + '</option>';
				}
				$('#SelInvColuna').html(options).show();
			});
		} else {
			$('#SelInvColuna').html('<option value="">Escolha a coluna</option>');
		}
	});
});

/* --- FECHAMENTO DE INVENTÁRIO --- */

$(document).ready(function(){
	$(document).on('click', '#btnEncTarDia', function(){
		$('#invTar').load('data/inventario/modal/m_enc_tar_dia.php');
	});

	$(document).on('change', '#id_inv_enc', function(){
		if( $(this).val() ) {
			$('#confirma').hide();
			$('#encerra').hide();
			$.getJSON('data/inventario/consulta_status_enc.php?search=',{id_inv: $(this).val(), ajax: 'true'}, function(j){
				for (var i = 0; i < j.length; i++) {

					if(j[i].info != 0){

						$('#retEncTar').append('<tr>\
							<th scope="row">'+ j[i].dia +'</th>\
							<td style="text-align:right">'+ j[i].tarefas +'</td>\
							</tr>\
							');

						$('#confirma').show();

					}else{

						$('#encerra').html('<h1>Não existem tarefas pendentes! Confirma encerramento do período?</h1>\
							<button type="submit" class="btn btn-primary" id="btnConfEncPeriodo" value="'+ j[i].id_inv +'" style="width: 80px">Sim</button>\
							<button type="button" class="btn btn-default" data-dismiss="modal" style="width: 80px">Cancelar</button>\
							').show();
					}
				}
			});
		}
	});

	$(document).on('click', '#btnConfEncPeriodo', function(){
		event.preventDefault();
		$('#btnConfEncPeriodo').prop("disabled", true);
		var inv = $(this).val();
		$.ajax
		({
			url:"data/inventario/encerra_periodo.php",
			method:"POST",
			dataType:'json',
			data:{inv:inv},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					if(j[i].info == 0){

						alert("Período encerrado com sucesso!");

					}else{

						alert("Erro no cadastro!");

					}
				}
			}
		});
		return false;
		$('#btnConfEncPeriodo').prop("disabled", false);
	});

	$(document).on('change', '#SelHistInv', function(){
		event.preventDefault();
		$('#SelHistInv').prop("disabled", true);
		$('#retHistStatus').hide();
		var id_inv = $(this).val();
		$.ajax
		({
			url:"data/inventario/consulta_resumo_inv.php",
			method:"POST",
			dataType:'json',
			data:{id_inv:id_inv},
			beforeSend:function(e){
				$("#aguardeStatus").html("<img src='css/loading9.gif'>");
			},
			success:function(j)
			{

				$("#aguardeStatus").hide();

				if(j.info == 0){

					$('#retHistStatus').append('<dl>\
						<dt>Acuracidade atual por posição</dt>\
						<dd>\
						<div style="font-size: x-small;text-align: right;">\
						<span class="percent">'+ j.acuracidade +'%</span>\
						<div class="progress progress-sm">\
						<div class="progress-bar bg-color-greenLight" style="width: '+ j.acuracidade +'%">\
						</div>\
						</div>\
						</div\
						</dd>\
						</dl>\
						');

					$('#retHistStatus').show();

				}else{

					alert("Erro no cadastro!");

				}
			}
		});
		return false;
		$('#SelHistInv').prop("disabled", false);
	});
});

$(document).ready(function(){
	$(document).on('change', '#idGalpaoNew', function(){
		if( $(this).val() ) {
			$('#idRuaNew').hide();
			$.getJSON('data/movimento/consulta_rua_transf.php?search=',{id_galpao: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a rua</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
				}
				$('#idRuaNew').html(options).show();
			});
		} else {
			$('#idRuaNew').html('<option value="">Escolha a rua</option>');
		}
	});

	$(document).on('change', '#idRuaNew', function(){
		if( $(this).val() ) {
			$('#idColNew').hide();
			$.getJSON('data/movimento/consulta_coluna_transf.php?search=',{id_rua: $(this).val(), id_galpao: $('#idGalpaoNew').val(),ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a coluna</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
				}
				$('#idColNew').html(options).show();
			});
		} else {
			$('#idColNew').html('<option value="">Escolha a coluna</option>');
		}
	});

	$(document).on('change', '#idColNew', function(){
		if( $(this).val() ) {
			$('#idAlturaNew').hide();
			$.getJSON('data/movimento/consulta_altura_transf.php?search=',{id_coluna: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">Escolha a altura</option>';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].altura + '">'  + j[i].altura + '</option>';
				}
				$('#idAlturaNew').html(options).show();
			});
		} else {
			$('#idAlturaNew').html('<option value="">Escolha a altura</option>');
		}
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnConsEmitNfCnpj', function(){
		event.preventDefault();
		var nr_cnpj_emit = $('#nr_cnpj_cpf_emit').val();
		var ds_uf_emit = $('#ds_uf_emit').val();
		$.ajax
		({
			url:"data/recebimento/consulta_dados_sefaz.php",
			method:"POST",
			dataType:'json',
			data:{
				nr_cnpj :nr_cnpj_emit,
				ds_uf_con :ds_uf_emit
			},
			success:function(s)
			{
				var postData = s;

				$.ajax
				({
					type: 'POST',
					url: 'https://nfe.ns.eti.br/util/conscad',
					data: JSON.stringify(postData),
					contentType: "application/json",
				}).done(function(emitente){

					if(emitente.status == 200){
						if(emitente.retConsCad.infCons.cStat == 111){

							for (var i = 0; i < emitente.retConsCad.infCons.infCad.length; i++) {

								var r_social        = emitente.retConsCad.infCons.infCad[i].xNome;
								var nr_cnpj_cpf     = emitente.retConsCad.infCons.infCad[i].CNPJ;
								var ds_uf           = emitente.retConsCad.infCons.infCad[i].UF;
								var ds_ie_rg        = emitente.retConsCad.infCons.infCad[i].IE;
								var ds_cep          = emitente.retConsCad.infCons.infCad[i].ender.CEP;
								var cod_mun         = emitente.retConsCad.infCons.infCad[i].ender.cMun;
								var ds_endereco     = emitente.retConsCad.infCons.infCad[i].ender.xLgr;
								var ds_numero       = emitente.retConsCad.infCons.infCad[i].ender.nro;
								var ds_complemento  = emitente.retConsCad.infCons.infCad[i].ender.xCpl;
								var ds_bairro       = emitente.retConsCad.infCons.infCad[i].ender.xBairro;
								var ds_cidade       = emitente.retConsCad.infCons.infCad[i].ender.xMun;

								$('#nm_cliente').val(r_social);
								$('#ds_ie_rg').val(ds_ie_rg);
								$('#ds_endereco').val(ds_endereco);
								$('#nr_numero').val(ds_numero);
								$('#ds_complemento').val(ds_complemento);
								$('#ds_bairro').val(ds_bairro);
								$('#ds_cidade').val(ds_cidade);
								$('#ds_cep').val(ds_cep);
								$('#ds_uf').val(ds_uf);

								$.ajax
								({
									url:"data/entidade/ins_dest_api.php",
									method:"POST",
									dataType:'json',
									data:{
										r_social        :r_social,
										nr_cnpj_cpf     :nr_cnpj_cpf,
										ds_ie_rg        :ds_ie_rg,
										ds_cep          :ds_cep,
										cod_mun         :cod_mun,
										ds_endereco     :ds_endereco,
										ds_numero       :ds_numero,
										ds_complemento  :ds_complemento,
										ds_bairro       :ds_bairro,
										ds_cidade       :ds_cidade,
										ds_uf           :ds_uf
									},
									success:function(d)
									{
										for (var i = 0; i < d.length; i++) {
											if(d[i].info == "0"){

												alert("Empresa  inserida com sucesso!");
												$('#novo_cliente_nf').modal('hide');
												$('#nm_emitente').val(d[i].nm_cliente);
												$('#id_emitente').val(d[i].cod_cliente);

											}else if(d[i].info == "1"){

												alert("O Cnpj pesquisado já existe no cadastro! Erro: "+d[i].info);
												$('#novo_cliente_nf').modal('hide');
												$('#nm_emitente').val(d[i].nm_cliente);
												$('#id_emitente').val(d[i].cod_cliente);

											}else if(d[i].info == "2"){

												alert("Não foi possível realizar o cadastro. Entre em contato com o suporte! Erro: "+d[i].info);

											}else if(d[i].info == "3"){

												alert("Erro na pesquisa do código do município. Por favor confirme o nome da cidade! Erro: "+d[i].info);

											}else{

												alert("Erro no cadastro! Erro: "+d[i].info);

											}
										}
									}
								}); 

							}

						}else if(emitente.retConsCad.infCons.cStat == 259){

							alert(emitente.retConsCad.infCons.xMotivo);

						}						

					}else{

						alert("CNPJ não encontrado.");

					}

				}).fail(function(jqXHR, textStatus, errorThrown) {

					var retorno = jqXHR.responseText;
					var obj 	= JSON.parse(retorno);

					var erro    = obj.xMotivo;
					alert(erro);

				});
			}
		});
		return false;
	});

	$(document).on('click', '#btnConsDestNfCnpj', function(){
		event.preventDefault();
		var nr_cnpj = $('#nr_cnpj_cpf').val();
		var ds_uf_con = $('#ds_uf_con').val();
		$.ajax
		({
			url:"data/recebimento/consulta_dados_sefaz.php",
			method:"POST",
			dataType:'json',
			data:{
				nr_cnpj :nr_cnpj,
				ds_uf_con :ds_uf_con
			},
			success:function(s)
			{
				var postData = s;

				$.ajax
				({
					type: 'POST',
					url: 'https://nfe.ns.eti.br/util/conscad',
					data: JSON.stringify(postData),
					contentType: "application/json",
				}).done(function(response){

					if(response.status == 200){

						if(response.retConsCad.infCons.cStat == 111){

							for (var i = 0; i < response.retConsCad.infCons.infCad.length; i++) {

								var r_social        = response.retConsCad.infCons.infCad[i].xNome;
								var nr_cnpj_cpf     = response.retConsCad.infCons.infCad[i].CNPJ;
								var ds_uf           = response.retConsCad.infCons.infCad[i].UF;
								var ds_ie_rg        = response.retConsCad.infCons.infCad[i].IE;
								var ds_cep          = response.retConsCad.infCons.infCad[i].ender.CEP;
								var cod_mun         = response.retConsCad.infCons.infCad[i].ender.cMun;
								var ds_endereco     = response.retConsCad.infCons.infCad[i].ender.xLgr;
								var ds_numero       = response.retConsCad.infCons.infCad[i].ender.nro;
								var ds_complemento  = response.retConsCad.infCons.infCad[i].ender.xCpl;
								var ds_bairro       = response.retConsCad.infCons.infCad[i].ender.xBairro;
								var ds_cidade       = response.retConsCad.infCons.infCad[i].ender.xMun;

								$('#nm_destinatario').val(r_social);
								$('#ds_ie_rg').val(ds_ie_rg);
								$('#ds_endereco').val(ds_endereco);
								$('#nr_numero').val(ds_numero);
								$('#ds_complemento').val(ds_complemento);
								$('#ds_bairro').val(ds_bairro);
								$('#ds_cidade').val(ds_cidade);
								$('#ds_cep').val(ds_cep);
								$('#ds_uf').val(ds_uf);

								$.ajax
								({
									url:"data/entidade/ins_dest_api.php",
									method:"POST",
									dataType:'json',
									data:{
										r_social        :r_social,
										nr_cnpj_cpf     :nr_cnpj_cpf,
										ds_ie_rg        :ds_ie_rg,
										ds_cep          :ds_cep,
										cod_mun         :cod_mun,
										ds_endereco     :ds_endereco,
										ds_numero       :ds_numero,
										ds_complemento  :ds_complemento,
										ds_bairro       :ds_bairro,
										ds_cidade       :ds_cidade,
										ds_uf           :ds_uf
									},
									success:function(d)
									{
										for (var i = 0; i < d.length; i++) {
											if(d[i].info == "0"){

												alert("Empresa  inserida com sucesso!");
												$('#novo_destinatario_nf').modal('hide');
												$('#nm_destinatario').val(d[i].nm_cliente);
												$('#id_destinatario').val(d[i].cod_cliente);

											}else if(d[i].info == "1"){

												alert("O Cnpj pesquisado já existe no cadastro! Erro: "+d[i].info);
												$('#novo_destinatario_nf').modal('hide');
												$('#nm_destinatario').val(d[i].nm_cliente);
												$('#id_destinatario').val(d[i].cod_cliente);

											}else if(d[i].info == "2"){

												alert("Não foi possível realizar o cadastro. Entre em contato com o suporte! Erro: "+d[i].info);

											}else if(d[i].info == "3"){

												alert("Erro na pesquisa do código do município. Por favor confirme o nome da cidade! Erro: "+d[i].info);

											}else{

												alert("Erro no cadastro! Erro: "+d[i].info);

											}
										}
									}
								}); 

							}

						}else if(response.retConsCad.infCons.cStat == 259){

							alert(response.retConsCad.infCons.xMotivo);

						}

					}else{

						alert("CNPJ não encontrado.");

					}

				}).fail(function(jqXHR, textStatus, errorThrown) {

					var retorno = jqXHR.responseText;
					var obj 	= JSON.parse(retorno);

					var erro    = obj.xMotivo;
					alert(erro);

				});
			}
		});
		return false;
	});
});

$(document).ready(function () {
	$(document).on('click', '#btnCadDestinatarioNf', function(){
		if(confirm("Confirma o cadastro do destinatário?")){
			$('#btnCadDestinatarioNf').prop("disabled", true);
			var nm_cliente 		= $('#nm_cliente').val();
			var nm_fantasia 	= $('#nm_fantasia').val();
			var nr_cnpj_cpf 	= $('#nr_cnpj_cpf').val();
			var ds_ie_rg 		= $('#ds_ie_rg').val();
			var ds_endereco 	= $('#ds_endereco').val();
			var nr_numero 		= $('#nr_numero').val();
			var ds_complemento 	= $('#ds_complemento').val();
			var ds_bairro 		= $('#ds_bairro').val();
			var ds_cidade 		= $('#ds_cidade').val();
			var ds_cep 			= $('#ds_cep').val();
			var ds_uf 			= $('#ds_uf').val();
			var nr_telefone 	= $('#nr_telefone').val();
			var ds_email 		= $('#ds_email').val();
			var nm_contato 		= $('#nm_contato').val();

			$.ajax
			({
				url:"data/entidade/ins_destinatario_nf.php",
				method:"POST",
				dataType:'json',
				data:{
					nm_cliente 		:nm_cliente,
					nm_fantasia 	:nm_fantasia,
					nr_cnpj_cpf 	:nr_cnpj_cpf,
					ds_ie_rg 		:ds_ie_rg,
					ds_endereco 	:ds_endereco,
					nr_numero 		:nr_numero,
					ds_complemento 	:ds_complemento,
					ds_bairro 		:ds_bairro,
					ds_cidade 		:ds_cidade,
					ds_cep 			:ds_cep,
					ds_uf 			:ds_uf,
					nr_telefone 	:nr_telefone,
					ds_email 		:ds_email,
					nm_contato 		:nm_contato
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {

						if(j[i].info == "0"){

							alert("Cadastro efetuado com sucesso!");
							$('#novo_destinatario_nf').modal('hide');
							$('#nm_destinatario').val(j[i].nm_cliente);
							$('#id_destinatario').val(j[i].cod_cliente);

						}else if(j[i].info == "1"){

							alert("Já existe cadastro com esse CNPJ!");

						}else{

							alert("Erro no cadastro!");

						}
					}
				}
			});
			$('#btnCadDestinatarioNf').prop("disabled", false);
			return false;
		}
	});

	$(document).on('click', '#btnCadClienteNf', function(){
		if(confirm("Confirma o cadastro do emitente?")){
			$('#btnCadClienteNf').prop("disabled", true);
			var nm_cliente 		= $('#nm_cliente').val();
			var nm_fantasia 	= $('#nm_fantasia').val();
			var nr_cnpj_cpf 	= $('#nr_cnpj_cpf').val();
			var ds_ie_rg 		= $('#ds_ie_rg').val();
			var ds_endereco 	= $('#ds_endereco').val();
			var nr_numero 		= $('#nr_numero').val();
			var ds_complemento 	= $('#ds_complemento').val();
			var ds_bairro 		= $('#ds_bairro').val();
			var ds_cidade 		= $('#ds_cidade').val();
			var ds_cep 			= $('#ds_cep').val();
			var ds_uf 			= $('#ds_uf').val();
			var nr_telefone 	= $('#nr_telefone').val();
			var ds_email 		= $('#ds_email').val();
			var nm_contato 		= $('#nm_contato').val();

			$.ajax
			({
				url:"data/entidade/ins_cliente_nf.php",
				method:"POST",
				dataType:'json',
				data:{
					nm_cliente 		:nm_cliente,
					nm_fantasia 	:nm_fantasia,
					nr_cnpj_cpf 	:nr_cnpj_cpf,
					ds_ie_rg 		:ds_ie_rg,
					ds_endereco 	:ds_endereco,
					nr_numero 		:nr_numero,
					ds_complemento 	:ds_complemento,
					ds_bairro 		:ds_bairro,
					ds_cidade 		:ds_cidade,
					ds_cep 			:ds_cep,
					ds_uf 			:ds_uf,
					nr_telefone 	:nr_telefone,
					ds_email 		:ds_email,
					nm_contato 		:nm_contato
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {

						if(j[i].info = "0"){

							alert("Cadastro efetuado com sucesso!");
							$('#novo_cliente_nf').modal('hide');
							$('#nm_emitente').val(j[i].nm_cliente);
							$('#id_emitente').val(j[i].cod_cliente);

						}else if(j[i].info = "1"){

							alert("Já existe cadastro com esse CNPJ!");

						}else{

							alert("Erro no cadastro!");

						}
					}
				}
			});
			$('#btnCadClienteNf').prop("disabled", false);
			return false;
		}
	});
});

$(document).ready(function () {
	$(document).on('click','#btnImpXml',function(e){
		event.preventDefault();
		var id_rec = $(this).val();
		$('#retornoNfe').load('importa_xml.php?search=',{id_rec:id_rec});
	});

	$(document).on('click','#btnImpNsSap',function(e){
		event.preventDefault();
		var id_rec = $(this).val();
		$('#retornoSap').load('importa_ns_sap.php?search=',{id_rec:id_rec});
	});

	$(document).on('click','#btnGeraSap',function(e){
		event.preventDefault();
		var id_rec_sap = $(this).val();
		$.ajax
		({
			url:"gera_or_sap.php",
			method:"POST",
			data:{id_rec_sap:id_rec_sap},
			beforeSend:function(j){
				$("#retornoSap").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoSap').html(data);
			}
		});
	});
/*
	$(document).on('click','#btnGeraNsSap',function(e){
		event.preventDefault();
		var id_ns_sap = $(this).val();
		$.ajax
		({
			url:"ins_ns_sap.php",
			method:"POST",
			data:{id_ns_sap:id_ns_sap},
			beforeSend:function(j){
				$("#retornoSap").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoSap').html(data);
			}
		});
	});
	*/
	$(document).on('click','#btnXmlNfe',function(){
		event.preventDefault();
		$('#btnXmlNfe').prop("disabled", true);
		if(confirm("Confirma a consulta da NF? Só são permitidas 50 consultas por documento.")){
			var chave_nfe = $('#chave_nfe').val();
			var id_rec = $('#id_rec').val();
			$.ajax
			({
				url:"data/recebimento/consulta_chave_nfe.php",
				method:"POST",
				dataType:'json',
				data:
				{
					chave_nfe:chave_nfe
				},
				success:function(j)
				{
					var consultaNfe = j;
					$.ajax
					({
						type: 'POST',
						url: 'https://ddfe.ns.eti.br/dfe/unique',
						data: JSON.stringify(consultaNfe),
						contentType: "application/json",

					}).done(function(consulta){

						var chave       = consulta.chave;
						var nsu      	= consulta.nsu;
						var status    	= consulta.status;
						var xml     	= consulta.xml;

						$.ajax
						({
							url:"data/recebimento/gera_xml_ddf.php",
							method:"POST",
							dataType:'json',
							data:
							{
								xml:xml,
								chave:chave
							},
							beforeSend:function(j){
								$("#retXml").html("<img src='css/loading9.gif'>");
							},
							success:function(j)
							{
								if(j.info == "0"){

									var caminho = j.caminho;

									$.ajax
									({
										url:"ins_xml_nf_ddf.php",
										method:"POST",
										data:
										{
											caminho:caminho,
											id_rec:id_rec
										},
										success:function(f)
										{
											$('#retXml').html(f).append();
										}
									});

								}else{

									console.log("Ocorreu um erro na gravação o arquivo! Por favor entre em contato com o suporte.");

								}
							}
						});

					}).fail(function(jqXHR, textStatus, errorThrown) {							

						var retorno 		= jqXHR.responseText;
						var obj 			= JSON.parse(retorno);

						var status       	= obj.status;
						var motivo     		= obj.motivo;

						alert("Não foi possível consultar a nota fiscal. Erro: "+ motivo +". Status: "+ status +". Por favor entre em contato com o suporte.");

					});
				}
			});
		}
		$('#btnXmlNfe').prop("disabled", false);
	});
});

$(document).ready(function () {
	/*$(document).on('click', '#btnLibRec', function(){
		event.preventDefault();
		$('#btnLibRec').prop("disabled", true);
		var id_rec = $(this).val();
		$.ajax
		({
			url:"data/recebimento/consulta_lib_rec.php",
			method:"POST",
			dataType:'json',
			data:{id_rec:id_rec},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					if(j[i].info == 0){

						alert("Recebimento liberado para conferência!");

					}else if(j[i].info == 1){

						alert("Erro no cadastro!");

					}else if(j[i].info == 2){

						alert("Não há produtos cadastrados para conferência!");

					}
				}
			}
		});
		$('#btnLibRec').prop("disabled", false);
		return false;
	});*/

	$(document).on('click', '#btnGeraEtq', function(){
		event.preventDefault();
		$('#btnGeraEtq').prop("disabled", true);
		var id_rec = $(this).val();
		$.ajax
		({
			url:"gera_etq_rec.php",
			method:"POST",
			data:{id_rec:id_rec},
			success:function(data)
			{
				$('#retorno').html(data);
			}
		});
		$('#btnGeraEtq').prop("disabled", false);
		return false;
	});
});

/* AGENDAMENTO DE ENTREGAS*/

$(document).ready(function () {
	$(document).on('click', '#btnInsRecAg', function(){
		event.preventDefault();
		if(confirm("Confirma a criação do agendamento?")){
			$('#btnInsRecAg').prop("disabled", true);
			var nm_fornecedor 				= $('#nm_fornecedor').val();
			var nr_peso_previsto 			= $('#nr_peso_previsto').val();
			var nr_volume_previsto 			= $('#nr_volume_previsto').val();
			var nm_transportadora 			= $('#nm_transportadora').val();
			var nm_motorista 				= $('#nm_motorista').val();
			var nm_placa 					= $('#nm_placa').val();
			var ds_obs 						= $('#obs').val();
			var nr_insumo 					= $('#nr_insumo').val();
			var id_janela 					= $('#hr_ag_disp').val();
			var dt_ag_disp 					= $('#dt_ag_disp').val();
			var tp_veiculo 					= $('#tp_veiculo').val();
			$.ajax
			({
				url:"data/recebimento/ins_recebimento_ag.php",
				method:"POST",
				dataType:'json',
				data:{
					nm_fornecedor 				:nm_fornecedor,
					nr_peso_previsto 			:nr_peso_previsto,
					nr_volume_previsto 			:nr_volume_previsto,
					nm_transportadora 			:nm_transportadora,
					nm_motorista 				:nm_motorista,
					nm_placa 					:nm_placa,
					ds_obs 						:ds_obs,
					nr_insumo 					:nr_insumo,
					id_janela 					:id_janela,
					dt_ag_disp 					:dt_ag_disp,
					tp_veiculo 					:tp_veiculo
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {
						if(j[i].info == 0){

							$.ajax
							({
								url:"data/mail/mail_rec.php",
								method:"POST",
								data:{
									nm_fornecedor :nm_fornecedor
								},
								success:function(m)
								{

								}
							});
							alert("Agendamento solicitado com sucesso!");

							$('#retornoAg').load('data/recebimento/list_recebimento_ag.php');

						}else{

							alert("Erro no cadastro!");

						}
					}
				}
			});
			$('#btnInsRecAg').prop("disabled", false);
		}
		return false;
	});

	$(document).on('click', '#btnNovaNfeAg', function(){
		var ins_rec = $(this).val();
		$.ajax
		({
			url:"ins_recebimento_nf_ag.php",
			method:"POST",
			data:{ins_rec:ins_rec},
			success:function(data)
			{
				$('#retornoNfeAg').html(data);
			}
		});
	});

	$(document).on('click', '#btnUpdRecAg', function(){
		var upd_rec = $(this).val();
		$.ajax
		({
			url:"edit_recebimento_ag.php",
			method:"POST",
			data:{upd_rec:upd_rec},
			success:function(data)
			{
				$('#retornoAg').html(data);
			}
		});
	});

	$(document).on('change', '#dt_ag_disp', function(){
		$('#hr_ag_disp').hide();
		$.getJSON('data/recebimento/consulta_ag_disp.php?search=',{dt_disp: $(this).val(), ajax: 'true'}, function(j){
			var options = '<option value="">Escolha o horário</option>';
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].id + '">' + j[i].ds_janela +'</option>';
			}
			$('#hr_ag_disp').html(options).show();
		});
	});

	$(document).on('click', '#btnNovoAgRec', function(){
		$.ajax
		({
			url:"ins_recebimento_ag.php",
			method:"POST",
			beforeSend:function(e){
				$("#retornoAg").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoAg').html(data);
			}
		});
	});

	$(document).on('click','#btnInsNfRecAg',function(){
		var ins_rec = $(this).val();
		if($('#nr_fisc_ent').val() == '' || $('#dt_emis_ent').val() == '' || $('#nr_cfop_ent').val() == '' || $('#tp_vol_ent').val() == '' || $('#qtd_vol_ent').val() == '' || $('#nr_peso_ent').val() == '' || $('#id_rem').val() == '' || $('#id_dest').val() == '' || $('#vl_tot_nf_ent').val() == '' || $('#vl_tot_nf_ent').val() == '' || $('#base_icms_ent').val() == '' || $('#vl_icms_ent').val() == ''){

			alert("Todos os campos são obrigatórios.");

		}else{

			$.post("data/recebimento/ins_nf_recebimento_ag.php", $("#formNovoNfRec").serialize(), function(data) {
				alert(data);
				$('#retornoNfeAg').load("ins_recebimento_nf_ag.php?search=",{ins_rec:ins_rec});
			});

		}
	});

	$(document).on('click', '#btnUpdNfRecAg', function(){
		event.preventDefault();
		var upd_nfrec = $(this).val();
		$.ajax
		({
			url:"data/recebimento/upd_nf_recebimento_ag.php",
			method:"POST",
			data:{upd_nfrec:upd_nfrec},
			success:function(data)
			{
				$('#retornoNfeAg').html(data);
			}
		});
	});

	$(document).on('click', '#btnFormUpdNfRecebimentoAg', function(){
		event.preventDefault();
		var id_nf 			= $(this).val();
		var nr_fisc_ent 	= $('#nr_fisc_ent').val();
		var dt_emis_ent 	= $('#dt_emis_ent').val();
		var nr_cfop_ent 	= $('#nr_cfop_ent').val();
		var qtd_vol_ent 	= $('#qtd_vol_ent').val();
		var nr_peso_ent 	= $('#nr_peso_ent').val();
		var tp_vol_ent 		= $('#tp_vol_ent').val();
		var vl_tot_nf_ent 	= $('#vl_tot_nf_ent').val();
		var base_icms_ent 	= $('#base_icms_ent').val();
		var vl_icms_ent 	= $('#vl_icms_ent').val();
		var chavenfe 		= $('#chavenfe').val();
		var ds_obs_nf 		= $('#ds_obs_nf').val();
		$.ajax
		({
			type: 'POST',
			dataType: 'json',
			url: 'data/recebimento/upd_nf_rec_ag.php',
			data: {
				id_nf 			:id_nf,
				nr_fisc_ent 	:nr_fisc_ent,
				dt_emis_ent 	:dt_emis_ent,
				nr_cfop_ent 	:nr_cfop_ent,
				qtd_vol_ent 	:qtd_vol_ent,
				nr_peso_ent 	:nr_peso_ent,
				tp_vol_ent 		:tp_vol_ent,
				vl_tot_nf_ent 	:vl_tot_nf_ent,
				base_icms_ent 	:base_icms_ent,
				vl_icms_ent 	:vl_icms_ent,
				chavenfe 		:chavenfe,
				ds_obs_nf 		:ds_obs_nf
			},
			success: function (j)
			{
				for (var i = 0; i < j.length; i++) {
					if(j[i].info == "0"){

						alert("Registro alterado com sucesso!");

					}else if(j[i].info == "1"){

						alert("Erro no registro!");

					}else if(j[i].info == "2"){

						alert("Os campos não pode estar vazios!");

					}
				}
			}
		});
	});
});

$(document).ready(function () {
	$(document).on('click','#btnImpXmlAg',function(e){
		event.preventDefault();
		var id_rec = $(this).val();
		$('#retornoNfeAg').load('importa_xml_ag.php?search=',{id_rec:id_rec});
	});

	$(document).on('click','#btnXmlNfeAg',function(){
		event.preventDefault();
		$('#btnXmlNfeAg').prop("disabled", true);
		if(confirm("Confirma a consulta da NF? Só são permitidas 50 consultas por documento.")){
			var chave_nfe = $('#chave_nfe').val();
			var id_rec = $('#id_rec').val();
			$.ajax
			({
				url:"data/recebimento/consulta_chave_nfe_ag.php",
				method:"POST",
				dataType:'json',
				data:
				{
					chave_nfe:chave_nfe
				},
				success:function(j)
				{
					var consultaNfe = j;
					$.ajax
					({
						type: 'POST',
						url: 'https://ddfe.ns.eti.br/dfe/unique',
						data: JSON.stringify(consultaNfe),
						contentType: "application/json",

					}).done(function(consulta){

						var chave       = consulta.chave;
						var nsu      	= consulta.nsu;
						var status    	= consulta.status;
						var xml     	= consulta.xml;

						$.ajax
						({
							url:"data/recebimento/gera_xml_ddf_ag.php",
							method:"POST",
							dataType:'json',
							data:
							{
								xml:xml,
								chave:chave
							},
							beforeSend:function(j){
								$("#retXml").html("<img src='css/loading9.gif'>");
							},
							success:function(j)
							{
								if(j.info == "0"){

									var caminho = j.caminho;

									$.ajax
									({
										url:"ins_xml_nf_ddf_ag.php",
										method:"POST",
										data:
										{
											caminho:caminho,
											id_rec:id_rec
										},
										success:function(f)
										{
											$('#retXml').html(f).append();
										}
									});

								}else{

									console.log("Ocorreu um erro na gravação o arquivo! Por favor entre em contato com o suporte.");

								}
							}
						});

					}).fail(function(jqXHR, textStatus, errorThrown) {							

						var retorno 		= jqXHR.responseText;
						var obj 			= JSON.parse(retorno);

						var status       	= obj.status;
						var motivo     		= obj.motivo;

						alert("Não foi possível consultar a nota fiscal. Erro: "+ motivo +". Status: "+ status +". Por favor entre em contato com o suporte.");

					});
				}
			});
		}
		$('#btnXmlNfeAg').prop("disabled", false);
	});
	
	$(document).on('click', '#btnConfRecAg', function(){
		event.preventDefault();
		$('#btnConfRecAg').prop("disabled", true);
		var id_rec = $(this).val();
		$.ajax
		({
			url:"data/recebimento/consulta_confirma_rec.php",
			method:"POST",
			dataType:'json',
			data:{id_rec:id_rec},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					if(j[i].info == 0){

						alert("Agendamento confirmado!");
						$('#retornoAg').load('data/recebimento/list_recebimento_ag.php');
						$.ajax
						({
							url:"feed_mail_conf.php",
							method:"POST",
							data:{
								id_rec:id_rec
							},
							success:function(data)
							{
								console.log(data);
							}
						});

					}else if(j[i].info == 1){

						alert("Erro no cadastro!");

					}else if(j[i].info == 2){

						alert("Não há produtos cadastrados!");

					}
				}
			}
		});
		$('#btnConfRecAg').prop("disabled", false);
		return false;
	});
});

/* CADASTRO DE PRODUTOS */

$(document).ready(function () {
	$(document).on('click', '#btnNovoNfePrd', function(){
		var ins_rec = $(this).val();
		$.ajax
		({
			url:"ins_recebimento_prd.php",
			method:"POST",
			data:{ins_rec:ins_rec},
			success:function(data)
			{
				$('#retornoSap').html(data);
			}
		});
	});

	$(document).on('click', '#btnDelRec', function(){
		if(confirm("Confirma a exclusão do recebimento? Essa ação excluirá as notas fiscais e produtos relacionados.")){
			$('#btnDelRec').prop("disabled", true);
			var del_rec = $(this).val();
			var del_sts = $(this).attr("data-st");
			if(del_sts == "A"){

				$.ajax
				({
					url:"data/recebimento/del_recebimento.php",
					method:"POST",
					data:{del_rec:del_rec},
					success:function(data)
					{
						alert(data);
					}
				});

			}else{

				alert("Somente ORs abertas pode ser excluidas.");

			}
			$('#btnDelRec').prop("disabled", false);
		}
	});

	$(document).on('click', '#btnDelNfrec', function(){
		if(confirm("Confirma a exclusão da nota fiscal? Essa ação excluirá também os produtos relacionados.")){
			$('#btnDelNfrec').prop("disabled", true);
			event.preventDefault();
			var del_nfrec = $(this).val();
			var dt_sts = $(this).attr("data-st");

			if(dt_sts == "A" || dt_sts == "AG"){

				$.ajax
				({
					url:"data/recebimento/del_item_nf_rec.php",
					method:"POST",
					data:{del_nfrec:del_nfrec},
					success:function(data)
					{
						alert(data);
					}
				});

			}else{

				alert("Somente podem ser excluídos notas fiscais de ORs abertas ou agendadas.");

			}
			$('#btnDelNfrec').prop("disabled", false);
		}
	});

	$(document).on('click', '#btnDelProdNfrec', function(){
		if(confirm("Confirma a exclusão do produto?")){
			$('#btnDelProdNfrec').prop("disabled", true);
			var del_prd = $(this).val();
			var dt_sts = $(this).attr("data-st");

			if(dt_sts == "A"){
				$.ajax
				({
					url:"data/recebimento/del_nf_prd_rec.php",
					method:"POST",
					data:{del_prd:del_prd},
					success:function(retorno)
					{
						alert(retorno);
					}
				});

			}else{

				alert("Somente podem ser excluídos produtos de ORs abertas.");

			}

			$('#btnDelProdNfrec').prop("disabled", false);
		}
	});
});

/* CADASTRO DE PRODUTOS */

$(document).ready(function () {
	$(document).on('click', '#btnPesqPrdNf', function(){
		var cod_cli = $('#cod_prod_cliente').val();
		$.ajax
		({
			url:"data/recebimento/consulta_produto_rec.php",
			method:"POST",
			dataType:'json',
			data:{cod_cli:cod_cli},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					if(j[i].info == 0){

						$('#cod_produto').val(j[i].cod_produto);
						$('#nm_produto').val(j[i].nm_produto);

					}else{

						$('#nm_produto').val("Produto não encontrado.");

					}

				}
			}
		});
	});

	$(document).on('click', '#btnBlqJan', function(){
		if(confirm("Confirma o fechamento da janela?")){
			var ins_jn = $(this).val();
			$.ajax
			({
				url:"data/recebimento/fecha_janela.php",
				method:"POST",
				data:{ins_jn:ins_jn},
				success:function(data)
				{
					alert(data);
					$('#retornoJan').load('data/recebimento/list_agenda.php');
				}
			});
		}
	});

	$(document).on('click', '#btnReabJan', function(){
		if(confirm("Confirma a reabertura da janela?")){
			var ins_jn = $(this).val();
			$.ajax
			({
				url:"data/recebimento/reabre_janela.php",
				method:"POST",
				data:{ins_jn:ins_jn},
				success:function(data)
				{
					alert(data);
					$('#retornoJan').load('data/recebimento/list_agenda.php');
				}
			});
		}
	});
});

/* PEDIDOS */

$(document).ready(function () {
	$(document).on('click','#CadPedido',function(e){
		event.preventDefault();
		$.ajax
		({
			url:"novo_pedido.php",
			method:"GET",
			success:function(data)
			{
				$('#retornoPed').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#liPedPend',function(){
		$('#retornoPed').load("data/movimento/pedido_status.php?search=",{statusA:statusA,nr_pedido:""});
	});
});

$(document).ready(function(){

	$(document).on('click', '#btnUpdPrdNfRec', function(){
		event.preventDefault();
		var id_prd = $(this).val();
		$.ajax
		({
			url:"dtl_recebimento_prd.php",
			method:"POST",
			data:{
				id_prd:id_prd
			},
			success:function(data)
			{
				$('#retornoPrd').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#btnNovaJanela',function(){
		$('#retModalJan').load("data/recebimento/modal/m_ins_janela.php");
	});

	$(document).on('click', '#btnSaveNovaJanela', function(){
		event.preventDefault();
		if(confirm("Confirma a criação da janela?")){
			$('#btnSaveNovaJanela').prop("disabled", true);
			var dt_janela 		= $('#dt_janela').val();
			var hr_janela 		= $('#hr_janela').val();
			var ds_solicitante 	= $('#ds_solicitante').val();
			var ds_motivo 		= $('#ds_motivo').val();
			$.ajax
			({
				url:"data/recebimento/ins_janela.php",
				method:"POST",
				data:{
					dt_janela:dt_janela,
					hr_janela:hr_janela,
					ds_solicitante:ds_solicitante,
					ds_motivo:ds_motivo
				},
				success:function(data)
				{
					alert(data);
					$('#retornoJan').load('data/recebimento/list_agenda.php');
				}
			});
			$('#btnSaveNovaJanela').prop("disabled", false);
		}
		return false;
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnPesquisaPrd', function(){

		if($('#codigoPrd').val() != ""){

		event.preventDefault();
		$('#btnPesquisaPrd').prop("disabled", true);
		var codigo 		= $('#codigoPrd').val();
		console.log(codigo);
		//var produtos 	= $('#produtos').val();
		$.ajax
		({
			url:"data/produto/list_produto.php",
			method:"POST",
			data:{
				codigo:codigo
				},
				success:function(data)
				{
					$('#retornoPrd').html(data);
				}
			});

		}else{

			alert("Digite o código do produto ou a descrição");

		}
		$('#btnPesquisaPrd').prop("disabled", false);
		return false;
	});
});

$(document).ready(function(){

	$(document).on('click', '#btnGeraAloc', function(){
		event.preventDefault();
		if(confirm("Confirma a composição dos volumes?")){
			if( $('.checkAloc:checked').length == 0 ){

				alert('Selecione pelo menos um produto!');

			}else{

				var val = [];

				$('.checkAloc:checked').each(function(){
					val.push($(this).val());
				});

				$.ajax
				({
					url:'data/movimento/ins_alocacao_auto.php',
					method:'POST',
					data:{
						cod_estoque:val
					},
					beforeSend:function(e){
						$("#info_aloca").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
					},
					success:function(j)
					{

						alert(j);
						$('#info_aloca').load('data/movimento/alocar_list.php');

					}
				});
			}
		}
	});
	/*$(document).on('click', '#btnGeraAloc', function(){
		event.preventDefault();
		if( $('.checkAloc:checked').length == 0 ){

			alert('Selecione pelo menos um produto!');

		}else{

			var val = [];

			$('.checkAloc:checked').each(function(){
				val.push($(this).val());
			});

			$.ajax
			({
				url:'data/movimento/ins_alocacao.php',
				method:'POST',
				dataType:'json',
				data:{
					cod_estoque:val
				},
				beforeSend:function(e){
					$("#info_aloca").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				}
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {

						if(j[i].info == 0){

							alert("Alocação criada com sucesso.");
							$('#info_aloca').load('data/movimento/alocar_list.php');

						}else{

							alert("Erro.");
							$('#info_aloca').load('data/movimento/alocar_list.php');

						}

					}	
				}
			});
		}
	});*/

	$(document).on('click', '#btnLibAloc', function(){
		event.preventDefault();
		var cod_estoque = $(this).val();
		$.ajax
		({
			url:'data/movimento/lib_alocacao.php',
			method:'POST',
			dataType:'json',
			data:{
				cod_estoque:cod_estoque
			},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					if(j[i].info == 0){

						alert("Alocação liberada com sucesso.");

					}else{

						alert("Erro.");

					}

				}	
			}
		});
	});

	$(document).on('click', '#btnPrintAloc', function(){
		var id_aloca = $(this).val();
		$.ajax({
			url:"data/recebimento/relatorio/ordem_alocacao.php",
			method:"POST",
			data:{id_aloca:id_aloca},
			success:function(data)
			{
				$('#infoAlocaGer').html(data);
			}
		});
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnDtlRecEnc', function(){
		var upd_rec = $(this).val();
		$.ajax
		({
			url:"dtl_recebimento.php",
			method:"POST",
			data:{upd_rec:upd_rec},
			success:function(data)
			{
				$('#retornoEnc').html(data);
			}
		});
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnMovDestino', function(){
		$('#btnMovDestino').prop("disabled", true);
		var cod_estoque = $(this).val();
		var nr_qtde = $('#nr_qtde').val();
		$.ajax
		({
			url:"mov_destino.php",
			method:"POST",
			data:{cod_estoque:cod_estoque, nr_qtde:nr_qtde},
			success:function(data)
			{
				$('#info_produtos').html(data);
			}
		});
		$('#btnMovDestino').prop("disabled", false);
		return false;
	});

	$(document).on('click','#impPedSap',function(e){
		event.preventDefault();
		$('#conteudo').load('importa_sap.php');
	});

	$(document).on('click','#BtnImpPedSap',function(e){
		event.preventDefault();
		$('#retornoPed').load('importa_sap.php');
	});

$(document).on('click','#BtnImpPedSapLp',function(e){
	event.preventDefault();
	$('#retornoPed').load('importa_lp.php');
});

	$(document).on('click','#btnSaveVolPrdPed',function(e) {
		if(confirm("Confirma a inclusão do volume?")){
			event.preventDefault();
			var nr_vol = $(this).closest('tr').find('#nr_volume').text();
			var id_item = $(this).val();
			$.ajax
			({  
				url:"data/movimento/upd_volume_ped_item.php",  
				method:"POST",  
				data:{
					id_item:id_item,
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

$(document).ready(function(){
	$(document).on('click', '#btnCadFornecedor', function(){
		$('#formCadDestinatario').ajaxForm({
			target:'#retornoConf',
			url:'data/entidade/ins_fornecedor.php',
			beforeSend:function(e){
				$("#retornoConf").html("<img src='css/loading9.gif'>");
			}
		});
	});

	$(document).on('click', '#btnNewFornecedor', function(){
		var ins_destinatario = $(this).val();
		$.ajax({
			url:"data/entidade/modal/m_ins_fornecedor.php",
			method:"POST",
			data:{ins_destinatario:ins_destinatario},
			success:function(data)
			{
				$('#retorno').html(data);
			}
		});
	});

	$('#relEncInv').click(function(e){
		event.preventDefault();
		$('#conteudo').load('fecha_inv.php');
	});

	$(document).on('click', '#btnDtlInvTar', function(){
		var id_prd = $(this).val();
		var id_inv = $(this).attr("data-inv");
		$.ajax
		({
			url:"data/inventario/modal/m_dtl_inv.php",
			method:"POST",
			data:{id_prd:id_prd,id_inv:id_inv},
			success:function(data)
			{
				$('#retModInv').html(data);
			}
		});
	});

	$(document).on('click', '#btnPrintEncInv', function(){
		event.preventDefault();
		$('#btnPrintEncInv').prop("disabled", true);
		var id_inv = $('#selInv').val();
		if(id_inv == ""){

			alert("Por favor selecione todos os campos!");

		}else{

			$.ajax
			({
				url:"data/inventario/relatorio/fechamento_inventario.php",
				method:"POST",
				data:{
					id_inv:id_inv
				},
				success:function(data)
				{
					$('#infoEncInv').html(data);
				}
			});

		}
		$('#btnPrintEncInv').prop("disabled", false);
		return false;
	});

	$(document).on('click', '#btnConsOrFin',function(){
		event.preventDefault();
		$('#retornoAg').load('data/recebimento/list_recebimento_ag_fin.php');
	});

	$(document).on('click', '#btnRetRecAg', function(){
		if(confirm("Confirma o retorno do agendamento?")){
			var upd_rec = $(this).val();

			$.ajax
			({
				url:"data/recebimento/upd_ret_ag.php",
				method:"POST",
				data:{upd_rec:upd_rec},
				success:function(data)
				{
					alert(data);
					$('#retornoAg').load('data/recebimento/list_recebimento_ag.php');
				}
			});
		}
	});

	$(document).on('click', '#btnRecAg',function(){
		event.preventDefault();
		var upd_rec = $(this).val();
		$('#retModalAg').load("data/recebimento/modal/m_rec_ag.php?search=",{upd_rec:upd_rec});
	});

	$(document).on('click', '#btnSaveRecAg', function(){
		event.preventDefault();
		if(confirm("Confirma a recusa do agendamento?")){
			upd_rec = $(this).val();
			id_jan = $(this).attr("data-jan");
			var ds_motivo = $('#ds_motivo').val();

			$.ajax
			({
				url:"data/recebimento/upd_rec_ag.php",
				method:"POST",
				data:
				{
					upd_rec:upd_rec,
					ds_motivo:ds_motivo
				},
				success:function(data)
				{
					alert(data);


					$.post("feed_mail_rec.php",{upd_rec:upd_rec,id_jan:id_jan},function(j){
						alert(j);
						$('#retornoAg').load('data/recebimento/list_recebimento_ag.php');
					});
				}
			});
		}
		return false;
	});

	$(document).on('click','#btnGeraPedSap',function(e){
		event.preventDefault();
		$('#btnGeraPedSap').prop("disabled", true);
		$.ajax
		({
			url:"gera_pedido_sap_v2.php",
			method:"POST",
			//data:{id_rec_sap:id_rec_sap},
			beforeSend:function(j){
				$("#retSap").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retSap').html(data);
				$('#btnGeraPedSap').prop("disabled", false);
			}
		});
		return false;
	});

$(document).on('click','#btnGeraPedSapLp',function(e){
	event.preventDefault();
	$('#btnGeraPedSapLp').prop("disabled", true);
	$.ajax
	({
		url:"gera_pedido_sap_con.php",
		method:"POST",
		//data:{id_rec_sap:id_rec_sap},
		beforeSend:function(j){
			$("#retSap").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
		},
		success:function(data)
		{
			$('#retSap').html(data);
			$('#btnGeraPedSapLp').prop("disabled", false);
		}
	});
	return false;
});
});

$(document).ready(function(){
	$(document).on('click', '#btnConsDivConf', function(){
		event.preventDefault();
		var dtl_ped = $('#btnConsDivConf').val();
		$.ajax
		({
			url:"data/movimento/list_conf_pedido.php",
			method:"POST",
			data:{dtl_ped:dtl_ped},
			success:function(data)
			{
				$('#retornoConfPed').html(data);
			}
		});
		return false;
	});

	$(document).on('click','#btnUpdRecebimentoAg',function(){
		var ins_rec = $(this).val();
		if($('#nr_fisc_ent').val() == '' || $('#dt_emis_ent').val() == '' || $('#nr_cfop_ent').val() == '' || $('#tp_vol_ent').val() == '' || $('#qtd_vol_ent').val() == '' || $('#nr_peso_ent').val() == '' || $('#id_rem').val() == '' || $('#id_dest').val() == '' || $('#vl_tot_nf_ent').val() == '' || $('#vl_tot_nf_ent').val() == '' || $('#base_icms_ent').val() == '' || $('#vl_icms_ent').val() == ''){

			alert("Todos os campos são obrigatórios.");

		}else{

			$.post("data/recebimento/upd_recebimento_ag.php", $("#formUpdRecAg").serialize(), function(data) {
				alert(data);
				$('#retorno').load('data/recebimento/list_recebimento_ag.php');
			});

		}
	});

	$(document).on('click', '#btnAtualizaEnd', function(){
		event.preventDefault();
		if(confirm("Confirma a atualização da coleta?")){
			$('#btnAtualizaEnd').prop("disabled", true);
			var nr_pedido= $(this).val();
			var cod_prd= $(this).attr("data-prd");
			var cod_col= $(this).attr("data-cod");
			$.ajax
			({
				url:"data/movimento/atualiza_coleta.php",
				method:"POST",
				dataType:'json',
				data:{
					nr_pedido:nr_pedido,
					cod_prd:cod_prd,
					cod_col:cod_col
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {

						if(j[i].info == "1"){

							alert("Não foi possível iniciar a coleta. Por favor entre em contato com o suporte.");

						}else if(j[i].info == "0"){

							alert("Coleta atualizada.");

						}else if(j[i].info == "3"){

							alert("O pedido ainda não foi liberado para coleta ou a coleta já foi iniciada!");
						}

					}
					$('#btnAtualizaEnd').prop("disabled", false);
				}
			});
			return false;
		}
	});

	$(document).on('click', '#btnAVolAloc', function(){
		event.preventDefault();
		var cod_estoq = $(this).val();
		$.ajax
		({
			url:"data/movimento/modal/m_aloca_volume.php",
			method:"POST",
			data:{cod_estoq:cod_estoq},
			success:function(data)
			{
				$('#info_aloca').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#btnFormAlocaVolume', function(){
		event.preventDefault();
		var cod_estoque 		= $('#cod_estoque').val();
		var nr_qtde 			= $('#nr_qtde_new').val();
		var nr_qtde_old 		= $('#nr_qtde_old').val();
		var cod_produto 		= $('#cod_produto').val();
		var produto 			= $('#produto').val();
		var nr_volume 			= $('#nr_vol_new').val();
		var nr_or 				= $('#nr_or').val();
		if($('#nr_qtde_new').val() == '' || $('#nr_vol_new').val() == ''){

			alert("Digite a quantidade e o volume que serão movimentados.");

		}else{

			$('#btnFormAlocaVolume').prop("disabled", true);
			$.ajax
			({
				url:"data/movimento/transf_volume.php",
				method:"POST",
				dataType:'json',
				data:{
					cod_estoque: 		cod_estoque,
					nr_qtde: 			nr_qtde,
					nr_qtde_old: 		nr_qtde_old,
					nr_volume: 			nr_volume,
					cod_produto: 		cod_produto,
					nr_or: 				nr_or,
					produto: 			produto
				},
				success:function(j)
				{
					for (var i = 0; i < j.length; i++) {

						if(j[i].info == "1"){

							alert("Ocorreu um erro na alocação. Por favor verifique se todos os campos foram preenchidos e a quantidade solicitada na alocação.");

						}else if(j[i].info == "0"){

							alert("Alocação realizada com sucesso!");
							$('#nr_qtde_old').val(j[i].n_qtde);
							$('#nr_qtde_new').val("");
							$('#nr_vol_new').val("");
							$('#reg_table').load("data/movimento/modal/list_aloc_modal.php?search=" ,{cod_estoq:$('#cod_estoque').val()});

						}else if(j[i].info == "2"){

							alert("A quantidade a transferir não pode ser maior que a quantidade original.");

						}else if(j[i].info == "4"){

							alert("Existe reserva para esse produto e posição! Faça a transferência somente após finalizar o pedido.");

						}

					}

					$('#btnFormAlocaVolume').prop("disabled", false);
				}
			});

		}		
		return false;
	});

	$(document).on('click', '#btnEstCol', function(){
		event.preventDefault();
		$.post("data/movimento/estorna_coleta.php", $("#FormEstCol").serialize(), function(data) {
			alert(data);
		});
		return false;
	});
});

$(document).ready(function(){
	$(document).on('click','#btnPesquisaDocmaterial',function(e){
		event.preventDefault();
		var doc_mat = $('#doc_material').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_doc.php",
			method:"POST",
			data:{doc_mat:doc_mat},
			beforeSend:function(j){
				$("#retornoPed").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoPed').html(data);
			}
		});
	});

	$(document).on('click', '#btnEndSep', function(){
		var nr_pedido = $(this).val();
		var sts = $(this).attr("data-st");

		if(sts == 'M' || sts == 'D' || sts == 'C'){
			$.ajax
			({
				url:"data/movimento/consulta_coleta.php",
				method:"POST",
				dataType:'json',
				data:{
					nr_pedido:nr_pedido
				},
				success:function(j)
				{	
					for (var i = 0; i < j.length; i++) {
						if(j[i].info == "1"){
							
							if(confirm("Pedido não foi coletado totalmente. Confirma liberação?")){

								$.ajax
								({
									url:"data/movimento/libera_expedicao_parcial.php",
									method:"POST",
									data:{
										nr_pedido:nr_pedido
									},
									success:function(data)
									{
										alert(data);	
									}
								});

							}

						}else if(j[i].info == "0"){

							$.ajax
							({
								url:"data/movimento/libera_expedicao.php",
								method:"POST",
								data:{
									nr_pedido:nr_pedido
								},
								success:function(data)
								{
									alert(data);	
								}
							});

						}else if(j[i].info == "2"){

							alert("Nenhum item do pedido foi coletado. Não é possível liberar o pedido.");

						}
					}
				}
			});

		}else{

			alert("Somente pedidos com coleta iniciada podem ser liberados para expedição.");

		}
	});

	$(document).on('click','#btnSaveVlNfSaida',function(e) {
		if(confirm("Confirma a inclusão do  valor unitário?")){
			event.preventDefault();
			var vl_unit = $(this).closest('tr').find('#nr_volume').text();
			var cod_prd = $(this).closest('tr').find('#nr_volume').attr("data-prd");
			var nr_ped = $(this).val();
			$.ajax
			({  
				url:"data/movimento/upd_vl_nf_saida.php",  
				method:"POST",  
				data:{
					id_item:id_item,
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

	$(document).on('click','#btnInsNfSaida',function(){
		$('#btnInsNfSaida').prop("disabled", true);
		var nr_pedido = $(this).val();
		if($('#nr_nf_formulario').val() == ''){

			alert("ATENÇÃO: Campo número da nota é obrigatório.");

		}else{

			$.post("data/movimento/ins_nf_saida.php", $("#formNovoNfSaida").serialize(), function(data) {
				alert(data);
				//$('#retornoNfe').load("ins_recebimento_nf.php?search=",{ins_rec:ins_rec});
			});

		}
		$('#btnInsNfSaida').prop("disabled", false);
	});

});

$(document).ready(function(){
	$(document).on('click','#btnPesquisaDocmaterialFin',function(e){
		event.preventDefault();
		var doc_mat = $('#doc_material_fin').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_doc_fin.php",
			method:"POST",
			data:{doc_mat:doc_mat},
			beforeSend:function(j){
				$("#retornoConfEnd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoConfEnd').html(data);
			}
		});
	});

	$(document).on('click', '#btnDtlPedFin', function(){
		event.preventDefault();
		var dtl_ped = $(this).val();
		$.ajax
		({
			url:"edit_pedido_fin.php",
			method:"POST",
			data:{dtl_ped:dtl_ped},
			success:function(data)
			{
				$('#retornoConfEnd').html(data);
			}
		});
		return false
	});
	
	$(document).on('click','#btnPesquisaDocmaterialExp',function(e){
		event.preventDefault();
		var doc_mat = $('#doc_material_fin').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_doc_exp.php",
			method:"POST",
			data:{doc_mat:doc_mat},
			beforeSend:function(j){
				$("#retornoConfExp").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoConfExp').html(data);
			}
		});
	});

	$(document).on('click', '#btnDtlPedExp', function(){
		event.preventDefault();
		var dtl_ped = $(this).val();
		$.ajax
		({
			url:"edit_pedido_fin.php",
			method:"POST",
			data:{dtl_ped:dtl_ped},
			success:function(data)
			{
				$('#retornoConfExp').html(data);
			}
		});
		return false
	});

	$(document).on('click', '#btnGeraRomaneio', function(){
		event.preventDefault();
		if( $('.checkRom:checked').length == 0 ){

			alert('Selecione pelo menos um pedido!');

		}else{

			var ped = [];

			$('.checkRom:checked').each(function(){
				ped.push($(this).val());
			});

			$.ajax
			({
				url:'data/movimento/modal/m_ins_minuta.php',
				method:'POST',
				data:{
					nr_ped:ped
				},
				success:function(j)
				{
					$('#retModalExp').html(j);
				}
			});
		}
	});
});

$(document).ready(function(){

	$(document).on('click', '#btnLibMinuta', function(){
		event.preventDefault();
		$('#btnLibMinuta').prop("disabled", true);
		var cod_min = $(this).val();
		$.ajax
		({
			url:"data/movimento/libera_minuta.php",
			method:"POST",
			dataType:'json',
			data:{cod_min:cod_min},
			success:function(j)
			{

				if(j.info == 0){

					alert("Romaneio liberado para saída!");      
					$('#retornoConfExp').load('data/movimento/pedido_sql_romaneio.php');

				}else if(j.info == 1){

					alert("Erro no cadastro!");

				}else if(j.info == 2){

					alert("Não há produtos cadastrados para conferência!");

				}
			}
		});
		$('#btnLibMinuta').prop("disabled", false);
		return false;
	});

	$(document).on('click', '#btnDtlMinuta', function(){
		event.preventDefault();
		var cod_min = $(this).val();
		$.ajax
		({
			url:'data/movimento/modal/m_dtl_minuta.php',
			method:'POST',
			data:{
				cod_min:cod_min
			},
			success:function(j)
			{
				$('#retModalExp').html(j);
			}
		});
	});

	$(document).on('click','#btnSaveUpdMinuta',function(){
		event.preventDefault();
		if(confirm("Confirma alteração do romaneio?")){
			$("#btnSaveUpdMinuta").prop("disabled", true);

			var cod_minuta 		= $('#listPedRom').attr("data-min");
			var dt_minuta 		= $('#dt_minuta').val();
			var hr_entrada 		= $('#hr_entrada').val();
			var hr_saida 		= $('#hr_saida').val();
			var nr_placa 		= $('#nr_placa').val();
			var tp_veiculo 		= $('#tp_veiculo').val();
			var ds_transporte 	= $('#ds_transporte').val();
			var km_ini 			= $('#km_ini').val();
			var km_fim 			= $('#km_fim').val();
			var nr_averba 		= $('#nr_averba').val();
			var fl_comprovante 	= $('#fl_comprovante').val();
			var ds_tipo 		= $('#ds_tipo').val();
			var ds_obs 			= $('#ds_obs').val();

			$.ajax
			({
				url:'data/movimento/upd_romaneio.php',
				method:'POST',
				data:{
					cod_minuta: 	cod_minuta,
					dt_minuta: 		dt_minuta,
					hr_entrada: 	hr_entrada,
					hr_saida: 		hr_saida,
					nr_placa: 		nr_placa,
					tp_veiculo: 	tp_veiculo,
					ds_transporte: 	ds_transporte,
					km_ini: 		km_ini,
					km_fim: 		km_fim,
					nr_averba: 		nr_averba,
					fl_comprovante: fl_comprovante,
					ds_tipo: 		ds_tipo,
					ds_obs: 		ds_obs
				},
				success:function(j)
				{
					alert(j);    
					$('#retornoConfExp').load('data/movimento/pedido_sql_romaneio.php');
				}
			});
			$("#btnSaveUpdMinuta").prop("disabled", false);
		}
		return false;
	});
});

$(document).ready(function(){
	$(document).on('click','#btnSaveDemPrd',function(e) {
		if(confirm("Confirma a inclusão das informações?")){
			event.preventDefault();
			var nr_dem = $(this).closest('tr').find('#nr_dem').text();
			var vlr_dem = $(this).closest('tr').find('#vlr_dem').text();
			var nr_ped = $(this).val();
			$.ajax
			({  
				url:"data/movimento/upd_pedido_dem.php",  
				method:"POST",  
				data:{
					nr_dem: 	nr_dem,
					vlr_dem: 	vlr_dem,
					nr_ped: 	nr_ped
				},
				success:function(data)
				{

					alert(data);
				}  
			});         
			return false;
		}
	});

	$(document).on('click', '#btnADelAloc', function(){
		var cod_est = $(this).val();
		if(confirm("Confirma a exclusão da alocação?")){
			$.ajax
			({
				url:"data/movimento/del_aloc.php",
				method:"POST",
				data:{cod_est:cod_est},
				success:function(data)
				{
					alert(data);
					$('#info_aloca').load('data/movimento/alocar_list.php');
				}
			});
		}
	});

	$(document).on('click','#btnPesquisaPedidoPrd',function(e){
		event.preventDefault();
		var nr_mat = $('#nr_matricula_prd').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_matricula.php",
			method:"POST",
			data:{nr_mat:nr_mat},
			beforeSend:function(j){
				$("#retorno_prd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retorno_prd').html(data);
			}
		});
	});

	$(document).on('click','#btnPesquisaNomePrd',function(e){
		event.preventDefault();
		var ds_nome = $('#ds_nome_prd').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_nome.php",
			method:"POST",
			data:{ds_nome:ds_nome},
			beforeSend:function(j){
				$("#retorno_prd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retorno_prd').html(data);
			}
		});
	});

	$(document).on('click','#btnPesquisaDocmaterialPrd',function(e){
		event.preventDefault();
		var doc_mat = $('#doc_material_prd').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_produto_doc.php",
			method:"POST",
			data:{doc_mat:doc_mat},
			beforeSend:function(j){
				$("#retorno_prd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retorno_prd').html(data);
			}
		});
	});

	$(document).on('click','#btnPesquisaProdutoPrd',function(e){
		event.preventDefault();
		var cod_prd = $('#produto_prd').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_produto_prd.php",
			method:"POST",
			data:{cod_prd:cod_prd},
			beforeSend:function(j){
				$("#retorno_prd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retorno_prd').html(data);
			}
		});
	});
});

$(document).ready(function() {
	$(document).on('change', '#cod_prod_cliente', function(){
		$('#tarProduto').hide();
		$.getJSON('data/inventario/consulta_inv_produto.php?search=',{id_parte: $(this).val(),ajax: 'true'}, function(j){
			for (var i = 0; i < j.length; i++) {

				if(j[i].cod_produto){

					var options = '<input type="text" class="form-control" id="nm_produto" name="" value="' +" Produto: "+ j[i].nm_produto +'" readonly="true">';
					$('#id_produto').val(j[i].cod_produto);

				} else {

					var options = '<input type="text" class="form-control" id="nm_produto" name="" value="' + j[i].erro + '" readonly="true">';

				}

			}
			$('#tarProduto').html(options).show();

		});
		return false;
	});
});

$(document).ready(function(){
	$(document).on('click','#btnPesquisaPedidoSep',function(e){
		event.preventDefault();
		var nr_ped = $('#nr_pedido_sep').val();
		$.ajax
		({
			url:"data/movimento/list_coleta_ped.php",
			method:"POST",
			data:{nr_ped:nr_ped},
			beforeSend:function(j){
				$("#infoSepara").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#infoSepara').html(data);
			}
		});
	});

	$(document).on('click','#btnPesquisaDocmaterialSep',function(e){
		event.preventDefault();
		var doc_mat = $('#doc_material_Sep').val();
		$.ajax
		({
			url:"data/movimento/list_coleta_doc.php",
			method:"POST",
			data:{doc_mat:doc_mat},
			beforeSend:function(j){
				$("#infoSepara").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#infoSepara').html(data);
			}
		});
	});

	$(document).on('click', '#btnSaveSep', function(){
		var nr_ped = [];
		var id_sep = $('#id_sep').val();

		$('.checkSep:checked').each(function(){
			nr_ped.push($(this).val());
		});

		if( $('.checkSep:checked').length == 0 ){

			alert('Selecione pelo menos um pedido!');

		}else{

			if($('#id_sep').find(':selected').val() == ""){

				alert('Selecione o separador!');

			}else{

				if(confirm("Tem certeza que deseja iniciar coleta dos pedidos selecionados?")){

					$.ajax
					({
						url:"data/movimento/libera_coleta_new.php",
						method:"POST",
						data:{
							nr_ped:nr_ped,
							id_sep:id_sep
						},
						success:function(data)
						{
							alert(data);
							$('#infoSepara').load('data/movimento/list_coleta_sep.php');
						}
					});
				}

			}
		}
		return false;
	});

	$(document).on('click','#btnPesquisaPedidoFin',function(e){
		event.preventDefault();
		var nr_ped = $('#nr_pedido_fin').val();
		$.ajax
		({
			url:"data/movimento/pedido_sql_ped_fin.php",
			method:"POST",
			data:{nr_ped:nr_ped},
			beforeSend:function(j){
				$("#retornoConfEnd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retornoConfEnd').html(data);
			}
		});
	});

	$(document).on('click', '#btnAtualizaCol', function(){
		event.preventDefault();
		$('#btnAtualizaCol').prop("disabled", true);
		var cod_conf 	= $(this).val();
		var cod_col 	= $(this).closest('tr').find('#cod_produto').attr("data-col");	
		var cod_prd 	= $(this).closest('tr').find('#cod_produto').text();		
		var nr_ped 		= $(this).attr("data-ped");		
		var id_rua 		= $(this).closest('tr').find('#ds_prateleira').text();
		var id_col 		= $(this).closest('tr').find('#ds_coluna').text();
		var id_alt 		= $(this).closest('tr').find('#ds_altura').text();
		var nr_qtde 	= $(this).closest('tr').find('#nr_qtde').text();
		$.ajax
		({
			url:"data/movimento/atualiza_conf.php",
			method:"POST",
			data:{
				cod_conf:cod_conf,
				cod_col:cod_col,
				cod_prd:cod_prd,
				id_rua:id_rua,
				id_col:id_col,
				id_alt:id_alt,
				nr_ped:nr_ped,
				nr_qtde:nr_qtde
			},
			success:function(data)
			{
				alert(data);
				$('#retornoPedConf').load('data/movimento/list_end_pedido.php?search=',{dtl_ped:nr_ped});
				$('#btnAtualizaCol').prop("disabled", false);
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
		return false;
	});
});

$(document).ready(function(){

	$(document).on('click', '#btnAtualizaConf', function(){
		event.preventDefault();
		$('#btnAtualizaConf').prop("disabled", true);
		var cod_exp 		= $(this).val();
		var nr_qtde_exp 	= $(this).closest('tr').find('#nr_qtde_exp').text();	
		var nr_ped_exp		= $(this).attr("data-ped");		
		$.ajax
		({
			url:"data/movimento/atualiza_exp.php",
			method:"POST",
			data:{
				cod_exp:cod_exp,
				nr_qtde_exp:nr_qtde_exp
			},
			success:function(data)
			{
				alert(data);
				$('#retornoConfPed').load('data/movimento/list_exp_pedido.php?search=',{dtl_ped:nr_ped_exp});
				$('#btnAtualizaConf').prop("disabled", false);
				$.ajax
				({
					url:"data/movimento/resumo_pedido_ind.php",
					dataType:'json',
					data: {nr_ped:nr_ped_exp},
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
		return false;
	});
});

$(document).ready(function(){
	$(document).on('click','#btnDelPedRomaneio',function(){
		event.preventDefault();
		var sts = $(this).attr("data-st");

		if(sts == "A"){

			if(confirm("Confirma a exclusão do pedido?")){
				$('#btnDelPedRomaneio').prop("disabled", true);
				var nr_ped = $(this).val();

				$.ajax
				({
					url:"data/movimento/del_ped_romaneio.php",
					method:"POST",
					data:{
						nr_ped:nr_ped
					},
					success:function(data){

						alert(data);
					}
				});

				$('#btnDelPedRomaneio').prop("disabled", false);
				return false;
			}

		}else{

			alert("Romaneio não pode ser alterado.");

		}
	});
});

$(document).ready(function(){
	var nivel = "<?php echo $fl_nivel; ?>";
	$('#insMb52').click(function(e){
		event.preventDefault();
		if(nivel < '6'){
			$('#insMb52').prop("disabled", true);
			alert('Você não tem acesso a esse menu!');
		}else{
			$('#conteudo').load('importa_mb52.php');
			$('#insMb52').prop("disabled", false);
		}
	});
});

$(document).ready(function(){
	$(document).on('click','#btnGeraPedSapCon',function(e){
		event.preventDefault();
		$.ajax
		({
			url:"gera_pedido_sap_con.php",
			method:"POST",
			beforeSend:function(j){
				$("#retSap").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			},
			success:function(data)
			{
				$('#retSap').html(data);
			}
		});
	});

	$(document).on('click','#BtnImpPedSapCon',function(e){
		event.preventDefault();
		$('#retornoPed').load('importa_sap_con.php');
	});
});

$(document).ready(function(){
	$('#ConsEstoqueGer').click(function(e){
		event.preventDefault();
		$('#conteudo').load('consulta_estoque_geral.php');
	});

	$(document).on('click', '#btnConsultaEstoqueGeral', function(){
		$('#formConsultaEstoqueGeral').ajaxForm({
			target:'#locais',
			url:'data/armazem/locais_list_detalhe_geral.php',
			beforeSend:function(j){
				$("#locais").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
			}
		});
	});
});

$(document).ready(function(){

	$(document).on('click', '#btnFormUpdProduto', function(){
		event.preventDefault();
		$.post("data/produto/upd_produto.php", $("#formUpdProduto").serialize(), function(data) {
			alert(data);
		});
		return false;
	});

	$(document).on('click','#btnPesqEstGeralGeral',function(e){
		event.preventDefault();
		$('#retornoEstGer').load('data/armazem/locais_list_geral.php');
		return false;
	});
});

</script>