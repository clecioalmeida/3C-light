<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_tar = mysqli_real_escape_string($link, $_POST["id_tar"]);

$big_select="SET SQL_BIG_SELECTS=1";
$res_big=mysqli_query($link, $big_select);

$sql_galpao = "select t1.id, t1.id_galpao, t1.dt_inicio, t2.nome 
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.fl_status = 'P'";
$res_inv = mysqli_query($link,$sql_galpao); 

$SQL = "select t1.*, t2.*, t3.cod_produto, t3.cod_prod_cliente, t6.nm_cliente
from tb_inv_tarefa t1 
left join tb_inv_conf t2 on t1.id = t2.id_tar
left join tb_produto t3 on t1.id_produto = t3.cod_produto
left join tb_cliente t6 on t2.conf_1 = t6.cod_cliente
where t1.id = '$id_tar'";
$res_tar = mysqli_query($link,$SQL);

while ($dados=mysqli_fetch_assoc($res_tar)) {
    $id_inv=$dados['id_inv'];
    $id_estoque=$dados['id_estoque'];
    $id_produto=$dados['id_produto'];
    $id_galpao=$dados['id_galpao'];
    $id_rua=$dados['id_rua'];
    $id_coluna=$dados['id_coluna'];
    $id_altura=$dados['id_altura'];
    $ds_detalhe=$dados['ds_detalhe'];
    $nr_qtde=$dados['nr_qtde'];
    $id_estoque=$dados['id_estoque'];
    $cont1=$dados['cont_1'];
    $cont2=$dados['cont_2'];
    $cont3=$dados['cont_3'];
    $conf1=$dados['conf_1'];
    $conf2=$dados['conf_2'];
    $nm_cliente=$dados['nm_cliente'];
    $cod_prod_cliente=$dados['cod_prod_cliente'];
    $ds_detalhe=$dados['ds_detalhe'];
    $nr_volume=$dados['nr_volume'];
}

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
<div class="modal fade" id="edita_tarefa" aria-hidden="true">
    <form class="form-horizontal" method="post" action="" id="formUpdTar">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #22262E;">
            <h5 class="modal-title" style="color: white"><bold>Editar tarefa: <?php echo $id_tar;?></bold></h5>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body modal-lg" style="overflow-y: auto">
            <div class="form-group">
                <label class="col-sm-1 control-label" for="u_nome">Inventário</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="id_inv_upd" name="id_inv_upd" value="<?php echo $id_inv;?>" readonly="true">
                </div>
                <label class="col-sm-1 control-label" for="u_nome">Data da tarefa</label>
                <div class="col-sm-4">
                  <input type="date" class="form-control" id="dt_tarefa" name="dt_tarefa" required="true">
              </div>
          </div>
          <div class="form-group">
            <label class="col-sm-1 control-label" for="inv_rua">Rua</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="inv_rua" name="inv_rua" value="<?php echo $id_rua;?>" readonly="true">
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-1 control-label" for="inv_mod">Coluna</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="inv_mod" name="inv_mod" value="<?php echo $id_coluna;?>" readonly="true">
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-1 control-label" for="inv_alt">Altura</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="inv_alt" name="inv_alt" value="<?php echo $id_altura;?>" readonly="true">
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="ds_embalagem">Produto</label>
            <div class="col-sm-3" id="feixePP">
                <input type="text" class="form-control" id="cod_prod_cliente" name="cod_prod_cliente" value="<?php echo $cod_prod_cliente;?>" required>
                <input type="hidden" class="form-control" id="id_produto" name="id_produto" value="<?php echo $id_produto;?>">
              <div class="form-control-focus"> </div>
          </div>
          <label class="col-sm-1 control-label" for="tarProduto">Produto</label>
          <div class="col-sm-7" id="tarProduto">
              <div class="form-control-focus"> </div>
          </div>
      </div>
      <legend>Insira as quantidades</legend>
      <div class="form-group">
        <label class="col-sm-1 control-label" for="qtde1">Qtde 1</label>
        <div class="col-sm-2">
           <input type="text" class="form-control" id="qtde1" name="qtde1" value="<?php echo $cont1;?>" required="true">
           <div class="form-control-focus"> </div>
       </div>
       <label class="col-sm-1 control-label" for="qtde2">Qtde 2</label>
       <div class="col-sm-2">
           <input type="text" class="form-control" id="qtde2" name="qtde2" value="<?php echo $cont2;?>" required="true">
           <div class="form-control-focus"> </div>
       </div>
       <label class="col-sm-1 control-label" for="cargo">Qtde 3</label>
       <div class="col-sm-2">
           <input type="text" class="form-control" id="qtde3" name="qtde3">
           <div class="form-control-focus"> </div>
       </div>
       <label class="col-sm-1 control-label" for="cargo">Volumes</label>
       <div class="col-sm-2">
           <input type="text" class="form-control" id="nr_volume" name="nr_volume" value="<?php echo $nr_volume;?>" required="true">
           <div class="form-control-focus"> </div>
       </div>
   </div>
   <div id="confirma"></div>
</div>
<div class="modal-footer" style="background-color: #22262E;">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    <button type="submit" class="btn btn-primary" id="btnFormUpdTar" value="<?php echo $id_tar;?>">Alterar</button>
</div>
</div>
</div>
</form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#edita_tarefa').modal('show');
    });
</script>