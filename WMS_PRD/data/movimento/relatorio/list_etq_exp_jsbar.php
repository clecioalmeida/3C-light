<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id=$_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$hoje	= date("d/m/Y");

$pedido = $_POST['nr_ped'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.nr_pedido, t4.produto, t3.nm_produto, t1.cod_almox, t1.ds_destino, t3.nm_produto, t3.cod_prod_cliente, t3.cod_produto, sum(t4.nr_qtde_col) as qtde 
from tb_pedido_coleta t1  
left join tb_coleta_pedido t4 on t1.nr_pedido = t4.nr_pedido 
left join tb_produto t3 on t4.produto = t3.cod_prod_cliente 
where t1.nr_pedido = '$pedido'
group by t4.produto";
$qtde = mysqli_query($link,$query_qtde);

if($cod_cli == "3"){

	$remetente 			= "EDP SAO PAULO - SÃO JOSÉ DOS CAMPOS - SP";
	$endRem 			= "";
	$brRem 				= "";
	$cidRem				= "";
	$cepRem				= "";

}else if($cod_cli == "4"){

	$remetente 			= "EDP ESPIRITO SANTO - VILA VELHA - SP";
	$endRem 			= "";
	$brRem 				= "";
	$cidRem				= "";
	$cepRem				= "";



}
$link->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Expedição</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style type="text/css">
		.quebrapagina {
			page-break-before: always;
		}

		@media print {
			@page { margin: 0; }
			body { margin: 1.6cm; }
		}
	</style>
</head>
<body>
	<div class="container">

		<div class="row">
			<div class="col-sm-12">
				<?php 
				while ($dados=mysqli_fetch_assoc($qtde)){

					$table = '<table class="table" align="center" border="1" cellpadding="1">
					<tr>
					<td><img src="i../.././img/logo3c2.png" border="0" height="14" width="32" align="top" /></td>
					<td>NF:</td>
					</tr>
					<tr>
					<td colspan="2">REMETENTE:</td>
					</tr>
					<tr>
					<td colspan="2">DESTINO:</td>
					</tr>
					<tr>
					<td colspan="2">PRODUTO</td>
					</tr>
					<tr>
					<td colspan="2">
					<svg id="barcode"
					class="barcode"
					jsbarcode-format="auto"
					jsbarcode-height="40"
					jsbarcode-displayValue="true"
					jsbarcode-value="12345678"
					jsbarcode-textmargin="0"
					jsbarcode-fontoptions="bold">
					</svg>
					</td>
					</tr>
					</table>';

					echo $table;
					echo '<br><br><br class="quebrapagina">';
				}

				?>
			</div>
		</div>

	</div>
</body>
</html>
<script type="text/javascript" src="../../../js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
	JsBarcode(".barcode").init();

</script>