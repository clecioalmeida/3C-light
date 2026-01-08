<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$select_cliente = "select * from tb_cliente where fl_tipo = 'C'";
$res_cliente = mysqli_query($link,$select_cliente);

$link->close();
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #8B1A1A">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel" style="color:white">Cadastrar nova embalagem</h4>
			</div>
			<div class="modal-body modal-lg">
				<form class="form-horizontal">
					<fieldset>
						<div class="form-group">
							<label class="col-md-1 control-label">Empresa</label>
							<div class="col-md-5">								
		                        <select class="form-control" id="id_cliente_emb" name="id_cliente_emb" required="true">
		                            <option>Cliente</option>
		                               <?php
		                                while ($dados=mysqli_fetch_assoc($res_cliente)) {?>

		                                <option value="<?php echo $dados['cod_cliente']; ?>"><?php echo $dados['nm_cliente']; ?></option>

		                            <?php } ?>
		                        </select>
							</div>
							<label class="col-md-1 control-label">Contrato</label>
							<div class="col-md-5">								
		                        <select class="form-control" id="id_contrato_emb" name="id_contrato_emb" required="true">
		                            <option>Contrato</option>
		                        </select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-1 control-label">Descrição</label>
							<div class="col-md-11">
								<input class="form-control" type="text" id="ds_descricao" name="ds_descricao" required="true">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-1 control-label">Cubado</label>
							<div class="col-md-3">
								<input class="form-control" type="text" id="nr_cubado" name="nr_cubado">
							</div>
							<label class="col-md-1 control-label">Peso</label>
							<div class="col-md-3">
								<input class="form-control" type="text" id="nr_peso" name="nr_peso">
							</div>
							<label class="col-md-1 control-label">Compr.</label>
							<div class="col-md-3">
								<input class="form-control" type="text" id="nr_comprimento" name="nr_comprimento">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-1 control-label">Largura</label>
							<div class="col-md-3">
								<input class="form-control" type="text" id="nr_largura" name="nr_largura">
							</div>
							<label class="col-md-1 control-label">Altura</label>
							<div class="col-md-3">
								<input class="form-control" type="text" id="nr_altura" name="nr_altura">
							</div>
						</div>	
					</fieldset>
				</form>
			</div>
			<div class="modal-footer modal-lg" style="background-color: #8B1A1A">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cancelar
				</button>
				<button type="button" class="btn btn-primary" id="btnSaveEmbalagem">
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