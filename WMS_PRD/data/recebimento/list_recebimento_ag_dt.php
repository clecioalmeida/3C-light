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

$dt_ini 	= $_POST["dt_ini_ag"];
$dt_fim 	= $_POST["dt_fim_ag"];

$SQL = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, t1.dt_recebimento_previsto,  t1.nr_volume_previsto, t1.nm_transportadora, t1.nr_insumo, t1.nm_motorista, t1.nm_placa, t1.tp_veiculo, t6.descricao, t1.dt_recebimento_real, t1.usr_create, t1.usr_confere, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.usr_recebe, t1.dt_recebido, t1.usr_autoriza, t1.dt_autoriza, t1.fl_status, t2.cod_cliente, t2.nm_cliente, t4.nm_user, date_format(t5.dt_janela,'%d/%m/%Y') as dt_janela, t5.ds_janela, t5.id as id_janela, date_format(t1.hr_chegada,'%Y/%m/%d') as dt_chegada, t1.hr_chegada, t1.init_descarga, t1.fim_descarga, t1.t_descarregamento, t1.t_permanece
from tb_recebimento_ag t1
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
left join tb_usuario t4 on t1.usr_create = t4.id
left join tb_janela t5 on t1.cod_recebimento = t5.cod_rec
left join tb_tipo_veiculo t6 on t1.tp_veiculo = t6.codigo
where t1.cod_cli = '$cod_cli' and t5.dt_janela >= '$dt_ini' and t5.dt_janela <= '$dt_fim'
order by date(dt_janela) asc";
$res = mysqli_query($link, $SQL);

