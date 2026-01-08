<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
    </head>
    <body>
    <div class="container theme-showcase" role="main">
<?php		
    $cod_estoque = $_POST['cod_estoque'];
    $nr_qtde = $_POST['nr_qtde'];
	$nr_qtde_old = $_POST['nr_qtde_old'];
	$ds_galpao = $_POST['ds_galpao'];
	$ds_rua = $_POST['ds_rua'];
	$ds_coluna = $_POST['ds_coluna'];
	$ds_altura = $_POST['ds_altura'];
	$id_aval = $_POST['id_aval'];
	$ds_projeto = $_POST['ds_projeto'];

		
			if($nr_qtde < 1 || $ds_galpao == '' || $ds_rua == '' || $ds_coluna == '' || $ds_altura == ''){ ?>

				<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">Por favor preencha todas as informações!</h4>
				      </div>
				      <div class="modal-body">
				      	<?php
				      	if($nr_qtde < 1){
				      		echo 'Digite a quantidade a alocar!';
				      	}elseif ($ds_galpao == ''){
				      		echo 'Selecione o galpão!';
				      	}elseif( $ds_rua == '' && $ds_coluna == '' && $ds_altura == ''){
				      		echo 'Selecione a rua!';
				      	}elseif ($ds_coluna == '' && $ds_altura == ''){
				      		echo 'Selecione a coluna!';
				      	}else{
				      		echo 'Selecione a altura!';
				      	}
				      	?>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
					<script>
						$('#myModal').modal('show');
					</script>
			<?php }else{
				
						require_once("bd_class.php");
						$objDb = new db();
						$link = $objDb->conecta_mysql();
						$sql = "CALL prc_alocacao('$ds_galpao', '$cod_estoque', '$ds_rua', '$ds_altura', '$ds_coluna', '$nr_qtde_old', '$nr_qtde', '$id', '$id_aval', '$ds_projeto')";
						$result_id = mysqli_query($link, $sql) or die(mysqli_error($link));	

						$upd_pp="update tb_posicao_pallet set nr_or = 0 where nr_posicao_temp = '$cod_estoque'";
						$res_pp = mysqli_query($link, $upd_pp) or die(mysqli_error($link));	
						if(mysqli_affected_rows($link) > 0){?>
							<div class="modal fade" id="conf_sucesso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myModalLabel">Alocação Realizada com Sucesso!</h4>
										</div>
										<div class="modal-body">
											
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
										</div>
									</div>
								</div>
							</div>
							<script>
								$(document).ready(function () {
									$('#conf_sucesso').modal('show');
								});
							</script>
						<?php } else {?>
							<div class="modal fade" id="conf_erro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myModalLabel">Erro no cadastro!</h4>
										</div>
										<div class="modal-body">
											
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
										</div>
									</div>
								</div>
							</div>
							<script>
								$(document).ready(function () {
									$('#conf_erro').modal('show');
								});
							</script>
							<?php } 
						}
$link->close();
			?>
		</div>
		<script type="text/javascript">
			
		</script>
	</body>
</html>