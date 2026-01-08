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
require_once('data/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

// $recebimento = "SELECT t1.id, t1.cod_estoque, t1.nr_alocado, t2.produto, t2.nr_volume 
// from tb_aloca t1 
// left join tb_posicao_pallet t2 on t1.cod_estoque = t2.cod_estoque
// where t1.fl_status = 'L' and t2.nr_qtde > 0 and t2.fl_empresa = '$cod_cli'";
// $res = mysqli_query($link, $recebimento);
// $tr = mysqli_num_rows($res);

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="home.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header role="heading">
						<div class="jarviswidget-ctrls" role="menu"> <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>

						<h4>Transferir de:</h4>

						<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
					</header>

					<div role="content">

						<div class="jarviswidget-editbox">

						</div>

						<div class="widget-body">
							<fieldset>
								<form id="form_conf_prod" method="" action="">
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" id="end_org" name="end_org" class="form-control" placeholder="Endereço de origem" style="text-align: right;">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" id="lp_org" name="lp_org" class="form-control" placeholder="LP" style="text-align: right;">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" id="prd_org" name="prd_org" class="form-control" placeholder="Produto" style="text-align: right;">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" id="qtd_org" name="qtd_org" class="form-control" placeholder="Quantidade" style="text-align: right;">
										</div>
									</div>
									<div class="col-md-12">

										<h4>Transferir para:</h4>

									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" id="end_dst" name="end_dst" class="form-control" placeholder="Endereço de destino" style="text-align: right;">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" id="lp_dst" name="lp_dst" class="form-control" placeholder="LP" style="text-align: right;">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" id="prd_dst" name="prd_dst" class="form-control" placeholder="Produto" style="text-align: right;">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" id="qtd_dst" name="qtd_dst" class="form-control" placeholder="Quantidade" style="text-align: right;">
										</div>
									</div>
									<div class="col-md-12">
										<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnSaveTransf" value="<?php echo $nr_pedido; ?>" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb;float: right">FINALIZAR</button>
									</div>
								</form>
							</fieldset>
							<fieldset>
								<div class="col-md-12">
									<div id="retTransfInfo" style="text-align: center"></div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			</article>
		</div>
		<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer"></div>
	</div>
</div>