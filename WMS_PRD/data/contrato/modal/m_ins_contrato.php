<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$select_cliente = "select * from tb_cliente where fl_tipo = 'C'";
$res_cliente = mysqli_query($link,$select_cliente);

?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #8B1A1A">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel" style="color:white">Cadastrar novo contrato</h4>
			</div>
			<div class="modal-body modal-lg">
				<form class="form-horizontal">
					<fieldset>
						<div class="form-group">
							<label class="col-md-2 control-label">Empresa</label>
							<div class="col-md-10">								
		                        <select class="form-control" id="id_cliente" name="id_cliente" required="true">
		                            <option>Cliente</option>
		                               <?php
		                                while ($dados=mysqli_fetch_assoc($res_cliente)) {?>

		                                <option value="<?php echo $dados['cod_cliente']; ?>"><?php echo $dados['nm_cliente']; ?></option>

		                            <?php } ?>
		                        </select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Descrição</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="ds_descricao" name="ds_descricao" required="true">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Aprovação</label>
							<div class="col-md-4">
								<input class="form-control" type="date" id="dt_aprova" name="dt_aprova" required="true">
							</div>
							<label class="col-md-2 control-label">Manuseio</label>
							<div class="col-md-4">
								<div class="inline-group">
									<label class="checkbox">
									<input type="checkbox" name="checkbox-inline" id="ds_manuseio" value="S"><i></i>Sim</label>
									<label class="checkbox">
									<input type="checkbox" name="checkbox-inline" id="ds_manuseio" value="N" checked="checked"><i></i>Não</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Valor por movimentação</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="vlr_mov" name="vlr_mov">
							</div>
							<label class="col-md-2 control-label">Franquia</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="nr_franquia_mov" name="nr_franquia_mov">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Vencimento(dia)</label>
							<div class="col-md-2">
								<input class="form-control" type="text" id="dt_vencto" name="dt_vencto" required="true">
							</div>
						</div>	
					</fieldset>
				</form>
			</div>
			<div class="modal-footer modal-lg" style="background-color: #8B1A1A">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cancelar
				</button>
				<button type="button" class="btn btn-primary" id="btnSaveContrato">
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