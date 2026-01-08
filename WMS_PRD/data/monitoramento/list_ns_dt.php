<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$dt_ini     = $_POST['dt_ini'];
$dt_fim     = $_POST['dt_fim'];

$sql = "select t1.id as id_ns, t1.id_produto, t1.n_serie as nserie_comp, LEFT (t1.n_serie, 7) as n_serie, upper(t1.nm_fornecedor) as nm_fornecedor, 
date_format(t1.dt_fin_col,'%d/%m/%Y %T') as dt_fin_col
from tb_nserie t1 
where t1.fl_status = 'P' and date(dt_fin_col) >= '$dt_ini' and date(dt_fin_col) <= '$dt_fim'
order by date(dt_fin_col), t1.nm_fornecedor";
$res = mysqli_query($link,$sql);

$tr = mysqli_num_rows($res);

$link->close();
?>

<?php if($tr > 0){ ?>

    <style type="text/css">
        .tableFixHead          { overflow-y: auto; height: 640px; }
        .tableFixHead thead th { position: sticky; top: 0; }
        table  { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px 16px; }
        th     { background:#eee; }

    </style>

    <div class="tableFixHead">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th data-toggle="tooltip" data-placement="left" title="Código do cliente"> COD. CLIENTE</th>
                    <th> FORNECEDOR </th>
                    <th> DATA </th>
                    <th> CÓDIGO SAP </th>
                    <th> NUM. COLETA </th>
                    <th> NUM. SÉRIE </th>
                </tr>
            </thead>
            <tbody>
                <?php                                                      
                while($dados = mysqli_fetch_array($res)) {?>
                    <tr class="odd gradeX">
                        <td> <?php echo $dados['id_ns']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['nm_fornecedor']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['dt_fin_col']; ?> </td>
                        <td> <?php echo $dados['id_produto']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['nserie_comp']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['n_serie']; ?> </td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    </div>
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
<?php }else{?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

<?php } ?>