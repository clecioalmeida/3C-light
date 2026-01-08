<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rec = mysqli_real_escape_string($link, $_POST["upd_rec"]);

$SQL = "SELECT t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, t1.dt_recebimento_previsto,  t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, date(t1.dt_recebido) as dt_recebido, t1.usr_create, t1.usr_confere, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.usr_recebe, t1.dt_recebimento_real, t1.usr_autoriza, t1.dt_autoriza, t2.cod_cliente, t2.nm_cliente, t1.nr_insumo
from tb_recebimento_ag t1 
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
where cod_recebimento = '$id_rec'";

$res = mysqli_query($link,$SQL);

while ($dados = mysqli_fetch_assoc($res)) {
  $cod_recebimento          = $dados['cod_recebimento'];
  $nm_user_recebido_por     = $dados['usr_recebe'];
  $dt_recebido              = $dados['dt_recebido'];
  $nm_user_autorizado_por   = $dados['usr_autoriza'];
  $dt_autoriza              = $dados['dt_autoriza'];
  $nm_cliente               = $dados['nm_cliente'];
  $nm_fornecedor            = $dados['nm_fornecedor'];
  $nr_peso_previsto         = $dados['nr_peso_previsto'];
  $dt_recebimento_previsto  = $dados['dt_recebimento_previsto'];
  $nr_volume_previsto       = $dados['nr_volume_previsto'];
  $nm_transportadora        = $dados['nm_transportadora'];
  $nm_motorista             = $dados['nm_motorista'];
  $nm_placa                 = $dados['nm_placa'];
  $dt_recebimento_real      = $dados['dt_recebimento_real'];
  $ds_obs                   = $dados['ds_obs'];
  $nr_insumo                = $dados['nr_insumo'];
  // $tp_recebimento           = $dados['tp_recebimento'];
}

$sql_cli = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'C' and fl_status = 1" or die(mysqli_error($sql_cli));
$select_cliente = mysqli_query($link, $sql_cli);

$sql_conf = "select t1.usr_recebe, t2.cod_cliente, t2.nm_cliente from tb_cliente t2 left join tb_recebimento t1 on t1.usr_recebe = t2.cod_cliente where t1.cod_recebimento = '$id_rec'" or die(mysqli_error($sql_conf));
$res_conf = mysqli_query($link, $sql_conf);

while ($dados_conf = mysqli_fetch_assoc($res_conf)) {
  $usr_rec=$dados_conf['nm_cliente'];
  $usr_cod=$dados_conf['cod_cliente'];
}

$sql_conf_aut = "select t1.nm_user_autorizado_por, t2.cod_cliente, t2.nm_cliente from tb_cliente t2 left join tb_recebimento t1 on t1.nm_user_autorizado_por = t2.cod_cliente where t1.cod_recebimento = '$id_rec'" or die(mysqli_error($sql_conf_aut));
$res_conf_aut = mysqli_query($link, $sql_conf_aut);




$sql_usr = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'U' and fl_status = 1" or die(mysqli_error($sql_usr));
$res_usr = mysqli_query($link, $sql_usr); 

$sql_fornecedor = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'D' and fl_status = 1" or die(mysqli_error($sql_fornecedor));

$select_fornecedor = mysqli_query($link, $sql_fornecedor);

$sql_tipo2 = "select t1.* from tb_tipo t1
left join tb_recebimento t2 on t1.cod_tipo = t2.tp_rec
where ds_tipo = 1";
$res_tipo2 = mysqli_query($link, $sql_tipo2);   
$link->close();
?>
<hr>
<legend>ORDEM DE RECEBIMENTO No. <?php echo $cod_recebimento;?><button type="submit" class="btn btn-success" id="btnUpdRecebimento" value="<?php echo $id_rec;?>" style="float: right;margin-top: -10px;width: 100px">Salvar</button></legend>
<form method="POST" action="" id="formUpdRec">
<fieldset>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">FORNECEDOR</label>
      <div class="col-md-2">
        <input class="form-control bs-autocomplete_forn" id="nm_fornecedor" name="nm_fornecedor" value="<?php echo $nm_fornecedor;?>" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/recebimento/consulta_fornecedor.php" data-hidden_field_id="id_forn" data-item_id="nm_for" data-item_label="nm_fornecedor" autocomplete="off">
      </div>
    </div>
  </section>
  <!-- <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">TIPO RECEBIMENTO</label>
      <div class="col-md-2">        
        <select class="form-control" name="tp_recebimento" id="tp_recebimento">
          <option value="<?php //echo $tp_recebimento;?>">
            <?php

            // if($tp_recebimento == "N"){

            //   echo "NORMAL";

            // }else{

            //   echo "DIVERGENTE";

            // }

            ?>
            
          </option>
          <option value="N">NORMAL</option>
          <option value="D">DIVERGENTE</option>
        </select>
      </div>
    </div>
  </section> -->
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">PEDIDO</label>
      <div class="col-md-1">
        <input type="text" class="form-control" name="nr_insumo" placeholder="Pedido de compra" id="nr_insumo" value="<?php echo $nr_insumo;?>" style="text-align: right;">
      </div>
    </div>
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">DATA PREVISTA</label>
      <div class="col-md-2">
        <input type="date" class="form-control" name="dt_recebimento_previsto" placeholder="Data prevista" id="dt_recebimento_previsto" value="<?php echo $dt_recebimento_previsto;?>">
      </div>
    </div>
  </section>
