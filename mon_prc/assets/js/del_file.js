$(document).ready(function () {
	$(document).on('click', '#btnDelFile', function(){
		if(confirm("Confirma a exclusão do arquivo?")){
			var file = $(this).val();
			$.ajax
			({
				url:"assets/php/del_file.php",
				method:"POST",
				data:{file:file},
				success:function(data)
				{
					alert("Arquivos excluídos.");
				}
			});
		}
	});
});