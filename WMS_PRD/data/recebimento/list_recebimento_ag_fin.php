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

$SQL = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, t1.dt_recebimento_previsto, t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.dt_recebimento_real, t1.usr_create, t1.usr_confere, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.usr_recebe, t1.dt_recebido, t1.usr_autoriza, t1.dt_autoriza, t1.fl_status, t2.cod_cliente, t2.nm_cliente, t4.nm_user, date_format(t5.dt_janela,'%d/%m/%Y') as dt_janela, t5.ds_janela, t1.hr_chegada, t1.init_descarga, t1.fim_descarga, t1.t_descarregamento, t1.t_permanece
from tb_recebimento_ag t1
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
left join tb_usuario t4 on t1.usr_create = t4.id
left join tb_janela t5 on t1.cod_recebimento = t5.cod_rec
where t1.cod_cli = '$cod_cli' and t1.fl_status = 'X'
order by date(dt_janela) asc";

$res = mysqli_query($link, $SQL);

$link->close();
?>
<table data-toggle="table" id="dt_basic_9" class="table" data-detail-view="" data-pagination="true" data-pagination-pre-text="< Previous" data-pagination-next-text="Next >" data-classes="table table-hover table-condensed">
	<thead>
		<tr>
			<th> AÇÕES </th>
			<th> O.R. </th>
			<th> DATA</th>
			<th> HORÁRIO</th>
			<th> PESO  </th>
			<th> VOLUME  </th>
			<th> FORNECEDOR  </th>	
			<th> TRANSPORTADOR  </th>
			<th> PLACA  </th>			
			<th> STATUS </th>
		</tr>
	</thead>
	<tbody>
		<?php
		while ($dados = mysqli_fetch_array($res)) {
			?>
			<tr class="status clickable js-tabularinfo-toggle" data-status="<?php echo $dados['fl_status']; ?>" data-toggle="collapse" id="row1" data-target=".row1<?php echo $dados['cod_recebimento'];?>">
				<td style="text-align: center; width: 400px">
					<button type="submit" id="btnRetRecAg" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">RETORNAR</button>
				</td>
				<td style="text-align: center; width: 10px"> <?php echo $dados['cod_recebimento']; ?> </td>
				<td style="text-align: center;"> 
					<?php echo $dados['dt_janela'];?>
				</td>
				<td style="text-align: center;"> <?php echo $dados['ds_janela']; ?> </td>
				<td style="text-align: right;"> <?php echo $dados['nr_peso_previsto']; ?> </td>
				<td style="text-align: right;"> <?php echo $dados['nr_volume_previsto']; ?> </td>
				<td> <?php echo $dados['nm_fornecedor']; ?> </td>
				<td> <?php echo $dados['nm_transportadora']; ?> </td>
				<td> <?php echo $dados['nm_placa']; ?> </td>
				<?php
				if ($dados['fl_status'] == 'A' || $dados['fl_status'] == 'K') {

					$td = '<td>ABERTA</td>';
					echo $td;

				}else if ($dados['fl_status'] == 'C'){

					$td = '<td>CONFERÊNCIA FINALIZADA</td>';
					echo $td;

				}else if ($dados['fl_status'] == 'F'){

					$td = '<td>OR FINALIZADA</td>';
					echo $td;

				}else if ($dados['fl_status'] == 'S'){

					$td = '<td style="background-color: #FFFF00">AGUARDANDO CONFIRMAÇÃO</td>';
					echo $td;
				}else if ($dados['fl_status'] == 'AG'){

					$td = '<td style="background-color: #9AFF9A">CONFIRMADA</td>';
					echo $td;
				}else if ($dados['fl_status'] == 'X'){

					$td = '<td style="background-color: #9AFF9A">FINALIZADA</td>';
					echo $td;
				}
				?>
			</tr>
			<tr  class="tabularinfo__subblock collapse row1<?php echo $dados['cod_recebimento'];?>">
				<td colspan="9">
					<table id="" class="table" data-detail-view="">
						<thead>
							<tr class="" data-toggle="" id="" data-target=".subrow1">
								<th></th>
								<th scope="col">HORA DE CHEGADA</th>
								<th scope="col">INÍCIO DA DESCARGA</th>
								<th scope="col">FIM DA DESCARGA</th>
								<th scope="col">TEMPO DE DESCARREGAMENTO</th>
								<th scope="col">TEMPO DE PERMANÊNCIA</th>
								<th scope="col">*</th>
							</tr>
						</thead>
						<tbody>
							<tr class="subrow1" data-href="#" style="background-color: #E8E8E8">
								<td></td>
								<td><?php echo $linha['hr_chegada']; ?></td>
								<td><?php echo $linha['init_descarga']; ?></td>
								<td><?php echo $linha['fim_descarga']; ?></td>
								<td><?php echo $linha['t_descarregamento']; ?></td>
								<td><?php echo $linha['t_permanece']; ?></td>
								<td width="13%">
									<button type="submit" id="btnDtlPedSep" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">SALVAR</button>
									<button type="submit" id="btnPesqQtdPed" class="btn btn-danger btn-xs" value="<?php echo $linha['nr_pedido']; ?>">EXCLUIR</button>
								</td>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	<?php }?>
</tbody>
</table>
<script type="text/javascript">	
	$(document).ready(function() {

		pageSetUp();
		var responsiveHelper_dt_basic_9 = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		$('#dt_basic_9').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"iDisplayLength": 100,
			"language": {
				"zeroRecords": "Não há agendamentos ativos."
			},
			"preDrawCallback" : function() {
				if (!responsiveHelper_dt_basic_9) {
					responsiveHelper_dt_basic_9 = new ResponsiveDatatablesHelper($('#dt_basic_9'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic_9.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic_9.respond();
			}
		});
	});

</script>