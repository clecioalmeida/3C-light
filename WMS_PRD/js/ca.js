$(document).ready(function(){

	$('#linkAlca').click(function(e){
		event.preventDefault();
		$('#conteudo').load('ca.php');
	});

	$(document).on('click', '#btnPesqFunc',function(){
		event.preventDefault();
		$('#retornoCa').load('data/recebimento/list_ca_func.php?search=',{nr_matr:$('#nr_matr').val()});
		return false;
	});

	$(document).on('click', '#btnPesqDocto',function(){
		event.preventDefault();
		$('#retornoCa').load('data/recebimento/list_ca_doc.php?search=',{nr_doc:$('#nr_docto').val()});
		return false;
	});

	$('#btnConsMesCons').on('click',function(){
		event.preventDefault();
		$("#retornoDash").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
		$('#retornoDash').load('data/recebimento/rel_consumo.php?search=',{ds_data:$('#mes_cons').find(':selected').val()});
		return false;
	});

	$('#btnConsMesFunc').on('click',function(){
		event.preventDefault();
		$("#retornoDash").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
		$('#retornoDash').load('data/recebimento/rel_consumo_func.php?search=',{ds_mes:$('#ds_data').val(),ds_ano:$('#ds_data').find(':selected').attr("data-ano")});
		return false;
	});
	
});