</fieldset>
<fieldset>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">PESO REVISTO</label>
      <div class="col-md-2">
        <input type="text" class="form-control" name="nr_peso_previsto" placeholder="Peso previsto" id="nr_peso_previsto" style="text-align: right;" value="<?php echo $nr_peso_previsto;?>">
      </div>
    </div>
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">VOLUME PREVISTO</label>
      <div class="col-md-1">
        <input type="text" class="form-control" name="nr_volume_previsto" placeholder="Volume previsto" id="nr_volume_previsto" value="<?php echo $nr_volume_previsto;?>" style="text-align: right;">
      </div>
    </div>
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">TRANSPORTADOR</label>
      <div class="col-md-2">
        <input type="text" class="form-control" name="nm_transportadora" placeholder="Transportador" id="nm_transportadora" value="<?php echo $nm_transportadora;?>">
      </div>
    </div>
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">PLACA</label>
      <div class="col-md-2">
        <input type="text" class="form-control" name="nm_placa" placeholder="Placa" id="nm_placa" value="<?php echo $nm_placa;?>">
      </div>
    </div>
  </section>
</fieldset>
<fieldset>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">MOTORISTA</label>
      <div class="col-md-2">
        <input type="text" class="form-control" name="nm_motorista" placeholder="Motorista" id="nm_motorista" value="<?php echo $nm_motorista;?>">
      </div>
    </div>
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">DATA REAL</label>
      <div class="col-md-1">
        <input type="date" class="form-control" name="dt_recebimento_real" placeholder="Data real" id="dt_recebimento_real" value="<?php echo $dt_recebimento_real;?>">
      </div>
    </div>
  </section>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">OBSERVAÇÕES</label>
      <div class="col-md-5">
       <textarea class="form-control" placeholder="Observações" name="obs" id="obs" rows="3"><?php echo $ds_obs;?></textarea>
     </div>
   </div>
 </section>
