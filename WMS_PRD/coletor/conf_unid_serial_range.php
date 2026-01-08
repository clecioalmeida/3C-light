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
			<div id="retConfSerial"></div>
			<!--form id="form_conf_prod" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="barcodeSerialRange" name="barcodeSerialRange" class="input-xs" placeholder="Selecione o produto" required="true" autofocus="true" style="text-align: right;">
						<input type="hidden" id="nrPedConf" name="nrPedConf" class="form-control" value="<?php echo $nr_pedido;?>">
					</div>
				</div>
			</form-->
			<form id="form_conf_end" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="localCegoSerialRange" name="localCegoSerialRange" class="input-xs" placeholder="Selecione o endereço" required="true"/>
					</div>
				</div>
			</form>
			<form id="form_conf_prod" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="nr_serial_ini" name="nr_serial_ini" class="form-control" placeholder="Número de série inicial" style="text-align: right;">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="nr_serial_fim" name="nr_serial_fim" class="form-control" placeholder="Número de série final" style="text-align: right;">
						<input type="hidden" id="nrPedConf" name="nrPedConf" class="form-control" value="<?php echo $nr_pedido;?>">
						<input type="hidden" id="cod_prd" name="cod_prd" class="form-control" value="<?php echo $cod_produto;?>">
					</div>
				</div>
			</form>
			<p><h2 id="retExpPrd"></h2></p>
			<p><h2 id="retExpEnd"></h2></p>
			<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnSaveRangeSerial" value="<?php echo $nr_pedido;?>" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb;float: right">SALVAR</button>
			<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnFinRangeSerial" value="<?php echo $nr_pedido;?>" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">FINALIZAR</button>
			<a href="sep_item_unid_serial.php?cod_ped=<?php echo $nr_pedido;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
			<div class="serial" id="list_serial" style="width:100; height:50; overflow: auto"></div>
		</div>
	</div>