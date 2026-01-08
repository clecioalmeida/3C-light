<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id     = $_SESSION["id"];
  $cod_cli    = $_SESSION['cod_cli'];
}
?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$select_tipo = "select distinct(t1.nm_tipo), t1.cod_tipo from tb_tipo t1 left join tb_pedido_coleta t2 on t1.cod_tipo = t2.ds_tipo where t1.ds_tipo = 2";
$res_tipo = mysqli_query($link,$select_tipo);

$select_doca = "select * from tb_doca";
$res_doca = mysqli_query($link,$select_doca);

$select_user = "select nm_cliente from tb_cliente where cod_cliente = '$id'";
$res_user = mysqli_query($link,$select_user);
while ($user=mysqli_fetch_assoc($res_user)) {
  $nm_cliente = $user['nm_cliente'];
}

$link->close();
?>
<script src="js/gera_pedido.js"></script>
<br><br>
<legend>CADASTRAR PEDIDO
  <button type="button" class="btn btn-primary btn-xs" id="btnFormCadPedido" style="float: right;width: 150px">SALVAR</button>
</legend>
<form method="POST" action="" id="formCadPedido">
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">REQUISITANTE</label>
        <div class="col-md-3">       
          <div class="input-group input-group-md">
            <input class="form-control" id="ds_req" name="ds_req" value="" placeholder="Digite o código da matrícula" type="text">
            <input class="form-control" id="nr_matricula" name="nr_matricula" value="<?php //echo $nr_matricula;?>" type="hidden">
            <input class="form-control" id="nr_pedido" name="nr_pedido" value="<?php //echo $nr_pedido;?>" type="hidden">
            <span class="input-group-btn">
              <button class="btn btn-info" type="button" id="btnConsPedReq" style="height: 32px"><span class="fa fa-search" title data-original-title="Consultar destino"></span></button>
            </span>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">REQUISIÇÃO SAP</label>
        <div class="col-md-2"> 
          <input class="form-control" id="nr_ped_sap" name="nr_ped_sap" type="text">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">CENTRO DE CUSTO</label>
        <div class="col-md-2"> 
          <input class="form-control" id="ds_custo" name="ds_custo" type="text">
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">TIPO</label>
        <div class="col-md-3">
          <select class="form-control" id="ds_tipo" name="ds_tipo">
            <option value="NORMAL">NORMAL</option>
            <option value="EMERGENCIAL">EMERGENCIAL</option>
          </select>
        </div>
      </div>      
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">MODAL</label>
        <div class="col-md-2">
          <select class="form-control" id="ds_frete" name="ds_frete">
            <option value="ENTREGA">ENTREGA</option>
            <option value="RETIRA">RETIRA</option>
          </select>
        </div>
      </div>      
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">PRODUTO</label>
        <div class="col-md-2">
          <select class="form-control" id="ds_prd" name="ds_prd">
            <option value="N">NÃO SERIALIZADO</option>
            <option value="S">SERIALIZADO</option>
          </select>
        </div>
      </div>      
    </section>
  </fieldset>
  <fieldset>
    <section>
      <hr>
    </section>
  </fieldset>
  <fieldset>
 <section>
  <div class="form-group">
    <label for="nm_expedidor" class="control-label col-sm-1">DATA LIMITE</label>
    <div class="col-md-2">      
     <input type="date" class="form-control" id="dt_limite" name="dt_limite">
   </div>
 </div>
</section>
<section>
  <div class="form-group">
    <label for="nm_expedidor" class="control-label col-sm-1">HORA LIMITE</label>
    <div class="col-md-1"> 
      <input type="time" class="form-control hora" id="hr_limite" name="hr_limite">
    </div>
  </div>
</section>
   <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">DATA SEPARAÇÃO</label>
      <div class="col-md-2">      
       <input type="date" class="form-control" id="dt_separa" name="dt_separa">
     </div>
   </div>
 </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">DATA PEDIDO</label>
        <div class="col-md-2">      
         <input type="date" class="form-control" id="dt_pedido" name="dt_pedido">
       </div>
     </div>
   </section>
</fieldset>
<fieldset>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">OBSERVAÇÕES</label>
      <div class="col-md-6">
        <textarea type="text" class="form-control" id="ds_obs" name="ds_obs" rows="5"></textarea>
      </div>
    </div>
  </section>
</fieldset>
</form>
<!--script type="text/javascript">
  $(document).ready(function () {


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

      var almox = '';

      $('.bs-autocomplete').each(function() {
        var _this = $(this),
        _data = _this.data(),
        _hidden_field = $('#' + _data.hidden_field_id);

        $.getJSON(_data.source, 
        {
          ajax: 'true'
        }, 
        function(j){

          almox = j;
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
            var data = almox.filter(function(item) {
              return item.ds_almox.match(_regexp);
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

  });
</script-->