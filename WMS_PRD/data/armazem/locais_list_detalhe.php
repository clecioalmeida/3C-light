<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$local = $_POST['local'];
$produto = $_POST['produto'];

$sql_local = "select t1.id, t1.nome, t2.cod_estoque, t2.ds_galpao, t2.produto, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.nr_qtde, t2.dt_validade, t2.cod_ca, date_format(t4.dt_docto,'%d/%m/%Y') as dt_ca, t2.cod_laudo, date_format(t5.dt_docto,'%d/%m/%Y') as dt_laudo, t3.cod_prod_cliente, t3.nm_produto, date_format(t2.dt_create, '%d/%m/%Y') as dt_create, t2.id_tar
from tb_armazem t1
left join tb_posicao_pallet t2 on t1.id = t2.ds_galpao
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
left join tb_ca t4 on t2.cod_ca = t4.id
left join tb_ca t5 on t2.cod_laudo = t5.id
where t2.fl_empresa = '$cod_cli' and t2.nr_qtde > 0 and t2.ds_galpao = '$local' and t2.produto = '$produto' and t2.fl_status = 'A'";
$res_local = mysqli_query($link,$sql_local);
$tr_local = mysqli_num_rows($res_local);


$link->close();
?>
<?php
if($tr_local){
	?>

	<div class="col-sm-12 text-align-right">
		<div class="btn-group">
			<button type="submit" class="btn btn-success" id="RepEstoqGenExcel" style="float:right;width: 100px">Excel</button>
		</div>
	</div>
	<div id="reportSalEstoque">
		<div class="padding-10">
			<div class="pull-left">
				<img src="img/Logo3C.jpg" width="80" height="32" alt="Gisis">
				<address>
					<br>
					<strong>3C Services</strong>
				</address>
			</div>
			<div class="pull-right">
				<h1 class="font-200">Relatório de saldo de estoque detalhado</h1>
			</div>
			<div class="clearfix"></div>
			<br>
			<br>
			<table class="table table-striped table-hover" id="" style="width: 100%">
				<thead>
					<tr>
						<th> Código </th>
						<th> Rua </th>
						<th> Coluna</th>
						<th> Altura </th>
						<th> Cód. SAP</th>
						<th> Produto </th>
						<th> Quantidade </th>
						<th> Data </th>
						<th> Tarefa </th>
					</tr>
				</thead>
				<tbody>
					<?php 
					while($dados_local = mysqli_fetch_assoc($res_local)) {
						?>
						<tr class="odd gradeX">
							<td style="text-align: center; width: 5px;"><?php echo $dados_local['cod_estoque']; ?> </td>
							<td style="text-align: center; width: 5px;"><?php echo $dados_local['ds_prateleira']; ?> </td>
							<td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_coluna']; ?> </td>
							<td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_altura']; ?> </td>
							<td style="text-align: right; width: 100px"> <?php echo $dados_local['cod_prod_cliente']; ?></td>
							<td style="text-align: left; width: auto"> <?php echo $dados_local['nm_produto']; ?></td>
							<td style="text-align: right; width: auto"> <?php echo $dados_local['nr_qtde']; ?></td>
							<td style="text-align: right; width: auto"> <?php echo $dados_local['dt_create']; ?></td>
							<td style="text-align: right; width: auto"> <?php echo $dados_local['id_tar']; ?></td>
							</tr>              <?php } ?> 
						</tbody>
					</table>
				</div>
			</div>
			<script type="text/javascript">
				$('#RepEstoqGenExcel').on('click', function(){
					event.preventDefault();
					$('#RepEstoqGenExcel').prop("disabled", true);
					var today = new Date();
					$("#reportSalEstoque").table2excel({
						exclude: ".noExl",
						name: "Consulta fechamento de inventário - Analítico",
						filename: "Relatório de saldo de estoque detalhado" + today});
					$('#RepEstoqGenExcel').prop("disabled", false);

				});
			</script>
		<?php }else{?>

			<h4>Nao foram encontrados produtos com esta descrição.</h4>

		<?php }
		?>