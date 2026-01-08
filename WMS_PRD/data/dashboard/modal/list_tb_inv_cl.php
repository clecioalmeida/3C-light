 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $id_ind = $_POST['id_ind'];

 $query_prod="select id, ds_data, nr_sku_qtde, nr_sku_falta, nr_sku_sobra, nr_ac_sku, format(vlr_ini,2,'de_DE') as vlr_ini, format(vlr_sobra,2,'de_DE') as vlr_sobra, format(vlr_falta,2,'de_DE') as vlr_falta, format(vlr_fim,2,'de_DE') as vlr_fim, vlr_div 
from tb_fc_inv_dep 
where id = '$id_ind'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td id="ds_data" contenteditable="true" style="text-align: left;width:150px"><?php echo $dados['ds_data']; ?></td>
    <td id="nr_sku_qtde" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_sku_qtde']; ?></td>
    <td id="nr_sku_sobra" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_sku_sobra']; ?></td>
    <td id="nr_sku_falta" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_sku_falta']; ?></td>
    <td id="nr_ac_sku" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_ac_sku']; ?></td>
    <td id="vlr_ini" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['vlr_ini']; ?></td>
    <td id="vlr_sobra" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['vlr_sobra']; ?></td>
    <td id="vlr_falta" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['vlr_falta']; ?></td>
    <td id="vlr_fim" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['vlr_fim']; ?></td>
    <td id="vlr_div" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['vlr_div']; ?></td>
   <td style="text-align: left;width:150px">
    <button type="submit" class="btn btn-primary btn-xs btnSaveUpdInvCl" id="btnSaveUpdInvCl" value="<?php echo $dados['id'];?>">SALVAR</button>
    <button type="submit" class="btn btn-danger btn-xs" id="btnDelInvDep" value="<?php echo $dados['id'];?>">EXCLUIR</button>
  </td>
</tr>
<?php }?>