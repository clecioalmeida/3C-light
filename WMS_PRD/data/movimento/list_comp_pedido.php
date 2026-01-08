<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST["dtl_ped"];

$select_produto = "select t1.cod_ped, t1.produto, t1.nr_pedido, format(t1.nr_qtde,0) as nr_qtde, t1.nr_doc_comp, t2. nm_produto, t3.ds_prateleira, t3.ds_coluna, t3.ds_altura, t3.nr_qtde as qtde_conf
from tb_pedido_coleta_produto t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
left join tb_pedido_conferencia t3 on t1.cod_ped = t3.cod_col and t1.nr_pedido = t3.nr_pedido
where t1.nr_pedido = '$nr_pedido' and t1.fl_tipo = 'C'";
$res_produto = mysqli_query($link,$select_produto);

?>
<?php
if ($res_produto) {
  ?>
  <div id="RetModalUpdPedido"></div>
  <table class="table">
    <thead>
      <tr>
        <th> CÓDIGO</th>
        <th> CÓDIGO SAP</th>
        <th> DESCRIÇÃO </th>
        <th> QUANTIDADE </th>
        <th colspan="3" style="text-align: center"> Endereço encontrado  </th>
        <th style="background-color: #C6E2FF"> Qtde coletada  </th>
        <th colspan="3" style="text-align: center;background-color: #C6E2FF"> Endereço coletado  </th>
        <th style="text-align: center"> Ações </th>
      </tr>
    </thead>
    <tbody>
      <?php 
      while($dados_produto=mysqli_fetch_assoc($res_produto)){

        ?>
        <tr>
          <td> <?php echo $dados_produto['cod_ped']; ?> </td>
          <td> <?php echo $dados_produto['produto']; ?> </td>
          <td> <?php echo $dados_produto['nm_produto']; ?> </td>
          <td style="text-align: right;"> <?php echo $dados_produto['nr_qtde']; ?> </td>
          <td style="text-align: right;"> <?php echo $dados_produto['ds_prateleira']; ?> </td>
          <td style="text-align: right;"> <?php echo $dados_produto['ds_coluna']; ?> </td>
          <td style="text-align: right;"> <?php echo $dados_produto['ds_altura']; ?> </td>
          <td contenteditable="true" id="nr_qtde" style="text-align: right"> <?php echo $dados_produto['qtde_conf']; ?> </td>
          <td contenteditable="true" id="ds_prateleira" style="text-align: right"> <?php echo $dados_produto['ds_prateleira']; ?> </td>
          <td contenteditable="true" id="ds_coluna" style="text-align: right"> <?php echo $dados_produto['ds_coluna']; ?> </td>
          <td contenteditable="true" id="ds_altura" style="text-align: right"> <?php echo $dados_produto['ds_altura']; ?> </td>
          <td style="text-align: center; width: 300px">
            <button type="submit" id="btnUpdCompPedido" class="btn btn-success btn-xs" value="<?php echo $dados_produto['cod_ped']; ?>">SALVAR</button>
            <button type="submit" id="btnDelCompPedido" class="btn btn-danger btn-xs" value="<?php echo $dados_produto['cod_ped']; ?>">EXCLUIR</button>
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