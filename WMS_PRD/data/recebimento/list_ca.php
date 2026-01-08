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

$SQL = "select t1.id, t1.nr_docto, case t1.fl_tipo when 'C' then 'CA' else 'LAUDO' end as tipo, date_format(t1.dt_docto,'%d/%m/%Y') as dt_docto, case t1.fl_status when 'A' then 'ATIVO' when 'V' then 'VENCIDO' end as fl_status
from tb_ca t1
where t1.dt_docto > 0
group by t1.nr_docto
order by t1.dt_docto";

$res = mysqli_query($link, $SQL);

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
		<table id="" class="table" style="font-size: 12px;width: 60%">
			<thead>
				<tr>
					<th> AÇÕES </th>
					<th> CÓDIGO </th>
					<th> TIPO </th>
					<th> VALIDADE</th>	
					<th> STATUS </th>
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
						<td style="text-align: right; width: 10px"> <?php echo $dados['nr_docto']; ?> </td>
						<td> <?php echo $dados['tipo']; ?> </td>
						<td style="text-align: center;"><?php echo $dados['dt_docto'];?></td>
						<td style="text-align: center;"> <?php echo $dados['fl_status']; ?> </td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</div>