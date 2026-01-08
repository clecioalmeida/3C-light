 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $link->close();
 ?>
 <div class="modal fade" id="recIndCron" aria-hidden="true">
   <form method="post" action="" id="formNovoRec">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #22262E;">
          <h5 class="modal-title" style="color: white"></h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body modal-lg" style="overflow-y: auto">
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="produto">PERÍODO</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="ds_mes" placeholder="Mês (mm)" required="true">
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="ds_ano" placeholder="Ano (aaaa)" required="true">
                </div>
              </div>
            </section>
          </fieldset>
          <hr>
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">QTDE SKU TOTAL</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nr_sku_qtde" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">QTDE SKU SOBRA</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nr_sku_sobra" style="text-align: right;"  required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">QTDE SKU FALTA</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nr_sku_falta" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
          </fieldset>
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">ACUR SKU</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nr_ac_sku" style="text-align: right;" disabled>
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>            
          </fieldset>
          <hr>
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">VLR INICIAL</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_ini" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">VLR SOBRA</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_sobra" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">VLR FALTA</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_falta" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
          </fieldset>
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">VLR FINAL</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_fim" style="text-align: right;" disabled>
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">VLR DIVERGÊNCIA</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_div" style="text-align: right;" disabled>
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnSaveInvAc" value="<?php echo $upd_rec;?>">SALVAR</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    $('#recIndCron').modal('show');

    $(document).on('change','#nr_sku_falta', function(){

      if($('#nr_sku_qtde').val() == '' || $('#nr_sku_sobra').val() == '' || $('#nr_sku_falta').val() == ''){

        alert("Por favor preencha todos os valores.");

      }else{

        var qtd = $('#nr_sku_qtde').val() - $('#nr_sku_sobra').val() - $('#nr_sku_falta').val();
        var perc_qtd = (qtd / $('#nr_sku_qtde').val())*100;
        var acur_qtd = parseFloat(perc_qtd).toFixed(2);
        console.log(acur_qtd);
        $('#nr_ac_sku').val(acur_qtd);

      }

    });

    $('#vlr_ini').on('change', function(){

      var vlr_ini = parseFloat($('#vlr_ini').val());
      var vlr_ini2 = vlr_ini.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
      $('#vlr_ini').val(vlr_ini2);
      console.log(vlr_ini2);
      console.log(vlr_ini);

    });

    $('#vlr_sobra').on('change',function(){

      var vlr_sobra = parseFloat($('#vlr_sobra').val());
      var vlr_sobra2 = vlr_sobra.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
      $('#vlr_sobra').val(vlr_sobra2);
      console.log(vlr_sobra2);
      console.log(vlr_sobra);

    });

    $('#vlr_falta').on('change', function(){

      var vlr_falta = parseFloat($('#vlr_falta').val());
      var vlr_falta2 = vlr_falta.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
      $('#vlr_falta').val(vlr_falta2);
      console.log(vlr_falta2);
      console.log(vlr_falta);

      if($('#vlr_ini').val() == '' || $('#vlr_sobra').val() == '' || $('#vlr_falta').val() == ''){

        alert("Por favor preencha todos os valores.");

      }else{

        var vlr_ini3 = $('#vlr_ini').val().substring(3).replace('.','').replace('.','').replace(',','.');
        var vlr_sobra3 = $('#vlr_sobra').val().substring(3).replace('.','').replace('.','').replace(',','.');
        var vlr_falta3 = $('#vlr_falta').val().substring(3).replace('.','').replace('.','').replace(',','.');

        var vlr = (parseFloat(vlr_ini3) - parseFloat(vlr_sobra3)) + parseFloat(vlr_falta3);
        var perc_vlr = (vlr / parseFloat(vlr_ini3))*100;
        var acur_vlr = perc_vlr.toFixed(3);
        var vlr2 = vlr.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
        $('#vlr_fim').val(vlr2);
        $('#vlr_div').val(acur_vlr);
        
      }
    });

  });
</script>