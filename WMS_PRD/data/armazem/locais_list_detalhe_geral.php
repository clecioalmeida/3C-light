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

$local = $_POST['local'];

$sql_local = "SELECT t1.id, t1.nome, t2.cod_estoque, t2.ds_galpao, t2.produto, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, 
t2.ds_altura, format(t2.nr_qtde,0) as nr_qtde, 
t3.cod_prod_cliente, t3.nm_produto, t2.nr_or, date_format(t4.dt_recebimento_real,'%d/%m/%Y') as dt_recebimento, t2.id_tar, 
date_format(t5.dt_create,'%d/%m/%Y') as dt_tarefa, t2.n_serie, t2.ds_lp, t2.ds_ano, t2.ds_fabr
from tb_armazem t1
left join tb_posicao_pallet t2 on t1.id = t2.ds_galpao
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
left join tb_recebimento t4 on t2.nr_or = t4.cod_recebimento
left join tb_inv_tarefa t5 on t2.id_tar = t5.id
where t2.fl_empresa = '$cod_cli' and t2.nr_qtde > 0 and t1.id = '$local' and t2.fl_status = 'A' and t2.produto > 0
group by t2.cod_estoque
order by t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.produto";
$res_local = mysqli_query($link, $sql_local);
$tr_local = mysqli_num_rows($res_local);

$link->close();
?>
<?php
if ($tr_local) { ?>

    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet" />
    <!--script src="https://code.jquery.com/jquery-3.5.1.js"></script-->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="jquery.table2excel.js"></script>

    <div class="col-sm-12 text-align-right">
        <div class="btn-group">
            <button type="submit" class="btn btn-success" id="RepEstoqGenExcel" style="float:right;width: 100px">Excel</button>
        </div>
    </div>
    <div id="reportSalEstoque">
        <div class="padding-10">
            <div class="pull-left">
                <img src="img/logo3c2.png" width="80" height="32" alt="Gisis">
                <address>
                    <br>
                    <strong>3C Services</strong>
                </address>
            </div>
            <div class="pull-right">
                <h1 class="font-200">Relatório de saldo de estoque por local</h1>
            </div>
            <div class="clearfix"></div>
            <br>
            <br>
            <table class="display responsive nowrap" id="example8" style="width:100%">
                <thead>
                    <tr>
                        <th> Código </th>
                        <th> Rua </th>
                        <th> Coluna</th>
                        <th> Altura </th>
                        <th> Cód. SAP</th>
                        <th> Série</th>
                        <th> Produto </th>
                        <th> Quantidade </th>
                        <th> MÊS/ANO </th>
                        <th> LP </th>
                        <th> FABRICANTE </th>
                        <th> O.R. </th>
                        <th> Data Recebimento </th>
                        <th> Inventário </th>
                        <th> Data inventário </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($dados_local = mysqli_fetch_assoc($res_local)) {
                    ?>
                        <tr class="odd gradeX">
                            <td style="text-align: center; width: 5px;"><?php echo $dados_local['cod_estoque']; ?> </td>
                            <td style="text-align: center; width: 5px;"><?php echo $dados_local['ds_prateleira']; ?> </td>
                            <td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_coluna']; ?> </td>
                            <td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_altura']; ?> </td>
                            <td style="text-align: right; width: 5px"> <?php echo $dados_local['produto']; ?></td>
                            <td style="text-align: left; width: auto"> <?php echo $dados_local['n_serie']; ?></td>
                            <td style="text-align: left; width: auto"> <?php echo $dados_local['nm_produto']; ?></td>
                            <td style="text-align: right; width: auto"> <?php echo $dados_local['nr_qtde']; ?></td>
                            <td style="text-align: right; width: auto"> <?php echo $dados_local['ds_ano']; ?></td>
                            <td style="text-align: right; width: auto"> <?php echo $dados_local['ds_lp']; ?></td>
                            <td style="text-align: left; width: auto"> <?php echo $dados_local['ds_fabr']; ?></td>
                            <td style="text-align: right; width: auto"> <?php echo $dados_local['nr_or']; ?></td>
                            <td style="text-align: center; width: auto"> <?php echo $dados_local['dt_recebimento']; ?></td>
                            <td style="text-align: right; width: auto"> <?php echo $dados_local['id_tar']; ?></td>
                            <td style="text-align: center; width: auto"> <?php echo $dados_local['dt_tarefa']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#example8").dataTable({
                "aLengthMenu": [5000]
            });
        });
    </script>
    <script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
    <script type="text/javascript">
        JsBarcode(".barcode").init();
    </script>
    <script type="text/javascript">
        $('#RepEstoqGenExcel').on('click', function() {
            event.preventDefault();
            $('#RepEstoqGenExcel').prop("disabled", true);
            var today = new Date();
            $("#reportSalEstoque").table2excel({
                exclude: ".noExl",
                name: "Relatório de saldo de estoque detalhado geral",
                filename: "Relatório de saldo de estoque detalhado geral" + today
            });
            $('#RepEstoqGenExcel').prop("disabled", false);

        });
    </script>
<?php } else { ?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

<?php } ?>