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
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

if (isset($_POST['nr_pedido'])) {

	$nr_pedido = $_POST['nr_pedido'];

} else {

	$nr_pedido = $_GET['cod_ped'];

}

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_inv = "select id, date_format(dt_inicio, '%d/%m/%Y') as dt_inicio, CASE ds_tipo WHEN 'I' THEN 'ABERTURA' WHEN 'R' THEN 'ROTATIVO' WHEN 'A' THEN 'ANUAL' END as ds_tipo
from tb_inv_prog
where fl_status = 'P' and fl_empresa = '$cod_cli'";
$res_inv = mysqli_query($link, $sql_inv);

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="inventario.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header>
						<h4>Selecione o inventário</h4>
						<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
					</header>
					<div role="content">
						<div class="jarviswidget-editbox">
						</div>
							<div class="widget-body">
								<fieldset>
									<form method="post" action="inv_cego.php">
										<div class="form-group">
											<select class="form-control" name="nr_inventario" id="cod_recebimento">
									            <?php 
									                       
									            while ($dados_pedido=mysqli_fetch_assoc($res_inv)) {?>
									                        
									            <option value="<?php echo $dados_pedido['id']; ?>"><?php echo $dados_pedido['dt_inicio']."-".$dados_pedido['ds_tipo']; ?></option>
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