<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
require_once 'data/movimento/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_galpao = "select t1.* 
from tb_armazem t1
left join tb_galpao t2 on t1.galpao = t2.cod_galpao
where t2.fl_empresa = '$cod_cli'";
$galpao = mysqli_query($link, $sql_galpao);
$tr = mysqli_num_rows($galpao);

$sql_rua = "select distinct ds_prateleira from tb_posicao_pallet where ds_galpao = 17";
$rua = mysqli_query($link, $sql_rua);

$link->close();
?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Movimentação</li><li>movimentação de produtos</li>
		</ol>
	</div>
	<div id="content">
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
											<header>
												<span class="widget-icon"> <i class="fa fa-table"></i> </span>
												<h2>Movimentação de produtos</h2>
											</header>
											<div>
												<div class="jarviswidget-editbox">
												</div>
												<div class="widget-body no-padding" id="dados">
													<div id="retorno"></div>
													<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<form method="POST" class="form-inline" id="formMovPrd" action=""><br><br>
															<fieldset>
																<div class="col-sm-12">
																	<div class="form-group">
																		<input type="text" id="cod_movimenta" name="cod_movimenta" class="form-control" aria-describedby="basic-addon2" placeholder="Digite o código SAP do produto">
																		<input type="text" id="nm_movimenta" name="nm_movimenta" class="form-control" aria-describedby="basic-addon2" placeholder="Digite a descrição do produto">
																		<select class="form-control" id="local" name="local">
																			<option>Selecione o local</option>
																			<?php
																			while ($linha = mysqli_fetch_assoc($galpao)) {?>
																				<option value="<?php echo $linha['id']; ?>"><?php echo $linha['nome']; ?></option>
																			<?php }?>
																		</select>
																		<input type="submit" class="btn-info form-control" id="btnFormMovPrd" value="Pesquisar">
																	</div>
																</div>
															</fieldset>
														</form><br /><br />
														<div id="info_produtos" class="row"></div>
													</article>
												</div>
											</div>
										</div>
									</article>
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