<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION['cod_cli'];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST["nr_ped"];

$select_produto = "select t2.nr_pedido, t2.cod_ped, t2.produto, t2.nr_qtde as qtde, t2.nr_volume, t3.nm_produto, t3.cod_produto, t3.cod_prod_cliente, t4.fl_status, t4.doc_material, t5.ds_prateleira, t5.ds_coluna, t5.ds_altura
from tb_pedido_coleta_produto t2
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
left join tb_pedido_coleta t4 on t2.nr_pedido = t4.nr_pedido
left join tb_coleta_pedido t5 on t2.nr_pedido = t5.nr_pedido and t2.produto = t5.produto
where t2.nr_pedido = '$nr_pedido' and t4.fl_status <> 'F' and t2.fl_empresa = '$cod_cli'";
$res_produto = mysqli_query($link,$select_produto);

?>
<style type="text/css">
	.ocupado {
		background-color: #F4A460;
	}

	.livre {
		background-color: #7FFFD4;
	}

	.alerta {
		background-color: #EEDD82;
	}

	.finalizado {
		background-color: #ADD8E6;
	}

	.expedido {
		background-color: #8FBC8F;
	}

	.expedicao {
		background-color: #98FB98;
	}
</style>
<?php
if ($res_produto) {
	?>
	<article>
		<table class="table" id="reportSalEstoque">
			<thead>
				<tr>
					<th> PEDDO WMS</th>
					<th> DOC MATERIAL</th>
					<th> CÓDIGO SAP</th>
					<th> DESCRIÇÃO </th>
					<th> QTDE SOLICITADA </th>
					<th> ENDEREÇO ENCONTRADO </th>
					<th> STATUS  </th>
				</tr>
			</thead>
			<tbody id="retPrdPedido">
				<?php 
				while($dados_produto=mysqli_fetch_assoc($res_produto)){?>
					<tr class="odd gradeX">
						<td class="atualiza"> <?php echo $dados_produto['nr_pedido']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['doc_material']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['cod_prod_cliente']; ?> </td>
						<td class="atualiza"> <?php echo $dados_produto['nm_produto']; ?> </td>
						<td class="atualiza" style="text-align: right;"> <?php echo $dados_produto['qtde']; ?> </td>
						<td class="atualiza" style="text-align: right;"> <?php echo $dados_produto['ds_prateleira']." - ".$dados_produto['ds_coluna']." - ".$dados_produto['ds_altura']; ?> </td>
						<td class="status">
							<?php
							if ($dados_produto['fl_status'] == 'A') {
								echo '<bold>ABERTO</bold>';
							} elseif ($dados_produto['fl_status'] == 'P') {
								echo '<bold>CONFERÊNCIA FINALIZADA</bold>';
							} elseif ($dados_produto['fl_status'] == 'E' || $dados_produto['fl_status'] == 'W') {
								echo '<bold>EXPEDIÇAO</bold>';
							} elseif ($dados_produto['fl_status'] == 'C') {
								echo '<bold>AGUARDANDO COLETA</bold>';
							} elseif ($dados_produto['fl_status'] == 'M') {
								echo '<bold>COLETA INICIADA</bold>';
							} elseif ($dados_produto['fl_status'] == 'F') {
								echo '<bold>COLETADO</bold>';
							} elseif ($dados_produto['fl_status'] == 'X') {
								echo '<bold>EXPEDIÇÃO</bold>';
							} elseif ($dados_produto['fl_status'] == 'L') {
								echo '<bold>EXPEDIDO</bold>';
							} elseif ($dados_produto['fl_status'] == 'H') {
								echo '<bold>MANUSEIO</bold>';
							} elseif ($dados_produto['fl_status'] == 'S') {
								echo '<bold>EXPEDIÇÃO FINALIZADA</bold>';
							}
							?>
						</td>
					</tr>
				<?php } ?> 
			</tbody>
		</table>
	</article>
	<div id="infoTarefasDia" class="row"></div>
<?php } else {?>
	<h4>Não há produtos pendentes.</h4>
<?php }
$link->close();
?>
<script type="text/javascript">
	$(document).ready(function(){
		var status_ = new Array();
		$('.status').each( function( i,v ){
			var $this = $( this )
			status_[i] = $this.attr('data-status');
			if(status_[i] == "A"){
				$this.addClass('ocupado');
			}else if(status_[i] == "C"){
				$this.removeClass('ocupado').addClass('alerta');
			}else if(status_[i] == "F"){
				$this.removeClass('ocupado').addClass('livre');
			}else if (status_[i] == "P"){
				$this.removeClass('ocupado').addClass('finalizado');
			}else if (status_[i] == "S"){
				$this.removeClass('ocupado').addClass('expedido');
			}else if (status_[i] == "X" || status_[i] == "W"){
				$this.removeClass('ocupado').addClass('expedicao');
			}else if (status_[i] == "H"){
				$this.removeClass('ocupado').addClass('alerta');
			}
		});
	});
</script>
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