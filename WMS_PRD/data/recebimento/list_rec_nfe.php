<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$id_rec =$_POST["nf_rec"];

$select_nf = "select t1.cod_nf_entrada, t1.nr_fisc_ent, date_format(t1.dt_emis_ent,'%d/%m/%Y') as dt_emis_ent, t1.qtd_vol_ent, t1.nr_peso_ent, t1.tp_vol_ent, format(t1.vl_tot_nf_ent,2,'de_DE') as vl_tot_nf_ent, t2.nm_cliente, t3.fl_status, t4.nm_fornecedor, concat('R$ ',format(sum(t5.vl_total),2,'de_de')) as valor_total
from tb_nf_entrada t1
left join tb_cliente t2 on t1.id_rem = t2.cod_cliente or t2.cod_sap =  t1.cod_fornecedor
left join tb_recebimento t3 on t1.cod_rec = t3.cod_recebimento
left join tb_fornecedor t4 on t1.cod_fornecedor = t4.cod_sap
left join tb_nf_entrada_item t5 on t1.cod_nf_entrada = t5.cod_nf_entrada
where t1.cod_rec = '$id_rec' and t1.fl_status <> 'E'
group by t1.cod_nf_entrada";
$res_nf = mysqli_query($link, $select_nf);

$link->close();
?>
<table class="table" id="sample_1">
  <thead>
    <tr>
      <th> Ações</th>
      <th> N.F. </th>
      <th> Emissão </th>
      <th> Fornecedor </th>
      <th> Peso (Kg)</th>
      <th> Volumes </th>
      <th> Tipo </th>
      <th> Valor  </th>
    </tr>
  </thead>
  <tbody id="retNfRec">
    <?php
    while ($dados = mysqli_fetch_assoc($res_nf)) {
     ?>
     <tr class="odd gradeX">
      <td style="text-align: center; width: 250px">
        <button type="submit" id="btnUpdNfRec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">DETALHE</button>
        <button type="submit" id="btnDelNfrec" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>" data-or="<?php echo $id_rec;?>" data-st="<?php echo  $dados['fl_status'];?>">EXCLUIR</button>
      </td>
      <td style="text-align: right"> <?php echo $dados['nr_fisc_ent']; ?> </td>
      <td> <?php echo $dados['dt_emis_ent']; ?> </td>
      <td> <?php echo $dados['nm_fornecedor']; ?> </td>
      <td style="text-align: right;"> <?php echo $dados['nr_peso_ent']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['qtd_vol_ent']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['tp_vol_ent']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['valor_total']; ?> </td>
    </tr>
  <?php }?>
</tbody>
</table>
<div id="retornoNfRec"></div>