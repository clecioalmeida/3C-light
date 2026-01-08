<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = mysqli_real_escape_string($link, $_POST["id_inv"]);

$big_select="SET SQL_BIG_SELECTS=1";
$res_big=mysqli_query($link, $big_select);

$SQL = "select t1.id, 
t1.id_galpao, 
t2.nome,
t1.id_rua_inicio,
t1.id_coluna_inicio,
t1.id_altura_inicio,
t1.id_rua_fim,
t1.id_coluna_fim,
t1.id_altura_fim,
t1.dt_inicio, 
t1.dt_fim,
CASE t1.ds_tipo WHEN 'R' THEN 'ROTATIVO' WHEN 'A' THEN 'ANUAL' WHEN 'I' THEN 'ABERTURA DE OPERAÇÃO' WHEN 'F' THEN 'ENCERRAMETNO DE OPERAÇÃO' END as tipo_inv,
t1.ds_tipo,
t1.id_produto,
t1.id_grupo,
t1.id_sub_grupo
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.id = '$id_inv'";
$res_tar = mysqli_query($link,$SQL);

$dados = mysqli_fetch_assoc($res_tar);

$id_galpao        = $dados['id_galpao'];
$dt_inicio        = $dados['dt_inicio'];
$dt_fim           = $dados['dt_fim'];
$id_rua_inicio    = $dados['id_rua_inicio'];
$id_coluna_inicio = $dados['id_coluna_inicio'];
$id_altura_inicio = $dados['id_altura_inicio'];
$id_rua_fim       = $dados['id_rua_fim'];
$id_coluna_fim    = $dados['id_coluna_fim'];
$id_altura_fim    = $dados['id_altura_fim'];
$tipo_inv         = $dados['tipo_inv'];
$ds_tipo          = $dados['ds_tipo'];
$id_produto       = $dados['id_produto'];
$id_grupo         = $dados['id_grupo'];
$id_sub_grupo     = $dados['id_sub_grupo'];
$nome             = $dados['nome'];

?>
<div class="modal fade" id="edita_tarefa" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" style="color: white"><bold>Editar inventário: <?php echo $id_inv;?></bold></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <div class="row">
          <article class="col-sm-12 col-md-12 col-lg-12">
            <form class="form-inline" method="post" action="" id="formInvAg" role="form">
              <fieldset>
                <header>
                  <legend>Parâmetros</legend>
                </header>
                <div class="col-md-10">
                  <label class="col-md-2">Período</label>
                  <div class="form-group">
                    <select class="form-control" name="ds_tipo" id="ds_tipo">
                      <option value="<?php echo $ds_tipo;?>"><?php echo $tipo_inv;?></option>
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
                    <input type="date" name="dt_inicio" class="form-control" id="datainicio" value="<?php echo $dt_inicio;?>" placeholder="Início">
                  </div>
                </div>
                <div class="col-md-4">
                  <label class="col-md-2">Até:</label>
                  <div class="form-group">
                    <input type="date" name="dt_fim" class="form-control" id="dt_fim" value="<?php echo $dt_fim;?>" placeholder="Fim">
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
                      <option value="<?php echo $id_galpao;?>"><?php echo $nome;?></option>
                      <?php

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
                      <option value="<?php echo $id_rua_inicio;?>"><?php echo $id_rua_inicio;?></option>
                    </select> 
                    <select class="form-control" name="id_coluna_inicio" id="id_coluna_inicio">
                      <option value="<?php echo $id_coluna_inicio;?>"><?php echo $id_coluna_inicio;?></option>
                    </select>  
                    <select class="form-control" name="id_altura_inicio" id="id_altura_inicio">
                      <option value="<?php echo $id_altura_inicio;?>"><?php echo $id_altura_inicio;?></option>
                    </select> 
                  </div>
                </div>
              </fieldset><br>
              <fieldset>
                <div class="col-md-10">
                  <label class="col-md-2">Até:</label>
                  <div class="form-group">
                    <select class="form-control" name="id_rua_fim" id="id_rua_fim">
                      <option value="<?php echo $id_rua_fim;?>"><?php echo $id_rua_fim;?></option>
                    </select> 
                    <select class="form-control" name="id_coluna_fim" id="id_coluna_fim">
                      <option value="<?php echo $id_coluna_fim;?>"><?php echo $id_coluna_fim;?></option>
                    </select> 
                    <select class="form-control" name="id_altura_fim" id="id_altura_fim">
                      <option value="<?php echo $id_altura_fim;?>"><?php echo $id_altura_fim;?></option>
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
                      <option value="<?php echo $id_grupo;?>"><?php echo $id_grupo;?></option>
                      <?php
                      $grupo="select cod_grupo, nm_grupo from tb_grupo";
                      $res_grupo = mysqli_query($link, $grupo);
                      while ($dados_grupo=mysqli_fetch_assoc($res_grupo)) { ?>
                        <option id="local" value="<?php echo $dados_grupo['cod_grupo']; ?>"><?php echo $dados_grupo['nm_grupo']; ?></option>
                      <?php } $link->close();?>
                    </select> 
                  </div>
                  <div class="form-group">
                    <select class="form-control" name="id_sub_grupo" id="id_sub_grupo">
                      <option value="<?php echo $id_sub_grupo;?>"><?php echo $id_sub_grupo;?></option>
                    </select> 
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="id_produto" id="cod_produto" value="<?php echo $id_produto;?>" placeholder="Digite o código do produto">
                    <input type="hidden" name="id_inv" value="<?php echo $id_inv;?>">
                  </div>
                </div>
              </fieldset>
            </article>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #22262E;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary" id="btnSaveUpdInv">Alterar</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function () {
      $('#edita_tarefa').modal('show');
    });
  </script>