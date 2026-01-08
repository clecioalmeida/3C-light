<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "SELECT c.nm_fornecedor
FROM tb_nserie_col c
left join tb_nserie n on c.id = n.id_col
WHERE c.nm_fornecedor <> '' and c.fl_status = 'A'
GROUP BY c.nm_fornecedor
ORDER BY c.nm_fornecedor ASC";
$res = mysqli_query($link, $sql);

$link->close();
?>

<script src="js/componente.js"></script>
<script src="js/saldo_minimo.js"></script>
<script src="js/seriais.js"></script>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li>
			<li>Cadastros</li>
			<li>Produtos</li>
		</ol>
	</div>
	<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget well" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
						<div>
							<div class="jarviswidget-editbox">

							</div>
							<div class="widget-body">
								<hr class="simple">
								<ul id="myTab1" class="nav nav-tabs bordered">
									<li class="active">
										<a href="#s1" id="liPrd" data-toggle="tab">PRODUTOS <span class="badge bg-color-blue txt-color-white"></span></a>
									</li>
									<li>
										<a href="#s2" id="liKit" data-toggle="tab">KIT DE PRODUTOS </a>
									</li>
									<li>
										<a href="#s3" id="liComp" data-toggle="tab">COMPONENTES</a>
									</li>
									<li>
										<a href="#s4" id="liNs" data-toggle="tab">NÚMERO DE SÉRIE</a>
									</li>
									<li>
										<a href="#s5" id="liGrp" data-toggle="tab">GRUPOS</a>
									</li>
									<li>
										<a href="#s6" id="liEmb" data-toggle="tab">EMBALAGENS</a>
									</li>
									<li>
										<a href="#s7" id="liCalib" data-toggle="tab">CONTROLE DE CALIBRAÇÃO</a>
									</li>
									<li>
										<a href="#s8" id="liSldMin" data-toggle="tab">SALDO MÍNIMO</a>
									</li>
								</ul>
								<div id="myTabContent1" class="tab-content padding-10">
									<div class="tab-pane fade in active" id="s1">
										<article>
											<div>
												<form class="form-horizontal" method="post" action="" id="">
													<label class="input">CÓDIGO SAP
														<input type="text" class="input-xs" id="codigoPrd" name="codigoPrd" style="color: black">
													</label>
													<button type="submit" id="btnPesquisaPrd" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
													<button type="submit" id="btnNovoProduto" class="btn btn-success btn-xs" style="margin-right: 3px;width: 100px">Novo</button>
												</form>
											</div>
										</article>
										<article id="loading">
											<div id="retornoPrd"></div>
											<div id="retModalPrd"></div>
										</article>
									</div>
									<div class="tab-pane fade" id="s2">
										<article>
											<div>
												<form class="form-horizontal" method="post" action="" id="">
													<label class="input">DESCRIÇÃO
														<input type="text" class="input-xs" id="produtosKit" name="produtosKit" style="color: black">
													</label>
													<label class="input">CÓDIGO SAP
														<input type="text" class="input-xs" id="codigoKit" name="codigoKit" style="color: black">
													</label>
													<button type="submit" id="btnPesquisaKit" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
												</form>
											</div>
										</article>
										<article>
											<div id="retornKit"></div>
											<div id="retModalKit"></div>
										</article>
									</div>
									<div class="tab-pane fade" id="s3">
										<article>
											<div>
												<form class="form-horizontal" method="post" action="" id="">
													<label class="input">CÓDIGO SAP
														<input type="text" class="input-xs" id="codigoComp" name="codigoComp" style="color: black">
													</label>
													<button type="submit" id="btnPesqCodigoComp" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
													<label class="input">NUMERO DE SÉRIE
														<input type="text" class="input-xs" id="nserie" name="nserie" style="color: black">
													</label>
													<button type="submit" id="btnPesqNserie" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>

													<label class="input">NÚMERO DE SÉRIE COMPONENTE
														<input type="text" class="input-xs" id="nserieComp" name="nserieComp" style="color: black">
													</label>
													<button type="submit" id="btnPesqNserieComp" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
													<button type="submit" id="btnNovoComp" class="btn btn-success btn-xs" style="margin-right: 3px;width: 100px">NOVO</button>
													<button type="submit" id="btnImpComp" class="btn btn-danger btn-xs" style="margin-right: 3px;width: 100px">IMPORTAR</button>
												</form>
											</div>
										</article>
										<article>
											<div id="retornoComp"></div>
											<div id="retModalComp"></div>
										</article>
									</div>
									<div class="tab-pane fade" id="s4">
										<article>
											<div>
												<form class="form-horizontal" method="post" action="" id="">
													<label class="input">DESCRIÇÃO
														<input type="text" class="input-xs" id="produtosNs" name="produtosNs" style="color: black">
													</label>
													<label class="input">PERÍODO
														<input type="date" class="input-xs" id="dt_ini_ns" name="dt_ini_ns" style="color: black">
														<input type="date" class="input-xs" id="dt_fim_ns" name="dt_fim_ns" style="color: black">
													</label>
													<button type="submit" id="btnPesqNsDt" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
													<button type="submit" class="btn btn-success btn-xs" id="RepEstoqGenExcel" style="float:right;width: 100px">Excel</button>
													<label class="input">FORNECEDOR
														<select class="input-xs" name="nmFornecedor" id="nmFornecedor" style="color: black; width: 100px">
															<?php while ($dados = mysqli_fetch_assoc($res)) { ?>
																<option value="<?= $dados['nm_fornecedor'] ?>"><?= $dados['nm_fornecedor'] ?></option>
															<?php } ?>
														</select>
													</label>
													<button type="submit" id="btnConsFornSeriais" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
												</form>
											</div>
										</article>
										<article>
											<div id="retornoEnc"></div>
										</article>
									</div>
									<div class="tab-pane fade" id="s5">
										<article>
											<div>
												<form class="form-horizontal" method="post" action="" id="">

												</form>
											</div>
										</article>
										<article>
											<div id="retorno_pend"></div>
										</article>
									</div>
									<div class="tab-pane fade" id="s6">
										<article>
											<div>
												<form class="form-horizontal" method="post" action="" id="">

												</form>
											</div>
										</article>
										<article>
											<div id="retorno_pend"></div>
										</article>
									</div>
									<div class="tab-pane fade" id="s7">
										<article>
											<div>
												<form class="form-horizontal" method="post" action="" id="">
													<label class="input">CÓDIGO SAP
														<input type="text" class="input-xs" id="codigoCalib" name="codigoCalib" style="color: black">
													</label>
													<button type="submit" id="btnPesqCodigoComp" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
													<label class="input">NUMERO DE SÉRIE
														<input type="text" class="input-xs" id="nserieClb" name="nserieClb" style="color: black">
													</label>
													<button type="submit" id="btnPesqNserie" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>

													<button type="submit" id="btnNovoClb" class="btn btn-success btn-xs" style="margin-right: 3px;width: 100px">NOVO</button>
												</form>
											</div>
										</article>
										<article>
											<div id="retornoClb"></div>
											<div id="retModalClb"></div>
										</article>
									</div>
									<div class="tab-pane fade" id="s8">
										<!--article>
											<div>
												<form class="form-horizontal" method="post" action="" id="">
													<label class="input">DESCRIÇÃO
														<input type="text" class="input-xs" id="prd_desc" name="prd_desc" style="color: black">
													</label>
													<label class="input">CÓDIGO SAP
														<input type="text" class="input-xs" id="prd_cod" name="prd_cod" style="color: black">
													</label>
													<button type="submit" id="btnPesqPrdSldMin" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
												</form>
											</div>
										</article-->
										<article id="loading">
											<div id="retornoSldMin"></div>
											<div id="retModalSldMin"></div>
										</article>
									</div>
								</div>
							</div>
						</div>
					</div>
				</article>
			</div>
			<div class="row">
				<div id="retModalEntrega">
				</div>
			</div>
		</section>
	</div>
	<div id="retNfTransp"></div>
</div>
<script type="text/javascript">
	$(document).on('click', '#RepEstoqGenExcel', function() {
		event.preventDefault();
		$('#RepEstoqGenExcel').prop("disabled", true);
		var today = new Date();
		$("#reportSalEstoque").table2excel({
			exclude: ".noExl",
			name: "Relatório de saldo de estoque detalhado geral",
			filename: "Relatório de saldo de estoque detalhado geral" + today
		});
		$('#RepEstoqGenExcel').prop("disabled", false);

	});
</script>