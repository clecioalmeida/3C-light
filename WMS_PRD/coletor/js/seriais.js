
$(document).ready(function () {

	$(document).on('change', '#n_serie_med', function (event) {
		event.preventDefault();
		var serial = $("tr").find("td[data-serial]").data("serial");
		console.log(serial);

		if ($('#n_serie_med').val() == '') {

			alert("Favor informar o número de série!");

		} else {

			var nm_for 		= $('#nm_for').val();
			var cod_prd 	= $('#cod_prd_med').val();
			var nr_serial 	= $('#n_serie_med').val();
			var nr_pallet 	= $('#nr_pallet').val();
			var id_col 		= $('#id_col').val();

			$.post("xhr/consulta_nserie.php", { 
				nr_serial: nr_serial, 
				nr_pallet: nr_pallet, 
				nm_for: nm_for, 
				cod_prd:cod_prd, 
				id_col:id_col 
			}, function (data) {

				if (data.info == "0") {

					var retorno = data.text;
					var conf = data.conf;
					$('#retTotalCol').text(conf);
					$('#list_serial').prepend(retorno);
					$('#n_serie_med').val("");
					$('#n_serie_med').focus();
					$('#id_col').val(data.id_col);

				} else {

					var retorno = data.text;
					$('#list_serial').prepend(retorno);
					$('#n_serie_med').val("");
					$('#n_serie_med').focus();

				}

			}, "json");

		}
	});

	$(document).on('click', '#btnSaveSerialLight', function (event) {
		event.preventDefault();

		if ($('#n_serie').val() == '') {

			alert("Favor informar o número de série!");

		} else {

			var nm_for = $('#nm_for').val();
			var cod_prd = $('#cod_prd_med').val();
			var nr_serial = $('#n_serie_med').val();

			$.post("xhr/consulta_nserie.php", { 
				nr_serial: nr_serial, 
				nm_for: nm_for, 
				cod_prd:cod_prd 
			}, function (data) {

				if (data.info == "0") {

					var retorno = data.text;
					var conf = data.conf;
					$('#total_coletado').text(conf);
					$('#list_serial').prepend(retorno);
					$('#n_serie_med').val("");
					$('#n_serie_med').focus();

				} else {

					var retorno = data.text;
					$('#list_serial').prepend(retorno);
					$('#n_serie_med').val("");
					$('#n_serie_med').focus();

				}

			}, "json");

		}
	});

	$(document).on('click', '#btnDelSerialLight', function (event) {
		event.preventDefault();

		if (confirm("Confirma a exclusão do número de série?")) {

			var nr_serial = $(this).val();

			$.post("xhr/del_nserie.php", { nr_serial: nr_serial }, function (data) {

				var retorno = data.text;
				$('#list_serial').prepend(retorno);
				$('#n_serie_med').val("");
				$('#n_serie_med').focus();

			}, "json");
		}
	});

	$(document).on('click', '#btnFinColetaSerial', function (event) {
		event.preventDefault();

			$.post("xhr/fin_coleta_nserie.php", {
				id_col: $('#id_col').val()
			}, function (data) {

				window.location.href = "seriais.php";

				if(data.info == "0"){

					var conf = data.conf;
					$('#total_coletado').html(conf);

					window.location.href = "seriais.php";
					console.log(data.info);

				}else{

					window.location.href = "seriais.php";
					console.log(data.info);

				}

			}, "json");
			
	});

	$(document).on('click', '#btnFinSr', function (event) {
		event.preventDefault();

			$.post("xhr/fin_coleta_nserie.php", {
				id_col: $(this).attr("data-id")
			}, function (data) {

				if(data.info == "0"){

					window.location.href = "seriais.php";
					console.log(data.info, data.conf);
					alert("Coleta finalizada.");
					var conf = data.conf;
					$('#total_coletado').text(conf);

				}else{

					window.location.href = "seriais.php";
					console.log(data.info, data.conf);
					alert("Coleta finalizada.");
					var conf = data.conf;
					$('#total_coletado').text(conf);

				}

			}, "json");
			
	});

	$(document).on('change', '#cod_prd_med', function (event) {
		event.preventDefault();

		var barcode = $('#cod_prd_med').val();

		if ($('#cod_prd_med').val() == '') {

			alert("Favor digitar o código do produto!");

		} else {

			$.post("xhr/consulta_produto.php", { 
				barcode: barcode 
			}, function (data) {

				var retorno = data.info;
				$('#retNmPrdMed').html(retorno);
				$('#n_serie_med').val("");
				$('#n_serie_med').focus();

			}, "json");
		}
	});

	$(document).on('change', '#barcodeSerial', function (event) {
		event.preventDefault();

		var barcode = $('#barcodeSerial').val();

		if ($('#barcodeSerial').val() == '') {

			alert("Favor bipar o volume!");

		} else {

			$.post("xhr/consulta_produto.php", { 
				barcode: barcode 
			}, function (data) {

				var retorno = data.info;
				$('#retPrd').html(retorno);
				$('#nr_serial').val("");
				$('#localCegoSerial').focus();

			}, "json");
		}
	});

	$(document).on('change', '#nr_serial', function (event) {
		event.preventDefault();
		$('#retConfSerial').hide();
		var nr_serial = $('#nr_serial').val();

		if ($('#nr_serial').val() == '') {

			alert("Favor bipar o número de série!");

		} else {

			$.post("xhr/consulta_nserie_trafo.php", { 
				nr_serial: nr_serial
			}, function (data) {
				if(data.info != "0"){

					alert("Serial já existe no cadastro.");

				}

			}, "json");

		}
	});

	$(document).on('change', '#nr_serial_unid', function (event) {
		event.preventDefault();
		$('#retConfSerial').hide();
		var nr_serial = $('#nr_serial_unid').val();
		var nr_ped = $('#nrPedConf').val();
		var ds_end = $('#localCegoSerial').val();
		var cod_prd = $('#cod_prd').val();

		if ($('#nr_serial_unid').val() == '') {

			alert("Favor bipar o número de série!");

		} else {

			$.post("xhr/consulta_barcode.php", { 
				nr_serial: nr_serial, 
				nr_ped: nr_ped, 
				ds_end: ds_end 
			}, function (data) {

				console.log(data);

			});

		}
	});

	/*$(document).on('change','#nr_serial_unid',function(event){
		event.preventDefault();
		$('#retConfSerial').hide();
		var nr_serial 	= $('#nr_serial_unid').val();
		var nr_ped 		= $('#nrPedConf').val();
		var ds_end 		= $('#localCegoSerial').val();
		var cod_prd 	= $('#cod_prd').val();

		if($('#nr_serial_unid').val() == ''){

			alert("Favor bipar o número de série!");

		}else{

			$.post("xhr/consulta_nserie_unid.php",{nr_serial:nr_serial,nr_ped:nr_ped,ds_end:ds_end,cod_prd:cod_prd},function(data){

				var retorno 	= data.info;
				var text 		= data.text;
				var conf 		= data.conf;
				var saldo 		= data.saldo;
				var produto		= data.produto;

				$('#retConfSerial').html(text).show();
				$('#retExpPrd').html(produto);
				$('#TotalSelecionado').html(conf);
				$('#tot_ped').html(saldo);
				$('#list_serial').prepend(retorno);
				$('#nr_serial_unid').val("");
				$('#nr_serial_unid').focus();

			}, "json");

		}
	});*/

});

