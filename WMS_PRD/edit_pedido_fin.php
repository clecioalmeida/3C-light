<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:index.php");
  exit;

}else{

  $id=$_SESSION["id"];
  $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST["dtl_ped"];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

$query_emissor="select nm_cliente from tb_cliente where cod_cliente = '$id'";
$res_emissor = mysqli_query($link,$query_emissor);
while($dados=mysqli_fetch_assoc($res_emissor)){
  $emissor=$dados['nm_cliente'];
}

$select_pedido = "select t1.*, date(t1.dt_limite) as data_limite, date(t1.dt_pedido) as dt_pedido, date(t1.dt_separa) as dt_separa, t1.ds_tipo, t1.ds_frete,t8.ds_nome as ds_almox
from tb_pedido_coleta t1
left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido
left join tb_funcionario t8 on t1.cod_almox = t8.nr_matricula
where t1.nr_pedido = '$nr_pedido'";
$res_pedido = mysqli_query($link,$select_pedido);
while($dados_pedido=mysqli_fetch_assoc($res_pedido)){
  $dt_limite      = $dados_pedido["data_limite"];
  $hr_limite      = $dados_pedido["hr_limite"];
  $pedido         = $dados_pedido["nr_pedido"];
  $fl_status      = $dados_pedido["fl_status"];
  $nm_usuario     = $dados_pedido["nm_usuario"];
  $nm_solicitante = $dados_pedido["nm_solicitante"];
  $cod_almox      = $dados_pedido["cod_almox"];
  $ds_destino     = $dados_pedido["cod_almox"]."-".$dados_pedido["ds_almox"];
  $doc_material   = $dados_pedido["doc_material"];
  $nr_ped_sap     = $dados_pedido["nr_ped_sap"];
  $ds_obs_sac     = $dados_pedido["ds_obs_sac"];
  $dt_pedido      = $dados_pedido["dt_pedido"];
  $dt_separa      = $dados_pedido["dt_separa"];
  $ds_tipo        = $dados_pedido["ds_tipo"];
  $ds_frete       = $dados_pedido["ds_frete"];
}

$link->close();
?>
<!--script src="js/autocomplete.js"></script-->
<hr>
<legend>PEDIDO No. <?php echo $nr_pedido;?>
<span id="retColOk" style="display: none;background-color: #98FB98;font-size: 20px;margin-left: 50px"></span>
<button type="submit" id="btnCadNfSaida" class="btn btn-success" value="<?php echo $nr_pedido; ?>" data-st="<?php echo $fl_status;?>" style="float: right;margin-top: -10px;width: 200px">INSERIR DEM</button>
<button type="submit" id="btnEndSep" class="btn btn-default" value="<?php echo $nr_pedido; ?>" data-st="<?php echo $fl_status;?>" disabled style="float: right;margin-top: -10px;width: 200px">FINALIZAR SEPARAÇÃO</button>
<button type="submit" id="btnColPed" class="btn btn-primary" value="<?php echo $nr_pedido;?>" disabled style="float: right;margin-top: -10px;width: 150px">LIBERAR COLETA</button>
<button type="submit" class="btn btn-success" id="btnUpdPedido" value="<?php echo $nr_pedido;?>" disabled style="float: right;margin-top: -10px;width: 100px">SALVAR</button>
</legend>
<form method="POST" action="" id="formUpdPedido">
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">DESTINO</label>
        <div class="col-md-3">       
          <div class="input-group input-group-md">
            <input class="form-control" id="ds_almox" name="ds_almox" value="<?php echo $ds_destino;?>" placeholder="Digite o código do destino" type="text">
            <input class="form-control" id="cod_almox" name="cod_almox" value="<?php echo $cod_almox;?>" type="hidden" readonly>
            <input class="form-control" id="nr_pedido" name="nr_pedido" value="<?php echo $nr_pedido;?>" type="hidden">
            <span class="input-group-btn">
              <button class="btn btn-info" type="button" id="btnConsPedAlmox" style="height: 32px"><span class="fa fa-search" title data-original-title="Consultar destino"></span></button>
            </span>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">DOC. MATERIAL</label>
        <div class="col-md-2"> 
          <input class="form-control" id="doc_material" name="doc_material" value="<?php echo $doc_material;?>" type="text">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">PEDIDO SAP</label>
        <div class="col-md-2"> 
          <input class="form-control" id="nr_ped_sap" name="nr_ped_sap" value="<?php echo $nr_ped_sap;?>" type="text">
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
            <option value="<?php echo $ds_tipo;?>"><?php echo $ds_tipo;?></option>
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
            <option value="<?php echo $ds_frete;?>"><?php echo $ds_frete;?></option>
            <option value="ENTREGA">ENTREGA</option>
            <option value="RETIRA">RETIRA</option>
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
        <label for="nm_expedidor" class="control-label col-sm-1">DATA PEDIDO</label>
        <div class="col-md-2">      
         <input type="date" class="form-control" id="d_pedido" name="d_pedido" value="<?php echo $dt_pedido;?>">
       </div>
     </div>
   </section>
   <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">DATA SEPARAÇÃO</label>
      <div class="col-md-2">      
       <input type="date" class="form-control" id="d_separa" name="d_separa" value="<?php echo $dt_separa;?>">
     </div>
   </div>
 </section>
 <section>
  <div class="form-group">
    <label for="nm_expedidor" class="control-label col-sm-1">DATA LIMITE</label>
    <div class="col-md-2">      
     <input type="date" class="form-control" id="d_limite" name="d_limite" value="<?php echo $dt_limite;?>">
   </div>
 </div>
</section>
<section>
  <div class="form-group">
    <label for="nm_expedidor" class="control-label col-sm-1">HORA LIMITE</label>
    <div class="col-md-1"> 
      <input type="time" class="form-control hora" id="h_limite" name="h_limite" value="<?php echo $hr_limite;?>" required="true">
    </div>
  </div>
</section>
</fieldset>
<fieldset>
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">OBSERVAÇÕES</label>
      <div class="col-md-6">
        <textarea type="text" class="form-control" id="ds_obs_sac" name="ds_obs_sac" value="<?php echo $ds_obs_sac;?>" rows="5"><?php echo $ds_obs_sac;?></textarea>
      </div>
    </div>
  </section>
</fieldset>
</form>
<br><br><br>
<div class="row" id="cadNfSaida">
  <article class="col-sm-12 col-md-12 col-lg-12">
    <div class="jarviswidget well" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
      <div>
        <div class="widget-body">
          <hr class="simple">
          <ul id="myTab2" class="nav nav-tabs bordered">
            <li class="active">
              <a href="#t1" id="liRecPed" data-id="<?php echo $nr_pedido;?>" data-toggle="tab">PRODUTOS <span class="badge bg-color-blue txt-color-white"></span></a>
            </li>
            <li>
              <a href="#t2" id="liPedEnd" data-toggle="tab">SEPARAÇÃO</a>
            </li>
            <li>
              <a href="#t4" id="liPedConf" data-ped="<?php echo $nr_pedido;?>" data-toggle="tab">CONFERÊNCIA</a>
            </li>
            <li>
              <a href="#t3" id="liPedInfo" data-ped="<?php echo $nr_pedido;?>" data-toggle="tab">INFO</a>
            </li>
            <li>
              <a href="#t5" id="liPedComp" data-ped="<?php echo $nr_pedido;?>" data-toggle="tab">COMPLEMENTO</a>
            </li>
            <li class="pull-right">
              <div>
                <ul id="sparks" class="">
                  <li class="sparks-info">
                    <h5>TOTAL PEDIDO <span class="txt-color-blue" id="tot_pedido" style="text-align: right;"></span>
                    </h5>
                  </li>
                  <li class="sparks-info">
                    <h5>TOTAL COLETADO <span class="txt-color-blue" id="tot_col" style="text-align: right;"></span>
                    </h5>
                  </li>
                  <li class="sparks-info">
                    <h5>COLETA PENDENTE<span class="txt-color-purple" id="tot_pend" style="text-align: right;"></span>
                    </h5>
                    <li class="sparks-info">
                      <h5>TOTAL CONFERIDO <span class="txt-color-purple" id="tot_conf" style="text-align: right;"></span>
                      </h5>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
            <div id="myTabContent2" class="tab-content padding-10">
              <div class="tab-pane fade in active" id="t1">
                <article>
                  <div>
                    <form class="form-horizontal" method="post" action="data/movimento/relatorio/list_etq_exp_all.php" id="" target="_blank">
                      <label class="input">PRODUTOS
                        <input type="text" class="input-xs" id="cod_prd" name="cod_prd" style="color: black">
                      </label>
                      <span> | </span>
                      <button type="submit" id="btnPesqPrdPed" class="btn btn-primary btn-xs" value="<?php echo $nr_pedido;?>" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                      <input type="hidden" class="input-xs" id="nr_ped" name="nr_ped" value="<?php echo $nr_pedido;?>" style="color: black">
                      <button type="submit" id="btnPrintEtqPrdExpAll" class="btn btn-success btn-xs" style="margin-right: 3px;width: 150px">IMPRIIR ETIQUETAS</button>
                    </form>
                  </div>
                </article>
                <article>
                  <div id="retornoPedDtl"></div>
                  <div id="retRomaneio"></div>
                  <div id="retModalPedDtl"></div>
                </article>
              </div>
              <div class="tab-pane fade" id="t2">
                <article>
                  <div>
                    <form class="form-horizontal" method="post" action="" id="form_end">
                      <label class="input">PRODUTOS
                        <input type="text" class="input-xs" id="nr_nf" name="nr_nf" style="color: black">
                      </label>
                      <span> | </span>
                      <button type="submit" id="" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                    </form>
                  </div>
                </article>
                <article>                                            
                  <div id="retornoPedConf"></div>
                </article>
              </div>
              <div class="tab-pane fade" id="t4">
                <article>
                  <div>
                    <form class="form-horizontal" method="post" action="" id="form_conf">
                      <label class="input">CONSULTAR PRODUTO
                        <input type="text" class="input-xs" id="nm_prod" name="nm_prod" style="color: black">
                      </label>
                      <span> | </span>
                      <button type="button" class="btn btn-info btn-xs" id="btnConsDivConf" value="<?php echo $nr_pedido;?>" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                    </form>
                  </div>
                </article>
                <article>                                            
                  <div id="retornoConfPed"></div>
                </article>
              </div>
              <div class="tab-pane fade" id="t3">
                <article>
                  <div>
                    <form class="form-horizontal" method="post" action="" id="form_conf">
                      <label class="input">CONSULTAR PRODUTO
                        <input type="text" class="input-xs" id="nm_prod" name="nm_prod" style="color: black">
                      </label>
                      <span> | </span>
                      <button type="button" class="btn btn-info btn-xs" id="btnConsDivConf" value="<?php echo $nr_pedido;?>" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                    </form>
                  </div>
                </article>
                <article>                                            
                  <div id="retornoConfInfo"></div>
                </article>
              </div>
              <div class="tab-pane fade" id="t5">
                <article>
                  <h5>Novo produto
                    <span id="retSldPrd" style="display: none"></span>
                    <input type="hidden" id="prd_pedido" name="prd_pedido" value="<?php echo $nr_pedido;?>">
                  </h5><br>
                  <div id="novoProduto">
                    <form method="POST" action="" id="formCadPrdPedido">
                      <fieldset>
                        <section>
                          <div class="form-group">
                            <label for="nm_expedidor" class="control-label col-sm-1">CÓD.SAP</label>
                            <div class="col-md-2">
                              <input type="text" id="prod_cliente" name="prod_cliente" class="form-control">
                              <input type="hidden" id="vl_saldo" name="vl_saldo" value="" class="form-control">
                            </div>
                          </div>
                        </section>
                        <section>
                          <div class="form-group">
                            <label for="nm_expedidor" class="control-label col-sm-1">DOC MAT. COMPLEMENTO</label>
                            <div class="col-md-2">
                              <input type="text" id="nr_doc_comp" name="nr_doc_comp" class="form-control">
                            </div>
                          </div>
                        </section>
                        <section>
                          <div class="form-group">
                            <label for="nm_expedidor" class="control-label col-sm-1">QTDE</label>
                            <div class="col-md-1">
                              <input type="text" id="prd_qtde" name="prd_qtde" class="form-control">
                            </div>
                          </div>
                        </section>
                        <section>
                          <div class="form-group">
                            <div class="col-md-3">
                              <button type="submit" id="btnConsProdPedido" class="btn btn-info btn-sm" value="" style="width: 200px">CONSULTAR PRODUTO</button>
                            </div>
                          </div>
                        </section>
                      </fieldset>
                      <fieldset>
                        <section>
                          <div class="form-group">
                            <label for="nm_expedidor" class="control-label col-sm-2">RUA</label>
                            <div class="col-md-1">
                              <input type="text" id="ds_rua" name="ds_rua" class="form-control">
                            </div>
                          </div>
                        </section>
                        <section>
                          <div class="form-group">
                            <label for="nm_expedidor" class="control-label col-sm-2">COLUNA</label>
                            <div class="col-md-1">
                              <input type="text" id="ds_coluna" name="ds_coluna" class="form-control">
                            </div>
                          </div>
                        </section>
                        <section>
                          <div class="form-group">
                            <label for="nm_expedidor" class="control-label col-sm-1">ALTURA</label>
                            <div class="col-md-1">
                              <input type="text" id="ds_altura" name="ds_altura" class="form-control">
                            </div>
                          </div>
                        </section>
                        <section>
                          <div class="form-group">
                            <div class="col-md-3">
                              <button type="submit" id="btnInsertPrdPedidoCompl" class="btn btn-primary btn-sm" value="<?php echo $fl_status;?>" style="width: 200px">INCLUIR COMPLEMENTO</button>
                            </div>
                          </div>
                        </section>
                      </fieldset><br><br>
                      <fieldset>
                        <section>
                          <div id="retComplemento"></div>
                        </section>
                      </fieldset>
                    </form>
                    <div id="retNmProduto"></div>
                    <div id="retProduto"></div>
                  </div>                                            
                  <div id="retornoConfInfo"></div>
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
  <div class="portlet-body" id="prdPedido" style="overflow-x: auto">

  </div>
  <div id="res_produto_dtl"></div>
  <div id="res_produto_upd"></div>
</div>
</form>
<script type="text/javascript">
  $(document).ready(function(){
    var nr_ped = $('#nr_ped').val();
    $.ajax
    ({
      url:"data/movimento/resumo_pedido_ind.php",
      dataType:'json',
      data: {nr_ped:nr_ped},
      method:"POST",
      success:function(j)
      {
        for (var i = 0; i < j.length; i++) {

          $('#tot_pedido').text(j[i].tot_pedido);
          $('#tot_col').text(j[i].tot_col);
          $('#tot_pend').text(j[i].tot_pend);
          $('#tot_conf').text(j[i].tot_conf);
        }
      }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){

    $('#retornoPedDtl').load('data/movimento/list_itens_pedido.php?search=',{dtl_ped:'<?php echo $nr_pedido;?>'});

    $('#liRecPed').on('click', function(){
      var dtl_ped = $(this).attr("data-id");
      $('#retornoPedDtl').load('data/movimento/list_itens_pedido.php?search=',{dtl_ped:dtl_ped});
    });

    $('#liPedEnd').on('click', function(){
      $('#retornoPedConf').load('data/movimento/list_end_pedido.php?search=',{dtl_ped:'<?php echo $nr_pedido;?>'});
    });

    $('#liPedInfo').on('click', function(){
      event.preventDefault();
      $('#retornoConfInfo').load('data/movimento/list_conf_pedido.php?search=',{dtl_ped:'<?php echo $nr_pedido;?>'});
    });

    $('#liPedConf').on('click', function(){
      event.preventDefault();
      $('#retornoConfPed').load('data/movimento/list_exp_pedido.php?search=',{dtl_ped:'<?php echo $nr_pedido;?>'});
    });

    $('#btnPesqPrdPed').on('click', function(){
      event.preventDefault();
      $('#retornoPedDtl').load('data/movimento/list_prd_pedido.php?search=',{cod_prd:$('#cod_prd').val(),nr_pedido: $(this).val()});
    });

    $('#btnCadNfSaida').on('click', function(){
      event.preventDefault();
      $('#cadNfSaida').load('data/movimento/cad_nf.php?search=',{nr_pedido: $(this).val()});
    });

    $('#liPedComp').on('click', function(){
      $('#retComplemento').load('data/movimento/list_comp_pedido.php?search=',{dtl_ped:'<?php echo $nr_pedido;?>'});
    });

  });

</script>