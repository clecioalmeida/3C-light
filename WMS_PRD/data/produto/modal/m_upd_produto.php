<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_produto = mysqli_real_escape_string($link, $_POST["upd_produto"]);

$SQL = "select t1.cod_prod_cliente, t1.cod_produto, t1.nm_produto, t1.tp_separacao, t1.cod_cli, t1.cod_grupo, t1.cod_sub_grupo, t1.codncm, t1.fl_lote, t1.ean, t1.peso, t1.peso_bruto, t1.curva, t1.nr_estoque_min, t1.volume, t1.unid, t1.unid_controle, t1.altura, t1.compr, t1.largura, t1.cod_identificacao, t1.multiplo, t1.detalhe_produto, t1.id_armazem, t1.aloc_aut, t2.cod_cliente, t2.nm_cliente, t3.cod_grupo, t3.nm_grupo, t5.id, t5.nome 
from tb_produto t1 
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente 
left join tb_grupo t3 on t1.cod_grupo = t3.cod_grupo
left join tb_armazem t5 on t1.id_armazem = t5.id
where t1.cod_produto = '$id_produto'"; 
$res = mysqli_query($link,$SQL); 
$tr = mysqli_num_rows($res);

while ($dados = mysqli_fetch_assoc($res)) {
   $cod_produto=$dados['cod_produto'];
   $nm_cliente=$dados['nm_cliente'];
   $nm_produto=$dados['nm_produto'];
   $cod_prod_cliente=$dados['cod_prod_cliente'];
   $tp_separacao=$dados['tp_separacao'];
   $codncm=$dados['codncm'];
   $cod_produto=$dados['cod_produto'];
   $ean=$dados['ean'];
   $fl_lote=$dados['fl_lote'];
   $peso=$dados['peso'];
   $curva=$dados['curva'];
   $peso_bruto=$dados['peso_bruto'];
   $detalhe_produto=$dados['detalhe_produto'];
   $nr_estoque_min=$dados['nr_estoque_min'];
   $unid=$dados['unid'];
   $volume=$dados['volume'];
   $unid_controle=$dados['unid_controle'];
   $altura=$dados['altura'];
   $nm_grupo=$dados['nm_grupo'];
   $compr=$dados['compr'];
   $largura=$dados['largura'];
   $cod_identificacao=$dados['cod_identificacao'];
   $multiplo=$dados['multiplo'];
   $nome=$dados['nome'];
   $aloc_aut=$dados['aloc_aut'];
}  

