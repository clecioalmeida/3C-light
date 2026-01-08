 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $ds_mes = $_POST['ds_mes'];

 $query_prod="select id, 
 date_format(ds_data,'%d-%m-%Y') as ds_data,
 sum(COALESCE(nr_total_sct,0)) as nr_total_sct, 
 sum(COALESCE(nr_sct_div,0)) as nr_sct_div, 
 format(coalesce(((sum(nr_sct_div)/sum(nr_total_sct)*-100)+100),0),2) as percent
 from tb_fc_avaria 
 where month(ds_data) = '$ds_mes' and fl_status = 'A' and fl_tipo = 'S'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td style="text-align: left;width:120px"><?php echo $dados['ds_data']; ?></td>
    <td id="nr_total_sct" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['nr_total_sct']; ?></td>
    <td id="nr_sct_div" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['nr_sct_div']; ?></td>
    <td id="percent" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['percent']; ?></td>
    <td style="text-align: left;width:250px">
        <button type="submit" class="btn btn-primary btn-xs btnSaveUpdSct" id="btnSaveUpdSct" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>">SALVAR</button>
        <button type="submit" class="btn btn-danger btn-xs" id="btnDelSct" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>">EXCLUIR</button>
    </td>
</tr>
<?php }?>