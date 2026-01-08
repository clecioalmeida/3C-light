<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:../index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }
?>
<?php
 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();
	$link1 = $objDb->conecta_mysql();

	$nr_pedido = $_POST['start_col'];
	
	$sql = "CALL prc_coleta($nr_pedido, '$id')";
	$result_id = mysqli_query($link, $sql) or die(mysqli_error($link));	

	$upd_col = "update tb_pedido_coleta_produto set usr_init_col = '$id', dt_init_col= now() where nr_pedido = '$nr_pedido'";
	$result_upd = mysqli_query($link1, $upd_col) or die(mysqli_error($link));	

	if(mysqli_affected_rows($link) > 0)
	{?>
		<div class="modal fade" id="conf_sucesso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #2F4F4F;">
						<h4 class="modal-title" style="color: white">Coleta iniciada com Sucesso!</h4>
					</div>
					<div class="modal-body">
						
					</div>
					<div class="modal-footer" style="background-color: #2F4F4F;">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				      </div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function () {
				$('#conf_sucesso').modal('show');
			});
		</script>
	<?php } 
	else 
	{?>
		<div class="modal fade" id="conf_erro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					 <div class="modal-header" style="background-color: #A52A2A;">
						 <h4 class="modal-title" id="myModalLabel" style="color: white">Erro no cadastro!</h4>
					</div>
					<div class="modal-body">
						
					</div>
					 <div class="modal-footer" style="background-color: #A52A2A;">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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
?>