<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_serie = $_POST["nr_serie"];

$select_produto = "SELECT t1.id, t1.id_produto, t1.n_serie, t1.status_sap, t1.dt_upd_sap, t1.status_usr, t1.dt_upd_usr, t1.cod_pedido, t1.cod_rec, t3.nm_produto, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura
from tb_nserie t1
left join tb_produto t3 on t1.id_produto = t3.cod_prod_cliente
left join tb_posicao_pallet t2 on t1.cod_estoque = t2.cod_estoque
where t1.n_serie = '$nr_serie'";
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
					<th> STATUS SAP</th>
					<th> DT STATUS SAP</th>
					<th> STATUS USER</th>
					<th> DT STATUS USER</th>
					<th> PEDIDO WMS</th>
					<th> ORDEM DE RECEBIMENTO</th>
					<th> ENDEREÇO</th>
					<th> CÓDIGO SAP</th>
					<th> DESCRIÇÃO </th>
				</tr>
			</thead>
			<tbody id="retPrdPedido">
				<?php 
				while($dados_produto=mysqli_fetch_assoc($res_produto)){?>
					<tr class="odd gradeX">
						<td class="atualiza"> <?php echo $dados_produto['n_serie']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['status_sap']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['dt_upd_sap']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['status_usr']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['dt_upd_usr']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['cod_rec']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['cod_pedido']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['ds_prateleira']."-".$dados_produto['ds_coluna']."-".$dados_produto['ds_altura']; ?> </td>
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