<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id=$_SESSION["id"];
}
?>
<?php

require_once('xhr/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto = mysqli_real_escape_string($link,$_GET['cod_prd']);
$rua = mysqli_real_escape_string($link,$_GET['rua']);
$col = mysqli_real_escape_string($link,$_GET['col']);
$alt = mysqli_real_escape_string($link,$_GET['alt']);
$qtd = mysqli_real_escape_string($link,$_GET['qtd']);
$galpao = mysqli_real_escape_string($link,$_GET['galpao']);
$nr_pedido = mysqli_real_escape_string($link,$_GET['cod_ped']);

$query_local="select ds_apelido from tb_armazem where id = '$galpao'";
$res_local=mysqli_query($link, $query_local);
while ($dados=mysqli_fetch_assoc($res_local)) {
	$nome = $dados['ds_apelido'];
}

$local=$nome.$rua.$alt.$col;

$query_prd="select nm_produto from tb_produto where cod_produto = '$cod_produto'";
$res_prd=mysqli_query($link, $query_prd);
while ($dados=mysqli_fetch_assoc($res_prd)) {
	$produto = $dados['nm_produto'];
}

$link->close();
?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>PICKING</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white;padding-top: 1em">
		
		<div class="row">
			<div>
				<h4 id="">Produto:<?php echo $produto;?></h4>
			</div>
			<div>
				<h4 id="">Endereço:<?php echo $local;?> - Quantidade:<?php echo $qtd;?></h4>
			</div>

			<legend>Selecione o endereço</legend>
			<form id="form_conf_end" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="local" name="local" class="form-control" required="true">
						<input type="hidden" id="nrPedConf" name="nrPedConf" class="form-control" value="<?php echo $nr_pedido;?>">
						<input type="hidden" id="nrProdConf" name="nrProdConf" class="form-control" value="<?php echo $cod_produto;?>">
						<input type="hidden" id="nrGlpConf" name="nrGlpConf" class="form-control" value="<?php echo $galpao;?>">
						<input type="hidden" id="nrRuaConf" name="nrRuaConf" class="form-control" value="<?php echo $rua;?>">
						<input type="hidden" id="nrColConf" name="nrColConf" class="form-control" value="<?php echo $col;?>">
						<input type="hidden" id="nrAltConf" name="nrAltConf" class="form-control" value="<?php echo $alt;?>">
						<input type="hidden" id="nrQtdConf" name="nrQtdConf" class="form-control" value="<?php echo $qtd;?>">
						<input type="hidden" id="nrEndConf" name="nrEndConf" class="form-control" value="<?php echo $local;?>">
					</div>
					<div class="form-group">
					</div>
				</div>
			</form>
		</div>
		<div class="produto" style="display: none">
			<legend>Selecione o produto</legend>
			<div class="row" id="confProdPick">
				<div>
					<h4 id="">Total:<?php echo $qtd;?></h4>
				</div>

				<div class="conferido" id="conferido">
					<h4 id="TotalConferido">Conferido:</h4>
				</div>
				<form id="form_conf_prod" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input tabindex="1" type="text" id="barcodeConf" name="barcodeConf" class="form-control" required="true" style="text-align: right;" autofocus="true"/>
						</div>
						<div class="form-group">
						</div>
					</div>
				</form>
			</div>
		</div>
		<a href="sep_item_pedido.php?cod_ped=<?php echo $nr_pedido;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
	</div>
</div>