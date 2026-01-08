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

$cod_produto = mysqli_real_escape_string($link,$_POST['cod_produto']);
$rua = mysqli_real_escape_string($link,$_POST['rua']);
$col = mysqli_real_escape_string($link,$_POST['col']);
$alt = mysqli_real_escape_string($link,$_POST['alt']);
$qtd = mysqli_real_escape_string($link,$_POST['qtd']);
$galpao = mysqli_real_escape_string($link,$_POST['galpao']);
$nr_pedido = mysqli_real_escape_string($link,$_POST['pedido']);

$query_local="select ds_apelido from tb_armazem where id = '$galpao'";
$res_local=mysqli_query($link, $query_local);
while ($dados=mysqli_fetch_assoc($res_local)) {
	$nome = $dados['ds_apelido'];
}

$local=$nome.$rua.$alt.$col;

$query_prd="select nm_produto from tb_produto where cod_produto = '$cod_produto'";
$res_prd=mysqli_query($link, $query_prd);
while ($dados=mysqli_fetch_assoc($res_prd)) {
	$produto = $dados['nm_produto'];
}

?>
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					×
				</button>
				<h4 class="modal-title" id="myModalLabel">Produto: <?php echo $produto;?> - Qtde: <?php echo $qtd;?></h4>
			</div>
			<div class="modal-body">
				<legend>Selecione o endereço</legend>
				<div class="row">
					<form id="form_conf_end" method="" action="">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" id="local" name="local" class="form-control" required="true">
							</div>
							<div class="form-group">
								<!--button type="btnFormConfEnd" id="submit" class="btn btn-success btn-sm">
									<span class="glyphicon glyphicon-floppy-disk"></span> Salvar
								</button-->
							</div>
						</div>
					</form>
				</div>
				<h2 id="retExpEnd"></h2>
				<div class="produto">
				<legend>Selecione o produto</legend>
					<div class="row" id="confProdPick">
							<div>
								<h4 id="">Total:<?php echo $qtd;?></h4>
							</div>
							
							<div class="conferido" id="conferido">
								<h4 id="TotalConferido">Conferido:</h4>
							</div>
						<form id="form_conf_prod" method="" action="">
							<div class="col-md-12">
								<div class="form-group">
									<input type="text" id="barcode" name="barcode" class="form-control" required="true">
								</div>
								<div class="form-group">
									<button type="btnFormConfProd" id="submit" class="btn btn-success btn-sm">
										<span class="glyphicon glyphicon-floppy-disk"></span> Salvar
									</button>
								</div>
							</div>
						</form>
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
<script type="text/javascript">
	$(document).ready(function () {
        $('#myModal').modal('show');
        $('.produto').hide();
    });

    $(document).ready(function(){
    	$('#local').change(function(event){
    		event.preventDefault();
        	$('#retExpEnd').hide();
    		var pedido = "<?php echo $nr_pedido;?>";    		
	        var prd = "<?php echo $cod_produto;?>";
    		var end = "<?php echo $local;?>";
    		var local = $('#local').val();
    		if($('#local').val() == ''){
	            alert("Favor bipar o endereço!");
	        } else {
	        	$.ajax
	            ({
	                url:"xhr/conf_local.php",
	                method: "POST",
	                dataType: 'json',
	                data:{pedido:pedido,local:local,end:end,prd:prd},
	                success:function(j){
	                	
	                	for(var i=0;i < j.length;i++){
	                		var confirma = j[i].info
	                		if(confirma == 1){
	                			$('.produto').show();
	                			var total = "Conferido:"+j[i].total;
								$('#TotalConferido').html(total);
	                		}else{
			                    var retorno = "Atenção:"+j[i].info
			                    $('#retExpEnd').show();
								$('#retExpEnd').html(retorno);
	                		}
						}
	                }
	            });
	        }
    	});
    });
   
	$(document).ready(function(){
	    $('#barcode').change(function(event){
	        event.preventDefault();
	        var prd = "<?php echo $cod_produto;?>";
	        var galpao = "<?php echo $galpao;?>";
	        var rua = "<?php echo $rua;?>";
	        var col = "<?php echo $col;?>";
	        var alt = "<?php echo $alt;?>";
	        var barcode = $('#barcode').val();
    		var end = "<?php echo $local;?>";
	        var pedido = "<?php echo $nr_pedido;?>";
	        var qtd = "<?php echo $qtd;?>";
	        if($('#barcode').val() == ''){
	            alert("Favor bipar o volume!");
	        } else {
	        	if(prd == barcode){
		            $.ajax
		            ({
		                url:"xhr/conf_picking.php",
		                method: "POST",
		                dataType:'json',
		                data:{prd:prd,rua:rua,col:col,alt:alt,qtd:qtd,galpao:galpao,barcode:barcode,pedido:pedido},
		                success:function(j){
			                    $('#form_conf_prod')[0].reset();
			                    $('#myModal').modal('show');
					        	for(var i=0;i < j.length;i++){
			                    	var total = "Conferido:"+j[i].info;
									$('#TotalConferido').html(total);
							}
		                }
		            });

	        	}else{

	        		alert("Favor bipar o produto selecionado!");

	        	}
	        }
	    });

	});

</script>