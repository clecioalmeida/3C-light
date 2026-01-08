<?php

require_once 'bd_class_dsv.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

if (isset($_POST['codigo'])) {

	$codigo = $_POST['codigo'];

	$inv_tar = "select t1.*, t2.id as id_conf, t2.cont_1, t2.cont_2, t2.cont_3, t3.nome, t4.nr_posicao
            from tb_inv_tarefa t1
            left join tb_inv_conf t2 on t1.id = t2.id_tar
            left join tb_armazem t3 on t1.id_galpao = t3.id
            left join tb_produto t5 on t1.id_produto = t5.cod_produto
            left join tb_item_torre t4 on t4.id_item = t5.cod_produto or t4.id_item = t5.id_torre
            where t1.id like '%$codigo%' and t1.fl_status = 'A' and t1.dt_create >= NOW() - INTERVAL 2 DAY
            order by t1.dt_create, t1.id asc";
	$res_tar = mysqli_query($link, $inv_tar);
	$tar = mysqli_num_rows($res_tar);
} else {

	$inv_tar = "select t1.*, t2.id as id_conf, t2.cont_1, t2.cont_2, t2.cont_3, t3.nome, t4.nr_posicao
            from tb_inv_tarefa t1
            left join tb_inv_conf t2 on t1.id = t2.id_tar
            left join tb_armazem t3 on t1.id_galpao = t3.id
            left join tb_produto t5 on t1.id_produto = t5.cod_produto
            left join tb_item_torre t4 on t4.id_item = t5.cod_produto or t4.id_item = t5.id_torre
            where t1.fl_status = 'A' and t1.dt_create >= NOW() - INTERVAL 2 DAY
            order by t1.dt_create, t1.id asc";
	$res_tar = mysqli_query($link, $inv_tar);
	$tar = mysqli_num_rows($res_tar);

}

$link->close();
?>
    <?php
if ($tar > 0) {
	?>
<head>
    <script>
    $(document).ready(function() {
        window.location.href='#ancora';
    });
</script>

</head><br /><br />
<section id="widget-grid" class="">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
            <div class="jarviswidget-editbox"></div>
                <div class="widget-body no-padding" id="dadosTar">
                    <table id="datatable_tabletools" class="table table-striped table-bordered table-hover table-responsive" width="100%">
                        <thead>
                            <tr style="background-color: #8DB6CD">
                                <th> Tarefa</th>
                                <th> Código estoque</th>
                                <th> Produto </th>
                                <th> Posição </th>
                                <th> Armazém </th>
                                <th> Rua </th>
                                <th> Coluna </th>
                                <th> Altura </th>
                                <th> Embalagem </th>
                                <th> Quantidade </th>
                                <th> Contagem 1 </th>
                                <th> Contagem 2 </th>
                                <th> Contagem 3 </th>
                                <th colspan="4" style="width: 180px;text-align: center"> Ações </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
while ($dados_tar = mysqli_fetch_assoc($res_tar)) {
		?>
                            <tr class="odd gradeX">
                                <td><?php echo $dados_tar['id']; ?></td>
                                <td style="width: 50px"><?php echo $dados_tar['id_estoque']; ?></td>
                                <td><?php echo $dados_tar['id_produto']; ?></td>
                                <td><?php echo $dados_tar['nr_posicao']; ?></td>
                                <td><?php echo $dados_tar['nome']; ?></td>
                                <td><?php echo $dados_tar['id_rua']; ?></td>
                                <td><?php echo $dados_tar['id_coluna']; ?></td>
                                <td><?php echo $dados_tar['id_altura']; ?></td>
                                <td><?php echo $dados_tar['ds_embalagem']; ?></td>
                                <td style="width: 50px;text-align: right"><?php echo $dados_tar['nr_qtde']; ?></td>
                                <td id="contA" class="contA" data-toggle="tooltip" data-placement="top" title="Digite a primeira contagem e clique em confirmar" style="width: 100px;text-align: right"><?php echo $dados_tar['cont_1']; ?>
                                </td>
                                <td id="contB" class="contB" data-toggle="tooltip" data-placement="top" title="Digite a segunda contagem e clique em confirmar" style="width: 100px;text-align: right"><?php echo $dados_tar['cont_2']; ?>
                                </td>
                                <td id="contC" class="contC" data-toggle="tooltip" data-placement="top" title="Digite a terceira contagem e clique em confirmar" style="width: 100px;text-align: right"><?php echo $dados_tar['cont_3']; ?>
                                </td>
                                <td style="width: 120px;text-align: center">
                                    <button type="submit" class="btn btn-primary btn-xs" id="btnformEditTar" value="<?php echo $dados_tar['id']; ?>" style="width: 80px">Editar</button>
                                </td>
                                <td style="width: 120px;text-align: center">
                                    <button type="submit" class="btn btn-default btn-xs" id="btnformStartContTar" value="<?php echo $dados_tar['id']; ?>" style="width: 110px">Iniciar contagem</button>
                                </td>
                                <td style="width: 120px;text-align: center">
                                    <button type="submit" class="btn btn-default btn-xs" id="btnFinTarefa" value="<?php echo $dados_tar['id']; ?>" style="width: 80px">Encerrar</button>
                                </td>
                                <td style="width: 120px;text-align: center">
                                    <button type="submit" class="btn btn-default btn-xs" id="btnDelTarefa" value="<?php echo $dados_tar['id']; ?>" style="width: 80px">Excluir</button>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <div id="tarefas" class="row">
                    <?php } else {?>
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