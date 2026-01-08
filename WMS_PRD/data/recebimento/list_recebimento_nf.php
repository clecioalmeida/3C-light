<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$id_rec = $_POST["id_rec"];

$select_nf = "SELECT t1.nr_fisc_ent, t3.nm_cliente as nm_emitente, t4.nm_cliente as nm_destinatario, t1.nr_peso_ent, t1.qtd_vol_ent, t1.tp_vol_ent, t1.vl_tot_nf_ent
from tb_nf_entrada t1
left join tb_recebimento t2 on t1.cod_rec = t2.cod_recebimento
left join tb_cliente t3 on t1.id_rem = t3.cod_cliente
left join tb_cliente t4 on t1.id_dest = t4.cod_cliente
where t1.cod_rec = '$id_rec'";
$res_nf = mysqli_query($link, $select_nf);
$tr = mysqli_num_rows($res_nf);

$select_or = "select * from tb_recebimento where cod_recebimento = '$id_rec'";
$res_or = mysqli_query($link, $select_or);
while ($dados_or = mysqli_fetch_assoc($res_or)) {
	$nm_fornecedor = $dados_or["nm_fornecedor"];
	$nm_transportadora = $dados_or["nm_transportadora"];
	$nr_peso_previsto = $dados_or["nr_peso_previsto"];
	$nr_volume_previsto = $dados_or["nr_volume_previsto"];
	$dt_recebimento_previsto = $dados_or["dt_recebimento_previsto"];
	$nm_motorista = $dados_or["nm_motorista"];
	$nm_placa = $dados_or["nm_placa"];
	$ds_obs = $dados_or["ds_obs"];
	$fl_status = $dados_or["fl_status"];
}

$link->close();
?>
<table class="table" id="sample_1" style="font-size: 12px">
	<thead>
		<tr>
			<th > Ações</th>
			<th> N.F. </th>
			<th> Fornecedor </th>
			<th data-toggle="tooltip" data-placement="left" title="Peso total da NF"> Peso (Kg)</th>
			<th data-toggle="tooltip" data-placement="left" title="Total de volumes da NF"> Volumes </th>
			<th data-toggle="tooltip" data-placement="left" title="Tipo de volume"> Tipo </th>
			<th data-toggle="tooltip" data-placement="left" title="Valor total da NF"> Valor  </th>
		</tr>
	</thead>
	<tbody id="retNfRec">
		<?php
		while ($dados = mysqli_fetch_assoc($res_nf)) {
			?>
			<tr class="odd gradeX">
				<td style="text-align: center; width: 300px">
					<button type="submit" id="btnDtlNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Detalhe</button>
					<button type="submit" id="btnUpdNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Alterar</button>
					<button type="submit" id="btnDelNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Excluir</button>
					<button type="submit" id="btnProdNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Produtos</button>
				</td>
				<td style="text-align: center; width: 10px"> <?php echo $dados['nr_fisc_ent']; ?> </td>	
				<td style="width: 30%"> <?php echo $dados['nm_emitente']; ?> </td>
				<td style="text-align: center; width: 30px"> <?php echo $dados['nr_peso_ent']; ?> </td>
				<td style="text-align: center; width: 30px"> <?php echo $dados['qtd_vol_ent']; ?> </td>
				<td style="text-align: center; width: 10px"> <?php echo $dados['tp_vol_ent']; ?> </td>
				<td style="text-align: center; width: 10px"> <?php echo $dados['vl_tot_nf_ent']; ?> </td>
			</tr>
		<?php }?>
	</tbody>
</table>
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