<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #FFA07A">
                        <h4 class="modal-title" id="myModalLabel">Erro!</h4>
                    </div>
                    <div class="modal-body">                                
                        <?php echo "<h3>Pedidos finalizados não podem ter quantidades alteradas. Nesse caso cancele o pedido ou informe quebra de estoque.</h3>"; ?>
                        <?php echo $cod_estoque; ?>

                        <div>
                            <a href="updt_estoque.php?cod_estoque=<?php echo $cod_estoque;?>&cont1=<?php echo $cont1;?>&id_inv=<?php echo $id_inv ;?>&id_tar=<?php echo $id_tar;?>"><button type="button" class="btn btn-danger">Sim</button></a>
                            <a href=""><button type="button" class="btn btn-success">Não</button></a>
                        </div>

                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>     
        <script>
            $(document).ready(function () {
                $('#conf_cadastro').modal('show');
            });
        </script>