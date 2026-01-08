$(document).ready(function(){

	$('#retorno').load('list_nf_transportar.php');

	$('#btnGerarCteEnt').on('click',function(){
		if( $('.checkNf:checked').length == 0 ){
			alert('Selecione pelo menos uma entrega!');
		}else{

			/*---- SELECIONA OS DESTINOS ------*/

			var cidade = [];
			$('.checkNf:checked').each(function(){
				cidade.push($(this).attr("data-dst"));
			});
			
			var destinos = [];
			$.each(cidade, function(i, elemento){
				if($.inArray(elemento, destinos) === -1) destinos.push(elemento);
			});

			var qtd_destinos = destinos.length;
			if(qtd_destinos > 1){

				var mun_dest = destinos;
				var mun_dst = "DIVERSOS";
				var cod_dst = "";
				var uf_dst = "";

			}else{

				var mun_dest = destinos;
				var mun_dst = $('.checkNf:checked').closest('tr').find('td').eq(3).text();
				var cod_dst = $('.checkNf:checked').attr("data-cod_dst");
				var uf_dst = $('.checkNf:checked').attr("data-uf_dst");

			}

			/*---- SELECIONA AS ORIGENS ------*/

			var origem = [];
			$('.checkNf:checked').each(function(){
				origem.push($(this).attr("data-org"));
			});
			
			var origens = [];
			$.each(origem, function(i, elemento){
				if($.inArray(elemento, origens) === -1) origens.push(elemento);
			});

			var qtd_origens = origens.length;
			if(qtd_origens > 1){

				var mun_rem = "DIVERSOS";
				var cod_org = "";
				var uf_org = "";

			}else{

				var mun_rem = $('.checkNf:checked').attr("data-org");
				var cod_org = $('.checkNf:checked').attr("data-cod_org");
				var uf_org = $('.checkNf:checked').attr("data-uf_org");

			}

			/*---- SELECIONA OS REMETENTES ------*/

			var remetente = [];
			$('.checkNf:checked').each(function(){
				remetente.push($(this).attr("data-cnpj_rem"));
			});
			
			var rem = [];
			$.each(remetente, function(i, elemento){
				if($.inArray(elemento, rem) === -1) rem.push(elemento);
			});

			var qtd_remetente = rem.length;
			if(qtd_remetente > 1){

				var nm_remetente = "DIVERSOS";
				var cnpj_rem = "";

			}else{

				var nm_remetente = $('.checkNf:checked').closest('tr').find('td').eq(4).text();
				var cnpj_rem = $('.checkNf:checked').attr("data-cnpj_rem");

			}

			/*---- SELECIONA OS DESTINATÁRIOS ------*/

			var destinatario = [];
			$('.checkNf:checked').each(function(){
				destinatario.push($(this).attr("data-cnpj_dst"));
			});
			
			var dest = [];
			$.each(destinatario, function(i, elemento){
				if($.inArray(elemento, dest) === -1) dest.push(elemento);
			});

			var qtd_destinatario = dest.length;
			console.log(qtd_destinatario);
			if(qtd_destinatario > 1){

				var nm_destinatario = "DIVERSOS";
				var cnpj_dst = "";

			}else{

				var nm_destinatario = $('.checkNf:checked').closest('tr').find('td').eq(5).text();
				var cnpj_dst = $('.checkNf:checked').attr("data-cnpj_dst");

			}

			/*---- TOTALIZA A NOTA FISCAL ------*/

			var val = [];
			var total_vol = 0;
			var total_peso = 0;
			var total_vlr = 0;

			$('.checkNf:checked').each(function(){
				val.push($(this).val());

				var vol_nf = $(this).closest('tr').find('td').eq(6).text();
				var peso_nf = $(this).closest('tr').find('td').eq(7).text();
				var vlr_nf = $(this).closest('tr').find('td').eq(8).text();

				total_vol += parseInt(vol_nf);
				total_peso += parseFloat(peso_nf);
				total_vlr += parseFloat(vlr_nf);

			});

			$.ajax
			({
				url:'emit_cte.php',
				method:'POST',
				data:{
					nFiscal 		:val,
					qtd_destinos 	:qtd_destinos,
					total_vol 		:total_vol,
					total_peso 		:total_peso,
					total_vlr 		:total_vlr,
					nm_remetente 	:nm_remetente,
					nm_destinatario :nm_destinatario,
					mun_dest 		:mun_dest,
					mun_dst 		:mun_dst,
					mun_rem 		:mun_rem,
					cnpj_dst 		:cnpj_dst,
					cnpj_rem 		:cnpj_rem,
					cod_org 		:cod_org,
					cod_dst 		:cod_dst,
					uf_org 			:uf_org,
					uf_dst 			:uf_dst
				},
				success:function(data){
					$('#retorno').html(data);
				}
			});		
		}
		return false;
	});
});