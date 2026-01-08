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

$query_prod = "SELECT * from tb_div_nf where fl_empresa = '$cod_cli'";
$res_prod = mysqli_query($link,$query_prod);
$link->close();

while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td><?php echo $dados['id']; ?></td>
    <td>
      <input type="text" name="ds_divergencia" id="ds_divergencia" value="<?php echo $dados['ds_divergencia']; ?>" placeholder="DIGITE A DIVERGÊNCIA">
    </td>
    <td style="width: 150px">
      <button type="submit" id="btnEditDivNf" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">SALVAR</button>
      <button type="submit" id="btnDelDivNf" class="btn btn-danger btn-xs" value="<?php echo $dados['id']; ?>">EXCLUIR</button>
    </td>
  </tr>
  <?php }?>