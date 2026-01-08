$(document).ready(function(){

	$('#linkRec').click(function(e){
		event.preventDefault();
		$('#conteudo').load('../ca.php');
	});
	
});