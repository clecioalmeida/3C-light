<?php
require_once('data/movimento/bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST['nr_pedido'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_ped = "select distinct(nr_pedido), t1.cod_cliente, t1.dt_pedido, t1.dt_limite, t1.hr_limite, t1.fl_status, t2.nm_cliente from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where t1.fl_status <> 'D' ORDER BY t1.dt_limite desc";
$ped = mysqli_query($link,$sql_ped);
$tr = mysqli_num_rows($ped);
?>
<style type="text/css">
    .ocupado {
        background-color: #F08080;
    }

    .livre {
        background-color: #7FFFD4;
    }

    .alerta {
        background-color: #EEDD82;
    }

    .finalizado {
        background-color: #ADD8E6;
    }

    .expedido {
        background-color: #8FBC8F;
    }

    .expedicao {
        background-color: #98FB98;
    }
</style>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Operacional</li><li>Pedidos de distribuição</li>
		</ol>
	</div>
	<!-- MAIN CONTENT -->
	<div id="content">

		<!-- row -->
		<div class="row">
					
			<!-- right side of the page with the sparkline graphs -->
			<!-- col -->
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8"></div>
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
						<!-- widget div-->
						<div>
							<form method="POST" class="form-inline" id="pesquisa_movimenta" action="">
					            <fieldset>
									<div class="col-sm-8" style="text-align: left;">
										<div class="form-group">
											<input type="text" id="codigo" class="form-control" name="pedido" aria-describedby="basic-addon2" placeholder="Digite o pedido">
											<input type="submit" class="btn-info form-control" id="btnPesquisaPedido" value="Pesquisar">
										</div>
									</div>
									<!--button type="submit" id="btnNovoRec" class="btn btn-primary" style="float:right; margin-top: 4px; margin-right: 12px">Novo pedido</button-->
								</fieldset>
					        </form>	<br />	
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
													<span class="widget-icon"> <i class="fa fa-table"></i> </span>
													<h2>Pedidos de distribuição </h2>
														
												</header>
														
												<div>
														
													<!-- widget edit box -->
													<div class="jarviswidget-editbox">
														<!-- This area used as dropdown edit box -->
														
													</div>
													<!-- end widget edit box -->
														
													<!-- widget content -->
													<div class="widget-body no-padding" id="dados">
														
															<table class="table table-bordered table-checkable order-column" id="tbConfPed">
															        <thead>
            <tr>
            	<th> Ações </th>
                <th> Pedido</th>
                <th> Destinatário </th>
                <th> Data do pedido </th>
                <th> Data limite </th>
                <th> Status do pedido </th>
                <th> Ações </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($linha = mysqli_fetch_assoc($ped)){
                ?>
            <tr  class="status" data-status="<?php echo $linha['fl_status'];?>">
            	<td style="text-align: center">
                    <button type="submit" id="btnDtlPed" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Detalhe</button>
                    <button type="submit" id="btnUpdPed" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Alterar</button>
                    <button type="submit" id="btnInsInst" class="btn btn-success btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Instruções</button>
                </td>
                <td style="text-align: right;"> <?php echo $linha['nr_pedido'];?> </td>
                <td> <?php echo $linha['nm_cliente'];?> </td>
                <td> <?php 
                            if ($linha['dt_pedido'] == ''){
                                echo '';
                            }else{
                                echo date('d-m-Y', strtotime($linha['dt_pedido']));
                            }?>
                </td>
                <td> <?php 
                            if ($linha['dt_limite'] == 0){
                                echo '';
                            }else{
                                echo date('d-m-Y', strtotime($linha['dt_limite']));
                            }?>
                </td>
                <td class="status"> <?php 
                            if ($linha['fl_status'] == 'A') {
                                echo '<bold>ABERTO</bold>';
                            }elseif ($linha['fl_status'] == 'P') {
                                echo '<bold>CONFERÊNCIA FINALIZADA</bold>';
                            }elseif ($linha['fl_status'] == 'E') {
                                echo '<bold>EXPEDIÇAO</bold>';
                            }elseif ($linha['fl_status'] == 'C') {
                                echo '<bold>AGUARDANDO COLETA</bold>';
                            }elseif ($linha['fl_status'] == 'M') {
                                echo '<bold>COLETA INICIADA</bold>';
                            }elseif($linha['fl_status'] == 'F') {
                            	echo '<bold>COLETADO</bold>';
                            }elseif($linha['fl_status'] == 'X'){
                                echo '<bold>EXPEDIÇÃO</bold>';
                            }elseif($linha['fl_status'] == 'L'){
                                echo '<bold>EXPEDIDO</bold>';
                            }elseif($linha['fl_status'] == 'H'){
                                echo '<bold>MANUSEIO</bold>';
                            }
                        ?> 
                </td>
                <td style="text-align: center">  
                    <button type="submit" id="btnNsPed" class="btn btn-default btn-xs" value="<?php echo $linha['nr_pedido']; ?>">N. Série</button> 
                    <button type="submit" id="btnColPed" class="btn btn-default btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Liberar coleta</button>
                    <button type="submit" id="btnExpPed" class="btn btn-default btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Finalizar</button>
                    <button type="submit" id="btnDelPed" class="btn btn-danger btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Cancelar</button>
                </td>
                <?php }?>
            </tr>
        </tbody>
																</table>
														
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
														
										<!-- end row -->
														
										</section>
										<!-- end widget grid -->
										</div>
									<!-- end widget content -->


														<div id="retorno"></div>
														<div id="retornoPrd"></div>
														<div id="retornoPrdConf"></div>
									
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
<script type="text/javascript">
    $(document).ready(function(){
        var status_ = new Array();
        $('.status').each( function( i,v ){
            var $this = $( this )
            status_[i] = $this.attr('data-status');
            if(status_[i] == "A"){
                $this.addClass('ocupado');
            }else if(status_[i] == "C"){
                $this.removeClass('ocupado').addClass('alerta');
            }else if(status_[i] == "F"){
            	$this.removeClass('ocupado').addClass('livre');
            }else if (status_[i] == "P"){
            	$this.removeClass('ocupado').addClass('finalizado');
            }else if (status_[i] == "L"){
            	$this.removeClass('ocupado').addClass('expedido');
            }else if (status_[i] == "X"){
            	$this.removeClass('ocupado').addClass('expedicao');
            }else if (status_[i] == "H"){
            	$this.removeClass('ocupado').addClass('alerta');
            }
        });
    });
</script>