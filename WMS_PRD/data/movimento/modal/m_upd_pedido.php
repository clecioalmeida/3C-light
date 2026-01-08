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

$nr_pedido = mysqli_real_escape_string($link, $_POST["upd_ped"]);

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$select_pedido = "select t1.*, t2.cod_produto, t2.cod_prod_cliente, t3.nm_cliente, t3.nr_cnpj_cpf, t3.ds_ie_rg, t4.nm_tipo, t5.ds_doca
from tb_pedido_coleta t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_cliente t3 on t1.cod_cliente = t3.cod_cliente
left join tb_tipo t4 on t1.fl_tipo = t4.cod_tipo
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
    $fl_status=$dados_pedido["fl_status"];
}

if($fl_status != "A" && $fl_status != 'I'){

    echo "<script>alert('Somente pedidos com status ABERTO ou PENDENTE ($fl_status) podem ser alterados!');</script>";

    exit();
}
$select_usr = "select t1.nm_cliente
from tb_cliente t1
left join tb_pedido_coleta t2 on t1.cod_cliente = t2.nm_usuario
where t2.nr_pedido = '$nr_pedido'";
$res_usr = mysqli_query($link,$select_usr);
while($dados_usr=mysqli_fetch_assoc($res_usr)){
    $usr=$dados_usr["nm_cliente"];        
}

$select_dest = "select t1.nm_cliente, t1.nr_cnpj_cpf, t1.ds_ie_rg, t2.cod_cliente
from tb_cliente t1
left join tb_pedido_coleta t2 on t1.cod_cliente = t2.cod_cliente
where t2.nr_pedido = '$nr_pedido'";
$res_dest = mysqli_query($link,$select_dest);
while($dados_cliente=mysqli_fetch_assoc($res_dest)){
    $cod_cliente=$dados_cliente["cod_cliente"];
    $cliente=$dados_cliente["nm_cliente"];
    $cnpj=$dados_cliente["nr_cnpj_cpf"];
    $ie=$dados_cliente["ds_ie_rg"];

}

$select_produto = "select t1.cod_produto, t1.nm_produto, t2.produto, t1.cod_prod_cliente, t2.nr_qtde, t2.nr_lote, t3.dt_validade from tb_produto t1 left join tb_pedido_coleta t2 on t1.cod_produto = t2.produto left join tb_nf_entrada_item t3 on t2.nr_lote = t3.nr_lote where t2.nr_pedido = '$nr_pedido'";
$res_produto = mysqli_query($link,$select_produto);

$select_tipo = "select * from tb_tipo where ds_tipo = 2";
$res_tipo = mysqli_query($link,$select_tipo);

$select_doca = "select * from tb_doca";
$res_doca = mysqli_query($link,$select_doca);

$select_cliente = "select nm_cliente as cliente from tb_cliente where cod_cliente = 110";
$res_cliente = mysqli_query($link,$select_cliente);
while($dados_cliente=mysqli_fetch_assoc($res_cliente)){
    $cteep = $dados_cliente['cliente'];
}
$sql_dest = "select distinct nm_cliente, cod_cliente from tb_cliente where cod_cli is null and fl_tipo = 'D'";
$res_dest = mysqli_query($link,$sql_dest);

$sql_dest_pedido = "select distinct nm_cliente, cod_cliente from tb_cliente where cod_cli is null and fl_tipo = 'D'";
$res_dest = mysqli_query($link,$sql_dest);

