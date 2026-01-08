<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:../../index.php");
  exit;

}else{

  $id     = $_SESSION["id"];
  $cod_cli  = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$query_prod = "select t1.cod_nf_entrada, t1.nr_fisc_ent, t1.cod_rec, t1.ds_resp_div, t1.ds_div, t1.dt_sol_div, t1.ds_sol_div, t1.nr_ped_sap, t2.ds_divergencia, date_format(t1.dt_nf,'%d/%m/%Y') as dt_nf, t3.nm_fornecedor, t1.fl_status, CASE t1.fl_status WHEN 'D' THEN 'PENDENTE' WHEN 'S' THEN 'SOLUCIONADA' END as status, t1.nr_chamado
from tb_nf_entrada t1
left join tb_div_nf t2 on t1.ds_div = t2.id
left join tb_recebimento t3 on t1.cod_rec = t3.cod_recebimento
where (t1.fl_status = 'D' or t1.fl_status = 'S') and t3.fl_empresa = '$cod_cli'
group by t1.cod_nf_entrada";
$res_prod = mysqli_query($link,$query_prod);

$link->close();
?>
<style type="text/css">

  .tableFixHead          { overflow-y: auto; height: 640px; }
  .tableFixHead thead th { position: sticky; top: 0; }
  table  { border-collapse: collapse; width: 100%; }
  th, td { padding: 8px 16px; }
  th     { background:#eee; }

  /* CAMPO INPUT DENTRO DA TD */

  table td {
    position: relative;
  }

  table td input {
    position: absolute;
    display: block;
    top:0;
    left:0;
    margin: 0;
    height: 100%;
    width: 100%;
    border: none;
    padding: 10px;
    box-sizing: border-box;
    font-size: 12px;
    text-align: right;

    }table td select {
      position: absolute;
      display: block;
      top:0;
      left:0;
      margin: 0;
      height: 100%;
      width: 300px;
      border: none;
      padding: 10px;
      box-sizing: border-box;
      font-size: 12px;
      text-align: right;
    }

  </style>
  <fieldset id="retTbControlTransp">
    <section>
      <div class="tableFixHead">
        <table id="" class="table" data-detail-view="" data-pagination="true" data-pagination-pre-text="< Previous" data-pagination-next-text="Next >" data-classes="table table-hover table-condensed" style="font-size: 12px">
         <tr>
          <th>CÓDIGO RECEBIMENTO</th>
          <th>DATA</th>
          <th>FORNECEDOR</th>
          <th>NOTA FISCAL</th>
          <th>PEDIDO</th>
          <th>DIVERGÊNCIA</th>
          <th>RESPONSÁVEL</th>
          <th>DATA DA SOLUÇÃO</th>
          <th>SITUAÇÃO</th>
          <th>CHAMADO</th>
          <th>STATUS</th>
          <th>AÇÕES</th>
        </tr>
        <tbody id="listTbCronAt"> 
          <?php while ($dados = mysqli_fetch_assoc($res_prod)) {?>
            <tr class="odd gradeX">
              <td><?php echo $dados['cod_rec'];?></td>
              <td><?php echo $dados['dt_nf'];?></td>
              <td><?php echo $dados['nm_fornecedor'];?></td>
              <td><?php echo $dados['nr_fisc_ent'];?></td>
              <td><?php echo $dados['nr_ped_sap'];?></td>
              <td><?php echo $dados['ds_divergencia'];?></td>
              <td><?php echo $dados['ds_resp_div'];?></td>
              <td><?php echo $dados['dt_sol_div'];?></td>
              <td><?php echo $dados['ds_sol_div'];?></td>
              <td><?php echo $dados['nr_chamado'];?></td>
              <td><?php echo $dados['status'];?></td>
              <td>
                <button type="submit" id="btInsSolDiv" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">SOLUÇÃO</button>
                <button type="submit" id="btnDelDiv" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">EXCLUIR</button>
              </td>
            </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </section>
</fieldset>