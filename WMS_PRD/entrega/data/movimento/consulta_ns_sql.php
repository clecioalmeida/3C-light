<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$nr_pedido = $_POST['ns_ped'];

$sql_ns = "select t1.id, t1.n_serie, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t3.cod_prod_cliente from tb_nserie t1 left join tb_posicao_pallet t2 on t1.id_produto = t2.produto left join tb_produto t3 on t1.id_produto = t3.cod_produto where t1.cod_pedido = '$nr_pedido' and t2.ds_galpao NOT IN ('RECEBIMENTO') and t1.fl_status = 'A' group by id asc";
$res_ns = mysqli_query($link,$sql_ns);
?>
<div class="modal fade" id="ns_pedido" aria-hidden="true">
 <form method="post" action="" id="formUpdPedido">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pedido número: <?php echo $nr_pedido;?></h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">     
    <div id="content">
    <section id="widget-grid" class="">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow-x: hidden">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
            <header>
            <!--span class="widget-icon"> <i class="fa fa-table"></i> </span-->
            <h5>Números de série </h5>
            </header>
            <div>
                <div class="jarviswidget-editbox">
                </div>
                <div class="widget-body no-padding">
                    <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                        <thead>                         
                            <tr>
                                <th data-hide="phone">id</th>
                                <th data-class="expand"> Código SAP</th>
                                <th data-hide="phone"> Número de série</th>
                                <th data-hide="phone"> Selecione</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($dados_ns=mysqli_fetch_assoc($res_ns)) {
                                ?>
                                <tr>
                                    <td><?php echo $dados_ns['id']; ?></td>
                                    <td><?php echo $dados_ns['cod_prod_cliente']; ?></td>
                                    <td><?php echo $dados_ns['n_serie']; ?></td>
                                    <td role="gridcell" style="text-align:center;width: 25px;" aria-describedby="jqgrid_cb"><input role="checkbox" type="checkbox" id="jqg_jqgrid_1" class="cbox" name="jqg_jqgrid_1[]" value="<?php echo $dados_ns['id']; ?>"></td>
                                    <input type="hidden" name="nr_pedido" value="<?php echo $nr_pedido; ?>">
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </article>
        </section>
    </div>
    </div>
      <div class="modal-footer">
        <!--button type="submit" class="btn btn-primary" id="btnFormUpdPedido">Salvar</button-->
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
 </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#ns_pedido').modal('show');
    });
</script>
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


</body>
</html>