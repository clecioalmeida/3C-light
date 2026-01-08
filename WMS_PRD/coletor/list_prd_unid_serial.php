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

$sql_ped = "select t1.cod_pedido, t1.id_produto, t1.n_serie, (
CASE 
WHEN t1.fl_status = 'C'
THEN 'CONFERIDO'
ELSE 'NÃO CONFERIDO'
END
) as status
from tb_nserie t1
where t1.cod_pedido = '$nr_pedido'";
$res_ped = mysqli_query($link, $sql_ped);

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="sep_item_unid_serial.php?cod_ped=<?php echo $nr_pedido;?>" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header>
						<h4>EXPEDIÇÃO POR SERIAL</h4>
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
												<th>SERIAL</th>
												<th>SITUAÇÃO</th>
												<th></th>
											</tr>
										</thead>
										<tbody style="font-size: 10px">
											<?php
											while ($dados_ped = mysqli_fetch_assoc($res_ped)) {?>
												<tr>
													<td><?php echo $dados_ped['id_produto']; ?></td>
													<td><?php echo $dados_ped['n_serie']; ?></td>
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