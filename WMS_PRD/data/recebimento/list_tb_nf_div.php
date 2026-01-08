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

 $id_rec     = $_POST['id_rec'];

$query_prod = "SELECT t1.cod_nf_entrada, t1.nr_fisc_ent, t1.ds_div, t1.ds_resp_div, t1.dt_limite_div, t1.dt_sol_div, t1.ds_sol_div, t2.ds_divergencia 
from tb_nf_entrada t1
left join tb_div_nf t2 on t1.ds_div = t2.id
where t1.cod_rec = '$id_rec' and t1.fl_status = 'D'";
$res_prod = mysqli_query($link,$query_prod);

$link->close();

while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td><?php echo $dados['nr_fisc_ent']; ?></td>
    <td><?php echo $dados['ds_divergencia']; ?></td>
    <td><?php echo $dados['ds_resp_div']; ?></td>
    <td><?php echo $dados['dt_limite_div']; ?></td>
    <td><?php echo $dados['dt_sol_div']; ?></td>
    <td><?php echo $dados['ds_sol_div']; ?></td>
  </tr>
  <?php }?>