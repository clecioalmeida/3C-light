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

 $ds_mes = $_POST['ds_mes'];

 $query_prod="select coalesce(nf_rec,0) as nf_rec, coalesce(nf_rec_div,0) as nf_rec_div, date_format(ds_data,'%d/%m/%Y') as ds_data, id from tb_fc_rec_sap where month(ds_data) = '$ds_mes' and fl_status = 'A' and fl_empresa = '$cod_cli'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td id="ds_data" contenteditable="true" style="text-align: left;width:150px"><?php echo $dados['ds_data']; ?></td>
    <td id="nf_rec" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nf_rec']; ?></td>
    <td id="nf_rec_div" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nf_rec_div']; ?></td>
    <td style="text-align: right;width:50px">
      <?php 
      if($dados['nf_rec'] > 0 && $dados['nf_rec_div']  > 0){

        echo number_format((($dados['nf_rec_div']/$dados['nf_rec'])*-100)+100, 2, '.', '');

      }else{

       echo "0.00"; 
     }                       
     ?>
   </td>
   <td style="text-align: left;width:150px">
    <button type="submit" class="btn btn-primary btn-xs btnUpdRecNf" id="btnUpdRecNf" value="<?php echo $dados['id'];?>">SALVAR</button>
    <button type="submit" class="btn btn-danger btn-xs" id="btnDelIndRec" value="<?php echo $dados['id'];?>">EXCLUIR</button>
  </td>
</tr>
<?php }?>