$link->close();
?>
<div class="modal fade" id="alterar_produto" aria-hidden="true">
 <form method="post" action="" id="formUpdProduto">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #22262E;">
            <h5 class="modal-title" id="alterar_produto" style="color: white">ALTERAR PRODUTO CÓDIGO: <?php echo $cod_produto; ?></h5>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body" style="overflow-y: auto">
            <fieldset>
                <section>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="produto">Produto</label>
                        <div class="col-sm-11">
                            <input type="text" class="form-control" name="nm_produto" value="<?php echo $nm_produto; ?>" id="produto" placeholder="Produto">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="p_cliente">Cód. Cliente</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $cod_prod_cliente; ?>" name="cod_prod_cliente" id="p_cliente" placeholder="Cód. Cliente" style="text-align: right;" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-md-1 control-label" for="p_estoque">Cód. Estoque</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="<?php echo $cod_produto; ?>" name="cod_produto" id="p_estoque" placeholder="Cód. Estoque" style="text-align: right;" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-md-1 control-label" for="fl_lote">Controle de lote</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $fl_lote; ?>" name="fl_lote" id="fl_lote" placeholder="Controle de lote">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="p_ean">EAN</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $ean; ?>" name="ean" id="p_ean" placeholder="EAN" style="text-align: right;">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-1 control-label" for="p_ncm">Cód. NCM</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $codncm; ?>" name="codncm" id="p_ncm" placeholder="NCM" style="text-align: right;">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-1 control-label" for="p_separacao">Separação</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $tp_separacao; ?>" name="tp_separacao" id="tp_separacao" placeholder="Separação" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <div class="form-group">
                        <label class="col-md-1 control-label" for="p_peso_l">Peso líquido</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="<?php echo $peso; ?>" name="peso" id="p_peso_l" placeholder="Peso líquido" style="text-align: right;">
                        </div>
                        <div class="form-control-focus"> </div>
                        <label class="col-sm-1 control-label" for="p_peso_b">Peso bruto</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="<?php echo $peso_bruto; ?>" name="peso_bruto" id="p_peso_b" placeholder="Peso bruto" style="text-align: right;">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-1 control-label" for="p_curva">Curva</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="<?php echo $curva; ?>" name="curva" id="curva" placeholder="Curva" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="p_detalhe">Detalhes</label>
                        <div class="col-md-11">
                            <textarea type="text" class="form-control" name="detalhe_produto" id="p_detalhe" value="<?php echo $detalhe_produto; ?>" rows="3"></textarea>
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="p_calculo">Unid. de Cálculo</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $unid; ?>" name="unid" id="p_calculo" placeholder="Unid. de Cálculo" style="text-align: right;">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-1 control-label" for="p_unid_estoque">Unid. de Estoque</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $unid_controle; ?>" name="unid_controle" id="p_unid_estoque" placeholder="Unid. de Estoque" style="text-align: right;">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-1 control-label" for="form_control_multiplo">Múltiplo</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $multiplo; ?>" name="multiplo" id="form_control_multiplo" placeholder="Múltiplo" style="text-align: right;">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="p_estoque_m">Estoque mínimo</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="<?php echo $nr_estoque_min; ?>" name="nr_estoque_min" id="p_estoque_m" placeholder="Estoque mínimo" style="text-align: right;">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-1 control-label" for="p_volume_padrao">Volume padrão</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="<?php echo $volume; ?>" name="volume" id="p_volume_padrao" placeholder="Volume padrão">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-1 control-label" for="form_control_identificacao">Identificação</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $cod_identificacao; ?>" name="cod_identificacao" id="form_control_identificacao" placeholder="Identificação">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <div class="form-group">
                       <label class="col-sm-1 control-label" for="cod_grupo">Grupo</label>
                       <div class="col-sm-3">
                        <input type="text" class="form-control" value="<?php echo $nm_grupo; ?>" name="nm_grupo" id="cod_grupo" placeholder="Grupo" readonly="readonly">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-1 control-label" for="form_control_sgrupo">Sub-grupo</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" value="" name="nm_sub_grupo" id="form_control_sgrupo" placeholder="Sub-grupo" readonly="readonly">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-1 control-label" for="form_control_tipo">Tipo</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="form_control_tipo" placeholder="Tipo">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </section>
        </fieldset>
        <fieldset>
            <section>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="form_control_comprimento">Compr.</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" value="<?php echo $compr; ?>" name="compr" id="form_control_comprimento" placeholder="Comprimento" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-1 control-label" for="form_control_largura">Largura</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" value="<?php echo $largura; ?>" name="largura" id="form_control_largura" placeholder="Largura" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-1 control-label" for="p_altura">Altura</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" value="<?php echo $altura; ?>" name="altura" id="p_altura" placeholder="Altura" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </section>
        </fieldset>
        <fieldset>
            <section>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="form_control_local_pref">Local preferencial</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="form_control_local_pref" value="<?php echo $nome; ?>" name="nome" placeholder="Local preferencial" readonly="readonly">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-md-1 control-label" for="aloc_aut">Alocação automática</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="aloc_aut" value="<?php echo $aloc_aut; ?>" name="aloc_aut" placeholder="Alocação automática" readonly="readonly">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </section>
        </fieldset>
    </div>
    <div class="modal-footer" style="background-color: #22262E;">
      <button type="submit" class="btn btn-primary" id="btnFormUpdProduto">Salvar</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
  </div>
</div>
</div>
</form>
</div>
<script>
    $(document).ready(function () {
        $('#alterar_produto').modal('show');
    });
</script>