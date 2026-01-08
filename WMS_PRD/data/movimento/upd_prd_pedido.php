<?php 
  require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $cod_ped = $_POST["cod_ped"];

    $status="select fl_status, produto from tb_pedido_coleta_produto where cod_ped = '$cod_ped'";
    $res_status = mysqli_query($link,$status); 
    while ($dados=mysqli_fetch_assoc($res_status)) {
    	$fl_status=$dados['fl_status'];
    	$produto=$dados['produto'];
    }
   
    if($fl_status == 'M' || $fl_status == 'A'){
    	$sel_prod="select sum(t1.nr_qtde) as alocado, t2.nr_qtde as reservado, t3.nm_produto, t3.cod_produto, t3.cod_prod_cliente, t2.nr_pedido
            from tb_posicao_pallet t1
            left join tb_pedido_coleta_produto t2 on t1.produto = t2.produto
            left join tb_produto t3 on t1.produto = t3.cod_prod_cliente
            where t2.cod_ped = '$cod_ped'";
    $res = mysqli_query($link,$sel_prod); 

    }else{
    	
    	echo "Pedidos nesse status não podem ser alterados.";
    }

    

$link->close();
?>
<div class="modal fade" id="upd_prd_pedido" aria-hidden="true">
    <form class="form-horizontal" method="post" action="" id="formInsPrdPedido">
        <input type="hidden" name="nr_pedido" value="<?php echo $nr_pedido;?>">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" style="color: white"> Inserir produtos no pedido: </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                  </div>
			      <div class="modal-body modal-lg" style="overflow-y: auto">
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form method="POST" id="formPesquisaProduto" action=""><br><br>
							<fieldset>
							    <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							        <thead>
							            <tr>
							                <th> Código SAP</th>
							                <th> Descrição </th>
							                <th> Alocado </th>
							                <th> Reservado </th>
							                <th> Saldo  </th>
							                <th> Nova Qtde  </th>
							                <th> #  </th>
							            </tr>
							        </thead>
							        <tbody><?php
							            while($dados = mysqli_fetch_assoc($res)) {

							            	$saldo = $dados['alocado']-$dados['reservado'];

							            	?>
							            <tr class="odd gradeX">
							                <td> 
							                    <?php echo $dados['cod_produto']; ?> 
							                    <input type="hidden" name="cod_produto" id="cod_produto" value="<?php echo $dados['cod_produto']; ?>">
							                </td>
							                <td> <?php echo $dados['nm_produto']; ?> </td>
							                <td style="text-align: right;"> <?php echo  number_format($dados['alocado'], 0, ',', '.'); ?>  </td>
							                <td style="text-align: right;"> <?php echo $dados['reservado']; ?> </td>
							                <td id="nr_saldo_upd" style="text-align: right;"> <?php echo $saldo; ?> </td>
							                <td>
							                	<input type="text" id="nr_new_qtde_pedido" name="" required="true" style="text-align: right;">
							                </td>
							                <td style="text-align: center; width: 5px">
							                    <form method="POST" id="formUpdPrdPedidoDtl" action="">
							                        <input type="hidden" name="nr_pedido" id="nrPedidoNewQtde" value="<?php echo $dados['nr_pedido'];?>">  
							                        <button type="submit" id="btnUpdPrdPedidoQtde" value="<?php echo $cod_ped; ?>" class="btn btn-primary btn-xs" value="">Alterar</button>
							                    </form>
							                </td>
							            </tr>
							            <?php } ?> 
							        </tbody>
							    </table>
							</fieldset>
						</form>
					<div id="res_produto"></div>
					</article>
				</div>
			    <div class="modal-footer" style="background-color: #2F4F4F;">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			    </div>
			 </div>
		</div>
     </form>
</div>
<script>
  $(document).ready(function () {
    $('#upd_prd_pedido').modal('show');
  });
</script>