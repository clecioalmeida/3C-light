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

$sql_ped = "select t1.nr_pedido, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, sum(t1.nr_qtde_col) as nr_qtde_col, t1.nr_qtde_conf, t2.cod_produto, t2.cod_prod_cliente, t3.nome
from tb_coleta_pedido t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
left join tb_armazem t3 on t1.ds_galpao = t3.id
where t1.nr_pedido = '$nr_pedido' and t1.fl_status = 'M' and t1.nr_qtde_col > 0
group by t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura
order by t1.ds_prateleira";
$res_ped = mysqli_query($link, $sql_ped);

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="picking_pedido.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header>
						<h4>Picking por pedido</h4>
					</header>
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
								<h3 class="fimPedido" id="retExpEnd1" style="background-color: #98FB98"></h3>
								<h3 class="fimPedido" id="retExpEnd2" style="background-color: #F08080"></h3>
								<fieldset>
									<table data-role="table" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">
										<thead>
											<tr style="font-size: 12px">
												<th>CÓDIGO</th>
												<th>ENDEREÇO</th>
												<th>QTDE</th>
												<th>CONFERIDO</th>
												<th></th>
											</tr>
										</thead>
										<tbody style="font-size: 10px">
											<?php
											while ($dados_ped = mysqli_fetch_assoc($res_ped)) {?>
												<tr class="tblRows" data_prd="<?php echo $dados_ped['cod_produto']; ?>" data_rua="<?php echo $dados_ped['ds_prateleira']; ?>" data_col="<?php echo $dados_ped['ds_coluna']; ?>" data_alt="<?php echo $dados_ped['ds_altura']; ?>" data_qtd="<?php echo $dados_ped['nr_qtde_col']; ?>"  data_glp="<?php echo $dados_ped['ds_galpao']; ?>">
													<td><?php echo $dados_ped['cod_prod_cliente']; ?></td>
													<td><?php echo $dados_ped['ds_galpao'].$dados_ped['ds_prateleira'].$dados_ped['ds_altura'].$dados_ped['ds_coluna']; ?></td>
													<td class="qtde" data-qtde="<?php echo $dados_ped['nr_qtde_col']; ?>"><?php echo $dados_ped['nr_qtde_col']; ?></td>
													<td class="total" id="total" data-conf="<?php echo $dados_ped['nr_qtde_conf']; ?>"><?php echo $dados_ped['nr_qtde_conf']; ?></td>
													<td>
														<a href="conf_ped.php?cod_ped=<?php echo $nr_pedido;?>&cod_prd=<?php echo $dados_ped['cod_produto'];?>&rua=<?php echo $dados_ped['ds_prateleira'];?>&col=<?php echo $dados_ped['ds_coluna']; ?>&alt=<?php echo $dados_ped['ds_altura']; ?>&qtd=<?php echo $dados_ped['nr_qtde_col']; ?>&galpao=<?php echo $dados_ped['ds_galpao']; ?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
															<button type="submit" class="ui-btn ui-btn-b" id="" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb">Iniciar</button>
														</a>
														<!--button type="submit" class="ui-btn ui-btn-b" id="btnOcorConfPed" style="float: right;width: 100px;background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb">Quebra</button--><hr>
													</td>
												</tr>
											<?php }?>
										</tbody>
									</table>
								</fieldset>
								<h2 id="retConfPick"></h2>
								<fieldset>
									<div class="form-group">
										<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnFinConfPed" value="<?php echo $nr_pedido;?>" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">Finalizar</button>
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