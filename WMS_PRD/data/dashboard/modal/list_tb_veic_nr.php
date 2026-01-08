 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $id_ind = $_POST['id_ind'];

 $query_prod="select id, date_format(ds_data,'%d/%m/%Y') as ds_data, nr_veic_total, nr_veic_sp, nr_dia_total from tb_fc_veic where id = '$id_ind'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td style="text-align: left;width:100px"><?php echo $dados['ds_data']; ?></td>
    <td id="nr_veic_total" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_veic_total']; ?></td>
    <td id="nr_veic_sp" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_veic_sp']; ?></td>
    <td style="text-align: right;width:50px">
      <?php 
      if($dados['nr_veic_sp'] > 0 && $dados['nr_veic_total']  > 0){

        echo number_format(($dados['nr_veic_sp']/$dados['nr_dia_total']), 2, '.', '');

      }else{

       echo "0.00"; 
     }                       
     ?>
   </td>
   <td style="text-align: left;width:150px">
    <button type="submit" class="btn btn-primary btn-xs" id="btnSaveUpdVeicNr" value="<?php echo $dados['id'];?>">ALTERAR</button>
    <button type="submit" class="btn btn-danger btn-xs" id="btnDelCron" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
  </td>
</tr>
<?php }?>