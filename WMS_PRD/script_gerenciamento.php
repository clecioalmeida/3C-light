<?php

	if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

		header("Location:index.php");
		exit;

	}else{
		
		$id=$_SESSION["id"];
		$fl_nivel=$_SESSION["fl_nivel"];
	}
?>
<script type="text/javascript">
/*- Chamadas de menu -*/
$(document).ready(function(){
	var nivel = "<?php echo $fl_nivel;?>";
/*--- DASHBOARD ---*/

/*--- Gerenciamento ---*/

	$('#cadIns').click(function(e){
		event.preventDefault();
		if(nivel <= '3'){
			$('#cadIns').attr("disable");
			alert("Você não tem acesso a esse menu.");
		}else{
			$('#conteudo').load('insumos.php');
		}
	});
/*--- Insumos - Pesquisa ---*/
	$(document).on('click', '#btnPesqCodIns', function(){
		event.preventDefault();
		var codInsCod = $('#codInsCli').val();
		var codInsDesc = $('#insumos').val();
		if(codInsCod != ""){

			$.ajax
			({
				url:"data/produto/insumos_list.php",
				method:"POST",
				data:{
					codInsCod:codInsCod,
					codInsDesc:codInsDesc
				},
				success:function(data)
				{
				    $('#info_Insumos').html(data);
				}
			});

		}else{

			alert("O campo pesquisa não pode estar vazio.");

		}
		return false;
	});

	$(document).on('click', '#btnPesqNomeIns', function(){
		event.preventDefault();
		var codInsDesc = $('#insumos').val();
		var codInsCod = $('#codInsCli').val();
		if(codInsDesc != ""){

			$.ajax
			({
				url:"data/produto/insumos_list.php",
				method:"POST",
				data:{
					codInsDesc:codInsDesc,
					codInsCod:codInsCod
				},
				success:function(data)
				{
				    $('#info_Insumos').html(data);
				}
			});

		}else{

			alert("O campo pesquisa não pode estar vazio.");

		}
		return false;
	});
});

/*--- Insumos - Insert ---*/
$(document).ready(function(){
	$(document).on('click', '#btnNovoInsumo', function(){
		$('#retorno').load("data/produto/modal/m_ins_insumo.php");
	});

	$(document).on('click', '#btnFormNovoInsumo', function(){
		$('#formNovoProduto').ajaxForm({
			target:'#info_Insumos',
			url:'data/produto/ins_insumos.php',
			beforeSend:function(e){
				$("#info_Insumos").html("<img src='css/loading9.gif'>");
			}
		});
	});

	$(document).on('click', '#btnUpdInsumo', function(){
		var upd_produto = $(this).val();
		$.ajax({
			url:"data/produto/modal/m_upd_insumo.php",
			method:"POST",
			data:{upd_produto:upd_produto},
			success:function(data)
			{
				$('#retorno').html(data);
			}
		});
	});
});
</script>