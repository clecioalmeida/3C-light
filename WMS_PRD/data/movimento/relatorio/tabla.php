
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

<div class="row">
	<div class="col-sm-12">
		<table class="table" align="conter" border="1" cellpadding="1">
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
		</table>
	</div>
</div>



<!--script type="text/javascript">

	function arrayjsonbarcode(j){
		json=JSON.parse(j);
		arr=[];
		for (var x in json) {
			arr.push(json[x]);
		}
		return arr;
	}

	jsonvalor='<?php echo json_encode($arrayCodigos) ?>';
	valores=arrayjsonbarcode(jsonvalor);

	for (var i = 0; i < valores.length; i++) {

		JsBarcode("#barcode" + valores[i], valores[i].toString(), {
			format: "codabar",
			lineColor: "#000",
			width: 2,
			height: 30,
			displayValue: true
		});
	}

</script-->