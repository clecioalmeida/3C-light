 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $id_ind = $_POST['id_ind'];

 $query_prod="select  id, date_format(ds_data,'%d/%m/%Y') as ds_data, nr_prazo, nr_atraso from tb_fc_tran where id = '$id_ind'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX" id="table">
    <td id="ds_data" contenteditable="true" style="text-align: left;width:150px"><?php echo $dados['ds_data']; ?></td>
    <td id="nr_prazo" class="nr_prazo" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_prazo']; ?></td>
    <td style="text-align: right;width:100px"><?php echo $dados['nr_atraso']; ?></td>
   <td style="text-align: left;width:150px">
    <button type="submit" class="btn btn-primary btn-xs btnSaveUpdTran" id="btnSaveUpdTran" value="<?php echo $dados['id'];?>">SALVAR</button>
    <button type="submit" class="btn btn-danger btn-xs" id="btnDelTran" value="<?php echo $dados['id'];?>">EXCLUIR</button>
  </td>
</tr>
<?php }?>