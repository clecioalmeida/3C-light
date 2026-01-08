<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;
} else {

	$id = $_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('xhr/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_ped = mysqli_real_escape_string($link, $_GET['cod_ped']);
$nr_ped = mysqli_real_escape_string($link, $_GET['nr_ped']);

$query_conf = "SELECT t1.cod_ped, t1.nr_pedido, t2.produto, t1.nr_qtde, coalesce(t1.nr_qtde_exp,0) as nr_qtde_exp, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura,
t1.ds_kva, t1.ds_lp, t1.ds_serial, t1.ds_ano, t1.ds_fabr, t1.ds_enr, t1.ds_oleo, t3.nome, t4.id as id_end 
from tb_pedido_coleta_produto t1
left join tb_coleta_pedido t2 on t1.cod_ped = t2.cod_ped
left join tb_armazem t3 on t2.ds_galpao = t3.id
left join tb_endereco t4 on t2.ds_galpao = t4.galpao and t2.ds_prateleira = t4.rua and t2.ds_coluna = t4.coluna and t2.ds_altura = t4.altura
where t1.cod_ped = '$cod_ped'";
$res_conf = mysqli_query($link, $query_conf);

$sql_rec = "select cod_ped, nr_qtde, cod_prd_org, cod_prd_dst, ds_umb, ds_material 
from tb_reclassifica 
where cod_ped = '$cod_ped' and fl_status <> 'E'";
$res_rec = mysqli_query($link, $sql_rec);

while ($totalconf = mysqli_fetch_assoc($res_conf)) {
	$cod_ped 		= $totalconf['cod_ped'];
	$conf 			= $totalconf['nr_qtde_exp'];
	$nr_qtde 		= $totalconf['nr_qtde'];
	$produto 		= $totalconf['produto'];
	$id_end 		= $totalconf['id_end'];
	$ds_galpao 		= $totalconf['ds_galpao'];
	$ds_prateleira 	= $totalconf['ds_prateleira'];
	$ds_coluna 		= $totalconf['ds_coluna'];
	$ds_altura 		= $totalconf['ds_altura'];
	$ds_kva 		= $totalconf['ds_kva'];
	$ds_lp 			= $totalconf['ds_lp'];
	$ds_serial 		= $totalconf['ds_serial'];
	$ds_ano 		= $totalconf['ds_ano'];
	$ds_fabr 		= $totalconf['ds_fabr'];
	$ds_enr 		= $totalconf['ds_enr'];
	$nome 			= $totalconf['nome'];
	$nr_pedido 		= $totalconf['nr_pedido'];
}

?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>EXPEDIÇÃO - Conversor de Umb</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white">
		<h2>Iniciar Expedição</h2>
		<div class="row">
			<div>
				<p>
				<h4 id="">Pedido:<?php echo $nr_ped; ?> - Total:<?php echo number_format($nr_qtde, 0, ",", ""); ?></h4>
				</p>
				<p>
				<h5>Produto: <?php echo $produto . " - kva: " . $ds_kva . " - Fabricante: " . $ds_fabr . " - LP: " . $ds_lp; ?></h5>
				</p>
				<p>
				<h5>Local: <?php echo $nome . " - " . $ds_prateleira . $ds_coluna . $ds_altura . " - Quantidade: " . $nr_qtde; ?></h5>
				</p>
			</div>
			<div class="conferido" id="conferido">
				<h4 id="TotalConferido">Conferido:<?php echo number_format($conf, 0, ",", ""); ?></h4>
			</div>
		</div>
		<div class="row">
			<form id="form_conf" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<label>Produto</label>
						<input type="text" id="PrdExp" name="PrdExp" class="form-control" required="true" autofocus="true" value="" style="text-align: right;" />

						<label>Endereço</label>
						<input type="text" id="localExp" name="localExp" class="form-control" required="true" value="" style="text-align: right;" />
						
						<label>Quantidade</label>
						<input class="form-control" type="text" id="nr_qtde_rec" name="nr_qtde_rec" value="" placeholder="QUANTIDADE">
					</div>
					<div class="ui-grid-a">
						<div class="ui-block-a">
							<input type="text" id="ds_umb" name="ds_umb" value="" placeholder="NOVA UMB" style="text-align: right;">
						</div>
						<div class="ui-block-b">
							<select class="form-control" name="ds_mat" id="ds_mat">
								<option value="FERRO">FERRO</option>
								<option value="VIDRO">VIDRO</option>
								<option value="ALUMÍNIO">ALUMÍNIO</option>
								<option value="CABO">CABO</option>
								<option value="SOBRA">SOBRA</option>
							</select>
						</div>
					</div>
				</div>
			</form>

			<div class="row">
				<div class="col-md-12" style="text-align: center;">
					<div>

						<table data-role="table" id="" data-mode="" class="" style="font-size: 10px;">
							<thead>
								<tr>
									<th data-priority="1">CODIGO</th>
									<th data-priority="2">COD.ORIGEM</th>
									<th data-priority="2">COD.DESTINO</th>
									<th data-priority="3">QTDE</th>
									<th data-priority="4">UMB</th>
									<th data-priority="4">MATERIAL</th>
									<!--th style="width:50%;text-align:center;">Ações</th-->
								</tr>
							</thead>
							<tbody id="retReclassifica">
								<?php while ($dados = mysqli_fetch_assoc($res_rec)) { ?>
									<tr>
										<td><?php echo $dados['cod_ped']; ?></td>
										<td><?php echo $dados['cod_prd_org']; ?></td>
										<td><?php echo $dados['cod_prd_dst']; ?></td>
										<td><?php echo $dados['nr_qtde']; ?></td>
										<td><?php echo $dados['ds_umb']; ?></td>
										<td><?php echo $dados['ds_material']; ?></td>
										<!--td style="text-align: right;">
										<form>
											<a href="recebimento_dtl.php?nm_placa=<?php echo $dados['nm_placa']; ?>&nm_fornecedor=<?php echo $dados['nm_fornecedor']; ?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
												<input type="button" id="" data-role="none" value="Detalhe" style="float: right;margin-left: 5px;background-color: #FF4500;text-shadow: none;color:white;border-color: #fdfbfb">
											</a>
											<a href="recebimento_or_qtde_dtl.php?nm_placa=<?php echo $dados['nm_placa']; ?>&nm_motorista=<?php echo $dados['nm_motorista']; ?>&nm_fornecedor=<?php echo $dados['nm_fornecedor']; ?>&dt_recebimento=<?php echo $dados['dt_recebimento']; ?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
												<input type="button" id="" data-role="none" value="Incluir" style="float: right;margin-left: 5px;background-color: #20B2AA;text-shadow: none;color:white;border-color: #fdfbfb">
											</a>
											<a href="" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
												<input type="button" id="btnFinRec" data-fn="<?php echo $dados['nm_placa']; ?>" data-role="none" value="Finaliza" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">
											</a>
										</form>
									</td-->
									<tr>
									<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<button class="btn btn-primary" type="button" value="<?php echo $cod_ped; ?>" data-ped="<?php echo $nr_ped; ?>" id="btnSaveConv">SALVAR</button>
		<button class="btn btn-primary" type="button" value="<?php echo $cod_ped; ?>" id="btnFinConv" style="background-color: #16a085; color:white">FINALIZAR</button>
		<a href="expede_pedido_con.php?cod_ped=<?php echo $nr_pedido; ?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">FECHAR</a>
	</div>
</div>