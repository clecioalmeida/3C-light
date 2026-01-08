<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST["dtl_ped"];

$select_produto = "select t2.cod_col, t2.cod_ped, t2.fl_status, t2.produto, t2.nr_qtde_col as qtde, t5.cod_conferencia, coalesce(t5.nr_qtde,0) as qtde_conf, 
t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t5.ds_prateleira as rua_col, t5.ds_coluna as col_col, t5.ds_altura as altura_col, 
t3.nm_produto, t3.cod_produto, t3.cod_prod_cliente, t4.nome, t5.cod_conferencia, t6.ds_lp, t6.ds_serial
from tb_coleta_pedido t2
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
left join tb_armazem t4 on t2.ds_galpao = t4.id
left join tb_pedido_conferencia t5 on t2.cod_col = t5.cod_col and coalesce(t5.fl_status,'M') <> 'E'
left join tb_pedido_coleta_produto t6 on t2.cod_ped = t6.cod_ped
where t2.nr_pedido = '$nr_pedido'
group by t2.cod_col, t2.ds_prateleira,t2.ds_coluna, t2.ds_altura, t2.nr_qtde_col";
$res_produto = mysqli_query($link,$select_produto);

?>
<?php
if ($res_produto) {
  ?>
  <div id="RetModalUpdPedido"></div>
  <table class="table table-striped table-bordered" id="">
    <thead>
      <tr>
        <th> Código</th>
        <th> Código SAP</th>
        <th> LP</th>
        <th> Serial</th>
        <th> Descrição </th>
        <th> Qtde encontrada </th>
        <th colspan="4" style="text-align: center"> Endereço encontrado  </th>
        <th style="background-color: #C6E2FF"> Qtde coletada  </th>
        <th colspan="3" style="text-align: center;background-color: #C6E2FF"> Endereço coletado  </th>
        <th style="text-align: center"> Ações </th>
      </tr>
    </thead>
    <tbody id="retPrdPedido">
      <?php 
      while($dados_produto=mysqli_fetch_assoc($res_produto)){

        ?>
        <tr class="odd gradeX">
          <td> <?php echo $dados_produto['cod_ped']; ?> </td>
          <td id="cod_produto" data-col="<?php echo $dados_produto['cod_col']; ?>"> <?php echo $dados_produto['cod_prod_cliente']; ?> </td>
          <td> <?php echo $dados_produto['ds_lp']; ?> </td>
          <td> <?php echo $dados_produto['ds_serial']; ?> </td>
          <td> <?php echo $dados_produto['nm_produto']; ?> </td>
          <td style="text-align: right;"> <?php echo $dados_produto['qtde']; ?> </td>
          <td style="text-align: left;"> <?php echo $dados_produto['nome']; ?> </td>
          <td style="text-align: left;"> <?php echo $dados_produto['ds_prateleira']; ?> </td>
          <td style="text-align: right;"> <?php echo $dados_produto['ds_coluna']; ?> </td>
          <td style="text-align: right;"> <?php echo $dados_produto['ds_altura']; ?> </td>
          <td contenteditable="true" id="nr_qtde" style="text-align: right"> <?php echo $dados_produto['qtde_conf']; ?> </td>
          <td contenteditable="true" id="ds_prateleira" style="text-align: right"> <?php echo $dados_produto['rua_col']; ?> </td>
          <td contenteditable="true" id="ds_coluna" style="text-align: right"> <?php echo $dados_produto['col_col']; ?> </td>
          <td contenteditable="true" id="ds_altura" style="text-align: right"> <?php echo $dados_produto['altura_col']; ?> </td>
          <td style="text-align: center; width: 300px">
            <button type="submit" id="btnAtualizaCol" class="btn btn-info btn-xs" data-ped="<?php echo $nr_pedido; ?>" value="<?php echo $dados_produto['cod_conferencia']; ?>">ATUALIZAR</button>
            <!--button type="submit" id="btnAtualizaEnd" data-prd="<?php echo $dados_produto['cod_prod_cliente']; ?>" data-cod="<?php echo $dados_produto['cod_col']; ?>" class="btn btn-info btn-xs" value="<?php echo $nr_pedido; ?>">ATUALIZAR</button-->
            <input type="hidden" id="nrPedidoProdSep" value="<?php echo $nr_pedido;?>" name="">
            <button type="submit" id="btnUpdQtdeProdPedido" class="btn btn-success btn-xs" value="<?php echo $dados_produto['cod_produto']; ?>">EDITAR</button>
            <button type="submit" id="btnDelProdPedidoSep" data-prd="<?php echo $dados_produto['cod_prod_cliente']; ?>" data-col="<?php echo $dados_produto['cod_col']; ?>" class="btn btn-danger btn-xs" value="<?php echo $dados_produto['cod_conferencia']; ?>">Excluir</button>
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