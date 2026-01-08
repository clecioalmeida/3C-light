<?php

require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

if (isset($_POST['SelIdTArefa'])) {

	$SelIdTArefa = $_POST['SelIdTArefa'];

	$inv_tar = "select t1.*, t2.id as id_conf, t2.cont_1, t2.cont_2, t2.cont_3, t3.nome, t4.nr_posicao
    from tb_inv_tarefa t1
    left join tb_inv_conf t2 on t1.id = t2.id_tar
    left join tb_armazem t3 on t1.id_galpao = t3.id
    left join tb_produto t5 on t1.id_produto = t5.cod_produto
    left join tb_item_torre t4 on t4.id_item = t5.cod_produto or t4.id_item = t5.id_torre
    where t1.id = '$SelIdTArefa'
    order by t1.dt_create desc";
    $res_tar = mysqli_query($link, $inv_tar);
    $tar = mysqli_num_rows($res_tar);

} else if (isset($_POST['dtInitHistTar']) && isset($_POST['dtFinHistTar'])) {

	$dt_ini = $_POST['dtInitHistTar'];
	$dt_fim = $_POST['dtFinHistTar'];

    $inv_tar = "select t1.id_tar, t1.cod_estoque, t3.cod_prod_cliente, t2.id_rua, t2.id_coluna, t2.id_altura, t1.nr_qtd_est, t1.nr_qtd_inv, t1.nr_qtd_est-t1.nr_qtd_inv as diff, t3.nm_produto
    from tb_log_tarefa t1
    left join tb_inv_tarefa t2 on t1.id_tar = t2.id
    left join tb_produto t3 on t2.id_produto = t3.cod_produto
    where date(t2.dt_create) >= '$dt_ini' and date(t2.dt_create) <= '$dt_fim' and t2.fl_status = 'X'
    order by t2.id_rua, t2.id_coluna, t2.id_altura";
    $res_tar = mysqli_query($link, $inv_tar);
    $tar = mysqli_num_rows($res_tar);

}

$total_tar = "select format(sum(t1.nr_qtd_est),0,'de_De') as total_est, format(sum(t1.nr_qtd_inv),0,'de_De') as total_cont, format(sum(t1.nr_qtd_est)-sum(t1.nr_qtd_inv),0,'de_De') as diff, round(((sum(t1.nr_qtd_est)-sum(t1.nr_qtd_inv))/sum(t1.nr_qtd_est))*-1+1,2)*100 as perc_acur
from tb_log_tarefa t1
left join tb_inv_tarefa t2 on t1.id_tar = t2.id
left join tb_posicao_pallet t3 on t1.cod_estoque = t3.cod_estoque
where date(t2.dt_create) >= '$dt_ini' and date(t2.dt_create) <= '$dt_ini'";
$res_total = mysqli_query($link, $total_tar);
$total = mysqli_fetch_assoc($res_total);

$total_est      = $total['total_est'];
$total_cont     = $total['total_cont'];
$diff           = $total['diff'];
$perc_acur      = $total['perc_acur'];


$link->close();
?>
<?php
if ($tar > 0) {
	?>
   <br /><br /> 
   <section id="widget-grid" class="">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="widget-body-toolbar" id="toolbar">
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8 text-align-right">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success" id="RepInvExcel" style="float:right;width: 100px">Excel</button>
                    </div>
                </div>

                <div id="retorno"></div>
            </div>
        </div> 
    </article>
</section>
<section id="widget-grid" class="">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
            <div class="widget-body no-padding" id="dadosTar">
                <table id="" class="table" style="width: 70%">
                    <thead>
                        <tr style="background-color: #8DB6CD">
                            <th> TAREFA</th>
                            <th> CÓDIGO PRODUTO </th>
                            <th> PRODUTO </th>
                            <th> RUA </th>
                            <th> COLUNA </th>
                            <th> ALTURA </th>
                            <th> QTDE ANTERIOR </th>
                            <th> CONTAGEM </th>
                            <th> SOBRA </th>
                            <th> FALTA </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($dados_tar = mysqli_fetch_assoc($res_tar)) {
                          ?>
                          <tr class="odd gradeX">
                            <td><?php echo $dados_tar['id_tar']; ?></td>
                            <td><?php echo $dados_tar['cod_prod_cliente']; ?></td>
                            <td><?php echo $dados_tar['nm_produto']; ?></td>
                            <td><?php echo $dados_tar['id_rua']; ?></td>
                            <td><?php echo $dados_tar['id_coluna']; ?></td>
                            <td><?php echo $dados_tar['id_altura']; ?></td>
                            <td style="width: 100px;text-align: right"><?php echo number_format($dados_tar['nr_qtd_inv'], 0); ?></td>
                            <td style="width: 100px;text-align: right"><?php echo number_format($dados_tar['nr_qtd_est'], 0); ?></td>
                            <td style="width: 100px;text-align: right;background-color: #009933;color:white">
                                <?php 

                                if($dados_tar['diff'] > 0 ){                                        

                                    echo $dados_tar['diff'];

                                }else{

                                    echo 0;

                                }
                                ?>

                            </td>
                            <td style="width: 100px;text-align: right;background-color: #D96123;color:white">
                                <?php 

                                if($dados_tar['diff'] > 0 ){

                                    echo 0;

                                }else{

                                    echo $dados_tar['diff']*-1;

                                }
                                ?>

                            </td>
                        </tr>
                    <?php }?>

                </tbody>

            </table>
            <table id="" class="table" style="width: 70%">
                <tr>
                    <td>Estoque</td>
                    <td>Inventariado</td>
                    <td>Diferença</td>
                    <td>Acuracidade</td>
                </tr>
                <tr>
                    <td><?php echo $total_est; ?></td>
                    <td><?php echo $total_cont; ?></td>
                    <td><?php echo $diff; ?></td>
                    <td><?php echo $perc_acur; ?></td>
                </tr>
                
            </table>

            <div id="tarefas" class="row">
            <?php } else {?>

                <h4>Nao foram encontradas tarefas com essa descrição.</h4>

            <?php }
            ?>

        </div>
    </div>
</article>
</section>