$(document).ready(function () {

	$(document).on('change', '#barcodeSerialRange', function (event) {
		event.preventDefault();

		var barcode = $('#barcodeSerialRange').val();

		if ($('#barcodeSerialRange').val() == '') {

			alert("Favor bipar o Produto!");

		} else {

			$.post("xhr/consulta_produto.php", { barcode: barcode }, function (data) {

				var retorno = data.info;
				$('#retPrd').html(retorno);
				$('#nr_serial_ini').val("");
				$('#localCegoSerial').focus();

			}, "json");
		}
	});

	$(document).on('change', '#nr_serial_fim', function (event) {
		event.preventDefault();
		$('#retConfSerial').hide();
		var nr_serial_ini = $('#nr_serial_ini').val();
		var nr_serial_fim = $('#nr_serial_fim').val();
		var nr_ped = $('#nrPedConf').val();
		var ds_end = $('#localCegoSerialRange').val();
		var cod_prd = $('#cod_prd').val();

		if ($('#nr_serial_ini').val() == '' || $('#nr_serial_fim').val() == '') {

			alert("Favor bipar o range do número de série!");

		} else {

			$.post("xhr/consulta_range_nserie.php", { nr_serial_ini: nr_serial_ini, nr_serial_fim: nr_serial_fim, nr_ped: nr_ped, ds_end: ds_end, cod_prd: cod_prd }, function (j) {

				for (var i = 0; i < j.length; i++) {

					var retorno = j[i].info;
					var text = j[i].text;
					var conf = j[i].conf;
					var saldo = j[i].saldo;
					var produto = j[i].produto;
					$('#retConfSerial').html(text).show();
					$('#retExpPrd').html(produto);
					$('#TotalSelecionado').html(conf);
					$('#tot_ped').html(saldo);
					$('#list_serial').prepend(retorno);
					$('#nr_serial_ini').val("");
					$('#nr_serial_fim').val("");
					$('#nr_serial_ini').focus();

				}

			}, "json");

		}
	});

	$(document).on('click', '#btnSaveRangeSerial', function (event) {
		event.preventDefault();
		$('#btnSaveRangeSerial').prop("disabled", true);
		$('#retConfSerial').hide();
		var nr_serial_ini = $('#nr_serial_ini').val();
		var nr_serial_fim = $('#nr_serial_fim').val();
		var nr_ped = $('#nrPedConf').val();
		var ds_end = $('#localCegoSerialRange').val();

		if ($('#nr_serial_ini').val() == '' || $('#nr_serial_fim').val() == '') {

			alert("Favor bipar o range do número de série!");

		} else {

			$.post("xhr/consulta_range_nserie.php", { nr_serial_ini: nr_serial_ini, nr_serial_fim: nr_serial_fim, nr_ped: nr_ped, ds_end: ds_end }, function (j) {

				for (var i = 0; i < j.length; i++) {

					var retorno = j[i].info;
					var text = j[i].text;
					var conf = j[i].conf;
					var saldo = j[i].saldo;
					$('#retConfSerial').html(text).show();
					$('#TotalSelecionado').html(conf);
					$('#tot_ped').html(saldo);
					$('#list_serial').prepend(retorno);
					$('#nr_serial_ini').val("");
					$('#nr_serial_fim').val("");
					$('#nr_serial_ini').focus();

				}

			}, "json");

		}
		$('#btnSaveRangeSerial').prop("disabled", false);
	});

	$(document).on('click', '#btnFinRangeSerial', function (event) {
		event.preventDefault();
		$('#btnSaveRangeSerial').prop("disabled", true);
		$('#retConfSerial').hide();
		var nr_ped = $('#nrPedConf').val();
		var ds_end = $('#localCegoSerialRange').val();

		$.post("xhr/fin_reg_serial.php", { nr_ped: nr_ped, ds_end: ds_end }, function (j) {

			for (var i = 0; i < j.length; i++) {

				var retorno = j[i].info;
				var text = j[i].text;
				$('#retConfSerial').html(text).show();
				$('#list_serial').prepend(retorno);

			}

		}, "json");

		$('#btnFinRangeSerial').prop("disabled", false);
	});

	$(document).on('click', '#btnSaveSerial', function (event) {
		event.preventDefault();
		$('#retConfSerial').hide();
		var nr_serial = $('#nr_serial').val();
		var nr_ped = $('#nrPedConf').val();
		var ds_end = $('#localCegoSerial').val();

		if ($('#nr_serial').val() == '') {

			alert("Favor bipar o número de série!");

		} else {

			$.post("xhr/consulta_nserie.php", { 
				nr_serial: nr_serial, 
				nr_ped: nr_ped, 
				ds_end: ds_end 
			}, function (data) {

				var retorno = data.info;
				var text = data.text;
				var conf = data.conf;
				var saldo = data.saldo;
				$('#retConfSerial').html(text).show();
				$('#TotalSelecionado').html(conf);
				$('#tot_ped').html(saldo);
				$('#list_serial').prepend(retorno);
				$('#nr_serial').val("");
				$('#nr_serial').focus();

			}, "json");

		}
	});

	$(document).on('click', '#btnFinSerial', function (event) {
		event.preventDefault();
		$('#btnFinSerial').prop("disabled", true);
		$('#retConfSerial').hide();
		var nr_ped = $('#nrPedConf').val();
		var ds_end = $('#localCegoSerial').val();

		$.post("xhr/fin_reg_serial.php", { nr_ped: nr_ped, ds_end: ds_end }, function (j) {

			for (var i = 0; i < j.length; i++) {

				var retorno = j[i].info;
				var text = j[i].text;
				$('#retConfSerial').html(text).show();
				$('#list_serial').prepend(retorno);

			}

		}, "json");

		$('#btnFinSerial').prop("disabled", false);
	});

});

