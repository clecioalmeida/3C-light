$(document).ready(function () {

    // Links

    $('#ins_ag').on('click', function(){
        event.preventDefault();
        $('#load_pages').load("assets/modal/ins_ag.html");

    });

    $(document).on('click', '#edit_ag', function(){
        event.preventDefault();
        var cod_rec = $(this).val();
        sessionStorage.setItem('cod_rec', cod_rec);
        $('#load_pages').load("assets/modal/edit_ag.html");

    });

    $(document).on('click', '#pesq_for', function(){
        event.preventDefault();
        var nm_for = $(this).val();
        sessionStorage.setItem('nm_for', nm_for);
        $('#ret_md').load("assets/modal/pesq_forn.html");

    });


    $(document).on('click','#btn_xml', function(){
        event.preventDefault();
        var cod_rec = $(this).val();
        sessionStorage.setItem('cod_rec', cod_rec);
        $('#ret_md').load("assets/modal/ins_xml.html");

    });

    $(document).on('click','#pesq_veic', function(){
        event.preventDefault();
        var tp_veic = $('#tp_veic').find(':selected').val();
        sessionStorage.setItem('tp_veic', tp_veic);
        $('#ret_md_vc').load("assets/modal/veic_disp.html");

    });

    $(document).on('click','#btn_danfe', function(){
        event.preventDefault();
        var cod_rec = $(this).val();
        sessionStorage.setItem('cod_rec', cod_rec);
        $('#ret_md').load("assets/modal/ins_pdf.html");

    });

    /*$(document).on('click','#btn_abrir_danfe',function(){
        event.preventDefault();
        var mdfe_chave = $(this).val();
        var caminho = "assets/pdf/" + mdfe_chave + "-mdfe.pdf";

        $.ajax
        ({

            url:caminho,
            type:'HEAD'

        }).done(function(){

            window.open(caminho, "_blank");

        }).fail(function(jqXHR, textStatus, errorThrown) {

            alert("Arquivo não encontrado.");

        }); 
        return false;
    });*/

    $(document).on('click','#btn_rec', function(){
        event.preventDefault();
        var cod_rec = $(this).val();
        sessionStorage.setItem('cod_rec', cod_rec);
        $('#ret_md').load("assets/modal/rec_abrir_ag.html");

    });

    $('#btn_abrir_danfe').on('click', function(){
        event.preventDefault();
        $('#load_pages').load('list_file_ag.php?search=',{nf_rec: $(this).attr("data-id")});
      });

    $(document).on("click", "#btnNovaJanela", function () {
        event.preventDefault();

        $("#load_pages").load("assets/modal/ins_admin_janela.html");
    });

    $(document).on('click','#fim_ag', function(){
        event.preventDefault();
        var cod_rec = $(this).val();
        
        $.post("assets/php/fim_ag.php", { cod_rec: cod_rec }, function (j) {
                        
            alert(j);

        });

    });

    $(document).on('click', '#btnBlqJan', function(){
        if(confirm("Confirma o fechamento da janela?")){
            var ins_jn = $(this).val();
            $.ajax
            ({
                url:"assets/php/edit_reab_janela.php",
                method:"POST",
                data:{ins_jn:ins_jn},
                success:function(data)
                {
                    alert(data);
                    $("#load_pages").load("admin_janelas.html");
                }
            });
        }
    });

    $(document).on('click', '#btnReabJan', function(){
        if(confirm("Confirma a abertura da janela?")){
            var ins_jn = $(this).val();
            $.ajax
            ({
                url:"assets/php/edit_reab_janela_abre.php",
                method:"POST",
                data:{ins_jn:ins_jn},
                success:function(data)
                {
                    alert(data);
                    $("#load_pages").load("admin_janelas.html");
                }
            });
        }
    });

    $(document).on("click", "#load_list_ag_fin",function () {
      event.preventDefault();
  
      $("#load_pages").load("realizados.html");
    });

    $("#load_list_ag_adm_jan").on("click", function () {
      event.preventDefault();

      $('#load_pages').load('admin_janelas.html');

    });

    $(document).on("click", "#btnFechaNovaJanela", function () {
        event.preventDefault();

        $("#load_pages").load("admin_janelas.html");
    });
  
    /*$('#pesq_dt').on('click',function(){
        event.preventDefault();

        if($('#dt_ini_ag').val() == '' || $('#dt_fim_ag').val() == ''){

            alert("Campo data inicial e data final são obrigatórios.");

        }else{

            var dt_ini_ag = $('#dt_ini_ag').val();
            var dt_fim_ag = $('#dt_fim_ag').val();

            sessionStorage.setItem('dt_ini_ag', dt_ini_ag);
            sessionStorage.setItem('dt_fim_ag', dt_fim_ag);

			$('#load_pages').load('list_ag_dt.html');

        }
    });*/

    $(document).on('click','#btn_pdf', function(){
        event.preventDefault();
        var cod_rec = $(this).val();
        console.log(cod_rec);
        sessionStorage.setItem('cod_rec', cod_rec);
        $('#ret_md').load("assets/modal/list_file.html");

    });

});