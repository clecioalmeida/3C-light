<div class="modal fade" id="novo_usuario" aria-hidden="true">
  <form class="form-horizontal" method="post" action="" id="formCadUsuario">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #22262E;">
          <h5 class="modal-title" id="novo_usuario" style="color: white">Incluir usuario externo</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body modal-lg" style="overflow-y: auto">
          <div class="form-group">
            <label class="col-sm-2" for="u_nome">FORNECEDOR</label>
            <div class="col-md-10">       
              <div class="input-group input-group-md">
                <input class="form-control bs-autocomplete" id="nm_destinatario" value="" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/movimento/consulta_fornecedor.php" data-hidden_field_id="cod_destinatario" data-item_id="cod_cliente" data-item_label="nm_cliente" autocomplete="off">
                <input class="form-control" id="cod_destinatario" name="cod_destinatario" value="" type="hidden" readonly>
                <span class="input-group-btn">
                  <button class="btn btn-info" type="button" id="btnInsDestNf" style="height: 32px"><span class="fa fa-plus" title data-original-title="Cadastrar Destinatário"></span></button>
                  <button class="btn btn-primary" type="button" id="btnUpdDestNf" name="btnUpdDestCte" style="height: 32px"><span class="fa fa-pencil" title data-original-title="Editar Destinatário"></span></button>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="cpf">CNPJ</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="ds_usuario" id="ds_usuario" placeholder="Digite o CNPJ">
              <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="rg">SENHA</label>
            <div class="col-sm-4">
             <input type="text" class="form-control" name="ds_senha" id="ds_senha" placeholder="Digite a senha">
             <div class="form-control-focus"> </div>
           </div>
         </div>
         <div class="form-group">
          <label class="control-label col-sm-2">EMPRESA</label>
          <div class="col-sm-10">
            <input class="form-control bs-autocomplete_cli" id="nm_cliente" value="" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/empresa/consulta_cliente_user.php" data-hidden_field_id="id_cliente" data-hidden_field_cnpj="nr_cnpj" data-item_id="cod_cliente" data-item_cnpj="nr_cnpj_cpf" data-item_label="nm_cliente" autocomplete="off">
            <input class="form-control" id="id_cliente" name="id_cliente" value="" type="hidden">
            <input class="form-control" id="nr_cnpj" name="nr_cnpj" value="" type="hidden">
          </div>
        </div>
      </div>
      <div class="modal-footer" style="background-color: #22262E;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
        <button type="submit" class="btn btn-primary" id="btnCadUsuarioExt">SALVAR</button>
      </div>
    </div>
  </div>
</form>
</div>
<script type="text/javascript">
  $('#novo_usuario').modal('show');
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

    var fornecedor = '';

    $('.bs-autocomplete').each(function() {
      var _this = $(this),
      _data = _this.data(),
      _hidden_field = $('#' + _data.hidden_field_id);

      $.getJSON(_data.source, 
      {
        ajax: 'true'
      }, 
      function(j){

        fornecedor = j;
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
          var data = fornecedor.filter(function(item) {
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
<script type="text/javascript">
  $(document).ready(function () {
    $('#btnCadUsuarioExt').on('click', function(){
      event.preventDefault();
      var ds_nome       = $('#nm_destinatario').val();
      var ds_usuario    = $('#ds_usuario').val();
      var ds_senha      = $('#ds_senha').val();
      var id_emitente   = $('#cod_destinatario').val();
      var nr_cnpj       = $('#nr_cnpj').val();
      $.ajax
      ({
        url:"data/empresa/ins_user_ext.php",
        method:"POST",
        dataType:'json',
        data:{
          ds_nome:ds_nome,
          ds_usuario:ds_usuario,
          ds_senha:ds_senha,
          id_emitente:id_emitente,
          nr_cnpj:nr_cnpj
        },
        success:function(j)
        {
          for (var i = 0; i < j.length; i++) {

            if(j[i].info = "0"){

              alert("Usuário cadastrado com sucesso!");

            }else{

              alert("Usuário Não cadastrado!");
            }
          }
        }
      });
    });
  });
</script>