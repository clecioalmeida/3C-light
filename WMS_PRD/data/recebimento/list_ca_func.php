<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli  	= $_SESSION['cod_cli'];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$nr_matr = $_POST["nr_matr"];

$clause = "where ";
$sql = "select t1.nr_pedido, date_format(t1.dt_pedido,'%d/%m/%Y') as dt_pedido, t6.produto, t7.nm_produto, t1.cod_almox, t3.nr_matricula, upper(t3.ds_nome) as ds_nome, t2.cod_estoque, date_format(t2.dt_validade,'%d/%m/%Y') as dt_validade, t4.nr_docto as cod_ca, date_format(t4.dt_docto,'%d/%m/%Y') as dt_ca, t5.nr_docto as cod_laudo, date_format(t5.dt_docto,'%d/%m/%Y') as dt_laudo
from tb_pedido_coleta t1
left join tb_funcionario t3 on t1.cod_almox = t3.nr_matricula
left join tb_coleta_pedido t8 on t1.nr_pedido = t8.nr_pedido
left join tb_posicao_pallet t2 on t8.cod_estoque = t2.cod_estoque and t8.produto = t2.produto
left join tb_ca t4 on t2.cod_ca = t4.id
left join tb_ca t5 on t2.cod_laudo = t5.id
left join tb_pedido_coleta_produto t6 on t1.nr_pedido = t6.nr_pedido
left join tb_produto t7 on t6.produto = t7.cod_prod_cliente ";

if ($nr_matr == "") {

	$sql .= $clause . " t1.fl_status = 'F' and t3.nr_matricula is not null and (COALESCE(t2.dt_validade,'0') > 0 or COALESCE(t4.dt_docto,'0') > 0 or COALESCE(t5.dt_docto,'0') > 0)";

}else{

	$sql .= $clause . "t1.cod_almox = '".$nr_matr."' and t1.fl_status = 'F' and t3.nr_matricula is not null and (COALESCE(t2.dt_validade,'0') > 0 or COALESCE(t4.dt_docto,'0') > 0 or COALESCE(t5.dt_docto,'0') > 0)";

}

$sql .= " group by t8.nr_pedido, t8.cod_estoque order by t1.nr_pedido desc
LIMIT 100";

$res = mysqli_query($link, $sql);

$link->close();
?>
<style type="text/css">

	.tableFixHead          { overflow-y: auto; height: 540px; }
	.tableFixHead thead th { position: sticky; top: 0; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }

	/* CAMPO INPUT DENTRO DA TD */

	table td {
		position: relative;
	}

	table td input {
		position: absolute;
		display: block;
		top:0;
		left:0;
		margin: 0;
		height: 100%;
		width: 100%;
		border: none;
		padding: 10px;
		box-sizing: border-box;
		font-size: 12px;
		text-align: right;

		}table td select {
			position: absolute;
			display: block;
			top:0;
			left:0;
			margin: 0;
			height: 100%;
			width: 300px;
			border: none;
			padding: 10px;
			box-sizing: border-box;
			font-size: 12px;
			text-align: right;
		}

	</style>
	<div class="tableFixHead">
		<table id="" class="table" style="font-size: 12px;width: 100%">
			<thead>
				<tr>
					<th> AÇÕES </th>
					<th> PEDIDO </th>
					<th> DATA DO PEDIDO </th>
					<th> MATRÍCULA</th>	
					<th> NOME </th>
					<th> PRODUTO </th>
					<th> DESCRIÇÃO </th>
					<th> VALIDADE PRODUTO </th>
					<th> CA </th>
					<th> VALIDADE CA </th>
					<th> LAUDO </th>
					<th> VALIDADE LAUDO </th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($dados = mysqli_fetch_array($res)) {
					?>
					<tr  class="status"id="row1" data-status="<?php echo $dados['fl_status']; ?>">
						<td style="text-align: center">
							<button type="submit" id="" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">DETALHE</button>
						</td>
						<td style="text-align: right; width: 10px"> <?php echo $dados['nr_pedido']; ?> </td>
						<td style="text-align: center; width: 10px"> <?php echo $dados['dt_pedido']; ?> </td>
						<td style="text-align: right; width: 10px"> <?php echo $dados['nr_matricula']; ?> </td>
						<td> <?php echo $dados['ds_nome']; ?> </td>
						<td style="text-align: right; width: 10px"> <?php echo $dados['produto']; ?> </td>
						<td> <?php echo $dados['nm_produto']; ?> </td>
						<td style="text-align: center;"><?php echo $dados['dt_validade'];?></td>
						<td style="text-align: right; width: 10px"> <?php echo $dados['cod_ca']; ?> </td>
						<td style="text-align: center;"><?php echo $dados['dt_ca'];?></td>
						<td style="text-align: right; width: 10px"> <?php echo $dados['cod_laudo']; ?> </td>
						<td style="text-align: center;"> <?php echo $dados['dt_laudo']; ?> </td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</div>