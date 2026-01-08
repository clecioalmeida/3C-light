<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "select * from tb_armazem";
$select_local = mysqli_query($link, $sql_local);

$sql_grupo = "select * from tb_grupo";
$select_grupo = mysqli_query($link, $sql_grupo);

$sql_sub_grupo = "select * from tb_sub_grupo";
$select_sub_grupo = mysqli_query($link, $sql_sub_grupo);

$link->close();
?>
<div class="modal fade" id="novo_produto" aria-hidden="true">
 <form method="post" action="" id="formNovoProduto">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" id="novo_produto" style="color: white">Incluir produtos</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="overflow-y: auto">               
        <div class="portlet-body">
            <form class="form-horizontal">
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="produto">Produto</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="nm_produto" id="produto" placeholder="Produto">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_cliente">Cód. Cliente</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="cod_prod_cliente" id="p_cliente" placeholder="Cód. Cliente">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_separacao">Separação</label>
                    <div class="col-sm-4">
                        <label class="radio"><input type="radio" name="tp_separacao" value="fifo" id="p_separacao">Fifo</label>
                        <label class="radio"><input type="radio" name="tp_separacao" value="fefo" id="p_separacao">Fefo</label>
                        <label class="radio"><input type="radio" name="tp_separacao" value="comum" id="p_separacao">Comum</label>
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_ncm">Cód. NCM</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="codncm" id="p_ncm" placeholder="NCM">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="p_estoque">Cód. Estoque</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="p_estoque" placeholder="Cód. Estoque" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_ean">EAN</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="ean" id="p_ean" placeholder="EAN">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="p_lote">Controle de lote</label>
                    <div class="col-md-4">
                        <label class="radio"><input type="radio" value="S" name="fl_lote" id="p_lote">Sim</label>
                        <label class="radio"><input type="radio" value="N" name="fl_lote" id="p_lote">Não</label>
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-md-2 control-label" for="p_peso_l">Peso líquido</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="peso" id="p_peso_l" placeholder="Peso líquido">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_curva">Curva</label>
                    <div class="col-sm-4">
                         <label class="radio"><input type="radio" value="A" name="curva" id="p_curva">A</label>
                         <label class="radio"><input type="radio" value="B" name="curva" id="p_curva">B</label>
                         <label class="radio"><input type="radio" value="C" name="curva" id="p_curva">C</label>
                    <div class="form-control-focus"> </div>
                </div>
                    <label class="col-sm-2 control-label" for="p_peso_b">Peso bruto</label>
                    <div class="col-sm-4 form-md">
                        <input type="text" class="form-control" name="peso_bruto" id="p_peso_b" placeholder="Peso bruto">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_detalhe">Detalhes</label>
                    <div class="col-sm-4 form-md">
                        <input type="text" class="form-control" name="detalhe_produto" id="p_detalhe" placeholder="Detalhes">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_estoque_m">Estoque mínimo</label>
                    <div class="col-sm-4 form-md">
                        <input type="text" class="form-control" name="nr_estoque_min" id="p_estoque_m" placeholder="Estoque mínimo">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </fieldset>
            <hr>
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_calculo">Unid. de Cálculo</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="unid" id="p_calculo" placeholder="Unid. de Cálculo">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_volume_padrao">Volume padrão</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="volume" id="p_volume_padrao" placeholder="Volume padrão">
                        <div class="form-control-focus"> </div>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_unid_estoque">Unid. de Estoque</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="unid_controle" id="p_unid_estoque" placeholder="Unid. de Estoque">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_altura">Altura</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="altura" id="p_altura" placeholder="Altura">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form_control_comprimento">Comprimento</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="compr" id="form_control_comprimento" placeholder="Comprimento">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="form_control_largura">Largura</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="largura" id="form_control_largura" placeholder="Largura">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </fieldset>
            <hr>
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_grupo">Grupo</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="cod_grupo" id="cod_grupo">
                            <option>Selecione</option>
                            <?php 
                            while($row_select_grupo = mysqli_fetch_assoc($select_grupo)) {?>
                            <option value="<?php echo $row_select_grupo['cod_grupo']; ?>">
                                    <?php echo $row_select_grupo['nm_grupo']; ?>
                            </option> <?php } ?>
                      </select>
                      <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="form_control_sgrupo">Sub-grupo</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="cod_sub_grupo" id="cod_sub_grupo">
                          <option>Selecione</option>
                            <?php 
                            while($row_select_subgrupo = mysqli_fetch_assoc($select_sub_grupo)) {?>
                            <option value="<?php echo $row_select_subgrupo['cod_sub_grupo']; ?>">
                                    <?php echo $row_select_subgrupo['nm_sub_grupo']; ?>
                            </option> <?php } ?>
                      </select>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form_control_identificacao">Identificação</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="cod_identificacao" id="form_control_identificacao" placeholder="Identificação">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="form_control_tipo">Tipo</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="form_control_tipo" placeholder="Tipo">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </fieldset>
            <hr>
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form_control_multiplo">Múltiplo</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="multiplo" id="form_control_multiplo" placeholder="Múltiplo">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="form_control_local_pref">Local preferencial</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="id_armazem">
                          <option>Selecione</option>
                          <?php                                                           
                          while($row_select_local = mysqli_fetch_assoc($select_local)) {?>
                          <option value="<?php echo $row_select_local['id']; ?>">
                              <?php echo $row_select_local['nome']; ?>
                          </option> <?php } ?>
                      </select>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="aloc_aut">Alocação automática</label>
                    <div class="col-md-4">
                         <label class="radio-inline"><input type="radio" value="S" name="aloc_aut" id="aloc_aut1">Sim</label>
                         <label class="radio-inline"><input type="radio" value="N" name="aloc_aut" id="aloc_aut2">Não</label>
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="form_control_local_pref">Embalagem de expedição</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="id_embalagem">
                          <option>Selecione</option>
                         
                      </select>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </fieldset>
        </form>
          </div>
      </div>
      <div class="modal-footer" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnFormNovoProduto">Salvar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#novo_produto').modal('show');
    });
</script>