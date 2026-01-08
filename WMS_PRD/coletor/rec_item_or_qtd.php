<?php
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

if(isset($_POST['cod_recebimento'])){
	$cod_recebimento = $_POST['cod_recebimento'];
}else if(isset($_GET['cod_recebimento'])){
	$cod_recebimento = $_GET['cod_recebimento'];
}

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_rec = "select t1.cod_recebimento, t2.cod_nf_entrada, sum(t3.nr_volume) as total, t3.cod_nf_entrada_item, t3.produto
from tb_recebimento t1 left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
where t1.cod_recebimento = '$cod_recebimento'";
$res_rec = mysqli_query($link, $sql_rec);
while ($dados_rec = mysqli_fetch_assoc($res_rec)) {
	$nr_qtde = $dados_rec['total'];
	$cod_nf = $dados_rec['cod_nf_entrada'];
	$cod_nf_item = $dados_rec['cod_nf_entrada_item'];
	$cod_produto = $dados_rec['produto'];
}

$query_conf = "select count(cod_nf_entrada_item) as total from tb_nf_entrada_conf where cod_nf_entrada_item = '$cod_nf'";
$res_conf = mysqli_query($link, $query_conf);
$tr_conf = mysqli_num_rows($res_conf);

while ($totalconf = mysqli_fetch_assoc($res_conf)) {
	$conf = $totalconf['total'];
}

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="recebimento_or_qtde.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header>
						<h4>Recebimento por OR</h4>
						<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
					</header>
					<div role="content">
						<div class="jarviswidget-editbox"></div>
						<div class="widget-body">
							<form id="formPedido">
								<fieldset>
									<div class="form-group">
										<label>Ordem de recebimento <?php echo $cod_recebimento; ?></label>
										<div>Total de itens a conferir <?php
										if ($nr_qtde > 0) {
											echo number_format($nr_qtde, 0, ",", "");
										} else {
											echo '0';
										}
										?></div>
										<h2 id="retFinConfRec"></h2>
									</div>
								</fieldset>
								<div class="form-actions">
									<a href="conf_rec_qtd.php?cod_recebimento=<?php echo $cod_recebimento;?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
										<button type="button" class="btn btn-primary btn-sm">Iniciar</button>
									</a>
									<button class="btn btn-success btn-sm" id="btnFinConfRec">Finalizar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>
</div>
<div class="page-footer">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<span class="txt-color-white">Growup <span class="hidden-xs"> - WMS Gisis</span> © 2016-2017</span>
		</div>
	</div>
</div>