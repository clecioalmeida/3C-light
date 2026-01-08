<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:../index.php");
  exit;

}else{

  $id = $_SESSION["id"];
  $cod_cli = $_SESSION["cod_cli"];
}
?>
<div id="main" role="main">
	<div id="content">
    <section id="" class="">
     <div class="row">
      <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       <div class="" id="dados">
        <br><br>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <form method="POST" id="pesquisa_produto" action="">
            <fieldset>
              <div class="row">
                <div class="col-sm-4" style="text-align: left;">
                  <p><h2><strong>IMPORTANTE:&nbsp;&nbsp;&nbsp;</strong><button class="btn btn-primary" id="btnAgendados">Pesquisar</button></h2></p>
                  <p><h3>Se irá utilizar intervalo de endereços, procure criar inventários por Rua. Caso o intervalo não tenha ruas sequênciais, é possível que o WMS não consiga listar todos os produtos.</h3></p>
                </div>
                <div class="col-sm-8" style="text-align: right;">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#novoInventario" id="btnNovo">Novo inventário</button>
                  <button type="button" class="btn btn-success" value="<?php echo $dados_ag['id']; ?>" id="btnCarregaInv">Carregar inventário</button>
                </div>
              </div>
            </fieldset>
          </form>
          <legend></legend>

          <div id="info" class="row">
            <div id="modalInfo">

            </div>
          </div>
          <div class="modal fade" id="novoInventario" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" style="color: white"><bold>Novo inventário</bold></h4>
                </div>
                <div class="modal-body modal-lg">
                  <div class="row">
                    <article class="col-sm-12 col-md-12 col-lg-12">
                      <form class="form-inline" method="post" action="" id="formInv" role="form">
                        <fieldset>
                          <header>
                            <legend>Parâmetros</legend>
                          </header>
                          <div class="col-md-10">
                            <label class="col-md-2">Período</label>
                            <div class="form-group">
                              <select class="form-control" name="ds_tipo" id="ds_tipo">
                                <option value="R">Rotativo</option>
                                <option value="A">Anual</option>
                                <option value="I">Abertura de operação</option>
                                <option value="F">Encerramento de operação</option>
                              </select> 
                            </div>
                          </div>
                        </fieldset>
                        <fieldset>
                          <header>
                            <legend>Data</legend>
                          </header>
                          <div class="col-md-4">
                            <label class="col-md-2">De:</label>
                            <div class="form-group">
                              <input type="date" name="dt_inicio" class="form-control" id="datainicio" placeholder="Início">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label class="col-md-2">Até:</label>
                            <div class="form-group">
                              <input type="date" name="dt_fim" class="form-control" id="dt_fim" placeholder="Fim">
                            </div>
                          </div>
                        </fieldset>
                        <fieldset>
                          <header>
                            <legend>Endereço</legend>
                          </header>
                          <div class="col-md-10 selectContainer">
                            <label class="col-md-2">Armazém</label>
                            <div class="form-group">
                              <select class="form-control" name="progInvGlp" id="progInvGlp">
                                <option value="">Selecione o armazém</option>
                                <?php
                                require_once('data/inventario/bd_class.php');
                                $objDb = new db();
                                $link = $objDb->conecta_mysql();

                                $local="select * from tb_armazem where id_oper = '$cod_cli'";
                                $res_local = mysqli_query($link, $local);
                                while ($dados_local=mysqli_fetch_assoc($res_local)) {?>
                                  <option id="local" value="<?php echo $dados_local['id']; ?>"><?php echo $dados_local['nome']; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </fieldset><br>
                        <fieldset>
                          <div class="col-md-10">
                            <label class="col-md-2">De:</label>
                            <div class="form-group">
                              <select class="form-control" name="id_rua_inicio" id="id_rua_inicio">
                                <option value="">Selecione a rua</option>
                              </select> 
                              <select class="form-control" name="id_coluna_inicio" id="id_coluna_inicio">
                                <option value="">Selecione a coluna</option>
                              </select>  
                              <select class="form-control" name="id_altura_inicio" id="id_altura_inicio">
                                <option value="">Selecione o nível</option>
                              </select> 
                            </div>
                          </div>
                        </fieldset><br>
                        <fieldset>
                          <div class="col-md-10">
                            <label class="col-md-2">Até:</label>
                            <div class="form-group">
                              <select class="form-control" name="id_rua_fim" id="id_rua_fim">
                                <option value="">Selecione a rua</option>
                              </select> 
                              <select class="form-control" name="id_coluna_fim" id="id_coluna_fim">
                                <option value="">Selecione a coluna</option>
                              </select> 
                              <select class="form-control" name="id_altura_fim" id="id_altura_fim">
                                <option value="">Selecione o nível</option>
                              </select> 
                            </div>
                          </div>
                        </fieldset>
                        <fieldset>
                          <header>
                            <legend>Produto</legend>
                          </header>
                          <div class="col-md-10">
                            <div class="form-group">
                              <select class="form-control" name="id_grupo" id="id_grupo">
                                <option value="">Selecione o grupo</option>
                                <?php
                                $grupo="select * from tb_grupo";
                                $res_grupo = mysqli_query($link, $grupo);
                                while ($dados_grupo=mysqli_fetch_assoc($res_grupo)) {?>
                                  <option id="local" value="<?php echo $dados_grupo['cod_grupo']; ?>"><?php echo $dados_grupo['nm_grupo']; ?></option>
                                <?php } ?>
                              </select> 
                            </div>
                            <div class="form-group">
                              <select class="form-control" name="id_sub_grupo" id="id_sub_grupo">
                                <option value="">Selecione o sub-grupo</option>
                              </select> 
                            </div>
                            <div class="form-group">
                              <input type="text" class="form-control" name="id_produto" id="cod_produto" placeholder="Digite o código do produto">
                            </div>
                          </div>
                        </fieldset>
                        <hr>
                        <button type="submit" id="btnNewInventario" class="btn btn-primary">
                          Salvar
                        </button>
                      </form>
                      <div id="retorno"></div>
                    </article>
                  </div>
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){

    $('#btnCarregaInv').on('click',function(){

      $('#info').load("importa_inventario.php");

    });

  });

