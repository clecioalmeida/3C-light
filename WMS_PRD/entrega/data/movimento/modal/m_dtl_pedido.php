<?php 
//$login  = $_SESSION["usuario"];
//$nr_pedido = $_GET['nr_pedido'];

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = mysqli_real_escape_string($link, $_POST["dtl_ped"]);

$select_pedido = "select t1.*, t2.cod_produto, t2.cod_prod_cliente, t3.nm_cliente, t3.nr_cnpj_cpf, t3.ds_ie_rg, t4.nm_tipo, t5.ds_doca
from tb_pedido_coleta t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_cliente t3 on t1.cod_cliente = t3.cod_cliente
left join tb_tipo t4 on t1.ds_tipo = t4.cod_tipo
left join tb_doca t5 on t1.id_doca = t5.id
where t1.nr_pedido ='$nr_pedido'";
$res_pedido = mysqli_query($link,$select_pedido);
while($dados_pedido=mysqli_fetch_assoc($res_pedido)){
        $nm_cliente=$dados_pedido["nm_cliente"];
        $ds_modalidade = $dados_pedido["ds_modalidade"];
        $dt_limite = $dados_pedido["dt_limite"];
        $hr_limite = $dados_pedido["hr_limite"];
        $cod_cliente = $dados_pedido["cod_cliente"];
        $produto = $dados_pedido["produto"];
        $nm_tipo = $dados_pedido["nm_tipo"];
        $ds_frete = $dados_pedido["ds_frete"];
        $nm_aprovacao = $dados_pedido['nm_aprovacao'];
        $nr_cnpj_cpf = $dados_pedido['nr_cnpj_cpf'];
        $ds_ie_rg = $dados_pedido['ds_ie_rg'];
        $pedido=$dados_pedido["nr_pedido"];
        $ds_doca=$dados_pedido["ds_doca"];
    }

$select_dest = "select t1.nm_cliente, t1.nr_cnpj_cpf, t1.ds_ie_rg
from tb_cliente t1
left join tb_pedido_coleta t2 on t1.nr_cnpj_cpf = t2.cod_cliente
 where t2.nr_pedido = '$nr_pedido'";
$res_dest = mysqli_query($link,$select_dest);
while($dados_cliente=mysqli_fetch_assoc($res_dest)){
        $cliente=$dados_cliente["nm_cliente"];
        $cnpj=$dados_cliente["nr_cnpj_cpf"];
        $ie=$dados_cliente["ds_ie_rg"];
        
    }

$select_produto = "select t1.cod_produto, t1.nm_produto, t2.produto, t1.cod_prod_cliente, t2.nr_qtde, t2.nr_lote, t3.dt_validade from tb_produto t1 left join tb_pedido_coleta t2 on t1.cod_produto = t2.produto left join tb_nf_entrada_item t3 on t2.nr_lote = t3.nr_lote where t2.nr_pedido = '$nr_pedido'";
$res_produto = mysqli_query($link,$select_produto);


$select_tipo = "select * from tb_tipo where ds_tipo = 2";
$res_tipo = mysqli_query($link,$select_tipo);


$select_cliente = "select nm_cliente from tb_cliente where cod_cliente = 110";
$res_cliente = mysqli_query($link,$select_cliente);
while($dados_cliente=mysqli_fetch_assoc($res_cliente)){
    $cteep = $dados_cliente['nm_cliente'];
    }
$sql_dest = "select cod_cliente, nm_cliente from tb_cliente where cod_cli is null and fl_tipo = 'D'";
$res_dest = mysqli_query($link,$sql_dest);
?>
<div class="modal fade" id="detalhe_pedido" aria-hidden="true">
 <form method="post" action="" id="formNUpdPedido">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pedido número:</h5>
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
      <div class="modal-footer">
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