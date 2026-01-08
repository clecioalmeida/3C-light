<?php
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

if (isset($_POST['nr_pedido'])) {

	$nr_pedido = $_POST['nr_pedido'];

} else {

	$nr_pedido = $_GET['cod_ped'];

}

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_ped = "SELECT t1.cod_ped,t3.ds_prateleira,t5.ds_prateleira,t3.ds_coluna,t5.ds_coluna,t3.ds_altura,t5.ds_altura,t1.nr_pedido,
t1.produto,t6.nm_produto,t1.nr_qtde,coalesce(t1.nr_qtde_exp,0) as nr_qtde_exp,t4.tp_unid,coalesce(t4.ds_lp,0) as ds_lp,t1.ds_serial,
t3.produto
from tb_pedido_coleta_produto t1
left join tb_coleta_pedido t3 on t1.cod_ped = t3.cod_ped
left join tb_mb51e t4 on t1.nr_pedido = t4.nr_pedido and t1.produto = t4.cod_prod_cliente
left join tb_produto t6 on t1.produto = t6.cod_prod_cliente 
left join tb_posicao_pallet t5 on (t3.ds_prateleira = t5.ds_prateleira and t3.ds_coluna = t5.ds_coluna 
and t3.ds_altura = t5.ds_altura) and t3.produto = t5.produto
where t1.nr_pedido = '$nr_pedido'
group by t1.cod_ped";
$res_ped = mysqli_query($link, $sql_ped);

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="expede_sp.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<h4>Expedição simples</h4>

					<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
					<div role="content">
						<div class="jarviswidget-editbox">
						</div>
						<div class="widget-body">
							<form id="formPedido">
								<fieldset>
									<div class="form-group">
										<label>Pedido número: <?php echo $nr_pedido; ?></label>
									</div>
								</fieldset>
								<h2 class="fimPedido" id="retExpEnd1" style="background-color: #98FB98"></h2>
								<h2 class="fimPedido" id="retExpEnd2" style="background-color: #F08080"></h2>
								<fieldset>
									<table data-role="table" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">
										<thead>
											<tr style="font-size: 12px">
												<th>CÓDIGO</th>
												<th>DESCRIÇÃO</th>
												<th>LP</th>
												<th>QTDE</th>
												<th>CONFERIDO</th>
												<th></th>
											</tr>
										</thead>
										<tbody style="font-size: 10px">
											<?php
											while ($dados_ped = mysqli_fetch_assoc($res_ped)) {?>
												<tr class="tblRows" data_prd="<?php echo $dados_ped['produto']; ?>" data_qtd="<?php echo $dados_ped['nr_qtde']; ?>">
													<td><?php echo $dados_ped['produto']; ?></td>
													<td><?php echo "Mat: ".$dados_ped['nm_produto']." KVa: ".$dados_ped['ds_kva']; ?></td>
													<td><?php echo $dados_ped['ds_lp']; ?></td>
													<td class="qtde" data-qtde="<?php echo $dados_ped['nr_qtde']; ?>" style="text-align: left;"><?php echo $dados_ped['nr_qtde']; ?></td>
													<td class="total" id="total" data-conf="<?php echo $dados_ped['nr_qtde_exp']; ?>" style="text-align: left;"><?php echo $dados_ped['nr_qtde_exp']; ?></td>
													<td>
														<a href="conf_exp.php?nr_ped=<?php echo $nr_pedido;?>&cod_ped=<?php echo $dados_ped['cod_ped'];?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
															<button type="submit" class="ui-btn ui-btn-b" id="" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb">Iniciar</button>
														</a><hr>
													</td>
												</tr>
											<?php }?>
										</tbody>
									</table>
								</fieldset>
								<h2 id="retConfPick"></h2>
								<fieldset>
									<div class="form-group">
										<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnFinConfExp" value="<?php echo $nr_pedido;?>" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">Finalizar</button>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>
</div>