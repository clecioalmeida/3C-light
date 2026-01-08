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
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'C' and fl_status = 1" or die(mysqli_error($sql));
$select_cliente = mysqli_query($link, $sql);

$sql_usr = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'U' and fl_status = 1" or die(mysqli_error($sql));
$res_usr = mysqli_query($link, $sql_usr);

$sql_fornecedor = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'D' and fl_status = 1" or die(mysqli_error($sql));
$select_fornecedor = mysqli_query($link, $sql_fornecedor);

$sql_tp = "select cod_tipo, nm_tipo from tb_tipo where ds_tipo = 1";
$res_tp = mysqli_query($link, $sql_tp);

$sql_tipo2 = "select t1.* from tb_tipo t1
left join tb_recebimento t2 on t1.cod_tipo = t2.tp_rec
where ds_tipo = 1";
$res_tipo2 = mysqli_query($link, $sql_tipo2);

$sql_jn = "select distinct date_format(dt_janela,'%d/%m/%Y') as janela, dt_janela from tb_janela where fl_status = 'A'and fl_empresa = '$cod_cli' and dt_janela >= '$date' order by dt_janela asc";
$res_jn = mysqli_query($link, $sql_jn);

$sql_veic = "select codigo, descricao from tb_tipo_veiculo order by descricao asc";
$res_veic = mysqli_query($link, $sql_veic);

$link->close();
?>
<br><br>
<legend>AGENDAR RECEBIMENTO
  <button type="button" class="btn btn-primary btn-xs" id="btnInsRecAg" style="float: right;width: 150px">SALVAR</button>
</legend>
<form method="POST" action="" id="checkout-form">
  <fieldset>
    <section>      
      <div class="form-group">
        <label for="dt_prevista" class="control-label col-sm-1">DATAS DISPONÍVEIS</label>
        <div class="col-md-2">
          <select class="form-control" name="dt_ag_disp" id="dt_ag_disp">
            <option>Selecione</option>
            <?php while ($data=mysqli_fetch_assoc($res_jn)) {?>             
              <option value="<?php echo $data['dt_janela']; ?>">
                <?php echo $data['janela']; ?>
                </option> <?php }?>
              </select>
            </div>
          </div>
        </section>
        <section>      
          <div class="form-group">
            <label for="dt_prevista" class="control-label col-sm-1">HORARIOS DISPONÍVEIS</label>
            <div class="col-md-2">
              <select class="form-control" name="hr_ag_disp" id="hr_ag_disp">
                <option>Escolha o horário</option>
              </select>
            </div>
          </div>
        </section>
      </fieldset>
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
              <input type="text" class="form-control" name="nr_insumo" placeholder="Pedido de compra" id="nr_insumo" style="text-align: right;">
            </div>
          </div>
        </section>
      </fieldset>
      <fieldset>
        <section>
          <div class="form-group">
            <label for="nm_expedidor" class="control-label col-sm-1">PESO REVISTO</label>
            <div class="col-md-2">
              <input type="text" class="form-control" name="nr_peso_previsto" placeholder="Peso previsto" id="nr_peso_previsto" style="text-align: right;">
            </div>
          </div>
        </section>
        <section>
          <div class="form-group">
            <label for="nm_expedidor" class="control-label col-sm-1">VOLUME PREVISTO</label>
            <div class="col-md-2">
              <input type="text" class="form-control" name="nr_volume_previsto" placeholder="Volume previsto" id="nr_volume_previsto" style="text-align: right;">
            </div>
          </div>
        </section>
        <section>
          <div class="form-group">
            <label for="nm_expedidor" class="control-label col-sm-1">TIPO DE VOLUME</label>
            <div class="col-md-2">
              <input type="text" class="form-control" name="ds_tipo_vol" placeholder="Tipo de volume" id="ds_tipo_vol" style="text-align: right;">
            </div>
          </div>
        </section>
      </fieldset>
      <fieldset>
        <section>
          <div class="form-group">
            <label for="nm_expedidor" class="control-label col-sm-1">TRANSPORTADOR</label>
            <div class="col-md-2">
              <input type="text" class="form-control" name="nm_transportadora" placeholder="Transportador" id="nm_transportadora">
            </div>
          </div>
        </section>
        <section>
          <div class="form-group">
            <label for="nm_expedidor" class="control-label col-sm-1">PLACA</label>
            <div class="col-md-2">
              <input type="text" class="form-control" name="nm_placa" placeholder="Placa" id="nm_placa">
            </div>
          </div>
        </section>
        <section>
          <div class="form-group">
            <label for="nm_expedidor" class="control-label col-sm-1">MOTORISTA</label>
            <div class="col-md-2">
              <input type="text" class="form-control" name="nm_motorista" placeholder="Motorista" id="nm_motorista">
            </div>
          </div>
        </section>
      </fieldset>
      <fieldset>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">TIPO DE VEÍCULO</label>
          <div class="col-md-2">
            <select class="form-control" id="tp_veiculo" name="tp_veiculo">
              <option value="">NÃO INFORMADO</option>

              <?php while ($data_veic = mysqli_fetch_assoc($res_veic)) {?> 

                <option value="<?php echo $data_veic['codigo']; ?>"><?php echo $data_veic['descricao']; ?></option> 

              <?php }?>
              
            </select>
          </div>
        </div>
      </section>
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
                    <a href="#a1" id="liRecNfeAg" data-toggle="tab">NOTAS FISCAIS <span class="badge bg-color-blue txt-color-white"></span></a>
                  </li>
                  <li>
                    <a href="#a2" id="liRecPrdAg" data-toggle="tab">PRODUTOS</a>
                  </li>
                </ul>
                <div id="myTabContent2" class="tab-content padding-10">
                  <div class="tab-pane fade in active" id="a1">
                    <article>
                      <div>
                        <form class="form-horizontal" method="post" action="" id="">
                          <label class="input">NOTA FISCAL
                            <input type="text" class="input-xs" id="nmForn" name="nmForn" style="color: black">
                          </label>
                          <button type="submit" id="btnPesqNfTransp" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                          <button type="button" class="btn btn-info btn-xs" id="btnNovaNfeAg" value="1" style="margin-right: 3px;width: 150px">CADASTRAR NFE</button>
                          <button type="button" class="btn btn-success btn-xs" id="btnImpXmlAg" style="margin-right: 3px;width: 150px">IMPORTAR XML</button>
                        </form>
                      </div>
                    </article>
                    <article>
                      <div id="retornoNfeAg"></div>
                      <div id="retRomaneioAg"></div>
                    </article>
                  </div>
                  <div class="tab-pane fade" id="a2">
                    <article>
                      <div>
                        <form class="form-horizontal" method="post" action="" id="">
                          <label class="input">PRODUTO
                            <input type="text" class="input-xs" id="nmForn" name="nmPrd" style="color: black">
                          </label>
                          <button type="submit" id="btnPesqPrdRecAg" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                          <button type="button" class="btn btn-info btn-xs" id="btnNovoPrdAg" value="1" style="margin-right: 3px;width: 150px">CADASTRAR PRODUTO</button>
                          <label class="input">NOTA FISCAL

                          </label>
                        </form>
                      </div>
                    </article>
                    <article>                                            
                      <div id="retornoPrdAg"></div>
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
  <!--script>
    $(document).ready(function () {
      $( '#liRecNfe').on('click', function(){
        var id_rec = $('#btnNovaNfe').val();
        $('#retornoNfe').load('data/recebimento/list_recebimento_nf.php?search=',{id_rec:id_rec});
      });
    });
  </script-->