$select_tipo = "select distinct(t1.nm_tipo), t1.cod_tipo from tb_tipo t1 left join tb_pedido_coleta t2 on t1.cod_tipo = t2.ds_tipo where t1.ds_tipo = 2";
$res_tipo = mysqli_query($link,$select_tipo); 
$link->close();
?>
<div class="modal fade" id="altera_pedido" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Pedido número: <?php echo $nr_pedido;?></h5>
        <input type="hidden" name="nr_pedido" id="nr_pedido" value="<?php echo $nr_pedido;?>">
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
    </div>
    <div class="modal-body modal-lg" style="overflow-y: auto"> 
        <div class="row">
            <div class="form-group">
                <label class="col-sm-2" for="emissor">Criado por:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="emissor" value="<?php echo $usr;?>" readonly="true">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2" for="conferente">Conferente</label>
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
                    <input type="text" class="form-control" id="form_control_cliente" value="<?php echo $cteep; ?>" readonly="true">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="solicitante">Solicitante</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="nm_aprovacao" id="nm_aprovacao" value="<?php echo $nm_aprovacao;?>">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="caption font-green-haze">
                <i class="icon-settings font-green-haze"></i>
                <span class="caption-subject bold uppercase"> Destinatário:   </span>
                <br />
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="cod_cliente">Razão Social</label>
                <div class="col-sm-4">
                    <select class="form-control" class="form-group" name="cod_cliente" id="cod_cliente">
                        <option value="<?php echo $cod_cliente; ?>"><?php echo $cliente;?></option>

                        <?php                                                           
                        while($dados_dest=mysqli_fetch_assoc($res_dest)) {?>
                            <option value="<?php echo $dados_dest['cod_cliente']; ?>">
                              <?php echo $dados_dest['nm_cliente']; ?>
                              </option> <?php } ?>
                          </select>
                          <div class="form-control-focus"> </div>
                      </div>
                      <label class="col-sm-1 control-label" for="cnpj">CNPJ</label>
                      <div class="col-sm-2" id="cnpjDest">
                        <input type="text" class="form-control" id="id_cnpj_dest" value="<?php echo $cnpj;?>">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-1 control-label" for="i_est">I.E.</label>
                    <div class="col-sm-2" id="ieDest">
                        <input type="text" class="form-control" value="<?php echo $ie;?>" id="id_ie_dest">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="caption font-green-haze">
                    <i class="icon-settings font-green-haze"></i>
                    <span class="caption-subject bold uppercase"> Modal:   </span>
                    <br />
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="modal">Modalidade</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="ds_modalidade" id="ds_modalidade">
                            <option value="<?php echo $ds_modalidade; ?>"><?php echo $ds_modalidade; ?></option>
                            <option value="ENTREGA">ENTREGA</option>
                            <option value="RETIRA">RETIRA</option>
                        </select>
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="fl_tipo">Tipo</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="fl_tipo" id="fl_tipo">
                            <option value="<?php echo $nm_tipo; ?>"><?php echo $nm_tipo; ?></option>
                            <?php

                            while ($dados_tipo=mysqli_fetch_assoc($res_tipo)) {?>

                                <option value="<?php echo $dados_tipo['cod_tipo']; ?>"><?php echo $dados_tipo['nm_tipo']; ?></option>

                            <?php } ?>
                        </select>
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="frete">Pagador do frete</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="ds_frete" id="ds_frete">
                            <option value="<?php echo $ds_frete; ?>"><?php echo $ds_frete; ?></option>
                            <option value="REMETENTE">REMETENTE</option>
                            <option value="DESTINATARIO">DESTINATÁRIO</option>
                            <option value="EXPEDIDOR">EXPEDIDOR</option>
                        </select>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="d_limite">Data limite</label>
                    <div class="col-sm-2">
                        <input type="date" class="form-control data" id="dt_limite" value="<?php 
                        if($dt_limite == 0){
                            echo '';
                            }else{
                             echo date('Y-m-d', strtotime($dt_limite)); 
                         }
                         ?>">
                         <div class="form-control-focus"> </div>
                     </div>
                     <label class="col-sm-2 control-label" for="h_limite">Hora limite</label>
                     <div class="col-sm-2">
                        <input type="text" class="form-control hora" id="hr_limite" value="<?php echo $hr_limite;?>">
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
                    <input type="text" class="form-control" id="ds_obs">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="p_obs">Doca</label>
                <div class="col-sm-2">
                    <select class="form-control" id="ds_doca" name="ds_doca" required="true">
                       <?php
                       while ($dados_doca=mysqli_fetch_assoc($res_doca)) {?>

                        <option value="<?php echo $dados_doca['id']; ?>"><?php echo $dados_doca['ds_doca']."-".$dados_doca['fl_tipo']; ?></option>

                    <?php } ?>
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="submit" class="btn btn-primary" id="btnFormUpdPed">Salvar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
    </div>
</div>
</div>
</form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#altera_pedido').modal('show');
    });
</script>