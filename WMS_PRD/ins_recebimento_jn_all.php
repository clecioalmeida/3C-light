<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:../index.php");
  exit;

} else {

  $id       = $_SESSION["id"];
  $cod_cli  = $_SESSION['cod_cli'];
}
?>
<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_recebimento = $_POST['ins_rec_all'];

/*$SQL = "select t1.nm_fornecedor, t1.nr_peso_previsto, t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.pedido, t1.ds_tipo_vol
from tb_recebimento_ag t1 
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
left join tb_janela t3 on t1.cod_recebimento = t3.cod_rec
where t1.cod_recebimento = '$cod_recebimento'";
$res = mysqli_query($link,$SQL);

$dados = mysqli_fetch_assoc($res);

$nm_fornecedor            = $dados['nm_fornecedor'];
$nr_peso_previsto         = $dados['nr_peso_previsto'];
$nr_volume_previsto       = $dados['nr_volume_previsto'];
$nm_transportadora        = $dados['nm_transportadora'];
$nm_motorista             = $dados['nm_motorista'];
$nm_placa                 = $dados['nm_placa'];
$pedido                   = $dados['pedido'];
$ds_tipo_vol              = $dados['ds_tipo_vol'];*/


$link->close();
?>
<br><br>
<legend>CADASTRAR ORDEM DE RECEBIMENTO
  <button type="button" class="btn btn-primary btn-xs" id="btnInsRecJnAll" value="<?php echo $cod_recebimento;?>" style="float: right;width: 150px">SALVAR</button>
</legend>
<form method="POST" action="" id="checkout-form">
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">FORNECEDOR</label>
        <div class="col-md-5">
          <input class="form-control" id="nm_fornecedor" value="" placeholder="Fornecedor" type="text">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">PEDIDO</label>
        <div class="col-md-2">
          <input type="text" class="form-control" name="nr_insumo" value="" placeholder="Pedido de compra" id="nr_insumo" style="text-align: right;">
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">PESO REVISTO</label>
        <div class="col-md-2">
          <input type="text" class="form-control" name="nr_peso_previsto" value="" placeholder="Peso previsto" id="nr_peso_previsto" style="text-align: right;">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">VOLUME PREVISTO</label>
        <div class="col-md-2">
          <input type="text" class="form-control" name="nr_volume_previsto" value="" placeholder="Volume previsto" id="nr_volume_previsto" style="text-align: right;">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">TIPO DE VOLUME</label>
        <div class="col-md-2">
          <input type="text" class="form-control" name="ds_tipo_vol" value="" placeholder="Tipo de volume" id="ds_tipo_vol" style="text-align: right;">
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">TRANSPORTADOR</label>
        <div class="col-md-2">
          <input type="text" class="form-control" name="nm_transportadora" value="" placeholder="Transportador" id="nm_transportadora">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">PLACA</label>
        <div class="col-md-2">
          <input type="text" class="form-control" name="nm_placa" value="" placeholder="Placa" id="nm_placa">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">MOTORISTA</label>
        <div class="col-md-2">
          <input type="text" class="form-control" name="nm_motorista" value="" placeholder="Motorista" id="nm_motorista">
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">DATA REAL</label>
        <div class="col-md-2">
          <input type="date" class="form-control" name="dt_recebimento_real" placeholder="Data real" id="dt_recebimento_real">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">TIPO RECEBIMENTO</label>
        <div class="col-md-2">        
          <select class="form-control" name="tp_recebimento" id="tp_recebimento">
            <option value="N">NORMAL</option>
            <option value="D">DIVERGENTE</option>
          </select>
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">OBSERVAÇÕES</label>
        <div class="col-md-5">
         <textarea class="form-control" placeholder="Observações" name="obs" id="obs" rows="3"></textarea>
       </div>
     </div>
   </section>
 </fieldset><br>
 <fieldset id="cad_nfe" style="display: none">
   <div class="row">
    <article class="col-sm-12 col-md-12 col-lg-12">
      <div class="jarviswidget well" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
        <div>
          <div class="widget-body">
            <hr class="simple">
            <ul id="myTab2" class="nav nav-tabs bordered">
              <li class="active">
                <a href="#t1" id="liRecNfe" data-toggle="tab">NOTAS FISCAIS <span class="badge bg-color-blue txt-color-white"></span></a>
              </li>
              <li>
                <a href="#t2" id="liRecPrd" data-toggle="tab">PRODUTOS</a>
              </li>
            </ul>
            <div id="myTabContent2" class="tab-content padding-10">
              <div class="tab-pane fade in active" id="t1">
                <article>
                  <div>
                    <form class="form-horizontal" method="post" action="" id="">
                      <label class="input">NOTA FISCAL
                        <input type="text" class="input-xs" id="nmForn" name="nmForn" style="color: black">
                      </label>
                      <button type="submit" id="btnPesqNfTransp" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                      <button type="button" class="btn btn-info btn-xs" id="btnNovaNfe" value="1" style="margin-right: 3px;width: 150px">CADASTRAR NFE</button>
                      <button type="button" class="btn btn-success btn-xs" id="btnImpXml" style="margin-right: 3px;width: 150px">IMPORTAR XML</button>
                    </form>
                  </div>
                </article>
                <article>
                  <div id="retornoNfe"></div>
                  <div id="retRomaneio"></div>
                </article>
              </div>
              <div class="tab-pane fade" id="t2">
                <article>
                  <div>
                    <form class="form-horizontal" method="post" action="" id="">
                      <label class="input">PRODUTO
                        <input type="text" class="input-xs" id="nmForn" name="nmPrd" style="color: black">
                      </label>
                      <button type="submit" id="btnPesqPrdRec" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                      <button type="button" class="btn btn-info btn-xs" id="btnNovoPrd" value="1" style="margin-right: 3px;width: 150px">CADASTRAR PRODUTO</button>
                      <label class="input">NOTA FISCAL

                      </label>
                    </form>
                  </div>
                </article>
                <article>                                            
                  <div id="retornoPrd"></div>
                </article>
              </div>
            </div>
          </div>
        </div>
      </div>
    </article>
  </div>
  <div class="row">
    <div id="retModalEntrega">
    </div>
  </div>
</fieldset>
</form>
<script>
  $(document).ready(function () {
    $( '#liRecNfe').on('click', function(){
      var id_rec = $('#btnNovaNfe').val();
      $('#retornoNfe').load('data/recebimento/list_recebimento_nf.php?search=',{id_rec:id_rec});
    });
  });
</script>