<?php
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$pedido ="SELECT distinct t2.nr_pedido, t2.ds_destino 
from tb_coleta_pedido t1 
left join tb_pedido_coleta t2 on t1.nr_pedido = t2.nr_pedido
where t1.fl_status = 'M'";
$res = mysqli_query($link,$pedido);
$tr = mysqli_num_rows($res); 

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="expede.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<h4>Expedição - conversão de unidades</h4>
					<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
				</header>
				<div role="content">
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body">
						<fieldset>
							<form method="post" action="expede_pedido_con.php">
								<div class="form-group">
									<label>Selecione o pedido</label>
									<select class="form-control" name="nr_pedido" id="cod_recebimento">
										<?php 
										while ($dados_pedido=mysqli_fetch_assoc($res)) {?>
											<option value="<?php echo $dados_pedido['nr_pedido']; ?>"><?php echo $dados_pedido['nr_pedido']."-".$dados_pedido['ds_destino']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-actions">
									<div>
										<button type="submit" class="btn btn-primary">Selecionar</button>
									</div>
								</div>
							</form>
						</fieldset>
					</div>
				</div>
			</div>
		</article>
	</div>
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
		
	</div>
</div>