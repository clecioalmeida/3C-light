<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:../index.php");
  exit;
} else {

  $id = $_SESSION["id"];
}
?>
<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rec    = $_POST['ins_rec'];

$sql_tp = "select cod_nf_entrada, nr_fisc_ent from tb_nf_entrada where cod_rec = '$id_rec' and fl_status <> 'E'";
$res_tp = mysqli_query($link, $sql_tp);

$sql_es = "select id, estado from tb_estado_produto";
$res_es = mysqli_query($link, $sql_es);

?>
<br><br>
<legend>CADASTRAR PRODUTO A RECEBER
  <button type="button" class="btn btn-success btn-xs" id="btnInsPrdRec" value="<?php echo $id_rec; ?>" style="float: right;width: 150px">SALVAR</button>
</legend>
<form method="post" action="" id="formNovoPrdRec">
  <input type="hidden" id="cod_rec" name="cod_rec" value="<?php echo $id_rec; ?>" type="hidden">
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">NOTA FISCAL</label>
        <div class="col-md-3">
          <select class="form-control" name="cod_nf_entrada" id="cod_nf_entrada">
            <?php
            while ($nfe = mysqli_fetch_assoc($res_tp)) { ?>
              <option value="<?php echo $nfe['cod_nf_entrada']; ?>"><?php echo $nfe['nr_fisc_ent']; ?>
              </option> <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">
          CÓDIGO
          <span class="d-inline-block" data-toggle="popover" data-placement="left" data-content="Insira o código do produto e clique no ícone de LUPA para pesquisar o produto">
            <i class="fa fa-question-circle" aria-hidden="true"></i>
          </span>
        </label>
        <div class="col-md-4">
          <div class="input-group input-group-md">
            <input class="form-control" id="cod_prod_cliente" name="" value="" type="text">
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
            <input class="form-control bs-autocomplete" id="nm_produto" name="nm_produto" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/recebimento/consulta_produto.php" data-hidden_field_id="cod_produto" data-item_id="cod_produto" data-item_label="nm_produto" autocomplete="off" readonly>
            <input class="form-control" id="cod_produto" name="cod_produto" value="" type="hidden" readonly>
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
          <select class="form-control" name="estado_produto" id="estado_produto">
            <?php
            while ($estado = mysqli_fetch_assoc($res_es)) { ?>
              <option value="<?php echo $estado['id']; ?>"><?php echo $estado['estado']; ?>
              </option> <?php } ?>
          </select>
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">TIPO DE VOLUMES</label>
        <div class="col-md-2">
          <input type="text" class="form-control" id="ds_unid" name="ds_unid" placeholder="Tipo de volumes" required="true">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">QUANTIDADE</label>
        <div class="col-md-2">
          <input type="text" class="form-control" id="nr_qtde" name="nr_qtde" placeholder="Total de itens" style="text-align: right;">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">PESO TOTAL</label>
        <div class="col-md-2">
          <input type="text" class="form-control" id="nr_peso_unit" name="nr_peso_unit" placeholder="Peso total (kg)" style="text-align: right;">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">VALOR UNITÁRIO</label>
        <div class="col-md-2">
          <input type="text" class="form-control valor" id="vl_unit" name="vl_unit" placeholder="Valor total" required="true" style="text-align: right;">
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">EAN</label>
        <div class="col-md-2">
          <input type="text" class="form-control" id="nr_ean" name="nr_ean" placeholder="Ean" style="text-align: right;">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">OBSERVAÇÃO</label>
        <div class="col-md-5">
          <textarea class="form-control" id="ds_obs_nf" name="ds_obs_nf" id="ds_obs_nf" rows="3" placeholder="Observação"></textarea>
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
  $(document).ready(function() {
    $(function() {
      $('[data-toggle="popover"]').popover();
    });
    
    $('.valor').maskMoney();

    $('#btnInsPrdNf').on('click', function(e) {
      event.preventDefault();
      $('#retornoModPrd').load("data/produto/modal/m_ins_produto_rec.php");
    });

    $(document).on('click', '#btnFormNovoProdutoRec', function() {
      $('#formNovoProduto').ajaxForm({
        dataType: 'json',
        url: 'data/produto/ins_produto_rec.php',
        success: function(retorno) {
          for (var i = 0; i < j.length; i++) {

            if (j[i].info == 0) {

              alert("Produto cadastrado!");
              $('#cod_produto').val(j[i].cod_produto);
              $('#nm_produto').val(j[i].nm_produto);

            } else {

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

      $.getJSON(_data.source, {
          ajax: 'true'
        },
        function(j) {

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