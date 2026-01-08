<?php ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../tmp')); session_start();?>
<?php 
  $login  = $_SESSION["usuario"];
	$cod_rec = $_GET['cod_rec'];
?>
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
				
				//$cod_recebimento = $_POST['cod_recebimento'];

				$objDb = new db();
				$link = $objDb->conecta_mysql();
				$sql = "CALL prc_recebimento('$login', $cod_rec)";
				//echo $sql;
				$result_id = mysqli_query($link, $sql) or die(mysqli_error($link));
				$cod_rec = 0;
			 
				if(mysqli_affected_rows($link) > 0)
				{ ?>

					<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">OR finalizada com sucesso!</h4>
								</div>
								<div class="modal-body">
									<?php echo "Produto: $nm_produto, Nota fiscal: $nr_nf_entrada, Quantidade: $nr_qtde_nf, Lote: $nr_lote"; ?>
								</div>
								<div class="modal-footer">
									<a href="../../../../../html/recebimento.php"><button type="button" class="btn btn-success">Ok</button></a>
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
				else
				{ ?>    
					<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Existe(m) NF(s) Sem Produto(s) Recebido(s)!</h4>
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
				<?php } 

					
				$link->close();
			?>
		</div>
	</body>
</html>