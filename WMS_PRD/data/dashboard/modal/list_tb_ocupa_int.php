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

?><?php 

 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $id_ind = $_POST['id_ind'];

 $sql_ocupa = "select id, ds_data, nr_total_sku, nr_pos_ocp, nr_ocupa_sku from tb_fc_est where id = '$id_ind'";
 $res_ocp = mysqli_query($link, $sql_ocupa);

 while ($ocupacao = mysqli_fetch_assoc($res_ocp)) {?>
  <tr class="odd gradeX">
    <td style="text-align: left;width:150px"><?php echo $ocupacao['ds_data']; ?></td>
    <td id="nr_total_sku" contenteditable="true" style="text-align: right;width:100px"><?php echo $ocupacao['nr_total_sku']; ?></td>
    <td id="nr_pos_ocp" contenteditable="true" style="text-align: right;width:100px"><?php echo $ocupacao['nr_pos_ocp']; ?></td>
    <td id="nr_ocupa_sku" contenteditable="true" style="text-align: right;width:100px"><?php echo $ocupacao['nr_ocupa_sku']."%"; ?></td>
    <td style="text-align: left;width:150px">
      <button type="submit" class="btn btn-primary btn-xs btnUpOcupInt" id="btnUpOcupInt" value="<?php echo $ocupacao['id'];?>">ALTERAR</button>
      <button type="submit" class="btn btn-danger btn-xs btnDelOcupInt" id="btnDelOcupInt" value="<?php echo $ocupacao['id'];?>" disabled>EXCLUIR</button>
  </td>
</tr>
<?php }

$link->close();

?>