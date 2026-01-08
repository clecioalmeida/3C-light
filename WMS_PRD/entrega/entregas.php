<?php
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

//$nr_pedido = $_POST['nr_pedido'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_ped = "select t1.*, t2.nm_cliente, t3.dt_limite, t2.ds_cidade, t3.hr_limite
from tb_nf_saida t1
left join tb_cliente t2 on t1.id_destinatario = t2.cod_cliente
left join tb_pedido_coleta t3 on t1.nr_pedido = t3.nr_pedido";
$res_ped = mysqli_query($link, $sql_ped);

?>
<?php echo include 'header.php'; ?>

<div id="main" role="main">
	<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
						<div role="content">
						<h4>Entregas</h4>
							<div class="jarviswidget-editbox">
							</div>
							<div class="widget-body">
								<form id="formPedido">
									<fieldset>
									</fieldset>
										<h2 class="fimPedido" id="retExpEnd1" style="background-color: #98FB98"></h2>
										<h2 class="fimPedido" id="retExpEnd2" style="background-color: #F08080"></h2>
									<fieldset>
										<table class="table table-hover" style="width: 100%">
											<thead>
												<tr>
													<th>DESTINO</th>
													<th>CIDADE</th>
													<th>DATA</th>
													<th>HORA LIMITE</th>
												</tr>
											</thead>
											<tbody>
												<?php
while ($dados = mysqli_fetch_assoc($res_ped)) {?>
												<tr class="tblRows">
													<td style="width: 200px"><?php echo $dados['nm_cliente']; ?></td>
													<td><?php echo $dados['ds_cidade']; ?></td>
													<td><?php echo date('d/m/Y', strtotime($dados['dt_limite'])); ?></td>
													<td><?php echo $dados['hr_limite']; ?></td>
												</tr>
												<?php }?>
											</tbody>
										</table>
									</fieldset>
									<h2 id="retConfPick"></h2>
								</form>
							</div>
						</div>
					</div>
				</article>
			</div>
		</section>
	</div>
</div>
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form id="form_conf" method="" action="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					×
				</button>
				<h4 class="modal-title" id="myModalLabel">Separação de volumes</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<input type="hidden" name="cod_nf_item" id="nr_pedido" value="">
							<input type="hidden" name="cod_nf" id="cod_produto" value="">
							<input type="text" id="barcode" name="barcode" class="form-control" required="true">
						</div>
						<div class="form-group">
							<button type="submit" id="submit" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-floppy-disk"></span> Salvar
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Fechar
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
	</form>
</div>
<!--script src="//code.jquery.com/jquery-1.11.2.min.js"></script-->
============================================== -->

<script type="text/javascript">
	$(document).ready(function(){
	     $( ".tblRows" ).click(function() {
	        var cod_produto = $(this).attr("data_prd");
	        var rua = $(this).attr("data_rua");
	        var col = $(this).attr("data_col");
	        var alt = $(this).attr("data_alt");
	        var qtd = $(this).attr("data_qtd");
	        var galpao = $(this).attr("data_glp");
	        var pedido = "<?php echo $nr_pedido; ?>";
	        $.ajax({
	            url:"xhr/m_conf_end.php",
	            method: "POST",
	            //dataType:'json',
	            data:{cod_produto:cod_produto,rua:rua,col:col,alt:alt,qtd:qtd,galpao:galpao,pedido:pedido},
	            success:function(data){
	                $('#retConfPick').html(data);
	            }
	        });
	    });
	});

	$(document).ready(function(){
		$('#retExpEnd1').hide();
		$('#retExpEnd2').hide();
	    $( '#btnFinConfPed').on('click', function() {
	    	event.preventDefault();
	    	var pedido = "<?php echo $nr_pedido; ?>";
		    	$.ajax({
		        url:"xhr/fin_conf_pedido.php",
		        method: "POST",
		        dataType:'json',
		        data:{pedido:pedido},
		        success:function(j){
					for(var i=0;i < j.length;i++){
					    var info = j[i].info;
					    if(info == 1){
					    	$('#retExpEnd1').show();
							$('#retExpEnd1').html("Pedido finalizado com sucesso!");

					    }else{
							$('#retExpEnd2').show();
							$('#retExpEnd2').html(info);

					    }
					}
				}
		    });
	   	});

	});

	$(document).ready(function(){
		$('#retExpEnd1').hide();
		$('#retExpEnd2').hide();
	    $( '#btnOcorConfPed').on('click', function() {
	    	event.preventDefault();
	    	var pedido = "";
		    	$.ajax({
		        url:"xhr/quebra_pedido.php",
		        method: "POST",
		        dataType:'json',
		        data:{pedido:pedido},
		        success:function(j){
					for(var i=0;i < j.length;i++){
					    var info = j[i].info;
					    if(info == 1){
					    	$('#retExpEnd1').show();
							$('#retExpEnd1').html("Quebra de estoque registrada!");

					    }else{
							$('#retExpEnd2').show();
							$('#retExpEnd2').html(info);

					    }
					}
				}
		    });
	   	});

	});
</script>

</body>

</html>