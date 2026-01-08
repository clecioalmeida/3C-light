<?php
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST['nr_pedido'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_ped = "select t1.nr_pedido, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, sum(t1.nr_qtde_col) as nr_qtde_col, t1.nr_qtde_conf, t2.cod_produto, t2.cod_prod_cliente, t3.nome 
from tb_coleta_pedido t1 
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_armazem t3 on t1.ds_galpao = t3.id
where t1.nr_pedido = '$nr_pedido' and t1.fl_status = 'R' and t1.nr_qtde_col > 0
group by t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura
order by t2.cod_prod_cliente";
$res_ped = mysqli_query($link,$sql_ped);

?>
<?php echo include'header.php';?>

<div id="main" role="main">
	<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
						<header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
									
						<h4>Picking por pedido</h4>
				
						<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
						<div role="content">
							<div class="jarviswidget-editbox">
							</div>
							<div class="widget-body">
								<form id="formPedido">
									<fieldset>
										<div class="form-group">
											<label>Pedido número: <?php echo $nr_pedido; ?></label>
											<button type="submit" class="btn btn-success btn-sm" id="btnFinConfPed" style="float: right;margin-left: 5px">Finalizar</button>
											<button type="submit" class="btn btn-danger btn-sm" id="btnOcorConfPed" style="float: right;">Quebra</button>
										</div>
									</fieldset>
										<h2 class="fimPedido" id="retExpEnd1" style="background-color: #98FB98"></h2>
										<h2 class="fimPedido" id="retExpEnd2" style="background-color: #F08080"></h2>
									<fieldset>
										<table class="table table-hover" style="width: 100%">
											<thead>
												<tr>
													<th>CÓDIGO</th>
													<th>GALPÃO</th>
													<th>RUA</th>
													<th>COLUNA</th>
													<th>ALTURA</th>
													<th>QTDE</th>
													<th>CONFERIDO</th>
												</tr>
											</thead>
											<tbody>
												<?php
												while ($dados_ped=mysqli_fetch_assoc($res_ped)) {?>
												<tr class="tblRows" data_prd="<?php echo $dados_ped['cod_produto'];?>" data_rua="<?php echo $dados_ped['ds_prateleira'];?>" data_col="<?php echo $dados_ped['ds_coluna'];?>" data_alt="<?php echo $dados_ped['ds_altura'];?>" data_qtd="<?php echo $dados_ped['nr_qtde_col'];?>"  data_glp="<?php echo $dados_ped['ds_galpao'];?>">
													<td><?php echo $dados_ped['cod_prod_cliente'];?></td>
													<td><?php echo $dados_ped['ds_galpao'];?></td>
													<td><?php echo $dados_ped['ds_prateleira'];?></td>
													<td><?php echo $dados_ped['ds_coluna'];?></td>
													<td><?php echo $dados_ped['ds_altura'];?></td>
													<td class="qtde" style="text-align: left;"><?php echo $dados_ped['nr_qtde_col'];?></td>
													<td class="total" style="text-align: left;"><?php echo $dados_ped['nr_qtde_conf'];?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</fieldset>
									<h2 id="retConfPick"></h2>
								</form>
							</div>
						</div>
					</div>
				</article>
			</div>
		</section>
	</div>
</div>
<!--div class="page-footer">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<span class="txt-color-white">Growup <span class="hidden-xs"> - WMS Gisis</span> © 2016-2017</span>
		</div>
	</div>
</div-->
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form id="form_conf" method="" action="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					×
				</button>
				<h4 class="modal-title" id="myModalLabel">Separação de volumes</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<input type="hidden" name="cod_nf_item" id="nr_pedido" value="<?php echo $nr_pedido; ?>">
							<input type="hidden" name="cod_nf" id="cod_produto" value="<?php echo $produto; ?>">
							<input type="text" id="barcode" name="barcode" class="form-control" required="true">
						</div>
						<div class="form-group">
							<button type="submit" id="submit" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-floppy-disk"></span> Salvar
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Fechar
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
	</form>
</div>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
     $( ".tblRows" ).click(function() {
        var cod_produto = $(this).attr("data_prd");
        var rua = $(this).attr("data_rua");
        var col = $(this).attr("data_col");
        var alt = $(this).attr("data_alt");
        var qtd = $(this).attr("data_qtd");
        var galpao = $(this).attr("data_glp");
        var pedido = "<?php echo $nr_pedido;?>";
        $.ajax({
            url:"xhr/m_conf_end.php",
            method: "POST",
            //dataType:'json',
            data:{cod_produto:cod_produto,rua:rua,col:col,alt:alt,qtd:qtd,galpao:galpao,pedido:pedido},
            success:function(data){
                $('#retConfPick').html(data);
            }
        });
    });
});

$(document).ready(function(){
	$('#retExpEnd1').hide();
	$('#retExpEnd2').hide();
    $( '#btnFinConfPed').on('click', function() {
    	event.preventDefault();
    	var pedido = "<?php echo $nr_pedido;?>";
	    	$.ajax({
	        url:"xhr/fin_conf_pedido.php",
	        method: "POST",
	        dataType:'json',
	        data:{pedido:pedido},
	        success:function(j){
				for(var i=0;i < j.length;i++){
				    var info = j[i].info;
				    if(info == 1){
				    	$('#retExpEnd1').show();
						$('#retExpEnd1').html("Pedido finalizado com sucesso!");

				    }else{
						$('#retExpEnd2').show();
						$('#retExpEnd2').html(info);

				    }
				}
			}
	    });
   	});

});

