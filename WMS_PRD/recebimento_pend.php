<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
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
</style>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Operacional</li><li>Recebimento</li>
		</ol>
	</div>
	<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>
						<div class="jarviswidget-editbox">
							<input class="form-control" type="text">
						</div>
						<div class="widget-body">
							<section id="widget-grid" class="">
								<div class="row">
									<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
											<header>
												<h2>Recebimento de produtos</h2>
												<button type="submit" id="btnNovoRec" class="btn btn-default btn-xs" style="float:right; margin-top: 4px; margin-right: 12px">Novo</button>
											</header>
											<div>
												<div class="jarviswidget-editbox">
												</div>
												<div class="widget-body no-padding" id="dados">
													<div id="confirma"></div>
													<div id="tabelaRec"></div>
												</div>
												<div id="retorno"></div>
												<div id="retornoOr"></div>
												<div id="retornoNfRec"></div>
											</div>
										</div>
									</article>
								</div>
							</section>
						</div>
					</div>
				</article>
			</div>
		</section>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#tabelaRec').load("data/recebimento/list_recebimento.php");

	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		var status_ = new Array();
		$('.status').each( function( i,v ){
			var $this = $( this )
			status_[i] = $this.attr('data-status');
			if(status_[i] == "A" || status_[i] == "K"){
				$this.addClass('ocupado');
			}else if(status_[i] == "C"){
				$this.removeClass('ocupado').addClass('alerta');
			}else if(status_[i] == "F"){
				$this.removeClass('ocupado').addClass('livre');
			}
		});
	});
</script>