</script>
<!--script type="text/javascript">

  function tarefas(tarefas)
  {
    var page = "data/inventario/gera_tarefa.php";
    $.ajax
    ({
      type: 'POST',
      dataType: 'html',
      url: page,
      beforeSend: function () 
      {
        $("#info").html("Carregando...");
      },
      data: {id_galpao: id_galpao, nr_inv: nr_inv,id_produto: id_produto,id_rua_inicio: id_rua_inicio,id_rua_fim: id_rua_fim},
      success: function (msg)
      {
        $("#info").html(msg);
      }
    });
  }
  $('#btnGerar').click(function () {
    tarefas($("#id_galpao").val(),$("#nr_inv").val(),$("#id_produto").val(),$("#id_rua_inicio").val(),$("#id_rua_fim").val())
  });

</script-->
<script>
 $(document).ready(function(){
  $('#btnAgendados').on('click',function () {
    event.preventDefault();
    var page = "data/inventario/list_inv_ag.php";
    $("#info").load(page);
  });

  $(document).on('click', '#btnEncerraInv', function(){
    event.preventDefault();
    $('#btnEncerraInv').prop("disabled", true);
    if(confirm("Tem certeza que deseja encerrar esse inventário?")){
      var cod_inv = $(this).val();
      var page = "data/inventario/list_inv_ag.php";
      $.ajax({
        url:"data/inventario/encerra_inventario.php",
        method:"POST",
        dataType:'json',
        data:{cod_inv:cod_inv},
        success:function(j)
        {
          for (var i = 0; i < j.length; i++) {
            if(j[i].info =="0"){

              alert("Inventário encerrado com sucesso.");
              $("#info").load(page);

            }else if(j[i].info =="1"){

              alert("Existem tarefas abertas nesse inventário. Finalize todas as tarefas e encerre novamente.");

            }else{

              alert("Erro na solicitação.");

            }
          }
        }
      });
    }
    $('#btnEncerraInv').prop("disabled", false);
    return false;
  });
});
</script>
<script>
 $(document).ready(function(){
  $(document).on('click', '#btnSaveUpdInv',function(){
    event.preventDefault();
    if(confirm("Confirma a alteração do inventário?")){

      $.post("data/inventario/upd_inv_ag.php", $("#formInvAg").serialize(), function(data) {
        alert(data);
        var page = "data/inventario/list_inv_ag.php";
        $('#edita_tarefa').modal('hide');
        $("#info").load(page);
      });

    }
    return false;
  });
});
</script>
<script type="text/javascript">
  $(function(){
    $('#progInvGlp').change(function(){
      if( $(this).val() ) {
        $('.carregando').show();
        $.getJSON('data/inventario/consulta_rua_inicio.php?search=',{id_galpao: $(this).val(), ajax: 'true'}, function(j){
          var options = '<option value="">Selecione a rua</option>'; 
          for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
          }   
          $('#id_rua_inicio').html(options);
          $('#id_rua_fim').html(options);
          $('.carregando').hide();
        });
      } else {
        $('#id_rua_inicio').html('<option value="">Selecione a rua</option>');
      }
    });

    $('#id_rua_inicio').change(function(){
      if( $(this).val() ) {
        $('.carregando').show();
        $.getJSON('data/inventario/consulta_coluna_inicio.php?search=',{id_rua: $(this).val(), id_galpao: $('#progInvGlp').val(), ajax: 'true'}, function(j){
          var options = '<option value="">Selecione a coluna</option>'; 
          for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
          }   
          $('#id_coluna_inicio').html(options);
          $('#id_coluna_fim').html(options);
          $('.carregando').hide();
        });
      } else {
        $('#id_coluna_inicio').html('<option value="0">Selecione a coluna</option>');
        $('#id_coluna_fim').html('<option value="0">Selecione a coluna</option>');
      }
    });

    $('#id_coluna_inicio').change(function(){
      if( $(this).val() ) {
        $('.carregando').show();
        $.getJSON('data/inventario/consulta_altura_inicio.php?search=',{id_coluna: $('#id_coluna_inicio').val(), id_galpao: $('#progInvGlp').val(), id_rua: $('#id_rua_inicio').val(), ajax: 'true'}, function(j){
          var options = '<option value="">Selecione a altura</option>'; 
          for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].altura + '">'  + j[i].altura + '</option>';
          }   
          $('#id_altura_inicio').html(options);
          $('#id_altura_fim').html(options);
          $('.carregando').hide();
        });
      } else {
        $('#id_altura_inicio').html('<option value="0">Selecione o nível</option>');
        $('#id_altura_fim').html('<option value="0">Selecione o nível</option>');
      }
    });

    $('#id_grupo').change(function(){
      if( $(this).val() ) {
        $('.carregando').show();
        $.getJSON('data/inventario/consulta_subgrupo.php?search=',{id_grupo: $(this).val(), ajax: 'true'}, function(j){
          var options = '<option value="">Selecione o sub-grupo</option>'; 
          for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].cod_sub_grupo + '">' + j[i].nm_sub_grupo + '</option>';
          }   
          $('#id_sub_grupo').html(options);
          $('.carregando').hide();
        });
      } else {
        $('#id_sub_grupo').html('<option value="0">Selecione o sub-grupo</option>');
      }
    });
  });
</script>