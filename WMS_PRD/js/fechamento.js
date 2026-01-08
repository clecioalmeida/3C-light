// ROTINAS PARA FECHAMENTO DE SALDOS FINANCEIROS //

$(document).ready(function(){
	$('#ConsFechCaixa').on('click',function(){
		event.preventDefault();
		var dt_ini = $('#dt_ini').val();
		var dt_fim = $('#dt_fim').val();

		if(dt_ini == '' || dt_fim == ''){

			alert('Por favor preencha todos os campos data');

		}else{

			$('#retFechData').load("data/financeiro/relatorio/fecha_periodo.php?search=",{dt_ini:dt_ini,dt_fim:dt_fim});

		}
		return false;
	});
});