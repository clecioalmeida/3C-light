<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_sap = $_POST['cod_sap'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$query_estoque = "select coalesce(t1.cod_estoque,0) as cod_estoque, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.produto, sum(t1.nr_qtde) as saldo, t2.cod_prod_cliente, t2.nm_produto
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
where t1.produto = '$cod_sap' and t1.fl_status = 'A' and fl_empresa = '$cod_cli' and t1.nr_qtde > 0
group by t1.cod_estoque
order by t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura";
$res_estoque = mysqli_query($link, $query_estoque);

$link->close();
?>
<table class="table table-hover">
	<thead>
		<tr>
			<th class="text-center">CÓDIGO</th>
			<th>CÓD. PRODUTO</th>
			<th>PRODUTO</th>
			<th>TIPO</th>
			<th>ARMAZÉM</th>
			<th>RUA</th>
			<th>COLUNA</th>
			<th>ALTURA</th>
			<th>QTDE</th>
			<th>CÓDIGO</th>
			<th>#</th>
		</tr>
	</thead>
	<tbody id="tbConProdEstoq">

		<?php
		while ($estoque = mysqli_fetch_assoc($res_estoque)) {
			if($estoque['cod_estoque'] != 0){	?>

				<tr>
					<td id="codProdRelEstoq"><?php echo $estoque['cod_estoque']; ?></td>
					<td><?php echo $estoque['cod_prod_cliente']; ?></td>
					<td><?php echo $estoque['nm_produto']; ?></td>
					<td></td>
					<td id="idGalRelEstoq"><?php echo $estoque['ds_galpao']; ?></td>
					<td id="idRuaRelEstoq"><?php echo $estoque['ds_prateleira']; ?></td>
					<td id="idColunaRelEstoq"><?php echo $estoque['ds_coluna']; ?></td>
					<td id="idAlturaRelEstoq"><?php echo $estoque['ds_altura']; ?></td>
					<td id="nrQtdeRelEstoq"><?php echo $estoque['saldo']; ?></td>
					<td style="width: 100px;text-align: center">
						<svg id="barcode"
							class="barcode"
							jsbarcode-format="auto"
							jsbarcode-height="20"
							jsbarcode-displayValue="true"
							jsbarcode-value="<?php echo $estoque['cod_prod_cliente'].'-'.$estoque['cod_estoque']; ?>"
							jsbarcode-textmargin="0"
							jsbarcode-fontoptions="bold">
						</svg>
					</td>
					<td>
						<a href="data/movimento/relatorio/list_etq_prd_aloc.php?cod_estoque=<?php echo $estoque['cod_estoque']; ?>" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-primary btn-xs" value="">Etiqueta</button></a>
					</td>
				</tr>
	 
	<?php 	}else{ ?>

				<tr>
					<td colspan="11">
						<h4>PRODUTO NÃO ENCONTRADO.</h4>
					</td>
				</tr>

		<?php	}
	 } ?>
</tbody >
</table>
<script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
	JsBarcode(".barcode").init();
</script>