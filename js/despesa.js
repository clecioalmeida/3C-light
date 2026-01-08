$(document).ready(function () {
	$('#mInsDespesa').modal('show');
	$('.valor').maskMoney();

	$('#r_docto').on('change',function(){
		$.getJSON('data/financeiro/consulta_docto_forn.php', 
		{
			nr_docto: $(this).val(),
			id_forn: $('#id_for').val(),
			ajax: 'true'
		}, 
		function(j){
			for (var i = 0; i < j.length; i++) {
				if(j[i].info == '0'){

					alert('Já existe lançamneto para o documento e fornecedor escolhido.');
					$('#r_docto').val("");

				}
				
			}
		});
	});
});