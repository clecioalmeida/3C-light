<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id=$_SESSION["id"];
}
?>
<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

//$cod_produto = mysqli_real_escape_string($link,$_POST['cod_produto']);
//$qtd = mysqli_real_escape_string($link,$_POST['qtd']);
$nr_pedido = mysqli_real_escape_string($link,$_POST['pedido']);

//$query_prd="select nm_produto from tb_produto where cod_produto = '$cod_produto'";
//$res_prd=mysqli_query($link, $query_prd);
//while ($dados=mysqli_fetch_assoc($res_prd)) {
//	$produto = $dados['nm_produto'];
//}

$query_conf="select sum(nr_qtde) as nr_qtde, coalesce(sum(nr_qtde_exp),0) as nr_qtde_exp from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido'";
$res_conf=mysqli_query($link, $query_conf);

while ($totalconf=mysqli_fetch_assoc($res_conf)) {
	$conf=$totalconf['nr_qtde_exp'];
	$nr_qtde=$totalconf['nr_qtde'];
}

$link->close();
?>
<div class="modal fade in" id="confPicking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					×
				</button>
				<h4 class="modal-title" id="myModalLabel">Pedido: <?php echo $nr_pedido;?> - Qtde: <?php echo $nr_qtde;?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div>
						<h4 id="">Total:<?php echo number_format($nr_qtde,0,",","");?></h4>
					</div>

					<div class="conferido" id="conferido">
						<h4 id="TotalConferido">Conferido:<?php echo number_format($conf,0,",","");?></h4>
					</div>

					<!--h4>Conferido:</h4><input type="text" class="conferido" name="" id="TotalConferido" value="<?php echo $conf;?>"-->
				</div>
				<div class="row">
					<form id="form_conf" method="" action="">
						<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" name="nr_qtde" id="nr_qtde" value="<?php echo $nr_qtde; ?>">
								<input type="text" id="barcode" name="barcode" class="form-control" required="">
							</div>
							<div class="form-group">
								<!--button type="submit" id="submit" class="btn btn-success btn-sm">
									<span class="glyphicon glyphicon-floppy-disk"></span> Salvar
								</button-->
							</div>
						</div>

					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="closeModal">
					Fechar
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</form>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#confPicking').modal('show');
		$('.produto').hide();
	});

	$(document).ready(function(){
		$(document).on('change','#barcode',function(event){
			event.preventDefault();
			var barcode = $('#barcode').val();
			var pedido = "<?php echo $nr_pedido;?>";
			if($('#barcode').val() == ''){
				alert("Favor bipar o volume!");
			} else {
				$.ajax
				({
					url:"xhr/conf_exp.php",
					method: "POST",
					dataType:'json',
					data:{barcode:barcode,pedido:pedido},
					success:function(j){
						$('#form_conf')[0].reset();
			                    $('#barcode').focus();
			                    for(var i=0;i < j.length;i++){
			                    	var total_conf = "Conferido:"+j[i].info;
			                    	$('#TotalConferido').html(total_conf);
								}
							}
						});
				return false;
			}
		});

		$(document).on('click', '#closeModal',function() {
			window.location.href = "expede_pedido.php?nr_pedido=<?php echo $nr_pedido;?>";
		});
	});

</script>