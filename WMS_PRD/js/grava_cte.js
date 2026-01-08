$('#btnEmitirCte').on('click',function(){
	event.preventDefault();

	if(confirm("Confirma a gravação dos Ct-es?")){		
		$('#btnEmitirCte').prop("disabled", true);
		var id_veiculo 			= $('#id_veic').val();
		var id_operacao 		= $('#insOpCte').val();
		var insCidOrgMan 		= $('#insCidOrgMan').val();
		var insCidDestMan 		= $('#insCidDestMan').val();
		var insExpCte	 		= $('#insExpCte').val();
		var insRecCte	 		= $('#insRecCte').val();
		var id_motorista 		= $('#id_mot').val();
		var id_carreta 			= $('#id_car').val();
		var vl_custo 			= $('#vl_custo').val();
		var id_carreta 			= $('#id_car').val();
		var id_carreta_ad		= $('#id_car2').val();
		var id_rota 			= $('#rota').val();
		var peso_total_nf		= $('#peso_total_nf').val();
		var peso_cubado_nf		= $('#peso_cubado_nf').val();
		var frete_peso 			= $('#frete_peso').val() ? $('#frete_peso').val() : 0;
		var seguro 				= $('#seguro').val();
		var vl_seguro 			= $('#vl_seguro').val() ? $('#vl_seguro').val() : 0;
		var pedagio 			= $('#pedagio').val() ? $('#pedagio').val() : 0;
		var gris 				= $('#gris').val() ? $('#gris').val() : 0;
		var tx_cte 				= $('#tx_cte').val() ? $('#tx_cte').val() : 0;
		var vl_excedente 		= $('#vl_excedente').val() ? $('#vl_excedente').val() : 0;
		var vl_aet 				= $('#vl_aet').val() ? $('#vl_aet').val() : 0;
		var vl_escolta 			= $('#vl_escolta').val() ? $('#vl_escolta').val() : 0;
		var outros 				= $('#outros').val() ? $('#outros').val() : 0;
		var aliquota 			= $('#aliquota').val();
		var total_frete 		= $('#total_frete').val() ? $('#total_frete').val() : 0;
		var base 				= $('#base').val() ? $('#base').val() : 0;
		var imposto 			= $('#imposto').val() ? $('#imposto').val() : 0;
		var fl_pag 				= $("input[name='fl_pag']:checked").val();
		var insPagCte 			= $('#insPagCte').val();
		var vl_descarga 		= $('#vl_descarga').val();
		var nr_pedido 			= $('#nr_pedido').val();
		var obs 				= $('#obs').val();
		var rateio 				= $('#insTipoRota').val();

		if(total_frete == '' || total_frete == 0 || peso_total_nf == ''){

			alert("Valor do frete ou peso da nota não pode ser zero.");

		}else{

			/*---- DEFININDO SE IRÁ GERAR RATEIO OU NÃO ------*/

			var fl_vg = $(this).find(':selected').attr("data-vg");

			var cidade = [];

			$('.checkboxCte:checked').each(function(){
				cidade.push($(this).attr("data-cid"));
			});
			
			var qtd_destinos = $('#total_destinos').val();

			if(qtd_destinos > 1){

				var url = "data/expedicao/ins_cte_fc_old.php";

			}else{

				var url = "data/expedicao/ins_cte_fc_old.php";

			}
			/*---- GERA ARRAY PRINCIPAL ------*/

			const ds_rateio = {};

			const criaPropSeVazio = (obj, prop, valor) => { 
				if (!(prop in obj)){
					obj[prop] = valor;
				}
			};

			$('select[name="insTipoRateio[]"] option:selected').each(function() {
				let valor = $(this).val();
				criaPropSeVazio(ds_rateio, valor, {});

				let cnpj = $(this).data("cnpj");
				criaPropSeVazio(ds_rateio[valor], cnpj, []);

				let nf = $(this).data("nf");
				ds_rateio[valor][cnpj].push(nf);
			});

			var j_rateio = JSON.stringify(ds_rateio);

			/*---- FIM GERA ARRAY PRINCIPAL ------*/

			$.ajax
			({
				url:url,
				method:"POST",
				dataType:'json',
				data:{
					rateio 				:rateio,
					insExpCte 			:insExpCte,
					insRecCte 			:insRecCte,
					insCidOrgMan 		:insCidOrgMan,
					insCidDestMan 		:insCidDestMan,
					peso_total_nf 		:peso_total_nf,
					peso_cubado_nf 		:peso_cubado_nf,
					frete_peso 			:frete_peso, 
					seguro 				:seguro,
					vl_seguro			:vl_seguro,
					pedagio 			:pedagio,
					gris 				:gris,
					tx_cte 				:tx_cte,
					vl_excedente 		:vl_excedente,
					vl_aet 				:vl_aet,
					vl_escolta 			:vl_escolta,
					outros 				:outros,
					base 				:base,
					aliquota 			:aliquota,
					imposto 			:imposto,
					total_frete 		:total_frete,
					fl_pag 				:fl_pag,
					insPagCte 			:insPagCte,
					id_veiculo 			:id_veiculo,
					id_operacao 		:id_operacao,
					id_motorista 		:id_motorista,
					id_carreta 			:id_carreta,
					id_carreta_ad 		:id_carreta_ad,
					vl_descarga 		:vl_descarga,
					nr_pedido			:nr_pedido,
					obs 				:obs,
					j_rateio 			:j_rateio
				},
				success:function(c)
				{
					for (var i = 0; i < c.length; i++) {
						if(c[i].info == "0"){
							alert("Ct-e criado com sucesso!");
							$('#retorno').load('list_nf_transportar.php');

						}else{
							alert("Erro no cadastro!");
						}
					}
				}
			});
		}						
		$('#btnEmitirCte').prop("disabled", false);
	}		
	return false;
});

