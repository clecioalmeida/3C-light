<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_kit = mysqli_real_escape_string($link, $_POST["dtl_kit"]);

$SQL = "select * from tb_kit where id = '$id_kit'";

$res_kit = mysqli_query($link,$SQL); 

while ($dados = mysqli_fetch_assoc($res_kit)) {
    $descricao=$dados['descricao'];
    $id=$dados['id'];
    $cod_cliente=$dados['cod_cliente'];
    $alerta_rep=$dados['alerta_rep'];
    $ean=$dados['ean'];
    $detalhe_kit=$dados['detalhe_kit'];
    $estoque_minimo=$dados['estoque_minimo'];
}

$link->close();
?>
<div class="modal fade" id="kit_detalhe" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Detalhes do kit <h3 style="color: white"><?php echo $descricao; ?></h3></h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="overflow-y: auto">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="kit">Kit</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="kit" value="<?php echo $id; ?>" placeholder="Kit">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="cod_cliente">Cód. Cliente</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="cod_cliente" value="<?php echo $cod_cliente; ?>" placeholder="Cód. Cliente">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="p_separacao">Separação</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" value="" name="tp_separacao" id="tp_separacao" placeholder="Tipo de separação" readonly="true">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="alerta_rep">Alerta de reposição?</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="alerta_rep" value="<?php echo $alerta_rep; ?>" placeholder="Alerta de reposição" readonly="true">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="p_ean">EAN</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="p_ean" value="<?php echo $ean; ?>" placeholder="EAN">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="fl_lote">Controle de lote</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" value="" name="fl_lote" id="fl_lote" placeholder="Controle de lote" readonly="true">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="curva">Curva</label>
                <div class="col-sm-4 form-md">
                    <input type="text" class="form-control" value="" name="curva" id="curva" placeholder="Curva" readonly="true">
                <div class="form-control-focus"> </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="p_detalhe">Detalhes</label>
                <div class="col-sm-4 form-md">
                    <input type="text" class="form-control" id="p_detalhe" value="<?php echo $detalhe_kit; ?>" placeholder="Detalhes">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="estoque_minimo">Estoque mínimo</label>
                <div class="col-sm-4 form-md">
                    <input type="text" class="form-control" id="estoque_minimo" value="<?php echo $estoque_minimo; ?>" placeholder="Estoque mínimo">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="p_grupo">Grupo</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="p_grupo" value="" placeholder="Grupo">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="form_control_sgrupo">Sub-grupo</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="form_control_sgrupo" value="" placeholder="Sub-grupo">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="local_preferencial">Local preferencial</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="local_preferencial" value="" placeholder="Local preferencial">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
    </div>
  </div>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#kit_detalhe').modal('show');
    });
</script>