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
  require_once('bd_class_dsv.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $nr_pedido = $_POST["nr_pedido"];
   
$link->close();
?>
<div class="modal fade" id="prd_pedido" aria-hidden="true">
    <form method="post" action="" id="formInsPrdPedido">
        <input type="hidden" name="nr_pedido" id="nr_pedido" value="<?php echo $nr_pedido;?>">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" style="color: white"> Inserir produtos no pedido: <?php echo $nr_pedido;?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                  </div>
			      <div class="modal-body modal-lg" style="overflow-y: auto">
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form method="POST" id="formPesquisaProduto" action=""><br><br>
							<fieldset>
								<div class="row">
									<div class="col-sm-4" style="text-align: right;">
										<div class="form-group">
											<input type="btn" id="cod_prod_cliente" name="cod_prod_cliente" class="form-control" aria-describedby="basic-addon2" placeholder="Código SAP">
										</div>
									</div>
									<div class="col-sm-4" style="text-align: right;">
										<div class="form-group">
											<input type="btn" id="nm_produto" name="nm_produto" class="form-control" aria-describedby="basic-addon2" placeholder="Nome do produto">
										</div>
									</div>
								</div> 
								<button type="submit" id="btnConsultaProduto" class="btn btn-primary btn-sm" value="">Pesquisar</button>
							</fieldset><br><br>
						</form>
					<div id="ret_conf"></div>
					</article>
				</div>
			    <div class="modal-footer" style="background-color: #2F4F4F;">
			    	<button type="button" id="btnCloseMdInsPedido">Fechar</button>
			        <!--a href="data/movimento/session.php">Fechar</a-->
			    </div>
			 </div>
		</div>
     </form>
</div><!--Fim modal-->
<script>
  $(document).ready(function () {
    $('#prd_pedido').modal('show');

  });
  $(document).on('click', '#btnCloseMdInsPedido', function(){
	event.preventDefault();
	$('#retorno').load('data/movimento/modal/m_conf_saida_pedido.php');
  });
</script>