$(document).ready(function () {

	$(document).on('change', '#nr_serial_exp', function (event) {
		event.preventDefault();
		$('#retConfSerial').hide();
		var nr_serial = $('#nr_serial_exp').val();
		var nr_ped = $('#nr_ped').val();
		console.log(nr_ped);

		if ($('#nr_serial').val() == '') {

			alert("Favor bipar o número de série!");

		} else {

			$.post("xhr/consulta_nserie_exp.php", { 
				nr_serial: nr_serial, 
				nr_ped: nr_ped 
			}, function (data) {

				var text = data.text;
				var conf = data.conf;
				var produto = data.produto;
				$('#retExpEndSerial').html(conf).show();
				$('#retConfSerialExp').html(produto);
				$('#list_serial').prepend(text);
				$('#nr_serial_exp').val("");
				$('#nr_serial_exp').focus();

			}, "json");

		}
	});

	$(document).on('change', '#nr_serial_fim_exp', function (event) {
		event.preventDefault();
		$('#retConfSerial').hide();
		var nr_serial_ini = $('#nr_serial_ini_exp').val();
		var nr_serial_fim = $('#nr_serial_fim_exp').val();
		var nr_ped = $('#nr_ped').val();

		if ($('#nr_serial_ini_exp').val() == '' || $('#nr_serial_fim_exp').val() == '') {

			alert("Favor bipar o range do número de série!");

		} else {

			$.post("xhr/consulta_nserie_range_exp.php", { 
				nr_serial_ini: nr_serial_ini, 
				nr_serial_fim: nr_serial_fim, 
				nr_ped: nr_ped 
			}, function (j) {

				for (var i = 0; i < j.length; i++) {
					var retorno = j[i].info;
					var text = j[i].text;
					var produto = j[i].produto;
					$('#retConfSerialExp').html(text).show();
					$('#retExpPrd').html(produto);
					$('#list_serial').prepend(retorno);
					$('#nr_serial_ini_exp').val("");
					$('#nr_serial_fim_exp').val("");
					$('#nr_serial_fim_exp').focus();

				}

			}, "json");

		}
	});

	$(document).on('click', '#btnFinConfExpSerial', function (event) {
		event.preventDefault();

		$('#btnFinConfExpSerial').prop("disabled", true);

		var pedido = $(this).val();

		$.post("xhr/fin_conf_exp_serial.php", { pedido: pedido },
			function (data) {
				var retorno = data.info;
				$('#retFinConfExpSerial').html(retorno);
			}, "json");

		return false;
	});

});

