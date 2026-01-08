<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$nr_pedido = $_REQUEST['nr_pedido'];
	
	$sql_parte = "select t1.cod_cliente, t1.nm_cliente
	from tb_cliente t1
	left join tb_pedido_coleta t2 on t1.cod_cliente = t2.id_remetente
	where t2.nr_pedido = '$nr_pedido'";
	$res_parte = mysqli_query($link, $sql_parte);
	
	while ($parte=mysqli_fetch_assoc($res_parte)) {
		$nm_cliente=$parte['nm_cliente'];
		$cod_cliente=$parte['cod_cliente'];
	}

	$sql_destino = "select t1.cod_cliente, t1.nm_cliente
	from tb_cliente t1
	left join tb_pedido_coleta t2 on t1.cod_cliente = t2.cod_cliente
	where t2.nr_pedido = '$nr_pedido'";
	$res_destino = mysqli_query($link, $sql_destino);
	
	while ($destino=mysqli_fetch_assoc($res_destino)) {
		$nm_destino=$destino['nm_cliente'];
		$cod_destino=$destino['cod_cliente'];
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
								<input class="form-control" type="text" id="nm_cliente" value="<?php echo $nm_destino;?>">
								<input class="form-control" type="hidden" id="id_destinatario" value="<?php echo $cod_destino;?>
								">
								<input class="form-control" type="hidden" id="nr_pedido" value="<?php echo $nr_pedido;?>
								">
							</div>
						</div>						
						<div class="form-group">
							<label class="col-md-2 control-label">Cliente</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="nm_destino" value="<?php echo $nm_cliente;?>">
								<input class="form-control" type="hidden" id="id_cliente" value="<?php echo $cod_cliente;?>">
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
				<button type="button" class="btn btn-primary" id="btnSaveInst">
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