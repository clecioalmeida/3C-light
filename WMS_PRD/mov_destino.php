<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id = $_SESSION["id"];
  $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_estoque = $_POST['cod_estoque'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$select_estoque = "SELECT t1.produto, t1.nr_qtde, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.ds_projeto, t1.ds_embalagem, t1.nr_or, t1.nr_nf_entrada, t2.cod_produto, t2.nm_produto, t2.cod_prod_cliente, t3.ds_apelido, t1.ds_ano, t1.n_serie, t1.ds_fabr, t1.ds_lp, t1.ds_enr
from tb_posicao_pallet t1 
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente or t1.cod_produto = t2.cod_produto 
left join tb_armazem t3 on t1.ds_galpao = t3.id
where cod_estoque = '$cod_estoque'";
$res_estoque = mysqli_query($link, $select_estoque);
while ($dados_estoque = mysqli_fetch_assoc($res_estoque)) {

  $cod_prod_cliente = $dados_estoque["produto"];
  $nr_qtde          = $dados_estoque["nr_qtde"];
  $nm_produto       = $dados_estoque["nm_produto"];
  $ds_galpao        = $dados_estoque['ds_galpao'];
  $ds_prateleira    = $dados_estoque['ds_prateleira'];
  $ds_coluna        = $dados_estoque['ds_coluna'];
  $ds_altura        = $dados_estoque['ds_altura'];
  $ds_apelido       = $dados_estoque['ds_apelido'];
  $produto          = $dados_estoque['cod_produto'];
  $ds_projeto       = $dados_estoque['ds_projeto'];
  $nr_nf_entrada    = $dados_estoque['nr_nf_entrada'];
  $ds_embalagem     = $dados_estoque['ds_embalagem'];
  $nr_or            = $dados_estoque['nr_or'];
  $ds_ano           = $dados_estoque['ds_ano'];
  $n_serie          = $dados_estoque['n_serie'];
  $ds_fabr          = $dados_estoque['ds_fabr'];
  $ds_lp            = $dados_estoque['ds_lp'];
  $ds_enr           = $dados_estoque['ds_enr'];

}

$select_mov = "select t1.cod_estoque, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_qtde, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.nome
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
left join tb_armazem t3 on t1.ds_galpao = t3.id
where t1.cod_estoque = '$cod_estoque'";
$res_mov = mysqli_query($link, $select_mov);

$sql_galpao = "SELECT distinct id, nome FROM tb_armazem where nome <> 'RECEBIMENTO' and id_oper = '$cod_cli'";
$res_galpao = mysqli_query($link, $sql_galpao);
$link->close();
?>
<hr>
<div>
  <legend>MOVIMENTAÇÃO ENTRE ENDEREÇOS<!--button type="submit" class="btn btn-success" id="btnUpdRecebimento" value="<?php //echo $id_rec;?>" style="float: right;margin-top: -10px;width: 100px">Salvar</button--></legend>
  <form method="POST" action="" id="formUpdRec">
    <fieldset>
      <div class="form-group">
        <label class="col-sm-1 control-label" for="codigo">Código</label>
        <div class="col-sm-2">
          <input type="text" class="form-control"  align="center" id="cod_prod_cliente" name="cod_prod_cliente" value="<?php echo $cod_prod_cliente; ?>" readonly="true">
          <div class="form-control-focus"> </div>
        </div>
        <label class="col-sm-1 control-label" for="descricao">Descrição</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" id="nm_produto" name="nm_produto" value="<?php echo $nm_produto; ?>" readonly="true">
          <div class="form-control-focus"> </div>
        </div>
      </div>
    </fieldset><br>
    <fieldset>
     <div class="form-group">
      <label class="col-sm-1 control-label" for="qtde">Quantidade alocada</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" value="<?php echo number_format($nr_qtde, 0, '.', ''); ?>" align="center" id="nr_qtde_old" name="nr_qtde_old" readonly="true">
        <div class="form-control-focus"> </div>
      </div>
      <label class="col-sm-1 control-label" for="qtde">Local atual</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" value="<?php echo $ds_apelido . $ds_prateleira . $ds_coluna . $ds_altura; ?>" align="center" id="ds_local" name="ds_local" readonly="true">
        <div class="form-control-focus"> </div>
      </div>
      <label class="col-sm-1 control-label" for="qtde">Projeto</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" value="<?php echo $ds_projeto; ?>" align="center" id="ds_projeto" name="ds_projeto" readonly="true">
        <div class="form-control-focus"> </div>
      </div>
    </div>
  </fieldset><br>
<br/>
<form method="post" action="">
  <fieldset>
    <div class="form-group">
      <label class="col-sm-1 control-label" for="alocar">Digite a quantidade que deseja alocar</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="nr_qtde_new" id="nr_qtde_new">
        <input type="hidden" class="form-control" value="<?php echo $nr_or; ?>" name="nr_or" id="nr_or">
        <input type="hidden" class="form-control" value="<?php echo $nr_nf_entrada; ?>" name="nr_nf_entrada" id="nr_nf_entrada">
        <input type="hidden" class="form-control" value="<?php echo $produto; ?>" name="cod_produto" id="cod_produto">
        <input type="hidden" name="cod_estoque" value="<?php echo $cod_estoque; ?>" id="cod_estoque">
        <input type="hidden" name="ds_ano" value="<?php echo $ds_ano; ?>" id="ds_ano">
        <input type="hidden" name="n_serie" value="<?php echo $n_serie; ?>" id="n_serie">
        <input type="hidden" name="ds_fabr" value="<?php echo $ds_fabr; ?>" id="ds_fabr">
        <input type="hidden" name="ds_lp" value="<?php echo $ds_lp; ?>" id="ds_lp">
        <div class="form-control-focus"> </div>
      </div>
    </div>
  </fieldset>
  <fieldset>
    <hr>
    <h5> Escolha o local de armazenagem</h5>
    <div class="form-group">
      <label class="col-sm-1 control-label" for="galpao">Galpão</label>
      <div class="col-sm-2" id="armaz">
        <select class="form-control" name="idGalpaoNew" id="idGalpaoNew">
          <option>Galpão</option>
          <?php
          while ($dados_galpao = mysqli_fetch_assoc($res_galpao)) {?>
            <option value="<?php echo $dados_galpao['id']; ?>">
              <?php echo $dados_galpao['nome']; ?>
              </option> <?php }?>
            </select>
          </div>
          <label class="col-sm-1 control-label" for="rua">Rua</label>
          <div class="col-sm-1" id="rua">
            <select class="form-control" name="idRuaNew" id="idRuaNew">
              <option value=""></option>
            </select><br>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-1 control-label" for="coluna">Coluna</label>
          <div class="col-sm-1" id="coluna">
            <select class="form-control" name="idColNew" id="idColNew">
              <option></option>
            </select>
          </div>
          <label class="col-sm-1 control-label" for="id_altura">Altura</label>
          <div class="col-sm-1" id="altura">
            <select class="form-control" name="idAlturaNew" id="idAlturaNew">
              <option></option>
            </select>
          </div>
        </div>
      </fieldset>
      <hr>
      <fieldset>
        <button type="submit" class="btn btn-primary btn-sm" id="btnFormAlocacao" style="float: left;margin-top: -10px;width: 100px">Salvar</button>
      </fieldset>
      <fieldset id="retTbPrdTransf">

      </fieldset>
    </form>
  </form>
</div>
<script type="text/javascript">
  $(document).ready(function(){

    $('#retTbPrdTransf').load('data/movimento/tb_prd_transf.php?search=',{cod_estoque: $('#cod_estoque').val()});

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
<!--script type="text/javascript">
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
</script-->