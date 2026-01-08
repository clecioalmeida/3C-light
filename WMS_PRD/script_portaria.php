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
  $(document).ready(function(){

    var nivel = "<?php echo $fl_nivel;?>";

    $('#regPortaria').click(function(e){
      event.preventDefault();
      if(nivel <= '2'){
        $('#regPortaria').attr("disable");
        alert("Você não tem acesso a esse menu.");
      }else{
        $('#conteudo').load('portaria_new.php');
      }
    });

    $(document).on('click', '#btnPesqPrt', function(){
      event.preventDefault();
      $('#info_produtos').load('data/portaria/list_portaria.php');
      return false;
    });

    $(document).on('click', '#insRegPtr', function(){
      event.preventDefault();
      $('#retornoReg').load('data/portaria/modal/m_ins_reg.php');
      return false;

    });

    $(document).on('click', '#btnSaveRegPrt', function(){
      event.preventDefault();
      var ds_placa = $('#ds_placa').val();
      var ds_veiculo = $('#ds_veiculo').val();
      var ds_empresa = $('#ds_empresa').val();
      var ds_nome = $('#ds_nome').val();
      var ds_dpto = $('#ds_dpto').val();
      var ds_contato = $('#ds_contato').val();
      var ds_motivo = $('#ds_motivo').val();
      var dt_saida = $('#dt_saida').val();
      var hr_saida = $('#hr_saida').val();
      var ds_galpao = $('#ds_galpao').val();
      var ds_doca = $('#ds_doca').val();
      var ds_obs = $('#ds_obs').val();
      $.ajax
      ({
        url:"data/portaria/ins_reg.php",
        method:"POST",
        dataType:'json',
        data:
        {
          ds_placa:ds_placa,
          ds_veiculo:ds_veiculo,
          ds_empresa:ds_empresa,
          ds_nome:ds_nome,
          ds_dpto:ds_dpto,
          ds_contato:ds_contato,
          ds_motivo:ds_motivo,
          dt_saida:dt_saida,
          hr_saida:hr_saida,
          ds_galpao:ds_galpao,
          ds_doca:ds_doca,
          ds_obs:ds_obs
        },
        success:function(j)
        {
          for (var i = 0; i < j.length; i++) {
            if(j[i].info == "0"){

              alert("Registro incluído com sucesso!");
              $('#info_produtos').load('data/portaria/list_portaria.php');

            }else if(j[i].info == "1"){

              alert("Erro no registro!");

            }else if(j[i].info == "2"){

              alert("A placa informada já deu entrada e não tem saída registrada.");

            }
          }
        }
      });
      return false;
    });

    $(document).on('change', '#ds_galpao', function(){
      if( $(this).val() ) {
        $('#ds_doca').hide();
        $.getJSON('data/portaria/consulta_doca.php?search=',{id: $(this).val(),ajax: 'true'}, function(j){
          var options = '<option value="">Escolha a doca</option>'; 
          for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].id + '">' + + j[i].ds_doca +" - "+ j[i].fl_tipo + '</option>';
          }   
          $('#ds_doca').html(options).show();
        });
      } else {
        $('#ds_doca').html('<option value="">Escolha a doca</option>');
      }
    });

    $(document).on('click', '#btnLibEntPrt', function(){
      event.preventDefault();
      var id = $(this).val();
      var st = $('.status').attr('data-id');
      $.ajax
      ({
        url:"data/portaria/libera_entrada.php",
        method:"POST",
        dataType:'json',
        data:
        {
          id:id
        },
        success:function(j)
        {
         for (var i = 0; i < j.length; i++) {
          if(j[i].info == "1"){
            alert("Veículo com entrada liberada!");
            $('#info_produtos').load('data/portaria/list_portaria.php');
          }else if(j[i].info == "0"){
            alert("Não foi encontrado veículo aguardando entrada!");          
          }else{
            alert("Ocorreu um erro, favor entrar em contato com o suporte!");
          }
        }
      }
    });
      return false;
    });

    $(document).on('click', '#btnSaveSaida', function(){
      event.preventDefault();
      if(confirm("Tem certeza que deseja a saída?")){
        var id = $(this).val();
        var nr_minuta = $('#nr_minuta').val();
        $.ajax
        ({
          url:"data/portaria/registra_saida.php",
          method:"POST",
          dataType:'json',
          data:
          {
            id:id,
            nr_minuta:nr_minuta
          },
          success:function(j)
          {
           for (var i = 0; i < j.length; i++) {
            if(j[i].info == "1"){
              alert("Veículo com saída liberada!");
            }else if(j[i].info == "0"){
              alert("Ainda não foi liberada a entrada!");          
            }else{
              alert("Ocorreu um erro, favor entrar em contato com o suporte!");
            }
          }
        }
      });
      }
      return false;
    });

    $(document).on('click', '#btnLibSaidaPrt', function(){
      event.preventDefault();
      var id = $(this).val();
      var st = $('.status').attr('data-id');
      $.ajax
      ({
        url:"data/portaria/modal/m_lib_saida.php",
        method:"POST",
        data:
        {
          id:id
        },
        success:function(j)
        {
         $('#retornoDoca').html(j);
       }
     });
      return false;
    });

  });

$(document).ready(function(){
  $(document).on('click', '#consDoca', function(){
    event.preventDefault();
    $('#retornoDoca').load('data/portaria/modal/m_cons_doca.php');
    return false;
  });

  $(document).on('change', '#codGalpao', function(){
    event.preventDefault();
    var ds_local = $('#codGalpao').val();
    $.ajax
    ({
      url:"data/portaria/cons_status_doca.php",
      method:"POST",
      dataType:'json',
      data:
      {
        ds_local:ds_local
      },
      success:function(j)
      {
        for(var i=0;i < j.length;i++){
          if(j[i].fl_status == 'L'){

            var status = "OCUPADO";

          }else{

            var status = "LIVRE";
          }
          $('#retorno_status').append('<tr class="status" data-status="'+ j[i].fl_status +'" data-id="'+ j[i].id +'">\
            <td>' + j[i].ds_apelido +" - "+ j[i].nome + '</td>\
            <td>' + j[i].ds_doca + '</td>\
            <td>' + status + '</td>\
            </tr>\
            ');

          var status_ = new Array();
          $('.status').each( function( i,v ){
            var $this = $( this )
            status_[i] = $this.attr('data-status');
            if(status_[i] == "L"){
              $this.addClass('ocupado');
            }else{
              $this.removeClass('ocupado').addClass('livre');
            }
          });
        }
      }
    });
    return false;
  });
});
$(document).ready(function(){

  $(document).on('click', '#btnRegChg', function(){
    event.preventDefault();
    if(confirm("Confirma a chegada do agendamento?")){
      var cod_rec = $(this).val();
      $.ajax
      ({
        url:"data/portaria/upd_reg_ag.php",
        method:"POST",
        data:
        {
          cod_rec:cod_rec
        },
        success:function(j)
        {
          alert(j);
          $('#retornoAg').load('data/portaria/list_recebimento_pt.php')
        }
      });
    }
    return false;
  });

  $(document).on('click', '#btnRegEnt', function(){
    event.preventDefault();
    if(confirm("Autoriza a entrada do agendamento?")){
      var cod_rec = $(this).val();
      $.ajax
      ({
        url:"data/portaria/upd_reg_aut.php",
        method:"POST",
        data:
        {
          cod_rec:cod_rec
        },
        success:function(j)
        {
          alert(j);
          $('#retornoAg').load('data/portaria/list_recebimento_pt.php')
        }
      });
    }
    return false;
  });
});
</script>