$(document).ready(function() {
	$("#checkboxTodos").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

	$.ajax
	({
		url:"data/frota/resumo_abastecimento.php",
		dataType:'json',
		method:"POST",
		success:function(j)
		{
			for (var i = 0; i < j.length; i++) {

				$('#tot_ltr_abas').text(j[i].total_ltr);
				$('#vlr_ltr_abas').text(j[i].total_vlr);
				$('#med_ltr_abas').text(j[i].total_med);
			}
		}
	});

	pageSetUp();
	var responsiveHelper_dt_basic_2 = undefined;

	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};

	$('#dt_basic_2').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
		"t"+
		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"oLanguage": {
			"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
		},
		"preDrawCallback" : function() {
			if (!responsiveHelper_dt_basic_2) {
				responsiveHelper_dt_basic_2 = new ResponsiveDatatablesHelper($('#dt_basic_2'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_dt_basic_2.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_dt_basic_2.respond();
		}
	});
});

$('#btnConsAbast').on('click', function(){
	event.preventDefault();
	var nr_placa = $('#PlacaAbast').val();
	var dt_ini = $('#dtIniAbast').val();
	var dt_fim = $('#dtFimAbast').val();

	if(nr_placa == '' && dt_ini == '' && dt_fim == ''){

		alert('Por favor insira a placa e o intervalo de datas ou apenas o intervalo de datas.');

	}else if(nr_placa != '' && dt_ini == '' || dt_fim == ''){

		alert('Por favor insira a placa e o intervalo de datas ou apenas o intervalo de datas.');

	}else{
		$.ajax
		({
			url:"data/frota/list_man_cad_dtl.php",
			method:"POST",
			data:{
				nr_placa:nr_placa,
				dt_ini:dt_ini,
				dt_fim:dt_fim
			},          
			beforeSend:function(e){
				$("#listManAg").html("<img src='css/loading9.gif'>");
			},
			success:function(j)
			{
				$('#listManAg').html(j);
			}
		});
	}
	return false;
});

$('#btnConsCteMon').on('click', function(){
	event.preventDefault();
	var cnpj_dst = $('#CnpjMonDestCte').val();
	var cte_dst = $('#NrCteMonCte').val();
	$.ajax
	({
		url:"data/monitoramento/list_mon_cte.php",
		method:"POST",
		data:{
			cnpj_dst:cnpj_dst,
			cte_dst:cte_dst
		},          
		beforeSend:function(e){
			$("#listMonCte").html("<img src='css/loading9.gif'>");
		},
		success:function(j)
		{
			$('#listMonCte').html(j);
		}
	});
	return false;
});

$('#btnConsOcorMon').on('click', function(){
	event.preventDefault();
	$.ajax
	({
		url:"data/monitoramento/list_mon_ocor.php",
		beforeSend:function(e){
			$("#listMonOcor").html("<img src='css/loading9.gif'>");
		},
		success:function(j)
		{
			$('#listMonOcor').html(j);
		}
	});
	return false;
});