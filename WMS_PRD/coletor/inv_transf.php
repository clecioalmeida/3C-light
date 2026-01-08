<?php
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

if (isset($_POST['nr_inventario'])) {

	$nr_inventario = $_POST['nr_inventario'];
} else {

	$nr_inventario = $_GET['nrInvConf'];
}

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_total = "select id_galpao
from tb_inv_prog
where id = '$nr_inventario'";
$res_total = mysqli_query($link, $sql_total);
$dados = mysqli_fetch_assoc($res_total);
$id_galpao = $dados['id_galpao'];

$query_conf = "SELECT id, nome from tb_armazem where fl_situacao = 'A'";
$res_conf = mysqli_query($link, $query_conf);

$link->close();
?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>INVENTÁRIO POR UNIDADE</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white;padding-top: 1em">

		<div class="row">

			<legend>Selecione o endereço</legend>
			<!--select class="form-control" name="ds_galpao_inv" id="ds_galpao_inv">
				<? php // while ($dados = mysqli_fetch_assoc($res_conf)) { 
				?>
					<option value="<?php //echo $dados['id']; 
									?>"><?php //echo $dados['nome']; 
																	?></option>
				<?php //} 
				?>
			</select-->
			<form id="form_conf_inv" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="localInv" name="localInv" placeholder="Bipe o endereço" class="form-control" required="true" autofocus="true" />
						<input type="hidden" id="nrInvConf" name="nrInvConf" class="form-control" value="<?php echo $nr_inventario; ?>">
						<input type="hidden" id="cod_estoque" name="cod_estoque" class="form-control" value="">
					</div>
					<div class="form-group">
						<h4 id="retInvTransf"></h4>
					</div>
				</div>
			</form>
		</div>
		<h2 id="retConEnd"></h2>
		<h2 id="retExpEnd"></h2>
		<div class="inventario">
			<legend>LP</legend>
			<input type="text" placeholder="Número do LP" id="nr_lp_inv" name="nr_lp_inv" class="form-control">
			<form id="" method="" action="">
				<div class="row" id="confProdInv">
					<div class="conferido" id="conferido">
						<h4 id="TotalInventariado">Produto:</h4>
					</div>
					<form id="form_conf_prod" method="" action="">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" id="barcodeInvTransf" name="barcodeInvTransf" class="form-control" />
							</div>
						</div>
					</form>
				</div>
			</form>
		</div>
		<div class="qtdeInvTransf">
			<div class="row" id="insQtdeInv">
				<form id="formConfInv" method="" action="">
					<div class="col-md-12">
						<div class="ui-field-contain">
							<legend>Qtde de volumes</legend>
							<input type="text" id="nr_vol_inv" name="nr_vol_inv" class="form-control" required="true">
							<legend>Qtde de itens</legend>
							<input type="text" id="nr_qtde_inv" name="nr_qtde_inv" class="form-control" required="true">
							<input type="hidden" id="id_galpao" name="id_galpao" value="<?php echo $id_galpao; ?>" class="form-control">
						</div>
						<div class="form-group"><br>
							<legend>KVA</legend>
							<input type="text" placeholder="Número do KVA" id="nr_kva_inv" name="nr_kva_inv" class="form-control" required="true">
							<legend>SERIAL</legend>
							<input type="text" placeholder="Número do Serial" id="nr_serial_inv" name="nr_serial_inv" class="form-control" required="true">
							<legend>FABRICANTE</legend>
							<input type="text" placeholder="Nome do Fabricante" id="nr_fabr_inv" name="nr_fabr_inv" class="form-control">
							<legend>FABRICAÇÃO</legend>
							<input type="text" placeholder="Data de Fabricação" id="nr_ano_inv" name="nr_ano_inv" class="form-control">
							<!--legend>C.A.</legend>
							<input type="text" placeholder="Número" id="nr_ca_inv" name="nr_ca_inv" class="form-control">
							<input type="date" id="dt_ca_inv" name="dt_ca_inv" class="form-control">
							<legend>Laudo</legend>
							<input type="text" placeholder="Número" id="nr_ld_inv" name="nr_ld_inv" class="form-control">
							<input type="date" id="dt_ld_inv" name="dt_ld_inv" class="form-control">
							<legend>Validade</legend>
							<input type="date" id="dt_val_inv" name="dt_val_inv" class="form-control"-->
						</div>
						<div class="form-group">
							<button type="button" id="btnSaveConfProdInvTransf" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-floppy-disk"></span> Salvar
							</button>
						</div>
						<div class="form-group">
							<h4 id="retInvQtdeTransf"></h4>
						</div>
					</div>
				</form>
			</div>
		</div>
		<a href="inventario_transf.php" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
	</div>
</div>