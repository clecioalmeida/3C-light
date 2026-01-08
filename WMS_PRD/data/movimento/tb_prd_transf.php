<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"])){

    header("Location:../logout.php");
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

$cod_estoque = $_POST['cod_estoque'];

$select_mov = "select t1.cod_estoque, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_qtde, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.nome
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
left join tb_armazem t3 on t1.ds_galpao = t3.id
where t1.nr_posicao_temp = '$cod_estoque' and t2.fl_empresa = '$cod_cli'";
$res_mov = mysqli_query($link, $select_mov);

$link->close();
?>
<h5> Quantidades alocadas</h5>
<hr>
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
 <thead>
  <tr>
    <th> Código SAP</th>
    <th> Descrição </th>
    <th> Galpão </th>
    <th> Rua  </th>
    <th> Coluna  </th>
    <th> Altura  </th>
    <th> Qtde alocada  </th>
</tr>
</thead>
<tbody>
 <?php
 while ($dados_mov = mysqli_fetch_array($res_mov)) {?>
   <tr class="odd gradeX">
     <td style="width: 10%"> <?php echo $dados_mov['cod_prod_cliente']; ?> </td>
     <td style="width: 30%"> <?php echo $dados_mov['nm_produto']; ?> </td>
     <td style="width: 10%"> <?php echo $dados_mov['nome']; ?> </td>
     <td> <?php echo $dados_mov['ds_prateleira']; ?> </td>
     <td> <?php echo $dados_mov['ds_coluna']; ?> </td>
     <td> <?php echo $dados_mov['ds_altura']; ?> </td>
     <td> <?php echo $dados_mov['nr_qtde']; ?> </td>
 </tr>
<?php }?>
</tbody>
</table>