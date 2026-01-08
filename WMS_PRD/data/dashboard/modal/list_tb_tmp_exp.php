 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $dt_exp = $_POST['dt_exp'];

 $query_prod="select distinct t1.nr_pedido, t1.doc_material, t1.cod_almox, t3.ds_almox, date(t2.dt_expedido) as dt_expedido, date(t1.dt_limite) as dt_cronograma 
 from tb_pedido_coleta t1
 left join tb_minuta t2 on t1.nr_minuta = t2.cod_minuta
 left join tb_almox t3 on t1.cod_almox = t3.cod_almox
 where date(dt_expedido) = '$dt_exp'";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td id="ds_data" contenteditable="true" style="text-align: left;width:50px"><?php echo $dados['nr_pedido']; ?></td>
    <td id="qtd_ipal_prev" contenteditable="true" style="text-align: right;width:50px"><?php echo $dados['doc_material']; ?></td>
    <td id="qtd_ipal_exe" contenteditable="true" style="text-align: left;width:300px"><?php echo $dados['cod_almox']."-".$dados['ds_almox']; ?></td>
    <td id="nr_irreg_seg" contenteditable="true" style="text-align: center;width:150px"><?php echo $dados['dt_cronograma']; ?></td>
    <td id="nr_acd_fat" contenteditable="true" style="text-align: center;width:150px"><?php echo $dados['dt_expedido']; ?></td>
  </tr>
  <?php }?>