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

$id_rec    = $_POST['ins_rec'];

?>
<br><br>
<legend>CADASTRAR NOTA FISCAL
  <button type="button" class="btn btn-success btn-xs" id="btnInsNfRecAg" value="<?php echo $id_rec;?>" style="float: right;width: 150px">SALVAR</button>
</legend>
<form method="post" action="" id="formNovoNfRec">
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nfe_chave" class="control-label col-sm-1">CHAVE NFE</label>
        <div class="col-md-5">
          <div class="input-group input-group-md">
            <input class="form-control" id="nfe_chave" name="nfe_chave" type="text">
            <input type="hidden" class="form-control" id="cod_rec" name="cod_rec" value="<?php echo $id_rec; ?>" >
            <span class="input-group-btn">
              <button class="btn btn-info" type="button" id="btnConsEmitNfAg" style="height: 32px"><span class="fa fa-search"></span></button>
            </span>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">NOTA FISCAL</label>
        <div class="col-md-2">
          <input type="text" class="form-control" id="nr_fisc_ent" name="nr_fisc_ent" value="" placeholder="Nota fiscal" required="true" style="text-align: right;">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">EMISSÃO</label>
        <div class="col-md-2">
          <input type="date" class="form-control" id="dt_emis_ent" name="dt_emis_ent" placeholder="Emissão" required="true">
        </div>
      </div>
    </section>    
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">EMITENTE</label>
        <div class="col-md-5">
          <div class="input-group input-group-md">
            <input class="form-control bs-autocomplete" id="nm_emitente" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/recebimento/consulta_entidade.php" data-hidden_field_id="id_emitente" data-item_id="cod_cliente" data-item_label="nm_cliente" autocomplete="off">
            <input class="form-control" id="id_emitente" name="id_emitente" value="" type="hidden" readonly>
            <span class="input-group-btn">
              <button class="btn btn-info" type="button" id="btnInsEmitNfAg" style="height: 32px"><span class="fa fa-plus" title data-original-title="Cadastrar Emitente"></span></button>
              <button class="btn btn-primary" type="button" id="btnUpdEmitNf" name="btnUpdEmitCte" style="height: 32px"><span class="fa fa-pencil" title data-original-title="Editar Emitente"></span></button>
            </span>
          </div>
        </div>  
      </div>
    </div>        
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">DESTINATÁRIO</label>
      <div class="col-md-5">
        <div class="input-group input-group-md">
          <input class="form-control bs-autocomplete" id="nm_destinatario" value="" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/recebimento/consulta_entidade.php" data-hidden_field_id="id_destinatario" data-item_id="cod_cliente" data-item_label="nm_cliente" autocomplete="off">
          <input class="form-control" id="id_destinatario" name="id_destinatario" value="" type="hidden" readonly>
          <span class="input-group-btn">
            <button class="btn btn-info" type="button" id="btnInsDestNfAg" style="height: 32px"><span class="fa fa-plus" title data-original-title="Cadastrar Destinatário"></span></button>
            <button class="btn btn-primary" type="button" id="btnUpdDestNf" name="btnUpdDestCte" style="height: 32px"><span class="fa fa-pencil" title data-original-title="Editar Destinatário"></span></button>
          </span>
        </div>
      </div>  
    </div>
  </div>        
</section>
</fieldset>
<fieldset>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">CFOP</label>
      <div class="col-md-2">
        <input type="text" class="form-control" id="nr_cfop_ent" name="nr_cfop_ent" placeholder="Cfop" style="text-align: right;">
      </div>
    </div>
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">TIPO DE VOLUMES</label>
      <div class="col-md-2">
        <input type="text" class="form-control" id="tp_vol_ent" name="tp_vol_ent" placeholder="Tipo de volumes" required="true">
      </div>
    </div>
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">TOTAL DE VOLUMES</label>
      <div class="col-md-2">
        <input type="text" class="form-control" id="qtd_vol_ent" name="qtd_vol_ent" placeholder="Total de volume" style="text-align: right;">
      </div>
    </div>
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">PESO TOTAL</label>
      <div class="col-md-2">
        <input type="text" class="form-control" id="nr_peso_ent" name="nr_peso_ent" placeholder="Peso total (kg)" style="text-align: right;">
      </div>
    </div>
  </section>
</fieldset>
<fieldset>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">VALOR TOTAL</label>
      <div class="col-md-2">
        <input type="text" class="form-control valor" id="vl_tot_nf_ent" name="vl_tot_nf_ent" placeholder="Valor total" required="true" style="text-align: right;">
      </div>
    </div>
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">VALOR ICMS</label>
      <div class="col-md-2">
        <input type="text" class="form-control valor" id="vl_icms_ent" name="vl_icms_ent" placeholder="Valor ICMS" style="text-align: right;">
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
  <div id="retornoNfAg">

  </div>
</div>
</form>
<script type="text/javascript">
  $(document).ready(function () {
    $('.valor').maskMoney();

    $('#btnInsEmitNfAg').on('click',function(e){
      event.preventDefault();
      $('#retornoNfAg').load("data/entidade/modal/m_ins_cliente_nf_ag.php");
    });

    $('#btnInsDestNfAg').on('click',function(e){
      event.preventDefault();
      $('#retornoNfAg').load("data/entidade/modal/m_ins_destinatario_nf_ag.php");
    });

    $('#btnConsEmitNfAg').on('click',function(){
      event.preventDefault();
      var nfe_chv = $('#nfe_chave').val();
      $.ajax
      ({
        url:"data/recebimento/consulta_dados_chave_ag.php",
        method:"POST",
        dataType:'json',
        data:{
          nfe_chv :nfe_chv
        },
        success:function(j)
        {
          if(j.info == "0"){

            $('#nm_emitente').val(j.nm_cliente);
            $('#id_emitente').val(j.cod_cliente);
            $('#nr_fisc_ent').val(j.nr_nf);
            
          }else if(j.info == "1"){

            $('#nm_emitente').val("Cadastro não encontrado.");
            $('#nr_fisc_ent').val(j.nr_nf);
            
          }else if(j.info == "2"){

            alert("Nota fiscal já foi importada anteriormente.");

          }
        }
      });
      return false;
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

    var entidades = '';

    $('.bs-autocomplete').each(function() {
      var _this = $(this),
      _data = _this.data(),
      _hidden_field = $('#' + _data.hidden_field_id);

      $.getJSON(_data.source, 
      {
        ajax: 'true'
      }, 
      function(j){

        entidades = j;
      });

      _this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
      .parent('.form-group').addClass('has-feedback');

      var feedback_icon = _this.next('.bs-autocomplete-feedback');
      feedback_icon.hide();

      _this.autocomplete({
        minLength: 2,
        autoFocus: true,

        source: function(request, response) {
          var _regexp = new RegExp(request.term, 'i');
          var data = entidades.filter(function(item) {
            return item.nm_cliente.match(_regexp);
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