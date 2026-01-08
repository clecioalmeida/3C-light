<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$id_rec =$_POST["id_rec"];

$select_nf = "select t1.id, t1.cod_etq, t1.nr_docto, t1.cod_item, t1.nr_seq, t1.nr_qtde, t1.fl_status as status_etq, t2.produto, t4.cod_prod_cliente, t2.cod_nf_entrada, t2.cod_nf_entrada_item, t2.fl_status, t4.nm_produto, t3.nr_fisc_ent
from tb_etiqueta t1
left join tb_nf_entrada_item t2 on t1.cod_item = t2.cod_nf_entrada_item
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
left join tb_nf_entrada t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
where t2.cod_rec = '$id_rec' and t1.fl_status <> 'E'
group by t1.id";
$res_nf = mysqli_query($link, $select_nf);

$link->close();
?>
<table class="table" id="dt_basic5">
  <thead>
    <tr>
      <!--th class="hasinput" style="width: 20px">
        <div class="form-group">
          <label class="checkbox-inline">
            <input type="checkbox" id="checkboxTodosPrd" class="checkbox style-0">
            <span></span>
          </label>
        </div>
      </th-->
      <th> Ações</th>
      <th> N.F. </th>
      <th> Cod. Produto </th>
      <th> Produto </th>
      <th> Sequencia </th>
      <th> Código </th>
      <th colspan="2"> Quantidade </th>
      <th> Status </th>
      <!--th> Etiqueta </th-->
    </tr>
  </thead>
  <tbody id="retNfRec">
    <?php
    while ($dados = mysqli_fetch_assoc($res_nf)) {
     ?>
     <tr class="odd gradeX">
      <!--td>
        <div class="form-group">
          <label class="checkbox-inline">
            <input type="checkbox" class="checkbox style-0 checkPrdEtq" id="checkPrdEtq" value="<?php echo $dados['cod_nf_entrada'];?>">
            <span></span>
          </label>
        </div>
      </td-->
      <td style="text-align: center; width: 150px">
        <form class="form-horizontal" method="post" action="data/recebimento/relatorio/list_etq_rec.php" id="" target="_blank">
          <input type="hidden" class="input-xs" id="id_etq" name="id_etq" value="<?php echo $dados['id'];?>">
          <input type="hidden" class="input-xs" id="cod_item" name="cod_item" value="<?php echo $dados['cod_item'];?>">
          <button type="submit" id="btnPrintEtqRecUn" class="btn btn-primary btn-xs">IMPRIMIR</button>
          <button type="button" id="btnDelEtqRecUn" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_etq']; ?>" data-st="<?php echo $dados['fl_status'];?>" data-nf="<?php echo $dados['cod_nf_entrada'];?>" data-it="<?php echo $dados['cod_nf_entrada_item'];?>">EXCLUIR</button>
        </form>
      </td>
      <td style="text-align: right"> <?php echo $dados['nr_fisc_ent']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['produto']; ?> </td>
      <td> <?php echo $dados['nm_produto']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['nr_seq']; ?> </td>
      <td style="text-align: right"> <?php echo $dados['id']; ?> </td>
      <td style="width: 70px;background-color: #DCDCDC"> <input type='text' id="nr_qtde" name="nr_qtde" value='<?php echo $dados['nr_qtde']; ?>' style="text-align: right;"/> </td>
      <td style="width: 70px;background-color: #D3D3D3"><button type="button" id="btnSaveEtqQtd" value="<?php echo $dados['id'];?>">Gravar</button></td>
      <?php
        if ($dados['status_etq'] == 'L') {

          $td = '<td style="background-color: #9AFF9A">CONFERIDA</td>';
          echo $td;

        }else if ($dados['status_etq'] == 'A'){

          $td = '<td style="background-color: #F4A460">AGUARDANDO CONFERÊNCIA</td>';
          echo $td;

        }else if ($dados['status_etq'] == 'F'){

          $td = '<td style="background-color: #9AFF9A">ALOCADA</td>';
          echo $td;

        }
      ?>
      <!--td style="width: 80px;text-align: center; width: 200px">
        <svg id="barcode"
        class="barcode"
        jsbarcode-format="auto"
        jsbarcode-height="50"
        jsbarcode-displayValue="false"
        jsbarcode-value="<?php echo $dados['produto']."-".$dados['cod_etq']; ?>"
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
<!--script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
  JsBarcode(".barcode").init();
</script-->
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