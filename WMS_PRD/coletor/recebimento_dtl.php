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

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$nm_placa       = $_GET['nm_placa'];
$nm_fornecedor  = $_GET['nm_fornecedor'];

$sql_ped = "SELECT r.cod_recebimento, r.nm_placa, r.nm_fornecedor, r.nm_motorista,
 r.nr_qtde as total_itens, r.nr_serial, r.cod_produto, COALESCE(p.unid,'S/INFO') as unid, r.dt_recebimento_real
 from tb_recebimento_ag r
 left join tb_produto p on r.cod_produto = p.cod_prod_cliente
 where r.fl_status = 'A' and r.nm_fornecedor = '$nm_fornecedor'
 order by r.dt_recebimento_real desc";
$res_ped = mysqli_query($link, $sql_ped);

$link->close();

?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="recebimento.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
				<div class="row">
					<h4>Recebimentos pendentes por produto/serial</h4>
                    <p style="font-size: 10px;">PLACA:<strong><?php echo $nm_placa;?></strong></p>
                    <p style="font-size: 10px;">FORNECEDOR:<strong><?php echo $nm_fornecedor;?></strong></p>
				</div>
				<hr>
				<div class="row">
					<div id="retFinRecDtl"></div>
					<table data-role="table" id="" data-mode="" class="" style="font-size: 10px;">
						<thead>
							<tr>
								<th data-priority="1">Lote</th>
								<th data-priority="2">Data</th>
								<th data-priority="3">Serial</th>
								<th data-priority="4">Qtde</th>
								<th style="width:50%;text-align:center;">Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($dados = mysqli_fetch_assoc($res_ped)) { ?>
								<tr>
									<td><?php echo $dados['cod_produto']; ?></td>
									<td><?php echo $dados['dt_recebimento_real']; ?></td>
									<td><?php echo $dados['nr_serial']; ?></td>
									<td style="text-align: right;">
										<?php 

											if($dados['unid'] == "KG" && strlen($dados['total_itens']) <= 7) {

												echo str_replace(".", ",", $dados['total_itens']) . " kg";
												
											} else if($dados['unid'] == "KG" && strlen($dados['total_itens']) > 7){

												echo $dados['total_itens'] / 1000 . " t";

											}else{

												echo number_format($dados['total_itens'],0) . " " . $dados['unid'];

											}
											
										?>
									</td>
									<td style="text-align: right;">
										<form>
											<a href="recebimento_or_qtde_edit.php?cod_rec=<?php echo $dados['cod_recebimento'];?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
												<input type="button" id="" data-role="none" value="Editar" style="float: right;margin-left: 5px;background-color: #FF4500;text-shadow: none;color:white;border-color: #fdfbfb">
											</a>
											<a href="" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
												<input type="button" id="btnDelRec" data-fn="<?php echo $dados['cod_recebimento'];?>" data-role="none" value="Excluir" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">
											</a>
										</form>
									</td>
								<tr>
								<?php } ?>
						</tbody>
					</table>
				</div>
			</article>
		</div>
	</div>
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
		<p>Argus Soluções para logística</p>
		<p>Copyright 2021 - Argus</p>
	</div>
</div>

<!-- ================== BEGIN custom-js ================== -->
<!-- ================== END custom-js ================== -->
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click', '#btnLogoutHome', function() {
			event.preventDefault();
			$.ajax({
				url: "logout.php",
				method: "GET",
				success: function(j) {
					alert("Saída realizada com sucesso!");
					window.location.replace("index.php");
				}
			});
		});
	});
</script>