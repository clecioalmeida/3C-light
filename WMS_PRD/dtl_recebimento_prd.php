<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id = $_SESSION["id"];
}
?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_prd = mysqli_real_escape_string($link, $_POST["id_prd"]);

$SQL = "select t1.cod_nf_entrada_item, t1.cod_nf_entrada, t1.fl_status, t1.produto, t1.nm_produto, t1.nr_qtde, t1.vl_unit, t1.nr_ean, t1.nr_peso_unit, t1.ds_unid, t1.estado_produto, t2.nr_fisc_ent, t1.ds_obs, CASE WHEN t3.cod_prod_cliente IS NULL THEN 'PRODUTO NÃO ENCONTRADO' ELSE t3.cod_prod_cliente END AS cod_prod_cliente, t3.cod_produto
from tb_nf_entrada_item t1
left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
left join tb_produto t3 on t1.nm_produto like t3.nm_produto
where t1.cod_nf_entrada_item = '$id_prd'";
$res = mysqli_query($link, $SQL);

while ($dados = mysqli_fetch_assoc($res)) {
  $cod_nf_entrada_item  = $dados['cod_nf_entrada_item'];
  $cod_nf_entrada       = $dados['cod_nf_entrada'];
  $nr_fisc_ent          = $dados['nr_fisc_ent'];
  $fl_status            = $dados['fl_status'];
  $produto              = $dados['produto'];
  $nm_produto           = $dados['nm_produto'];
  $nr_qtde              = $dados['nr_qtde'];
  $vl_unit              = $dados['vl_unit'];
  $nr_ean               = $dados['nr_ean'];
  $nr_peso_unit         = $dados['nr_peso_unit'];
  $cod_produto          = $dados['cod_produto'];
  $cod_prod_cliente     = $dados['cod_prod_cliente'];
  $estado_produto       = $dados['estado_produto'];
  $ds_unid              = $dados['ds_unid'];
  $ds_obs               = $dados['ds_obs'];
}

$link->close();
?>
<br><br>
<legend>CADASTRAR PRODUTO A RECEBER
  <button type="button" class="btn btn-success btn-xs" id="btnInsPrdRec" value="<?php echo $id_prd;?>" style="float: right;width: 150px">SALVAR</button>
</legend>
<form method="post" action="" id="formNovoPrdRec">
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">NOTA FISCAL</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="nr_fisc_ent" name="nr_fisc_ent" placeholder="" value="<?php echo $nr_fisc_ent; ?>">
            <input type="hidden" class="form-control" id="cod_nf_entrada" name="cod_nf_entrada" placeholder="" value="<?php echo $cod_nf_entrada; ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">CÓDIGO DO PRODUTO</label>
          <div class="col-md-4">
            <div class="input-group input-group-md">
              <input class="form-control" id="cod_prod_cliente" name="" value="<?php echo $cod_prod_cliente;?>" type="text">
              <span class="input-group-btn">
                <button class="btn btn-info" type="button" id="btnPesqPrdNf" style="height: 32px"><span class="fa fa-search" title data-original-title="Pesquisar Produto"></span></button>
              </span>
            </div>
          </div>  
        </div>  
      </section>
    </fieldset>
    <fieldset>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">PRODUTO</label>
          <div class="col-md-5">
            <div class="input-group input-group-md">
              <input class="form-control bs-autocomplete" id="nm_produto" name="nm_produto" value="<?php echo $nm_produto;?>" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/recebimento/consulta_produto.php" data-hidden_field_id="cod_produto" data-item_id="cod_produto" data-item_label="nm_produto" autocomplete="off">
              <input class="form-control" id="cod_produto" name="cod_produto" value="<?php echo $cod_produto;?>" type="hidden" readonly>
              <span class="input-group-btn">
                <button class="btn btn-info" type="button" id="btnInsPrdNf" style="height: 32px"><span class="fa fa-plus" title data-original-title="Cadastrar Produto"></span></button>
                <button class="btn btn-primary" type="button" id="btnUpdPrdNf" name="btnUpdPrdNf" style="height: 32px"><span class="fa fa-pencil" title data-original-title="Editar Produto"></span></button>
              </span>
            </div>
          </div>  
        </div>     
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">ESTADO</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="estado_produto" name="estado_produto" placeholder="" required="true">
          </div>
        </div>
      </section>
    </fieldset>
    <fieldset>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">TIPO DE VOLUMES</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="ds_unid" name="ds_unid" placeholder="Tipo de volumes" value="<?php echo $ds_unid;?>">
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">TOTAL DE VOLUMES</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="nr_qtde" name="nr_qtde" placeholder="Total de volume" value="<?php echo $nr_qtde;?>" style="text-align: right;">
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">PESO TOTAL</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="nr_peso_unit" name="nr_peso_unit" placeholder="Peso total (kg)" value="<?php echo $nr_peso_unit;?>" style="text-align: right;">
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">VALOR UNITÁRIO</label>
          <div class="col-md-2">
            <input type="text" class="form-control valor" id="vl_unit" name="vl_unit" placeholder="Valor total" value="<?php echo $vl_unit;?>" required="true" style="text-align: right;">
          </div>
        </div>
      </section>
    </fieldset>
    <fieldset>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">EAN</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="nr_ean" name="nr_ean" placeholder="Ean" value="<?php echo $nr_ean;?>" style="text-align: right;">
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">OBSERVAÇÃO</label>
          <div class="col-md-5">
            <textarea class="form-control" id="ds_obs_nf" name="ds_obs_nf" id="ds_obs_nf" rows="3" placeholder="Observação"> <?php echo $ds_obs;?></textarea>
          </div>
        </div>
      </section>
    </fieldset>
  </form>
  <br><br>
  <div class="row">
    <div id="retornoModPrd">

    </div>
  </div>
