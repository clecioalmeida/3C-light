<?php 
require_once('data/inventario/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select * from tb_inv_prog where fl_status = 'P'";
$res_inv = mysqli_query($link,$SQL); 

$SQL_conf = "select t1.nm_cliente, t1.cod_cliente, t2.nm_cargo 
from tb_cliente t1 left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
where t1.nm_cargo = 20";
$res_conf = mysqli_query($link,$SQL_conf); 

$SQL_conf2 = "select t1.nm_cliente, t1.cod_cliente, t2.nm_cargo 
from tb_cliente t1 left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
where t1.nm_cargo = 20";
$res_conf2 = mysqli_query($link,$SQL_conf2); 

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
																	<div class="col-sm-10" style="text-align: left;">
																		<div class="form-group">                         
																			<label for="tags" >Inventário</label>
																			<select class="form-control" id="selInvTar" name="selInvTar">
																				<option value="">Escolha o inventário</option>
																				<?php
																				while ($dados=mysqli_fetch_assoc($res_inv)) {
																					echo '<option value="'.$dados['id'].'">'.$dados['id'].'</option>';
																				} ?>
																			</select>
																			<label for="tags">Rua</label>
																			<select class="form-control" id="selRuaInvTar" name="selRuaInvTar">
																				<option>Escolha a rua</option>

																			</select>
																			<label for="tags">Coluna</label>
																			<select class="form-control" id="selColInvTar" name="selColInvTar">
																				<option>Escolha a coluna</option>

																			</select>
																			<label for="tags">Altura</label>
																			<select class="form-control" id="selAltInvTar" name="selAltInvTar">
																				<option>Escolha a altura</option>

																			</select>
																		</div>
																	</div>
																	<div class="col-sm-2">
																		<button type="button" id="btnPrintTarInv" class="btn btn-primary btn-sm" style="width: 100px">Gerar</button>
																		<button type="button" id="btnTarExcel" class="btn btn-success btn-sm" style="width: 100px">Excel</button>
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
	<!-- END MAIN CONTENT -->
<!--script>
$(document).ready(function(){
    $('#btnAgendados').click(function () {
        inventario($("#agendados").val())
    });

    
});
    
</script-->