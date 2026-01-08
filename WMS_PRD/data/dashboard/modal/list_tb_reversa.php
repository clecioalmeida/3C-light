 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $ds_mes = $_POST['ds_mes'];

 $query_prod="select id, 
 date_format(ds_data,'%d-%m-%Y') as ds_data,
 sum(COALESCE(nr_log_rev,0)) as nr_log_rev, 
 sum(COALESCE(log_rev_at,0)) as log_rev_at, 
 format(coalesce(((sum(log_rev_at)/sum(nr_log_rev)*-100)+100),0),2) as percent
 from tb_fc_avaria 
 where month(ds_data) = '$ds_mes' and fl_status = 'A' and fl_tipo = 'R'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td style="text-align: left;width:120px"><?php echo $dados['ds_data']; ?></td>
    <td id="nr_log_rev" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['nr_log_rev']; ?></td>
    <td id="log_rev_at" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['log_rev_at']; ?></td>
    <td id="percent" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['percent']; ?></td>
    <td style="text-align: left;width:250px">
        <button type="submit" class="btn btn-primary btn-xs btnSaveUpdRev" id="btnSaveUpdRev" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>">SALVAR</button>
        <button type="submit" class="btn btn-danger btn-xs" id="btnDelRev" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>">EXCLUIR</button>
    </td>
</tr>
<?php }?>