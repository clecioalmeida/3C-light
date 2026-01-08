/* 	IMPORTACAO DE PRODUTOS VIA EXCEL */
$(document).ready(function(){
	$(document).on('click','#recImpProd',function(e){
		event.preventDefault();
		//var fl_nivel = $(this).attr("data-nivel");

		//if(fl_nivel >= '5'){
			$('#conteudo').load('importa_produto.php');

		//}else{

		//	alert("Você não tem permissão para acessar este módulo.");
		//}	
	});

    $(document).on('click','#insDpto',function(e){
        event.preventDefault();
        //var fl_nivel = $(this).attr("data-nivel");

        //if(fl_nivel >= '5'){
            $('#conteudo').load('importa_depto.php');

        //}else{

        //  alert("Você não tem permissão para acessar este módulo.");
        //} 
    });
    
    $(document).on('click','#insFunc',function(e){
        event.preventDefault();
        //var fl_nivel = $(this).attr("data-nivel");

        //if(fl_nivel >= '5'){
            $('#conteudo').load('importa_func.php');

        //}else{

        //  alert("Você não tem permissão para acessar este módulo.");
        //} 
    });
    
    $(document).on('click','#insSld',function(e){
        event.preventDefault();
        //var fl_nivel = $(this).attr("data-nivel");

        //if(fl_nivel >= '5'){
            $('#conteudo').load('importa_saldo.php');

        //}else{

        //  alert("Você não tem permissão para acessar este módulo.");
        //} 
    });

    $(document).on('click','#recImpFor',function(e){
        event.preventDefault();
        var fl_nivel = $(this).attr("data-nivel");

        if(fl_nivel >= '5'){
            $('#conteudo').load('importa_fornecedor.php');

        }else{

            alert("Você não tem permissão para acessar este módulo.");
        }   
    });

    $(document).on('click','#recImpGrp',function(e){
        event.preventDefault();
        var fl_nivel = $(this).attr("data-nivel");

        if(fl_nivel >= '5'){
            $('#conteudo').load('importa_grupo.php');

        }else{

            alert("Você não tem permissão para acessar este módulo.");
        }   
    });

    $(document).on('submit', '#testeXml', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "ins_produto.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $('.aguarde').show();
            },
            success: function(data)
            {
                $('.aguarde').hide();
                $("#retImportRepom").html(data);
            }
        });
        return false;
    });

    $(document).on('submit', '#formImpFor', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "ins_fornecedor.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $('.aguarde').show();
            },
            success: function(data)
            {
                $('.aguarde').hide();
                $("#retImportForn").html(data);
            }
        });
        return false;
    });

    $(document).on('submit', '#formImpGrp', function(e){
        event.preventDefault();
        $.ajax
        ({
            //url: "teste_log_funcionario.php",
            url: "ins_grupo.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $('.aguarde').show();
            },
            success: function(data)
            {
                $('.aguarde').hide();
                $("#retImportGrp").html(data);
            }
        });
        return false;
    });

    $('#btnClearChave').on('click',function(){
        $('#chave_nfe').val('');
    });
});

$(document).ready(function(){
    $(document).on('click','#cadEnd',function(e){
        event.preventDefault();
        var fl_nivel = $(this).attr("data-nivel");

        if(fl_nivel == '5'){
            $('#conteudo').load('endereco.php');

        }else{

            alert("Você não tem permissão para acessar este módulo.");
            console.log(fl_nivel);
        }   
    });

    $(document).on('click', '#btnSaveGal', function(){
        event.preventDefault();
        if(confirm("Confirma a criação do galpão?")){
            $('#btnSaveGal').prop("disabled", true);
            var nm_gal    = $('#nm_gal').val();
            var cid_gal   = $('#cid_gal').val();
            var apel_gal  = $('#apel_gal').val();
            $.ajax
            ({
                url:"ins_galpao.php",
                method:"POST",
                data:{
                    nm_gal:nm_gal,
                    cid_gal:cid_gal,
                    apel_gal:apel_gal
                },
                success:function(data)
                {
                    alert(data);
                }
            });
            $('#btnSaveGal').prop("disabled", false);
        }
        return false;
    });

    $(document).on('click', '#btnInsEnd', function(){
        event.preventDefault();
        if(confirm("Confirma a criação dos endereços?")){
            $('#btnInsEnd').prop("disabled", true);
            var cod_galpao      = $('#cod_galpao').val();
            var rua_ini         = $('#rua_ini').val();
            var rua_fim         = $('#rua_fim').val();
            var col_ini         = $('#col_ini').val();
            var col_fin         = $('#col_fin').val();
            var ds_pre          = $('#ds_pre').val();
            var ds_pos          = $('#ds_pos').val();
            var nr_nivel        = $('#nr_nivel').val();
            var ds_posni         = $('#ds_posni').val();
            var ds_posnf         = $('#ds_posnf').val();
            var ds_pren         = $('#ds_pren').val();
            $.ajax
            ({
                url:"ins_endereco.php",
                method:"POST",
                data:{
                    cod_galpao:cod_galpao,
                    rua_ini:rua_ini,
                    rua_fim:rua_fim,
                    col_ini:col_ini,
                    col_fin:col_fin,
                    ds_pre:ds_pre,
                    ds_pos:ds_pos,
                    nr_nivel:nr_nivel,
                    ds_posni:ds_posni,
                    ds_posnf:ds_posnf,
                    ds_pren:ds_pren
                },
                beforeSend:function(e){
                    $("#retornoEnd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
                },
                success:function(data)
                {
                    $('#retornoEnd').html(data);
                }
            });
            $('#btnInsEnd').prop("disabled", false);
        }
        return false;
    });
});

$(document).ready(function(){
    $(document).on('click','#cadJan',function(e){
        event.preventDefault();
        var fl_nivel = $(this).attr("data-nivel");

        if(fl_nivel == '5'){
            $('#conteudo').load('endereco.php');

        }else{

            alert("Você não tem permissão para acessar este módulo.");
            console.log(fl_nivel);
        }   
    });

    $(document).on('click','#btnGeraEtqRec',function(){
        event.preventDefault();
        if( $('.checkEtq:checked').length == 0 ){
            alert('Selecione pelo menos uma nota fiscal!');
        }else{
            if(confirm("Confirma a criação das etiquetas?")){
                $('#btnGeraEtqRec').prop("disabled", true);
                var cod_nf = [];

                $('.checkEtq:checked').each(function(){
                    cod_nf.push($(this).val());

                });

                $.ajax
                ({
                    url:"data/recebimento/ins_etq_rec.php",
                    method:"POST",
                    data:{
                        cod_nf:cod_nf
                    },
                    beforeSend:function(e){
                        $("#retornoNfe").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
                    },
                    success:function(data){

                        $('#retornoNfe').html(data);
                    }
                });
                $('#btnGeraEtqRec').prop("disabled", false);
                return false;
            }
        }
    });

    $(document).on('click','#btnGeraEtqInv',function(){
        event.preventDefault();
        if(confirm("Confirma a criação das etiquetas?")){
            $('#btnGeraEtqInv').prop("disabled", true);
            var id_tar =$(this).val();

            $.ajax
            ({
                url:"data/inventario/ins_etq_inv_prd.php",
                method:"POST",
                data:{
                    id_tar:id_tar
                },
                success:function(data){

                    alert("Etiquetas criadas com sucesso!");
                }
            });
            $('#btnGeraEtqInv').prop("disabled", false);
            return false;
        }
    });
});