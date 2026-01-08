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

$SQL = "select t1.id, t1.nr_docto,  t2.cod_estoque, t5.nr_pedido, t7.nr_matricula, t7.cod_depto, upper(t7.ds_nome) as ds_nome, t1.dt_docto, DATEDIFF(date(t1.dt_docto), date(now())) as qtd_dias, CASE t1.fl_tipo when 'C' THEN 'CA' when 'L' then 'LAUDO' END as tipo, t2.produto, t3.nm_produto,t2.ds_galpao, t4.nome, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, round(t2.nr_qtde,0) as nr_qtde, coalesce(t2.fl_bloq,'N') as fl_bloq, t5.cod_col, date_format(t6.dt_pedido,'%d/%m/%Y') as dt_pedido, t5.cod_estoque
from tb_ca t1
left join tb_posicao_pallet t2 on t1.id = (CASE t1.fl_tipo WHEN 'C' then t2.cod_ca when 'L' THEN t2.cod_laudo END) and coalesce(t2.fl_bloq,'N') = 'N'
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
left join tb_armazem t4 on t2.ds_galpao = t4.id
left join tb_coleta_pedido t5 on t2.cod_estoque = t5.cod_estoque
left join tb_pedido_coleta t6 on t5.nr_pedido = t6.nr_pedido
left join tb_funcionario t7 on t6.cod_almox = t7.nr_matricula
where DATEDIFF(date(t1.dt_docto), date(now())) <= '30'
group by t1.nr_docto, t2.cod_estoque, t7.nr_matricula
order by t1.nr_docto, t2.cod_estoque";

$res = mysqli_query($link, $SQL);

$link->close();
?>
<style type="text/css">

	.tableFixHead          { overflow-y: auto; height: 640px; }
	.tableFixHead thead th { position: sticky; top: 0; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:grey; }

</style>
<div class="col-sm-12 text-align-right">
	<div class="btn-group">
		<button type="submit" class="btn btn-success" id="RepCaAlertEmitExcel" style="float:right;width: 100px">Excel</button>
	</div>
</div>
<div class="col-sm-12">
	<div class="tableFixHead">
		<table id="TbConsCaAlert" class="table" style="font-size: 12px">
			<thead>
				<tr>
					<th> C.R. </th>
					<th> MATRÍCULA </th>
					<th> NOME </th>
					<th> DOCTO </th>
					<th> PRODUTO </th>
					<th> VENCIMENTO </th>
					<th> DIAS ATÉ VENCTO </th>	
					<th> LOCAL </th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($dados = mysqli_fetch_array($res)) {
					?>
					<tr  class="status" data-status="<?php echo $dados['fl_status']; ?>">
						<td style="text-align: right; width: 10px"> <?php echo $dados['cod_depto']; ?> </td>
						<td style="text-align: right; width: 10px"> <?php echo $dados['nr_matricula']; ?> </td>
						<td style="text-align: left;"> <?php echo $dados['ds_nome']; ?> </td>
						<td style="text-align: right;"> <?php echo $dados['nr_docto']; ?> </td>
						<td style="text-align: left;"> <?php echo $dados['produto'].' - '.$dados['nm_produto']; ?> </td>
						<td style="text-align: center;"> <?php echo $dados['dt_docto']; ?> </td>
						<td style="text-align: right;"> <?php echo $dados['qtd_dias']; ?> </td>
						<td style="text-align: center;"> <?php echo $dados['cod_estoque'].' - '.$dados['nome'].' - '.$dados['ds_prateleira'].' - '.$dados['ds_coluna'].' - '.$dados['ds_altura']; ?> </td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>