$(document).ready(function () {
	$('#retExpEnd1').hide();
	$('#retExpEnd2').hide();
	$(document).on('click', '#btnFinConfPedCegoSerial', function (event) {
		event.preventDefault();
		if (confirm("Confirma a finalização do pedido? Não será possivel incluir novos produtos após confirmação.")) {
			var pedido = $(this).val();
			var nr_sap = $(this).attr("data-sap");

			$.post("xhr/consulta_barcode.php", { nr_ped: pedido, nr_sap: nr_sap }, function (c) {
				console.log(c);

				/*$.post("xhr/consulta_separacao_serial.php",{pedido:pedido},function(j){

					if(j.info == 1){

						$.post("xhr/fin_conf_cego_serial.php",{pedido:pedido},function(k){
							var info = k.info;
							if(info == 1){
								$('#retExpEnd1').show();
								$('#retExpEnd1').html("Pedido finalizado com sucesso!");
							}else{
								$('#retExpEnd2').show();
								$('#retExpEnd2').html(info);
							}
						}, "json");

					}else{

						$('#retExpEnd2').show();
						$('#retExpEnd2').html(info);

					}

				}, "json");*/

			});

		}

	});

	$(document).on('change', '#nr_serial_unid_comp', function (event) {
		event.preventDefault();
		$('#retConfSerialComp').hide();
		var nr_serial = $('#nr_serial_unid_comp').val();
		var nr_ped = $('#nrPedConf').val();
		var ds_end = $('#localCegoSerial').val();
		var cod_prd = $('#cod_prd').val();

		if ($('#nr_serial_unid_comp').val() == '') {

			alert("Favor bipar o número de série!");

		} else {

			$.post("xhr/consulta_nserie_unid_comp.php", { 
				nr_serial: nr_serial, 
				nr_ped: nr_ped, 
				ds_end: ds_end, 
				cod_prd: cod_prd 
			}, function (data) {

				var retorno = data.info;
				var text = data.text;
				var conf = data.conf;
				var saldo = data.saldo;
				var produto = data.produto;

				$('#retConfSerial').html(text).show();
				$('#retExpPrdComp').html(produto);
				$('#TotalSelecionado').html(conf);
				$('#tot_ped').html(saldo);
				$('#list_serial_comp').prepend(retorno);
				$('#nr_serial_unid_comp').val("");
				$('#nr_serial_unid_comp').focus();

			}, "json");

		}
	});

	$(document).on('click', '#btnFinSerialComp', function (event) {
		event.preventDefault();
		$('#btnFinSerialComp').prop("disabled", true);
		$('#retConfSerialComp').hide();
		var nr_ped = $('#nrPedConf').val();
		var ds_end = $('#localCegoSerial').val();

		$.post("xhr/fin_reg_serial_comp.php", { nr_ped: nr_ped, ds_end: ds_end }, function (j) {

			for (var i = 0; i < j.length; i++) {

				var retorno = j[i].info;
				var text = j[i].text;
				$('#retConfSerial').html(text).show();
				$('#list_serial_comp').prepend(retorno);

			}

		}, "json");

		$('#btnFinSerialComp').prop("disabled", false);
	});

	$(document).on('click', '#btnSaveSerialComp', function (event) {
		event.preventDefault();
		$('#btnSaveSerialComp').hide();
		var nr_serial = $('#nr_serial_unid_comp').val();
		var nr_ped = $('#nrPedConf').val();
		var ds_end = $('#localCegoSerial').val();

		if ($('#nr_serial_unid_comp').val() == '') {

			alert("Favor bipar o número de série!");

		} else {

			$.post("xhr/consulta_nserie_unid_comp.php", { 
				nr_serial: nr_serial, 
				nr_ped: nr_ped, 
				ds_end: ds_end 
			}, function (data) {

				var retorno = data.info;
				var text = data.text;
				var conf = data.conf;
				var saldo = data.saldo;
				$('#retConfSerial').html(text).show();
				$('#TotalSelecionado').html(conf);
				$('#tot_ped').html(saldo);
				$('#list_serial').prepend(retorno);
				$('#nr_serial_unid_comp').val("");
				$('#nr_serial_unid_comp').focus();

			}, "json");

		}
	});

	$('#retExpEnd1').hide();
	$('#retExpEnd2').hide();
	$(document).on('click', '#btnFinConfPedCompSerial', function (event) {
		event.preventDefault();
		if (confirm("Confirma a finalização do pedido? Não será possivel incluir novos produtos após confirmação.")) {
			var pedido = $(this).val();
			$.post("xhr/consulta_separacao_serial_comp.php", { pedido: pedido }, function (j) {

				if (j.info == 1) {

					$.post("xhr/fin_conf_comp_serial.php", { pedido: pedido }, function (k) {
						var info = k.info;
						if (info == 1) {
							$('#retExpEnd1').show();
							$('#retExpEnd1').html("Pedido finalizado com sucesso!");
						} else {
							$('#retExpEnd2').show();
							$('#retExpEnd2').html(info);
						}
					}, "json");

				} else {

					$('#retExpEnd2').show();
					$('#retExpEnd2').html(info);

				}

			}, "json");

		}

	});

});