<?php include 'includes/header.php'; ?>


        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <div style="position: fixed">
                <?php echo include 'includes/sidebar.php'; ?>
            </div>
            
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->

                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="dashboard.php">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Cadastros</span>
                            </li>
							<li>
								<span>Empresas</span>
							</li>
                        </ul>
                        <div class="page-toolbar">
                            <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm hide" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                                <i class="icon-calendar"></i>&nbsp;
                                <span class="thin uppercase hidden-xs"></span>&nbsp;
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Cadastros
                        <small>Empresas</small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                   	<div class="row">
                        <div class="col-md-12">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">

                    <div class="portlet-body">

                        <legend>Consulta</legend>
                        <div class="row">
                        <div class="col-md-12">
                                <form class="form-inline" method="POST" id="formItemTorre" action="">
                                    <fieldset>
                                        <a href="ocor_abertas.php" class="btn btn-labeled btn-success" id="btnOcorrencia">Ocorrências pendentes </a>
                                        <a href="#" class="btn btn-labeled btn-success" id="">Ocorrências finalizadas </a>
                                        <a href="#" class="btn btn-labeled btn-primary" id="" style="float: right;">Nova ocorrência </a>
                                    </fieldset>
                                </form><br /><br />
                                <div id="ocorrencia"></div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <!--div class="page-footer">
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div-->
        <!-- END FOOTER -->
    <?php include 'scripts.php'; ?>
<script>
	$(document).ready(function(){
        $('#btnOcorrencia').click(function(e){
            e.preventDefault();
            var href = $(this).attr('href');
            $('#ocorrencia').load(href+'#ocorrencia');
        });
	});
</script>