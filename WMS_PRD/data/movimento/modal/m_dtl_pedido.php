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

$nr_pedido = mysqli_real_escape_string($link, $_POST["dtl_ped"]);

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

$query_emissor="select nm_cliente from tb_cliente where cod_cliente = '$id'";
$res_emissor = mysqli_query($link,$query_emissor);
while($dados=mysqli_fetch_assoc($res_emissor)){
    $emissor=$dados['nm_cliente'];
}

$select_pedido = "select t1.*, t6.cod_produto, t6.cod_prod_cliente, t3.nm_cliente, t3.nr_cnpj_cpf, t3.ds_ie_rg, t4.nm_tipo, t5.ds_doca, t5.fl_tipo
from tb_pedido_coleta t1
left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido
left join tb_cliente t3 on t1.cod_cliente = t3.cod_cliente
left join tb_tipo t4 on t1.fl_tipo = t4.cod_tipo and t1.fl_tipo = t4.cod_tipo
left join tb_doca t5 on t1.id_doca = t5.id
left join tb_produto t6 on t2.produto = t6.cod_produto
where t1.nr_pedido = '$nr_pedido'";
$res_pedido = mysqli_query($link,$select_pedido);
while($dados_pedido=mysqli_fetch_assoc($res_pedido)){
    $nm_cliente=$dados_pedido["nm_cliente"];
    $ds_modalidade = $dados_pedido["ds_modalidade"];
    $dt_limite = $dados_pedido["dt_limite"];
    $hr_limite = $dados_pedido["hr_limite"];
    $cod_cliente = $dados_pedido["cod_cliente"];
    $produto = $dados_pedido["cod_produto"];
    $nm_tipo = $dados_pedido["nm_tipo"];
    $ds_frete = $dados_pedido["ds_frete"];
    $nm_aprovacao = $dados_pedido['nm_aprovacao'];
    $nr_cnpj_cpf = $dados_pedido['nr_cnpj_cpf'];
    $ds_ie_rg = $dados_pedido['ds_ie_rg'];
    $pedido=$dados_pedido["nr_pedido"];
    $ds_doca=$dados_pedido["ds_doca"];
    $fl_tipo=$dados_pedido["fl_tipo"];
    $fl_status=$dados_pedido["fl_status"];
    $nm_usuario=$dados_pedido["nm_usuario"];
}

$select_dest = "select t1.nm_cliente, t1.nr_cnpj_cpf, t1.ds_ie_rg
from tb_cliente t1
left join tb_pedido_coleta t2 on t1.cod_cliente = t2.cod_cliente
where t2.nr_pedido = '$nr_pedido'";
$res_dest = mysqli_query($link,$select_dest);
while($dados_cliente=mysqli_fetch_assoc($res_dest)){
    $cliente=$dados_cliente["nm_cliente"];
    $cnpj=$dados_cliente["nr_cnpj_cpf"];
    $ie=$dados_cliente["ds_ie_rg"];
    
}

$reservado="select sum(nr_qtde) as reservado from tb_pedido_coleta_produto where produto = '$produto'";
$res_reservado=mysqli_query($link, $reservado);
while ($saldo_reservado=mysqli_fetch_assoc($res_reservado)) {
    $reservado=$saldo_reservado['reservado'];
}

$select_produto = "select t2.nr_qtde as qtde, t3.nm_produto, t3.cod_produto, t3.cod_prod_cliente
from tb_pedido_coleta_produto t2
left join tb_produto t3 on t2.produto = t3.cod_produto
where t2.nr_pedido = '$nr_pedido' and t2.fl_status <> 'D'
group by t2.produto";
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

$sql_nfs = "select nr_nf_formulario, nr_serie, dt_emissao, vl_mercadoria from tb_nf_saida where nr_pedido = '$nr_pedido'";
$res_nfs = mysqli_query($link,$sql_nfs);

