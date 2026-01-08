$(document).ready(function(){

	$(document).on('click','#btnImpMe2w',function(e){
		event.preventDefault();
		$('#retorno_ns').load('importa_sap_me2w.php');
	});
});