$(document).ready(function(){

	$('#btnListUserExt').on('click', function(){
		$('#tabCadUserExt').load("data/empresa/list_usuario_ext.php");
	});

	$('#btnNewUserInd').on('click', function(){
		$('#modalSucess').load("data/empresa/modal/m_ins_usuario_ind.php");
	});

	$('#btnNewUserExt').on('click', function(){
		$('#retorno').load("data/empresa/modal/m_ins_usuario_ext.php");
	});

	$('#btnCadUsuarioExt').on('click',function(){
		event.preventDefault();
		$.post("data/empresa/ins_user_ext.php", $("#formCadUsuarioExt").serialize(), function(data) {
			alert(data);
			$('#retorno').load('data/empresa/list_usuario_ext.php');
		});
	});

	$(document).on('click','#btnCadUsuarioInd',function(){
		event.preventDefault();		
		$.post("data/empresa/ins_user_ind.php", $("#formCadUsuarioInd").serialize(), function(data) {
			alert(data);
			$('#retorno').load('data/empresa/list_usuario_ext.php');
		});
	});

});