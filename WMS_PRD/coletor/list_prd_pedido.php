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

$dados_ped = $_GET['dados_ped'];
$pieces = explode("-", $dados_ped);
$nr_pedido = trim($pieces[0]);

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_ped = "select t1.nr_pedido, t1.produto, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.cod_almox, t4.ds_almox, (
CASE 
WHEN t1.nr_qtde_exp IS NULL
THEN 'NÃO CONFERIDO'
ELSE 'CONFERIDO'
END
) as status
from tb_pedido_coleta_produto t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
left join tb_pedido_coleta t3 on t1.nr_pedido = t3.nr_pedido
left join tb_almox t4 on t3.cod_almox = t4.cod_almox
where t1.nr_pedido = '$nr_pedido'
group by t1.produto
order by t1.produto";
$res_ped = mysqli_query($link, $sql_ped);

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="expede_onda.php?dados_ped=<?php echo $dados_ped;?>" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
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
										<h5>PICKING: <?php echo $nr_pedido;?></h5>
									</div>
									<table data-role="table" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">
										<thead>
											<tr style="font-size: 12px">
												<th>CÓDIGO</th>
												<th>PRODUTO</th>
												<th>SITUAÇÃO</th>
												<th></th>
											</tr>
										</thead>
										<tbody style="font-size: 10px">
											<?php
											while ($dados_ped = mysqli_fetch_assoc($res_ped)) {?>
												<tr>
													<td><?php echo $dados_ped['cod_prod_cliente']; ?></td>
													<td><?php echo $dados_ped['nm_produto']; ?></td>
													<td>
														<?php 
															if($dados_ped['status'] == "CONFERIDO"){

																echo "<span style='background-color: #98FB98'>".$dados_ped['status']."</span>"; 

															}else{

																echo "<span style='background-color: #A52A2A;color:white'>".$dados_ped['status']."</span>"; 

															}
														?>														
													</td>
													<td><?php echo "<hr>"; ?></td>
												</tr>
											<?php }?>
										</tbody>
									</table>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>
</div>