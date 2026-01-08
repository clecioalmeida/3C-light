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

$SQL = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.tp_rec, date_format(t1.dt_recebimento_previsto,'%d/%m/%Y') as dt_recebimento_previsto, sum(t6.nr_peso_unit) as nr_peso, sum(t6.nr_qtde) as nr_qtde, sum(t6.nr_volume) as nr_volume, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, date_format(t1.dt_recebimento_real,'%d/%m/%Y') as dt_recebimento_real, t1.usr_create, t1.usr_confere, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.usr_recebe, t1.dt_recebido, t1.usr_autoriza, t1.dt_autoriza, t1.fl_status, t2.cod_cliente, t2.nm_cliente, t4.nm_user
from tb_recebimento t1
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
left join tb_usuario t4 on t1.usr_create = t4.id
left join tb_nf_entrada t5 on t1.cod_recebimento = t5.cod_rec
left join tb_nf_entrada_item t6 on t5.cod_nf_entrada = t6.cod_nf_entrada
where t1.cod_cli = '$cod_cli' and (t1.fl_status = 'A' or t1.fl_status = 'AG' or t1.fl_status = 'L' or t1.fl_status = 'CR' or t1.fl_status = 'AT')
group by t1.cod_recebimento
order by t1.cod_recebimento desc";

$res = mysqli_query($link, $SQL);

$link->close();
?>
<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
	<div>
		<div class="jarviswidget-editbox">
		</div>
		<div id="retCte"></div>
		<div id="retNf"></div>
		<div class="widget-body no-padding" id="tabela_cte_pend">
			<table id="dt_basic2" class="table" style="font-size: 12px">
				<thead>
					<tr>
						<th> AÇÕES </th>
						<th> O.R. </th>
						<th> DATA</th>
						<th> PESO  </th>
						<th> VOLUME  </th>
						<th> FORNECEDOR  </th>	
						<th> TRANSPORTADOR  </th>
						<th> PLACA  </th>			
						<th> SITUAÇÃO </th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($dados = mysqli_fetch_array($res)) {
						?>
						<tr  class="status" data-status="<?php echo $dados['fl_status']; ?>">
							<td style="text-align: center; width: 400px">
								<button type="submit" id="btnUpdRec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento'];?>">DETALHE</button>
								<button type="submit" id="btnDelRec" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_recebimento'];?>" data-st="<?php echo $dados['fl_status'];?>">EXCLUIR</button>
								<button type="submit" id="btnGeraEtq" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">ETIQUETA</button>
								<button type="submit" id="btnPrintRec" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">IMPRIMIR</button>
								<button type="submit" id="btnLibRec" class="btn btn-success btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">LIBERAR</button>
							</td>
							<td style="text-align: center; width: 10px"> <?php echo $dados['cod_recebimento']; ?> </td>
							<td style="text-align: center;"> 
								<?php
								if ($dados['dt_recebimento_real'] < 1) {
									echo '';
								} else {
									echo $dados['dt_recebimento_real'];
								}
								?>
							</td>
							<td style="text-align: right;"> <?php echo $dados['nr_peso_previsto']; ?> </td>
							<td style="text-align: right;"> <?php echo $dados['nr_volume_previsto']; ?> </td>
							<td> <?php echo $dados['nm_fornecedor']; ?> </td>
							<td> <?php echo $dados['nm_transportadora']; ?> </td>
							<td> <?php echo $dados['nm_placa']; ?> </td>
							<?php
							if ($dados['fl_status'] == 'A' || $dados['fl_status'] == 'K') {

								$td = '<td style="background-color: #F4A460">ABERTA</td>';
								echo $td;

							}else if ($dados['fl_status'] == 'C'){

								$td = '<td style="background-color: #9AFF9A">CONFERÊNCIA FINALIZADA</td>';
								echo $td;

							}else if ($dados['fl_status'] == 'F'){

								$td = '<td style="background-color: #B0C4DE">OR FINALIZADA</td>';
								echo $td;

							}else if ($dados['fl_status'] == 'S'){

								$td = '<td style="background-color: #FFFF00">AGUARDANDO CONFIRMAÇÃO</td>';
								echo $td;
							}else if ($dados['fl_status'] == 'AG'){

								$td = '<td style="background-color:#FFFF00">AGENDADA</td>';
								echo $td;
							}else if ($dados['fl_status'] == 'L'){

								$td = '<td style="background-color: #9AFF9A">LIBERADA</td>';
								echo $td;
							}else if ($dados['fl_status'] == 'CR'){

								$td = '<td style="background-color: #FFFF00">AGUARDANDO LIBERAÇÃO</td>';
								echo $td;
							}else if ($dados['fl_status'] == 'AT'){

								$td = '<td style="background-color: #9AFF9A">ENTRADA AUTORIZADA</td>';
								echo $td;
							}
							?>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">	
	$(document).ready(function() {

		pageSetUp();
		var responsiveHelper_dt_basic2 = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		$('#dt_basic2').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"iDisplayLength": 100,
			"oLanguage": {
				"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
			},
			"preDrawCallback" : function() {
				if (!responsiveHelper_dt_basic2) {
					responsiveHelper_dt_basic2 = new ResponsiveDatatablesHelper($('#dt_basic2'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic2.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic2.respond();
			}
		});
	});

</script>