<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id=$_SESSION["id"];
	$cod_cli=$_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('xhr/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto = $_GET['cod_prd'];
$rua = $_GET['rua'];
$col = $_GET['col'];
$alt = $_GET['alt'];
$qtd = $_GET['qtd'];
$galpao = $_GET['galpao'];
$nr_pedido = $_GET['cod_ped'];
$cod_estoque = $_GET['cod_estoque'];
$cod_col = $_GET['cod_col'];

$sql_conf = "select coalesce(sum(nr_qtde),0) as conf 
from tb_pedido_conferencia
 where nr_pedido = '$nr_pedido' and produto = '$cod_produto'";
$res_conf = mysqli_query($link, $sql_conf);
while ($dados_conf=mysqli_fetch_assoc($res_conf)) {
	$conferido=$dados_conf['conf'];
}

$sql_total = "select coalesce(sum(nr_qtde),0) as totalConf 
from tb_pedido_coleta_produto
 where nr_pedido = '$nr_pedido' and produto = '$cod_produto'";
$res_total = mysqli_query($link, $sql_total);
while ($dados=mysqli_fetch_assoc($res_total)) {
	$totalConf=$dados['totalConf'];
}

$query_local="select ds_apelido from tb_armazem where id = '$galpao'";
$res_local=mysqli_query($link, $query_local);
while ($dados=mysqli_fetch_assoc($res_local)) {
	$nome = $dados['ds_apelido'];
}

$local=$rua."-".$col."-".$alt;

$query_prd="select nm_produto from tb_produto where cod_prod_cliente = '$cod_produto'";
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
				<h4 id="">Produto:<?php echo $produto." - ".$cod_produto;?></h4>
			</div>
			<div>
				<h4 id="">Endereço:<?php echo $local;?> - Itens a coletar:<?php echo $totalConf-$conferido;?></h4>
			</div>

			<legend>Selecione o endereço</legend>
			<form id="form_conf_end" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="localCego" name="localCego" class="form-control" required="true" autofocus="true"/>
						<input type="hidden" id="nrPedConf" name="nrPedConf" class="form-control" value="<?php echo $nr_pedido;?>">
						<input type="hidden" id="nrProdConf" name="nrProdConf" class="form-control" value="<?php echo trim($cod_produto);?>">
						<input type="hidden" id="nrGlpConf" name="nrGlpConf" class="form-control" value="<?php echo $galpao;?>">
						<input type="hidden" id="nrRuaConf" name="nrRuaConf" class="form-control" value="">
						<input type="hidden" id="nrColConf" name="nrColConf" class="form-control" value="">
						<input type="hidden" id="nrAltConf" name="nrAltConf" class="form-control" value="">
						<input type="hidden" id="nrQtdConf" name="nrQtdConf" class="form-control" value="<?php echo $qtd;?>">
						<input type="hidden" id="nrEndConf" name="nrEndConf" class="form-control" value="<?php echo $galpao.$rua.$col.$alt;?>">
						<input type="hidden" id="cod_estoque" name="cod_estoque" class="form-control" value="<?php echo $cod_estoque;?>">
						<input type="hidden" id="cod_col" name="cod_col" class="form-control" value="<?php echo $cod_col;?>">
					</div>
					<div class="form-group">
					</div>
				</div>
			</form>
		</div>
		<h2 id="retExpEnd"></h2>
		<div class="produto">
			<legend>Selecione o produto</legend>
			<div class="row" id="confProdPick">
				<!--div>
					<h4 id="">Total:<?php echo $qtd;?></h4>
				</div-->
				<div class="conferido" id="conferido">
					<h4 id="TotalConferido">Conferido:</h4>
				</div>
				<form id="form_conf_prod" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input type="text" id="barcodeCego" name="barcodeCego" class="form-control" required="true">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="qtde">
			<legend>Insira a quantidade</legend>
			<div class="row" id="insQtdePick">
				<form id="form_conf_qte" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input type="text" id="nr_qtde_conf" name="nr_qtde_conf" class="form-control" required="true">
						</div>
						<div class="form-group">
							<button type="btnFormConfProd" id="btnSaveConfProd" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-floppy-disk"></span> Salvar
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<a href="sep_item_cego.php?cod_ped=<?php echo $nr_pedido;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
	</div>
</div>