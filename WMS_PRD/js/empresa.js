$(document).ready(function(){
	$(document).on('click', '#btnPesqDsNomeFunc', function(){
		event.preventDefault();
		$('#btnPesqDsNomeFunc').prop("disabled", true);
		var ds_nome_func 		= $('#ds_nome_func').val();
		$.ajax
		({
			url:"data/empresa/list_funcionario_nome.php",
			method:"POST",
			data:{
				ds_nome_func:ds_nome_func
			},
			success:function(data)
			{
				$('#retornoFunc').html(data);
			}
		});
		$('#btnPesqDsNomeFunc').prop("disabled", false);
		return false;
	});

	$(document).on('click', '#btnPesqNrMatricula', function(){
		event.preventDefault();
		$('#btnPesqNrMatricula').prop("disabled", true);
		var nr_matricula 		= $('#nr_matricula').val();
		$.ajax
		({
			url:"data/empresa/list_funcionario_matricula.php",
			method:"POST",
			data:{
				nr_matricula:nr_matricula
			},
			success:function(data)
			{
				$('#retornoFunc').html(data);
			}
		});
		$('#btnPesqNrMatricula').prop("disabled", false);
		return false;
	});

	$(document).on('click', '#btnInsFunc', function(){
		event.preventDefault();
		$('#retModalFunc').load("data/empresa/modal/m_ins_funcionario.php");
		return false;
	});

	$(document).on('click', '#btnSaveFuncionario', function(){
		event.preventDefault();
		var ds_nome = $('#ds_nome').val();
		$.post("data/empresa/ins_funcionario.php", $("#formInsFuncionario").serialize(), function(data) {

			if(data.result == "0"){

				$.post("data/empresa/ins_log_funcionario.php",
				{
					ds_nome:ds_nome
				},
				function(log){
					
					alert(data.info);

					$("#retornoFunc").html("<br><br><br><img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
					$('#retornoFunc').load('data/empresa/list_funcionario.php');

				});

			}else{

				alert(data.info);

			}
		}, "json");
		return false;
	});

	$(document).on('click', '#btnDelFunc', function(){
		event.preventDefault();

		if(confirm("Tem certeza que deseja excluir o registro?")){
			var id_fun = $(this).val();

			$.post("data/empresa/del_funcionario.php",
			{
				id_fun:id_fun
			},
			function(data){
				alert(data);
				$("#retornoFunc").html("<br><br><br><img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				$('#retornoFunc').load('data/empresa/list_funcionario.php');
			});

			return false;

		}

	});
});