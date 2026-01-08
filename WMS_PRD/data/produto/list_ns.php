<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "SELECT t1.id as id_ns, t1.id_produto, t1.n_serie as nserie_comp, LEFT (t1.n_serie, 7) as n_serie, 
upper(t1.nm_fornecedor) as nm_fornecedor, date_format(t1.dt_fin_col,'%d/%m/%Y %T') as dt_fin_col, 
date_format(t1.dt_create,'%d/%m/%Y %T') as dt_create, t1.ds_emb_primaria,
CASE WHEN t1.fl_status = 'A' THEN 'NÃO EXPORTADO' WHEN t1.fl_status = 'P' THEN 'COLETADO' 
WHEN t1.fl_status = 'Y' THEN 'INTEGRADO SAP' END AS fl_status, t2.nm_user
from tb_nserie t1 
left join tb_usuario t2 on t1.usr_update = t2.id or t1.usr_create = t2.id
where t1.fl_status = 'A' or t1.fl_status = 'Y'
order by date(t1.dt_create) desc, t1.nm_fornecedor desc";
$res = mysqli_query($link, $sql);

$tr = mysqli_num_rows($res);

$link->close();
?>

<?php if ($tr > 0) { ?>

    <style type="text/css">
        .tableFixHead {
            overflow-y: auto;
            height: 640px;
        }

        .tableFixHead thead th {
            position: sticky;
            top: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px 16px;
        }

        th {
            background: #eee;
        }
    </style>

    <div class="tableFixHead">
        <div id="reportSalEstoque">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                <thead>
                    <tr>
                        <th data-toggle="tooltip" data-placement="left" title="Código do cliente"> COD. CLIENTE</th>
                        <th> FORNECEDOR </th>
                        <th> CRIADO EM</th>
                        <th> DATA FINALIZAÇÃO</th>
                        <th> CÓDIGO SAP </th>
                        <th> NUM. COLETA </th>
                        <th> NUM. SÉRIE </th>
                        <th> PALLET </th>
                        <th> RESPONSÁVEL </th>
                        <th> STATUS </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($dados = mysqli_fetch_array($res)) { ?>
                        <tr class="odd gradeX">
                            <td> <?php echo $dados['id_ns']; ?> </td>
                            <td style="text-align: right"> <?php echo $dados['nm_fornecedor']; ?> </td>
                            <td style="text-align: right"> <?php echo $dados['dt_create']; ?> </td>
                            <td style="text-align: right"> <?php echo $dados['dt_fin_col']; ?> </td>
                            <td> <?php echo $dados['id_produto']; ?> </td>
                            <td style="text-align: right"> <?php echo str_replace("-","",$dados['nserie_comp']); ?> </td>
                            <td style="text-align: right"> <?php echo $dados['n_serie']; ?> </td>
                            <td style="text-align: right"> <?php echo $dados['ds_emb_primaria']; ?> </td>
                            <td style="text-align: right"> <?php echo $dados['nm_user']; ?> </td>
                            <td><?php echo $dados['fl_status'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } else { ?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

<?php } ?>