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
require_once('data/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$recebimento ="select cod_recebimento from tb_recebimento where fl_status = 'L' and fl_empresa = '$cod_cli'";
$res = mysqli_query($link,$recebimento);
$tr = mysqli_num_rows($res);   

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="recebimento.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>

						<h4>Recebimento por OR</h4>

						<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
					</header>

					<div role="content">

						<div class="jarviswidget-editbox">

						</div>

						<div class="widget-body">
							<fieldset>
								<form method="post" action="rec_item_or.php">
									<div class="form-group">
										<label>Selecione a OR</label>
										<select class="form-control" name="cod_recebimento" id="cod_recebimento">
											<?php 
											while ($dados_or=mysqli_fetch_assoc($res)) {?>

												<option value="<?php echo $dados_or['cod_recebimento']; ?>"><?php echo $dados_or['cod_recebimento']; ?></option>
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