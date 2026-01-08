 <?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id         = $_SESSION["id"];
  $cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $query_transp = "select * from tb_fc_est where fl_tipo = 'I' and fl_empresa = '$cod_cli'";
 $res_transp = mysqli_query($link, $query_transp);

 
 while ($dados = mysqli_fetch_assoc($res_transp)) {?>
  <tr class="odd gradeX">
    <td style="text-align: left;width:100px"><?php echo $dados['ds_data']; ?></td>
    <td style="text-align: right;width:100px"><?php echo $dados['nr_total_sku']; ?></td>
    <td style="text-align: right;width:100px"><?php echo $dados['nr_pos_ocp']; ?></td>
    <td style="text-align: right;width:100px"><?php echo $dados['nr_ocupa_sku']."%"; ?></td>
    <td style="text-align: left;width:150px">
      <button type="submit" class="btn btn-primary btn-xs" id="btnUpdDem" value="<?php echo $dados['id'];?>">ALTERAR</button>
      <button type="submit" class="btn btn-danger btn-xs" id="btnDelDem" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
  </td>
</tr>
<?php }

$link->close();

?>