<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$id_rec =$_POST["id_rec"];

$select_nf = "select t1.cod_nf_entrada, t1.nr_fisc_ent, t2.cod_nf_entrada_item, t2.nm_produto, t2.nr_ean, t2.nr_qtde, t2.nr_peso_unit, t2.ds_unid, format(t2.vl_unit,2,'de_DE') as vl_unit, t3.fl_status,t2.fl_imp
from tb_nf_entrada t1
inner join tb_nf_entrada_item t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
left join tb_recebimento_ag t3 on t1.cod_ag = t3.cod_recebimento
where t1.cod_ag = '$id_rec' and t2.fl_status <> 'E'";
$res_nf = mysqli_query($link, $select_nf);

$link->close();
?>
<table class="table" id="dt_basic5">
  <thead>
    <tr>
      <th> Ações</th>
      <th> NFe </th>
      <th> Produto </th>
      <th> Quantidade </th>
      <th> Peso (Kg)</th>
      <th> Tipo volume </th>
      <th> Valor </th>
      <th> EAN  </th>
    </tr>
  </thead>
  <tbody id="retNfRec">
    <?php
    while ($dados = mysqli_fetch_assoc($res_nf)) {
     ?>
     <tr class="odd gradeX">
      <td style="text-align: center; width: 250px">
        <!--button type="submit" id="btnUpdPrdNfRec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada_item']; ?>">DETALHE</button-->
        <button type="submit" id="btnDelPrdNfrec" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_nf_entrada_item']; ?>">EXCLUIR</button>
      </td>
      <td style="text-align: right"> <?php echo $dados['nr_fisc_ent']; ?> </td>
      <td> <?php echo $dados['nm_produto']; ?> </td>
      <td style="text-align: right;"> <?php echo $dados['nr_qtde']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['nr_peso_unit']; ?> </td>
      <td> <?php echo $dados['ds_unid']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['vl_unit']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['nr_ean']; ?> </td>
    </tr>
  <?php }?>
</tbody>
</table>
<div id="retornoNfRec"></div>
<script type="text/javascript"> 
  $(document).ready(function() {

    pageSetUp();
    var responsiveHelper_dt_basic5 = undefined;

    var breakpointDefinition = {
      tablet : 1024,
      phone : 480
    };

    $('#dt_basic5').dataTable({
      "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
      "t"+
      "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
      "autoWidth" : true,
      "iDisplayLength": 100,
      "oLanguage": {
        "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
      },
      "preDrawCallback" : function() {
        if (!responsiveHelper_dt_basic5) {
          responsiveHelper_dt_basic5 = new ResponsiveDatatablesHelper($('#dt_basic5'), breakpointDefinition);
        }
      },
      "rowCallback" : function(nRow) {
        responsiveHelper_dt_basic5.createExpandIcon(nRow);
      },
      "drawCallback" : function(oSettings) {
        responsiveHelper_dt_basic5.respond();
      }
    });
  });

</script>