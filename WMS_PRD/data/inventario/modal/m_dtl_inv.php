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
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$id_prd = $_POST['id_prd'];
$id_inv = $_POST['id_inv'];

$big_select = "SET SQL_BIG_SELECTS=1";
$res_big = mysqli_query($link, $big_select);

$query_torre = "select t1.*, t2.cod_prod_cliente, t2.unid, t3.cont_2 
from tb_inv_tarefa t1 
left join tb_produto t2 on t1.id_produto = t2.cod_produto
left join tb_inv_conf t3 on t1.id = t3.id_tar
where t1.fl_empresa = '$cod_cli' and t1.id_produto = '$id_prd' and t1.id_inv = '$id_inv' and t1.fl_status <> 'E'";
$res_torre = mysqli_query($link, $query_torre);
$tr_torre = mysqli_num_rows($res_torre);

$link->close();

?>
<div class="modal fade in" id="saldoItem" style="padding-right: 19px;">
    <form method="post" id="formCadPeca" action="">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #22262E;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <button type="submit" class="btn btn-success" id="SalAnalitTorGenExcel" style="float:right;margin-right: 10px;width: 100px">Excel</button>
                    <h4 class="modal-title" id="myModalLabel" style="color: white">Consulta detalhada de tarefas por produto</h4>
                </div>
                <div class="modal-body modal-lg">
                    <table id="TbConsSalTorreAnalit" class="table">
                        <thead>
                            <tr>
                                <th data-hide="phone"> ID </th>
                                <th data-class="expand"> CÓDIGO SAP </th>
                                <th data-class="expand"> RUA </th>
                                <th data-class="expand"> COLUNA </th>
                                <th data-class="expand"> ALTURA </th>
                                <th data-class="expand"> VOLUMES </th>
                                <th data-class="expand"> UNIDADE </th>
                                <th data-class="expand"> QTDE </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($tipo = mysqli_fetch_assoc($res_torre)) {
                             ?>
                             <tr>
                                <td style="text-align: right;"><?php echo $tipo['id']; ?></td>
                                <td style="text-align: right;"><?php echo $tipo['cod_prod_cliente']; ?></td>
                                <td style="text-align: right;"><?php echo $tipo['id_rua']; ?></td>
                                <td style="text-align: right;"><?php echo $tipo['id_coluna']; ?></td>
                                <td style="text-align: right;"><?php echo $tipo['id_altura']; ?></td>
                                <td style="text-align: right;"><?php echo $tipo['nr_volume']; ?></td>
                                <td style="text-align: right;"><?php echo $tipo['unid']; ?></td>
                                <td style="text-align: right;"><?php echo $tipo['cont_2']; ?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background-color: #22262E;">
                <button type="button" id="btnAtualiza" class="btn btn-default" data-dismiss="modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</form>
</div>
<script>
  $(document).ready(function () {
    $('#saldoItem').modal('show');
  });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#SalAnalitTorGenExcel', function(){
            event.preventDefault();
            $('#SalAnalitTorGenExcel').prop("disabled", true);
            var today = new Date();
            $("#TbConsSalTorreAnalit").table2excel({
                exclude: ".noExl",
                name: "Consulta estoque de torres - Analítico",
                filename: "Consulta estoque de torres - Analítico - " + today //do not include extension
            });

        });
        $('#SalAnalitTorGenExcel').prop("disabled", false);
    });
</script>