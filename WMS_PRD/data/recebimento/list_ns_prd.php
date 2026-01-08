<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rec =$_POST["id_rec"];

$select_nf = "select t1.id, t1.id_produto, t1.cod_pedido, t1.cod_for_sap, t1.n_serie, t1.fl_status, t2.nm_produto
from tb_nserie t1
left join tb_produto t2 on t1.id_produto = t2.cod_prod_cliente
where t1.cod_rec = '$id_rec'";
$res_nf = mysqli_query($link, $select_nf);

$link->close();
?>
<table class="table" id="dt_basic5">
  <thead>
    <tr>
      <th style="text-align: center"> AÇÕES</th>
      <th style="text-align: right"> N.S. </th>
      <th style="text-align: right"> PRODUTO </th>
      <th style="text-align: right"> PEDIDO </th>
      <th style="text-align: right"> COD.FORNECEDOR</th>
    </tr>
  </thead>
  <tbody id="retNfRec">
    <?php
    while ($dados = mysqli_fetch_assoc($res_nf)) {
     ?>
     <tr class="odd gradeX">
      <td style="text-align: center; width: 250px">
        <button type="button" id="btnDelProdNfrec" class="btn btn-danger btn-xs" value="<?php echo $dados['id']; ?>" data-st="<?php echo $dados['fl_status']; ?>">EXCLUIR</button>
      </td>
      <td style="text-align: right"> <?php echo $dados['n_serie']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['id_produto']; ?> </td>
      <td> <?php echo $dados['nm_produto']; ?> </td>
      <td style="text-align: right;"> <?php echo $dados['cod_pedido']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['cod_for_sap']; ?> </td>
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