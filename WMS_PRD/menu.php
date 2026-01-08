<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$fl_nivel 	= $_SESSION["fl_nivel"];
}

?>
<?php

require_once 'data/movimento/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$user = "select nm_user, fl_nivel, case coalesce(avatar,0) when 0 then 'user.png' else avatar end as avatar from tb_usuario where id = '$id'";
$usuario = mysqli_query($link, $user);

if(mysqli_num_rows($usuario) > 0){

	$dados = mysqli_fetch_assoc($usuario);

	$user 		= $dados['nm_user'];
	$fl_nivel 	= $dados['fl_nivel'];
	$img_user 	= $dados['avatar'];

	?>
	<div class="login-info">
		<span>
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<img src="img/avatars/<?php echo $img_user; ?>" alt="me" class="online" />
				<span id="btnLoadProfile">
					<?php echo $user; ?>
				</span>
				<i class="fa fa-angle-down"></i>
			</a>

		</span>
	</div>
	<nav>
		<ul>
			<li>
				<a href="#" title="Administração"><i class="fa fa-lg fa-fw fa-pencil-square"></i> <span class="menu-item-parent">Administração</span></a>
				<ul>
					<li>
						<a href="#" title="Importação de produtos" id="recImpProd" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importação de produtos</span></a>
					</li>
					<li>
						<a href="#" title="Importação de fornecedores" id="recImpFor" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importação de fornecedores</span></a>
					</li>
					<li>
						<a href="#" title="Importação de grupos" id="recImpGrp" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importação de grupos</span></a>
					</li>
					<li>
						<a href="#" title="Gerador de endereços" id="cadEnd" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Gerador de endereços</span></a>
					</li>
					<li>
						<a href="#" title="Gerador de janelas" id="cadJan" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Gerar janelas de recebimento</span></a>
					</li>
					<li>
						<a href="#" title="Gerador de endereços" id="cadInvImp" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importar inventário</span></a>
					</li>
					<li>
						<a href="#" title="Estorno de pedidos em coleta" id="estPedCol" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Estorno de pedidos em coleta</span></a>
					</li>
					<li>
						<a href="#" title="Importação de cadastro de almox" id="impAlmox" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importação de cadastro de almox</span></a>
					</li>
					<li>
						<a href="#" title="Importação de cadastro de almox" id="insMb52" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importação MB52</span></a>
					</li>
					<li>
						<a href="#" title="Importação de cadastro de almox" id="insDpto" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importação Departamentos</span></a>
					</li>
					<li>
						<a href="#" title="Importação de cadastro de almox" id="insFunc" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importação Funcionários</span></a>
					</li>
					<li>
						<a href="#" title="Importação de cadastro de almox" id="insInv" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importação de Inventário</span></a>
					</li>
					<li>
						<a href="#" title="Importação de cadastro de almox" id="insSld" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Atualiza saldo</span></a>
					</li>
					<li>
						<a href="#" title="Importação de valores de estoque" id="insVlrEst" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importa valores</span></a>
					</li>
					<li>
						<a href="#" title="Importação de valores de estoque" id="insTpPrd" data-nivel="<?php echo $fl_nivel;?>"><span class="menu-item-parent">Importa tipo de produto</span></a>
					</li>
				</ul>
			</li>
			<li id="mDashboard">
				<a href="#" title="Dashboard"><i class="fa fa-lg fa-fw fa-dashboard"></i> <span class="menu-item-parent">Dashboard</span></a>
				<ul>
					<li>
						<a href="#" title="Operação" id="dashOp"><span class="menu-item-parent">Operação</span></a>
					</li>
					<li>
						<a href="#" title="Atendimento" id=""><span class="menu-item-parent">Atendimento</span></a>
					</li>
					<li>
						<a href="#" title="Recebimento" id="dashRec"><span class="menu-item-parent">Recebimento</span></a>
					</li>
					<li class="">
						<a href="#" title="Estoques" id="dashEstoque"><span class="menu-item-parent">Estoques</span></a>
					</li>
					<li class="">
						<a href="#" class="dashOcupa" title="Ocupação de estoque" id="dashOcupa"><span class="menu-item-parent">Ocupação de estoque</span></a>
					</li>
					<li class="">
						<a href="#" title="Transportes" id=""><span class="menu-item-parent">Transportes</span></a>
					</li>
				</ul>
			</li>
			<li class="top-menu-invisible" id="mCadastro">
				<a href="#"><i class="fa fa-lg fa-fw fa-book txt-color-blue"></i> <span class="menu-item-parent">Cadastros</span></a>
				<ul>
					<li class="">
						<a href="#" title="Empresa" id="empresa"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Empresa</span></a>

					</li>
					<li class="">
						<a href="#" title="Entidades"><i class="fa fa-lg fa-fw fa-picture-o"></i> <span class="menu-item-parent">Entidades</span></a>
						<ul>
							<li>
								<a href="#" title="Clientes" id="cadCliente"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Clientes</span></a>
							</li>
							<li>
								<a href="#" title="Destinatários" id="cadDestinatario"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Destinatários</span></a>
							</li>
							<li>
								<a href="#" title="Fornecedores" id="cadFornecedor"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Fornecedores</span></a>
							</li>
							<li>
								<a href="#" title="Contratos" id="cadContrato"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Contratos</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#"><i class="fa fa-cube"></i> Armazém</a>
						<ul>
							<li>
								<a href="#" title="Dashboard" id="cadGalpao"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Galpão</span></a>
							</li>
							<li>
								<a href="#" title="Dashboard" id="cadLocal"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Locais</span></a>
							</li>
							<li>
								<a href="#" title="Dashboard" id="cadDoca"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Docas</span></a>
							</li>
							<li>
								<a href="#" title="Dashboard" id="listEtq"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Etiquetas</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" id="cadProduto"><i class="fa fa-cube"></i> Produto</a>

					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-gears"></i> <span class="menu-item-parent">Operacional</span></a>
				<ul>
					<li>
						<a href="#" title="Dashboard" id="RecPend"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Recebimento</span></a>
					</li>
					<li>
						<a href="#" title="Dashboard" id="cadMovimento"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Movimentação</span></a>
						<ul>
							<li>
								<a href="#" title="Dashboard" id="cadAloc"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Alocação</span></a>
							</li>
							<li>
								<a href="#" title="Dashboard" id="cadTransf"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Transferência interna</span></a>
							</li>
							<li>
								<a href="#" title="Dashboard" id="cadTransfFeixe"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Transf. por feixe</span></a>
							</li>
							<li>
								<a href="#" title="Pedido" id=""><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Pedido</span></a>
								<ul>
									<li>
										<a href="#" title="Pedidos" id="cadPed"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Pedidos</span></a>
									</li>
									<li>
										<a href="#" title="Novo pedido" id="NovoPed"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Novo pedido</span></a>
									</li>
									<li>
										<a href="#" title="Novo pedido" id="impPedSap"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Importação SAP</span></a>
									</li>
								</ul>
							</li>
							<li>
								<a href="#" title="Coletas" id="ConsCol"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Coletas</span></a>
								<ul>
									<li>
										<a href="#" title="Gerar onda" id="gerOnda"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Gerar onda</span></a>
									</li>
									<li>
										<a href="#" title="Consultar onda" id="consOnda"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Consultar onda</span></a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" title="Cross Docking" id="cadCrossDoc"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Cross Docking</span></a>
					</li>
					<li>
						<a href="#" title="Conferência" id="ConsConf"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Conferência</span></a>
					</li>
					<li>
						<a href="#" title="Manuseio" id="cadManuseio"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Manuseio</span></a>
					</li>
					<li>
						<a href="#" title="Expedição"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Expedição</span></a>
						<ul>
							<li>
								<a href="#" title="Expedição" id="CadExped"></i> <span class="menu-item-parent">Expedição</span></a>
							</li>
							<li>
								<a href="#" title="Notas fiscais de saída" id="CadNfs"><span class="menu-item-parent">NF Saída</span></a>
							</li>
							<li>
								<a href="#" title="Minutas" id="ConsMin"><span class="menu-item-parent">Minutas</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" title="Reversa" id="CadColeta"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Reversa</span></a>
						<ul>
							<li>
								<a href="#" title="Pedidos" id="cadPed"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Coletas</span></a>
							</li>
							<li>
								<a href="#" title="Novo pedido" id="NovoPed"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Rotas</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" title="" id=""><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Consulta</span></a>
						<ul>
							<li>
								<a href="#" title="Produtos alocados" id="consEstoqueProd"><span class="menu-item-parent">Consulta produtos alocados</span></a>
							</li>
							<li>
								<a href="#" title="Produtos não conforme" id="consProdNc"><span class="menu-item-parent">Consulta produtos não conforme</span></a>
							</li>

							<li>
								<a href="#" title="Histórico de produtos" id="consHisProd"><span class="menu-item-parent">Histórico de produto</span></a>
							</li>
							<li>
								<a href="#" title="Dashboard" id="ConsEstoque"><span class="menu-item-parent">Consulta estoque</span></a>
							</li>
							<li>
								<a href="#" title="Dashboard" id="ConsEstoqueGer"><span class="menu-item-parent">Consulta estoque - geral</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" title="Produto não conforme" id="cadNc"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Produto não conforme</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-arrow-right"></i> <span class="menu-item-parent">Portaria</span></a>
				<ul>
					<li>
						<a href="#" title="Entregas pendentes" id="regPortaria"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Registro</span></a>
					</li>
					<li>
						<a href="#" title="Entregas finalizadas" id="repPortaria"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Relatório</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-bolt"></i> <span class="menu-item-parent">Torres</span></a>
				<ul>
					<li>
						<a href="#" class="active" title="Dashboard" id=""><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Cadastro</span></a>
						<ul>
							<li>
								<a href="#" class="active" title="Dashboard" id="CadTorreTipo"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Torre</span></a>
							</li>
							<li>
								<a href="#" class="active" title="Dashboard" id="CadTorreParte"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Parte</span></a>
							</li>
							<li>
								<a href="#" class="active" title="Dashboard" id="CadTorreItem"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Peça</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" class="active" title="Pedidos"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Pedidos</span></a>
						<ul>
							<li>
								<a href="#" class="active" title="Novo pedido" id="CadExpTorre"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Novo pedido</span></a>
							</li>
							<li>
								<a href="#" class="active" title="Novo pedido" id="CadExpFeixe"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Pedido por feixe</span></a>
							</li>
							<li>
								<a href="#" class="active" title="Pedidos" id="PedTorrePen"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Pedidos</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" class="active" title="Consulta saldo de torres"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Consulta</span></a>
						<ul>
							<li>
								<a href="#" class="active" title="Consulta sintética" id="ConsTorComp"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Consulta por Torre</span></a>
							</li>
							<li>
								<a href="#" class="active" title="Consulta analítica" id="ConsTorDtl"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Consulta por Parte</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" class="active" title="Relatórios"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Relatórios</span></a>
						<ul>
							<li>
								<a href="#" class="active" title="Relatório sintético" id="RepTorSaldo"><span class="menu-item-parent">Saldos - Sintético</span></a>
							</li>
							<li>
								<a href="#" class="active" title="Relatório analítico" id="RepTorSaldoDtl"><span class="menu-item-parent">Saldos - analítico</span></a>
							</li>
							<li>
								<a href="#" class="active" title="Relatório analítico" id="RepTorSldEstoque"><span class="menu-item-parent">Saldos - analítico por torre</span></a>
							</li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-check"></i> <span class="menu-item-parent">Gerenciamento</span></a>
				<ul>
					<li>
						<a href="#" title="Qualidade" id=""><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Qualidade</span></a>
						<ul>
							<li>
								<a href="#" title="Ocorrências" id="GesQld"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Ocorrências</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" title="Recursos" id=""><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Recursos</span></a>
						<ul>
							<li>
								<a href="#" title="Equipamentos" id="gesEquip"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Equipamentos</span></a>
								<ul>
									<li>
										<a href="#" title="" id="InsAbs"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Manutenções</span></a>
									</li>
									<li>
										<a href="#" title="" id="InsAbs"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Peças</span></a>
									</li>
									<li>
										<a href="#" title="" id="InsAbs"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Serviços</span></a>
									</li>
								</ul>
							</li>
							<li>
								<a href="#" title="Operadores" id="gesPessoas"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Operadores</span></a>
								<ul>
									<li>
										<a href="#" title="" id="InsAbs"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Absenteísmo</span></a>
									</li>
									<li>
										<a href="#" title="" id="InsAbs"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Cadastro</span></a>
									</li>
									<li>
										<a href="#" title="" id="InsAbs"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Relatórios</span></a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" title="Qualidade" id=""><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Insumos</span></a>
						<ul>
							<li>
								<a href="#" title="Cadastro" id="cadIns"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Cadastro</span></a>
							</li>
							<li>
								<a href="#" title="Reabastecimento" id="GesReab"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Reabastecimento</span></a>
							</li>
							<li>
								<a href="#" title="Consulta" id="ConsIns"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Consulta</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" title="Segurança" id=""><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Segurança</span></a>
						<ul>
							<li>
								<a href="#" title="Ocorrências" id="gesOcorSeg"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Ocorrências</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" title="Fechamento" id="apSaldoMensal"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Apuração mensal</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-truck"></i> <span class="menu-item-parent">Transporte</span></a>
				<ul>
					<li>
						<a href="#" title="Entregas pendentes" id="ConEntrPend"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Entregas</span></a>
					</li>
					<li>
						<a href="#" title="Entregas finalizadas" id="ConEntrFin"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Finalizadas</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-barcode"></i> <span class="menu-item-parent">Inventário</span></a>
				<ul>
					<li>
						<a href="#" title="Programação" id="ConsProg"><span class="menu-item-parent">Programação</span></a>
					</li>
					<li>
						<a href="#" title="Tarefas" id="ConsTar"><span class="menu-item-parent">Tarefas</span></a>
					</li>
					<li>
						<a href="#" title="Imprimir tarefas" id="PrintTar"><span class="menu-item-parent">Imprimir tarefas</span></a>
					</li>
					<li>
						<a href="#" title="Encerrar tarefas" id="encTarLote"><span class="menu-item-parent">Encerrar tarefas</span></a>
					</li>
					<li>
						<a href="#" title="Histórico de inventário" id="HistInv"><span class="menu-item-parent">Histórico</span></a>
					</li>
					<li>
						<a href="#" title="Dashboard" id=""><span class="menu-item-parent">Relatórios</span></a>
						<ul>
							<li>
								<a href="#" title="Fechamento de inventário" id="relEncInv"><span class="menu-item-parent">Fechamento de inventário</span></a>
							</li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-desktop"></i> <span class="menu-item-parent">Comercial</span></a>
				<ul>
					<li>
						<a href="#" title="Dashboard" id="cadParam"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Contratos</span></a>
					</li>
					<li>
						<a href="#" title="Dashboard" id="ConsProg"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Faturamento</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-list-alt"></i> <span class="menu-item-parent">Relatórios</span></a>
				<ul>
					<li>
						<a href="#" title="Movimentação de estoque" id="RepMovEstoque"><span class="menu-item-parent">Mov. de estoque</span></a>
					</li>
					<li>
						<a href="#" title="Saldos de estoque" id="RepSalEstoque"><span class="menu-item-parent">Saldos de estoque</span></a>
					</li>

					<li>
						<a href="#" title="Saldos de estoque" id="RepGiroEstoque"><span class="menu-item-parent">Giro de estoque</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#" id=""><i class="fa fa-lg fa-fw fa-inbox"></i> <span class="menu-item-parent">Mensagens</span> <span id="nlidas" class="badge pull-right inbox-badge margin-right-13"></span></a>	
			</li>
		</ul>
	</nav>


	<span class="minifyme" data-action="minifyMenu">
		<i class="fa fa-arrow-circle-left hit"></i>
	</span>


	<?php

}else{

	?>

	<div class="login-info">
		<span>
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<!--img src="img/avatars/<?php //echo $img_user; ?>" alt="me" class="online" -->
				<span id="btnLoadProfile">
					<h3>Usuário não encontrado.</h3>
				</span>
				<i class="fa fa-angle-down"></i>
			</a>

		</span>
	</div>
	<nav>


	<?php

	}

?>