<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						    <h2>Ocorrências | Finalizadas </h2>
						</header>
						<div>
							<div class="jarviswidget-editbox">
							</div>
							<div class="widget-body no-padding">
								<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>                         
                                        <tr>
                                            <!--th>Ações</th-->
                                            <th data-hide="phone" style="width: 5px">Código</th>
                                            <th data-class="expand"><i class="fa fa-fw fa-file-text text-muted hidden-md hidden-sm hidden-xs"></i> Origem</th>
                                            <th data-hide="phone"><i class="fa fa-fw fa-cog text-muted hidden-md hidden-sm hidden-xs"></i> Descrição</th>
                                            <th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i>Responsável</th>
                                            <th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i>Data de abertura</th>
                                            <th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i>Data Final</th>
                                            <th  data-hide="phone,tablet"><i class="fa fa-fw fa-exclamation-circle txt-color-blue hidden-md hidden-sm hidden-xs"></i>Prazo (Dias)</th>
                                            <th  data-hide="phone,tablet"><i class="fa fa-fw fa-exclamation-circle txt-color-blue hidden-md hidden-sm hidden-xs"></i>Data de solução</th>
                                            <th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i>Tipo</th>
                                            <th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i>Situação</th>
                                            <th data-hide="phone,tablet"><i class="fa fa-fw fa-check-square txt-color-blue hidden-md hidden-sm hidden-xs"></i> Criticidade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php require_once('xhr/pesquisa_finalizadas.php');  
                                        while($dados = mysqli_fetch_array($res_ocor_finalizada)) {

                                            $tipo=$dados['tipo'];
                                            $cod_ocorrencia=$dados['cod_ocorrencia'];
                                            $nm_ocorrencia=$dados['nm_ocorrencia'];
                                            $user_create=$dados['user_create'];
                                            $id_responsavel=$dados['ds_responsavel'];
                                            $dt_abertura=date("Y-m-d", strtotime($dados['dt_abertura']));
                                            $dt_final=date("d/m/Y", strtotime($dados['dt_final']));
                                            $criticidade=$dados['criticidade'];
                                            $dt_sol=date("d/m/Y", strtotime($dados['dt_sol']));
                                        ?> 
                                        <tr>
                                            <td><?php echo $dados['cod_ocorrencia']; ?></td>
                                            <td><?php echo $dados['cod_origem']; ?></td>
                                            <td><?php echo $dados['nm_ocorrencia']; ?></td>
                                            <td><?php echo $dados['ds_responsavel']; ?></td>
                                            <td><?php if($dados['dt_abertura'] == 0){

                                                    echo '';

                                                }else{

                                                    echo date("d/m/Y", strtotime($dados['dt_abertura']));

                                                } ?></td>
                                            <td><?php 

                                                if($dados['dt_final'] == ''){

                                                    echo '';

                                                }else{

                                                    echo date("d/m/Y", strtotime($dados['dt_final']));

                                                }?>
                                                        
                                            </td>
                                            <td><?php 
                                                if($dados['dt_final'] == '' or $dados['dt_abertura'] == 0){

                                                    echo '';

                                                }else{

                                                    $data_inicio = new DateTime($dados['dt_abertura']);
                                                    $data_fim = new DateTime($dados['dt_final']);
                                                    $dateInterval = $data_inicio->diff($data_fim);
                                                    echo $dateInterval->days;

                                                }?>
                                            </td>
                                            <td><?php 

                                                if($dados['dt_sol'] == ''){

                                                    echo '';

                                                }else{

                                                    echo date("d/m/Y", strtotime($dados['dt_sol']));

                                                }?>
                                                    
                                            </td>
                                            <td><?php 

                                                if($dados['tipo'] == 'A'){

                                                    echo "Armazém";

                                                }elseif($dados['tipo'] == 'T'){

                                                    echo "Transporte";

                                                }else{

                                                    echo "Outros";

                                                } ?>
                                                        
                                            </td>
                                            <td><?php 

                                                if($dados['fl_status'] == 'A'){

                                                    echo "Aberta";

                                                }elseif($dados['fl_status'] == 'F'){

                                                    echo "Finalizada";

                                                }elseif($dados['fl_status'] == 'P'){

                                                    echo "Em progresso";

                                                }else{

                                                    echo "Atrasada";

                                                }?>
                                            </td>
                                            <td><?php 

                                                if($dados['criticidade'] == 'B'){

                                                    echo "Baixa";

                                                }elseif($dados['criticidade'] == 'M'){


                                                    echo "Média";

                                                }else{

                                                    echo "Alta";

                                                }?>
                                                        
                                            </td>
                                        </tr>
                                            <?php } ?>
                                    </tbody>
                                </table>
							</div>
						</div>
					</div>
				</article>
			</div>
		</div>
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
                        "sSearch": '<!--span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span-->'
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