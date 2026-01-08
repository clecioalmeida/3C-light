 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $ds_mes = $_POST['ds_mes'];

 $query_prod="select id, 
 date_format(ds_data,'%d-%m-%Y') as ds_data,
 sum(COALESCE(sku_int,0)) as sku_int, 
 sum(COALESCE(vlr_int,0)) as vlr_int, 
 sum(COALESCE(sku_for,0)) as sku_for, 
 sum(COALESCE(vlr_for,0)) as vlr_for, 
 sum(COALESCE(sku_cli,0)) as sku_cli, 
 sum(COALESCE(vlr_cli,0)) as vlr_cli, 
 sum(COALESCE(sku_total,0)) as sku_total,
 sum(COALESCE(vlr_total,0)) as vlr_total
 from tb_fc_avaria 
 where month(ds_data) = '$ds_mes' and fl_status = 'A' and fl_tipo = 'A'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td style="text-align: left;width:120px"><?php echo $dados['ds_data']; ?></td>
    <td id="sku_int" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['sku_int']; ?></td>
    <td id="vlr_int" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['vlr_int']; ?></td>
    <td id="sku_for" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['sku_for']; ?></td>
    <td id="vlr_for" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['vlr_for']; ?></td>
    <td id="sku_cli" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['sku_cli']; ?></td>
    <td id="vlr_cli" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['vlr_cli']; ?></td>
    <td id="sku_total" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['sku_total']; ?></td>
    <td id="vlr_total" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['vlr_total']; ?></td>
    <td style="text-align: left;width:250px">
        <button type="submit" class="btn btn-primary btn-xs btnSaveUpdAv" id="btnSaveUpdAv" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>">SALVAR</button>
        <button type="submit" class="btn btn-danger btn-xs" id="btnDelAv" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>">EXCLUIR</button>
    </td>
</tr>
<?php }?>