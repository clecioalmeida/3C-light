<?php
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto = $_GET['cod_prd'];
$cod_estoque = $_GET['cod_estq'];
$nr_qtde = $_GET['qtd_prd'];
$cont_1 = $_GET['contp'];
$cont_2 = $_GET['conts'];
$cont_3 = $_GET['contt'];
$ds_galpao = $_GET['ds_galpao'];
$ds_prateleira = $_GET['ds_prateleira'];
$ds_coluna = $_GET['ds_coluna'];
$ds_altura = $_GET['ds_altura'];
$cod_prod_cliente = $_GET['cod_cli'];
$id_inv = $_GET['id_inv'];
$id_tar = $_GET['id_tar'];
/*
$sel_end="select cont_1 from tb_inv_conf where id_tar = '$id_tar'";
$res_end = mysqli_query($link, $sel_end);
while ($dados=mysqli_fetch_assoc($res_end)) {
	$contp = $dados['cont_1'];
}

if($contp == 0){

	echo


}
*/
$sql_torre = "select ds_apelido from tb_armazem where id = '$ds_galpao'";
$res_torre = mysqli_query($link, $sql_torre);
while ($dados=mysqli_fetch_assoc($res_torre)) {
	$ds_apelido = $dados['ds_apelido'];
}
$link->close();
?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>CONTAGEM</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white;padding-top: 1em">
		
		<div class="row">
			<div>
				<h4 id="">Produto:<?php echo $cod_prod_cliente;?></h4>
			</div>
			<div>
				<h4 id="">Endereço:<?php echo $ds_apelido.$ds_prateleira.$ds_altura.$ds_coluna;?></h4>
			</div>

			<legend>Selecione o endereço</legend>
			<form id="form_conf_end" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="localInv" name="localInv" class="form-control" required="true">
						<input type="hidden" id="cont_1" name="cont_1" class="form-control" value="<?php echo $cont_1;?>">
						<input type="hidden" id="cont_2" name="cont_2" class="form-control" value="<?php echo $cont_2;?>">
						<input type="hidden" id="cont_3" name="cont_3" class="form-control" value="<?php echo $cont_3;?>">
						<input type="hidden" id="cod_estoque" name="cod_estoque" class="form-control" value="<?php echo $cod_estoque;?>">
						<input type="hidden" id="id_tar" name="id_tar" class="form-control" value="<?php echo $id_tar;?>">
					</div>
					<div class="form-group">
					</div>
				</div>
			</form>
		</div>
		<div class="contP" style="display: none">
			<legend>Primeira contagem</legend>
			<div class="row" id="confProdPick">
				<div>
					<h4 id="">Total:<?php echo $nr_qtde;?></h4>
				</div>

				<div class="conferido" id="conferidoP">
					<h4 id="TotalConferidoP">Conferido:</h4>
				</div>
				<form id="form_conf_prod" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input tabindex="1" type="text" id="barcodeConfInvP" name="barcodeConfInvP" class="form-control" required="true">
						</div>
						<div class="form-group">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="contS" style="display: none">
			<legend>Segunda contagem</legend>
			<div class="row" id="confProdPick">
				<div>
					<h4 id="">Total:<?php echo $nr_qtde;?></h4>
				</div>

				<div class="conferido" id="conferidoS">
					<h4 id="TotalConferidoS">Conferido:</h4>
				</div>
				<form id="form_conf_prod" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input tabindex="1" type="text" id="barcodeConfInvs" name="barcodeConfInvs" class="form-control" required="true">
						</div>
						<div class="form-group">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="contT" style="display: none">
			<legend>Terceira contagem</legend>
			<div class="row" id="confProdPick">
				<div>
					<h4 id="">Total:<?php echo $nr_qtde;?></h4>
				</div>

				<div class="conferido" id="conferidoT">
					<h4 id="TotalConferidoT">Conferido:</h4>
				</div>
				<form id="form_conf_prod" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input tabindex="1" type="text" id="barcodeConfInvT" name="barcodeConfInvT" class="form-control" required="true">
						</div>
						<div class="form-group">
						</div>
					</div>
				</form>
			</div>
		</div>
		<a href="inv_produtos.php?id_inv=<?php echo $id_inv;?>&id_local=<?php echo $ds_galpao;?>&id_rua=<?php echo $ds_prateleira;?>&id_coluna=<?php echo $ds_coluna;?>&id_altura=<?php echo $ds_altura;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
		<a href="inv_produtos.php?id_tar=<?php echo $id_tar;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb">Finalizar</a>
	</div>
</div>