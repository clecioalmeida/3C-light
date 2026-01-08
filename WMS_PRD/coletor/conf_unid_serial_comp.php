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

$cod_produto 	= $_GET['cod_prd'];
/*$rua 			= $_GET['rua'];
$col 			= $_GET['col'];
$alt 			= $_GET['alt'];
$qtd 			= $_GET['qtd'];
$galpao 		= $_GET['galpao'];*/
$nr_pedido 		= $_GET['cod_ped'];
//$cod_estoque 	= $_GET['cod_estoque'];
//$cod_col 		= $_GET['cod_col'];

$sql_conf = "select count(id) as conf 
from tb_nserie
where cod_pedido = '$nr_pedido'";
$res_conf = mysqli_query($link, $sql_conf);
while ($dados_conf=mysqli_fetch_assoc($res_conf)) {
	$conferido=$dados_conf['conf'];
}

$sql_total = "select coalesce(sum(nr_qtde),0) as totalConf 
from tb_pedido_coleta_produto
where nr_pedido = '$nr_pedido'";
$res_total = mysqli_query($link, $sql_total);
while ($dados=mysqli_fetch_assoc($res_total)) {
	$totalConf=$dados['totalConf'];
}

/*$query_local="select ds_apelido from tb_armazem where id = '$galpao'";
$res_local=mysqli_query($link, $query_local);
while ($dados=mysqli_fetch_assoc($res_local)) {
	$nome = $dados['ds_apelido'];
}

$local=$rua."-".$col."-".$alt;

$query_prd="select nm_produto from tb_produto where cod_prod_cliente = '$cod_produto'";
$res_prd=mysqli_query($link, $query_prd);
while ($dados=mysqli_fetch_assoc($res_prd)) {
	$produto = $dados['nm_produto'];
}*/

$link->close();
?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>PICKING SERIALIZADOS</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white;padding-top: 1em">		
		<div class="row">
			<p id="retPrd"></p>
			<!--p id="tot_ped">Endereço:<?php echo $local;?> - Itens a coletar:<?php echo $totalConf-$conferido;?></p-->
			<p id="TotalSelecionado">Selecionado:<?php echo $conferido;?></p>
			<div id="retConfSerialComp"></div>
			<!--form id="form_conf_prod" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="barcodeSerial" name="barcodeSerial" class="input-xs" placeholder="Selecione o produto" required="true" autofocus="true" style="text-align: right;">
						<input type="hidden" id="nrPedConf" name="nrPedConf" class="form-control" value="<?php echo $nr_pedido;?>">
					</div>
				</div>
			</form-->
			<form id="form_conf_end" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="localCegoSerial" name="localCegoSerial" class="input-xs" placeholder="Selecione o endereço" required="true"/>
					</div>
				</div>
			</form>
			<form id="form_conf_prod" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="nr_serial_unid_comp" name="nr_serial_unid_comp" class="form-control" placeholder="Número de série" style="text-align: right;">
						<input type="hidden" id="nrPedConf" name="nrPedConf" class="form-control" value="<?php echo $nr_pedido;?>">
						<input type="hidden" id="cod_prd" name="cod_prd" class="form-control" value="<?php echo $cod_produto;?>">
					</div>
				</div>
			</form>
			<p><h2 id="retExpPrdComp"></h2></p>
			<p><h2 id="retExpEnd"></h2></p>
			<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnSaveSerialComp" value="<?php echo $nr_pedido;?>" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb;float: right">SALVAR</button>
			<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnFinSerialComp" value="<?php echo $nr_pedido;?>" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">FINALIZAR</button>
			<a href="sep_item_unid_serial_comp.php?cod_ped=<?php echo $nr_pedido;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
			<div class="serial" id="list_serial_comp" style="width:100; height:50; overflow: auto"></div>
		</div>
	</div>
</div>