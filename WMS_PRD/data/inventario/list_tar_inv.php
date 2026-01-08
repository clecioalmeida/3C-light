<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;

} else {

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php

require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

$inv_tar = "select t1.*, t2.id as id_conf, t2.cont_1, t2.cont_2, t2.cont_3, t3.nome, t5.cod_prod_cliente, t6.nm_user
from tb_inv_tarefa t1
left join tb_inv_conf t2 on t1.id = t2.id_tar
left join tb_armazem t3 on t1.id_galpao = t3.id
left join tb_produto t5 on t1.id_produto = t5.cod_produto
left join tb_usuario t6 on t1.user_create = t6.id
where t1.fl_empresa = '$cod_cli' and t1.fl_status = 'A'
order by t1.id desc";
$res_tar = mysqli_query($link,$inv_tar); 
$tar = mysqli_num_rows($res_tar);


$link->close();
?>
<?php
if($tar>0){
    ?>
    <br /><br /> <section id="widget-grid" class="">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                <div class="jarviswidget-editbox">
                </div>
                <div class="widget-body no-padding" id="dadosTar">

                    <table id="datatable_tabletools" class="table table-striped table-bordered table-hover table-responsive" width="100%">

                        <thead>
                            <tr style="background-color: #8DB6CD">
                                <th> Tarefa</th>
                                <th> Data</th>
                                <th> Local</th>
                                <th> Produto </th>
                                <th> Rua </th>
                                <th> Coluna </th>
                                <th> Altura </th>
                                <th> Volumes </th>
                                <th> Contagem 1 </th>
                                <th> Contagem 2 </th>
                                <th> Contagem 3 </th>
                                <th> Conferente </th>
                                <th colspan="4"> Ações </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                            while($dados_tar = mysqli_fetch_assoc($res_tar)) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $dados_tar['id']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($dados_tar['dt_create'])); ?></td>
                                    <td><?php echo $dados_tar['nome']; ?></td>
                                    <td><?php echo $dados_tar['cod_prod_cliente']; ?></td>
                                    <td><?php echo $dados_tar['id_rua']; ?></td>
                                    <td><?php echo $dados_tar['id_coluna']; ?></td>
                                    <td><?php echo $dados_tar['id_altura']; ?></td>
                                    <td><?php echo $dados_tar['nr_volume']; ?></td>
                                    <td id="contA" class="contA" style="width: 100px;text-align: right"><?php echo $dados_tar['cont_1']; ?>
                                </td>
                                <td id="contB" class="contB" style="width: 100px;text-align: right"><?php echo $dados_tar['cont_2']; ?>
                            </td>
                            <td id="contC" class="contC" style="width:100px;text-align: right"><?php echo $dados_tar['cont_3']; ?>
                        </td>
                        <td><?php echo $dados_tar['nm_user']; ?></td>
                        <td style="width: 400px;text-align: center">
                            <form class="form-horizontal" method="post" action="data/inventario/relatorio/list_etq_inv_prd.php" id="" target="_blank">
                                <button type="button" class="btn btn-primary btn-xs" id="btnformEditTar" value="<?php echo $dados_tar['id']; ?>" style="width: 80px">Editar</button>
                                <button type="button" class="btn btn-default btn-xs" id="btnFinTarefa" value="<?php echo $dados_tar['id']; ?>" style="width: 80px" disabled >Encerrar</button>
                                <input type="hidden" class="input-xs" id="nr_qtde" name="nr_qtde" value="<?php echo $dados_tar['nr_volume'];?>" style="color: black">
                                <input type="hidden" class="input-xs" id="id_tar" name="id_tar" value="<?php echo $dados_tar['id'];?>" style="color: black">
                                <button type="submit" class="btn btn-success btn-xs" id="" value="" style="width: 110px">Etiquetas</button>
                                <button type="button" class="btn btn-danger btn-xs" id="btnDelTarefa" value="<?php echo $dados_tar['id']; ?>" style="width: 80px">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php }?>

            </tbody>

        </table>


        <div id="tarefas" class="row">
        <?php }else{?>

            <h4>Nao foram encontradas tarefas com essa descrição.</h4>

        <?php }
        ?>

    </div>
</div>
</div>
<div id="retornoDelTar"></div>
</article>
</section>


<a href="#" id="ancora">

    <script type="text/javascript">



        function tarefas(tarefas)
        {
            var page = "data/inventario/gera_tarefa.php";
            $.ajax
            ({
                type: 'POST',
                dataType: 'html',
                url: page,
                beforeSend: function () {
                    $("#info").html("Carregando...");
                },
                data: {id_galpao: id_galpao, nr_inv: nr_inv,id_produto: id_produto,id_rua_inicio: id_rua_inicio,id_rua_fim: id_rua_fim},
                success: function (msg)
                {
                    $("#info").html(msg);
                }
            });
        }


        $('#btnGerar').click(function () {
            tarefas($("#id_galpao").val(),$("#nr_inv").val(),$("#id_produto").val(),$("#id_rua_inicio").val(),$("#id_rua_fim").val())
        });

    </script>