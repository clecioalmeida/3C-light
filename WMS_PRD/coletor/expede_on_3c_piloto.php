<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$pedido ="select distinct t1.nr_pedido, t2.cod_almox, t3.ds_almox 
from tb_pedido_coleta_produto t1
left join tb_pedido_coleta t2 on t1.nr_pedido = t2.nr_pedido
left join tb_almox t3 on t2.cod_almox = t3.cod_almox
where t1.fl_conferido = 'C' and t2.fl_empresa = '$cod_cli'";
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
					<header>
						<h4 style="text-align: center">EXPEDIÇÃO POR ONDA</h4>
						<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
					</header>
					<div role="content">
						<div class="jarviswidget-editbox">
						</div>
						<div class="widget-body">
							<fieldset>
								<form method="post" action="expede_onda_3c_piloto.php">
									<div class="form-group">
										<label>Selecione o pedido</label>
										<select class="form-control" name="nr_pedido_on" id="nr_pedido_on">
											<?php 

											while ($dados_pedido=mysqli_fetch_assoc($res)) {?>

												<option value="<?php echo $dados_pedido['nr_pedido']."-".$dados_pedido['cod_almox']."-".$dados_pedido['ds_almox']; ?>"><?php echo $dados_pedido['nr_pedido']."-".$dados_pedido['cod_almox']."-".$dados_pedido['ds_almox']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-actions">
										<div>
											<button type="submit" class="btn btn-success btn-sm" id="" style="background-color: #2E8B57;text-shadow: none;color:white;border-color: #fdfbfb">SELECIONAR</button>
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