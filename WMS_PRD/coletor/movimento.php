<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="home.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div><!-- /header -->
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!--div class="row">
					<a href="picking_pedido.php" style="text-decoration: none">
						<button type="button" class="btn btn-primary btn-lg btn-block">Picking</button>
					</a>
				</div-->
				<div class="row">
					<a href="picking_cego_piloto.php" style="text-decoration: none">
						<button type="button" class="btn btn-default btn-lg btn-block">Picking por Unidade</button>
					</a>
				</div>
				<div class="row">
					<a href="picking_onda.php" style="text-decoration: none">
						<button type="button" class="btn btn-success btn-lg btn-block" disabled="true">Picking por onda</button>
					</a>
				</div>
				<!--div class="row">
					<a href="picking_cego_piloto.php" style="text-decoration: none">
						<button type="button" class="btn btn-danger btn-lg btn-block">Picking (piloto)</button>
					</a>
				</div-->
				<div class="row">
					<a href="alocacao.php" style="text-decoration: none">
						<button type="button" class="btn btn-danger btn-lg btn-block">Alocação</button>
					</a>
				</div>
				<div class="row">
					<a href="picking_serial.php" style="text-decoration: none">
						<button type="button" class="btn btn-danger btn-lg btn-block" disabled>Serializados unidade (piloto)</button>
					</a>
				</div>
				<div class="row">
					<a href="picking_serial_comp.php" style="text-decoration: none">
						<button type="button" class="btn btn-danger btn-lg btn-block" disabled>Serializados componente (piloto)</button>
					</a>
				</div>
				<div class="row">
					<a href="picking_serial_cego.php" style="text-decoration: none">
						<button type="button" class="btn btn-danger btn-lg btn-block" disabled>Serializados cego (piloto)</button>
					</a>
				</div>
				<div class="row">
					<a href="transf_end.php" style="text-decoration: none">
						<button type="button" class="btn btn-danger btn-lg btn-block">Transferência de endereço</button>
					</a>
				</div>
			</article>
		</div>
	</div><!-- /content -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
		<p>Growup Soluções para logística</p>
		<p>Copyright 2018 - Growup</p>
	</div><!-- /footer -->
</div><!-- /page -->

</div><!-- /page two -->
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '#btnLogoutHome', function(){
			event.preventDefault();
			$.ajax
			({
				url:"logout.php",
				method: "GET",
				success:function(j)
				{
					alert("Saída realizada com sucesso!");
					window.location.replace("index.php");
				}
			});
		});
	});
</script>