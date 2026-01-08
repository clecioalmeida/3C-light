$(document).ready(function(){

		$('#btnPesquisaData').on('click', function(){
			$('#formRepEstoque').ajaxForm({
				target:'#wid-id-0',
				url:'data/movimento/relatorio/estoque.php',
				beforeSend:function(e){
					$("#wid-id-0").html("<img src='css/loading9.gif'>");
				}
			});
		});

		$('#btnPesquisaSaldo').on('click', function(){
			$('#formSalEstoque').ajaxForm({
				target:'#wid-id-0',
				url:'data/movimento/relatorio/saldo.php',
				beforeSend:function(e){
					$("#wid-id-0").html("<img src='css/loading9.gif'>");
				}
			});
		});

    $('#btnPesquisaGiro').on('click', function(){

      if($('#CodProduto').val() != '' && $('#CodProdCliente').val() != ''){

        alert("Digite somente o código WMS ou o código SAP.");

      }else if($('#CodProduto').val() == '' && $('#CodProdCliente').val() == ''){

        alert("Digite uma das informações solicitadas.");

      }else{

        $('#formGiroEstoque').ajaxForm({
          target:'#wid-id-0',
          url:'data/movimento/relatorio/giro.php',
          beforeSend:function(e){
            $("#wid-id-0").html("<img src='css/loading9.gif'>");
          }
        });

      }

    });

		$('#SalDtlTorGenExcel').on('click', function(){
			event.preventDefault();
			var today = new Date()
      $("#TbConsSalTorreDtl").table2excel({
	    	exclude: ".noExl",
				name: "Consulta estoque de torres",
	    	filename: "Consulta estoque de torres - " + today
  		});
    });  

    $('#SalSintTorGenExcel').on('click', function(){
			event.preventDefault();
			var today = new Date();
      $("#TbConsSalTorreSint").table2excel({
	    	exclude: ".noExl",
			  name: "Consulta estoque de torres - Sintético",
	    	filename: "Consulta estoque de torres - Sintético - " + today
  		});
    }); 

    $('#RepEstoqGenExcel').on('click', function(){
    	event.preventDefault();
    	var today = new Date();
      $("#reportSalEstoque").table2excel({
     		//exclude: ".noExl",
      	name: "Consulta saldo de estoque - Analítico",
    		filename: "Consulta saldo de estoque - Analítico - " + today
      });
    });

    $('#btnTarExcel').on('click', function(){
      event.preventDefault();
      var today = new Date();
      $("#dadosTar").table2excel({
        //exclude: ".noExl",
        name: "Inventário - Tarefas abertas",
        filename: "Inventário - Tarefas abertas - " + today
      });
    });

    $('#btnDtlPedidoMes').on('click', function(){
     	event.preventDefault();
      var dtl_ped = $(this).val();
      $.ajax({
        url:"data/movimento/modal/m_dtl_pedido.php",
        method:"POST",
        data:{dtl_ped:dtl_ped},
        success:function(data)
        {
          $('#consulta').html(data);
        }
      });
    });

    $('#btnDtlRecebidoMes').on('click', function(){
     	event.preventDefault();
      var dtl_rec = $(this).val();
      $.ajax({
        url:"data/recebimento/modal/m_dtl_recebimento.php",
        method:"POST",
        data:{dtl_rec:dtl_rec},
        success:function(data)
        {
          $('#consulta').html(data);
        }
      });
      return false;
    });

    $('#btnListPedidos').on('click', function(){
      event.preventDefault();
      var cod_produto = $(this).val();
      $.ajax({
        url:"data/dashboard/modal/m_list_pedido.php",
        method:"POST",
        data:{cod_produto:cod_produto},
        success:function(data)
        {
          $('#consultaRetorno').html(data);
        }
      });
      return false;
    });
});
/*- Consulta estoque por produto -*/
$(document).ready(function(){
  $(document).on('change', '#conGalpao',function(){
    if( $(this).val() ) {
      $('#conRua').hide();
      $.getJSON('data/movimento/consulta_rua.php?search=',{id_galpao: $(this).val(), ajax: 'true'}, function(j){
        var options = '<option value="">Escolha a rua</option>'; 
        for (var i = 0; i < j.length; i++) {
          options += '<option value="' + j[i].rua + '">'  + j[i].rua + '</option>';
        }   
        $('#conRua').html(options).show();
      });
    } else {
      $('#conRua').html('<option value="">Escolha a rua</option>');
    }
    return false;
  });

  $(document).on('change','#conRua', function(){
    if( $(this).val() ) {
      $('#conColuna').hide();
        $.getJSON('data/movimento/consulta_coluna.php?search=',{id_rua: $(this).val(), id_galpao: $('#conGalpao').val(), ajax: 'true'}, function(j){
          var options = '<option value="">Escolha a coluna</option>'; 
          for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
          }   
          $('#conColuna').html(options).show();
        });
    } else {
      $('#conColuna').html('<option value="">Escolha a coluna</option>');
    }
    return false;
  });

  $(document).on('change','#conColuna', function(){
    if( $(this).val() ) {
      $('#conAltura').hide();
        $.getJSON('data/movimento/consulta_altura.php?search=',{id_coluna: $(this).val(), ajax: 'true'}, function(j){
          var options = '<option value="">Escolha a altura</option>'; 
          for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].altura + '">'  + j[i].altura + '</option>';
          }   
          $('#conAltura').html(options).show();
        });
    } else {
      $('#conAltura').html('<option value="">Escolha a altura</option>');
    }
    return false;
  });
});

$(document).ready(function(){
  $(document).on('click','#btnPesquisaProdEstoq', function(){
    event.preventDefault();
    var conGalpao = $('#conGalpao').val();
    var conRua = $('#conRua').val();
    var conColuna = $('#conColuna').val();
    var conAltura = $('#conAltura').val();
    if( conGalpao != '' && conRua != '' && conColuna != '' && conAltura != ''){
      $.ajax
      ({
        url:"data/movimento/cons_estoque_prod_sql.php",
        method:"POST",
        data:{conGalpao:conGalpao, conRua:conRua, conColuna:conColuna, conAltura:conAltura},
        success:function(data)
          {
            $('#retornoEstoque').html(data);
          }
      });
    } else {
      alert('Selecione todos os campos');
    }
    return false;
  });

  $('#btnPesquisaProdEstoqNc').on('click', function(){
    event.preventDefault();
    var conGalpao = $('#conGalpao').val();
    var conRua = $('#conRua').val();
    var conColuna = $('#conColuna').val();
    var conAltura = $('#conAltura').val();
    $.ajax({
      url:"data/movimento/cons_estoque_prodnc_sql.php",
      method:"POST",
      data:{conGalpao:conGalpao, conRua:conRua, conColuna:conColuna, conAltura:conAltura},
      success:function(data)
        {
          $('#retornoEstoque').html(data);
        }
    });
    return false;
  });
});


$(document).ready(function(){
   $('#id_armazem').on('change', function(){
    event.preventDefault();
    var id_armazem = $('#id_armazem').val();
    console.log(id_armazem);
    if(id_armazem == 11){

      $.ajax
      ({
        url:"data/dashboard/dashboard_ocupa_11.php",
        method:"POST",
        data:{id_armazem:id_armazem},
        success:function(j)
          {

            $('#retornoTable').html(j);

          }
      });

    }else if(id_armazem == 13){

      $.ajax
      ({
        url:"data/dashboard/dashboard_ocupa_13.php",
        method:"POST",
        data:{id_armazem:id_armazem},
        success:function(j)
          {

            $('#retornoTable').html(j);

          }
      });

    }
  });
});