<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id     = $_SESSION["id"];
	$cod_cli  = $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_minuta = $_POST['cod_min'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$imp = "update tb_minuta set fl_impresso = 'S', dt_impresso = '$date' where cod_minuta = '$cod_minuta'";
$res_imp = mysqli_query($link,$imp); 

$sql_res = "select t1.cod_minuta, date_format(t1.dt_minuta,'%d/%m/%Y') as dt_minuta, t1.ds_transporte, t1.ds_obs, date_format(t1.dt_create,'%d/%m/%Y') as dt_create
from tb_minuta t1
where t1.cod_minuta = '$cod_minuta'";
$res = mysqli_query($link,$sql_res);
$dados=mysqli_fetch_assoc($res);
$romaneio 		= $dados['cod_minuta'];
$dt_minuta 		= $dados['dt_minuta'];
$ds_transporte 	= $dados['ds_transporte'];
$ds_obs 		= $dados['ds_obs'];
$dt_create 		= $dados['dt_create'];

$total_dem = "select sum(vlr_dem) as total_dem from tb_pedido_coleta where nr_minuta = '$cod_minuta' and fl_status <> 'E'";
$res_dem = mysqli_query($link,$total_dem); 
while($dados_dem=mysqli_fetch_assoc($res_dem)){
	$total_dem = $dados_dem['total_dem'];
}

$total = "select sum(t1.nr_qtde_exp) as total from tb_pedido_coleta_produto t1 left join tb_pedido_coleta t2 on t1.nr_pedido = t2.nr_pedido where t2.nr_minuta = '$cod_minuta' and t1.fl_status <> 'E'";
$res_total = mysqli_query($link,$total); 
while($dados_total=mysqli_fetch_assoc($res_total)){
	$total = $dados_total['total'];
}

$pedido = "select t1.cod_minuta, t1.dt_minuta, t1.ds_obs, t2.nr_pedido, t2.nr_ped_sap, t2.doc_material, t2.cod_almox, t2.ds_destino, t3.produto, t3.nr_qtde_exp,t4.nm_produto, t2.nr_dem, t2.vlr_dem, t5.ds_almox 
from tb_minuta t1
left join tb_pedido_coleta t2 on t1.cod_minuta = t2.nr_minuta
left join tb_pedido_coleta_produto t3 on t2.nr_pedido = t3.nr_pedido
left join tb_produto t4 on t3.produto = t4.cod_prod_cliente
left join tb_almox t5 on t2.cod_almox = t5.cod_almox
where t1.cod_minuta = '$cod_minuta'
group by t3.produto
order by t2.nr_dem asc";
$res_pedido = mysqli_query($link,$pedido);

if($cod_cli == "3"){

	$remetente 			= "EDP SAO PAULO - SÃO JOSÉ DOS CAMPOS - SP";
	$endRem 			= "";
	$brRem 				= "";
	$cidRem				= "";
	$cepRem				= "";

}else if($cod_cli == "4"){

	$remetente 			= "EDP ESPIRITO SANTO - VILA VELHA - SP";
	$endRem 			= "";
	$brRem 				= "";
	$cidRem				= "";
	$cepRem				= "";



} 

$link->close();
?>
<style type="text/css">
	@media print {
		@page { margin: 0; }
		body { margin: 1.6cm; }
	}
</style>
<script type="text/javascript" src="./js/jspdf.min.js"></script>
<script type="text/javascript">
	function printContent(el){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
	}
</script>
<div id="content">
	<section id="widget-grid" class="">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget well jarviswidget-color-darken" id="wid-id-0" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false">
					<div>
						<div class="jarviswidget-editbox">
						</div>
						<div class="widget-body no-padding">
							<div class="widget-body-toolbar" id="toolbar">
								<div class="row">
									<div class="col-sm-4">
									</div>
									<div class="col-sm-8 text-align-right">
												<!--div class="btn-group">
													<button class="btn btn-sm btn-primary" id="" style="width: 100px">PDF</button>
												</div-->
												<div class="btn-group">
													<!--a href="javascript:demoFromHTML()" class="button">JsPdf</a-->
													<button onclick="printContent('reportSalEstoque')" type="submit" class="btn btn-primary" id="RepEstoqGenPdf" style="float:right;width: 100px">Imprimir</button>
												</div>
											</div>

											<div id="retorno"></div>
										</div>
									</div>

									<div id="reportSalEstoque">
										<div class="padding-10">
											<div class="pull-left">
												<img src="img/Logo3C.jpg" width="80" height="32" alt="Gisis">
												<address>
													<br>
													<strong>3C Services</strong>
												</address>
											</div>
											<div class="pull-right">
												<h1 class="font-18">ROMANEIO DE TRANSPORTE: <?php echo $cod_minuta;?></h1>
												<strong>ROMANEIO CRIADO EM:</strong>
												<span> <i class="fa fa-calendar"></i> 
													<?php 
													echo $dt_create;
													?> 
												</span>
												<div style="text-align: right;width: 100px">
													<svg id="barcode" 
													class="barcode"
													jsbarcode-format="auto"
													jsbarcode-height="40"
													jsbarcode-displayValue="false"
													jsbarcode-value="<?php echo $cod_minuta;?>"
													jsbarcode-textmargin="0"
													jsbarcode-fontoptions="bold">
												</svg>
											</div>
											<br>
											<strong>MOTORISTA: <?php echo $ds_transporte; ?></strong>
											<br><br><br>
											<strong>KM INICIO CL:____________ KM FINAL CL:_________________</strong><br><br><br>
											<strong>HR SAÍDA CL:_____________ HR CHEGADA CL :______________</strong>
											<br><br><br>
											<strong>INSTRUÇÕES: <?php echo $ds_obs; ?></strong>
										</div>
										<div class="clearfix"></div>
										<br>
										<div class="row">
											<div class="col-sm-12">
												<div class="pull-left col-sm-3">
													<address>
														<br>
														<strong>REMETENTE: <?php echo $remetente; ?></strong>
														<br>
													</address>
												</div>
												<!--div class="pull-midle col-sm-4">
													<address>
														<br>
														<strong>Destinatário:<?php echo $cod_almox." - ".$ds_destino; ?></strong>
														<br>
													</address>
												</div-->
												<div class="pull-right col-sm-3">
													<!--h4>Romaneio de transporte</h4-->
													<div class="font-md">
                                                  <!--div>
                                                    <strong>Minuta No:</strong>
                                                    <span class="pull-right"> #AA-454-4113-00 </span>
                                                </div-->
                                                <strong>DATA DE SAÍDA:</strong>
                                                <span class="pull-right"> <i class="fa fa-calendar"></i> <?php echo $dt_minuta; ?> </span>

                                            </div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                                <table class="table table-hover" style="width: 100%">
                                	<thead>
                                		<tr>
                                			<th>PEDIDO</th>
                                			<th>PEDIDO SAP</th>
                                			<th>DOC MATERIAL</th>
                                			<th>D.E.M</th>
                                			<th>DESTINO</th>
                                			<th>COD PRODUTO</th>
                                			<th>DESCRIÇÃO</th>
                                			<th>QTDE</th>
                                		</tr>
                                	</thead>
                                	<tbody>
                                		<?php 
                                		while($dados_pedido=mysqli_fetch_assoc($res_pedido)){
                                			?>
                                			<tr>
                                				<td style="text-align: center;"><?php echo $dados_pedido['nr_pedido']; ?></td>
                                				<td style="text-align: center;"><?php echo $dados_pedido['nr_ped_sap']; ?></td>
                                				<td style="text-align: center;"><?php echo $dados_pedido['doc_material']; ?></td>
                                				<td style="text-align: center;"><?php echo $dados_pedido['nr_dem']; ?></td>
                                				<td><?php echo $dados_pedido['cod_almox']."-".$dados_pedido['ds_almox']; ?></td>
                                				<td style="text-align: center;"><?php echo $dados_pedido['produto']; ?></td>
                                				<td><?php echo $dados_pedido['nm_produto']; ?></a></td>
                                				<td style="text-align: right;"><?php echo $dados_pedido['nr_qtde_exp']; ?></td>
                                			</tr>
                                		<?php } ?>												
                                		<tr style="background-color: #98FB98">
                                			<td colspan="6" style="text-align: right;"><strong>Total:</strong></td>
                                			<td style="text-align: right;"><strong><?php echo $total_dem;?></strong></td>
                                			<td style="text-align: right;"><strong><?php echo $total;?></strong></td>
                                		</tr>
                                	</tbody>
                                </table>

                                <div class="invoice-footer">
                                	<div class="col-sm-12">				
                                		<!--div class="row">
                                			<dl>
                                				<dt>Instruções de entrega:</dt>
                                				<dd><h6>INFORMAÇÃO IMPORTANTE: <?php echo $ds_obs;?>.</h6></dd><br>
                                			</dl>													
                                		</div-->
                                	</div>
                                	<div class="col-sm-12">				
                                		<div class="row">

                                			<div class="col-sm-5">
                                				<p>Conferente:</p><br /><br />
                                				<p>Nome: ___________________________________________________</p><br />
                                				<p>Data da conferência: ______/______/________</p><br />
                                			</div>
                                			<div class="col-sm-5">
                                				<p>Motorista:</p><br /><br /><br />
                                				<p>Nome: ___________________________________________________</p><br />
                                				<p>Data do carregamento: ______/______/________</p>
                                			</div>
                                		</div>
                                	</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

            </div>
        </section>
    </div>
    <script type="text/javascript" src="../../../js/JsBarcode.all.min.js"></script>
    <script type="text/javascript">
    	JsBarcode(".barcode").init();
    </script>