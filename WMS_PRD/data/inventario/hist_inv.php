<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
require_once 'data/inventario/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$SQL = "select t1.*, t2.nome from tb_inv_prog t1 left join tb_armazem t2 on t1.id_galpao = t2.id where t1.fl_status <> 'E'";
$res_inv = mysqli_query($link, $SQL);

$SQL_conf = "select t1.nm_cliente, t1.cod_cliente, t2.nm_cargo
from tb_cliente t1 left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
where t1.nm_cargo = 20";
$res_conf = mysqli_query($link, $SQL_conf);

$SQL_conf2 = "select t1.nm_cliente, t1.cod_cliente, t2.nm_cargo
from tb_cliente t1 left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
where t1.nm_cargo = 20";
$res_conf2 = mysqli_query($link, $SQL_conf2);

$SQL1 = "select count(t1.id) as count_rua 
from tb_inv_tarefa  t1
left join tb_inv_prog t2 on t1.id_inv= t2.id
where t1.id_rua <> '' and t1.fl_empresa = '$cod_cli' and t1.fl_status = 'X' and t2.fl_status = 'P'
group by t1.id_rua, t1.id_coluna, t1.id_altura";
$res1 = mysqli_query($link, $SQL1);
$count_rua = mysqli_num_rows($res1);

$SQL2 = "select count(t1.id) as count_end 
from tb_endereco t1
left join tb_armazem t2 on t1.galpao = t2.id
where t2.id_oper = '$cod_cli'";
$res2 = mysqli_query($link, $SQL2);
$dados2 = mysqli_fetch_assoc($res2);
$count_end = $dados2['count_end'];

$total_end = $count_rua / $count_end * 100;

//echo $total_end;

$SQL3 = "select sum(t2.cont_2) as qtde
from tb_inv_tarefa t1
left join tb_inv_conf t2 on t1.id = t2. id_tar
left join tb_inv_prog t3 on t1.id_inv = t3.id
where t1.fl_status = 'X' and t1.fl_empresa = '$cod_cli' and t3.fl_status = 'P'";
$res3 = mysqli_query($link, $SQL3);
$dados3 = mysqli_fetch_assoc($res3);
$count_item = $dados3['qtde'];


$link->close();
?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Inventário</li><li>Histórico</li>
		</ol>
	</div>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-home"></i>
					Inventário
					<span>|
						Histórico
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
				<ul id="sparks" class="">
					<li class="sparks-info">
						<h5> Itens contados <span class="txt-color-blue"><?php echo $count_item; ?></span></h5>
					</li>
					<li class="sparks-info">
						<h5> Endereços inventariados <span class="txt-color-purple"><i class="fa fa-arrow-circle-up"></i>&nbsp;<?php echo number_format(floor($total_end), 0, ".", "."); ?>%</span></h5>
					</li>
					<li class="sparks-info">
						<h5> Percentual SKU inventariado <span class="txt-color-greenDark"><i class="fa fa-arrow-circle-up"></i></i>&nbsp;0%</span></h5>
					</li>
				</ul>
			</div>
		</div>
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>
						<div class="jarviswidget-editbox">
							<input class="form-control" type="text">
						</div>
						<div class="widget-body">
							<section id="widget-grid" class="">
								<div class="row">
									<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
											<div>
												<div class="jarviswidget-editbox">
												</div>
												<div class="widget-body no-padding" id="dados">
													<br><br>
													<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
														<form method="POST" class="form-inline" id="pesquisaTarefa" action="">
															<fieldset>
																<div class="row">
																	<div class="form-group" style="text-align: left;">
																		<label class="col-sm-4 control-label" for="inv_rua">Selecione a tarefa</label>
																		<div class="col-sm-8">
																			<input type="text" class="form-control" aria-describedby="basic-addon2" name="dtInitHistTar" id="SelIdTArefa" placeholder="Tarefa" style="width: 200px">
																		</div>
																		<label class="col-sm-4 control-label" for="inv_rua">Selecione o inventário e o período</label>
																		<div class="col-sm-8">
																			<select class="form-control" id="SelHistInv" required="true" style="width: 200px">
																				<option>Inventário</option>
																				<?php
																				while ($row_inv = mysqli_fetch_assoc($res_inv)) {?>
																					<option value="<?php echo $row_inv['id']; ?>">
																						<?php echo $row_inv['id'] . " - " . $row_inv['nome'] . " - " . date("d-m-Y", strtotime($row_inv['dt_inicio'])); ?>
																						</option> <?php }?>
																					</select>
																					<input type="date" class="form-control" aria-describedby="basic-addon2" name="dtInitHistTar" id="dtInitHistTar" style="width: 200px">
																					<input type="date" class="form-control" aria-describedby="basic-addon2" name="dtFinHistTar" id="dtFinHistTar" style="width: 200px">
																				</div>
																				<label class="col-sm-4 control-label" for="inv_rua">Selecione a rua e coluna</label>
																				<!--div class="col-sm-8">
																					<select class="form-control" id="SelInvRua" style="width: 200px">
																						<option value="">Rua</option>

																					</select>
																					<select class="form-control" id="SelInvColuna" style="width: 200px">
																						<option value="">Coluna</option>
																					</select>
																				</div-->
																				<div class="col-sm-12">
																					<br><br>
																					<button type="button" id="btnHistTar" class="btn btn-success btn-sm">Consulta tarefas</button>
																					<button type="button" id="btnHistInvFin" class="btn btn-primary btn-sm">Tarefas encerradas por dia</button>
																					<button type="button" id="btnHistInvOcor" class="btn btn-default btn-sm">Consulta produtos não conforme</button>
																					<br><br>
																				</div>
																			</div>
																		</div>
																	</fieldset>
																</form>
															</div>
															<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																<div id="aguardeStatus"></div>
																<div id="retHistStatus"></div>
															</div>
														</div>
														<div id="infoTarefas" class="row" style="margin-left: 10px"></div>
														<div id="retornoTarefas" class="row"></div>

													</div>
												</div>
											</article>
											<div class="page-content-wrapper">
												<div id="invTar"></div>
											</div>

										</div>
									</section>
								</div>
							</div>
						</article>
					</div>
					<div class="row">
						<div class="col-sm-12">
						</div>
					</div>
				</section>
			</div>