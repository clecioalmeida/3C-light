<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;
} else {

	$id = $_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('xhr/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = mysqli_real_escape_string($link, $_GET['nr_ped']);
$cod_ped = mysqli_real_escape_string($link, $_GET['cod_ped']);

$query_conf = "SELECT t1.cod_ped, t2.produto, t1.nr_qtde, coalesce(t1.nr_qtde_exp,0) as nr_qtde_exp, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura,
t1.ds_kva, t1.ds_lp, t1.ds_serial, t1.ds_ano, t1.ds_fabr, t1.ds_enr, t1.ds_oleo, t3.nome, t4.id as id_end 
from tb_pedido_coleta_produto t1
left join tb_coleta_pedido t2 on t1.cod_ped = t2.cod_ped
left join tb_armazem t3 on t2.ds_galpao = t3.id
left join tb_endereco t4 on t2.ds_galpao = t4.galpao and t2.ds_prateleira = t4.rua and t2.ds_coluna = t4.coluna and t2.ds_altura = t4.altura
where t1.cod_ped = '$cod_ped'";
$res_conf = mysqli_query($link, $query_conf);

while ($totalconf = mysqli_fetch_assoc($res_conf)) {
	$cod_ped 		= $totalconf['cod_ped'];
	$conf 			= $totalconf['nr_qtde_exp'];
	$nr_qtde 		= $totalconf['nr_qtde'];
	$produto 		= $totalconf['produto'];
	$id_end 		= $totalconf['id_end'];
	$ds_galpao 		= $totalconf['ds_galpao'];
	$ds_prateleira 	= $totalconf['ds_prateleira'];
	$ds_coluna 		= $totalconf['ds_coluna'];
	$ds_altura 		= $totalconf['ds_altura'];
	$ds_kva 		= $totalconf['ds_kva'];
	$ds_lp 			= $totalconf['ds_lp'];
	$ds_serial 		= $totalconf['ds_serial'];
	$ds_ano 		= $totalconf['ds_ano'];
	$ds_fabr 		= $totalconf['ds_fabr'];
	$ds_enr 		= $totalconf['ds_enr'];
	$nome 			= $totalconf['nome'];
}

?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>EXPEDIÇÃO</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white">
		<h2>Iniciar Expedição</h2>
		<div class="row">
			<div>
				<p>
				<h4 id="">Pedido:<?php echo $nr_pedido; ?> - Total:<?php echo number_format($nr_qtde, 0, ",", ""); ?></h4>
				</p>
				<p>
				<h5>Produto: <?php echo $produto . " - kva: " . $ds_kva . " - Fabricante: " . $ds_fabr . " - LP: " . $ds_lp; ?></h5>
				</p>
				<p>
				<h5>Local: <?php echo $nome . " - " . $ds_prateleira . $ds_coluna . $ds_altura; ?></h5>
				</p>
			</div>
			<div class="conferido" id="conferido">
				<h4 id="TotalConferido">Conferido:<?php echo number_format($conf, 0, ",", ""); ?></h4>
			</div>
		</div>
		<div class="row">
			<form id="form_conf" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<label>Endereço</label>
						<input type="text" id="localExp" name="localExp" class="form-control" required="true" autofocus="true" value="<?php echo $id_end."-".$ds_prateleira."-".$ds_coluna."-".$ds_altura; ?>" style="text-align: right;" />
					</div>
					<div class="form-group">
						<label>Produto</label>
						<input type="text" id="barcodeExpSp" name="barcodeExpSp" class="form-control" required="true" value="<?php echo $produto; ?>" style="text-align: right;" />
					</div>
					<div class="form-group">
						<label>Quantidade</label>
						<input type="text" id="nr_qtde" name="nr_qtde" class="form-control" required="true" value="<?php echo $nr_qtde; ?>" style="text-align: right;" />
					</div>
					<div class="form-group">
						<label>LP</label>
						<input type="text" id="serial_exp" name="serial_exp" class="form-control" value="<?php echo $ds_lp; ?>" style="text-align: right;" />
					</div>
				</div>
			</form>
		</div>
		<button class="btn btn-primary" type="button" value="<?php echo $nr_pedido; ?>" id="btnSaveExp">SALVAR</button>
		<a href="expede_pedido.php?cod_ped=<?php echo $nr_pedido; ?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
	</div>
</div>