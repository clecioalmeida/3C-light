<?php
require_once('../bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_ped    = $_POST['cod_ped'];

$query_pedido = "SELECT t1.nr_pedido, t1.dt_create, case t1.usr_create when '99' then 'SISTEMA' else upper(t2.ds_nome) end as ds_nome, t3.dt_init_col, t4.nm_user as nm_init_col, t3.dt_fim_conf, t5.nm_user as nm_fim_conf, t3.dt_fim_coleta, t6.nm_user as nm_fim_coleta, upper(t7.ds_nome) as nm_solicitante, t7.cod_depto
from tb_pedido_coleta t1
left join tb_funcionario t2 on t1.usr_create = t2.id
left join tb_pedido_coleta_produto t3 on t1.nr_pedido = t3.nr_pedido
left join tb_usuario t4 on t3.usr_init_col = t4.id
left join tb_usuario t5 on t3.usr_fim_conf = t5.id
left join tb_usuario t6 on t3.usr_fim_coleta = t6.id
left join tb_funcionario t7 on t1.cod_almox = t7.nr_matricula
where t1.nr_pedido = '$cod_ped' and t3.dt_fim_conf is not null";
$res_pedido = mysqli_query($link, $query_pedido);
$dados = mysqli_fetch_assoc($res_pedido);
$nr_pedido          = $dados['nr_pedido'];
$dt_create          = $dados['dt_create'];
$ds_nome            = $dados['ds_nome'];
$dt_init_col        = $dados['dt_init_col'];
$nm_init_col        = $dados['nm_init_col'];
$dt_fim_conf        = $dados['dt_fim_conf'];
$nm_fim_conf        = $dados['nm_fim_conf'];
$dt_fim_coleta      = $dados['dt_fim_coleta'];
$nm_fim_coleta      = $dados['nm_fim_coleta'];
$nm_solicitante     = $dados['nm_solicitante'];
$cod_depto          = $dados['cod_depto'];

$link->close();
?>
<div class="modal fade in" id="listPedidoDtl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding-right: 19px;">
    <form method="post" id="" action="">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <button type="submit" class="btn btn-success" id="mRelRecebidoMesGenExcel" style="float:right;margin-right: 10px;width: 100px">Excel</button>
                    <h4 class="modal-title" id="myModalLabel" style="color: white">DETALHAMENTO DE REQUISIÇÕES </h4>
                </div>
                <div class="modal-body modal-xs">
                    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                        <div class="jarviswidget-editbox"></div>
                        <div class="widget-body no-padding">
                            <p><span style="width: 50px"> NÚMERO DA REQUISIÇÃO: </span><span><?php echo $nr_pedido;?></span></p>
                            <p><span style="width: 50px"> DATA DE CRIAÇÃO: </span><span><?php echo $dt_create;?></span></p>
                            <p><span style="width: 50px"> CRIADO POR: </span><span><?php echo $ds_nome;?></span></p>
                            <p><span style="width: 50px"> SOLICITANTE DO MATERIAL: </span><span><?php echo $nm_solicitante;?></span></p>
                            <p><span style="width: 50px"> c.r.: </span><span><?php echo $cod_depto;?></span></p>
                            <hr>
                            <p><span style="width: 50px"> INÍCIO DA SEPARAÇÃO: </span><span><?php echo $dt_init_col;?></span></p>
                            <p><span style="width: 50px"> INICIADO POR: </span><span><?php echo $nm_init_col;?></span></p>
                            <p><span style="width: 50px"> FIM DA SEPARAÇÃO: </span><span><?php echo $dt_fim_conf;?></span></p>
                            <p><span style="width: 50px"> FINALIZADO POR: </span><span><?php echo $nm_fim_conf;?></span></p>
                            <hr>
                            <p><span style="width: 50px"> ATENDIMENTO DA REQUISIÇÃO: </span><span><?php echo $dt_fim_coleta;?></span></p>
                            <p><span style="width: 50px"> ATENDIDO POR: </span><span><?php echo $nm_fim_coleta;?></span></p>
                        </div>
                    </div>    
                </div>
                <div class="modal-footer modal-xs" style="background-color: #2F4F4F;">
                    <button type="button" id="closeModal" class="btn btn-default" data-dismiss="modal">
                        Fechar
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div> <!--Fim Modal-->
<script type="text/javascript">
    $(document).ready(function(){
        $('#listPedidoDtl').modal('show');
        return false;

    });
</script>