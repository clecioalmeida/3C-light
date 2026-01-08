<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];

	echo $cod_cli;
}

?>
<?php
require_once 'data/inventario/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.id, t1.id_galpao, t1.dt_inicio, t2.nome
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.fl_status = 'P'";
$res_inv = mysqli_query($link, $SQL);

$SQL_conf = "select DISTINCT t1.user_create, t2.nm_user
from tb_inv_tarefa t1
left join tb_usuario t2 on t1.user_create = t2.id
where t2.fl_status = 'A' and t1.fl_empresa = '$cod_cli' and t1.fl_status = 'A'";
$res_conf = mysqli_query($link, $SQL_conf);

$link->close();
?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Inventário</li><li>Tarefas</li>
		</ol>
	</div>
	<div id="content">
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
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<form method="POST" class="form-inline" id="pesquisaTarefa" action="">
															<fieldset>
																<div class="row">
																	<div class="col-sm-8" style="text-align: left;">
																		<div class="form-group">			
																			<select class="form-control" name="user_tar" id="user_tar">
																				<option value="">Selecione o conferente</option>
																				<?php
																				while ($dados_conf=mysqli_fetch_assoc($res_conf)) {?>
																					<option id="" value="<?php echo $dados_conf['user_create']; ?>"><?php echo $dados_conf['nm_user']; ?></option>
																				<?php } ?>
																			</select>
																			<input type="submit" class="btn-info form-control" id="btnTarefas" value="Pesquisar">
																			<button type="button" id="btnNewTar" class="btn btn-success btn-sm">Nova tarefa</button>
																			<button type="button" id="btnProdNaoIdent" class="btn btn-default btn-sm">Produtos não conformes</button>
																		</div>
																	</div>
																	<div class="col-sm-4" style="text-align: right;">
																		<button type="button" id="btnEncTarConf" class="btn btn-info btn-sm" style="width: 150px">Encerrar por conferente</button>
																		<button type="button" id="btnEncTarDia" class="btn btn-primary btn-sm" style="width: 100px">Fechamento</button>
																		<button type="button" id="btnTarExcel" class="btn btn-success btn-sm" style="width: 80px">Excel</button>
																	</div>
																</div>
															</fieldset>
														</form>

														<div id="infoTarefas" class="row" style="margin-left: 10px"></div>
														<div id="retornoTarefas" class="row"></div>
													</div>
												</div>
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