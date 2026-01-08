<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$id_rec =$_POST["nf_rec"];

$select_nf = "select t2.cod_nf_entrada_item, t1.cod_nf_entrada, t1.nr_fisc_ent, t2.cod_nf_entrada_item, t2.produto, t4.nm_produto, t2.nr_ean, t2.nr_qtde, t2.nr_peso_unit, t2.ds_unid, coalesce(t2.nr_volume,0) as nr_volume, format(t2.vl_unit,2,'de_DE') as vl_unit, t3.fl_status,t2.fl_imp, t1.fl_status as status_nf
from tb_nf_entrada t1
inner join tb_nf_entrada_item t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
left join tb_recebimento t3 on t1.cod_rec = t3.cod_recebimento
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
where t1.cod_rec = '$id_rec' and t2.fl_status = 'A'
group by t2.cod_nf_entrada_item";
$res_nf = mysqli_query($link, $select_nf);

$link->close();
?>
<table class="table" id="sample_1">
  <thead>
    <tr>
      <th class="hasinput" style="width: 20px">
        <!--div class="form-group">
          <label class="checkbox-inline">
            <input type="checkbox" id="checkboxTodos" class="checkbox style-0">
            <span></span>
          </label>
        </div-->
      </th>
      <th> CÓDIGO </th>
      <th> N.F. </th>
      <th> COD.PRODUTO </th>
      <th> PRODUTO </th>
      <th> PESO (Kg)</th>
      <th> VOLUMES </th>
      <th> Tipo </th>
    </tr>
  </thead>
  <tbody id="retNfRec">
    <?php
    while ($dados = mysqli_fetch_assoc($res_nf)) {
     ?>
     <tr class="odd gradeX">
      <td>
        <div class="form-group">
          <label class="checkbox-inline">
            <input type="checkbox" class="checkbox style-0 checkEtq" id="checkEtq" value="<?php echo $dados['cod_nf_entrada_item'];?>" data-st="<?php echo $dados['status_nf'];?>" data-vl="<?php echo $dados['nr_volume'];?>">
            <span></span>
          </label>
        </div>
      </td>
      <td style="text-align: right"> <?php echo $dados['cod_nf_entrada_item']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['nr_fisc_ent']; ?> </td>
      <td> <?php echo $dados['produto']; ?> </td>
      <td> <?php echo $dados['nm_produto']; ?> </td>
      <td style="text-align: right;"> <?php echo $dados['nr_peso_unit']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['nr_volume']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['ds_unid']; ?> </td>
    </tr>
  <?php }?>
</tbody>
</table>
<div id="retornoNfRec"></div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkboxTodos").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(':checkbox').on('change', function() {
      var data = $(this).attr('data-vl');
      if(data == 0){

        alert("Volumes não foram gravados. Volte ao detalhe do recebimento e registre os volumes.");
        $(this).prop("disabled", true).prop('checked', false);
      }
    });
    
  });
</script>