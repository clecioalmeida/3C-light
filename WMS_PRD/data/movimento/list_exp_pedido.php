<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST["dtl_ped"];

$select_produto = "select t1.cod_ped, t1.nr_pedido, t1.produto, coalesce(t1.nr_qtde,0) as nr_qtde, coalesce(t2.nr_qtde,0) as nr_qtde_conf, coalesce(t1.nr_qtde_exp,0) as nr_qtde_exp, t2.ds_galpao, t2.ds_prateleira,t2.ds_coluna, t2.ds_altura, t3.nm_produto
from tb_pedido_coleta_produto t1 
left join tb_pedido_conferencia t2 on t1.nr_pedido = t2.nr_pedido and t1.produto = t2.produto
left join tb_produto t3 on t1.produto = t3.cod_prod_cliente
where t1.nr_pedido = '$nr_pedido'
group by t1.produto";
$res_produto = mysqli_query($link,$select_produto);

?>
<?php
if ($res_produto) {
  ?>
  <div id="RetModalUpdPedido"></div>
  <table class="table table-striped table-bordered" id="">
    <thead>
      <tr>
        <th> CÓDIGO</th>
        <th> CÓDIGO SAP</th>
        <th> DESCRIÇÃO </th>
        <th style="background-color: #C6E2FF"> QTDE SEPARADA </th>
        <th colspan="3" style="text-align: center"> ENDEREÇO  </th>
        <th style="background-color: #C6E2FF"> QTDE CONFERIDA  </th>
        <th style="text-align: center"> AÇÕES </th>
      </tr>
    </thead>
    <tbody id="retPrdPedido">
      <?php 
      while($dados_produto=mysqli_fetch_assoc($res_produto)){

        ?>
        <tr class="odd gradeX">
          <td> <?php echo $dados_produto['cod_ped']; ?> </td>
          <td id="cod_produto" data-col="<?php echo $dados_produto['produto']; ?>"> <?php echo $dados_produto['produto']; ?> </td>
          <td> <?php echo $dados_produto['nm_produto']; ?> </td>
          <td style="text-align: right;background-color: #C6E2FF"> <?php echo $dados_produto['nr_qtde_conf']; ?> </td>
          <td style="text-align: left;"> <?php echo $dados_produto['ds_prateleira']; ?> </td>
          <td style="text-align: right;"> <?php echo $dados_produto['ds_coluna']; ?> </td>
          <td style="text-align: right;"> <?php echo $dados_produto['ds_altura']; ?> </td>
          <td contenteditable="true" id="nr_qtde_exp" style="text-align: right;background-color: #C6E2FF"> <?php echo $dados_produto['nr_qtde_exp']; ?> </td>
          <td style="text-align: center; width: 300px">
            <button type="submit" id="btnAtualizaConf" class="btn btn-info btn-xs" data-ped="<?php echo $nr_pedido; ?>" value="<?php echo $dados_produto['cod_ped']; ?>">ATUALIZAR</button>
            <input type="hidden" id="nrPedidoProd" value="<?php echo $nr_pedido;?>" name="">
          </td>
        </tr>
      <?php } ?> 
    </tbody>
  </table>
<?php } else {?>
  <h4>Dados não encontrados.</h4>
<?php }
$link->close();
?>