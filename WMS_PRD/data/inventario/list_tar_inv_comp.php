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

$inv_tar = "select t1.id as id_tarefa, t1.dt_create, t3.produto, t6.nome, t3.ds_prateleira, t3.ds_coluna, t3.ds_altura, t5.nm_produto as descricao, t4.cont_1 as qtd_inv, t2.id as id_etq, t3.cod_estoque, round(t3.nr_qtde,0) as qtd_est, round((t3.nr_qtde - t4.cont_1),0) as conf
from tb_inv_tarefa t1
left join tb_etiqueta t2 on t1.id_etq = t2.id
left join tb_posicao_pallet t3 on t2.cod_estoque = t3.cod_estoque
left join tb_inv_conf t4 on t1.id = t4.id_tar
left join tb_produto t5 on t3.produto = t5.cod_prod_cliente
left join tb_armazem t6 on t3.ds_galpao = t6.id
where t1.fl_status = 'A' and t3.produto is not null
order by (t3.nr_qtde - t4.cont_1) desc";
$res_tar = mysqli_query($link,$inv_tar);
$tar = mysqli_num_rows($res_tar);

$sql_tar = "select count(id) as total_tar 
from tb_inv_tarefa
where fl_status = 'A'";
$res_totaltar = mysqli_query($link,$sql_tar);
$dados_totaltar = mysqli_fetch_assoc($res_totaltar);
$total_tar = $dados_totaltar['total_tar'];

$sql_prd = "select count(distinct id_produto) as total_produto
from tb_inv_tarefa
where fl_status = 'A'";
$res_totalprd = mysqli_query($link,$sql_prd);
$dados_totalprd = mysqli_fetch_assoc($res_totalprd);
$total_produto = $dados_totalprd['total_produto'];

$sql_itn = "select sum(t2.cont_1) as total_iten
from tb_inv_tarefa t1
left join tb_inv_conf t2 on t1.id = t2.id_tar
where t1.fl_status = 'A'";
$res_totalitn = mysqli_query($link,$sql_itn);
$dados_totalitn = mysqli_fetch_assoc($res_totalitn);
$total_iten = $dados_totalitn['total_iten'];

$sql_acr = "select round(sum(t3.nr_qtde),0), sum(t4.cont_1), round(sum(t4.cont_1)/sum(t3.nr_qtde)*100,2) as total_acr
from tb_inv_tarefa t1
left join tb_etiqueta t2 on t1.id_etq = t2.id
left join tb_posicao_pallet t3 on t2.cod_estoque = t3.cod_estoque
left join tb_inv_conf t4 on t1.id = t4.id_tar
where t1.fl_status = 'A' and t3.produto is not null
group by t1.fl_status";
$res_acr = mysqli_query($link,$sql_acr);
$dados_acr = mysqli_fetch_assoc($res_acr);
$total_acr = $dados_acr['total_acr'];


$link->close();
?>
<?php
if($tar>0){
    ?>

    <script type="text/javascript">
        function printContent(el){
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>
    <script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
    <script type="text/javascript">
        JsBarcode(".barcode").init();
    </script>
    <br /><br /> 
    <section>
        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-sm-2">
                    <h5> Total de tarefas: <span class="txt-color-blue" style="float: center;"><?php echo "<br>".$total_tar;?></span></h5>
                </div>
                <div class="col-sm-2">
                    <h5> Total SKU's: <span class="txt-color-green" style="float: center;"><?php echo "<br>".$total_produto;?></span></h5>
                </div>
                <div class="col-sm-2">
                    <h5> Total de itens contados: <span class="txt-color-purple" style="float: center;"><?php echo "<br>".$total_iten;?></span></h5>
                </div>
                <div class="col-sm-2">
                    <h5> % Acuracidade: <span class="txt-color-purple" style="float: center;"><?php echo "<br>".$total_acr;?></span></h5>
                </div>
                <button onclick="printContent('reportSalEstoque')" type="submit" class="btn btn-primary" id="RepEstoqGenPdf" style="float:right;width: 100px">Imprimir</button>
            </article>
        </div>
    </section>
    <section id="widget-grid" class="">
        <article>
            <div id="reportSalEstoque">

                <table id="table_tar" class="table" width="100%">

                    <thead>
                        <tr style="background-color: #8DB6CD">
                            <th> PRODUTO</th>
                            <th> DESCRIÇÃO</th>
                            <th> LOCAL</th>
                            <th> RUA</th>
                            <th> COLUNA</th>
                            <th> ALTURA</th>
                            <th> TAREFA</th>
                            <th> DATA </th>
                            <th> ETIQUETA </th>
                            <th> COD.ESTOQUE </th>
                            <th> QTD.ESTOQUE </th>
                            <th> QTD.INVENTÁRIO </th>
                            <th> DIFERENÇA </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php  while($dados_tar = mysqli_fetch_assoc($res_tar)) {?>
                            <tr class="odd gradeX">
                                <td style="text-align: right;"><?php echo $dados_tar['produto']; ?></td>
                                <td><?php echo $dados_tar['descricao']; ?></td>
                                <td><?php echo $dados_tar['nome']; ?></td>
                                <td><?php echo $dados_tar['ds_prateleira']; ?></td>
                                <td><?php echo $dados_tar['ds_coluna']; ?></td>
                                <td><?php echo $dados_tar['ds_altura']; ?></td>
                                <td style="text-align: right;"><?php echo $dados_tar['id_tarefa']; ?></td>
                                <td><?php echo $dados_tar['dt_create']; ?></td>
                                <td id="produto" style="text-align: right;"><?php echo $dados_tar['id_etq']; ?></td>
                                <td id="rua" style="text-align: right;"><?php echo $dados_tar['cod_estoque']; ?></td>
                                <td id="altura" style="text-align: right;"><?php echo $dados_tar['qtd_est']; ?></td>
                                <td id="coluna" style="text-align: right;"><?php echo $dados_tar['qtd_inv']; ?></td>
                                <td id="volume" style="text-align: right;"><?php echo $dados_tar['conf']; ?></td>
                            </tr>
                        <?php }?>

                    </tbody>

                </table>
            </div>

            <div id="tarefas" class="row">
            <?php }else{?>

                <h4>Nao foram encontradas tarefas com essa descrição.</h4>

            <?php }
            ?>

            <div id="retornoDelTar"></div>
        </article>
    </section>

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