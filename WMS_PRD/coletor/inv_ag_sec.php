<?php
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

if (isset($_POST['nr_inventario2'])) {

	$nr_inventario = $_POST['nr_inventario2'];

} else {

	$nr_inventario = $_GET['nrInvConf'];

}

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

/*$sql_ped = "select t1.nr_pedido, t1.produto, t4.ds_galpao, t4.ds_prateleira, t4.ds_coluna, t4.ds_altura, sum(t1.nr_qtde) as nr_qtde_col, t1.nr_qtde_conf, t2.cod_produto, t2.cod_prod_cliente, t3.nome
from tb_pedido_coleta_produto t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
left join tb_posicao_pallet t4 on t1.produto = t4.produto
left join tb_armazem t3 on t4.ds_galpao = t3.id
where t1.nr_pedido = '$nr_pedido' and t1.fl_status = 'C' and t4.nr_qtde > 0
group by t1.produto, t4.cod_estoque
order by t4.ds_prateleira, t4.ds_coluna, t4.ds_altura";
$res_ped = mysqli_query($link, $sql_ped);

$sql_total = "select sum(nr_qtde) as totalQtde, sum(coalesce(nr_qtde_conf,0)) as totalConf from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido'";
$res_total = mysqli_query($link, $sql_total);
while ($dados=mysqli_fetch_assoc($res_total)) {
	$totalQtde=$dados['totalQtde'];
	$totalConf=$dados['totalConf'];
}*/

$link->close();
?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>INVENTÁRIO - SEGUNDA CONTAGEM</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white;padding-top: 1em">
		
		<div class="row">
			<!--div>
				<h4 id="">Produto:<?php echo $produto;?></h4>
			</div>
			<div>
				<h4 id="">Endereço:<?php echo $local;?> - Itens a coletar:<?php echo $qtd;?></h4>
			</div-->

			<legend>Selecione o endereço</legend>
			<form id="form_conf_inv" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="localInvAg2" name="localInvAg2" class="form-control" required="true" autofocus="true"/>
						<input type="hidden" id="nrInvConf" name="nrInvConf" class="form-control" value="<?php echo $nr_inventario;?>">
					</div>
					<div class="form-group">
						<h4 id="retInvTransf"></h4>
					</div>
				</div>
			</form>
		</div>
		<h2 id="retExpEnd"></h2>
		<div class="inventario">
			<legend>Selecione o produto</legend>
			<form id="" method="" action="">
				<div class="row" id="confProdInv">
					<div class="conferido" id="conferido">
						<h4 id="TotalInventariado">Produto:</h4>
					</div>
					<form id="form_conf_prod" method="" action="">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" id="barcodeInvAg2" name="barcodeInvAg2" class="form-control"/>
							</div>
						</div>
					</form>
				</div>
			</form>
		</div>
		<div class="qtdeInvTransf">
			<div class="row" id="insQtdeInv">
				<form id="formConfInv" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<legend>Qtde de volumes</legend>
							<input type="text" id="nr_vol_inv" name="nr_vol_inv" class="form-control" required="true">
							<legend>Qtde de itens</legend>
							<input type="text" id="nr_qtde_inv" name="nr_qtde_inv" class="form-control" required="true">
						</div>
						<div class="form-group">
							<button type="button" id="btnSaveConfProdInvAg2" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-floppy-disk"></span> Salvar
							</button>
						</div>
						<div class="form-group">
							<h4 id="retInvQtdeAg2"></h4>
						</div>
					</div>
				</form>
			</div>
		</div>
		<a href="inventario_ag.php" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
	</div>
</div>
<!--script type="text/javascript">
	$(document).keypress(function(e) {
		if (e.which == 13) {
			alert("funciona");
		}
	});
</script-->