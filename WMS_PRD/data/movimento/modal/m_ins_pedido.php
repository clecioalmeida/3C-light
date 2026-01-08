<div class="modal fade" id="novo_pedido" aria-hidden="true">
 <form method="post" action="" id="formInsPedido">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Novo pedido</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">                
        <div class="portlet-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="emissor">Emissor</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="emissor" value="">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="conferente">Conferente</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="conferente">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form_control_cliente">Cliente</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="form_control_cliente" value="<?php echo $cteep; ?>">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="solicitante">Solicitante</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="solicitante" value="<?php echo $nm_aprovacao;?>">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="caption font-green-haze">
                    <i class="icon-settings font-green-haze"></i>
                    <span class="caption-subject bold uppercase"> Destinatário:   </span>
                    <br />
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="cod_cliente">Razão Social</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="r_social" value="<?php echo $nm_cliente; ?>" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-1 control-label" for="cnpj">CNPJ</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="cnpj" value="<?php echo $nr_cnpj_cpf; ?>">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-1 control-label" for="i_est">I.E.</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" value="<?php echo $ds_ie_rg; ?>">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="caption font-green-haze">
                    <i class="icon-settings font-green-haze"></i>
                    <span class="caption-subject bold uppercase"> Modal:   </span>
                    <br />
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="modal">Modalidade</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="modal" value="<?php echo $ds_modalidade; ?>">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="fl_tipo">Tipo</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="fl_tipo" value="<?php echo $nm_tipo; ?>">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="frete">Pagador do frete</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="modal" value="<?php echo $ds_frete; ?>">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="d_limite">Data limite</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control data" id="d_limite" value="<?php 
                                           if($dt_limite == 0){
                                             echo '';
                                            }else{
                                            echo date("d/m/Y", strtotime($dt_limite)); 
                                            }
                                            ?>">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="h_limite">Hora limite</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control hora" id="h_limite" value="<?php echo $hr_limite;?>">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="h_limite"></label>
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 control-label" for="p_obs">Observações</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="p_obs">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="p_obs">Doca</label>
                <div class="col-sm-2	">
                    <input type="text" class="form-control" id="p_obs" value="<?php echo $ds_doca;?>">
                    <div class="form-control-focus"> </div>
                </div>
                    </div>
                    <legend>Produtos</legend>
                    <div class="portlet-body" style="overflow-x: auto">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th> Código SAP</th>
                                    <th> Descrição </th>
                                    <th> Quantidade </th>
                                    <th> Qtd Coletada  </th>
                                    <th> #  </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                while($dados_produto=mysqli_fetch_assoc($res_produto)){
                                    $produto = $dados_produto['nm_produto'];
                            ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $dados_produto['cod_prod_cliente']; ?> </td>
                                    <td> <?php echo $dados_produto['nm_produto']; ?> </td>
                                    <td> <?php echo $dados_produto['nr_qtde']; ?></td>
                                    <td>  </td>
                                    <td style="text-align: center; width: 5px">  
                                        <button type="submit" id="btnDelRec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">Excluir</button>
                                    </td>
                                </tr>
                               <?php } ?> 
                            </tbody>
                        </table>
                        <legend>Nota fiscal de saída</legend>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1" style="width: 500px">
                            <thead>
                                <tr>
                                    <th> Nota fiscal </th>
                                    <th> Série </th>
                                    <th> Enissão </th>
                                    <th> Valor total </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX">
                                    <td>  </td>
                                    <td>  </td>
                                    <td>  </td>
                                    <td>  </td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
        <!--button type="submit" class="btn btn-primary" id="btnFormUpdPedido">Salvar</button-->
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
 </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#detalhe_pedido').modal('show');
    });
</script>