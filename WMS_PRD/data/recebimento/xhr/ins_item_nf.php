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
<?php
	require_once('bd_class.php');
	

	$cod_nf_entrada = $_POST['cod_nf'];
	$estado_produto = $_POST['idEstado'];
	$produto = $_POST['cod_produto'];
	$nr_qtde = $_POST['nr_qtde'];
	$vl_unit = $_POST['vl_unit'];
	$cod_produto = $_POST['cod_produto'];
 
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = " insert into tb_nf_entrada_item (cod_nf_entrada, estado_produto, produto, nr_qtde, vl_unit) values ('$cod_nf_entrada', '$estado_produto', '$produto', '$nr_qtde', '$vl_unit') ";

	$resultado_id = mysqli_query($link, $sql);

	if(mysqli_affected_rows($link) > 0){ ?>
		<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Registro incluído com sucesso!</h4>
					</div>
					<div class="modal-body">

					</div>
					<div class="modal-footer">
						<a href="../../../../../html/includes/forms/recebimento/item_or.php?cod_rec=<?php echo $cod_rec; ?>&cod_nf=<?php echo $dados['cod_nf_entrada']; ?>"><button type="button" class="btn btn-success">Ok</button></a>
					</div>
				</div>
			</div>
		</div>
			<script>
				$(document).ready(function () {
					$('#conf_cadastro').modal('show');
				});
			</script>
			<?php } else { ?>
			<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Erro na exclusão!</h4>
						</div>
						<div class="modal-body">                                

						</div>
						<div class="modal-footer">
							<a href="../../../../../html/recebimento.php"><button type="button" class="btn btn-danger">Ok</button></a>
						</div>
					</div>
				</div>
			</div>          
			<script>
				$(document).ready(function () {
					$('#conf_cadastro').modal('show');
				});
			</script>
			<?php  }
  
	$link->close();	
	
?>
</div>
	</body>
	</html>
