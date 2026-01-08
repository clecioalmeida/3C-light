<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:index.php");
  exit;

}else{

  $id=$_SESSION["id"];
}
?>
<?php 
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

$select_pedido = "select t1.*, date(t1.dt_limite) as data_limite, t3.nm_cliente, t6.nm_cliente as nm_emissor, t7.doc_material
from tb_pedido_coleta t1
left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido
left join tb_cliente t3 on t1.id_remetente = t3.cod_cliente
left join tb_cliente t6 on t1.nm_usuario = t6.cod_cliente
left join tb_mb51e t7 on t1.nr_pedido = t7.nr_pedido
where t1.nr_pedido = '$nr_pedido'";
$res_pedido = mysqli_query($link,$select_pedido);
while($dados_pedido=mysqli_fetch_assoc($res_pedido)){
  $ds_modalidade  = $dados_pedido["ds_modalidade"];
  $dt_limite      = $dados_pedido["data_limite"];
  $hr_limite      = $dados_pedido["hr_limite"];
  $pedido         = $dados_pedido["nr_pedido"];
  $fl_status      = $dados_pedido["fl_status"];
  $nm_usuario     = $dados_pedido["nm_usuario"];
  $nm_emissor     = $dados_pedido["nm_emissor"];
  $nm_solicitante = $dados_pedido["nm_solicitante"];
  $id_doca        = $dados_pedido["id_doca"];
  $ds_obs_sac     = $dados_pedido["ds_obs_sac"];
  $cod_almox      = $dados_pedido["cod_almox"];
  $ds_destino     = $dados_pedido["ds_destino"];
  $doc_material   = $dados_pedido["doc_material"];
}

$link->close();
?>
<hr>
<legend>PEDIDO No. <?php echo $nr_pedido;?><span id="retColOk" style="display: none;background-color: #98FB98;font-size: 20px;margin-left: 50px"></span>
<button type="submit" id="btnExpPed" class="btn btn-default" value="<?php echo $nr_pedido; ?>" style="float: right;margin-top: -10px;width: 100px">FINALIZAR</button>
<button type="submit" id="btnColPed" class="btn btn-primary" value="<?php echo $nr_pedido;?>" style="float: right;margin-top: -10px;width: 150px">LIBERAR COLETA</button><button type="submit" class="btn btn-success" id="btnUpdRecebimento" value="<?php echo $nr_pedido;?>" style="float: right;margin-top: -10px;width: 100px">SALVAR</button></legend>
<form method="POST" action="" id="formCadPedido">
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">DESTINO</label>
        <div class="col-md-3">       
          <div class="input-group input-group-md">
            <input class="form-control bs-autocomplete" id="nm_destinatario" value="<?php echo $cod_almox.'-'.$ds_destino;?>" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/recebimento/consulta_entidade.php" data-hidden_field_id="cod_destinatario" data-item_id="cod_cliente" data-item_label="nm_cliente" autocomplete="off">
            <input class="form-control" id="cod_destinatario" name="cod_destinatario" value="" type="hidden" readonly>
            <span class="input-group-btn">
              <button class="btn btn-info" type="button" id="btnInsDestNf" style="height: 32px"><span class="fa fa-plus" title data-original-title="Cadastrar Destinatário"></span></button>
              <button class="btn btn-primary" type="button" id="btnUpdDestNf" name="btnUpdDestCte" style="height: 32px"><span class="fa fa-pencil" title data-original-title="Editar Destinatário"></span></button>
            </span>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">DOC. MATERIAL</label>
        <div class="col-md-2"> 
          <input class="form-control" id="cod_destinatario" name="cod_destinatario" value="<?php echo $doc_material;?>" type="text">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">DOCA</label>
        <div class="col-md-2"> 
          <select class="form-control" id="ds_doca" name="ds_doca" required="true">
            <option value="<?php echo $id_doca;?>"><?php echo $ds_doca."-".$fl_tipo;?></option>
            <?php
            while ($dados_doca=mysqli_fetch_assoc($res_doca)) {?>

              <option value="<?php echo $dados_doca['id']; ?>"><?php echo $dados_doca['ds_doca']."-".$dados_doca['fl_tipo']; ?></option>

            <?php } ?>
          </select>
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
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
  <section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">OBSERVAÇÕES</label>
      <div class="col-md-4">
        <textarea type="text" class="form-control" id="ds_obs_sac" name="ds_obs_sac" value="<?php echo $ds_obs_sac;?>" rows="5"><?php echo $ds_obs_sac;?></textarea>
      </div>
    </div>
  </section>
