<?php
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = $_GET['cod_rec'];

$sql_rec = "select count(id) as total
from tb_etiqueta
where cod_rec = '$cod_rec' and fl_status = 'A'";
$res_rec = mysqli_query($link,$sql_rec);
while ($dados_rec=mysqli_fetch_assoc($res_rec)) {
	$nr_qtde 		= $dados_rec['total'];
}

$conf = $nr_qtde;
$link->close();

?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>ALOCAÇÃO</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white;padding-top: 1em">
		
		<div class="row">
			<div>
				<h4 id="">OR:<?php echo $cod_rec;?></h4>
			</div>
			<div>
				<h4 id="">Quantidade para alocar:<?php echo $nr_qtde;?></h4>
			</div>

			<legend>Selecione o endereço</legend>
			<form id="form_conf_aloc" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="id_end" name="id_end" class="form-control" required="true" style="text-align: right;">
					</div>
					<div class="form-group">
						<h4 id="retEnd"></h4>
					</div>
				</div>
			</form>
		</div>
		<div class="aloca" id="aloca" style="display: none">
			<legend>Selecione o produto</legend>
			<div class="row" id="confProdPick">
				<div>
					<h4 id="">Total:<?php echo $nr_qtde;?></h4>
				</div>

				<div class="conferido" id="conferido">
					<h4 id="TotalConferido">Conferido:</h4>
				</div>
				<form id="form_conf_prd_aloca" method="post" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input tabindex="1" type="text" id="barcodeAloc" name="barcodeAloc" class="form-control" required="true" style="text-align: right;"  
							onfocus="this.selectionStart = this.selectionEnd = this.value.length;"  
							autofocus="true"/>
							<input type="hidden" id="cod_rec" name="cod_rec" value="<?php echo $cod_rec;?>" style="text-align: right;">
							<input type="hidden" id="nr_qtde" name="nr_qtde" value="<?php echo $nr_qtde;?>" style="text-align: right;">
							<input type="hidden" id="id_endereco" name="id_endereco" value="" style="text-align: right;">
						</div>
						<div class="form-group">
						</div>
					</div>
				</form>
			</div>
		</div>
		<a href="aloc_item.php?cod_rec=<?php echo $cod_rec;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		document.getElementById("id_end").focus();
	});
</script>