<?php 
	require_once('bd_class_dsv.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$cod_cliente = $_REQUEST['cod_cliente'];
	
	$sql_parte = "SELECT nm_cliente FROM tb_cliente where cod_cliente = '$cod_cliente'";
	$res_parte = mysqli_query($link, $sql_parte);
	
	while ($parte=mysqli_fetch_assoc($res_parte)) {
		$nm_cliente=$parte['nm_cliente'];
	}

	$sql_cliente = "SELECT * FROM  tb_cliente WHERE fl_tipo = 'C'";
	$res_cliente = mysqli_query($link, $sql_cliente);
$link->close();
?>
<div class="modal fade" id="insInstrucao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #2F4F4F">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel" style="color:white">Cadastrar instrução de entrega</h4>
			</div>
			<div class="modal-body modal-lg">
				<form class="form-horizontal">
					<fieldset>
						<div class="form-group">
							<label class="col-md-2 control-label">Destinatário</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="nm_cliente" value="<?php echo $nm_cliente;?>">
								<input class="form-control" type="hidden" id="id_destinatario" value="<?php echo $cod_cliente;?>">
							</div>
						</div>						
						<div class="form-group">
							<label class="col-md-2 control-label">Cliente</label>
							<div class="col-md-4">
								<select class="form-control" id="id_cliente" name="id_cliente">
									<option>Selecione</option>
									<?php                                                           
					                while($dados=mysqli_fetch_assoc($res_cliente)) {?>
					                  <option value="<?php echo $dados['cod_cliente']; ?>">
					                    <?php echo $dados['nm_cliente']; ?>
					                  </option> 
					                <?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Instrução</label>
							<div class="col-md-10">
								<textarea class="form-control" rows="5" type="text" id="ds_instrucao" name="ds_instrucao" required="true"></textarea>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer modal-lg" style="background-color: #2F4F4F">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cancelar
				</button>
				<button type="button" class="btn btn-primary" id="btnSaveInstrucao">
					Salvar
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    $(document).ready(function () {
        $('#insInstrucao').modal('show');
    });
</script>