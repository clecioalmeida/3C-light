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
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$ds_mes = $_POST['ds_mes'];

$query_prod="select id, 
date_format(ds_data,'%d-%m-%Y') as ds_data,
nr_total_rec,
nr_total_ex
from tb_fc_rec 
where month(ds_data) = '$ds_mes' and fl_empresa = '$cod_cli' and nr_total_rec is not null ";
$res_prod = mysqli_query($link,$query_prod);

$link->close();

while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td style="text-align: left;width:120px"><?php echo $dados['ds_data']; ?></td>
    <td id="nr_total_rec" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['nr_total_rec']; ?></td>
    <td id="nr_total_ex" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['nr_total_ex']; ?></td>
    <td style="text-align: center;width:250px">
        <button type="submit" class="btn btn-primary btn-xs btnSaveUpdAgEx" id="btnSaveUpdAgEx" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>">SALVAR</button>
        <button type="submit" class="btn btn-danger btn-xs" id="btnDelAgEx" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
    </td>
  </tr>
<?php }?>