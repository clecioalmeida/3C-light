<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:../../index.php");
  exit;

}else{

  $id     = $_SESSION["id"];
  $cod_cli  = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$ds_mes = $_POST['ds_mes'];

$query_prod = "select t1.cod_minuta, date_format(t1.dt_minuta,'%d/%m/%Y') as dt_transp, t1.ds_tipo, t1.ds_transporte, t1.nr_placa, GROUP_CONCAT(DISTINCT t2.cod_almox) AS cod_almox, GROUP_CONCAT(DISTINCT t3.ds_almox) AS ds_almox, GROUP_CONCAT(DISTINCT t2.nr_dem) AS nr_dem, concat('R$ ',format(sum(t2.vlr_dem),2,'de_DE')) as vlr_total, t1.nr_averba, t1.fl_comprovante, t1.tp_veiculo 
from tb_minuta t1
left join tb_pedido_coleta t2 on t1.cod_minuta = t2.nr_minuta
left join tb_almox t3 on t2.cod_almox = t3.cod_almox
left join tb_pedido_coleta_produto t4 on t2.nr_pedido = t4.nr_pedido
where month(dt_minuta) = '$ds_mes' and t1.fl_status = 'F' and t2.fl_empresa = '$cod_cli'
group by t1.cod_minuta";
$res_prod = mysqli_query($link,$query_prod);

$link->close();
?>
<br><br>
<section>
  <div class="table-responsive-sm">
   <table id="RepIndCronExcelDtl" class="table table-bordered" width="100%" style="font-size: 12px">
     <tr>
      <th>Data programada para entrega</th>
      <th>Transporte</th>
      <th>Tipo de veículo</th>
      <th>Motorista</th>
      <th>Placa</th>
      <th>Origem</th>
      <th>Destino</th>
      <th>NF</th>
      <th>Valor Total</th>
      <th>Controle de averbação</th>
      <th>Canhoto das NF assinados?</th>
    </tr>
    <tbody id="listTbCronAt"> 
      <?php while ($dados = mysqli_fetch_assoc($res_prod)) {?>
        <tr class="odd gradeX">
          <td style="text-align: left;width:150px"><?php echo $dados['dt_transp']; ?></td>
          <td  style="width:100px"><?php echo $dados['ds_tipo']; ?></td>
          <td id="nr_at" contenteditable="true"  style="text-align: right;width:100px"></td>
          <td><?php echo $dados['ds_transporte']; ?></td>
          <td><?php echo $dados['nr_placa']; ?></td>
          <td><?php echo $dados['tp_veiculo']; ?></td>
          <td style="width:200px"><?php echo $dados['ds_almox']; ?></td>
          <td style="text-align: right;width:300px"><?php echo $dados['nr_dem']; ?></td>
          <td style="text-align: right;width:150px"><?php echo $dados['vlr_total']; ?></td>
          <td><?php echo $dados['nr_averba']; ?></td>
          <td><?php echo $dados['fl_comprovante']; ?></td>
        </tr>
      <?php }?>
    </tbody>
  </table>
</div>
</section>
<script type="text/javascript">
  $('#ExpExcelTransp').on('click', function(){
    event.preventDefault();
    $('#ExpExcelTransp').prop("disabled", true);
    var today = new Date();
    $("#RepIndCronExcelDtl").table2excel({
      name: "Relatório de transporte",
      filename: "Relatório de transporte"});
    $('#ExpExcelTransp').prop("disabled", false);

  });
</script>