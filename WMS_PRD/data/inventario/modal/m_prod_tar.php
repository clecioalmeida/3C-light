<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.id, t1.id_galpao, t1.dt_inicio, t2.nome 
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.fl_status = 'P'";
$res_inv = mysqli_query($link,$SQL); 

$SQL_torre = "select * from tb_tipo_torre";
$res_torre = mysqli_query($link,$SQL_torre); 

$SQL_conf = "select t1.nm_cliente, t1.cod_cliente, t2.nm_cargo 
            from tb_cliente t1 left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
            where t1.nm_cargo = 20";
$res_conf = mysqli_query($link,$SQL_conf); 

$SQL_conf2 = "select t1.nm_cliente, t1.cod_cliente, t2.nm_cargo 
            from tb_cliente t1 left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
            where t1.nm_cargo = 20";
$res_conf2 = mysqli_query($link,$SQL_conf2); 

$link->close();
?>
<div class="modal fade" id="nova_tarefa" aria-hidden="true">
<form class="form-horizontal" method="post" action="" id="formCadProdTar">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #838B8B;">
        <h5 class="modal-title" style="color: white"><bold>Inclusão de produtos não conformes</bold></h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="id_inv">Inventário</label>
            <div class="col-sm-4">
                <select class="form-control" id="id_inv" name="id_inv" required="true">
                	<option>Selecione o inventário</option>
                 <?php 
                    while($row_inv = mysqli_fetch_assoc($res_inv)) {?>
                    <option value="<?php echo $row_inv['id']; ?>">
                            <?php echo $row_inv['id']." - ".$row_inv['nome']." - ".date('d/m/Y', strtotime($row_inv['dt_inicio'])); ?>
                    </option> 
                    <input type="hidden" name="id_galpao_inv" id="id_galpao_inv" value="<?php echo $row_inv['id_galpao'];?>">
                    <?php
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inv_rua">Rua / Módulo</label>
            <div class="col-sm-2">
                <select class="form-control" name="inv_rua" id="inv_rua" required="true">
                  <option value="">Selecione a rua</option>
                </select>
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="inv_mod">Coluna</label>
            <div class="col-sm-2">
                 <select class="form-control" name="inv_mod" id="inv_mod" required="true">
                  <option value="">Selecione a coluna</option>
                </select>
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="inv_alt">Altura</label>
            <div class="col-sm-2">
                 <select class="form-control" name="inv_alt" id="inv_alt" required="true">
                  <option value="">Selecione a altura</option>
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="id_torre">Torre</label>
            <div class="col-sm-4">
                <select class="form-control" id="id_torre" name="id_torre" required="true">
                	<option value="">Selecione a torre</option>
                 <?php 
                    while($row_torre = mysqli_fetch_assoc($res_torre)) {?>
                    <option value="<?php echo $row_torre['id']; ?>">
                        <?php echo $row_torre['id']." ".$row_torre['ds_tensao']." "."KV"." ".$row_torre['ds_torre']." ".$row_torre['ds_tipo']." ".$row_torre['ds_linhao']." ".$row_torre['ds_circuito'] ;?>
                    </option>
                    <?php
                    } ?>
                </select>
                <div class="form-control-focus"> </div>
            </div>

            <label class="col-sm-2 control-label" for="ds_embalagem">Embalagem</label>
            <div class="col-sm-4" id="feixePP">
                <input type="text" class="form-control" id="ds_embalagem" name="ds_embalagem" required="true">
                <div class="form-control-focus"> </div>
            </div>
        </div>
      	<div class="form-group">
            <label class="col-sm-2 control-label" for="ds_detalhe">Detalhe</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="ds_detalhe" name="ds_detalhe" required="true" placeholder="Digite informações existentes">
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="conf1">Conferente 1</label>
            <div class="col-sm-4">
                 <select class="form-control" id="conf1" name="conf1" required="true">
                	<option value="">Selecione o primeiro conferente</option>
                 <?php 
                    while($row_conf = mysqli_fetch_assoc($res_conf)) {?>
                    <option value="<?php echo $row_conf['cod_cliente']; ?>">
                        <?php echo $row_conf['nm_cliente'] ;?>
                    </option>
                    <?php
                    } ?>
                </select>
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="conf2">Conferente 2</label>
            <div class="col-sm-4">
                 <select class="form-control" id="conf2" name="conf2" required="true">
                	<option value="">Selecione o segundo conferente</option>
                 <?php 
                    while($row_conf2 = mysqli_fetch_assoc($res_conf2)) {?>
                    <option value="<?php echo $row_conf2['cod_cliente']; ?>">
                        <?php echo $row_conf2['nm_cliente'] ;?>
                    </option>
                    <?php
                    } ?>
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <legend>Insira as quantidades</legend>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="qtde1">Qtde 1</label>
            <div class="col-sm-2">
                 <input type="text" class="form-control" id="qtde1" name="qtde1" required="true">
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="qtde2">Qtde 2</label>
            <div class="col-sm-2">
                 <input type="text" class="form-control" id="qtde2" name="qtde2" required="true">
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="cargo">Qtde 3</label>
            <div class="col-sm-2">
                 <input type="text" class="form-control" id="qtde3" name="qtde3">
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div id="confirma"></div>
       </div>
      <div class="modal-footer" style="background-color: #838B8B">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary" id="btnFormCadProdTar">Incluir</button>
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
