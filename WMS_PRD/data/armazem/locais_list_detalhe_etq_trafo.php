<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;
} else {

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$local = $_POST['localTrafo'];

$sql_local = "select t1.id, t1.nome, t2.cod_estoque, t2.ds_galpao, t2.produto, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, 
format(t2.nr_qtde,0) as nr_qtde, round(t2.nr_volume,0) as nr_volume, 
case when t2.dt_validade = '0' then '' else date_format(t2.dt_validade,'%d/%m/%Y') end as dt_validade, t3.cod_prod_cliente, 
t3.nm_produto, t2.nr_or,t2.id_tar, t8.id as id_etq, t8.cod_estoque as cod_est_etq, t2.n_serie, t2.dt_aloca, 
t2.ds_lp,t2.ds_fabr, t2.ds_ano, t2.ds_enr, t2.ds_kva
from tb_armazem t1
left join tb_posicao_pallet t2 on t1.id = t2.ds_galpao
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
left join tb_etiqueta t8 on t2.cod_estoque = t8.cod_estoque
where t2.nr_qtde > 0 and t1.id = '$local' and t2.fl_status = 'A' and t2.produto > 0 and t2.fl_empresa = '$cod_cli' 
and t3.nm_produto like 'TRANSF%'
group by t2.cod_estoque
order by t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.produto";
$res_local = mysqli_query($link, $sql_local);
$tr_local = mysqli_num_rows($res_local);

$link->close();
?>
<?php
if ($tr_local) { ?>

    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

    <div class="col-sm-12 text-align-right">
        <div class="btn-group">
            <form class="form-horizontal" method="post" action="data/armazem/relatorios/list_etq_prd_all_trafo.php" id="" target="_blank">
                <button type="submit" class="btn btn-primary btn-xs" name="local" value="<?php echo $local; ?>" style="float:right;width: 150px">IMPRIMIR ETIQUETAS</button>
                <button type="submit" id="btnGeraEtqPrdEstTrafo" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px;float:right">GERAR ETIQUETAS</button>
            </form>
        </div>
        
    </div>
    <div id="reportSalEstoque">
        <div class="padding-10">
            <br>
            <br>
            <table class="table table-striped table-hover" id="" style="width:100%">
                <thead>
                    <tr>
                        <th class="hasinput" style="width: 20px">
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="checkboxTodos" class="checkbox style-0">
                                    <span></span>
                                </label>
                            </div>
                        </th>
                        <th> Ações </th>
                        <th> Código estoque</th>
                        <th> Rua </th>
                        <th> Coluna</th>
                        <th> Altura </th>
                        <th> Cód. SAP</th>
                        <th> Produto </th>
                        <th colspan="2"> Volumes </th>
                        <th> Quantidade </th>
                        <th> Kva </th>
                        <th> LP </th>
                        <th> Serial </th>
                        <th> Ano </th>
                        <th> Enrolamento </th>
                        <th> Etiqueta </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($dados_local = mysqli_fetch_assoc($res_local)) {
                    ?>
                        <tr class="odd gradeX">
                            <td>
                                <div class="form-group">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" class="checkbox style-0 checkLocEtqTrafo" id="checkLocEtqTrafo" value="<?php echo $dados_local['cod_estoque']; ?>" data-qt="<?php echo $dados_local['nr_volume']; ?>" data-et="<?php echo $dados_local['id_etq']; ?>">
                                        <span></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <form class="form-horizontal" method="post" action="data/armazem/relatorios/list_etq_prd_all_trafo.php" id="" target="_blank">
                                    <input type="hidden" class="input-xs" id="cod_est" name="cod_est" value="<?php echo $dados_local['cod_estoque']; ?>">
                                    <button type="submit" id="btnPrintEtqPrdEstTrafo" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">IMPRIMIR</button>
                                </form>
                            </td>
                            <td style="text-align: center; width: 5px;"><?php echo $dados_local['cod_estoque']; ?> </td>
                            <td style="text-align: center; width: 5px;"><?php echo $dados_local['ds_prateleira']; ?> </td>
                            <td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_coluna']; ?> </td>
                            <td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_altura']; ?> </td>
                            <td style="text-align: right; width: 5px"> <?php echo $dados_local['produto']; ?></td>
                            <td style="text-align: left; width: auto"> <?php echo $dados_local['nm_produto']; ?></td>
                            <td style="background-color: #DCDCDC"> <input type='text' id="nr_volume" name="nr_volume" value='<?php echo $dados_local['nr_volume']; ?>' style="text-align: right;width: 70px" /> </td>
                            <td style="background-color: #D3D3D3"><button type="button" id="btnSaveEtqQtdLoc" value="<?php echo $dados_local['cod_estoque']; ?>">Gravar</button></td>
                            <td style="text-align: right; width: auto"> <?php echo $dados_local['nr_qtde']; ?></td>
                            <td style="text-align: right; width: auto"> <?php echo $dados_local['ds_kva']; ?></td>
                            <td style="text-align: right; width: auto"> <?php echo $dados_local['ds_lp']; ?></td>
                            <td style="text-align: right; width: 20px"> <?php echo $dados_local['nr_serial']; ?></td>
                            <td style="text-align: right; width: auto"> <?php echo $dados_local['ds_ano']; ?></td>
                            <td style="text-align: right; width: 20px"> <?php echo $dados_local['ds_enr']; ?></td>
                            <td style="text-align: center; width: 100px">

                                <?php if ($dados_local['id_etq']) { ?>

                                    <svg id="barcode" class="barcode" jsbarcode-format="auto" jsbarcode-height="50" jsbarcode-displayValue="false" jsbarcode-value="<?php echo $dados_local['produto'] . "-" . $dados_local['id_etq']; ?>" jsbarcode-textmargin="0" jsbarcode-fontoptions="bold">
                                    </svg>

                                <?php } else {

                                    echo "";
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--script type="text/javascript">
        $(document).ready(function() {
            $("#example14").dataTable({
                "aLengthMenu": [5000]
            });
        });
    </script-->
    
<script type="text/javascript"> 
	$(document).ready(function() {

		pageSetUp();
		var responsiveHelper_dt_basicTrafo = undefined;
		var responsiveHelper_datatable_fixed_column_trafo = undefined;
		var responsiveHelper_datatable_col_reorder_trafo = undefined;
		var responsiveHelper_datatable_tabletools_trafo = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		$('#dt_basicTrafo').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"iDisplayLength": 100,
			"oLanguage": {
				"sSearch": '<!--span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span-->'
			},
			"preDrawCallback" : function() {
				if (!responsiveHelper_dt_basicTrafo) {
					responsiveHelper_dt_basicTrafo = new ResponsiveDatatablesHelper($('#dt_basicTrafo'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basicTrafo.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basicTrafo.respond();
			}
		});
		var otable = $('#datatable_fixed_column_trafo').DataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"oLanguage": {
				"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
			},
			"preDrawCallback" : function() {
				if (!responsiveHelper_datatable_fixed_column_trafo) {
					responsiveHelper_datatable_fixed_column_trafo = new ResponsiveDatatablesHelper($('#datatable_fixed_column_trafo'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_fixed_column_trafo.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_fixed_column_trafo.respond();
			}       

		});
		$("#datatable_fixed_column_trafo thead th input[type=text]").on( 'keyup change', function () {

			otable
			.column( $(this).parent().index()+':visible' )
			.search( this.value )
			.draw();

		} );
	});

</script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#checkboxTodos").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });
    </script>
    <script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
    <script type="text/javascript">
        JsBarcode(".barcode").init();
    </script>
<?php } else { ?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

<?php } ?>