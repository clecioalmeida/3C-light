<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="home.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!--div class="row">
					<a href="expede_sp.php" style="text-decoration: none">
						<button type="button" class="btn btn-primary btn-lg btn-block">Expedição simples</button>
					</a>
				</div-->
				<div class="row">
					<a href="expede_sp.php" style="text-decoration: none">
						<button type="button" class="btn btn-primary btn-lg btn-block">Expedição Simples</button>
					</a>
				</div>
				<div class="row">
					<a href="expede_conv.php" style="text-decoration: none">
						<button type="button" class="btn btn-primary btn-lg btn-block">Conversor UMB</button>
					</a>
				</div>
				<!--div class="row">
					<a href="expede_ck.php" style="text-decoration: none">
						<button type="button" class="btn btn-primary btn-lg btn-block">Expedição por unidade</button>
					</a>
				</div>
				<div class="row">
					<a href="expede_on_3c.php" style="text-decoration: none">
						<button type="button" class="btn btn-primary btn-lg btn-block">Expedição por onda</button>
					</a>
				</div>
				<div class="row">
					<a href="expede_on_3c.php" style="text-decoration: none">
						<button type="button" class="btn btn-primary btn-lg btn-block">Expedição por onda (Piloto)</button>
					</a>
				</div>
				<div class="row">
					<a href="expede_on_3c_piloto.php" style="text-decoration: none">
						<button type="button" class="btn btn-primary btn-lg btn-block">Expedição por onda (parcial)</button>
					</a>
				</div>
				<div class="row">
					<a href="expede_on_serial.php" style="text-decoration: none">
						<button type="button" class="btn btn-primary btn-lg btn-block">Expedição serializados (piloto)</button>
					</a>
				</div-->
			</article>
		</div>
	</div>
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
		<p>Growup Soluções para logística</p>
		<p>Copyright 2018 - Growup</p>
	</div>
</div>
</div>
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