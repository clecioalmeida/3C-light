<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$id_rec =$_POST["id_rec"];

$select_nf = "select t1.id, t1.cod_etq, t1.nr_docto, t1.cod_item, t1.nr_seq, t3.nr_fisc_ent, t2.produto, t4.cod_prod_cliente, t3.cod_nf_entrada, t2.cod_nf_entrada_item, t2.fl_status, t4.nm_produto
from tb_etiqueta t1
left join tb_nf_entrada_item t2 on t1.cod_item = t2.cod_nf_entrada_item
left join tb_nf_entrada t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
where t3.cod_rec = '$id_rec' and t1.fl_status <> 'E'
group by t1.id";
$res_nf = mysqli_query($link, $select_nf);

$link->close();
?>
<form class="form-horizontal" method="post" action="data/recebimento/relatorio/list_etq_rec_all_prd.php" id="" target="_blank" style="text-align: right;">
  <!--input type="hidden" class="input-xs" id="id_rec" name="id_item_prd" value="<?php //echo $id_item;?>" style="color: black"-->
  <input type="hidden" class="input-xs" id="id_rec" name="id_rec" value="<?php echo $id_rec;?>" style="color: black">
  <button type="submit" id="btnPrintEtqRecPrd" class="btn btn-success btn-xs" style="margin-right: 3px;width: 150px">IMPRIMIR CONSULTA</button>
  <table class="table" id="dt_basic5">
    <thead>
      <tr>
        <th class="hasinput" style="width: 20px">
          <div class="form-group">
            <label class="checkbox-inline">
              <input type="checkbox" id="checkboxTodosPrd" class="checkbox style-0">
              <span></span>
            </label>
          </div>
        </th>
        <th> Ações</th>
        <th> N.F. </th>
        <th> Cod. Produto </th>
        <th> Produto </th>
        <th> Sequencia </th>
        <!--th> Etiqueta </th-->
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
              <input type="checkbox" class="checkbox style-0 checkPrdEtqPend" id="checkPrdEtqPend" value="<?php echo $dados['cod_nf_entrada_item'];?>">
              <span></span>
            </label>
          </div>
        </td>
        <td style="text-align: center; width: 20px">
          <form class="form-horizontal" method="post" action="data/recebimento/relatorio/list_etq_rec.php" id="" target="_blank">
            <input type="hidden" class="input-xs" id="id_etq" name="id_etq" value="<?php echo $dados['id'];?>" style="color: black">
            <button type="submit" id="btnPrintEtqRecUn" class="btn btn-primary btn-xs">IMPRIMIR</button>
          </form>
          <!--button type="submit" id="btnDelEtqRecUn" class="btn btn-danger btn-xs" value="<?php //echo $dados['cod_etq']; ?>" data-st="<?php //echo $dados['fl_status'];?>" data-nf="<?php //echo $dados['cod_nf_entrada'];?>" data-it="<?php //echo $dados['cod_nf_entrada_item'];?>">EXCLUIR</button-->
        </td>
        <td style="text-align: right"> <?php echo $dados['nr_fisc_ent']; ?> </td>
        <td style="text-align: right"> <?php echo $dados['produto']; ?> </td>
        <td> <?php echo $dados['nm_produto']; ?> </td>
        <td style="text-align: right"> <?php echo $dados['nr_seq']; ?> </td>
      <!--td style="width: 80px;text-align: center; width: 200px">
        <svg id="barcode"
        class="barcode"
        jsbarcode-format="auto"
        jsbarcode-height="50"
        jsbarcode-displayValue="false"
        jsbarcode-value="<?php //echo $dados['produto']."-".$dados['cod_etq']; ?>"
        jsbarcode-textmargin="0"
        jsbarcode-fontoptions="bold">
      </svg>
    </td-->
  </tr>
<?php }?>
</tbody>
</table>
<div id="retornoNfRec"></div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkboxTodosPrd").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
    });
  });
</script>
<script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
  JsBarcode(".barcode").init();
</script>
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