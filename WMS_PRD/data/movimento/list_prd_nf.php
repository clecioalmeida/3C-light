<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST['nr_pedido'];

$select_mov = "select t1.produto, t1.nr_qtde, t2.nm_produto
from tb_pedido_conferencia t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
left join tb_pedido_coleta t3 on t1.nr_pedido = t3.nr_pedido
where t1.nr_pedido = '$nr_pedido'";
$res_mov = mysqli_query($link, $select_mov);

$link->close();
?>
<h5>PRODUTOS</h5>
<hr>
<table class="table" style="width: 80%">
 <thead>
  <tr>
    <th> CÓD SAP</th>
    <th> DESCRIÇÃO </th>
    <th> QTDE  </th>
    <th colspan="2"> VALOR UNIT.  </th>
    <th> AÇÕES  </th>
</tr>
</thead>
<tbody>
 <?php
 while ($dados_mov = mysqli_fetch_array($res_mov)) {?>
   <tr>
     <td> <?php echo $dados_mov['produto']; ?> </td>
     <td> <?php echo $dados_mov['nm_produto']; ?> </td>
     <td style="text-align: right;"> <?php echo $dados_mov['nr_qtde']; ?> </td>
     <td contenteditable="true" id="vl_unit" style="text-align: right;background-color: #D3D3D3;width: 100px">  </td>
      <td style="text-align: right;width: 70px;background-color: #D3D3D3"><button type="button" id="btnSaveVlNfSaida" value="<?php echo $dados['nr_pedido'];?>" data_prd="<?php echo $dados_mov['produto']; ?>">Gravar</button></td>
     <td>  </td>
 </tr>
<?php }?>
</tbody>
</table>