$('#btnConfCte').on('click',function(){
	event.preventDefault();

	$('#btnConfCte').prop("disabled", true);
	var id_veiculo 			= $('#id_veic').val();
	var id_operacao 		= $('#insOpCte').val();
	var insCidOrgMan 		= $('#insCidOrgMan').val();
	var insCidDestMan 		= $('#insCidDestMan').val();
	var insExpCte	 		= $('#insExpCte').val();
	var insRecCte	 		= $('#insRecCte').val();
	var id_motorista 		= $('#id_mot').val();
	var id_carreta 			= $('#id_car').val();
	var vl_custo 			= $('#vl_custo').val();
	var id_carreta 			= $('#id_car').val();
	var id_carreta_ad		= $('#id_car2').val();
	var id_rota 			= $('#rota').val();
	var peso_total_nf		= $('#peso_total_nf').val();
	var peso_cubado_nf		= $('#peso_cubado_nf').val();
	var frete_peso 			= $('#frete_peso').val() ? $('#frete_peso').val() : 0;
	var seguro 				= $('#seguro').val();
	var vl_seguro 			= $('#vl_seguro').val() ? $('#vl_seguro').val() : 0;
	var pedagio 			= $('#pedagio').val() ? $('#pedagio').val() : 0;
	var gris 				= $('#gris').val() ? $('#gris').val() : 0;
	var tx_cte 				= $('#tx_cte').val() ? $('#tx_cte').val() : 0;
	var vl_excedente 		= $('#vl_excedente').val() ? $('#vl_excedente').val() : 0;
	var vl_aet 				= $('#vl_aet').val() ? $('#vl_aet').val() : 0;
	var vl_escolta 			= $('#vl_escolta').val() ? $('#vl_escolta').val() : 0;
	var outros 				= $('#outros').val() ? $('#outros').val() : 0;
	var aliquota 			= $('#aliquota').val();
	var total_frete 		= $('#total_frete').val() ? $('#total_frete').val() : 0;
	var base 				= $('#base').val() ? $('#base').val() : 0;
	var imposto 			= $('#imposto').val() ? $('#imposto').val() : 0;
	var fl_pag 				= $("input[name='fl_pag']:checked").val();
	var insPagCte 			= $('#insPagCte').val();
	var vl_descarga 		= $('#vl_descarga').val();
	var nr_pedido 			= $('#nr_pedido').val();
	var obs 				= $('#obs').val();
	var rateio 				= $('#insTipoRota').val();

	if(total_frete == '' || total_frete == 0 || peso_total_nf == ''){

		alert("Valor do frete ou peso da nota não pode ser zero.");

	}else{

		/*---- GERA ARRAY PRINCIPAL ------*/

		const ds_rateio = {};

		const criaPropSeVazio = (obj, prop, valor) => { 
			if (!(prop in obj)){
					obj[prop] = valor;
			}
		};

		$('select[name="insTipoRateio[]"] option:selected').each(function() {
			let valor = $(this).val();
			criaPropSeVazio(ds_rateio, valor, {});

			let cnpj = $(this).data("cnpj");
			criaPropSeVazio(ds_rateio[valor], cnpj, []);

			let nf = $(this).data("nf");
			ds_rateio[valor][cnpj].push(nf);
		});

		var j_rateio = JSON.stringify(ds_rateio);

		/*---- FIM GERA ARRAY PRINCIPAL ------*/

		var url = "data/expedicao/modal/m_conf_cte_new.php";

		$.ajax
		({
			url:url,
			method:"POST",
			data:{
				rateio 				:rateio,
				insExpCte 			:insExpCte,
				insRecCte 			:insRecCte,
				insCidOrgMan 		:insCidOrgMan,
				insCidDestMan 		:insCidDestMan,
				peso_total_nf 		:peso_total_nf,
				peso_cubado_nf 		:peso_cubado_nf,
				frete_peso 			:frete_peso, 
				seguro 				:seguro,
				vl_seguro			:vl_seguro,
				pedagio 			:pedagio,
				gris 				:gris,
				tx_cte 				:tx_cte,
				vl_excedente 		:vl_excedente,
				vl_aet 				:vl_aet,
				vl_escolta 			:vl_escolta,
				outros 				:outros,
				base 				:base,
				aliquota 			:aliquota,
				imposto 			:imposto,
				total_frete 		:total_frete,
				fl_pag 				:fl_pag,
				insPagCte 			:insPagCte,
				id_veiculo 			:id_veiculo,
				id_operacao 		:id_operacao,
				id_motorista 		:id_motorista,
				id_carreta 			:id_carreta,
				id_carreta_ad 		:id_carreta_ad,
				vl_descarga 		:vl_descarga,
				nr_pedido			:nr_pedido,
				obs 				:obs,
				j_rateio 			:j_rateio
			},
			success:function(c)
			{
				$('#retModalIns').html(c);

			}
		});				
		$('#btnConfCte').prop("disabled", false);
	}		
	return false;
});