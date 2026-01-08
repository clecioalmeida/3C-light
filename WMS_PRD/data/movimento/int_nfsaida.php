<?php
		require_once('bd_class.php');

		$nr_nf = $_POST['nr_nf'];

		$objDb = new db();
		$link = $objDb->conecta_mysql();

		$sql_exclui = "delete from tb_nf_saida where nr_nf = '$nr_nf'";
		$res_exclui = mysqli_query($link, $sql_exclui);
$link->close();
		if(mysqli_affected_rows($link) > 0){ ?>
		<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Nota fiscal de saída excluída com sucesso!</h4>
					</div>
					<div class="modal-body">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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
							<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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