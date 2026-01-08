<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_estoque = $_POST['cod_estoque'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$select_estoque = "select t1.*, t2.cod_produto, t2.nm_produto, t2.cod_prod_cliente, t3.ds_apelido from tb_posicao_pallet t1 left join tb_produto t2 on t1.produto = t2.cod_prod_cliente or t1.cod_produto = t2.cod_produto left join tb_armazem t3 on t1.ds_galpao = t3.id where cod_estoque = '$cod_estoque' and t3.id <> 2";
$res_estoque = mysqli_query($link, $select_estoque);
while ($dados_estoque = mysqli_fetch_assoc($res_estoque)) {
  $cod_prod_cliente = $dados_estoque["cod_prod_cliente"];
  $nr_qtde = $dados_estoque["nr_qtde"];
  $nm_produto = $dados_estoque["nm_produto"];
  $ds_galpao = $dados_estoque['ds_galpao'];
  $ds_prateleira = $dados_estoque['ds_prateleira'];
  $ds_coluna = $dados_estoque['ds_coluna'];
  $ds_altura = $dados_estoque['ds_altura'];
  $ds_apelido = $dados_estoque['ds_apelido'];
  $produto = $dados_estoque['cod_produto'];
  $id_aval = $dados_estoque['ds_avaliacao'];
  $ds_projeto = $dados_estoque['ds_projeto'];
  $nr_nf_entrada = $dados_estoque['nr_nf_entrada'];
  $ds_embalagem = $dados_estoque['ds_embalagem'];
}

$select_mov = "select t1.cod_estoque, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_qtde, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_produto
where t1.cod_estoque = '$cod_estoque'";
$res_mov = mysqli_query($link, $select_mov);

$sql_galpao = "SELECT distinct id, nome FROM tb_armazem where id <> 2";
$res_galpao = mysqli_query($link, $sql_galpao);
$link->close();
?>
<hr>
<legend>MOVIMENTAÇÃO ENTRE ENDEREÇOS<button type="submit" class="btn btn-success" id="btnUpdRecebimento" value="<?php echo $id_rec;?>" style="float: right;margin-top: -10px;width: 100px">Salvar</button></legend>
<form method="POST" action="" id="formUpdRec">
  <fieldset>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="codigo">Código</label>
      <div class="col-sm-2">
        <input type="text" class="form-control"  align="center" id="cod_prod_cliente" name="cod_prod_cliente" value="<?php echo $cod_prod_cliente; ?>" readonly="true">
        <div class="form-control-focus"> </div>
      </div>
      <label class="col-sm-2 control-label" for="descricao">Descrição</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="nm_produto" name="nm_produto" value="<?php echo $nm_produto; ?>" readonly="true">
        <div class="form-control-focus"> </div>
      </div>
    </div>
  </fieldset><br>
  <fieldset>
   <div class="form-group">
    <label class="col-sm-2 control-label" for="qtde">Quantidade alocada</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" value="<?php echo number_format($nr_qtde, 0, '.', ''); ?>" align="center" id="nr_qtde_old" name="nr_qtde_old" readonly="true">
      <div class="form-control-focus"> </div>
    </div>
    <label class="col-sm-2 control-label" for="qtde">Local atual</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" value="<?php echo $ds_apelido . $ds_prateleira . $ds_coluna . $ds_altura; ?>" align="center" id="ds_local" name="ds_local" readonly="true">
      <div class="form-control-focus"> </div>
    </div>
    <label class="col-sm-2 control-label" for="qtde">Projeto</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" value="<?php echo $ds_projeto; ?>" align="center" id="ds_projeto" name="ds_projeto" readonly="true">
      <div class="form-control-focus"> </div>
    </div>
  </div>
</fieldset>
<br/>
<form method="post" action="">
  <fieldset>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="alocar">Digite a quantidade que deseja alocar</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="nr_qtde_new" id="nr_qtde_new">
        <input type="hidden" class="form-control" value="<?php echo $id_aval; ?>" name="id_aval" id="id_aval">
        <input type="hidden" class="form-control" value="<?php echo $ds_projeto; ?>" name="ds_projeto" id="ds_projeto">
        <input type="hidden" class="form-control" value="<?php echo $nr_nf_entrada; ?>" name="nr_nf_entrada" id="nr_nf_entrada">
        <input type="hidden" class="form-control" value="<?php echo $produto; ?>" name="cod_produto" id="cod_produto">
        <input type="hidden" name="cod_estoque" value="<?php echo $cod_estoque; ?>" id="cod_estoque"><input type="hidden" name="ds_embalagem" value="<?php echo $ds_embalagem; ?>" id="ds_embalagem">
        <div class="form-control-focus"> </div>
      </div>
    </div>
  </fieldset>
  <fieldset>
    <hr>
    <h5> Escolha o local de armazenagem</h5>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="galpao">Galpão</label>
      <div class="col-sm-4" id="armaz">
        <select class="form-control" name="idGalpaoNew" id="idGalpaoNew">
          <option>Galpão</option>
          <?php
          while ($dados_galpao = mysqli_fetch_assoc($res_galpao)) {?>
            <option value="<?php echo $dados_galpao['id']; ?>">
              <?php echo $dados_galpao['nome']; ?>
              </option> <?php }?>
            </select>
          </div>
          <label class="col-sm-2 control-label" for="rua">Rua</label>
          <div class="col-sm-4" id="rua">
            <select class="form-control" name="idRuaNew" id="idRuaNew">
              <option value=""></option>
            </select><br>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="coluna">Coluna</label>
          <div class="col-sm-4" id="coluna">
            <select class="form-control" name="idColNew" id="idColNew">
              <option></option>
            </select>
          </div>
          <label class="col-sm-2 control-label" for="id_altura">Altura</label>
          <div class="col-sm-4" id="altura">
            <select class="form-control" name="idAlturaNew" id="idAlturaNew">
              <option></option>
            </select>
          </div>
        </div>
      </fieldset><br>
      <fieldset>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="coluna">Projeto</label>
          <div class="col-sm-4" id="coluna">
            <input type="text" class="form-control" name="ds_projeto_new" id="ds_projeto_new" required="true">
          </div>
        </fieldset>
        <hr>
        <fieldset>
          <button type="submit" class="btn btn-primary btn-sm" id="btnFormAlocacao">Salvar</button>
        </fieldset>
      </form>
      <h5> Quantidades alocadas</h5>
      <hr/>
      <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
       <thead>
        <tr>
          <th> Código SAP</th>
          <th> Descrição </th>
          <th> Galpão </th>
          <th> Rua  </th>
          <th> Coluna  </th>
          <th> Altura  </th>
          <th> Qtde alocada  </th>
        </tr>
      </thead>
      <tbody>
       <?php
       while ($dados_mov = mysqli_fetch_array($res_mov)) {?>
         <tr class="odd gradeX">
           <td style="width: 10%"> <?php echo $dados_mov['cod_prod_cliente']; ?> </td>
           <td style="width: 30%"> <?php echo $dados_mov['nm_produto']; ?> </td>
           <td style="width: 10%"> <?php echo $dados_mov['ds_galpao']; ?> </td>
           <td> <?php echo $dados_mov['ds_prateleira']; ?> </td>
           <td> <?php echo $dados_mov['ds_coluna']; ?> </td>
           <td> <?php echo $dados_mov['ds_altura']; ?> </td>
           <td> <?php echo $dados_mov['nr_qtde']; ?> </td>
         </tr>
       <?php }?>
     </tbody>

   </table>
 </form>
 <script type="text/javascript">
  $(document).ready(function(){

    $('#retornoNfe').load('data/recebimento/list_rec_nfe.php?search=',{nf_rec:'<?php echo $id_rec;?>'});

    $( '#liRecNfe').on('click', function(){
      $('#retornoNfe').load('data/recebimento/list_rec_nfe.php?search=',{nf_rec:'<?php echo $id_rec;?>'});
    });

    $( '#liRecNs').on('click', function(){
      $('#retornoNs').load('data/recebimento/list_ns_prd.php?search=',{id_rec:'<?php echo $id_rec;?>'});
    });

    $( '#liRecSap').on('click', function(){
      $('#retornoSap').load('data/recebimento/list_rec_sap.php?search=',{id_rec:'<?php echo $id_rec;?>'});
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