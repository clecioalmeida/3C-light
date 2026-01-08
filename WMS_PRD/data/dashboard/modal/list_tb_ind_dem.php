 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $ds_mes = $_POST['ds_mes'];

 $query_prod="select coalesce(nr_trans_dep,0) as nr_trans_dep, coalesce(nr_dem_proc,0) as nr_dem_proc, date_format(ds_data,'%d/%m/%Y') as ds_data, id from tb_fc_rec_sap where month(ds_data) = '$ds_mes' and fl_status = 'A'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td id="ds_data" contenteditable="true" style="text-align: left;width:150px"><?php echo $dados['ds_data']; ?></td>
    <td id="nr_trans_dep" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_trans_dep']; ?></td>
    <td id="nr_dem_proc" contenteditable="true" style="text-align: right;width:100px"><?php echo $dados['nr_dem_proc']; ?></td>
    <td style="text-align: right;width:50px">
      <?php 
      if($dados['nr_trans_dep'] > 0 && $dados['nr_dem_proc']  > 0){

        echo number_format((($dados['nr_dem_proc']/$dados['nr_trans_dep'])*-100)+100, 2, '.', '');

      }else{

       echo "0.00"; 
     }                       
     ?>
   </td>
   <td style="text-align: left;width:150px">
    <button type="submit" class="btn btn-primary btn-xs btnSaveUpdIndDem" id="btnSaveUpdIndDem" value="<?php echo $dados['id'];?>">SALVAR</button>
    <button type="submit" class="btn btn-danger btn-xs" id="btnDelIndDem" value="<?php echo $dados['id'];?>">EXCLUIR</button>
  </td>
</tr>
<?php }?>