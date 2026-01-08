 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $id_ind = $_POST['id_ind'];

 $query_prod="select id, ds_data, format(sum(coalesce(vlr_total,0)),2,'de_DE') as vlr_total, format(avg(coalesce(vlr_medio,0)),2,'de_DE') as vlr_medio from tb_fc_est where id = '$id_ind'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td style="text-align: left;width:200px"><?php echo $dados['ds_data']; ?></td>
    <td id="vlr_total" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['vlr_total']; ?></td>
    <td id="vlr_medio" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['vlr_medio']; ?></td>
    <td style="text-align: left;width:150px">
      <button type="submit" class="btn btn-primary btn-xs" id="btnSaveUpdVlrEst" value="<?php echo $dados['id'];?>">SALVAR</button>
      <button type="submit" class="btn btn-danger btn-xs" id="btnDelCron" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
    </td>
  </tr>
  <?php }?>