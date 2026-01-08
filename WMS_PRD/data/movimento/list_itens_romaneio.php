<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST["nr_ped"];

$select_produto = "select t2.cod_ped, t2.produto, t2.nr_qtde as qtde, t2.nr_volume, t3.nm_produto, t3.cod_produto, t3.cod_prod_cliente
from tb_pedido_coleta_produto t2
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
where t2.nr_pedido = '$nr_pedido'";
$res_produto = mysqli_query($link,$select_produto);

$sql_nfs = "select nr_nf_formulario, nr_serie, dt_emissao, vl_mercadoria from tb_nf_saida where nr_pedido = '$nr_pedido'";
$res_nfs = mysqli_query($link,$sql_nfs);

?>
<?php
if ($res_produto) {
	?>
  <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
    <thead>
      <tr>
        <th>
          <div class="form-group">
            <label class="checkbox-inline">
              <input type="checkbox" id="checkboxTodosExp" class="checkbox style-0">
              <span></span>
            </label>
          </div>
        </th>
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

        $sql_saldo = "select sum(nr_qtde_col) as qtde_col from tb_coleta_pedido where nr_pedido = '".$nr_pedido."' and produto = '".$dados_produto['produto']."'";
        $res_saldo = mysqli_query($link,$sql_saldo);
        $dados_saldo=mysqli_fetch_assoc($res_saldo);

        ?>
        <tr class="odd gradeX">
          <td>
          <div class="form-group">
            <label class="checkbox-inline">
              <input type="checkbox" class="checkbox style-0 checkPrdEtqExp" id="checkPrdEtqExp" value="<?php echo $dados_produto['produto'];?>" data-vol="<?php echo $dados_produto['nr_volume'];?>">
              <span></span>
            </label>
          </div>
          </td>
          <td class="atualiza"> <?php echo $dados_produto['cod_produto']; ?> </td>
          <td class="atualiza"> <?php echo $dados_produto['cod_prod_cliente']; ?> </td>
          <td class="atualiza"> <?php echo $dados_produto['nm_produto']; ?> </td>
          <td class="atualiza" style="text-align: right;"> <?php echo $dados_produto['qtde']; ?> </td>
          <td class="atualiza" style="text-align: right;"> <?php echo $dados_saldo['qtde_col']; ?> </td>
          <td class="atualiza" class="noExl" style="text-align: center; width: 300px">
            <!--button type="submit" id="btnPrintEtqPrdPed" class="btn btn-info btn-xs" value="<?php echo $dados_produto['cod_ped']; ?>">Etiqueta</button-->
            <input type="hidden" id="nrPedidoProd" value="<?php echo $nr_pedido;?>" name="">
            <button type="submit" id="btnUpdQtdeProdPedido" class="btn btn-success btn-xs" value="<?php echo $dados_produto['cod_ped']; ?>">Editar</button>
            <button type="submit" id="btnDelProdPedido" class="btn btn-danger btn-xs" value="<?php echo $dados_produto['cod_ped']; ?>">Excluir</button>
          </td>
        </tr>
      <?php } ?> 
    </tbody>
  </table>
  <legend>Nota fiscal de saída</legend>
  <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1" style="width: 500px">
    <thead>
      <tr>
        <th> Nota fiscal </th>
        <th> Série </th>
        <th> Emissão </th>
        <th> Valor total </th>
      </tr>
    </thead>
    <tbody>
      <?php 
      while($dados_nfs=mysqli_fetch_assoc($res_nfs)){
        ?>
        <tr class="odd gradeX">
          <td><?php echo $dados_nfs['nr_nf_formulario']; ?></td> 
          <td><?php echo $dados_nfs['nr_serie']; ?></td>
          <td><?php echo date('d/m/Y',strtotime($dados_nfs['dt_emissao'])); ?></td>
          <td><?php echo $dados_nfs['vl_mercadoria']; ?></td>
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
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkboxTodosPrd").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
    });
  });
</script>