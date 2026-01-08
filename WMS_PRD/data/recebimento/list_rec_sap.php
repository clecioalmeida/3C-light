<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:../../index.php");
  exit;

}else{

  $id     = $_SESSION["id"];
  $id_oper  = $_SESSION["cod_cli"];
}
?>
<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$id_rec =$_POST["id_rec"];

$select_nf = "select t1.cod_recebimento, t1.ds_kva, t1.ds_lp, t1.ds_fabr, t1.ds_ano, t1.ds_enr, t1.ds_oleo, t1.nr_qtde, 
t1.nr_peso_previsto, t1.nr_volume_previsto, t1.fl_status, t4.cod_produto as cod_wms, t4.nm_produto, t4.cod_prod_cliente
from tb_recebimento_ag t1
left join tb_produto t4 on t1.cod_produto = t4.cod_prod_cliente
where t1.cod_recebimento = '$id_rec' and t1.fl_status <> 'E' and t4.fl_status <> 'E' and t4.fl_empresa = '$id_oper'
order by t1.cod_produto asc";
$res_nf = mysqli_query($link, $select_nf);

$link->close();
?>
<table class="table" id="dt_basic5">
  <thead>
    <tr>
      <th> AÇÕES</th>
      <th> CÓDIGO WMS </th>
      <th> PRODUTO </th>
      <th> DESCRIÇÃO </th>
      <th> QUANTIDADE </th>
      <th> PESO (Kg)</th>
      <th> VOLUMES </th>
      <th> KVA </th>
      <th> LP </th>
      <th> FABRICAÇÃO </th>
      <th> ANO </th>
      <th> ENROLAMENTO </th>
      <th> OLEO </th>
    </tr>
  </thead>
  <tbody id="retNfRec">
    <?php
    while ($dados = mysqli_fetch_assoc($res_nf)) {
     ?>
     <tr class="odd gradeX">
      <td style="text-align: center; width: 250px">
        <?php 
        if($dados['fl_imp'] == "S"){

          $dtl = '<button type="button" id="btnUpdPrdNfRec" class="btn btn-primary btn-xs" value="'.$dados['cod_nf_entrada_item'].'">DETALHE</button>';

        }else{

          $dtl = '<button type="button" id="btnUpdPrdNfRec" class="btn btn-primary btn-xs" value="'.$dados['cod_nf_entrada_item'].'">DETALHE</button>';

        }

        echo $dtl;
        ?>
        
        <button type="button" id="btnDelProdNfrec" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_nf_entrada_item']; ?>" data-st="<?php echo $dados['fl_status']; ?>">EXCLUIR</button>
      </td>
      <td> <?php echo $dados['cod_wms']; ?> </td>
      <td> <?php echo $dados['cod_prod_cliente']; ?> </td>
      <td> <?php echo $dados['nm_produto']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['nr_qtde']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['nr_peso_previsto']; ?> </td>
      <td> <?php echo $dados['nr_volume_previsto']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['ds_kva']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['ds_lp']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['ds_fabr']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['ds_ano']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['ds_enr']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['ds_oleo']; ?> </td>
    </tr>
  <?php }?>
</tbody>
</table>
<div id="retornoNfRec"></div>