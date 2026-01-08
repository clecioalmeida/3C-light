<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$SQL = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, t1.dt_recebimento_previsto,  t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.dt_recebimento_real, t1.usr_create, t1.usr_confere, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.usr_recebe, t1.dt_recebido, t1.usr_autoriza, t1.dt_autoriza, t1.fl_status, t2.cod_cliente, t2.nm_cliente, t4.nm_user, date_format(t5.dt_janela,'%d/%m/%Y') as dt_janela, t5.ds_janela
from tb_recebimento_ag t1
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
left join tb_usuario t4 on t1.usr_create = t4.id
left join tb_janela t5 on t1.cod_recebimento = t5.cod_rec
where (t1.fl_status = 'AG' or t1.fl_status = 'CR' or t1.fl_status = 'AT')";
$res = mysqli_query($link, $SQL);

$link->close();
?>
<table id="dt_basic9" class="table" style="font-size: 12px">
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
			<tr  class="status" data-status="<?php echo $dados['fl_status']; ?>">
				<td style="text-align: center; width: 400px">
					<?php 

						if($dados['fl_status'] == "AG"){

							$btn_conf = '<button type="submit" id="btnRegChg" class="btn btn-primary btn-xs" value="'.$dados['cod_recebimento'].'">REGISTRAR CHEGADA</button>
							<button type="submit" id="btnRegEnt" class="btn btn-success btn-xs" value="'.$dados['cod_recebimento'].'" disabled>AUTORIZAR ENTRADA</button>';

						}else if($dados['fl_status'] == "CR"){

							$btn_conf = '<button type="submit" id="btnRegChg" class="btn btn-primary btn-xs" value="'.$dados['cod_recebimento'].'" disabled>REGISTRAR CHEGADA</button>
							<button type="submit" id="btnRegEnt" class="btn btn-success btn-xs" value="'.$dados['cod_recebimento'].'">AUTORIZAR ENTRADA</button>';

						}else if($dados['fl_status'] == "AT"){

							$btn_conf = '<button type="submit" id="btnRegChg" class="btn btn-primary btn-xs" value="'.$dados['cod_recebimento'].'" disabled>REGISTRAR CHEGADA</button>
							<button type="submit" id="btnRegEnt" class="btn btn-success btn-xs" value="'.$dados['cod_recebimento'].'" disabled>AUTORIZAR ENTRADA</button>';

						}

						echo $btn_conf;

					?>
					
				</td>
				<td style="text-align: center; width: 10px"> <?php echo $dados['cod_recebimento']; ?> </td>
				<td style="text-align: center;"> <?php echo $dados['dt_janela'];?></td>
				<td style="text-align: center;"> <?php echo $dados['ds_janela']; ?> </td>
				<td style="text-align: right;"> <?php echo $dados['nr_peso_previsto']; ?> </td>
				<td style="text-align: right;"> <?php echo $dados['nr_volume_previsto']; ?> </td>
				<td> <?php echo $dados['nm_fornecedor']; ?> </td>
				<td> <?php echo $dados['nm_transportadora']; ?> </td>
				<td> <?php echo $dados['nm_placa']; ?> </td>
				<?php
				if ($dados['fl_status'] == 'S') {

					$td = '<td style="background-color: #FFFF00">AGUARDANDO CONFIRMAÇÃO</td>';

				}else if ($dados['fl_status'] == 'AG'){

					$td = '<td style="background-color: #9AFF9A">CONFIRMADA</td>';

				}else if ($dados['fl_status'] == 'CR'){

					$td = '<td style="background-color: #EEDD82">CHEGADA CONFIRMADA</td>';

				}else if ($dados['fl_status'] == 'AT'){

					$td = '<td style="background-color: #9AFF9A">ENTRADA AUTORIZADA</td>';

				}
				echo $td;
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
		var responsiveHelper_dt_basic9 = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		$('#dt_basic9').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"iDisplayLength": 100,
			"language": {
				"zeroRecords": "Não há agendamentos ativos."
			},
			"preDrawCallback" : function() {
				if (!responsiveHelper_dt_basic9) {
					responsiveHelper_dt_basic9 = new ResponsiveDatatablesHelper($('#dt_basic9'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic9.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic9.respond();
			}
		});
	});

</script>