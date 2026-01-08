<?php
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

if(isset($_POST['cod_rec'])){

	$cod_rec = $_POST['cod_rec'];

}else if(isset($_GET['cod_rec'])){

	$cod_rec = $_GET['cod_rec'];
}else{

	$cod_rec = "0";

}

if($cod_rec != "0"){

	$sql_rec = "select count(id) as total
	from tb_etiqueta
	where cod_rec = '$cod_rec' and fl_status = 'A'";
	$res_rec = mysqli_query($link,$sql_rec);
	$dados_rec=mysqli_fetch_assoc($res_rec);
	$nr_qtde 	= $dados_rec['total'];

	?>
	<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
		<div data-role="header" class="jqm-header" style="height: 50px">
			<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
			<a href="alocacao.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
			<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
		</div>
		<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
						<header>
							<h4>Alocação de produtos</h4>
						</header>
						<div role="content">
							<div class="jarviswidget-editbox">
							</div>
							<div class="widget-body">
								<form id="formPedido">
									<fieldset>
										<div class="form-group">
											<label>Alocação: <?php echo $cod_rec; ?></label>
											<div>Total de itens a alocar 
												<?php echo $nr_qtde;?>
											</div>
											<h3 id="retFinConfAloc"></h3>
										</div>
									</fieldset>
									<div class="form-actions">
										<a href="conf_aloc.php?cod_rec=<?php echo $cod_rec;?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
											<button type="button" id="iniAloc" class="btn btn-primary btn-sm">Iniciar</button>
										</a>
										<button class="btn btn-success btn-sm" id="btnFinAloca" value="<?php echo $cod_rec; ?>">Finalizar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>

	<?php

}else{

	?>
	<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
		<div data-role="header" class="jqm-header" style="height: 50px">
			<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
			<a href="alocacao.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
			<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
		</div>
		<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
						<header>
							<h4>Não há dados para mostrar</h4>
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