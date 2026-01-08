<div class="portlet-body" style="overflow-x: auto">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th> Código SAP</th>
                                    <th> Descrição </th>
                                    <th> Quantidade </th>
                                    <th> Saldo </th>
                                    <th> Qtd Coletada  </th>
                                    <th> #  </th>
                                </tr>
                            </thead>
                            <tbody><?php
                                while($dados = mysqli_fetch_assoc($res)) {?>
                                <tr class="odd gradeX">
                                    <td> 
                                        <?php echo $dados['cod_produto']; ?> 
                                        <input type="hidden" name="cod_prod_cliente" id="cod_prod_cliente" value="<?php echo $dados['cod_produto']; ?>">
                                    </td>
                                    <td> <?php echo $dados['nm_produto']; ?> </td>
                                    <td>  </td>
                                    <td> <?php echo $dados['saldo']; ?> </td>
                                    <td><input type="text" id="nr_qtde_pedido" name=""></td>
                                    <td style="text-align: center; width: 5px">
                                        <input type="hidden" name="nr_pedido" id="nr_pedido" value="<?php echo $nr_pedido;?>">  
                                        <button type="submit" id="btnInsertPrdPedido" class="btn btn-primary btn-xs" value="">Inserir</button>
                                    </td>
                                </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>