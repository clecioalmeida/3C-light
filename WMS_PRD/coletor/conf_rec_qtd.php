<?php
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_recebimento = $_GET['cod_recebimento'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_rec = "select t1.cod_recebimento, t2.cod_nf_entrada, sum(t3.nr_volume) as total, t3.cod_nf_entrada_item, t3.produto 
from tb_recebimento t1 left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec 
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada 
where t1.cod_recebimento = '$cod_recebimento'";
$res_rec = mysqli_query($link,$sql_rec);
while ($dados_rec=mysqli_fetch_assoc($res_rec)) {
	$nr_qtde = $dados_rec['total'];
	$cod_nf = $dados_rec['cod_nf_entrada'];
	$cod_nf_item = $dados_rec['cod_nf_entrada_item'];
	$cod_produto = $dados_rec['produto'];
}

$query_conf="select count(cod_nf_entrada_item) as total from tb_nf_entrada_conf where cod_nf_entrada_item = '$cod_nf'";
$res_conf=mysqli_query($link, $query_conf);
$tr_conf = mysqli_num_rows($res_conf);

while ($totalconf=mysqli_fetch_assoc($res_conf)) {
	$conf=$totalconf['total'];
}

?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>RECEBIMENTO</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white">
		<h2>Iniciar conferência</h2>
		<div class="row">
			<div>
				<h4 id="">Total:<?php echo number_format($nr_qtde,0,",","");?></h4>
			</div>
			<div class="conferido" id="conferido">
				<h4 id="TotalConferido">Conferido:<?php echo number_format($conf,0,",","");?></h4>
			</div>
		</div>
		<div class="row">
			<form id="form_conf_qtd" method="POST" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="hidden" name="cod_nf_item" id="cod_nf_item" value="<?php echo $cod_nf_item; ?>">
						<input type="hidden" name="cod_nf" id="cod_nf" value="<?php echo $cod_nf; ?>">
						<input type="hidden" name="cod_rec" id="cod_rec" value="<?php echo $cod_recebimento; ?>">
						<input type="hidden" name="nr_qtde" id="nr_qtde" value="<?php echo $nr_qtde; ?>">
						<input type="text" id="barcodeQtde" name="barcodeQtde" class="form-control" required="" style="text-align: right;"  autofocus="true"/>
						<h3 id="retConfRecQtde"></h3>
					</div>
					<div class="col-md-6">
						<input type="text" id="ins_qtde_conf" name="qtde_conf" class="form-control" required="" placeholder="Quantidade" style="text-align: right;">
					</div>
					<div class="form-group">
					</div>
				</div>
			</form>
		</div>
		<a href="rec_item_or_qtd.php?cod_recebimento=<?php echo $cod_recebimento;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
	</div>
</div>