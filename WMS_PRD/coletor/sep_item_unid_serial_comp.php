<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

if (isset($_POST['nr_pedido'])) {

	$nr_pedido = $_POST['nr_pedido'];

} else {

	$nr_pedido = $_GET['cod_ped'];

}

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_ped = "select t1.cod_col,t1.nr_pedido, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, sum(t1.nr_qtde_col) as nr_qtde_col, t1.nr_qtde_conf, t2.cod_produto, t2.nm_produto, t2.cod_prod_cliente, t3.nome, t1.cod_estoque, t4.fl_status, COALESCE(t5.nr_qtde,0) as nr_qtde
from tb_coleta_pedido t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
left join tb_armazem t3 on t1.ds_galpao = t3.id
left join tb_posicao_pallet t4 on t1.cod_estoque = t4.cod_estoque
left join tb_pedido_conferencia t5 on t1.nr_pedido = t5.nr_pedido and t1.produto = t5.produto
where t1.nr_pedido = '$nr_pedido' and (t1.fl_status = 'M' or t1.fl_status = 'D' or t1.fl_status = 'F') and t1.fl_status <> 'E'
group by t1.produto, t1.cod_estoque
order by t1.ds_prateleira, t1.ds_coluna + 0, t1.ds_altura, t1.produto";
$res_ped = mysqli_query($link, $sql_ped);

// NOVA CONSULTA COM ORDEM CORRETA - NAO SAI OS QUE NAO TEM ENDERECO

$sql_total = "select coalesce(sum(nr_qtde),0) as totalConf 
from tb_pedido_conferencia
where nr_pedido = '$nr_pedido'";
$res_total = mysqli_query($link, $sql_total);
while ($dados=mysqli_fetch_assoc($res_total)) {
	$totalConf=$dados['totalConf'];
}

$sql_totalQtde = "select coalesce(sum(nr_qtde),0) as totalQtde
from tb_pedido_coleta_produto
where nr_pedido = '$nr_pedido' and fl_status <> 'E'";
$res_totalQtde = mysqli_query($link, $sql_totalQtde);
while ($dados_qtde=mysqli_fetch_assoc($res_totalQtde)) {
	$totalQtde=$dados_qtde['totalQtde'];
}

$link->close();

?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="picking_serial_comp.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div>
					<div role="content">
						<form id="formPedido">
							<fieldset>
								<div class="form-group">
									<h5 style="font-size: 12px">Pedido número: <?php echo $nr_pedido;?> - Qtde pedido: <?php echo $totalQtde;?> - Coletado: <?php echo $totalConf;?></h5>
								</div>
								<h2 class="fimPedido" id="retExpEnd1" style="background-color: #98FB98"></h2>
								<h2 class="fimPedido" id="retExpEnd2" style="background-color: #F08080"></h2>
								<table data-role="table">
									<thead>
										<tr style="font-size: 11px">
											<th>CÓDIGO</th>
											<th>ENDEREÇO</th>
											<th>QTDE</th>
											<th>COLETADO</th>
											<th></th>
										</tr>
									</thead>
									<tbody style="font-size: 11px">
										<?php
										while ($dados_ped = mysqli_fetch_assoc($res_ped)) {?>
											<tr class="tblRows" data_prd="<?php echo $dados_ped['cod_produto']; ?>" data_rua="<?php echo $dados_ped['ds_prateleira']; ?>" data_col="<?php echo $dados_ped['ds_coluna']; ?>" data_alt="<?php echo $dados_ped['ds_altura']; ?>" data_qtd="<?php echo $dados_ped['nr_qtde_col']; ?>"  data_glp="<?php echo $dados_ped['ds_galpao']; ?>">
												<td><?php echo $dados_ped['cod_prod_cliente']." - ".$dados_ped['nm_produto']; ?></td>
												<td><?php echo $dados_ped['ds_prateleira']."-".$dados_ped['ds_coluna']."-".$dados_ped['ds_altura']; ?></td>
												<td class="qtde" data-qtde="<?php echo $dados_ped['nr_qtde_col']; ?>" style="text-align: left;"><?php echo $dados_ped['nr_qtde_col']; ?></td>
												<td class="total" id="total" data-conf="<?php echo $dados_ped['nr_qtde_conf']; ?>" style="text-align: left;"><?php echo $dados_ped['nr_qtde']; ?></td>
												<td>
													<a href="conf_unid_serial_comp.php?cod_ped=<?php echo $nr_pedido;?>&cod_prd=<?php echo $dados_ped['cod_prod_cliente'];?>&rua=<?php echo $dados_ped['ds_prateleira'];?>&col=<?php echo $dados_ped['ds_coluna']; ?>&alt=<?php echo $dados_ped['ds_altura']; ?>&qtd=<?php echo $totalQtde; ?>&galpao=<?php echo $dados_ped['ds_galpao']; ?>&cod_estoque=<?php echo $dados_ped['cod_estoque']; ?>&cod_col=<?php echo $dados_ped['cod_col']; ?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
														<button type="submit" class="ui-btn ui-btn-b" id="" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb;float: right">INICIAR</button>
													</a><br>
													<a href="conf_unid_serial_range.php?cod_ped=<?php echo $nr_pedido;?>&cod_prd=<?php echo $dados_ped['cod_prod_cliente'];?>&rua=<?php echo $dados_ped['ds_prateleira'];?>&col=<?php echo $dados_ped['ds_coluna']; ?>&alt=<?php echo $dados_ped['ds_altura']; ?>&qtd=<?php echo $totalQtde; ?>&galpao=<?php echo $dados_ped['ds_galpao']; ?>&cod_estoque=<?php echo $dados_ped['cod_estoque']; ?>&cod_col=<?php echo $dados_ped['cod_col']; ?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
														<button type="submit" class="ui-btn ui-btn-b" id="" style="background-color: #000080;text-shadow: none;color:white;border-color: #fdfbfb;float: right">INSERIR RANGE</button>
													</a><br>
													<a href="list_prd_unid_serial.php?dados_ped=<?php echo $nr_pedido;?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
														<button type="button" class="btn btn-primary btn-sm" style="background-color: #2E8B57;text-shadow: none;color:white;border-color: #fdfbfb">SERIAIS</button>
													</a><br>
												</td>
											</tr>
										<?php }?>
									</tbody>
								</table>
							</fieldset>
							<h2 id="retConfPick"></h2>
							<fieldset>
								<div class="form-group">
									<!--a href="conf_cego_serial.php?cod_ped=<?php echo $nr_pedido;?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
										<button type="submit" class="ui-btn ui-btn-b" id="" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb;float: right">INICIAR</button>
									</a><br>
									<a href="conf_cego_serial_range.php?cod_ped=<?php echo $nr_pedido;?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
										<button type="submit" class="ui-btn ui-btn-b" id="" style="background-color: #000080;text-shadow: none;color:white;border-color: #fdfbfb;float: right">INSERIR RANGE</button>
									</a><br>
									<a href="list_prd_serial.php?dados_ped=<?php echo $nr_pedido;?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
										<button type="button" class="btn btn-primary btn-sm" style="background-color: #2E8B57;text-shadow: none;color:white;border-color: #fdfbfb">SERIAIS</button>
									</a-->
									<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnFinConfPedCompSerial" value="<?php echo $nr_pedido;?>" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">FINALIZAR</button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</article>
		</div>
	</div>
</div>