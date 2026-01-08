$(document).ready(function() {
	$('#fl_pag_o').on('click', function(){
		$('#cli_pag').toggle();
	});

	$('#btnCalcFrete').on('click',function(e){
		$('#btnCalcFrete').prop("disable", true);

		var tp_veic = $('#insTipoVeiculoCobrado').val();
		var cod_org = $('#insCidOrgMan').val();
		var cod_dst = $('#insDestTabela').val();
		var id_op = $('#insOpCte').val();
		var nm_rota = $('#insTipoRota').find(':selected').text();
		var uf_org_imp = $('#uf_org').val();
		var uf_dst = $('#uf_dst').val();
		var uf_dst_rota = $('#insDestTabela').find(':selected').attr("data-uf");


		if(tp_veic == '' || id_op == ''){

			alert("Por favor selecione a operação e o veículo.");

		}else{

			$.ajax
			({
				url:"data/expedicao/consulta_aliquota.php",
				method:"POST",
				dataType:'json',
				data:
				{
					uf_org_imp 	:uf_org_imp,
					uf_dst 	:uf_dst_rota
				},
				success:function(s)
				{
					for (var i = 0; i < s.length; i++) {
						var aliquota = s[i].aliquota;
						var regime = s[i].regime;
						if(regime == 'SN'){

							$('#aliquota').val(0);
							$('#frete_peso').css({'background-color' : '#98FB98'});
							$('#aliquota').css({'background-color' : '#98FB98'});
							$('#total_frete').css({'background-color' : '#98FB98'});

						}else{

							$('#frete_peso').css({'background-color' : '#98FB98'});
							$('#aliquota').css({'background-color' : '#98FB98'});
							$('#total_frete').css({'background-color' : '#98FB98'});

							$.ajax
							({
								url:"data/expedicao/consulta_tabela.php",
								method:"POST",
								dataType:'json',
								data:
								{
									tp_veic 	:tp_veic,
									cod_org 	:cod_org,
									cod_dst 	:cod_dst,
									id_op 		:id_op,
									nm_rota 	:nm_rota
								},
								success:function(j)
								{
									for (var i = 0; i < j.length; i++) {
										if(j[i].info == "0"){

											var frete_peso = j[i].vl_frete_minimo;
											var aliq = (100-(aliquota))/100;
											var fpeso = frete_peso*aliq;
											console.log (frete_peso, aliq, fpeso);

											$('#aliquota').val(aliquota);
											$('#frete_peso').val(fpeso.toFixed(3));
											$('#pedagio').val(j[i].vl_pedagio);
											$('#gris').val(j[i].fl_advalor);
											$('#outros').val(j[i].vl_outros);

											var fp = parseFloat($('#frete_peso').val().replace(',','') != '' ? $('#frete_peso').val().replace(',','') : 0);
											var sg = parseFloat($('#seguro').val().replace(',','') != '' ? $('#seguro').val().replace(',','') : 0);
											var pd = parseFloat($('#pedagio').val().replace(',','') != '' ? $('#pedagio').val().replace(',','') : 0);
											var gr = parseFloat($('#gris').val().replace(',','') != '' ? $('#gris').val().replace(',','') : 0);
											var ot = parseFloat($('#outros').val().replace(',','') != '' ? $('#outros').val().replace(',','') : 0);
											var ae = parseFloat($('#vl_aet').val().replace(',','') != '' ? $('#vl_aet').val().replace(',','') : 0);
											var es = parseFloat($('#vl_escolta').val().replace(',','') != '' ? $('#vl_escolta').val().replace(',','') : 0);
											var ve = parseFloat($('#vl_excedente').val().replace(',','') != '' ? $('#vl_excedente').val().replace(',','') : 0);
											var dc = parseFloat($('#vl_descarga').val().replace(',','') != '' ? $('#vl_descarga').val().replace(',','') : 0);
											var vm = parseFloat($('#valor_total_nf').val().replace(',',''));
											if($('#seguro').val() != ''){

												var vsg = vm*(sg/100);
												$('#vl_seguro').val(vsg.toFixed(2).replace('.',','));

											}else{

												$('#vl_seguro').val("0,00");
												vsg = 0;
											}

											var st = (fp + pd + gr + ot + ae + es + ve + dc + vsg);

											$('#total_frete').val(st.toFixed(2).replace('.',','));

											if($('#aliquota').val() != ''){

												var alq = (100-(parseFloat($('#aliquota').val())))/100;
												var tt = st / alq;
												var ip = tt * ($('#aliquota').val()/100);
												var nfp = fp*alq;

												$('#imposto').val(ip.toFixed(2).replace('.',','));

												$('#total_frete').val(tt.toFixed(2).replace('.',','));

												$('#base').val(tt.toFixed(2).replace('.',','));

											}else{

												$('#imposto').val("0,00");
												$('#base').val("0,00");

											}

										}else{

											alert("Não há tabela associada a esses parâmetros");

										}
									}


								}
							});

						}

					}
				}
			});
		}		

		$('#frete_peso').css({'background-color' : '#98FB98'});

		return false;	
		$('#btnCalcFrete').prop("disable", false);
	});

$('#btnCalcFreteMan').on('click',function(e){
	$('#btnCalcFreteMan').prop("disable", true);
	if($('#frete_peso').val() == ""){

		alert("Digite o frete peso.");

	}else{

		var uf_org_imp = $('#uf_org').val();
		var uf_dst = $('#uf_dst').val();

		
		$.ajax
		({
			url:"data/expedicao/consulta_aliquota.php",
			method:"POST",
			dataType:'json',
			data:
			{
				uf_org_imp 	:uf_org_imp,
				uf_dst 	:uf_dst
			},
			success:function(s)
			{
				for (var i = 0; i < s.length; i++) {
					var aliquota = s[i].aliquota;
					var regime = s[i].regime;
					if(regime == 'SN'){

						$('#aliquota').val(0);
						$('#frete_peso').css({'background-color' : '#98FB98'});
						$('#aliquota').css({'background-color' : '#98FB98'});
						$('#total_frete').css({'background-color' : '#98FB98'});

					}else{

						$('#frete_peso').css({'background-color' : '#98FB98'});
						$('#aliquota').css({'background-color' : '#98FB98'});
						$('#total_frete').css({'background-color' : '#98FB98'});

						var frete_peso = parseFloat($('#frete_peso').val().replace(',',''));
						var aliq = (100-(aliquota))/100;
						var fpeso = frete_peso*aliq;

						$('#aliquota').val(aliquota);
						$('#frete_peso').val(fpeso.toFixed(3));

						var fpm = parseFloat($('#frete_peso').val().replace(',','') != '' ? $('#frete_peso').val().replace(',','') : 0);
						var sgm = parseFloat($('#seguro').val().replace(',','') != '' ? $('#seguro').val().replace(',','') : 0);
						var pdm = parseFloat($('#pedagio').val().replace(',','') != '' ? $('#pedagio').val().replace(',','') : 0);
						var grm = parseFloat($('#gris').val().replace(',','') != '' ? $('#gris').val().replace(',','') : 0);
						var otm = parseFloat($('#outros').val().replace(',','') != '' ? $('#outros').val().replace(',','') : 0);
						var aem = parseFloat($('#vl_aet').val().replace(',','') != '' ? $('#vl_aet').val().replace(',','') : 0);
						var esm = parseFloat($('#vl_escolta').val().replace(',','') != '' ? $('#vl_escolta').val().replace(',','') : 0);
						var vem = parseFloat($('#vl_excedente').val().replace(',','') != '' ? $('#vl_excedente').val().replace(',','') : 0);
						var dcm = parseFloat($('#vl_descarga').val().replace(',','') != '' ? $('#vl_descarga').val().replace(',','') : 0);
						var vmm = parseFloat($('#valor_total_nf').val().replace(',',''));
						if($('#seguro').val() != ''){

							var vsgm = vmm*(sgm/100);
							$('#vl_seguro').val(vsgm.toFixed(2).replace('.',','));

						}else{

							$('#vl_seguro').val("0,00");
							vsgm = 0;
						}

						var stm = (fpm + pdm + grm + otm + aem + esm + vem + dcm + vsgm);

						$('#total_frete').val(stm.toFixed(2).replace('.',','));

						if($('#aliquota').val() != ''){

							var alqm = (100-(parseFloat($('#aliquota').val())))/100;
							var ttm = stm / alqm;
							var ipm = ttm * ($('#aliquota').val()/100);
							var nfpm = fpm*alqm;

							$('#imposto').val(ipm.toFixed(2).replace('.',','));

							$('#total_frete').val(ttm.toFixed(2).replace('.',','));

							$('#base').val(ttm.toFixed(2).replace('.',','));

						}else{

							$('#imposto').val("0,00");
							$('#base').val("0,00");

						}

					}

				}
			}
		});

	}
	
	return false;	
	$('#btnCalcFreteMan').prop("disable", false);
});
/*
$('.valor').on('change',function(){
	var fp = parseFloat($('#frete_peso').val().replace(',','') != '' ? $('#frete_peso').val().replace(',','') : 0);
	var sg = parseFloat($('#seguro').val().replace(',','') != '' ? $('#seguro').val().replace(',','') : 0);
	var pd = parseFloat($('#pedagio').val().replace(',','') != '' ? $('#pedagio').val().replace(',','') : 0);
	var gr = parseFloat($('#gris').val().replace(',','') != '' ? $('#gris').val().replace(',','') : 0);
	var ot = parseFloat($('#outros').val().replace(',','') != '' ? $('#outros').val().replace(',','') : 0);
	var ae = parseFloat($('#vl_aet').val().replace(',','') != '' ? $('#vl_aet').val().replace(',','') : 0);
	var es = parseFloat($('#vl_escolta').val().replace(',','') != '' ? $('#vl_escolta').val().replace(',','') : 0);
	var ve = parseFloat($('#vl_excedente').val().replace(',','') != '' ? $('#vl_excedente').val().replace(',','') : 0);
	var dc = parseFloat($('#vl_descarga').val().replace(',','') != '' ? $('#vl_descarga').val().replace(',','') : 0);
	var vm = parseFloat($('#valor_total_nf').val().replace(',',''));
	if($('#seguro').val() != ''){

		var vsg = vm*(sg/100);
		$('#vl_seguro').val(vsg.toFixed(2).replace('.',','));

	}else{

		$('#vl_seguro').val("0,00");
		vsg = 0;
	}

	var st = (fp + pd + gr + ot + ae + es + ve + dc + vsg);

	$('#total_frete').val(st.toFixed(2).replace('.',','));

	if($('#aliquota').val() != ''){

		var alq = (100-(parseFloat($('#aliquota').val())))/100;
		var tt = st / alq;
		var ip = tt * ($('#aliquota').val()/100);
		var nfp = fp*alq;

		$('#imposto').val(ip.toFixed(2).replace('.',','));

		$('#total_frete').val(tt.toFixed(2).replace('.',','));

		$('#base').val(tt.toFixed(2).replace('.',','));

	}else{

		$('#imposto').val("0,00");
		$('#base').val("0,00");

	}
});*/
});
/*
$('#frete_peso').on('click',function(){
	var fp = parseFloat($('#frete_peso').val().replace(',','.') != '' ? $('#frete_peso').val().replace(',','.') : 0);
	var sg = parseFloat($('#seguro').val().replace(',','') != '' ? $('#seguro').val().replace(',','') : 0);
	var pd = parseFloat($('#pedagio').val().replace(',','') != '' ? $('#pedagio').val().replace(',','') : 0);
	var gr = parseFloat($('#gris').val().replace(',','') != '' ? $('#gris').val().replace(',','') : 0);
	var ot = parseFloat($('#outros').val().replace(',','') != '' ? $('#outros').val().replace(',','') : 0);
	var ae = parseFloat($('#vl_aet').val().replace(',','') != '' ? $('#vl_aet').val().replace(',','') : 0);
	var es = parseFloat($('#vl_escolta').val().replace(',','') != '' ? $('#vl_escolta').val().replace(',','') : 0);
	var ve = parseFloat($('#vl_excedente').val().replace(',','') != '' ? $('#vl_excedente').val().replace(',','') : 0);
	var dc = parseFloat($('#vl_descarga').val().replace(',','') != '' ? $('#vl_descarga').val().replace(',','') : 0);
	var vm = parseFloat($('#valor_total_nf').val().replace(',',''));
	if($('#seguro').val() != ''){

		var vsg = vm*(sg/100);
		$('#vl_seguro').val(vsg.toFixed(2).replace('.',','));

	}else{

		$('#vl_seguro').val("0,00");
		vsg = 0;
	}

	var st = (fp + pd + gr + ot + ae + es + ve + dc + vsg);

	$('#total_frete').val(st.toFixed(2).replace('.',','));

	if($('#aliquota').val() != ''){

		var alq = (100-(parseFloat($('#aliquota').val())))/100;
		var tt = st / alq;
		var ip = tt * ($('#aliquota').val()/100);

		$('#imposto').val(ip.toFixed(2).replace('.',','));

		$('#total_frete').val(tt.toFixed(2).replace('.',','));

		$('#base').val(tt.toFixed(2).replace('.',','));

	}else{

		$('#imposto').val("0,00");
		$('#base').val("0,00");

	}
});

$('#frete_peso').on('change',function(){
	$.getJSON('data/expedicao/consulta_aliquota.php', 
	{
		uf_org: $('#uf_org').val(),
		uf_dst: $('#insDestTabela').find(":selected").attr("data-uf"),
		ajax: 'true'
	}, 
	function(s){
		for (var i = 0; i < s.length; i++) {
			var aliquota = s[i].aliquota;
			var regime = s[i].regime;
			if(regime == 'SN'){

				$('#aliquota').val(0);
				$('#frete_peso').css({'background-color' : '#98FB98'});
				$('#aliquota').css({'background-color' : '#98FB98'});
				$('#total_frete').css({'background-color' : '#98FB98'});

			}else{

				$('#aliquota').val(aliquota);
				$('#frete_peso').css({'background-color' : '#98FB98'});
				$('#aliquota').css({'background-color' : '#98FB98'});
				$('#total_frete').css({'background-color' : '#98FB98'});

			}

		}
	});

	var fp = parseFloat($('#frete_peso').val().replace(',','.') != '' ? $('#frete_peso').val().replace(',','.') : 0);
	var sg = parseFloat($('#seguro').val().replace(',','') != '' ? $('#seguro').val().replace(',','') : 0);
	var pd = parseFloat($('#pedagio').val().replace(',','') != '' ? $('#pedagio').val().replace(',','') : 0);
	var gr = parseFloat($('#gris').val().replace(',','') != '' ? $('#gris').val().replace(',','') : 0);
	var ot = parseFloat($('#outros').val().replace(',','') != '' ? $('#outros').val().replace(',','.') : 0);
	var ae = parseFloat($('#vl_aet').val().replace(',','') != '' ? $('#vl_aet').val().replace(',','') : 0);
	var es = parseFloat($('#vl_escolta').val().replace(',','') != '' ? $('#vl_escolta').val().replace(',','') : 0);
	var ve = parseFloat($('#vl_excedente').val().replace(',','') != '' ? $('#vl_excedente').val().replace(',','') : 0);
	var dc = parseFloat($('#vl_descarga').val().replace(',','') != '' ? $('#vl_descarga').val().replace(',','') : 0);
	var vm = parseFloat($('#valor_total_nf').val().replace(',',''));
	if($('#seguro').val() != ''){

		var vsg = vm*(sg/100);
		$('#vl_seguro').val(vsg.toFixed(2).replace('.',','));

	}else{

		$('#vl_seguro').val("0,00");
		vsg = 0;
	}

	var st = (fp + pd + gr + ot + ae + es + ve + dc + vsg);

	$('#total_frete').val(st.toFixed(2).replace('.',','));

	if($('#aliquota').val() != ''){

		var alq = (100-(parseFloat($('#aliquota').val())))/100;
		var tt = st / alq;
		var ip = tt * ($('#aliquota').val()/100);

		$('#imposto').val(ip.toFixed(2).replace('.',','));

		$('#total_frete').val(tt.toFixed(2).replace('.',','));

		$('#base').val(tt.toFixed(2).replace('.',','));

	}else{

		$('#imposto').val("0,00");
		$('#base').val("0,00");

	}
	return false;
});*/