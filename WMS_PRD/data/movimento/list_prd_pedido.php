<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_prd = $_POST["cod_prd"];
$nr_pedido = $_POST["nr_pedido"];

$select_produto = "select t2.cod_ped, t2.produto, t2.nr_qtde as qtde, t2.nr_volume, t3.nm_produto, t3.cod_produto, t3.cod_prod_cliente
from tb_pedido_coleta_produto t2
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
where t2.produto = '$cod_prd' and t2.nr_pedido = '$nr_pedido'";
$res_produto = mysqli_query($link,$select_produto);

?>
<?php
if ($res_produto) {
	?>
  <table class="table" id="sample_1">
    <thead>
      <tr>
        <th> Código</th>
        <th> Código SAP</th>
        <th> Descrição </th>
        <th> Qtde solicitada </th>
        <th> Qtde encontrada  </th>
        <th> Ações </th>
      </tr>
    </thead>
    <tbody id="retPrdPedido">
      <?php 
      while($dados_produto=mysqli_fetch_assoc($res_produto)){
        $produto = $dados_produto['nm_produto'];

        $sql_saldo = "select sum(nr_qtde_col) as qtde_col from tb_coleta_pedido where produto = '".$cod_prd."'";
        $res_saldo = mysqli_query($link,$sql_saldo);
        $dados_saldo=mysqli_fetch_assoc($res_saldo);

        ?>
        <tr class="odd gradeX">
          <td class="atualiza"> <?php echo $dados_produto['cod_produto']; ?> </td>
          <td class="atualiza"> <?php echo $dados_produto['cod_prod_cliente']; ?> </td>
          <td class="atualiza"> <?php echo $dados_produto['nm_produto']; ?> </td>
          <td class="atualiza" style="text-align: right;"> <?php echo $dados_produto['qtde']; ?> </td>
          <td class="atualiza" style="text-align: right;"> <?php echo $dados_saldo['qtde_col']; ?> </td>
          <td class="atualiza" class="noExl" style="text-align: center; width: 300px">
            <button type="submit" id="btnPrintEtqPrdPed" class="btn btn-info btn-xs" value="<?php echo $dados_produto['cod_produto']; ?>">Etiqueta</button>
            <input type="hidden" id="nrPedidoProd" value="<?php echo $nr_pedido;?>" name="">
            <button type="submit" id="btnUpdQtdeProdPedido" class="btn btn-success btn-xs" value="<?php echo $dados_produto['cod_produto']; ?>">Editar</button>
            <button type="submit" id="btnDelProdPedido" class="btn btn-danger btn-xs" value="<?php echo $dados_produto['cod_produto']; ?>">Excluir</button>
          </td>
        </tr>
      <?php } ?> 
    </tbody>
  </table>
  <div id="infoTarefasDia" class="row"></div>
<?php } else {?>
  <h4>Não há ondas ativas.</h4>
<?php }
$link->close();
?>