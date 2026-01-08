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
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.id, t1.id_galpao, t1.dt_inicio, t2.nome
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.fl_status = 'P' and fl_empresa = '$cod_cli'";
$res_inv = mysqli_query($link, $SQL);

$SQL_conf = "select t1.nm_user, t1.id
from tb_usuario t1 
where t1.id_depto = '3' and t1.fl_status = 'A' and id_op = '$cod_cli'";
$res_conf = mysqli_query($link, $SQL_conf);

$SQL_conf2 = "select t1.nm_user, t1.id
from tb_usuario t1 
where t1.id_depto = '3' and t1.fl_status = 'A' and id_op = '$cod_cli'";
$res_conf2 = mysqli_query($link, $SQL_conf2);

$link->close();
?>
<style type="text/css">
  .carregando{
    color:#ff0000;
    display:none;
  }
</style>
<div class="modal fade" id="nova_tarefa" aria-hidden="true">
  <form class="form-horizontal" method="post" action="" id="formCadTar">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #22262E;">
          <h5 class="modal-title" style="color: white"><bold>Incluir Tarefa</bold></h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body modal-lg" style="overflow-y: auto">
          <div class="form-group">
            <label class="col-sm-1 control-label" for="u_nome">Inventário</label>
            <div class="col-sm-4">
              <select class="form-control" id="id_inv" name="id_inv">
                <option>Selecione o inventário</option>
                <?php
                while($row_inv = mysqli_fetch_assoc($res_inv)){?>
                  <option value="<?php echo $row_inv['id']; ?>" data-inv="<?php echo $row_inv['id_galpao']; ?>"><?php echo $row_inv['id']." - ".$row_inv['nome']." - ".date('d/m/Y', strtotime($row_inv['dt_inicio'])); ?></option>
                <?php }?>
              </select>
                    <!--select class="form-control" id="id_inv" name="id_inv" required="true">
                        <option>Selecione o inventário</option>
                        <?php
                        while ($row_inv = mysqli_fetch_assoc($res_inv)) {?>
                            <option value="<?php echo $row_inv['id']; ?>">
                                <?php echo $row_inv['id']." - ".$row_inv['nome']." - ".date('d/m/Y', strtotime($row_inv['dt_inicio'])); ?>
                            </option>
                            <input type="hidden" name="id_galpao_inv" id="id_galpao_inv" value="<?php echo $row_inv['id_galpao']; ?>">
                            <?php } ?>
                          </select-->
                        </div>
                        <label class="col-sm-1 control-label" for="u_nome">Data da tarefa</label>
                        <div class="col-sm-4">
                          <input type="date" class="form-control" id="dt_tarefa" name="dt_tarefa" required="true">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-1 control-label" for="inv_rua">Rua</label>
                        <div class="col-sm-3">
                          <select class="form-control" name="inv_rua" id="inv_rua" required="true">
                            <option value="">Selecione a rua</option>
                          </select>
                          <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-1 control-label" for="inv_mod">Coluna</label>
                        <div class="col-sm-3">
                          <select class="form-control" name="inv_mod" id="inv_mod" required="true">
                            <option value="">Selecione a coluna</option>
                          </select>
                          <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-1 control-label" for="inv_alt">Altura</label>
                        <div class="col-sm-3">
                          <select class="form-control" name="inv_alt" id="inv_alt" required="true">
                            <option value="">Selecione a altura</option>
                          </select>
                          <div class="form-control-focus"> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-1 control-label" for="ds_embalagem">Produto</label>
                        <div class="col-sm-3" id="feixePP">
                          <input type="text" class="form-control" id="cod_prod_cliente" name="cod_prod_cliente" required>
                          <input type="hidden" class="form-control" id="id_produto" name="id_produto" >
                          <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-1 control-label" for="tarProduto">Produto</label>
                        <div class="col-sm-7" id="tarProduto">
                          <div class="form-control-focus"> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-1 control-label" for="conf1">Conferente 1</label>
                        <div class="col-sm-5">
                         <select class="form-control" id="conf1" name="conf1" required="true">
                           <option value="">Selecione o primeiro conferente</option>
                           <?php
                           while ($row_conf = mysqli_fetch_assoc($res_conf)) {?>
                            <option value="<?php echo $row_conf['cod_cliente']; ?>">
                              <?php echo $row_conf['nm_cliente']; ?>
                            </option>
                            <?php
                          }?>
                        </select>
                        <div class="form-control-focus"> </div>
                      </div>
                      <label class="col-sm-1 control-label" for="conf2">Conferente 2</label>
                      <div class="col-sm-5">
                       <select class="form-control" id="conf2" name="conf2" required="true">
                         <option value="">Selecione o segundo conferente</option>
                         <?php
                         while ($row_conf2 = mysqli_fetch_assoc($res_conf2)) {?>
                          <option value="<?php echo $row_conf2['cod_cliente']; ?>">
                            <?php echo $row_conf2['nm_cliente']; ?>
                          </option>
                          <?php
                        }?>
                      </select>
                      <div class="form-control-focus"> </div>
                    </div>
                  </div>
                  <legend>Insira as quantidades</legend>
                  <div class="form-group">
                    <label class="col-sm-1 control-label" for="qtde1">Qtde 1</label>
                    <div class="col-sm-2">
                     <input type="text" class="form-control" id="qtde1" name="qtde1" required="true">
                     <div class="form-control-focus"> </div>
                   </div>
                   <label class="col-sm-1 control-label" for="qtde2">Qtde 2</label>
                   <div class="col-sm-2">
                     <input type="text" class="form-control" id="qtde2" name="qtde2" required="true">
                     <div class="form-control-focus"> </div>
                   </div>
                   <label class="col-sm-1 control-label" for="cargo">Qtde 3</label>
                   <div class="col-sm-2">
                     <input type="text" class="form-control" id="qtde3" name="qtde3">
                     <div class="form-control-focus"> </div>
                   </div>
                   <label class="col-sm-1 control-label" for="cargo">Volumes</label>
                   <div class="col-sm-2">
                     <input type="text" class="form-control" id="nr_vol" name="nr_vol">
                     <div class="form-control-focus"> </div>
                   </div>
                 </div>
                 <div id="confirma"></div>
               </div>
               <div class="modal-footer" style="background-color: #22262E">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="btnFormCadTar">Incluir</button>
              </div>
            </div>
          </div>
        </form>
      </div><!--Fim modal-->
      <script>
        $(document).ready(function () {
          $('#nova_tarefa').modal('show');
        });
      </script>
<!--script type="text/javascript">

        $(function(){

            $(document).on('keyup', '#id_pos', function(){

                var pesquisa = $(this).val();
                var torre = $('#id_torre').val();

                if(pesquisa != '' || id_torre != ''){
                    var id_pos = {id_pos:pesquisa}
                    var id_torre = {id_torre:torre}

                    $.post('data/inventario/consulta_inv_produto.php', id_pos, id_torre, function(retorna){
                        $('#tarProduto').html(retorna);
                        });
                }else{

                    $('#tarProduto').html('');

                }
            });
        });

      </script-->
