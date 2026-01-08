<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id=$_SESSION["id"];
	$cod_cli=$_SESSION["cod_cli"];
}
?>
<?php
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$pedido ="select 
distinct t1.nr_pedido, 
t1.cod_almox, 
t2.ds_nome as ds_almox 
from tb_pedido_coleta t1 
RIGHT join tb_funcionario t2 on t1.cod_almox = t2.nr_matricula 
where t1.fl_empresa = '$cod_cli' 
and (t1.fl_status = 'A' or t1.fl_status = 'M' or t1.fl_status = 'C') 
and ds_prd = 'S'";
$res = mysqli_query($link,$pedido);
$tr = mysqli_num_rows($res);

if($tr > 0){

	?>
	<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
		<div data-role="header" class="jqm-header" style="height: 50px">
			<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
			<a href="movimento.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
			<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
		</div>
		<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
						<header>
							<h4>Picking por unidade (piloto)</h4>
							<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
						</header>
						<div role="content">
							<div class="jarviswidget-editbox">
							</div>
							<div class="widget-body">
								<fieldset>
									<form method="post" action="sep_item_unid_serial.php">
										<div class="form-group">
											<label>Selecione o pedido</label>
											<select class="form-control" name="nr_pedido" id="cod_recebimento">
												<?php 

												while ($dados_pedido=mysqli_fetch_assoc($res)) {?>

													<option value="<?php echo $dados_pedido['nr_pedido']; ?>"><?php echo $dados_pedido['nr_pedido']." - ".$dados_pedido['cod_almox']." - ".$dados_pedido['ds_almox']; ?></option>
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
				<p>Growup Soluções para logística</p>
				<p>Copyright 2018 - Growup</p>
			</div>
		</div>
	</div>

	<?php

}else{

	?>
	<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
		<div data-role="header" class="jqm-header" style="height: 50px">
			<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
			<a href="movimento.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
			<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
		</div>
		<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
						<header>
							<h4>Não há dados para mostrar.</h4>
							<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
						</header>
					</div>
				</article>
			</div>
			<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
				<p>Growup Soluções para logística</p>
				<p>Copyright 2018 - Growup</p>
			</div>
		</div>
	</div>

	<?php

}

$link->close();
?>