<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
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

$sql_ped = "select t1.nr_pedido, t1.produto, t1.nr_qtde as nr_qtde_col, t1.nr_qtde_conf, t1.nr_qtde_exp, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.cod_almox, t3.ds_destino
from tb_pedido_coleta_produto t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
left join tb_pedido_coleta t3 on t1.nr_pedido = t3.nr_pedido
where t1.fl_empresa = '$cod_cli' and t1.nr_pedido = '$nr_pedido' and t1.fl_status <> 'C'
group by t1.produto
order by t1.produto";
$res_ped = mysqli_query($link, $sql_ped);

$sql_total = "select coalesce(sum(nr_qtde_conf),0) as totalConf 
from tb_coleta_pedido
 where nr_pedido = '$nr_pedido'";
$res_total = mysqli_query($link, $sql_total);
while ($dados=mysqli_fetch_assoc($res_total)) {
	$totalConf=$dados['totalConf'];
}

$sql_totalQtde = "select t1.cod_almox, t1.ds_destino, t2.ds_almox
from tb_pedido_coleta t1
left join tb_almox t2 on t1.cod_almox = t2.cod_almox
 where nr_pedido = '$nr_pedido'";
$res_totalQtde = mysqli_query($link, $sql_totalQtde);
while ($dados_qtde=mysqli_fetch_assoc($res_totalQtde)) {
	$cod_almox=$dados_qtde['cod_almox'];
	$ds_destino=$dados_qtde['ds_destino'];
	$ds_almox=$dados_qtde['ds_almox'];
}

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="expede_ck.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header>
						<h4>Expedição por unidade</h4>
					</header>
					<div role="content">
						<div class="jarviswidget-editbox">
						</div>
						<div class="widget-body">
							<form id="formPedido">
								<fieldset>
									<div class="form-group">
										<h5>Pedido número: <?php echo $nr_pedido;?> - Destino: <?php echo $cod_almox."-".$ds_almox;?></h5>
									</div>
								</fieldset>
								<h2 class="fimPedido" id="retExpEnd1" style="background-color: #98FB98"></h2>
								<h2 class="fimPedido" id="retExpEnd2" style="background-color: #F08080"></h2>
								<fieldset>
									<table data-role="table" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">
										<thead>
											<tr style="font-size: 12px">
												<th>CÓDIGO</th>
												<th>PRODUTO</th>
												<th>CONFERIDO</th>
												<th></th>
											</tr>
										</thead>
										<tbody style="font-size: 10px">
											<?php
											while ($dados_ped = mysqli_fetch_assoc($res_ped)) {?>
												<tr class="tblRows" data_prd="<?php echo $dados_ped['cod_produto']; ?>" data_qtd="<?php echo $dados_ped['nr_qtde_col']; ?>">
													<td><?php echo $dados_ped['cod_prod_cliente']; ?></td>
													<td><?php echo $dados_ped['nm_produto']; ?></td>
													<td class="total" id="total" data-conf="<?php echo $dados_ped['nr_qtde_exp']; ?>"><?php echo $dados_ped['nr_qtde_exp']; ?></td>
													<td>
														<a href="expede_cego.php?cod_ped=<?php echo $nr_pedido;?>&cod_prd=<?php echo $dados_ped['cod_prod_cliente'];?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
															<button type="submit" class="ui-btn ui-btn-b" id="" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb;float: right">Iniciar</button>
														</a><br><br><br><hr>
													</td>
												</tr>
											<?php }?>
										</tbody>
									</table>
								</fieldset>
								<h2 id="retConfPick"></h2>
								<fieldset>
									<div class="form-group">
										<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnFinConfExpCego" value="<?php echo $nr_pedido;?>" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">Finalizar</button>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>
</div>