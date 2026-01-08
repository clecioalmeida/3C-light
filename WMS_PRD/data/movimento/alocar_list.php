<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:../../index.php");
    exit;

}else{

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

if($cod_cli == "5"){

    $ds_galpao = "7";

}else{

    $ds_galpao = "7";

}

$SQL = "select t1.cod_estoque, t1.nr_or, t3.nome, format(t1.nr_qtde,0) as nr_qtde, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t4.nm_fornecedor 
from tb_posicao_pallet t1 
left join tb_produto t2 on t1.cod_produto = t2.cod_produto or t1.produto = t2.cod_prod_cliente
left join tb_armazem t3 on t1.ds_galpao = t3.id
left join tb_recebimento t4 on t1.nr_or = t4.cod_recebimento 
where t1.ds_galpao = '$ds_galpao' and t1.fl_status = 'A' and t1.nr_qtde > 0 and t1.fl_empresa = '$cod_cli'
group by t1.cod_estoque
order by t1.nr_or";
$res = mysqli_query($link,$SQL);
$tr = mysqli_num_rows($res); 


$link->close();
?>
<?php
if($tr>0){
    ?>
    <legend>Produtos</legend>
    <table class="table" id="sample_1">
        <thead>
            <tr>
              <th class="hasinput" style="width: 20px">
                <div class="form-group">
                  <label class="checkbox-inline">
                    <input type="checkbox" id="checkboxTodosAloc" class="checkbox style-0">
                    <span></span>
                </label>
            </div>
        </th>
        <th> Alocar</th>
        <th> Galpão</th>
        <th> Código </th>
        <th> Código SAP </th>
        <th> Descrição </th>
        <th> O.R.  </th>
        <th> Fornecedor </th>
        <th> Saldo a alocar </th>
    </tr>
</thead>
<tbody>
    <?php                                                           
    while($dados = mysqli_fetch_assoc($res)) 
        {?>
            <tr class="odd gradeX">
              <td>
                <div class="form-group">
                  <label class="checkbox-inline">
                    <input type="checkbox" class="checkbox style-0 checkAloc" id="checkAloc" value="<?php echo $dados['cod_estoque'];?>">
                    <span></span>
                </label>
            </div>
        </td>
        <td style="width: 15%"> 
            <!--button type="submit" id="btnAlocMan" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_estoque']; ?>">ALOCAR</button-->
            <button type="submit" id="btnAVolAloc" class="btn btn-success btn-xs" value="<?php echo $dados['cod_estoque']; ?>">VOLUMES</button>
            <button type="submit" id="btnADelAloc" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_estoque']; ?>">EXCLUIR</button>
        </td>
        <td style="text-align: left; width: 5%"> <?php echo $dados['nome']; ?> </td>
        <td style="text-align: right; width: 5%"> <?php echo $dados['cod_produto']; ?> </td>
        <td style="text-align: right; width: 5%"> <?php echo $dados['cod_prod_cliente']; ?> </td>
        <td style="text-align: left; width: 25%"> <?php echo $dados['nm_produto']; ?> </td>
        <td style="text-align: right; width: 5%"> <?php echo $dados['nr_or']; ?> </td>
        <td style="text-align: right; width: 25%"> <?php echo $dados['nm_fornecedor']; ?> </td>
        <td style="text-align: right; width: 25%"> <?php echo $dados['nr_qtde']; ?> </td>
    </tr>   
<?php } ?> 
</tbody>
</table>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkboxTodosAloc").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
  });
});
</script>
<?php }else{?>

    <h4>Nao foram encontradas alocações pendentes.</h4>

<?php }
?>