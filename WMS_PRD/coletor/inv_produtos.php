<?php
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

if (isset($_POST['id_inv'])) {

	$id_inv = $_POST['id_inv'];
	$id_local = $_POST['id_local'];
	$id_rua = $_POST['id_rua'];
	$id_coluna = $_POST['id_coluna'];
	$id_altura = $_POST['id_altura'];

} else {

	$id_inv = $_GET['id_inv'];
	$id_local = $_GET['id_local'];
	$id_rua = $_GET['id_rua'];
	$id_coluna = $_GET['id_coluna'];
	$id_altura = $_GET['id_altura'];

}

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_ped = "select t1.id, t1.id_inv,t1.id_estoque, t1.id_produto, t1.nr_qtde, t2.cod_prod_cliente, coalesce(t3.cont_1,0) as cont_1,
coalesce(t3.cont_2,0) as cont_2, coalesce(t3.cont_3,0) as cont_3, t3.status_conf
from tb_inv_tarefa t1
left join tb_produto t2 on t1.id_produto = t2.cod_produto
left join tb_inv_conf t3 on t1.id =  t3.id_tar
where t1.id_inv = '$id_inv' and t1.id_galpao = '$id_local' and t1.id_rua = '$id_rua' and t1.id_coluna = '$id_coluna' and t1.id_altura = '$id_altura'";
$res_ped = mysqli_query($link, $sql_ped);

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="inventario_ag.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header>
						<h4>Inventário</h4>
					</header>
					<div role="content">
						<div class="jarviswidget-editbox">
						</div>
						<div class="widget-body">
							<form id="formPedido">
								<fieldset>
									<div class="form-group">
										<label></label>
									</div>
								</fieldset>
								<h3 class="fimPedido" id="retExpEnd1" style="background-color: #98FB98"></h3>
								<h3 class="fimPedido" id="retExpEnd2" style="background-color: #F08080"></h3>
								<fieldset>
									<table data-role="table" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">
										<thead>
											<tr style="font-size: 12px">
												<th>CÓDIGO</th>
												<th>QTDE</th>
												<th>CONT.1</th>
												<th>CONT.2</th>
												<th>CONT.3</th>
												<th></th>
											</tr>
										</thead>
										<tbody style="font-size: 10px">
											<?php
											while ($dados_ped = mysqli_fetch_assoc($res_ped)) {?>
												<tr>
													<td><?php echo $dados_ped['cod_prod_cliente']; ?></td>
													<td><?php echo $dados_ped['nr_qtde']; ?></td>
													<td><?php echo $dados_ped['cont_1']; ?></td>
													<td><?php echo $dados_ped['cont_2']; ?></td>
													<td><?php echo $dados_ped['cont_3']; ?></td>
													<td>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<a href="inv_estoque_p.php?cod_prd=<?php echo $dados_ped['id_produto'];?>&cod_estq=<?php echo $dados_ped['id_estoque'];?>&qtd_prd=<?php echo $dados_ped['nr_qtde'];?>&contp=<?php echo $dados_ped['cont_1']; ?>&conts=<?php echo $dados_ped['cont_2']; ?>&contt=<?php echo $dados_ped['cont_3']; ?>&ds_galpao=<?php echo $id_local; ?>&ds_prateleira=<?php echo $id_rua; ?>&ds_coluna=<?php echo $id_coluna; ?>&ds_altura=<?php echo $id_altura; ?>&cod_cli=<?php echo $dados_ped['cod_prod_cliente']; ?>&id_inv=<?php echo $dados_ped['id_inv']; ?>&id_tar=<?php echo $dados_ped['id']; ?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
															<button type="submit" class="ui-btn ui-btn-inline ui-btn-b btnConf" id="btnContP" value="<?php echo $dados_ped['status_conf']; ?>" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb;font-size: 10px">Prim. contagem</button>
														</a>
														<a href="inv_estoque_s.php?cod_prd=<?php echo $dados_ped['id_produto'];?>&cod_estq=<?php echo $dados_ped['id_estoque'];?>&qtd_prd=<?php echo $dados_ped['nr_qtde'];?>&contp=<?php echo $dados_ped['cont_1']; ?>&conts=<?php echo $dados_ped['cont_2']; ?>&contt=<?php echo $dados_ped['cont_3']; ?>&ds_galpao=<?php echo $id_local; ?>&ds_prateleira=<?php echo $id_rua; ?>&ds_coluna=<?php echo $id_coluna; ?>&ds_altura=<?php echo $id_altura; ?>&cod_cli=<?php echo $dados_ped['cod_prod_cliente']; ?>&id_inv=<?php echo $dados_ped['id_inv']; ?>&id_tar=<?php echo $dados_ped['id']; ?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
															<button type="submit" class="ui-btn ui-btn-inline ui-btn-b btnConf" id="" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb;font-size: 10px">Seg. contagem</button>
														</a>
														<a href="inv_estoque_t.php?cod_prd=<?php echo $dados_ped['id_produto'];?>&cod_estq=<?php echo $dados_ped['id_estoque'];?>&qtd_prd=<?php echo $dados_ped['nr_qtde'];?>&contp=<?php echo $dados_ped['cont_1']; ?>&conts=<?php echo $dados_ped['cont_2']; ?>&contt=<?php echo $dados_ped['cont_3']; ?>&ds_galpao=<?php echo $id_local; ?>&ds_prateleira=<?php echo $id_rua; ?>&ds_coluna=<?php echo $id_coluna; ?>&ds_altura=<?php echo $id_altura; ?>&cod_cli=<?php echo $dados_ped['cod_prod_cliente']; ?>&id_inv=<?php echo $dados_ped['id_inv']; ?>&id_tar=<?php echo $dados_ped['id']; ?>" class="btn btn-primary btn-lg btn-block" data-transition="pop" style="text-decoration: none">
															<button type="submit" class="ui-btn ui-btn-inline ui-btn-b btnConf" id="" style="background-color: #2c3e50;text-shadow: none;color:white;border-color: #fdfbfb;font-size: 10px">Terc. contagem</button>
														</a>
														</div><hr>
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