</fieldset>
<br>
<legend>Produtos</legend>
<h5>Novo produto
  <span id="retSldPrd" style="display: none"></span>
  <input type="hidden" id="prd_pedido" name="prd_pedido" value="<?php echo $nr_pedido;?>">
</h5><br>
<div id="novoProduto">
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
        <label for="nm_expedidor" class="control-label col-sm-1">PRODUTO</label>
        <div class="col-md-3">       
          <div class="input-group input-group-md">
            <input class="form-control bs-autocomplete" id="nm_produto" value="" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/movimento/consulta_produto.php" data-hidden_field_id="cod_produto" data-item_id="cod_produto" data-item_label="nm_produto" autocomplete="off">
            <input class="form-control" id="cod_produto" name="cod_produto" value="" type="hidden" readonly>
            <span class="input-group-btn">
              <button class="btn btn-info" type="button" id="btnInsDestNf" style="height: 32px"><span class="fa fa-plus" title data-original-title="Cadastrar Destinatário"></span></button>
              <button class="btn btn-primary" type="button" id="btnUpdDestNf" name="btnUpdDestCte" style="height: 32px"><span class="fa fa-pencil" title data-original-title="Editar Destinatário"></span></button>
            </span>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">QTDE</label>
        <div class="col-md-1">
          <input type="btn" id="prd_qtde" name="prd_qtde" class="form-control">
        </div>
      </div>
    </section>
    <section>
      <div class="form-group">
        <div class="col-md-3">
          <button type="submit" id="btnConsProdPedido" class="btn btn-info btn-sm" value="" style="width: 150px">CONSULTAR PRODUTO</button>
          <button type="submit" id="btnInsertPrdPedidoDtl" class="btn btn-primary btn-sm" value="" style="width: 150px">INCLUIR PRODUTO</button>
        </div>
      </div>
    </section>
  </fieldset>
</form>
<div id="retNmProduto"></div>
<div id="retProduto"></div>
</div><br><br><div class="row">
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
              <a href="#t2" id="liPedEnd" data-toggle="tab">ENDEREÇOS</a>
            </li>
            <li>
              <a href="#t3" id="liPedConf" data-toggle="tab">CONFERÊNCIA</a>
            </li>
          </ul>
          <div id="myTabContent2" class="tab-content padding-10">
            <div class="tab-pane fade in active" id="t1">
              <article>
                <div>
                  <form class="form-horizontal" method="post" action="" id="">
                    <label class="input">PRODUTOS
                      <input type="text" class="input-xs" id="nr_nf" name="nr_nf" style="color: black">
                    </label>
                    <span> | </span>
                    <button type="submit" id="btnPesqNfRec" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">CONSULTAR</button>
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
                  <form class="form-horizontal" method="post" action="" id="">
                    <label class="input">PRODUTOS
                      <input type="text" class="input-xs" id="nr_nf" name="nr_nf" style="color: black">
                    </label>
                    <span> | </span>
                    <button type="submit" id="btnPesqNfRec" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                  </form>
                </div>
              </article>
              <article>                                            
                <div id="retornoPedConf"></div>
              </article>
            </div>
            <div class="tab-pane fade" id="t3">
              <article>
                <div>
                  <form class="form-horizontal" method="post" action="" id="">
                    <label class="input">CONSULTAR PRODUTO
                      <input type="text" class="input-xs" id="nm_prod" name="nm_prod" style="color: black">
                    </label>
                    <span> | </span>
                    <button type="button" class="btn btn-info btn-xs" id="btnConsProdRec" value="<?php echo $id_rec;?>" style="margin-right: 3px;width: 150px">CONSULTAR</button>
                  </form>
                </div>
              </article>
              <article>                                            
                <div id="retornoEndPrd"></div>
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

    $('#retornoPedDtl').load('data/movimento/list_itens_pedido.php?search=',{dtl_ped:'<?php echo $nr_pedido;?>'});

    $( '#liRecPed').on('click', function(){
      $('#retornoPedDtl').load('data/movimento/list_itens_pedido.php?search=',{nr_pedido:'<?php echo $nr_pedido;?>'});
    });

  });
</script>