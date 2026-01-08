<?php
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

if(isset($_POST['nr_pedido_on'])){

	$dados_ped = $_POST['nr_pedido_on'];
	$pieces = explode("-", $dados_ped);
	$nr_pedido = trim($pieces[0]);

}else if(isset($_GET['dados_ped'])){

	$dados_ped = $_GET['dados_ped'];
	$pieces = explode("-", $dados_ped);
	$nr_pedido = trim($pieces[0]);

}

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_rec = "select sum(t1.nr_qtde_conf) as total
from tb_pedido_coleta_produto t1 
where t1.nr_pedido = '$nr_pedido'";
$res_rec = mysqli_query($link,$sql_rec);
while ($dados_rec=mysqli_fetch_assoc($res_rec)) {
	$nr_qtde = $dados_rec['total'];
}

$query_conf="select count(nr_qtde) as total from tb_pedido_conferencia where nr_pedido = '$nr_pedido'";
$res_conf=mysqli_query($link, $query_conf);
$tr_conf = mysqli_num_rows($res_conf);

while ($totalconf=mysqli_fetch_assoc($res_conf)) {
	$conf_item=$totalconf['total'];
}

$conf = $nr_qtde - $conf_item;

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="expede_on_3c.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header style="text-align: center">
						<h4>EXPEDIÇÃO POR ONDA</h4>
					</header>
					<div role="content">
						<div class="jarviswidget-editbox">
						</div>
						<div class="widget-body">
							<form id="formPedido">
								<fieldset>
									<div class="form-group">
										<label>PICKING: <?php echo $dados_ped; ?></label>
										<!--div>Total pedido 
											<?php
											echo number_format($nr_qtde,0,",","");
											?>
										</div>
										<div>Total de itens a conferir 
											<?php
											if($nr_qtde > 0){
												echo number_format($conf,0,",","");
											} else {
												echo '0';
											}
											?>

										</div>
										<div>Total de itens conferidos: 
											<?php
											echo number_format($conf_item,0,",","");
											?>
										</div-->
										<div id="retFinConfExpOn3c"></div>
									</div>
								</fieldset>
								<div class="form-actions">
									<a href="conf_exp_onda_3c.php?nr_pedido=<?php echo $nr_pedido;?>&nr_qtde=<?php echo $nr_qtde;?>&nr_conf=<?php echo $conf_item;?>&dados_ped=<?php echo $dados_ped;?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
										<button type="button" class="btn btn-primary btn-sm" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb">INICIAR</button>
									</a>
									<a href="list_prd_pedido_3c.php?dados_ped=<?php echo $dados_ped;?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
										<button type="button" class="btn btn-primary btn-sm" style="background-color: #2E8B57;text-shadow: none;color:white;border-color: #fdfbfb">PRODUTOS</button>
									</a>
									<button class="btn btn-success btn-sm" id="btnFinConfExpCegoOn3c" value="<?php echo $nr_pedido; ?>" style="background-color: #A52A2A;text-shadow: none;color:white;border-color: #fdfbfb">FINALIZAR</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>
</div>