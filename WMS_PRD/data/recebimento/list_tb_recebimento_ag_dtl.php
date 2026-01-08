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

$query_prod = "select t1.cod_recebimento, t1.dt_recebimento_previsto, t1.nm_fornecedor
from tb_recebimento_ag t1
left join tb_janela t2 on t1.cod_recebimento = t2.cod_rec
where month(t2.dt_janela) = month(curdate()) and t1.fl_status <> 'E' and t2.fl_empresa = '$cod_cli'
group by t1.cod_recebimento";
$res_prod = mysqli_query($link,$query_prod);

$link->close();
?>
<section>
  <div class="tableFixHead">
    <table id="" class="table" data-detail-view="" data-pagination="true" data-pagination-pre-text="< Previous" data-pagination-next-text="Next >" data-classes="table table-hover table-condensed" style="font-size: 12px">
     <tr>
      <th>CÓD. AGENDAMENTO</th>
      <th>DATA</th>
      <th>FORNECEDOR</th>
      <th>VOLUMES</th>
      <th>VEÍCULO</th>
      <th>OBSERVAÇÕES</th>
      <th>AGENDADO</th>
      <th>JANELA</th>
      <th>VALOR TOTAL NF</th>
      <th>NOTAS FISCAIS</th>
      <th>HORÁRIO CHEGADA</th>
      <th>INÍCIO DESCARGA</th>
      <th>FIM DESCARGA</th>
      <th>TEMPO DESCARGA</th>
      <th>TEMPO PERMANÊNCIA</th>
      <th>% TD/TP</th>
    </tr>
    <tbody id="listTbCronAt"> 
      <?php while ($dados = mysqli_fetch_assoc($res_prod)) {?>
        <tr class="odd gradeX">
          <td><?php echo $dados['cod_recebimento']; ?></td>
          <td><?php echo $dados['dt_previsto']; ?></td>
          <td><?php echo $dados['nm_fornecedor']; ?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      <?php }?>
    </tbody>
  </table>
</div>
</section>