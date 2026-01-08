<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$nr_nf =$_POST["nr_nf"];

$select_nf = "select r.nm_fornecedor, r.nm_transportadora, r.nm_placa, r.ds_obs, DATE_FORMAT(dt_recebimento_previsto ,'%d/%m/%Y') dt_recebimento_previsto, c.nm_cliente, i.cod_nf_entrada, i.nr_fisc_ent, i.dt_emis_ent, i.nr_cfop_ent, i.qtd_vol_ent, i.nr_peso_ent, i.vl_tot_nf_ent, i.tp_vol_ent, i.base_icms_ent, i.vl_icms_ent, i.chavenfe from tb_recebimento r left join tb_cliente c on r.cod_cli = c.cod_cliente left join tb_nf_entrada i on i.cod_rec = r.cod_recebimento where i.nr_fisc_ent = '$nr_nf'";
$res_nf = mysqli_query($link, $select_nf);

$link->close();
?><br><br>
<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
	<div>
		<div class="jarviswidget-editbox">
		</div>
		<div id="retCte"></div>
		<div id="retNf"></div>
		<div class="widget-body no-padding" id="tabela_cte_pend">
			<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
        <thead>
          <tr>
            <th colspan="4"> Ações</th>
            <th> N.F. </th>
            <th> Fornecedor </th>
            <th data-toggle="tooltip" data-placement="left" title="Peso total da NF"> Peso (Kg)</th>
            <th data-toggle="tooltip" data-placement="left" title="Total de volumes da NF"> Volumes </th>
            <th data-toggle="tooltip" data-placement="left" title="Tipo de volume"> Tipo </th>
            <th data-toggle="tooltip" data-placement="left" title="Valor total da NF"> Valor  </th>
          </tr>
        </thead>
        <tbody id="retNfRec">
          <?php
          while ($dados = mysqli_fetch_assoc($res_nf)) {
           ?>
           <tr class="odd gradeX">
            <td style="text-align: center; width: 50px">
              <button type="submit" id="btnDtlNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Detalhe</button>
              <button type="submit" id="btnUpdNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Alterar</button>
              <button type="submit" id="btnDelNfrec" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Excluir</button>
              <button type="submit" id="btnProdNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Produtos</button>
            </td>
            <td style="text-align: center; width: 10px"> <?php echo $dados['nr_fisc_ent']; ?> </td>
            <td style="width: 30%"> <?php echo $dados['nm_fornecedor']; ?> </td>
            <td style="text-align: center; width: 30px"> <?php echo $dados['nr_peso_ent']; ?> </td>
            <td style="text-align: center; width: 30px"> <?php echo $dados['qtd_vol_ent']; ?> </td>
            <td style="text-align: center; width: 10px"> <?php echo $dados['tp_vol_ent']; ?> </td>
            <td style="text-align: center; width: 10px"> <?php echo $dados['vl_tot_nf_ent']; ?> </td>
          </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
</div>
</div>
<script type="text/javascript">	
	$(document).ready(function() {

		pageSetUp();
		var responsiveHelper_dt_basic2 = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		$('#dt_basic2').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
      "iDisplayLength": 100,
      "oLanguage": {
        "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
      },
      "preDrawCallback" : function() {
        if (!responsiveHelper_dt_basic2) {
         responsiveHelper_dt_basic2 = new ResponsiveDatatablesHelper($('#dt_basic2'), breakpointDefinition);
       }
     },
     "rowCallback" : function(nRow) {
      responsiveHelper_dt_basic2.createExpandIcon(nRow);
    },
    "drawCallback" : function(oSettings) {
      responsiveHelper_dt_basic2.respond();
    }
  });
	});

</script>