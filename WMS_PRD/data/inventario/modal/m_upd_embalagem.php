<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_tar = $_REQUEST['id_tar'];
	
	$sql_parte = "SELECT id, id_produto, id_galpao, id_rua, id_coluna, id_altura, ds_embalagem FROM tb_inv_tarefa where id = '$id_tar'";
	$res_parte = mysqli_query($link, $sql_parte);
	while ($dados=mysqli_fetch_assoc($res_parte)) {
		$produto = $dados['id_produto'];
		$galpao = $dados['id_galpao'];
		$rua = $dados['id_rua'];
		$coluna = $dados['id_coluna'];
		$altura = $dados['id_altura'];
		$embalagem = $dados['ds_embalagem'];
	}
$link->close();
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #8B1A1A">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel" style="color:white">Alterar tarefa</h4>
			</div>
			<div class="modal-body modal-lg">
				<form class="form-horizontal">
					<fieldset>
						<p>Produto: <?php echo $produto;?></p>
						<p>Galpão: <?php echo $galpao;?></p>
						<p>Rua: <?php echo $rua;?></p>
						<p>Coluna: <?php echo $coluna;?></p>
						<p>Altura: <?php echo $altura;?></p>
						<p>Embalagem: <?php echo $embalagem;?></p>
					</fieldset>
					<hr>
					<fieldset>
						<div class="form-group">
							<label class="col-md-2 control-label">Nova embalagem</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="ds_embalagem" name="ds_embalagem" required="true">
								<input type="hidden" name="id_tarefa" id="id_tarefa" value="<?php echo $id_tar;?>">
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer modal-lg" style="background-color: #8B1A1A">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cancelar
				</button>
				<button type="button" class="btn btn-primary" id="btnSaveUpdEmbalagem">
					Salvar
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    $(document).ready(function () {
        $('#myModal').modal('show');
    });
</script>