$select_usr = "select t1.nm_cliente
from tb_cliente t1
left join tb_pedido_coleta t2 on t1.cod_cliente = t2.nm_usuario
where t2.nr_pedido = '$nr_pedido'";
$res_usr = mysqli_query($link,$select_usr);
while($dados_usr=mysqli_fetch_assoc($res_usr)){
    $usr=$dados_usr["nm_cliente"];        
}
$link->close();
?>
<div class="modal fade" id="detalhe_pedido" tabindex="1" aria-hidden="true">
   <form method="post" action="" id="formNUpdPedido">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #2F4F4F;">
            <h5 class="modal-title" style="color: white">Pedido número: <?php echo $nr_pedido;?></h5>
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
                            <input type="text" class="form-control" id="emissor" value="<?php echo $usr;?>">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-2 control-label" for="conferente">Conferente</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="conferente">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                </div><br>
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
                </div><br>
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
                    </div><br>
                    <div class="row">
                        <label class="col-sm-2 control-label" for="p_obs">Observações</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="p_obs">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-2 control-label" for="p_obs">Doca</label>
                        <div class="col-sm-2	">
                            <input type="text" class="form-control" id="p_obs" value="<?php echo $ds_doca." - ".$fl_tipo;?>">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div><br>
                    <!--h3 style="background-color: #4682B4;color:white">Produtos</h3-->
                    <legend>Produtos</legend>
                    <!--button type="submit" id="btnDtlInsProdPed" class="btn btn-primary btn-xs" value="<?php echo $nr_pedido; ?>">Novo produto</button-->
                    <h5>Novo produto</h5><br>
                    <div id="novoProduto">
                        <form id="formInsPedido">
                            <fieldset>
                                <div class="row">
                                    <div class="col-sm-2" style="text-align: left;">
                                        <label class="col-sm-2 control-label" for="prod_cliente">Cód.SAP</label>
                                        <div class="form-group">
                                            <input type="btn" id="prod_cliente" name="cod_prod_cliente" class="form-control" aria-describedby="basic-addon2">
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="text-align: right;">
                                        <label class="col-sm-2 control-label" for="prdEstoque">Estoque</label>
                                        <div class="form-group" id="prd_estoque">
                                            <input type="btn" id="prdEstoque" name="prdEstoque" class="form-control" aria-describedby="basic-addon2" readonly="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="text-align: right;">
                                        <label class="col-sm-2 control-label" for="prdReservado">Reservado</label>
                                        <div class="form-group" id="prd_reservado">
                                            <input type="btn" id="prdReservado" name="prdReservado" class="form-control" aria-describedby="basic-addon2" readonly="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="text-align: right;">
                                        <label class="col-sm-2 control-label" for="prdSaldo">Saldo</label>
                                        <div class="form-group" id="prd_saldo">
                                            <input type="btn" id="prdSaldo" name="prdSaldo" class="form-control" aria-describedby="basic-addon2" readonly="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="text-align: right;">
                                        <label class="col-sm-2 control-label" for="prd_qtde">Qtde</label>
                                        <div class="form-group">
                                            <input type="btn" id="prd_qtde" name="prd_qtde" class="form-control" aria-describedby="basic-addon2">
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="text-align: right;">
                                        <label class="col-sm-2 control-label" for=""></label>
                                        <div class="form-group">
                                            <button type="submit" id="btnInsertPrdPedidoDtl" class="btn btn-success btn-sm" value="" style="width: 100px;margin-top: 15px">Salvar</button>
                                            <input type="hidden" id="prd_pedido" name="prd_pedido" value="<?php echo $nr_pedido;?>">
                                        </div>
                                    </div>

                                    <div id="retNmProduto"></div>
                                </div>
                                <div id="retProduto"></div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="portlet-body" id="prdPedido" style="overflow-x: auto">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th> Código</th>
                                    <th> Código SAP</th>
                                    <th> Descrição </th>
                                    <th> Reservado  </th>
                                    <th colspan="3"> Ações </th>
                                </tr>
                            </thead>
                            <tbody id="retPrdPedido">
                                <?php 
                                while($dados_produto=mysqli_fetch_assoc($res_produto)){
                                    $produto = $dados_produto['nm_produto'];
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="atualiza"> <?php echo $dados_produto['cod_produto']; ?> </td>
                                        <td class="atualiza"> <?php echo $dados_produto['cod_prod_cliente']; ?> </td>
                                        <td class="atualiza"> <?php echo $dados_produto['nm_produto']; ?> </td>
                                        <td class="atualiza" style="text-align: right;"> <?php echo $dados_produto['qtde']; ?> </td>
                                        <td class="atualiza" class="noExl" style="text-align: center; width: 5px"><button type="submit" id="btnDtlProdPedido" class="btn btn-primary btn-xs" value="<?php echo $dados_produto['cod_produto']; ?>">Detalhe</button></td>
                                        <td class="atualiza" class="noExl" style="text-align: center; width: 5px">
                                            <input type="hidden" id="nrPedidoProd" value="<?php echo $nr_pedido;?>" name="">
                                            <button type="submit" id="btnUpdQtdeProdPedido" class="btn btn-primary btn-xs" value="<?php echo $dados_produto['cod_produto']; ?>">Alterar Qtde</button>
                                        </td>
                                        <td class="atualiza" style="text-align: center; width: 5px">  
                                            <button type="submit" id="btnDelProdPedido" class="btn btn-primary btn-xs" value="<?php echo $dados_produto['cod_produto']; ?>">Excluir</button>
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
                                    <th> Emissão </th>
                                    <th> Valor total </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while($dados_nfs=mysqli_fetch_assoc($res_nfs)){
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $dados_nfs['nr_nf_formulario']; ?></td> 
                                        <td><?php echo $dados_nfs['nr_serie']; ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($dados_nfs['dt_emissao'])); ?></td>
                                        <td><?php echo $dados_nfs['vl_mercadoria']; ?></td>
                                    </tr> 
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                    <div id="res_produto_dtl"></div>
                    <div id="res_produto_upd"></div>
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