</form>
<script type="text/javascript">
  $(document).ready(function () {
    $('.valor').maskMoney();

    $('#btnInsPrdNf').on('click',function(e){
      event.preventDefault();
      $('#retornoModPrd').load("data/produto/modal/m_ins_produto_rec.php");
    });

    $(document).on('click', '#btnFormNovoProdutoRec', function(){
      $('#formNovoProduto').ajaxForm({
        dataType:'json',
        url:'data/produto/ins_produto_rec.php',
        success:function(retorno)
        {
          for (var i = 0; i < j.length; i++) {

            if(j[i].info == 0){

              alert("Produto cadastrado!");
              $('#cod_produto').val(j[i].cod_produto);
              $('#nm_produto').val(j[i].nm_produto);

            }else{

              alert("Não foi possível cadastrar o produto!");

            }

          }
        }
      });
    });
  });
</script>
<script type="text/javascript">
  $.widget("ui.autocomplete", $.ui.autocomplete, {
    _renderMenu: function(ul, items) {
      var that = this;
      ul.attr("class", "nav nav-pills nav-stacked  bs-autocomplete-menu");
      $.each(items, function(index, item) {
        that._renderItemData(ul, item);
      });
    },

    _resizeMenu: function() {
      var ul = this.menu.element;
      ul.outerWidth(Math.min(
        ul.width("").outerWidth() + 1,
        this.element.outerWidth()
        ));
    }

  });

  (function() {
    "use strict";

    var produto = '';

    $('.bs-autocomplete').each(function() {
      var _this = $(this),
      _data = _this.data(),
      _hidden_field = $('#' + _data.hidden_field_id);

      $.getJSON(_data.source, 
      {
        ajax: 'true'
      }, 
      function(j){

        produto = j;
      });

      _this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
      .parent('.form-group').addClass('has-feedback');

      var feedback_icon = _this.next('.bs-autocomplete-feedback');
      feedback_icon.hide();

      _this.autocomplete({
        minLength: 3,
        autoFocus: true,

        source: function(request, response) {
          var _regexp = new RegExp(request.term, 'i');
          var data = produto.filter(function(item) {
            return item.nm_produto.match(_regexp);
          });
          response(data);
        },

        search: function() {
          feedback_icon.show();
          _hidden_field.val('');
        },

        response: function() {
          feedback_icon.hide();
        },

        focus: function(event, ui) {
          _this.val(ui.item[_data.item_label]);
          event.preventDefault();
        },

        select: function(event, ui) {
          _this.val(ui.item[_data.item_label]);
          _hidden_field.val(ui.item[_data.item_id]);
          event.preventDefault();
        }
      })
      .data('ui-autocomplete')._renderItem = function(ul, item) {
        return $('<li></li>')
        .data("item.autocomplete", item)
        .append('<a>' + item[_data.item_label] + '</a>')
        .appendTo(ul);
      };
    });
  })();
</script>