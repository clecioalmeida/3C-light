<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$ns_prd = $_POST["ns_prd"];

$select_produto = "t1.id, t1.id_produto, t1.n_serie, t2.nr_pedido, t2.doc_material, t3.nm_produto
from tb_nserie t1
left join tb_pedido_coleta t2 on t1.cod_pedido = t2.cod_pedido
left join tb_produto t3 on t1.id_produto = t3.cod_prod_cliente
where t1.id_produto = '$ns_prd'";
$res_produto = mysqli_query($link,$select_produto);

?>
<?php
if ($res_produto) {
	?>
	<article>
		<table class="table" id="reportSalEstoque">
			<thead>
				<tr>
					<th> NÚMERO DE SÉRIE</th>
					<th> PEDIDO WMS</th>
					<th> DOC MATERIAL</th>
					<th> CÓDIGO SAP</th>
					<th> DESCRIÇÃO </th>
				</tr>
			</thead>
			<tbody id="retPrdPedido">
				<?php 
				while($dados_produto=mysqli_fetch_assoc($res_produto)){?>
					<tr class="odd gradeX">
						<td class="atualiza"> <?php echo $dados_produto['n_serie']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['nr_pedido']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['doc_material']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['id_produto']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['nm_produto']; ?> </td>
					</tr>
				<?php } ?> 
			</tbody>
		</table>
	</article>
	<div id="infoTarefasDia" class="row"></div>
<?php } else {?>
	<h4>A PESQUISA NÃO RETORNOU NENHUM RESULTADO.</h4>
<?php }
$link->close();
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#BtnPrdExcel').on('click', function(){
			event.preventDefault();
			$('#BtnPrdExcel').prop("disabled", true);
			var today = new Date();
			$("#reportSalEstoque").table2excel({
				exclude: ".noExl",
				name: "Relatório geral de produtos pendentes - Analítico",
                filename: "Relatório geral de produtos pendentes - Analítico - " + today //do not include extension
            });
			$('#BtnPrdExcel').prop("disabled", false);

		});
	});
</script>