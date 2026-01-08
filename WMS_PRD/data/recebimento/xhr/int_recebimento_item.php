<!DOCTYPE html>
<html lang="pt-br">
<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container theme-showcase" role="main">

<?php
	require_once("bd_class.php");
	
	$cod_c_v = $_POST['cod_c_v'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "update tb_saldo_produto set fl_status =  0 WHERE cod_c_v = '$cod_c_v'";
	
	$resultado_id = mysqli_query($link, $sql);

if($resultado_id){

		if(mysqli_affected_rows($link) > 0){ ?>

	<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Recebimento inativado com sucesso!</h4>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<a href="http://localhost/app/WMS/wms/html/recebimento.php"><button type="button" class="btn btn-success">Ok</button></a>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function () {
			$('#conf_cadastro').modal('show');
		});
	</script>

	<?php }else{ ?> 

	<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Erro ao inativar!</h4>
				</div>
				<div class="modal-body">                                

				</div>
				<div class="modal-footer">
					<a href="http://localhost/app/WMS/wms/html/recebimento.php"><button type="button" class="btn btn-danger">Ok</button></a>
				</div>
			</div>
		</div>
	</div>          
	<script>
		$(document).ready(function () {
			$('#conf_cadastro').modal('show');
		});
	</script>
	<?php }
}  
$link->close();

?>
