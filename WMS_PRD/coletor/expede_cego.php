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


$sql_total = "select coalesce(sum(nr_qtde_conf),0) as totalConf 
from tb_coleta_pedido
 where nr_pedido = '$nr_pedido'";
$res_total = mysqli_query($link, $sql_total);
while ($dados=mysqli_fetch_assoc($res_total)) {
	$totalConf=$dados['totalConf'];
}

$query_local="select ds_apelido from tb_armazem where id = '$galpao'";
$res_local=mysqli_query($link, $query_local);
while ($dados=mysqli_fetch_assoc($res_local)) {
	$nome = $dados['ds_apelido'];
}

$local=$nome.$rua.$col.$alt;

$query_prd="select nm_produto from tb_produto where cod_prod_cliente = '$cod_produto'";
$res_prd=mysqli_query($link, $query_prd);
while ($dados=mysqli_fetch_assoc($res_prd)) {
	$produto = $dados['nm_produto'];
}

$link->close();
?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>EXPEDIÇÃO</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white;padding-top: 1em">
		
		<div class="row">
			<div>
				<h4 id="">Produto:<?php echo $produto." - ".$cod_produto;?></h4>
			</div>
		</div>
		<h2 id="retExpEnd"></h2>
		<div class="produto">
			<legend>Selecione o produto</legend>
			<div class="row" id="confProdPick">
				<form id="form_conf_prod" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input type="text" id="barcodeExpCego" name="barcodeExpCego" class="form-control" required="true">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="qtde">
			<legend>Insira a quantidade</legend>
			<div class="row" id="insQtdeExp">
				<form id="form_conf_prod" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input type="text" id="nr_qtde_conf" name="nr_qtde_conf" class="form-control" required="true">
						</div>
				<div class="conferido" id="conferido">
					<h4 id="TotalConferido">Conferido:</h4>
				</div>
						<div class="form-group">
							<button type="btnFormConfProd" id="btnSaveConfExpCego" value="<?php echo $nr_pedido;?>" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-floppy-disk"></span> Salvar
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<a href="sep_expede_cego.php?cod_ped=<?php echo $nr_pedido;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
	</div>
</div>