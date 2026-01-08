<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;
} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_ped = "SELECT c.id as id_col, c.ds_data, c.nm_fornecedor, count(n.n_serie) as total_col, c.fl_status, c.usr_create, c.dt_create
from tb_nserie_col c
left join tb_nserie n on c.id = n.id_col
where c.fl_status = 'A' and n.fl_status <> 'E'
group by c.id
order by c.ds_data desc";
$res_ped = mysqli_query($link, $sql_ped);

$link->close();

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Argus - Conferência eletrônica</title>
	<link rel="shortcut icon" href="_assets/img/logoArgus.png">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="js/jquery.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="_assets/js/index.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
	<script src="js/seriais.js"></script>
	<script src="js/baixa_pedidos.js"></script>
	<script src="js/transf_end.js"></script>
	<script src="js/inventario.js"></script>
	<script src="js/custom/recebimento.js"></script>
	<script src="js/custom/expedicao.js"></script>
	<style>
		input[type="email"]::placeholder {

			/* Firefox, Chrome, Opera */
			text-align: center;
		}

		input[type="text"]::placeholder {

			/* Firefox, Chrome, Opera */
			text-align: left;
		}

		input[type="tel"]::placeholder {

			/* Firefox, Chrome, Opera */
			text-align: left;
		}

		input[type="email"]:-ms-input-placeholder {

			/* Internet Explorer 10-11 */
			text-align: center;
		}

		input[type="email"]::-ms-input-placeholder {

			/* Microsoft Edge */
			text-align: center;
		}
	</style>
</head>

<body>
	<style type="text/css">
		.ocupado {
			background-color: #F08080;
		}

		.livre {
			background-color: #7FFFD4;
		}

		.alerta {
			background-color: #EEDD82;
		}

		.finalizado {
			background-color: #ADD8E6;
		}
	</style>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="home.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<a href="seriais_edit.php" style="text-decoration: none">
						<button type="button" class="btn btn-primary btn-lg btn-block">Nova coleta de seriais</button>
					</a>
				</div>
			</article>
			<article>
				<div class="row">
					<h4>Coletas pendentes por fornecedor/data</h4>
					<div id="total_coletado"></div>
				</div>
				<hr>
				<div class="row">
					<div id="retFinRec"></div>
					<table data-role="table" id="" data-mode="" class="" style="font-size: 10px;">
						<thead>
							<tr>
								<th data-priority="1">Código</th>
								<th data-priority="2">Data</th>
								<th data-priority="3">Fornecedor</th>
								<th data-priority="3">Coletado</th>
								<th style="width:35%;text-align:center;">Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($dados = mysqli_fetch_assoc($res_ped)) { ?>
								<tr>
									<td><?php echo $dados['id_col']; ?></td>
									<td><?php echo $dados['ds_data']; ?></td>
									<td><?php echo $dados['nm_fornecedor']; ?></td>
									<td><?php echo $dados['total_col']; ?></td>
									<td style="text-align: right;">
										<form>
											<a href="" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
												<input type="button" id="btnFinSr" data-id="<?php echo $dados['id_col']; ?>" data-role="none" value="Finalizar" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">
											</a>
											<a href="seriais_edit.php?id_col=<?php echo $dados['id_col']; ?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
												<input type="button" id="" data-role="none" value="Incluir" style="float: right;margin-left: 5px;background-color: #FF4500;text-shadow: none;color:white;border-color: #fdfbfb">
											</a>
										</form>
									</td>
								<tr>
								<?php } ?>
						</tbody>
					</table>
				</div>
			</article>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click', '#btnLogoutHome', function() {
			event.preventDefault();
			$.ajax({
				url: "logout.php",
				method: "GET",
				success: function(j) {
					alert("Saída realizada com sucesso!");
					window.location.replace("index.php");
				}
			});
		});
	});
</script>
</body>

</html>