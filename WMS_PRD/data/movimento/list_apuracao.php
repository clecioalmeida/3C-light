<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$selMesAp = $_POST['selMesAp'];

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$SQL = "select produto, qtd_rec, qtd_ped, nr_saldo
from tb_giro
where date_format(dt_mes,'%m/%Y') = '$selMesAp' and (qtd_rec > 0 or qtd_ped > 0)";

$res = mysqli_query($link, $SQL);
$tr = mysqli_num_rows($res);

$link->close();
?>
<hr>
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2" style="width: 600px">
    <thead>
        <tr>
            <th> Produto</th>
            <th> Total expedido</th>
            <th> Total recebido </th>
            <th> Saldo médio </th>
        </tr>
    </thead>
    <tbody>
<?php
while ($dados = mysqli_fetch_assoc($res)) {?>
        <tr class="odd gradeX">
            <td style="text-align: left"> <?php echo $dados['produto']; ?> </td>
            <td style="text-align: right"> <?php echo $dados['qtd_ped']; ?> </td>
            <td style="text-align: right"> <?php echo $dados['qtd_rec']; ?> </td>
            <td style="text-align: right"> <?php echo $dados['nr_saldo']; ?> </td>
        </tr>
<?php }?>
    </tbody>
</table>