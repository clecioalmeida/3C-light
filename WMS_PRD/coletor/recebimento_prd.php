<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="recebimento.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row"><h2>MATERIAIS</h2>
			<div class="ui-grid-solo">
				<div class="ui-block-a">
					<label class="select">CÓDIGO</label>
					<select name="cod_for" id="cod_for" name="cod_for">
						
					</select>
				</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">
					<div class="ui-bar ui-bar-a">
						<label for="basic" data-inline="true">Transportador</label>
						<input type="text" id="ds_transp" name="ds_transp" data-inline="true" value="" />
					</div>
				</div>
				<div class="ui-block-b">
					<div class="ui-bar ui-bar-a">
						<label for="basic" data-inline="true">Motorista</label>
						<input type="text" id="ds_mot" name="ds_mot" data-inline="true" value="" />
					</div>
				</div>
				<div class="ui-block-a">
					<div class="ui-bar ui-bar-a">
						<label for="basic" data-inline="true">Veículo</label>
						<input type="text" id="nr_veic" name="nr_veic" data-inline="true" value="" />
					</div>
				</div>
				<div class="ui-block-b">
					<div class="ui-bar ui-bar-a">
						<label for="basic" data-inline="true">Peso</label>
						<input type="text" id="nr_peso" name="nr_peso" data-inline="true" value="" style="text-align: right;" />
					</div>
				</div>
				<div class="ui-block-a">
					<div class="ui-bar ui-bar-a">
						<label for="basic" data-inline="true">Tipo de volume</label>
						<input type="text" id="tp_volume" name="tp_volume" data-inline="true" value="" />
					</div>
				</div>
				<div class="ui-block-b">
					<div class="ui-bar ui-bar-a">
						<label for="basic" data-inline="true">Volumes</label>
						<input type="text" id="ds_volume" name="ds_volume" data-inline="true" value="" style="text-align: right;" />
					</div>
				</div>
			</div>
			<div class="ui-grid-solo">
				<div>
					<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="GravaOR" value="" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">GRAVAR</button>
					<!--button type="button" id="GravaOR" class="btn btn-primary btn-lg btn-block">GRAVAR</button-->
				</div>
			</div>
			<div class="ui-grid-solo">
				<div id="InsPrd" style="display: none;">
					<button type="button" id="inserePRD" class="btn btn-primary btn-lg btn-block">INSERIR PRODUTOS</button>
				</div>
			</div>
		<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
			<p>Argus Soluções para logística</p>
			<p>Copyright 2021 - Argus</p>
		</div>
	</div>

</div>
