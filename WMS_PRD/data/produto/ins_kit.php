<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="container theme-showcase" role="main">
<?php
	require_once("bd_class.php");
	
	$descricao = $_POST['descricao'];
	$cod_cliente = $_POST['cod_cliente'];
	$ean = $_POST['ean'];
	$controle_lote = $_POST['controle_lote'];
	$detalhe_kit = $_POST['detalhe_kit'];
	$estoque_minimo = $_POST['estoque_minimo'];
	$volume_padrao = $_POST['volume_padrao'];
	$cod_grupo = $_POST['cod_grupo'];
	$cod_sub_grupo = $_POST['cod_sub_grupo'];
	$cod_identificacao = $_POST['cod_identificacao'];
	$local_preferencial = $_POST['local_preferencial'];
	$alerta_rep = $_POST['alerta_rep'];


	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql_kit = " insert into tb_kit (descricao, cod_cliente, ean, controle_lote, detalhe_kit, estoque_minimo, volume_padrao, cod_grupo, cod_sub_grupo, cod_identificacao, local_preferencial, alerta_rep, fl_status) values ('$descricao', '$cod_cliente', '$ean', '$controle_lote', '$detalhe_kit', '$estoque_minimo', '$volume_padrao', '$cod_grupo', '$cod_sub_grupo', '$cod_identificacao', '$local_preferencial', '$alerta_rep', 1) ";

	$resultado_id = mysqli_query($link, $sql_kit) or die( mysqli_error( $link ) );

	if(mysqli_affected_rows($link) > 0){ ?>

	<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Cadastro realizado com sucesso!</h4>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
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
					<h4 class="modal-title" id="myModalLabel">Erro no cadastro!</h4>
				</div>
				<div class="modal-body">                                

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
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
    
$link->close();
?>

</div>

</body>
</html>