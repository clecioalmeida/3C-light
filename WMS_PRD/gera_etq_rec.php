<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rec = mysqli_real_escape_string($link, $_POST["id_rec"]);

$SQL = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, t1.dt_recebimento_previsto,  t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, date(t1.dt_recebido) as dt_recebido, t1.usr_create, t1.usr_confere, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.usr_recebe, t1.dt_recebimento_real, t1.usr_autoriza, t1.dt_autoriza, t2.cod_cliente, t2.nm_cliente, t1.nr_insumo, t3.cod_nf_entrada
from tb_recebimento t1 
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
left join tb_nf_entrada t3 on t1.cod_recebimento = t3.cod_rec
where cod_recebimento = '$id_rec'";
$res = mysqli_query($link,$SQL);

while ($dados = mysqli_fetch_assoc($res)) {
  $cod_recebimento          = $dados['cod_recebimento'];
  $nm_user_recebido_por     = $dados['usr_recebe'];
  $dt_recebido              = $dados['dt_recebido'];
  $nm_user_autorizado_por   = $dados['usr_autoriza'];
  $dt_autoriza              = $dados['dt_autoriza'];
  $nm_cliente               = $dados['nm_cliente'];
  $cod_recebimento          = $dados['cod_recebimento'];
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
  $cod_nf_entrada           = $dados['cod_nf_entrada'];
}


$link->close();
?>
<hr>
<legend>ORDEM DE RECEBIMENTO No. <?php echo $cod_recebimento;?><button type="submit" class="btn btn-success" id="btnUpdRecebimento" value="<?php echo $id_rec;?>" style="float: right;margin-top: -10px;width: 100px">Salvar</button></legend>
<form method="POST" action="" id="formUpdRec">
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">FORNECEDOR</label>
        <div class="col-md-4">
          <input class="form-control bs-autocomplete_forn" id="nm_fornecedor" name="nm_fornecedor" value="<?php echo $nm_fornecedor;?>" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/recebimento/consulta_fornecedor.php" data-hidden_field_id="id_forn" data-item_id="nm_for" data-item_label="nm_fornecedor" autocomplete="off">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">PEDIDO</label>
        <div class="col-md-2">
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
                <a href="#t1" data-id="<?php echo $id_rec;?>" data-toggle="tab">NOTAS FISCAIS <span class="badge bg-color-blue txt-color-white"></span></a>
              </li>
              <li id="liRecEtqProd">
                <a href="#t3" data-id="<?php echo $id_rec;?>" data-toggle="tab">ETIQUETAS POR PRODUTO</a>
              </li>
              <li id="liRecPrdEtq" data-id="<?php echo $id_rec;?>">
                <a href="#t2" data-toggle="tab">ETIQUETAS</a>
              </li>
            </ul>
            <div id="myTabContent2" class="tab-content padding-10">
              <div class="tab-pane fade in active" id="t1">
                <article>
                  <div>
                    <form class="form-horizontal" method="post" action="" id="">
                      <button type="submit" id="btnGeraEtqRec" class="btn btn-primary btn-xs" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 150px">GERAR ETIQUETAS</button>
                    </form>
                  </div>
                </article>
                <article>
                  <div id="retornoNfe"></div>
                  <div id="retRomaneio"></div>
                  <div id="retModal"></div>
                </article>
              </div>
              <div class="tab-pane fade" id="t3">
                <article>
                  <div>
                    <form class="form-horizontal" method="post" action="" id="">
                      <button type="submit" id="btnGeraEtqRecPrd" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px" disabled>GERAR ETIQUETAS</button>
                      </form>
                    </form>
                  </div>
                </article>
                <article>                                            
                  <div id="retornoEtqPrd"></div>
                </article>
              </div>
              <div class="tab-pane fade" id="t2">
                <article>
                  <div>
                    <form class="form-horizontal" method="post" action="data/recebimento/relatorio/list_etq_rec_all.php" id="" target="_blank">
                      <label class="input">CONSULTAR PRODUTO
                        <input type="text" class="input-xs" id="nm_prod" name="nm_prod" style="color: black">
                        <input type="hidden" class="input-xs" id="id_rec" name="id_rec" value="<?php echo $id_rec;?>" style="color: black">
                      </label>
                      <span> | </span>
                      <button type="button" class="btn btn-info btn-xs" id="btnConsProdRecEtq" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                      <form class="form-horizontal" method="post" action="data/recebimento/relatorio/list_etq_rec_all.php" id="" target="_blank">
                        <input type="hidden" class="input-xs" id="id_rec" name="id_rec" value="<?php echo $id_rec;?>" style="color: black">
                        <button type="submit" id="btnPrintEtqRec" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">IMPRIMIR TODAS</button>
                      </form>
                      </form>
                    </form>
                  </div>
                </article>
                <article>                                            
                  <div id="retornoPrdEtq"></div>
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

    $('#retornoNfe').load('data/recebimento/list_rec_nfe_etq.php?search=',{nf_rec:'<?php echo $id_rec;?>'});

    $( '#liRecNfe').on('click', function(){
      $('#retornoNfe').load('data/recebimento/list_rec_nfe_etq.php?search=',{nf_rec:'<?php echo $id_rec;?>'});
    });

    $(document).on('click', '#liRecPrdEtq',function(){
      $('#retornoPrdEtq').load('data/recebimento/list_rec_prd_etq.php?search=',{id_rec:$(this).attr("data-id")});
    });

    $('#liRecEtqProd').on('click', function(){
      $('#retornoEtqPrd').load('data/recebimento/list_prd_etq_pend.php?search=',{id_rec:'<?php echo $id_rec;?>'});
    });

    $('#btnConsProdRecEtq').on('click', function(){
      $('#retornoPrdEtq').load('data/recebimento/list_rec_prd_etq_item.php?search=',{id_rec:$('#id_rec').val()});
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