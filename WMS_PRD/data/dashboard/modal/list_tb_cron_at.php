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

  $ds_ind = $_POST['ds_ind'];

  $query_prod="select id, ds_data, nr_total_ped, nr_total_em from tb_fc_qtd_at where id = '$ds_ind' and fl_empresa = '$cod_cli'";
  $res_prod = mysqli_query($link,$query_prod);

  $link->close();

  while ($dados = mysqli_fetch_assoc($res_prod)) {?>
    <tr class="odd gradeX">
      <td style="text-align: left;width:150px"><?php echo $dados['ds_data']; ?></td>
      <td id="nr_ped" contenteditable="true"  style="text-align: right;width:100px"><?php echo $dados['nr_total_ped']; ?></td>
      <td id="nr_at" contenteditable="true"  style="text-align: right;width:100px"><?php echo $dados['nr_total_em']; ?></td>
      <td style="text-align: right;width:50px">
        <?php 
        if($dados['nr_total_ped'] > 0 && $dados['nr_total_ped']  > 0){

         echo number_format(($dados['nr_total_em']/$dados['nr_total_ped'])*100, 2, '.', '')."%";

       }else{

         echo "0.00%"; 
       }                       
       ?>
     </td>
     <td style="text-align: left;width:150px">
      <button type="submit" class="btn btn-primary btn-xs" id="btnSaveUpdIndCron" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>">SALVAR</button>
      <button type="submit" class="btn btn-danger btn-xs" id="btnDelIndCron" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
    </td>
  </tr>
  <?php }?>