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
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_POST['id_inv'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_galpao="select date_format(t1.dt_inicio,'%d/%m/%Y') as dt_inicio, date_format(t1.dt_fim,'%d/%m/%Y') as dt_fim, t2.nome
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.id = '$id_inv' and t1.fl_empresa = '$cod_cli' and t1.fl_status <>  'E'";
$res_galpao=mysqli_query($link, $query_galpao);
while ($galpao=mysqli_fetch_assoc($res_galpao)) {
	$dt_inicio = $galpao['dt_inicio'];
	$dt_fim = $galpao['dt_fim'];
	$nome = $galpao['nome'];
}

$SQL = "select t1.id_produto, t1.id_inv, sum(t2.cont_2) as saldo, sum(coalesce(t2.cont_3,0)) as saldo_2, t3.cod_prod_cliente, t3.nm_produto
from tb_inv_tarefa t1
left join tb_inv_conf t2 on t1.id = t2.id_tar
left join tb_produto t3 on t1.id_produto = t3.cod_produto
where t1.id_inv= '$id_inv' and t1.fl_status = 'X' and t1.fl_empresa = '$cod_cli' and t1.id_produto > 0
group by t1.id_produto";
$res_saldo = mysqli_query($link,$SQL); 

$link->close();
?>
<div id="content">
	<section id="widget-grid" class="">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget well jarviswidget-color-darken" id="wid-id-0" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false">
					<div>
						<div class="jarviswidget-editbox">
						</div>
						<div class="widget-body no-padding">
							<div class="widget-body-toolbar" id="toolbar">
								<div class="row">
									<div class="col-sm-4">
									</div>
									<div class="col-sm-8 text-align-right">
										<div class="btn-group">
											<button type="submit" class="btn btn-success" id="RepEstoqGenExcel" style="float:right;width: 100px">Excel</button>
										</div>
									</div>

									<div id="retorno"></div>
								</div>
							</div>

							<div id="reportSalEstoque">
								<div class="padding-10">
									<div class="pull-left">
										<img src="img/Logo3C.jpg" width="80" height="32" alt="Gisis">
										<address>
											<br>
											<strong>3C Services</strong>
										</address>
									</div>
									<div class="pull-right">
										<h1 class="font-200">Relatório de encerramento de inventário</h1>
									</div>
									<div class="clearfix"></div>
									<br>
									<br>
									<div class="row">
										<div class="col-sm-12">
											<div>
												<div class="col-sm-8">
													<strong>Data inicial :</strong>
													<span><i class="fa fa-calendar"></i> <?php echo $dt_inicio;?> |</span>
													<strong>Data final :</strong>
													<span> <i class="fa fa-calendar"></i> <?php echo $dt_fim;?> |</span>
													<strong>Armazém :</strong>
													<span> <?php echo $nome;?> </span>
												</div>
												<div class="col-sm-4 ">

													<span class="pull-right"><i class="fa fa-calendar"></i> <?php echo $date;?></span>
													<strong class="pull-right">Data do relatório :</strong>
												</div>
											</div>
											<br><br>
										</div>
									</div>
									<table class="table table-hover" style="width: 800px;">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th>PRODUTO</th>
												<th>DESCRIÇÃO</th>
												<th>SALDO TOTAL</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											while ($dados=mysqli_fetch_assoc($res_saldo)) {
												?>
												<tr>
													<td style="text-align: center;">
														<button type="submit" class="btn btn-primary btn-xs" id="btnDtlInvTar" value="<?php echo $dados['id_produto']; ?>" data-inv="<?php echo $dados['id_inv']; ?>" style="width: 80px">DETALHE</button>
													</td>
													<td class="text-center"><?php echo $dados['cod_prod_cliente'];?></td>
													<td><?php echo $dados['nm_produto'];?></td>
													<td style="text-align: right;"><?php echo $dados['saldo'];?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>

									<div class="invoice-footer">

										<div class="row">

											<div class="col-sm-7"></div>
											<div class="col-sm-5"></div>

										</div>

										<div class="row">
											<div class="col-sm-12"></div>
										</div>

									</div>
								</div>
	<div id="retModInv"></div>
							</div>
						</div>
					</div>
				</div>
			</article>

		</div>
	</section>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#RepEstoqGenExcel', function(){
            event.preventDefault();
            var today = new Date();
            $("#reportSalEstoque").table2excel({
                exclude: ".noExl",
                name: "Consulta fechamento de inventário - Analítico",
                filename: "Consulta fechamento de inventário - Analítico - " + today //do not include extension
            });

        });
    });
</script>

<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="data/movimento/relatorio/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.2/jspdf.plugin.autotable.js"></script>
<script type="text/javascript">

	function pdfToHTML(){
		var pdf = new jsPDF('l', 'pt', 'a4');
		source = $('#reportSalEstoque')[0];
		hide = {
			'#toolbar': function(element, renderer){
				return true
			}
		}
		margins = {
		    top: 15,
		    left: 15,
		    width: 180
		  };
		
		pdf.fromHTML(
		  	source // HTML string or DOM elem ref.
		  	, margins.left // x coord
		  	, margins.top // y coord
		  	, {
		  		'width': margins.width // max width of content on PDF
		  		, 'elementHandlers': hide
		  	},
		  	function (dispose) {
		  	  // dispose: object with X, Y of the last line add to the PDF
		  	  //          this allow the insertion of new lines after html
		        pdf.save('Relatorio_de_saldo_de_estoque.pdf');
		      }
		  )
		}
	</script-->
<!--script type="text/javascript">
	function PDFId() {
    var div = document.getElementById("reportSalEstoque").innerHTML;
    //document.getElementById("hiddenhtml").value = elem;
}
</script-->
<?php 

/*
use Dompdf\Dompdf;

$dompdf = new DOMPDF();

$dompdf->load_html('div');

$dompdf->render();

$dompdf->stream(
	array(

		"attachment" => false
	)

);
*/
?>