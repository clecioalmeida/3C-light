<?php
require_once('xhr/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto = $_GET['cod_prd'];
$cod_estoque = $_GET['cod_estq'];
$nr_qtde = $_GET['qtd_prd'];
$cont_1 = $_GET['contp'];
$cont_2 = $_GET['conts'];
$cont_3 = $_GET['contt'];
$ds_galpao = $_GET['ds_galpao'];
$ds_prateleira = $_GET['ds_prateleira'];
$ds_coluna = $_GET['ds_coluna'];
$ds_altura = $_GET['ds_altura'];
$cod_prod_cliente = $_GET['cod_cli'];
$id_inv = $_GET['id_inv'];
$id_tar = $_GET['id_tar'];

$sel_end="select * from tb_endereco where galpao = '$id_local' and rua = '$id_rua' and coluna = '$id_pp'";
$res_end = mysqli_query($link, $sel_end);
while ($dados=mysqli_fetch_assoc($res_end)) {
	$id_end = $dados['id'];
}

$sql_torre = "select ds_apelido from tb_armazem where id = '$ds_galpao'";
$res_torre = mysqli_query($link, $sql_torre);
while ($dados=mysqli_fetch_assoc($res_torre)) {
	$ds_apelido = $dados['ds_apelido'];
}
$link->close();
?>
<div data-role="page" data-dialog="true" style="background-color: white">
	<div data-role="header" data-theme="b">
		<h2>CONTAGEM</h2>
	</div>
	<div role="main" class="ui-content" style="background-color: white;padding-top: 1em">
		
		<div class="row">
			<div>
				<h4 id="">Produto:<?php echo $cod_prod_cliente;?></h4>
			</div>
			<div>
				<h4 id="">Endereço:<?php echo $ds_apelido.$ds_prateleira.$ds_altura.$ds_coluna;?></h4>
			</div>

			<legend>Selecione o endereço</legend>
			<form id="form_conf_end" method="" action="">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" id="localInv" name="localInv" class="form-control" required="true">
						<input type="hidden" id="cont_1" name="cont_1" class="form-control" value="<?php echo $cont_1;?>">
						<input type="hidden" id="cont_2" name="cont_2" class="form-control" value="<?php echo $cont_2;?>">
						<input type="hidden" id="cont_3" name="cont_3" class="form-control" value="<?php echo $cont_3;?>">
						<input type="hidden" id="cod_estoque" name="cod_estoque" class="form-control" value="<?php echo $cod_estoque;?>">
						<input type="hidden" id="id_tar" name="id_tar" class="form-control" value="<?php echo $id_tar;?>">
					</div>
					<div class="form-group">
					</div>
				</div>
			</form>
		</div>
		<div class="contP" style="display: none">
			<legend>Primeira contagem</legend>
			<div class="row" id="confProdPick">
				<div>
					<h4 id="">Total:<?php echo $nr_qtde;?></h4>
				</div>

				<div class="conferido" id="conferidoP">
					<h4 id="TotalConferidoP">Conferido:</h4>
				</div>
				<form id="form_conf_prod" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input tabindex="1" type="text" id="barcodeConfInvP" name="barcodeConfInvP" class="form-control" required="true">
						</div>
						<div class="form-group">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="contS" style="display: none">
			<legend>Segunda contagem</legend>
			<div class="row" id="confProdPick">
				<div>
					<h4 id="">Total:<?php echo $nr_qtde;?></h4>
				</div>

				<div class="conferido" id="conferidoS">
					<h4 id="TotalConferidoS">Conferido:</h4>
				</div>
				<form id="form_conf_prod" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input tabindex="1" type="text" id="barcodeConfInvs" name="barcodeConfInvs" class="form-control" required="true">
						</div>
						<div class="form-group">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="contT" style="display: none">
			<legend>Terceira contagem</legend>
			<div class="row" id="confProdPick">
				<div>
					<h4 id="">Total:<?php echo $nr_qtde;?></h4>
				</div>

				<div class="conferido" id="conferidoT">
					<h4 id="TotalConferidoT">Conferido:</h4>
				</div>
				<form id="form_conf_prod" method="" action="">
					<div class="col-md-12">
						<div class="form-group">
							<input tabindex="1" type="text" id="barcodeConfInvT" name="barcodeConfInvT" class="form-control" required="true">
						</div>
						<div class="form-group">
						</div>
					</div>
				</form>
			</div>
		</div>
		<a href="inv_produtos.php?id_inv=<?php echo $id_inv;?>&id_local=<?php echo $ds_galpao;?>&id_rua=<?php echo $ds_prateleira;?>&id_coluna=<?php echo $ds_coluna;?>&id_altura=<?php echo $ds_altura;?>" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Fechar</a>
	</div>
</div>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#btnFormConf').on('click',function(event){
        event.preventDefault();
        if($('#qtde1').val() == '' || $('#qtde2').val() == ''){
            alert("Favor digitar as quantidades!");
        } else if($('#qtde1').val() != $('#qtde2').val()) {

        	alert("As quantidades devem ser iguais!");
            
        } else {

        	$.ajax({
                url:"xhr/ins_conf.php",
                method: "POST",
                data: $('#formConf').serialize(),
                success:function(data){
                    $('#formConf')[0].reset();
                    alert('Tarefa inserida com sucesso!');
                }
            });
        }
    });
});

$(function(){
        
            $('#id_torre').change(function(){
                if( $(this).val() ) {
                    $('#cod_produto').hide();
                    $('.carregando').show();
                    $.getJSON('xhr/consulta_conjunto.php?search=',{id_torre: $(this).val(), ajax: 'true'}, function(j){
                        var options = '<option value="">Escolha a Peça</option>'; 
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].cod_produto + '">'+"Pos. " + j[i].nr_posicao +" | "+"Comp. "+ j[i].compr +" | "+"Peso. "+ j[i].peso + '</option>';
                            //options += '<input type="hidden" name="nr_qtde" value="' + j[i].nr_qtde + '">';
                        }   
                        $('#cod_produto').html(options).show();
                        $('.carregando').hide();
                    });
                } else {
                    $('#cod_produto').html('<option value="">– Escolha a Peça –</option>');
                }
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