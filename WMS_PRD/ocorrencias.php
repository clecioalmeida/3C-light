<?php 
require_once('data/inventario/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.id, t1.id_galpao, t1.dt_inicio, t2.nome 
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.fl_status = 'P'";
$res_inv = mysqli_query($link,$SQL); 

$SQL_torre = "select * from tb_tipo_torre";
$res_torre = mysqli_query($link,$SQL_torre); 

$SQL_conf = "select t1.nm_cliente, t1.cod_cliente, t2.nm_cargo 
            from tb_cliente t1 left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
            where t1.nm_cargo = 20";
$res_conf = mysqli_query($link,$SQL_conf); 

$SQL_conf2 = "select t1.nm_cliente, t1.cod_cliente, t2.nm_cargo 
            from tb_cliente t1 left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
            where t1.nm_cargo = 20";
$res_conf2 = mysqli_query($link,$SQL_conf2); 

$link->close();
?>
<div id="main" role="main">
    <div id="ribbon">
        <ol class="breadcrumb">
            <li>Home</li><li>Inventário</li><li>Tarefas</li>
        </ol>
    </div>
    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- row -->
        <div class="row">
                    
            <!-- col -->
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                            
                    <!-- PAGE HEADER -->
                    <i class="fa-fw fa fa-home"></i> 
                        Qualidade 
                    <span>|  
                        Ocorrências
                    </span>
                </h1>
            </div>
            <!-- end col -->
                    
            <!-- right side of the page with the sparkline graphs -->
            <!-- col -->
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            </div>
            <!-- end col -->
                    
        </div>
        <!-- end row -->
                
        <!--
            The ID "widget-grid" will start to initialize all widgets below 
            You do not need to use widgets if you dont want to. Simply remove 
            the <section></section> and you can use wells or panels instead 
            -->
                
        <!-- widget grid -->
        <section id="widget-grid" class="">
                
            <!-- row -->
            <div class="row">
                        
                <!-- NEW WIDGET START -->
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            
                    <!-- Widget ID (each widget will need unique ID)-->
                        <!-- widget div-->
                        <div>
                                    
                            <!-- widget edit box -->
                            <div class="jarviswidget-editbox">
                                <!-- This area used as dropdown edit box -->
                                <input class="form-control" type="text">    
                            </div>
                            <!-- end widget edit box -->
                                    
                            <!-- widget content -->
                            <div class="widget-body">
                                <section id="widget-grid" class="">
                                                        
                                    <!-- row -->
                                    <div class="row">
                                                        
                                        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        
                                            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                                                <header>
                                                        
                                                </header>
                                                        
                                                <div>
                                                        
                                                    <!-- widget edit box -->
                                                    <div class="jarviswidget-editbox">
                                                        <!-- This area used as dropdown edit box -->
                                                        
                                                    </div>
                                                    <!-- end widget edit box -->
                                                        
                                                    <!-- widget content -->
                                                    <div class="widget-body no-padding" id="dados">
                                                        <br><br>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <form class="form-inline" method="POST" id="" action="">
                                                            <fieldset>
                                                                <button type="button" id="btnOcorPend" class="btn btn-success btn-sm">Ocorrências pendentes</button>
                                                                <button type="button" id="btnOCorFin" class="btn btn-primary btn-sm">Ocorrências finalizadas</button>
                                                                <button type="button" id="btnOCorNew" class="btn btn-success btn-sm" style="float: right;">Nova ocorrência</button>
                                                            </fieldset>
                                                        </form><br /><br />

                                                        <div id="infoOcorrencia" class="row" style="margin-left: 10px"></div>
                                                        <div id="retornoOcorrencia" class="row"></div>
                                                        </div>
                                                    </div>
                                                    <!-- end widget content -->
                                                        
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
<!--script>
$(document).ready(function(){
    $('#btnAgendados').click(function () {
        inventario($("#agendados").val())
    });

    
});
    
</script-->