</fieldset><br>
<fieldset>
 <div class="row">
  <article class="col-sm-12 col-md-12 col-lg-12">
    <div class="jarviswidget well" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
      <div>
        <div class="widget-body">
          <hr class="simple">
          <ul id="myTab2" class="nav nav-tabs bordered">
            <li class="active" id="liRecNfe">
              <a href="#t1" id="" data-id="<?php echo $id_rec;?>" data-toggle="tab">NOTAS FISCAIS <span class="badge bg-color-blue txt-color-white"></span></a>
            </li>
            <li id="liRecSap">
              <a href="#t2" data-toggle="tab">PRODUTOS SAP</a>
            </li>
            <li id="liRecNs">
              <a href="#t3" data-toggle="tab">NÚMEROS DE SÉRIE</a>
            </li>
            <li>
              <a href="#t4" id="liRecAlc" data-toggle="tab">PRODUTOS ALOCADOS</a>
            </li>
          </ul>
          <div id="myTabContent2" class="tab-content padding-10">
            <div class="tab-pane fade in active" id="t1">
              <article>
                <div>
                  <form class="form-horizontal" method="post" action="" id="">
                    <label class="input">NOTA FISCAL
                      <input type="text" class="input-xs" id="nr_nf" name="nr_nf" style="color: black">
                    </label>
                    <span> | </span>
                    <button type="submit" id="btnPesqNfRec" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                    <button type="button" class="btn btn-info btn-xs" id="btnNovaNfe" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 150px">CADASTRAR NFE</button>
                    <button type="button" class="btn btn-success btn-xs" id="btnImpXml" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 150px">IMPORTAR XML</button>
                  </form>
                </div>
              </article>
              <article>
                <div id="retornoNfe"></div>
                <div id="retRomaneio"></div>
                <div id="retModal"></div>
              </article>
            </div>
            <div class="tab-pane fade" id="t2">
              <article>
                <div>
                  <form class="form-horizontal" method="post" action="" id="">
                    <label class="input">PEDIDO
                      <input type="text" class="input-xs" id="nr_nf" name="nr_nf" style="color: black">
                    </label>
                    <span> | </span>
                    <button type="submit" id="btnPesqNfRec" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                    <button type="button" class="btn btn-info btn-xs" id="btnNovoNfePrd" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 150px">CADASTRAR PRODUTO</button>
                    <button type="button" class="btn btn-success btn-xs" id="btnImpSap" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 150px">IMPORTAR MB51</button>
                    <button type="button" class="btn btn-primary btn-xs" id="btnGeraSap" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 150px">GERAR RECEBIMENTO</button>
                    <button type="button" class="btn btn-primary btn-xs" id="btnImpNsSap" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 150px">IMPORTA IQ09</button>
                  </form>
                </div>
              </article>
              <article>                                            
                <div id="retornoSap"></div>
              </article>
            </div>
            <div class="tab-pane fade" id="t3">
              <article>
                <div>
                  <form class="form-horizontal" method="post" action="" id="">
                    <label class="input">CONSULTAR NÚMERO DE SÉRIE
                      <input type="text" class="input-xs" id="nm_prod" name="nm_prod" style="color: black">
                    </label>
                    <span> | </span>
                    <button type="button" class="btn btn-info btn-xs" id="btnConsProdRec" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                    <button type="button" class="btn btn-success btn-xs" id="btnNovoOrNs" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 200px">CADASTRAR NÚMERO DE SÉRIE</button>
                  </form>
                </div>
              </article>
              <article>                                            
                <div id="retornoNs"></div>
              </article>
            </div>
            <div class="tab-pane fade" id="t4">
              <article>
                <div>
                  <form class="form-horizontal" method="post" action="" id="">
                  </form>
                </div>
              </article>
              <article>                                            
                <div id="retornoAloc"></div>
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
<script type="text/javascript">
  $(document).ready(function(){

    $('#retornoNfe').load('data/recebimento/list_rec_nfe.php?search=',{nf_rec:'<?php echo $id_rec;?>'});

    $('#liRecNfe').on('click', function(){
      $('#retornoNfe').load('data/recebimento/list_rec_nfe.php?search=',{nf_rec:'<?php echo $id_rec;?>'});
    });

    $('#liRecNs').on('click', function(){
      $('#retornoNs').load('data/recebimento/list_ns_prd.php?search=',{id_rec:'<?php echo $id_rec;?>'});
    });

    $('#liRecSap').on('click', function(){
      $('#retornoSap').load('data/recebimento/list_rec_sap.php?search=',{id_rec:'<?php echo $id_rec;?>'});
    });

    $( '#liRecAlc').on('click', function(){
      $('#retornoAloc').load('data/recebimento/list_rec_aloc.php?search=',{id_rec:'<?php echo $id_rec;?>'});
    });

  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#btnPesqNfRec').on('click',function(){
      var nr_nf  = $('#nr_nf').val();

      if(nr_nf == ''){

        alert("Digite o número da nota fiscal que deseja pesquisar.");

      }else{

        $.ajax
        ({
          url:"data/recebimento/list_rec_nrnfe.php",
          method:"POST",
          data:{
            nr_nf:nr_nf
          },
          success:function(data)
          {
            $('#retornoNfe').html(data);
          }
        });

      }

    });

  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#btnConsProdRec').on('click',function(){
      var id_rec  = '<?php echo $id_rec;?>';
      var nm_prod = $('#nm_prod').val();

      if(nr_nf == ''){

        alert("Digite o número da nota fiscal que deseja pesquisar.");

      }else{

        $.ajax
        ({
          url:"data/recebimento/list_rec_prd_nm.php",
          method:"POST",
          data:{
            id_rec:id_rec,
            nm_prod:nm_prod
          },
          success:function(data)
          {
            $('#retornoPrd').html(data);
          }
        });

      }

    });

  });
</script>