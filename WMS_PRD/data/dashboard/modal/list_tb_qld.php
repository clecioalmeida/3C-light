 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $id_ind = $_POST['id_ind'];

 $query_prod="select  id, date_format(ds_data,'%d/%m/%Y') as ds_data, nr_sku_blq, format(vlr_sku_blq,2,'de_DE') as vlr_sku_blq, nr_est_qld, format(vlr_est_qld,2,'de_DE') as vlr_est_qld from tb_fc_qld where id = '$id_ind'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX" id="table">
    <td id="ds_data" contenteditable="true" style="text-align: left;width:150px"><?php echo $dados['ds_data']; ?></td>
    <td id="nr_sku_blq" class="nr_sku_blq" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_sku_blq']; ?></td>
    <td id="vlr_sku_blq" class="vlr_sku_blq" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['vlr_sku_blq']; ?></td>
    <td id="nr_est_qld" class="nr_est_qld" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_est_qld']; ?></td>
    <td id="vlr_est_qld" class="vlr_est_qld" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['vlr_est_qld']; ?></td>
   <td style="text-align: left;width:150px">
    <button type="submit" class="btn btn-primary btn-xs btnSaveUpdQld" id="btnSaveUpdQld" value="<?php echo $dados['id'];?>">SALVAR</button>
    <button type="submit" class="btn btn-danger btn-xs" id="btnDelQld" value="<?php echo $dados['id'];?>">EXCLUIR</button>
  </td>
</tr>
<?php }?>