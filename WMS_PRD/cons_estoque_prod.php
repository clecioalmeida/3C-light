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
require_once('data/movimento/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "select * from tb_armazem where id_oper = '$cod_cli'";
$res_local = mysqli_query($link, $sql_local);

?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Movimentação</li><li>Consulta saldos de estoque</li>
		</ol>
	</div>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-home"></i> 
					Consulta 
					<span>|  
						Estoque
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
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
											<header>
												<span class="widget-icon"> <i class="fa fa-cog"></i> </span>
												<h2>Consulta saldo de estoque por produto</h2>	

											</header>
										</div>

										<div>
											<div class="jarviswidget-editbox">
											</div>
											<div class="widget-body no-padding" id="dados">

												<div id="retorno"></div>
												<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 30px">

													<form class="form-inline" method="POST" id="formProdEstoque" action="">
														<div class="form-group">
															<label for="conGalpao" style="color: black"> Local</label>
															<select class="form-control" id="conGalpao" name="conGalpao">
																<option value="">Escolha o local</option>
																<?php
																while ($row_select_local = mysqli_fetch_assoc($res_local)) {
																	echo '<option value="'.$row_select_local['id'].'">'.$row_select_local['nome'].'</option>';
																} ?>
															</select>
														</div>
														<div class="form-group">
															<label for="conRua" style="color: black"> Rua / Módulo</label>
															<select class="form-control" id="conRua" name="conRua">
																<option>Selecione a rua</option>
															</select>
														</div>
														<div class="form-group">
															<label for="conColuna" style="color: black"> Coluna</label>
															<select class="form-control" id="conColuna" name="conColuna">
																<option>Selecione a coluna</option>
															</select>
														</div>
														<div class="form-group">
															<label for="conAltura" style="color: black"> Altura</label>
															<select class="form-control" id="conAltura" name="conAltura">
																<option>Selecione a altura</option>
															</select>
														</div>
														<div class="form-group form-inline" style="float:right; margin-right: 60px">
															<input type="submit" class="form-control btn-info" id="btnPesquisaProdEstoq" value="Pesquisar">
														</div>
													</form>
												</article>
												<div id="retornoEstoque"></div>
											</div>
											<div>		
											</div>
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