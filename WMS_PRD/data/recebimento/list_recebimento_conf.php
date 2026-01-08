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

$SQL = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, date_format(t1.dt_recebimento_previsto,'%d/%m/%Y') as dt_recebimento_previsto,  t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, date_format(t1.dt_recebimento_real,'%d/%m/%Y') as dt_recebimento_real, t1.usr_create, t1.usr_confere, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.usr_recebe, t1.dt_recebido, t1.usr_autoriza, t1.dt_autoriza, t1.fl_status, t2.cod_cliente, t2.nm_cliente, t4.nm_user, count(t5.id) as total_conf
from tb_recebimento t1
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
left join tb_usuario t4 on t1.usr_create = t4.id
left join tb_nf_entrada_conf t5 on t1.cod_recebimento = t5.cod_rec
left join tb_nf_entrada t6 on t1.cod_recebimento = t6.cod_rec
where t1.cod_cli = '$cod_cli' and (t1.fl_status = 'C' or t1.fl_status = 'L')
group by t1.cod_recebimento
order by t1.cod_recebimento desc";
$res = mysqli_query($link, $SQL);

?>
<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
	<div>
		<div class="jarviswidget-editbox">
		</div>
		<div id="retCte"></div>
		<div id="retNf"></div>
		<div class="widget-body no-padding" id="tabela_cte_pend">
			<table id="dt_basic3" class="table" style="font-size: 12px">
				<thead>
					<tr>
						<th> AÇÕES </th>
						<th> O.R. </th>
						<th> DATA</th>
						<th> PESO  </th>
						<th> VOLUME  </th>
						<th> CONFERIDO  </th>
						<th> FORNECEDOR  </th>	
						<th> TRANSPORTADOR  </th>
						<th> PLACA  </th>			
						<th style="width: 150px"> STATUS </th>			
						<th style="width: 250px"> SITUAÇÃO </th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($dados = mysqli_fetch_array($res)) {

						$sql_vol = "select sum(t1.nr_volume) as total_volume 
						from tb_nf_entrada_item t1
						left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
						where t2.cod_rec = '".$dados['cod_recebimento']."'";
						$res_vol = mysqli_query($link, $sql_vol);
						$dados_vol=mysqli_fetch_array($res_vol);
						$total_vol = $dados_vol['total_volume'];
						$saldo_conf = ($dados['total_conf']/$total_vol)*100;
						?>
						<tr  class="status" data-status="<?php echo $dados['fl_status']; ?>">
							<td style="text-align: center; width: 300px">
								<button type="submit" id="btnUpdRecConf" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">DETALHE</button>
								<button type="submit" id="btnFimRec" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">FINALIZAR</button>
								<!--button type="submit" id="btnPrintRec" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">IMPRIMIR</button-->
								<!--button type="submit" id="btnDelConf" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">ZERAR CONFERÊNCIA</button-->
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
							<td style="text-align: right;"> <?php echo $dados_vol['total_volume']; ?> </td>
							<td style="text-align: right;"> <?php echo $dados['total_conf']; ?> </td>
							<td> <?php echo $dados['nm_fornecedor']; ?> </td>
							<td> <?php echo $dados['nm_transportadora']; ?> </td>
							<td> <?php echo $dados['nm_placa']; ?> </td>
							<td class="progresso" style="font-size: 12px;text-align: right;"><span class="percent"><?php echo number_format($saldo_conf, 2, ',', ' '); ?>%</span>
								<div class="progress progress-sm">
									<div class="progress-bar bg-color-greenLight" style="width: <?php echo $saldo_conf; ?>%"></div>
                            	</div>
                            </td>
                            <?php
                            if ($dados['fl_status'] == 'L') {

                            	$td = '<td style="background-color: #F4A460">AGUARDANDO CONFERÊNCIA</td>';
                            	echo $td;

                            }else if ($dados['fl_status'] == 'C'){

                            	$td = '<td style="background-color: #9AFF9A">CONFERÊNCIA FINALIZADA</td>';
                            	echo $td;

                            }else if ($dados['fl_status'] == 'F'){

                            	$td = '<td style="background-color: #B0C4DE">OR FINALIZADA</td>';
                            	echo $td;

                            }
                            ?>
                        </tr>
                    <?php }
                    $link->close();?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">	
	$(document).ready(function() {

		pageSetUp();
		var responsiveHelper_dt_basic3 = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		$('#dt_basic3').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"iDisplayLength": 100,
			"oLanguage": {
				"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
			},
			"preDrawCallback" : function() {
				if (!responsiveHelper_dt_basic3) {
					responsiveHelper_dt_basic3 = new ResponsiveDatatablesHelper($('#dt_basic3'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic3.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic3.respond();
			}
		});
	});

</script>