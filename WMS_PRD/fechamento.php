<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "select * from tb_armazem";
$res_local = mysqli_query($link, $sql_local);

$sql_fechamento = "select concat(
		case MONTH(dt_mes)
		when 1 then 'Janeiro'
		when 2 then 'Fevereiro'
		when 3 then 'Março'
		when 4 then 'Abril'
		when 5 then 'Maio'
		when 6 then 'Junho'
		when 7 then 'Julho'
		when 8 then 'Agosto'
		when 9 then 'Setembro'
		when 10 then 'Outubro'
		when 11 then 'Novembro'
		when 12 then 'Dezembro'
		end,' / ', YEAR(dt_mes)) as dt_fechamento, DATE_FORMAT(dt_mes, '%m/%Y') as mes
		from tb_giro
    where YEAR(dt_mes) =  YEAR(NOW())
		group by MONTH(dt_mes) DESC
UNION
select concat(
		case MONTH(dt_mes)
		when 1 then 'Janeiro'
		when 2 then 'Fevereiro'
		when 3 then 'Março'
		when 4 then 'Abril'
		when 5 then 'Maio'
		when 6 then 'Junho'
		when 7 then 'Julho'
		when 8 then 'Agosto'
		when 9 then 'Setembro'
		when 10 then 'Outubro'
		when 11 then 'Novembro'
		when 12 then 'Dezembro'
		end,' / ', YEAR(dt_mes)) as dt_fechamento, DATE_FORMAT(dt_mes, '%m/%Y') as mes
		from tb_giro
    where YEAR(dt_mes) < YEAR(NOW())
		group by MONTH(dt_mes) DESC";
$res_fechamento = mysqli_query($link, $sql_fechamento);

$SQL = "select
            DATE_FORMAT(dt_mes, '%m/%Y') as mes,
            avg(nr_saldo) as saldo, sum(qtd_rec) as rec, sum(qtd_ped) as ped
            from tb_giro
            where YEAR(dt_mes) =  YEAR(NOW())
            group by DATE_FORMAT(dt_mes, '%m/%Y') desc
        UNION
            select
            DATE_FORMAT(dt_mes, '%m/%Y') as mes,
            avg(nr_saldo) as saldo, sum(qtd_rec) as rec, sum(qtd_ped) as ped
            from tb_giro
            where YEAR(dt_mes) < YEAR(NOW())
            group by DATE_FORMAT(dt_mes, '%m/%Y') desc";

$res = mysqli_query($link, $SQL);
$tr = mysqli_num_rows($res);

?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Gerencial</li><li>Apuração mensal</li>
		</ol>
	</div>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-home"></i>
						Gerenciamento
					<span>|
						Apuração mensal
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
			</div>
		</div>
		<section id="widget-grid" class="">
			<div class="row">
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
											<h2>Apuração de saldos de estoque</h2>
										</header>
										<div>
											<div class="jarviswidget-editbox"></div>
										<div class="widget-body no-padding" id="dados">
											<div id="retorno"></div>
											<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<form method="POST" class="form-inline" id="formGiroEstoque" action="">
												<br><br>
												    <fieldset>
														<div class="col-sm-8" style="text-align: left;">
															<div class="form-group">
																<input type="submit" class="btn-info form-control" id="btnApSaldoMensal" value="Iniciar" style="width: 200px">
															</div>
														</div>
														<div class="col-sm-4" style="text-align: left;">
															<div class="form-group">
																<select class="form-control" id="selMesAp" required="true" style="width: 200px">
																    <option>Apuração</option>
																        <?php
while ($row = mysqli_fetch_assoc($res_fechamento)) {?>
																    <option value="<?php echo $row['mes']; ?>">
																        <?php echo $row['dt_fechamento']; ?>
																    </option> <?php }?>
																</select>
																<input type="submit" class="btn-info form-control" id="btnConsApMensal" value="Consultar" style="width: 100px">
															</div>
														</div>
													</fieldset>
												</form>
											</article><br /><br />
											<article style="margin-left: 50px">
												<div id="relatorio" class="row">
													<section class="panel col-lg-6">
													    <hr>
													    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1" style="width: 600px">
													        <thead>
													            <tr>
													                <th> Mês</th>
													                <th> Total expedido</th>
													                <th> Total recebido </th>
													                <th> Saldo médio do estoque </th>
													            </tr>
													        </thead>
													        <tbody>
													            <?php
while ($dados = mysqli_fetch_assoc($res)) {?>
													            <tr class="odd gradeX">
													                <td style="text-align: left"> <?php echo $dados['mes']; ?> </td>
													                <td style="text-align: right"> <?php echo $dados['ped']; ?> </td>
													                <td style="text-align: right"> <?php echo $dados['rec']; ?> </td>
													                <td style="text-align: right"> <?php echo $dados['saldo']; ?> </td>
													            </tr>
													            <?php }?>
													        </tbody>
													    </table>
													</section>
													<section class="panel col-lg-6" id="retAp">

													</section>
												</div>
											</article>
										</div>
										</div>
									</div>
							</article>
						</div>
					</section>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="row">
	<div class="col-sm-12">
</div>
</div>
</div>