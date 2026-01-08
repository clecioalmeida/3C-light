<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["cod_cli"])){

    header("Location:../logout.php");
    exit;

}else{

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$id_rec =$_POST["id_rec"];

if($cod_cli == '5'){

    $rec = '7';

}else if($cod_cli == '6'){

    $rec = '18';

}else if($cod_cli == '7'){

    $rec = '27';

}else if($cod_cli == '8'){

    $rec = '33';

}else{

    $rec = "0";

}

$select_nf = "select t1.produto, t1.ds_galpao, t2.nome, t3.nm_produto, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_qtde
from tb_posicao_pallet t1
left join tb_armazem t2 on t1.ds_galpao = t2.id
left join tb_produto t3 on t1.produto = t3.cod_prod_cliente
where t1.nr_or = '$id_rec' and t1.ds_galpao <> '$rec'";
$res_nf = mysqli_query($link, $select_nf);

$link->close();
?>
<table class="table" id="">
  <thead>
    <tr>
      <th> PRODUTO </th>
      <th> DESCRIÇÃO </th>
      <th> LOCAL </th>
      <th> RUA</th>
      <th> COLUNA </th>
      <th> ALTURA </th>
      <th> QUANTIDADE </th>
    </tr>
  </thead>
  <tbody id="">
    <?php
    while ($dados = mysqli_fetch_assoc($res_nf)) {
     ?>
     <tr class="odd gradeX">
      <td style="text-align: right"> <?php echo $dados['produto']; ?> </td>
      <td> <?php echo $dados['nm_produto']; ?> </td>
      <td> <?php echo $dados['nome']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['ds_prateleira']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['ds_coluna']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['ds_altura']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['nr_qtde']; ?> </td>
    </tr>
  <?php }?>
</tbody>
</table>
<div id="retornoNfRec"></div>