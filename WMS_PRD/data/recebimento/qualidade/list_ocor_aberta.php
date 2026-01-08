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
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select * from tb_ocorrencias where fl_empresa = '$cod_cli' and (fl_status = 'A' or fl_status = 'P')";
$res = mysqli_query($link, $SQL);

$link->close();
?>
<table id="dt_basic9" class="table" style="font-size: 12px">
	<thead>
		<tr>
			<th> AÇÕES </th>
			<th> CÓDIGO </th>
			<th> ORIGEM </th>
			<th> DESCRIÇÃO </th>
			<th> RESPONSÁVEL </th>
			<th> ABERTURA </th>
			<th> FINAL </th>	
			<th> PRAZO (DIAS) </th>
			<th> TIPO </th>			
			<th> SITUAÇÃO </th>			
			<th> CRITICIDADE </th>
		</tr>
	</thead>
	<tbody>
		<?php 
		while($dados = mysqli_fetch_assoc($res)) {?>
			<tr  class="status" data-status="<?php echo $dados['fl_status']; ?>">
				<td style="text-align: center; width: 200px">
					<button type="submit" class="btn btn-primary btn-xs" id="btnUpdOcor" value="<?php echo $dados['cod_ocorrencia']; ?>" style="width: 70px">DETALHE</button>
					<button type="submit" class="btn btn-success btn-xs" id="btnFinOcor" value="<?php echo $dados['cod_ocorrencia']; ?>" style="width: 70px">FINALIZAR</button>
				</td>
				<td><?php echo $dados['cod_ocorrencia']; ?></td>
				<td><?php echo $dados['cod_origem']; ?></td>
				<td><?php echo $dados['nm_ocorrencia']; ?></td>
				<td><?php echo $dados['ds_responsavel']; ?></td>
				<td>
					<?php if($dados['dt_abertura'] == 0){

						echo '';

					}else{

						echo date("d/m/Y", strtotime($dados['dt_abertura']));

					}?>

				</td>
				<td>
					<?php 

					if($dados['dt_final'] == '' || $dados['dt_final'] == 0){

						echo '';

					}else{

						echo date("d/m/Y", strtotime($dados['dt_final']));

					}?>

				</td>
				<td>
					<?php 
					if($dados['dt_final'] == '' || $dados['dt_final'] == 0 || $dados['dt_abertura'] == 0){

						echo '';

					}else{

						$data_inicio = new DateTime($dados['dt_abertura']);
						$data_fim = new DateTime($dados['dt_final']);
						$dateInterval = $data_inicio->diff($data_fim);
						echo $dateInterval->days;

					}?>
				</td>
				<td>
					<?php 

					if($dados['tipo'] == 'A'){

						echo "ARMAZÉM";

					}else if($dados['tipo'] == 'T'){

						echo "TRANSPORTE";

					}else if($dados['tipo'] == 'G'){

						echo "AGENDAMENTO";

					}else{

						echo "OUTROS";

					} ?>

				</td>
				<td>
					<?php 

					if($dados['fl_status'] == 'A'){

						echo "ABERTA";

					}elseif($dados['fl_status'] == 'F'){

						echo "FINALIZADA";

					}else if($dados['fl_status'] == 'P'){

						echo "EM PROGRESSO";

					}else{

						echo "ATRASADA";

					}?>
				</td>
				<td>
					<?php 

					if($dados['criticidade'] == 'B'){

						echo "BAIXA";

					}else if($dados['criticidade'] == 'M'){


						echo "MÉDIA";

					}else{

						echo "ALTA";

					}?>

				</td>
			</tr>
		<?php }?>
	</tbody>
</table>
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