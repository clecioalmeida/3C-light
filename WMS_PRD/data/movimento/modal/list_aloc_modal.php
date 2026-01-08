<?php 

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_estoque = $_POST["cod_estoq"];

$select_aloc = "select t1.cod_estoque, t1.produto, t1.nr_volume, t1.nr_qtde, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t2.cod_prod_cliente
from tb_posicao_pallet t1 
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente or t1.cod_produto = t2.cod_produto
where t1.nr_posicao_temp = '$cod_estoque' and t1.fl_status <> 'E'
group by t1.cod_estoque";
$res_aloc = mysqli_query($link,$select_aloc);
$link->close();
?>
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
	<thead>
		<tr>
			<th> CÓDIGO</th>
			<th> DESCRIÇÃO </th>
			<th> VOLUMES  </th>
			<th> QUANTIDADE  </th>
		</tr>
	</thead>
	<tbody>
		<?php 
		while($dados_aloc = mysqli_fetch_array($res_aloc)) {
			?>                        
			<tr class="odd gradeX">
				<td style="width: 10%"> <?php echo $dados_aloc['cod_prod_cliente']; ?> </td>
				<td style="width: 30%"> <?php echo $dados_aloc['nm_produto']; ?> </td>
				<td> <?php echo $dados_aloc['nr_volume']; ?> </td>
				<td> <?php echo $dados_aloc['nr_qtde']; ?> </td>
			</tr>
		<?php } ?>
	</tbody>
</table>
