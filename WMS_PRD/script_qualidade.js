$(document).ready(function(){

	$(document).on('click', '#btnOCorFin', function(){
	   $('#infoOcorrencia').load('data/qualidade/ocor_finalizada.php');
	});

	$(document).on('click', '#btnOCorNew', function(){
	   $('#retornoOcorrencia').load('data/qualidade/modal/m_nova_ocorrencia.php');
	});
	$(document).on('click', '#btnUpdOcor', function(){
		var id_ocor = $(this).val();
		$.ajax({
			url:"data/qualidade/modal/mdl_alterar_ocorrencia.php",
			method:"POST",
			data:{id_ocor:id_ocor},
			success:function(data)
			{
				$('#retornoOcorrencia').html(data);
			}
		});
	});

	$(document).on('click', '#btnFinOcor', function(){
		var id_ocor = $(this).val();
		$.ajax({
			url:"data/qualidade/modal/mdl_fin_ocorrencia.php",
			method:"POST",
			data:{id_ocor:id_ocor},
			success:function(data)
			{
				$('#retornoOcorrencia').html(data);
			}
		});
	});

	$(document).on('click','#btnNewOcor',function(){
		$.post("data/qualidade/ins_ocorrencia.php", $("#formNovaOcor").serialize(), function(data) {
			alert(data);
            $('#infoOcorrencia').load('data/qualidade/list_ocor_aberta.php');
		});
	});
});

	$(document).on('click', '#btnNewImage', function(){
		var id_ocor = $('#codOcor').val();
		$.ajax({
			url:"data/qualidade/modal/m_imagedata.php",
			method:"POST",
			data:{id_ocor:id_ocor},
			success:function(data)
			{
				$('#retornoModalOcor').html(data);
			}
		});
		return false;
	});

	$(document).on('click', '#btnInsImgOcor', function(){
		var id_ocor = $('#id_ocor').val();
		var image1 = $('#image1').val();
		var image2 = $('#image2').val();
		var image3 = $('#image3').val();
		$.ajax({
			url:"data/qualidade/ins_image.php",
			method:"POST",
			data:{id_ocor:id_ocor, image1:image1, image2:image2, image3:image3},
			success:function(data)
			{
				$('#image_data').html(data);
			}
		});
		return false;
	});