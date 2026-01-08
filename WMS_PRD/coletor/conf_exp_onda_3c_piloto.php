<?php
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido 	= $_GET['nr_pedido'];
$nr_qtde 	= $_GET['nr_qtde'];
$nr_conf 	= $_GET['nr_conf'];
$dados_ped 	= $_GET['dados_ped'];

/*$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_rec = "select t1.nr_pedido, t2.cod_nf_entrada, sum(t3.nr_volume) as total, t3.cod_nf_entrada_item, t3.produto 
from tb_recebimento t1 
left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec 
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
}*/

$link->close();

?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>EXPEDIÇÃO</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white">
		<h2>PICKING: <?php echo $dados_ped;?></h2>
		<!--div class="row">
			<div>
				<h4 id="">Total:<?php echo number_format($nr_qtde,0,",","");?></h4>
			</div>
			<div class="conferido" id="conferido">
				<h4 id="TotalConferido">Conferido:<?php echo number_format($nr_conf,0,",","");?></h4>
			</div>
		</div-->
		<div class="row">
			<form id="form_conf_exp_on_3c" method="POST" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="hidden" name="nr_pedido" id="nr_pedido" value="<?php echo $nr_pedido; ?>">
						<input type="hidden" name="nr_qtde" id="nr_qtde" value="<?php echo $nr_qtde; ?>">
						<label>PRODUTO</label>
						<input tabindex="1" type="text" id="barcode_exp_3c" name="barcode_exp_3c" class="form-control" required="" style="text-align: right;" 
						onfocus="this.selectionStart = this.selectionEnd = this.value.length;"  
						autofocus="true"/>
						<label>QUANTIDADE</label>
						<input tabindex="2" type="text" name="nr_qtde_conf" id="nr_qtde_conf" style="text-align: right;">
					</div>
					<div class="form-group" id="retConfExpOn">
					</div>
				</div>
			</form>
		</div>
		<button type="text" id="btnSaveConfExpOnda3cPl" class="btn btn-success btn-sm" style="background-color: #556B2F;text-shadow: none;color:white;border-color: #fdfbfb">
			<span class="glyphicon glyphicon-floppy-disk"></span> Salvar
		</button>
		<a href="expede_onda_3c_piloto.php?dados_ped=<?php echo $dados_ped;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a" style="background-color: #A52A2A;text-shadow: none;color:white;border-color: #fdfbfb">Fechar</a>
		<button type="text" id="btnCleanConfExpOnda" class="btn btn-primary btn-sm" style="background-color: #778899;text-shadow: none;color:white;border-color: #fdfbfb">
			<span class="glyphicon glyphicon-floppy-disk"></span> Nova conferência
		</button>
	</div>
</div>
</script>	
<!--script type="text/javascript">
	$(document).ready(function(){
		
		document.getElementById("barcode").focus();

	});
</script-->