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
require_once('data/inventario/bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.*, t2.nome from tb_inv_prog t1 left join tb_armazem t2 on t1.id_galpao = t2.id where t1.fl_status = 'P' and t1.fl_empresa = '$cod_cli'";
$res_inv = mysqli_query($link,$SQL); 

$link->close();
?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Inventário</li><li>Relatório</li>
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
																	<div class="col-sm-10" style="text-align: left;">
																		<div class="form-group">                         
																			<label for="tags" style="color: white"> Inventário</label>
																			<select class="form-control" id="selInv" name="id_torre">
																				<option value="">Escolha o inventário</option>
																				<?php
																				while ($dados=mysqli_fetch_assoc($res_inv)) {
																					echo '<option value="'.$dados['id'].'">'.$dados['id']."-".$dados['nome'].'</option>';
																				} ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-2" style="text-align: right;">
																		<button type="button" id="btnPrintEncInv" class="btn btn-primary btn-sm" style="width: 100px">Gerar</button>
																		<!--button type="button" id="btnTarExcel" class="btn btn-success btn-sm" style="width: 100px">Excel</button-->
																	</div>
																</div> 
															</fieldset>
														</form>

														<div id="infoEncInv" class="row" style="margin-left: 10px"></div>
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
</div>