$link->close();
?>
<style type="text/css">

	.tableFixHead          { overflow-y: auto; height: 640px; }
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
		<table id="" class="table" data-detail-view="" data-pagination="true" data-pagination-pre-text="< Previous" data-pagination-next-text="Next >" data-classes="table table-hover table-condensed" style="font-size: 12px">
			<thead>
				<tr>
					<th> AÇÕES </th>
					<th> O.R. </th>
					<th> PEDIDO SAP </th>
					<th> DATA</th>
					<th> HORÁRIO</th>
					<th> PESO  </th>
					<th> VOLUME  </th>
					<th> FORNECEDOR  </th>	
					<th> TRANSPORTADOR  </th>
					<th> PLACA  </th>			
					<th> TIPO  </th>			
					<th> STATUS </th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($dados = mysqli_fetch_array($res)) {
					?>
					<tr  class="status clickable js-tabularinfo-toggle" data-toggle="collapse" id="row1" data-target=".row1<?php echo $dados['cod_recebimento'];?>" data-status="<?php echo $dados['fl_status']; ?>">
						<td style="text-align: center; width: 400px">
							<button type="submit" id="btnUpdRecAg" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">DETALHE</button>
							<button type="submit" id="btnRecAg" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">RECUSAR</button>
							<!--button type="submit" id="btnRecAgNc" class="btn btn-info btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">FALTA</button-->
							<button type="submit" id="btnEncRecAg" class="btn btn-success btn-xs" value="<?php echo $dados['cod_recebimento']; ?>" data-st="<?php echo $dados['fl_status']; ?>">FINALIZAR</button>
							<?php 

							if($dados['fl_status'] == "S"){

								$btn_conf = '<button type="submit" id="btnConfRecAg" class="btn btn-success btn-xs" value="'.$dados['cod_recebimento'].'">CONFIRMAR</button>';

							}else{

								$btn_conf = '<button type="submit" id="btnConfRecAg" class="btn btn-success btn-xs" value="'.$dados['cod_recebimento'].'" disabled>CONFIRMAR</button>';

							}

							echo $btn_conf;

							?>

						</td>
						<td style="text-align: center; width: 10px"> <?php echo $dados['cod_recebimento']; ?> </td>
						<td> <?php echo $dados['nr_insumo']; ?> </td>
						<td style="text-align: center;"> 
							<?php echo $dados['dt_janela'];?>
						</td>
						<td style="text-align: center;"> <?php echo $dados['ds_janela']; ?> </td>
						<td style="text-align: right;"> <?php echo $dados['nr_peso_previsto']; ?> </td>
						<td style="text-align: right;"> <?php echo $dados['nr_volume_previsto']; ?> </td>
						<td> <?php echo $dados['nm_fornecedor']; ?> </td>
						<td> <?php echo $dados['nm_transportadora']; ?> </td>
						<td> <?php echo $dados['nm_placa']; ?> </td>
						<td> <?php echo $dados['descricao']; ?> </td>
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
						}else if ($dados['fl_status'] == 'R'){

							$td = '<td style="background-color: #D96123">RECUSADO</td>';
							echo $td;
						}else if ($dados['fl_status'] == 'NC'){

							$td = '<td style="background-color: #D96123">NÃO COMPARECEU</td>';
							echo $td;
						}
						?>
					</tr>
					<tr  class="tabularinfo__subblock collapse row1<?php echo $dados['cod_recebimento'];?>">
						<td colspan="11">
							<table id="" class="table" data-detail-view="">
								<thead>
									<tr class="" data-toggle="" id="" data-target=".subrow1">
										<th scope="col">STATUS</th>
										<th scope="col">DATA DE CHEGADA</th>
										<th scope="col">HORA DE CHEGADA</th>
										<th scope="col">INÍCIO DA DESCARGA</th>
										<th scope="col">FIM DA DESCARGA</th>
										<th scope="col">TEMPO DE DESCARREGAMENTO</th>
										<th scope="col">TEMPO DE PERMANÊNCIA</th>
										<th scope="col">TD/TP</th>
										<th scope="col">*</th>
									</tr>
								</thead>
								<tbody>
									<tr class="subrow1" data-href="#">
										<td>
											<select name="fl_status" id="fl_status" class="selectpicker">
												<option value="HKD">NÃO COMPARECEU</option>
												<option value="HKD">ATRASOU</option>
												<option value="HKD">CHEGOU FORA DO AGENDAMENTO</option>
											</select>
										</td>
										<td style="text-align: right;width: 50px">
											<input type="date" name="dt_chegada" id="dt_chegada" value="<?php echo $dados['dt_chegada']; ?>" placeholder="DATA DE CHEGADA">
										</td>
										<td style="text-align: right;">										
											<input type="text" name="hr_chegada" id="hr_chegada" value="<?php echo $dados['hr_chegada']; ?>" placeholder="DATA DE CHEGADA">
										</td>
										<td style="text-align: right;">										
											<input type="text" name="init_descarga" id="init_descarga" value="<?php echo $dados['init_descarga']; ?>" placeholder="INÍCIO DA DESCARGA">
										</td>
										<td style="text-align: right;">										
											<input type="text" name="fim_descarga" id="fim_descarga" value="<?php echo $dados['fim_descarga']; ?>" placeholder="FIM DA DESCARGA">
										</td>
										<td style="text-align: right;">										
											<input type="text" name="t_descarregamento" id="t_descarregamento" value="<?php echo $dados['t_descarregamento']; ?>" placeholder="TEMPO DE DESCARREGAMENTO">
										</td>
										<td style="text-align: right;">										
											<input type="text" name="t_permanece" id="t_permanece" value="<?php echo $dados['t_permanece']; ?>" placeholder="TEMPO DE PERMANÊNCIA">
										</td>
										<td></td>
										<td width="13%" colspan="2">
											<button type="submit" id="btnDtlPedSep" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">SALVAR</button>
											<button type="submit" id="btnPesqQtdPed" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">EXCLUIR</button>
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
</div>
<script type="text/javascript">	
	$(document).ready(function() {

		/*function hmToMins(str) {
			const [hh, mm] = str.split(':').map(nr => Number(nr) || 0);
			return hh * 60 + mm;
		}

		function calcular() {
			const init_descarga = hmToMins(document.getElementById('init_descarga').value);
			const fim_descarga = hmToMins(document.getElementById('fim_descarga').value);
			const diff = fim_descarga - init_descarga;
			if (isNaN(diff)) return;
			const hhmm = [
			Math.floor(diff / 60), 
			Math.round(diff % 60)
			].map(nr => `00${nr}`.slice(-2)).join(':');

			document.getElementById('t_descarregamento').value = hhmm;
		}

		calcular();*/

		function hmToMins(str) {
			const [hh, mm] = str.split(':').map(nr => Number(nr) || 0);
			return hh * 60 + mm;
		}

		const init_descarga = hmToMins(document.getElementById('init_descarga').value);
		const fim_descarga = hmToMins(document.getElementById('fim_descarga').value);
		console.log(init_descarga);

		$(document).on('change','#fim_descarga',function() {

			var timeStart = new Date(init_descarga).getTime();
			var timeEnd = new Date(fim_descarga).getTime();
			var hourDiff = fim_descarga - init_descarga; //in ms
			var secDiff = hourDiff / 1000; //in s
			var minDiff = hourDiff / 60 / 1000; //in minutes
			var hDiff = hourDiff / 3600 / 1000; //in hours
			var humanReadable = {};
			humanReadable.hours = Math.floor(minDiff);
			//humanReadable.minutes = minDiff - 60 * humanReadable.hours;
			console.log(hourDiff);

			/*var init_descarga = $('#init_descarga').val();
			var fim_descarga = $('#fim_descarga').val();;

			var horas = Math.abs(new Date(fim_descarga) - new Date(init_descarga)) / 36e5;
			alert(horas,init_descarga,fim_descarga);*/

		});

		

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