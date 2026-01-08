$(document).ready(function(){

	$(document).on('click', '#btnNovoComp', function(){
		event.preventDefault();
		$.ajax
		({
			url:"data/produto/modal/m_ins_comp.php",
			method:"POST",
			success:function(data)
			{
				$('#retModalComp').html(data);
			}
		});
		return false;
	});

	$(document).on("click", "#btnConsFornSeriais", function () {
    event.preventDefault();
    var nmForn = $("#nmFornecedor").val();

    $.ajax({
      url: "data/recebimento/list_recebimento_forn.php",
      method: "POST",
      data: {
        nmForn: nmForn,
      },
      success: function (data) {
        $("#retornoEnc").html(data);
      },
    });
    return false;
  });

	$(document).on('click', '#btnFormNovoComp', function(){

		$.post("data/produto/ins_comp.php", $("#formNovoComp").serialize(), function(data) {
			alert(data);
		});

	});

	$(document).on('click','#btnImpComp',function(e){
		event.preventDefault();
		$('#retornoComp').load('importa_componente.php');
	});

	$(document).on('change', '#cod_prod_comp',function(){
		var cod_prod =  $(this).val();

		if(cod_prod.length != 8){

			alert("Código inválido!");

		}else{

			$.getJSON('data/produto/consulta_produto.php?search=',{cod_prod: $(this).val(), ajax: 'true'}, function(j){
				
				if(j.info == '0'){

					$('#nm_prod_comp').val(j.nm_produto);

				}else{

					$('#nm_prod_comp').val(j.alerta);

				}

			});
		}
		return false;
	});

	$(document).on('submit', '#PedComp', function(e){
		event.preventDefault();

		if($('#cod_prod_comp').val().length != 8){

			alert("Preencha corretamente o código do produto.");

		}else{

			$.ajax
			({
				url: "ins_componente.php",
				type: "POST",
				data: new FormData(this),
				contentType: false,
				processData:false,
				beforeSend:function(j){
					$("#retComp").html("<img src='css/loading9.gif'>");
				},
				success: function(data)
				{
					$("#retComp").html(data);
				}
			});

		}
		return false;
	});

	$(document).on('click', '#btnPesqCodigoComp', function(e){
		event.preventDefault();

		if($('#codigoComp').val().length != 8){

			alert("Preencha corretamente o código do produto.");

		}else{

			$.ajax
			({
				url:"data/produto/list_prd_comp.php",
				method:"POST",
				data:{cod_prd:$('#codigoComp').val()},
				beforeSend:function(e){
					$("#retornoComp").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				},
				success:function(data)
				{
					$('#retornoComp').html(data);
				}
			});

		}
		return false;
	});

	$(document).on('click', '#btnPesqNserie', function(e){
		event.preventDefault();

		if($('#nserie').val().length != 8){

			alert("Preencha corretamente o número de série do produto.");

		}else{

			$.ajax
			({
				url:"data/produto/list_ns_comp.php",
				method:"POST",
				data:{ns_prd:$('#nserie').val()},
				beforeSend:function(e){
					$("#retornoComp").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				},
				success:function(data)
				{
					$('#retornoComp').html(data);
				}
			});

		}
		return false;
	});

	$(document).on('click', '#btnPesqNserieComp', function(e){
		event.preventDefault();

		if($('#nserieComp').val().length != 8){

			alert("Preencha corretamente o número de série do produto.");

		}else{

			$.ajax
			({
				url:"data/produto/list_nscomp_comp.php",
				method:"POST",
				data:{ns_comp:$('#nserieComp').val()},
				beforeSend:function(e){
					$("#retornoComp").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				},
				success:function(data)
				{
					$('#retornoComp').html(data);
				}
			});

		}
		return false;
	});

});