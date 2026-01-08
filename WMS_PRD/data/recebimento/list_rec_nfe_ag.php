<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$id_rec =$_POST["nf_rec"];

$select_nf = "select t1.cod_nf_entrada, t1.nr_fisc_ent, date_format(t1.dt_emis_ent,'%d/%m/%Y') as dt_emis_ent, t1.qtd_vol_ent, t1.nr_peso_ent, t1.tp_vol_ent, format(t1.vl_tot_nf_ent,2,'de_DE') as vl_tot_nf_ent, t2.nm_cliente, t3.fl_status
from tb_nf_entrada t1
left join tb_cliente t2 on t1.id_rem = t2.cod_cliente
left join tb_recebimento_ag t3 on t1.cod_ag = t3.cod_recebimento
where t1.cod_ag = '$id_rec' and t1.fl_status <> 'E'";
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
        <button type="submit" id="btnUpdNfRecAg" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">DETALHE</button>
        <button type="submit" id="btnDelNfrecAg" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">EXCLUIR</button>
      </td>
      <td style="text-align: right"> <?php echo $dados['nr_fisc_ent']; ?> </td>
      <td> <?php echo $dados['dt_emis_ent']; ?> </td>
      <td> <?php echo $dados['nm_cliente']; ?> </td>
      <td style="text-align: right;"> <?php echo $dados['nr_peso_ent']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['qtd_vol_ent']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['tp_vol_ent']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['vl_tot_nf_ent']; ?> </td>
    </tr>
  <?php }?>
</tbody>
</table>
<div id="retornoNfRec"></div>