 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $ds_mes  = explode('-', $_POST['ds_mes']);

 $query_prod = "select DISTINCT t1.cod_almox, t2.ds_almox, CASE t3.ds_tipo when 'SPOT' THEN COUNT(DISTINCT t3.cod_minuta) ELSE '0' END as total_spot, CASE t4.ds_tipo when 'NORMAL' THEN COUNT(DISTINCT t4.cod_minuta) ELSE '0' END as total_normal
 from tb_pedido_coleta t1
 left join tb_almox t2 on t1.cod_almox = t2.cod_almox
 left join tb_minuta t3 on t1.nr_minuta = t3.cod_minuta
 left join tb_minuta t4 on t1.nr_minuta = t4.cod_minuta
 where month(t1.dt_limite) = '".$ds_mes[0]."' and year(t1.dt_limite) = '".$ds_mes[1]."'
 group by t1.cod_almox";
 $res_prod = mysqli_query($link,$query_prod);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
  <tr class="odd gradeX">
    <td style="text-align: left;width:300px"><?php echo $dados['cod_almox']." - ".$dados['ds_almox']; ?></td>
    <td style="text-align: right;width:50px"><?php echo $dados['total_spot']; ?></td>
    <td style="text-align: right;width:50px"><?php echo $dados['total_normal']; ?></td>
    <td style="text-align: right;width:50px">
      <?php 
      if($dados['total_spot']+$dados['total_normal'] == $dados['total_normal']){

       echo "0.00"; 

      }else{

        echo number_format(($dados['total_spot']+$dados['total_normal'])/$dados['total_normal'], 2, '.', '');
     }                       
     ?>
   </td>
   <td style="text-align: left;width:150px">
    <button type="submit" class="btn btn-primary btn-xs" id="btnUpdVeicFx" value="<?php echo $dados['id'];?>">ALTERAR</button>
    <button type="submit" class="btn btn-danger btn-xs" id="btnDelVeicFx" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
  </td>
</tr>
<?php }?>