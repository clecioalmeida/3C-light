<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_produto = mysqli_real_escape_string($link, $_POST["dtl_produto"]);

$SQL = "select t1.cod_prod_cliente, t1.cod_produto, t1.nm_produto, t1.tp_separacao, t1.cod_cli, t1.cod_grupo, t1.cod_sub_grupo, t1.codncm, t1.fl_lote, t1.ean, t1.peso, t1.peso_bruto, t1.curva, t1.nr_estoque_min, t1.volume, t1.unid, t1.unid_controle, t1.altura, t1.compr, t1.largura, t1.cod_identificacao, t1.multiplo, t1.detalhe_produto, t1.id_armazem, t1.aloc_aut, t2.cod_cliente, t2.nm_cliente, t3.cod_grupo, t3.nm_grupo, t5.id, t5.nome
from tb_produto t1
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
left join tb_grupo t3 on t1.cod_grupo = t3.cod_grupo
left join tb_armazem t5 on t1.id_armazem = t5.id
where t1.cod_produto = '$id_produto'";
$res = mysqli_query($link, $SQL);
$tr = mysqli_num_rows($res);

while ($dados = mysqli_fetch_assoc($res)) {
	$cod_produto = $dados['cod_produto'];
	$nm_cliente = $dados['nm_cliente'];
	$nm_produto = $dados['nm_produto'];
	$cod_prod_cliente = $dados['cod_prod_cliente'];
	$tp_separacao = $dados['tp_separacao'];
	$codncm = $dados['codncm'];
	$cod_produto = $dados['cod_produto'];
	$ean = $dados['ean'];
	$fl_lote = $dados['fl_lote'];
	$peso = $dados['peso'];
	$curva = $dados['curva'];
	$peso_bruto = $dados['peso_bruto'];
	$detalhe_produto = $dados['detalhe_produto'];
	$nr_estoque_min = $dados['nr_estoque_min'];
	$unid = $dados['unid'];
	$volume = $dados['volume'];
	$unid_controle = $dados['unid_controle'];
	$altura = $dados['altura'];
	$nm_grupo = $dados['nm_grupo'];
	$nm_sub_grupo = $dados['nm_sub_grupo'];
	$compr = $dados['compr'];
	$largura = $dados['largura'];
	$cod_identificacao = $dados['cod_identificacao'];
	$multiplo = $dados['multiplo'];
	$nome = $dados['nome'];
	$aloc_aut = $dados['aloc_aut'];
}

$link->close();
?>
<div class="modal fade" id="detalhe_produto" aria-hidden="true">
 <form method="post" action="" id="formDtlProduto">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="alterar_produto" style="color: white">Consulta produto <?php echo $cod_produto; ?></h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
    </div>
    <div class="modal-body modal-lg" style="overflow-y: auto">
        <div class="portlet-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="cod_cli">Cliente</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nm_cliente" value="<?php echo $nm_cliente; ?>" id="cliente" placeholder="Cliente" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 form-group" for="produto">Produto</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="nm_produto" value="<?php echo $nm_produto; ?>" id="produto" placeholder="Produto" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 form-group" for="p_cliente">Cód. Cliente</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $cod_prod_cliente; ?>" name="cod_prod_cliente" id="p_cliente" placeholder="Cód. Cliente" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_separacao">Separação</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $tp_separacao; ?>" name="tp_separacao" id="p_cliente" placeholder="Separação" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_ncm">Cód. NCM</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $codncm; ?>" name="codncm" id="p_ncm" placeholder="NCM" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="p_estoque">Cód. Estoque</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" value="<?php echo $cod_produto; ?>" name="cod_produto" id="p_estoque" placeholder="Cód. Estoque" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_ean">EAN</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $ean; ?>" name="ean" id="p_ean" placeholder="EAN" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="p_lote">Controle de lote</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" value="<?php echo $fl_lote; ?>" name="fl_lote" id="p_ean" placeholder="EAN" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-md-2 control-label" for="p_peso_l">Peso líquido</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" value="<?php echo $peso; ?>" name="peso" id="p_peso_l" placeholder="Peso líquido" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_curva">Curva</label>
                    <div class="col-sm-4 form-md">
                        <input type="text" class="form-control" value="<?php echo $curva; ?>" name="curva" id="p_ean" placeholder="EAN" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_peso_b">Peso bruto</label>
                    <div class="col-sm-4 form-md">
                        <input type="text" class="form-control" value="<?php echo $peso_bruto; ?>" name="peso_bruto" id="p_peso_b" placeholder="Peso bruto" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_detalhe">Detalhes</label>
                    <div class="col-sm-4 form-md">
                        <input type="text" class="form-control" value="<?php echo $detalhe_produto; ?>" name="detalhe_produto" id="p_detalhe" placeholder="Detalhes" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_estoque_m">Estoque mínimo</label>
                    <div class="col-sm-4 form-md">
                        <input type="text" class="form-control" value="<?php echo $nr_estoque_min; ?>" name="nr_estoque_min" id="p_estoque_m" placeholder="Estoque mínimo" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_calculo">Unid. de Cálculo</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $unid; ?>" name="unid" id="p_calculo" placeholder="Unid. de Cálculo" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_volume_padrao">Volume padrão</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $volume; ?>" name="volume" id="p_volume_padrao" placeholder="Volume padrão" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_unid_estoque">Unid. de Estoque</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $unid_controle; ?>" name="unid_controle" id="p_unid_estoque" placeholder="Unid. de Estoque" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="p_altura">Altura</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $altura; ?>" name="altura" id="p_altura" placeholder="Altura" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="p_grupo">Grupo</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $nm_grupo; ?>" name="nm_grupo" id="p_ean" placeholder="Grupo" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="form_control_sgrupo">Sub-grupo</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $nm_sub_grupo; ?>" name="nm_sub_grupo" id="p_ean" placeholder="Sub-grupo" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form_control_comprimento">Comprimento</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $compr; ?>" name="compr" id="form_control_comprimento" placeholder="Comprimento" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="form_control_largura">Largura</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $largura; ?>" name="largura" id="form_control_largura" placeholder="Largura" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form_control_identificacao">Identificação</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $cod_identificacao; ?>" name="cod_identificacao" id="form_control_identificacao" placeholder="Identificação" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="form_control_multiplo">Múltiplo</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $multiplo; ?>" name="multiplo" id="form_control_multiplo" placeholder="Múltiplo" readonly="true" style="text-align: right;">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form_control_tipo">Tipo</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="form_control_tipo" placeholder="Tipo" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="form_control_local_pref">Local preferencial</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?php echo $nome; ?>" name="id_armazem" id="p_ean" placeholder="Local Preferencial" readonly="true">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="aloc_aut">Alocação automática</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="aloc_aut" value="<?php echo $aloc_aut; ?>" name="aloc_aut" placeholder="Alocação automática" readonly="readonly">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer modal-lg" style="background-color: #2F4F4F;">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
  </div>
</div>
</div>
</form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#detalhe_produto').modal('show');
    });
</script>