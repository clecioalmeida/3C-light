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

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$id_usr = $_POST['id_usr'];

$inv_tar = "select t1.*, t2.id as id_conf, t2.cont_1, t2.cont_2, t2.cont_3, t3.nome, t5.cod_prod_cliente, t6.nm_user, t7.id as id_etq
from tb_inv_tarefa t1
left join tb_inv_conf t2 on t1.id = t2.id_tar
left join tb_armazem t3 on t1.id_galpao = t3.id
left join tb_produto t5 on t1.id_produto = t5.cod_produto
left join tb_usuario t6 on t1.user_create = t6.id
left join tb_etiqueta t7 on t1.id_estoque = t7.cod_estoque
where t1.fl_empresa = '$cod_cli' and t1.fl_status = 'A' and t1.user_create = '$id_usr'
GROUP BY t1.id
order by t1.id desc";
$res_tar = mysqli_query($link, $inv_tar);
$tar = mysqli_num_rows($res_tar);


$link->close();
?>
<?php
if ($tar > 0) {
?>
<script type="text/javascript" src="./jquery.table2excel.min.js"></script>
    <button type="submit" class="btn btn-success" id="RepFornExcel" style="float:right;width: 100px">Excel</button>
    <br><br>

    <div id="reportSalForn">

        <table id="reportSalEstoque" class="table" width="100%">

            <thead>
                <tr style="background-color: #8DB6CD">
                    <th> Tarefa</th>
                    <th> Data</th>
                    <th> Local</th>
                    <th> Produto </th>
                    <th> LP </th>
                    <th> Serial </th>
                    <th> Kva </th>
                    <th> Rua </th>
                    <th> Coluna </th>
                    <th> Altura </th>
                    <th> Volumes </th>
                    <th> Contagem 1 </th>
                    <th> Contagem 2 </th>
                    <th> Contagem 3 </th>
                    <th> Conferente </th>
                    <th style="text-align: center"> Ações </th>
                </tr>
            </thead>
            <tbody>

                <?php
                while ($dados_tar = mysqli_fetch_assoc($res_tar)) {
                ?>
                    <tr class="odd gradeX">
                        <td><?php echo $dados_tar['id']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($dados_tar['dt_create'])); ?></td>
                        <td><?php echo $dados_tar['nome']; ?></td>
                        <td id="produto"><?php echo $dados_tar['cod_prod_cliente']; ?></td>
                        <td id="ds_lp"><?php echo $dados_tar['ds_lp']; ?></td>
                        <td id="ds_serial"><?php echo $dados_tar['ds_serial']; ?></td>
                        <td id="ds_kva"><?php echo $dados_tar['ds_kva']; ?></td>
                        <td id="rua"><?php echo $dados_tar['id_rua']; ?></td>
                        <td id="coluna"><?php echo $dados_tar['id_coluna']; ?></td>
                        <td id="altura"><?php echo $dados_tar['id_altura']; ?></td>
                        <td id="volume"><?php echo $dados_tar['nr_volume']; ?></td>
                        <td id="contA" class="contA" style="width: 100px;text-align: right"><?php echo $dados_tar['cont_1']; ?></td>
                        <td id="contB" class="contB" style="width: 100px;text-align: right"><?php echo $dados_tar['cont_2']; ?></td>
                        <td id="contC" class="contC" style="width:100px;text-align: right"><?php echo $dados_tar['cont_3']; ?>
                        <td><?php echo $dados_tar['nm_user']; ?></td>
                        <td style="width: 400px;text-align: center">
                            <form class="form-horizontal" method="post" action="data/inventario/relatorio/list_etq_inv_prd.php" id="" target="_blank">
                                <button type="button" class="btn btn-primary btn-xs" id="btnformEditTar" value="<?php echo $dados_tar['id']; ?>" style="width: 80px">Editar</button>
                                <button type="button" class="btn btn-default btn-xs" id="btnFinTarefa" value="<?php echo $dados_tar['id']; ?>" style="width: 80px">Encerrar</button>
                                <input type="hidden" class="input-xs" id="nr_qtde" name="nr_qtde" value="<?php echo $dados_tar['nr_volume']; ?>" style="color: black">
                                <input type="hidden" class="input-xs" id="id_tar" name="id_tar" value="<?php echo $dados_tar['id']; ?>" style="color: black">
                                <!--button type="submit" class="btn btn-success btn-xs" id="" value="" style="width: 110px">Etiquetas</button-->
                                <button type="button" class="btn btn-danger btn-xs" id="btnDelTarefa" value="<?php echo $dados_tar['id']; ?>" style="width: 80px">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>

        </table>
    </div>

    <div id="tarefas" class="row">
    <?php } else { ?>

        <h4>Nao foram encontradas tarefas com essa descrição.</h4>

    <?php }
    ?>

    <div id="retornoDelTar"></div>

    <script type="text/javascript">
        $('#RepFornExcel').on('click', function() {
            //event.preventDefault();
            $('#RepFornExcel').prop("disabled", true);
            var today = new Date();
            $("#reportSalEstoque").table2excel({
                name: "Relatório de tarefas de inventário",
                filename: "Relatório de tarefas de inventário"
            });
            $('#RepFornExcel').prop("disabled", false);

        });
    </script>
    <script type="text/javascript">
        function tarefas(tarefas) {
            var page = "data/inventario/gera_tarefa.php";
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: page,
                beforeSend: function() {
                    $("#info").html("Carregando...");
                },
                data: {
                    id_galpao: id_galpao,
                    nr_inv: nr_inv,
                    id_produto: id_produto,
                    id_rua_inicio: id_rua_inicio,
                    id_rua_fim: id_rua_fim
                },
                success: function(msg) {
                    $("#info").html(msg);
                }
            });
        }


        $('#btnGerar').click(function() {
            tarefas($("#id_galpao").val(), $("#nr_inv").val(), $("#id_produto").val(), $("#id_rua_inicio").val(), $("#id_rua_fim").val())
        });
    </script>