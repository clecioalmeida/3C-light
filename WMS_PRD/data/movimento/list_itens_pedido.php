<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:index.php");
  exit;

}else{

  $id     = $_SESSION["id"];
  $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST["dtl_ped"];

$select_produto = "select t2.cod_ped, t2.produto, t2.ds_lp, t2.ds_kva, t2.ds_serial, date(t2.dt_chegada) as dt_chegada, t2.ds_prestadora, round(t2.nr_qtde,3) as qtde, t2.nr_volume, t3.nm_produto, t3.cod_produto, t3.cod_prod_cliente
from tb_pedido_coleta_produto t2
LEFT join tb_produto t3 on t2.produto = t3.cod_prod_cliente and t3.fl_empresa = '$cod_cli'
where t2.nr_pedido = '$nr_pedido' and t2.fl_status <> 'E'";
$res_produto = mysqli_query($link,$select_produto);

$sql_nfs = "select nr_nf_formulario, nr_serie, dt_emissao, vl_mercadoria from tb_nf_saida where nr_pedido = '$nr_pedido'";
$res_nfs = mysqli_query($link,$sql_nfs);

?>
<?php
if ($res_produto) {
	?>
  <table class="table" id="">
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
        <th> LP</th>
        <th> KVA</th>
        <th> SERIAL</th>
        <th> DT CHEGADA</th>
        <th> PRESTADORA</th>
        <th> Qtde solicitada </th>
        <th> Qtde encontrada  </th>
        <th> Ações </th>
      </tr>
    </thead>
    <tbody id="retPrdPedido">
      <?php 
      while($dados_produto=mysqli_fetch_assoc($res_produto)){
        $produto = $dados_produto['nm_produto'];
        $cod_ped = $dados_produto['cod_ped'];

        $sql_saldo = "select sum(nr_qtde_col) as qtde_col from tb_coleta_pedido where cod_ped = '".$cod_ped."' and fl_status <> 'E'";
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
          <td class="atualiza"> <?php echo $dados_produto['ds_lp']; ?> </td>
          <td class="atualiza"> <?php echo $dados_produto['ds_kva']; ?> </td>
          <td class="atualiza"> <?php echo $dados_produto['ds_serial']; ?> </td>
          <td class="atualiza"> <?php echo $dados_produto['dt_chegada']; ?> </td>
          <td class="atualiza"> <?php echo $dados_produto['ds_prestadora']; ?> </td>
          <td class="atualiza" style="text-align: right;"> <?php echo $dados_produto['qtde']; ?> </td>
          <td class="atualiza" style="text-align: right;"> <?php echo $dados_saldo['qtde_col']; ?> </td>
          <td class="atualiza" class="noExl" style="text-align: center; width: 300px">
            <!--button type="submit" id="btnPrintEtqPrdPed" class="btn btn-info btn-xs" value="<?php echo $dados_produto['cod_ped']; ?>">Etiqueta</button-->
            <input type="hidden" id="nrPedidoProd" value="<?php echo $nr_pedido;?>" name="">
            <input type="hidden" id="nrPedidoProdItem" value="<?php echo $dados_produto['cod_prod_cliente'];?>" name="">
            <button type="submit" id="btnUpdQtdeProdPedido" class="btn btn-success btn-xs" value="<?php echo $dados_produto['cod_ped']; ?>">Editar</button>
            <button type="submit" id="btnDelProdPedido" class="btn btn-danger btn-xs" value="<?php echo $dados_produto['cod_ped']; ?>">Excluir</button>
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
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkboxTodosPrd").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
    });
  });
</script>