$(document).ready(function(){
	$('#retExpEnd1').hide();
	$('#retExpEnd2').hide();
    $( '#btnOcorConfPed').on('click', function() {
    	event.preventDefault();
    	var pedido = "<?php echo $nr_pedido;?>";
	    	$.ajax({
	        url:"xhr/quebra_pedido.php",
	        method: "POST",
	        dataType:'json',
	        data:{pedido:pedido},
	        success:function(j){
				for(var i=0;i < j.length;i++){
				    var info = j[i].info;
				    if(info == 1){
				    	$('#retExpEnd1').show();
						$('#retExpEnd1').html("Quebra de estoque registrada!");

				    }else{
						$('#retExpEnd2').show();
						$('#retExpEnd2').html(info);

				    }
				}
			}
	    });
   	});

});
</script>
	<!--================================================== -->

	<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
	<script data-pace-options='{ "restartOnRequestAfter": true }' src="js/plugin/pace/pace.min.js"></script>

	<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script>
		if (!window.jQuery) {
			document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');
		}
	</script>

	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script>
		if (!window.jQuery.ui) {
			document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
		}
	</script>

	<!-- IMPORTANT: APP CONFIG -->
	<script src="js/app.config.js"></script>

	<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
	<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

	<!-- BOOTSTRAP JS -->
	<script src="js/bootstrap/bootstrap.min.js"></script>

	<!-- CUSTOM NOTIFICATION -->
	<script src="js/notification/SmartNotification.min.js"></script>

	<!-- JARVIS WIDGETS -->
	<script src="js/smartwidgets/jarvis.widget.min.js"></script>

	<!-- EASY PIE CHARTS -->
	<script src="js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

	<!-- SPARKLINES -->
	<script src="js/plugin/sparkline/jquery.sparkline.min.js"></script>

	<!-- JQUERY VALIDATE -->
	<script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>

	<!-- JQUERY MASKED INPUT -->
	<script src="js/plugin/masked-input/jquery.maskedinput.min.js"></script>

	<!-- JQUERY SELECT2 INPUT -->
	<script src="js/plugin/select2/select2.min.js"></script>

	<!-- JQUERY UI + Bootstrap Slider -->
	<script src="js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

	<!-- browser msie issue fix -->
	<script src="js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

	<!-- FastClick: For mobile devices -->
	<script src="js/plugin/fastclick/fastclick.min.js"></script>

		<!--[if IE 8]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->

		<!-- Demo purpose only -->
		<!--script src="js/demo.min.js"></script-->

		<!-- MAIN APP JS FILE -->
		<script src="js/app.min.js"></script>

		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
		<script src="js/smart-chat-ui/smart.chat.ui.min.js"></script>
		<script src="js/smart-chat-ui/smart.chat.manager.min.js"></script>

		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

		<script type="text/javascript">

		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		
		$(document).ready(function() {
			
			pageSetUp();
			
			/* // DOM Position key index //
		
			l - Length changing (dropdown)
			f - Filtering input (search)
			t - The Table! (datatable)
			i - Information (records)
			p - Pagination (paging)
			r - pRocessing 
			< and > - div elements
			<"#id" and > - div with an id
			<"class" and > - div with a class
			<"#id.class" and > - div with an id and class
			
			Also see: http://legacy.datatables.net/usage/features
			*/	

			/* BASIC ;*/
			var responsiveHelper_dt_basic = undefined;
			var responsiveHelper_datatable_fixed_column = undefined;
			var responsiveHelper_datatable_col_reorder = undefined;
			var responsiveHelper_datatable_tabletools = undefined;

			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

			$('#dt_basic').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"oLanguage": {
					"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
				},
				"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			/* END BASIC */
			
			/* COLUMN FILTER  */
			var otable = $('#datatable_fixed_column').DataTable({
		    	//"bFilter": false,
		    	//"bInfo": false,
		    	//"bLengthChange": false
		    	//"bAutoWidth": false,
		    	//"bPaginate": false,
		    	//"bStateSave": true // saves sort state using localStorage
		    	"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
		    	"t"+
		    	"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		    	"autoWidth" : true,
		    	"oLanguage": {
		    		"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
		    	},
		    	"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_fixed_column) {
						responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_fixed_column.respond();
				}		

			});

		    // custom toolbar
		    $("div.toolbar").html('<div class="text-right"><img src="img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');

		    // Apply the filter
		    $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {
		    	
		    	otable
		    	.column( $(this).parent().index()+':visible' )
		    	.search( this.value )
		    	.draw();

		    } );
		    /* END COLUMN FILTER */   

		    /* COLUMN SHOW - HIDE */
		    $('#datatable_col_reorder').dataTable({
		    	"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
		    	"t"+
		    	"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
		    	"autoWidth" : true,
		    	"oLanguage": {
		    		"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
		    	},
		    	"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_col_reorder) {
						responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_col_reorder.respond();
				}			
			});

		    /* END COLUMN SHOW - HIDE */

		    /* TABLETOOLS */
		    $('#datatable_tabletools').dataTable({

				// Tabletools options: 
				//   https://datatables.net/extensions/tabletools/button_options
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
				"oLanguage": {
					"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
				},		
				"oTableTools": {
					"aButtons": [
					"copy",
					"csv",
					"xls",
					{
						"sExtends": "pdf",
						"sTitle": "SmartAdmin_PDF",
						"sPdfMessage": "SmartAdmin PDF Export",
						"sPdfSize": "letter"
					},
					{
						"sExtends": "print",
						"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
					}
					],
					"sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
				},
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_tabletools) {
						responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_tabletools.respond();
				}
			});

		    /* END TABLETOOLS */

		})

	</script>

	<!-- Your GOOGLE ANALYTICS CODE Below -->


</body>

</html>