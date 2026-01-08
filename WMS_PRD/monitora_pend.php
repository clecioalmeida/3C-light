<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select distinct t1.nr_pedido, t1.dt_pedido, t1.dt_limite, t2.dt_init_col, t2.dt_fim_conf, t2.dt_fim_coleta, t2.dt_lib_exp, t4.dt_entrega, t5.id_destino, coalesce(t5.ds_anexo,0) as ds_anexo
from tb_pedido_coleta t1
left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido
left join tb_nf_saida t3 on t1.nr_pedido = t3.nr_pedido
left join tb_entrega t4 on t3.nr_nf_formulario = t4.nr_nf
left join tb_anexo t5 on t1.nr_pedido = t5.nr_pedido
where t1.fl_status <> 'E'";
$res_ped = mysqli_query($link, $SQL);

$link->close();
?>
<div id="main" role="main">
    <div id="ribbon">
        <ol class="breadcrumb">
            <li>Home</li><li>Monitoramento</li><li>Ativos</li>
        </ol>
    </div>
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-home"></i>
                        Monitoramento
                    <span>|
                        Ativos
                    </span>
                </h1>
            </div>
        </div>
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget" id="wid-id-0">
                        <header>
                        </header>
                        <div>
                            <div class="jarviswidget-editbox">
                                <input class="form-control" type="text">
                            </div>
                            <div class="widget-body">
                                <section id="widget-grid" class="">
                                    <div class="row">
                                        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                                                <!--header>
                                                </header-->
                                                <div>
                                                    <div class="jarviswidget-editbox">
                                                    </div>
                                                    <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr style="font-size: x-small;">
                                                    <th style="width: 100px"></th>
                                                    <th data-hide="phone" style="width: 10px">Pedido</th>
                                                    <th data-class="expand"><i class="fa fa-fw fa-calendar text-muted hidden-md hidden-sm hidden-xs"></i> Data</th>
                                                    <th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Limite</th>
                                                    <th data-hide="phone"><i class="fa fa-fw fa-exclamation-circle text-muted hidden-md hidden-sm hidden-xs"></i>Coleta-Início</th>
                                                    <th  data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>Conferênica-Fim</th>
                                                    <th  data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>Coleta-Fim</th>
                                                    <th data-hide="phone,tablet"><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>Liberado para Expedição</th>
                                                    <th data-hide="phone,tablet"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i> Saída</th>
                                                    <th data-hide="phone,tablet"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i> Entregue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
while ($linha = mysqli_fetch_assoc($res_ped)) {
	?>
                                                <tr>
                                                    <td>
                                                        <ul class="demo-btns">
                                                            <li>
                                                                <a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Comprovante de entrega" data-target="#comprovante<?php echo $linha['nr_pedido']; ?>" style="font-size: x-small;"><i class="fa fa-download"></i></a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td><span class="center-block padding-5 label label-success"><?php echo $linha['nr_pedido']; ?></span></td>
                                                    <td><?php if ($linha['dt_pedido'] == '') {
		echo '';
	} else {
		echo date('d-m-Y', strtotime($linha['dt_pedido']));
	}
	?>
                                                    </td>
                                                    <td><?php if ($linha['dt_limite'] == '') {
		echo '';
	} else {
		echo date('d-m-Y', strtotime($linha['dt_limite']));
	}
	?>
                                                    </td>
                                                    <td><?php if ($linha['dt_init_col'] == '') {
		echo '';
	} else {
		echo date('d-m-Y', strtotime($linha['dt_init_col']));
	}
	?>
                                                    </td>
                                                    <td><?php if ($linha['dt_fim_conf'] == '') {
		echo '';
	} else {
		echo date('d-m-Y', strtotime($linha['dt_fim_conf']));
	}
	?>
                                                    </td>
                                                    <td><?php if ($linha['dt_fim_coleta'] == '') {
		echo '';
	} else {
		echo date('d-m-Y', strtotime($linha['dt_fim_coleta']));
	}
	?>
                                                    </td>
                                                    <td><?php if ($linha['dt_lib_exp'] == '') {
		echo '';
	} else {
		echo date('d-m-Y', strtotime($linha['dt_lib_exp']));
	}
	?>
                                                    </td>
                                                    <td></td>
                                                    <td><?php if ($linha['dt_entrega'] == '') {
		echo '';
	} else {
		echo date('d-m-Y', strtotime($linha['dt_entrega']));
	}
	?></td>
                                                </tr>
                                                <div class="modal fade" id="comprovante<?php echo $linha['nr_pedido']; ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="comprovante" style="color: white">Comprovante de entrega</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="nm_cargo"></label>
            <?php
if ($linha['ds_anexo'] != "0") {

		//foreach ($linha['ds_anexo'] as $value) {

		echo '<img src ="../entrega/data/upload/' . $linha['id_destino'] . '/' . $linha['ds_anexo'] . '"style="with:100px;height:100px"/>';
		//}
	} else {
		echo "<p>Comprovante não encontrado</p>";
	}
	;?>
        </div>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div><!--Fim modal-->
                                                <?php }?>
                                            </tbody>
                                        </table>
                                                </div>
                                                <!-- end widget div -->

                                            </div>
                                        <!-- end widget -->

                                    </article>
                                    <!-- WIDGET END -->
                                    <div class="page-content-wrapper">
                                        <div id="invTar"></div>
                                    </div>

                                </div>

                                <!-- end row -->

                                <!-- end row -->

                                </section>
                                <!-- end widget grid -->
                                </div>
                            <!-- end widget content -->

                        </div>
                        <!-- end widget div -->

                    </div>
                    <!-- end widget -->

                </article>
                <!-- WIDGET END -->

            </div>

            <!-- end row -->

            <!-- row -->

            <div class="row">

                <!-- a blank row to get started -->
                <div class="col-sm-12">
                    <!-- your contents here -->
                </div>

            </div>

            <!-- end row -->

        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->
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
                        "sSearch": '<h5>Pesquisar</h5><span class="input-group-addon"><i class="fa fa-search"></i></span>'
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
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
            _gaq.push(['_trackPageview']);

            (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
            })();
        </script>
