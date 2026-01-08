 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $id_ind = $_POST['id_ind'];

 $query_prod="select id, ds_data, nr_qtd_sol, nr_qtd_at from tb_fc_qtd_at where id = '$id_ind'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td style="text-align: left;width:150px"><?php echo $dados['ds_data']; ?></td>
    <td id="nr_qtd_sol" contenteditable="true"  style="text-align: right;width:100px"><?php echo number_format($dados['nr_qtd_sol'],0); ?></td>
    <td id="nr_qtd_at" contenteditable="true"  style="text-align: right;width:100px"><?php echo number_format($dados['nr_qtd_at'],0); ?></td>
    <td style="text-align: right;width:50px">
      <?php 
      if($dados['nr_qtd_at'] > 0 && $dados['nr_qtd_sol']  > 0){

       echo number_format(($dados['nr_qtd_at']/$dados['nr_qtd_sol'])*100, 2, '.', '')."%";

     }else{

       echo "0.00%"; 
     }                       
     ?>
   </td>
   <td style="text-align: left;width:150px">
    <button type="submit" class="btn btn-primary btn-xs" id="btnSaveUpdQtdAt" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>">SALVAR</button>
    <button type="submit" class="btn btn-danger btn-xs" id="btnDelQtdAtCron" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
  </td>
</tr>
<?php }?>