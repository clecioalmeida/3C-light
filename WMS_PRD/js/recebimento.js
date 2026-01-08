$(document).ready(function () {

	$(document).on('click', '#btnDelSeriePrd', function () {
		if (confirm("Confirma a exclusão do serial?")) {
			$('#btnDelSeriePrd').prop("disabled", true);
			var del_serie_prd = $(this).val();

			$.ajax
				({
					url: "data/recebimento/del_serie_prd.php",
					method: "POST",
					data: { del_serie_prd: del_serie_prd },
					success: function (retorno) {
						alert(retorno);
					}
				});

			$('#btnDelSeriePrd').prop("disabled", false);
		}
	});

	$(document).on('click', '#btnSaveAdicPrd', function (e) {
		if (confirm("Confirma a inclusão das informações?")) {
			event.preventDefault();
			var nr_vol = $(this).closest('tr').find('#nr_volume').val();
			var dt_val = $(this).closest('tr').find('#dt_validade').val();
			var id_item = $(this).val();
			var nr_ca = $(this).closest('tr').find('#nr_ca').val();
			var dt_ca = $(this).closest('tr').find('#dt_ca').val();
			var nr_laudo = $(this).closest('tr').find('#nr_laudo').val();
			var dt_laudo = $(this).closest('tr').find('#dt_laudo').val();
			var nr_qtde = $(this).closest('tr').find('#nr_qtde').val();

			if (nr_ca != "0" && dt_ca == "") {

				alert("Por favor insira a validade do CA.");
				console.log(dt_ca, nr_ca);

			} else if (nr_laudo != "0" && dt_laudo == "") {

				alert("Por favor insira a validade do Laudo.");

			} else if (nr_qtde == "") {

				alert("Por favor insira a quantidade.");

			} else {

				$.ajax
					({
						url: "data/recebimento/upd_volume_nf_item.php",
						method: "POST",
						data: {
							id_item: id_item,
							nr_vol: nr_vol,
							dt_val: dt_val,
							nr_ca: nr_ca,
							dt_ca: dt_ca,
							nr_laudo: nr_laudo,
							dt_laudo: dt_laudo,
							nr_qtde: nr_qtde
						},
						success: function (data) {

							alert(data);
						}
					});

			}
			return false;
		}
	});

	$(document).on('click', '#btnSaveEtqQtd', function (e) {
		if (confirm("Confirma a inclusão das informações?")) {
			event.preventDefault();
			var nr_qt = $(this).closest('tr').find('#nr_qtde').val();
			var id_item = $(this).val();

			if (nr_qt == '') {

				alert("Insira a quantidade.");

			} else {

				$.ajax
					({
						url: "data/recebimento/upd_qtd_etq.php",
						method: "POST",
						data: {
							id_item: id_item,
							nr_qt: nr_qt
						},
						success: function (data) {

							alert(data);
						}
					});

			}
			return false;
		}
	});

	$(document).on('click', '#btnSaveVolPrd', function (e) {
		event.preventDefault();

		var dt_ini_ag = $('#dt_ini_ag').val();
		var dt_fim_ag = $('#dt_fim_ag').val();

		if (dt_ini_ag == "" || dt_fim_ag == "") {

			alert("Por favor digite o período pesquisado.");

		} else {

			$.post("data/recebimento/list_recebimento_ag_dt.php", { dt_ini_ag: dt_ini_ag, dt_fim_ag: dt_fim_ag }, function (data) {

				$("#retornoAg").html("<img src='../css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				$('#retornoAg').html(data);

			});

		}
	});

	$(document).on('click', '#btnDtlPedSep', function (e) {
		if (confirm("Confirma a inclusão das informações?")) {
			event.preventDefault();

			var cod_rec = $(this).val();
			var dt_chegada = $('#dt_chegada').val();
			var hr_chegada = $('#hr_chegada').val();
			var init_descarga = $('#init_descarga').val();
			var fim_descarga = $('#fim_descarga').val();
			var t_descarregamento = $('#t_descarregamento').val();
			var t_permanece = $('#t_permanece').val();
			var fl_status = $('#fl_status').val();

			if (fl_status == "") {

				alert("Selecione o Status.");

			} else {

				$.ajax
					({
						url: "data/recebimento/upd_ag_hr.php",
						method: "POST",
						data: {
							cod_rec: cod_rec,
							dt_chegada: dt_chegada,
							hr_chegada: hr_chegada,
							init_descarga: init_descarga,
							fim_descarga: fim_descarga,
							t_descarregamento: t_descarregamento,
							t_permanece: t_permanece,
							fl_status: fl_status
						},
						success: function (data) {

							alert(data);

						}
					});

			}
			return false;
		}
	});

	$(document).on('click', '#btnRecAgNc', function () {
		event.preventDefault();
		if (confirm("Confirma o não comparecimento?")) {
			var upd_rec = $(this).val();

			$.ajax
				({
					url: "data/recebimento/upd_rec_nc.php",
					method: "POST",
					data:
					{
						upd_rec: upd_rec
					},
					success: function (data) {
						alert(data);
						$('#retornoAg').load('data/recebimento/list_recebimento_ag.php');
					}
				});
		}
		return false;
	});

	$(document).on('click', '#btnRepRec', function () {
		event.preventDefault();
		$('#retornoRep').load('data/recebimento/list_tb_recebimento_ag.php');
		return false;
	});

	$(document).on('click', '#btnRepRecMes', function () {
		event.preventDefault();
		var ds_mes = $('#ds_mes').val();

		$.ajax
			({
				url: "data/recebimento/list_tb_recebimento_ag_dtl.php",
				method: "POST",
				data:
				{
					ds_mes: ds_mes
				},
				success: function (data) {
					$('#retTbControlTransp').html(data);
				}
			});
		return false;
	});

	$(document).on('click', '#btnNfPend', function () {
		event.preventDefault();
		//$('#retorno').load('data/recebimento/list_nf_rec_pend.php');
		$('#retorno').load('data/recebimento/cad_div_nf.php');
		return false;
	});

	$(document).on('click', '#btnCadDivNf', function () {
		event.preventDefault();
		$('#retTbControlTransp').load('data/recebimento/cad_div_nf.php');
		return false;
	});

	$(document).on('click', '#btnInsNFDiv', function () {
		event.preventDefault();
		$('#retorno').load('data/recebimento/ins_nf_div.php');
		return false;
	});

	$(document).on('click', '#btnSavDivNf', function () {
		event.preventDefault();
		var ds_div = $('#ds_div').val();

		$.ajax
			({
				url: "data/recebimento/ins_div_nf.php",
				method: "POST",
				data:
				{
					ds_div: ds_div
				},
				success: function (data) {
					$('#listTbDivNf').load('data/recebimento/list_tb_div_nf.php');
				}
			});
		return false;
	});

	$(document).on('click', '#btnPesqRecNf', function () {
		var cod_rec = $('#cod_rec').val();

		if (cod_rec == "") {

			alert("Digite o código da OR.");

		} else {

			$.ajax
				({
					url: "data/recebimento/consulta_nf_rec_div.php",
					method: "POST",
					dataType: 'json',
					data: {
						cod_rec: cod_rec
					},
					success: function (j) {
						var options = '<option value="">Escolha a nota fiscal</option>';

						for (var i = 0; i < j.length; i++) {

							if (j[i].info == "0") {

								options += '<option value="' + j[i].nr_nf + '">' + j[i].nr_nf_formulario + '</option>';

							} else {

								options += '<option value="">Não há notas fiscais</option>';

							}
						}

						$('#nr_nf').html(options).show();
					}
				});

		}
	});

	$(document).on('click', '#btnInsDivNfRec', function () {
		event.preventDefault();
		$('#btnInsDivNfRec').prop("disabled", true);
		var id_rec = $('#cod_rec').val();

		$.post("data/recebimento/upd_div_nf.php", $("#formDivNf").serialize(), function (data) {
			alert(data);
			$('#cad_div_nfe').load("data/recebimento/list_tb_nf_div.php?search=", { id_rec: id_rec });
		});
		$('#btnInsDivNfRec').prop("disabled", false);
		return false;
	});

	$(document).on('click', '#btnInsDivNf', function () {
		event.preventDefault();
		$('#retModalNfPend').load('data/recebimento/modal/m_ins_div_nf.php');
		return false;
	});

	$(document).on('click', '#btInsSolDiv', function () {
		event.preventDefault();
		$('#retornoNfPend').load('data/recebimento/upd_nf_div.php?search=', { id_nf: $(this).val() });
		return false;
	});

	$(document).on('click', '#btnUpdDivNfRec', function () {
		event.preventDefault();
		$('#btnUpdDivNfRec').prop("disabled", true);
		var id_nf = $(this).val();

		$.post("data/recebimento/upd_sol_div_nf.php", $("#formUpdDivNf").serialize(), function (data) {
			alert(data);
			$('#retornoNfPend').load('data/recebimento/list_nf_rec_pend.php');
		});
		$('#btnUpdDivNfRec').prop("disabled", false);
		return false;
	});

	$(document).on('click', '#btnEncRecAg', function () {
		if (confirm("Confirma o encerramento do agendamento?")) {

			var upd_rec = $(this).val();
			var rec_sts = $(this).attr("data-st");
			var hr_chegada = $('#hr_chegada').val();
			var init_descarga = $('#init_descarga').val();
			var fim_descarga = $('#fim_descarga').val();
			var t_descarregamento = $('#t_descarregamento').val();
			var t_permanece = $('#t_permanece').val();

			if (rec_sts == "S") {

				alert("Somente agendamentos confirmados podem ser finalizados.");

			} else if (hr_chegada == '' || init_descarga == '' || fim_descarga == '' || t_descarregamento == '' || t_permanece == '') {

				alert("Por favor preencha os dados de recebimento.");

			} else {

				$.ajax
					({
						url: "data/recebimento/upd_fim_ag.php",
						method: "POST",
						data: { upd_rec: upd_rec },
						success: function (data) {
							alert(data);
							$('#retornoAg').load('data/recebimento/list_recebimento_ag.php');
						}
					});

			}
		}
	});

	$(document).on('click', '#btnNewRec', function () {
		var ins_rec = $(this).val();
		$.ajax
			({
				url: "ins_recebimento_jn.php",
				method: "POST",
				data: { ins_rec: ins_rec },
				success: function (data) {
					$('#retornoAg').html(data);
				}
			});
	});

	$(document).on('click', '#btnInsRec', function () {
		event.preventDefault();
		if (confirm("Confirma a criação do recebimento?")) {
			var nm_fornecedor = $('#nm_fornecedor').val();
			var tp_rec = $('#tp_rec').val();
			var nr_peso_previsto = $('#nr_peso_previsto').val();
			var dt_recebimento_previsto = $('#dt_recebimento_previsto').val();
			var nr_volume_previsto = $('#nr_volume_previsto').val();
			var ds_tipo_vol = $('#ds_tipo_vol').val();
			var nm_transportadora = $('#nm_transportadora').val();
			var nm_motorista = $('#nm_motorista').val();
			var nm_placa = $('#nm_placa').val();
			var dt_recebimento_real = $('#dt_recebimento_real').val();
			var ds_obs = $('#obs').val();
			var nr_insumo = $('#nr_insumo').val();
			var tp_recebimento = $('#tp_recebimento').val();
			var cod_ca = $('#cod_ca').val();
			var tp_prd = $('#tp_prd').val();
			$.ajax
				({
					url: "data/recebimento/ins_recebimento.php",
					method: "POST",
					dataType: 'json',
					data: {
						nm_fornecedor: nm_fornecedor,
						tp_rec: tp_rec,
						nr_peso_previsto: nr_peso_previsto,
						dt_recebimento_previsto: dt_recebimento_previsto,
						nr_volume_previsto: nr_volume_previsto,
						ds_tipo_vol: ds_tipo_vol,
						nm_transportadora: nm_transportadora,
						nm_motorista: nm_motorista,
						nm_placa: nm_placa,
						dt_recebimento_real: dt_recebimento_real,
						ds_obs: ds_obs,
						nr_insumo: nr_insumo,
						tp_recebimento: tp_recebimento,
						cod_ca: cod_ca,
						tp_prd: tp_prd
					},
					success: function (j) {
						for (var i = 0; i < j.length; i++) {
							if (j[i].info == 0) {
								alert("OR cadastrada com sucesso!");
								$('#retorno').load('data/recebimento/list_recebimento.php');
							} else {
								alert("Erro no cadastro!");
							}
						}
					}
				});
		}
	});

	$(document).on('click', '#btnInsRecJn', function () {
		event.preventDefault();
		if (confirm("Confirma a criação do recebimento?")) {
			var cod_rec = $(this).val();
			var nm_fornecedor = $('#nm_fornecedor').val();
			var tp_rec = $('#tp_rec').val();
			var nr_peso_previsto = $('#nr_peso_previsto').val();
			var dt_recebimento_previsto = $('#dt_recebimento_previsto').val();
			var nr_volume_previsto = $('#nr_volume_previsto').val();
			var ds_tipo_vol = $('#ds_tipo_vol').val();
			var nm_transportadora = $('#nm_transportadora').val();
			var nm_motorista = $('#nm_motorista').val();
			var nm_placa = $('#nm_placa').val();
			var dt_recebimento_real = $('#dt_recebimento_real').val();
			var ds_obs = $('#obs').val();
			var nr_insumo = $('#nr_insumo').val();
			var tp_recebimento = $('#tp_recebimento').val();
			$.ajax
				({
					url: "data/recebimento/ins_recebimento_jn.php",
					method: "POST",
					dataType: 'json',
					data: {
						cod_rec: cod_rec,
						nm_fornecedor: nm_fornecedor,
						tp_rec: tp_rec,
						nr_peso_previsto: nr_peso_previsto,
						dt_recebimento_previsto: dt_recebimento_previsto,
						nr_volume_previsto: nr_volume_previsto,
						ds_tipo_vol: ds_tipo_vol,
						nm_transportadora: nm_transportadora,
						nm_motorista: nm_motorista,
						nm_placa: nm_placa,
						dt_recebimento_real: dt_recebimento_real,
						ds_obs: ds_obs,
						nr_insumo: nr_insumo,
						tp_recebimento: tp_recebimento
					},
					success: function (j) {
						for (var i = 0; i < j.length; i++) {
							if (j[i].info == 0) {
								alert("OR cadastrada com sucesso!");
								$('#retornoAg').load('data/recebimento/list_recebimento_ag.php');
							} else {
								alert("Erro no cadastro!");
							}
						}
					}
				});
		}
	});

	$(document).on('click', '#btnNewRecAll', function () {
		event.preventDefault();

		if ($('.checkAg:checked').length == 0) {

			alert('Selecione pelo menos um agendamento!');

		} else {

			ins_rec_all = [];

			$('.checkAg:checked').each(function () {
				ins_rec_all.push($(this).val());
			});

			$.ajax
				({
					url: "ins_recebimento_jn_all.php",
					method: "POST",
					data: { ins_rec_all: ins_rec_all },
					success: function (data) {
						$('#retornoAg').html(data);
					}
				});
		}
	});

	$(document).on('click', '#btnInsRecJnAll', function () {
		event.preventDefault();
		if (confirm("Confirma a criação do recebimento?")) {
			//var cod_rec_all 				= $(this).val();
			var nm_fornecedor = $('#nm_fornecedor').val();
			var tp_rec = $('#tp_rec').val();
			var nr_peso_previsto = $('#nr_peso_previsto').val();
			var dt_recebimento_previsto = $('#dt_recebimento_previsto').val();
			var nr_volume_previsto = $('#nr_volume_previsto').val();
			var ds_tipo_vol = $('#ds_tipo_vol').val();
			var nm_transportadora = $('#nm_transportadora').val();
			var nm_motorista = $('#nm_motorista').val();
			var nm_placa = $('#nm_placa').val();
			var dt_recebimento_real = $('#dt_recebimento_real').val();
			var ds_obs = $('#obs').val();
			var nr_insumo = $('#nr_insumo').val();
			var tp_recebimento = $('#tp_recebimento').val();
			$.ajax
				({
					url: "data/recebimento/ins_recebimento_jn_all.php",
					method: "POST",
					dataType: 'json',
					data: {
						cod_rec_all: ins_rec_all,
						nm_fornecedor: nm_fornecedor,
						tp_rec: tp_rec,
						nr_peso_previsto: nr_peso_previsto,
						dt_recebimento_previsto: dt_recebimento_previsto,
						nr_volume_previsto: nr_volume_previsto,
						ds_tipo_vol: ds_tipo_vol,
						nm_transportadora: nm_transportadora,
						nm_motorista: nm_motorista,
						nm_placa: nm_placa,
						dt_recebimento_real: dt_recebimento_real,
						ds_obs: ds_obs,
						nr_insumo: nr_insumo,
						tp_recebimento: tp_recebimento
					},
					success: function (j) {
						for (var i = 0; i < j.length; i++) {
							if (j[i].info == 0) {
								alert("OR cadastrada com sucesso!");
								$('#retornoAg').load('data/recebimento/list_recebimento_ag.php');
							} else {
								alert("Erro no cadastro!");
							}
						}
					}
				});
		}
	});

	$(document).on('click', '#btnImpSap', function (e) {
		event.preventDefault();
		$('#retorno').load('importa_rec_sap.php');
	});

	$(document).on('click', '#btnInsPrdRec', function () {
		$('#btnInsPrdRec').prop("disabled", true);
		var id_rec = $(this).val();

		$.post("data/recebimento/ins_prd_recebimento.php", $("#formNovoPrdRec").serialize(), function (data) {
			alert(data);
			$('#retornoPrd').load('data/recebimento/list_rec_prd.php?search=', { id_rec: id_rec });
			$('#btnInsPrdRec').prop("disabled", false);
		});
	});

});

$(document).ready(function () {
	$(document).on('click', '#btnLibRec', function () {
		event.preventDefault();
		$('#btnLibRec').prop("disabled", true);
		var cod_rec = $(this).val();
		var tot_vol = $(this).attr("data-vl");

		if (tot_vol == "0") {

			alert("Volumes não foram gravados. Volte ao detalhe do recebimento e registre os volumes.");

		} else {

			$.ajax
				({
					url: "data/recebimento/valida_fim_rec.php",
					method: "POST",
					dataType: 'json',
					data: { cod_rec: cod_rec },
					success: function (j) {
						for (var i = 0; i < j.length; i++) {

							if (j[i].info == 0) {

								alert("Recebimento liberado para conferência!");

							} else if (j[i].info == 1) {

								alert("Erro no cadastro!");

							} else if (j[i].info == 2) {

								alert("Ocorreu um erro na criação do saldo!");

							} else if (j[i].info == 3) {

								alert("Não foram encontradas etiquetas para os volumes!");

							}
						}
					}
				});
		}
		$('#btnLibRec').prop("disabled", false);
		return false;
	});

	$(document).on('click', '#btnDelEtqRecUn', function () {
		event.preventDefault();
		if (confirm("Confirma a exclusão da etiqueta?")) {
			var id_etq = $(this).val();
			var sts = $(this).attr("data-st");
			var cod_nf = $(this).attr("data-nf");
			var cod_item = $(this).attr("data-it");
			if (sts == "T") {
				$('#btnDelEtqRecUn').prop("disabled", true);
				$.ajax
					({
						url: "data/recebimento/del_etq_rec.php",
						method: "POST",
						dataType: 'json',
						data: {
							id_etq: id_etq,
							cod_nf: cod_nf,
							cod_item: cod_item
						},
						success: function (j) {
							for (var i = 0; i < j.length; i++) {
								if (j[i].info == "0") {

									alert("Etiqueta excluida");

								} else {

									alert("Erro no cadastro!");

								}
							}
						}
					});
				$('#btnDelEtqRecUn').prop("disabled", false);
			} else {

				alert("Não é possível excluir etiquetas de produtos já alocados.");
				$('#btnDelEtqRecUn').prop("disabled", false);

			}
		}
		return false;
	});

	$(document).on('click', '#btnGeraEtqRecPrd', function () {
		event.preventDefault();
		if ($('.checkEtqRecPrd:checked').length == 0) {

			alert('Selecione pelo menos uma nota fiscal!');

		} else if ($('.checkEtqRecPrd:checked').attr("data-vl") == 0) {

			alert('Produto sem volume cadastrado!');

		} else {

			//console.log($('.checkEtqRecPrd:checked').attr("data-vl"));

			if (confirm("Confirma a criação das etiquetas?")) {
				$('#btnGeraEtqRecPrd').prop("disabled", true);
				var id_rec = $(this).val();
				var cod_nf_item = [];

				$('.checkEtqRecPrd:checked').each(function () {
					cod_nf_item.push($(this).val());

				});

				$.ajax
					({
						url: "data/recebimento/ins_etq_rec_prd.php",
						method: "POST",
						data: {
							cod_nf_item: cod_nf_item,
							id_rec: id_rec
						},
						beforeSend: function (e) {
							$("#retornoEtqPrd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
						},
						success: function (data) {

							$('#retornoEtqPrd').html(data);
						}
					});

				$('#btnGeraEtqRecPrd').prop("disabled", false);

				return false;
			}
		}
	});

	$(document).on('click', '#btnConsSerial', function () {
		event.preventDefault();
		var nserial = $("#nrSerial").val();

		$.ajax
			({
				url: "data/recebimento/list_recebimento_ns.php",
				method: "POST",
				data:
				{
					nserial: nserial
				},
				success: function (data) {
					$('#retornoNs').html(data);
				}
			});
		return false;
	});

	$(document).on('click', '#btnConsForn', function () {
		event.preventDefault();
		var nmForn = $("#nmFornecedor").val();

		$.ajax
			({
				url: "data/recebimento/list_recebimento_forn.php",
				method: "POST",
				data:
				{
					nmForn: nmForn
				},
				success: function (data) {
					$('#retornoNs').html(data);
				}
			});
		return false;
	});

	$(document).on('click', '#btnConsData', function () {
		event.preventDefault();
		var dt_inicio = $("#dt_inicio").val();
		var dt_fim = $("#dt_fim").val();

		$.ajax
			({
				url: "data/recebimento/list_recebimento_data.php",
				method: "POST",
				data:
				{
					dt_inicio: dt_inicio,
					dt_fim: dt_fim,
				},
				success: function (data) {
					$('#retornoNs').html(data);
				}
			});
		return false;
	});

	$(document).on('click', '#btnConsSerialPrd', function () {
		event.preventDefault();
		var codPrd = $('#codPrd').val();

		$.ajax
			({
				url: "data/recebimento/list_recebimento_ns_prd.php",
				method: "POST",
				data:
				{
					codPrd: codPrd
				},
				success: function (data) {
					$('#retornoNs').html(data);
				}
			});
		return false;
	});

	/*$(document).on('click', '#btnExportSapSeriaisRec', function () {
		console.log("Funciona.");
		//event.preventDefault();

		$.ajax
			({
				url: "data/recebimento/down_seriais.php",
				method: "POST",
				data:
				{
					codPrd: codPrd
				},
				success: function (data) {
					$('#retornoNs').html(data);
				}
			});
		//return false;
	});*/
	
	/*$(document).on('click','#btnDownPdfCte',function(){
		event.preventDefault();
		var dt_ini = $('#dt_ini').val();
		var dt_fim = $('#dt_fim').val();
	
		if(dt_ini == '' || dt_fim == ''){
	
			alert('Por favor preencha todos os campos data');
	
		}else{		
			$('#btnDownPdfCte').prop("disabled", true);
	
			$.ajax
			({
				url:"baixa_pdf.php",
				method:"POST",
				dataType:'json',
				data:{
					dt_ini		:dt_ini,
					dt_fim 		:dt_fim
				},
				beforeSend:function(e){
					$(".aguarde").show();
				},
				success:function(j)
				{
					$(".aguarde").hide();
	
					if(j.info == 0){
						$("#ret_imp_cte").append("<h2>Arquivo com CT-es autorizados gerado com sucesso! Aguarde o download.</h2>");
						var arquivo=j.arquivo;
						window.open(arquivo, "_blank");
	
					}else if(j.info == 1){
	
						$("#ret_imp_cte").append("<h2>O arquivo não pode ser gerado!</h2>");
	
					}else{
	
						$("#ret_imp_cte").append("<h2>Não há CT-es autorizados no período!</h2>");
	
					}
				}
			});
	
			$('#btnDownPdfCte').prop("disabled", false);
		}
		return false;
	});*/

});