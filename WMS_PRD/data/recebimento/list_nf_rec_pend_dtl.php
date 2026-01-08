<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:../../index.php");
  exit;

}else{

  $id       = $_SESSION["id"];
  $cod_cli  = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$dt_ini_div   = $_POST["dt_ini_div"];
$dt_fim_div   = $_POST["dt_fim_div"];

$query_prod = "select t1.cod_nf_entrada, t1.nr_fisc_ent, t1.cod_rec, t1.ds_div, t2.ds_divergencia, date_format(t1.dt_nf,'%d/%m/%Y') as dt_nf, t3.nm_fornecedor, t1.fl_status, CASE t1.fl_status WHEN 'D' THEN 'PENDENTE' WHEN 'S' THEN 'SOLUCIONADA' END as status
from tb_nf_entrada t1
left join tb_div_nf t2 on t1.ds_div = t2.id
left join tb_recebimento t3 on t1.cod_rec = t3.cod_recebimento
where t1.dt_nf >= '$dt_ini_div' and t1.dt_nf <= '$dt_fim_div' and t1.ds_div > 0 and t1.fl_empresa = '$cod_cli'
group by t3.cod_recebimento";
$res_prod = mysqli_query($link,$query_prod);

$link->close();
?>
  <section>
  <div class="">
    <table id="" class="table" data-detail-view="" data-pagination="true" data-pagination-pre-text="< Previous" data-pagination-next-text="Next >" data-classes="table table-hover table-condensed" style="font-size: 12px">
       <tr>
        <th>CÓDIGO RECEBIMENTO</th>
        <th>DATA</th>
        <th>FORNECEDOR</th>
        <th>NOTA FISCAL</th>
        <th>DIVERGÊNCIA</th>
        <th>STATUS</th>
      </tr>
      <tbody id="listTbCronAt"> 
        <?php while ($dados = mysqli_fetch_assoc($res_prod)) {?>
          <tr class="odd gradeX">
            <td><?php echo $dados['cod_rec']; ?></td>
            <td><?php echo $dados['dt_nf']; ?></td>
            <td><?php echo $dados['nm_fornecedor']; ?></td>
            <td><?php echo $dados['nr_fisc_ent']; ?></td>
            <td><?php echo $dados['ds_divergencia']; ?></td>
            <td><?php echo $dados['status']; ?></td>
          </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
</section>