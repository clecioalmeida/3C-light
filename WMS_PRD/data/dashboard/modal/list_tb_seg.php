 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $id_ind = $_POST['id_ind'];

 $query_prod="select * from tb_fc_seg where id = '$id_ind'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td id="ds_data" contenteditable="true" style="text-align: left;width:150px"><?php echo $dados['ds_data']; ?></td>
    <!--td id="qtd_ipal_prev" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['qtd_ipal_prev']; ?></td>
    <td id="qtd_ipal_exe" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['qtd_ipal_exe']; ?></td-->
    <td id="nr_irreg_seg" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_irreg_seg']; ?></td>
    <td id="nr_acd_fat" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_acd_fat']; ?></td>
   <td style="text-align: left;width:150px">
    <button type="submit" class="btn btn-primary btn-xs btnSaveUpdSeg" id="btnSaveUpdSeg" value="<?php echo $dados['id'];?>">SALVAR</button>
    <button type="submit" class="btn btn-danger btn-xs" id="btnDelSeg" value="<?php echo $dados['id'];?>">EXCLUIR</button>
  </td>
</tr>
<?php }?>