<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$feixe_rua = $_POST['feixe_rua'];
$feixe_mod = $_POST['feixe_mod'];
$id_feixe = $_POST['id_feixe'];
$torre_fx = $_POST['torre_fx'];
$parte_fx = $_POST['parte_fx'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$select_estoque = "select sum(t1.nr_qtde) as qtde 
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_produto 
left join tb_item_torre t3 on t2.cod_produto = t3.id_item or t2.id_torre = t3.id_item
where t1.ds_prateleira = '$feixe_rua' and t1.ds_galpao = 17 and ds_coluna = '$feixe_mod' and t1.nr_qtde > 0 and t1.ds_embalagem = '$id_feixe' and t3.id_torre = '$torre_fx' and t3.id_parte = '$parte_fx'
order by t1.produto asc";
$res_estoque = mysqli_query($link, $select_estoque);
while ($dados_estoque = mysqli_fetch_assoc($res_estoque)) {
	$qtde = $dados_estoque["qtde"];
}

$select_mov = "select t1.cod_estoque, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_qtde, t1.ds_embalagem, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_item_torre t3 on t2.cod_produto = t3.id_item or t2.id_torre = t3.id_item
where t1.ds_prateleira = '$feixe_rua' and t1.ds_coluna = '$feixe_mod' and t1.ds_embalagem = '$id_feixe' and t3.id_torre = '$torre_fx' and t3.id_parte = '$parte_fx' and t1.nr_qtde > 0";
$res_mov = mysqli_query($link, $select_mov);

$sql_galpao = "SELECT distinct id, nome FROM tb_armazem";
$res_galpao = mysqli_query($link, $sql_galpao);
$link->close();
?>
<div class="modal fade" id="mov_destino" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Movimentação de produtos por feixe</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="codigo">Rua</label>
            <div class="col-sm-1">
              <input type="text" class="form-control"  align="center" id="feixe_rua" name="feixe_rua" value="<?php echo $feixe_rua; ?>" readonly="true" style="width: 70px;margin-left: -70px">
              <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="descricao">Módulo</label>
            <div class="col-sm-1">
              <input type="text" class="form-control" id="feixe_mod" name="feixe_mod" value="<?php echo $feixe_mod; ?>" readonly="true" style="width: 70px;margin-left: -70px">
              <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="descricao">Feixe</label>
            <div class="col-sm-1">
              <input type="text" class="form-control" id="id_feixe" name="id_feixe" value="<?php echo $id_feixe; ?>" readonly="true" style="width: 70px;margin-left: -70px">
              <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="descricao">Qtde</label>
            <div class="col-sm-1">
              <input type="text" class="form-control" id="qtde_feixe" name="qtde_feixe" value="<?php echo $qtde; ?>" readonly="true" style="width: 100px;margin-left: -70px">
              <input type="hidden" class="form-control" id="torre_feixe" name="torre_feixe" value="<?php echo $torre_fx; ?>" readonly="true" style="width: 100px;margin-left: -70px">
              <input type="hidden" class="form-control" id="parte_feixe" name="parte_feixe" value="<?php echo $parte_fx; ?>" readonly="true" style="width: 100px;margin-left: -70px">
              <div class="form-control-focus"> </div>
            </div>
          </div>
        </fieldset><br>
        <form method="post" action="">
          <fieldset>
            <hr>
            <h5> Escolha o local de armazenagem</h5>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="galpao">Galpão</label>
              <div class="col-sm-4" id="armaz">
                <select class="form-control" name="ds_galpao" id="cmbarmaz">
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
                    <select class="form-control" name="ds_prateleira" id="cmbrua">
                      <option value=""></option>
                    </select><br>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="coluna">Coluna</label>
                  <div class="col-sm-4" id="coluna">
                    <select class="form-control" name="ds_coluna" id="cmbcoluna">
                      <option></option>
                    </select>
                  </div>
                  <label class="col-sm-2 control-label" for="id_altura">Altura</label>
                  <div class="col-sm-4" id="altura">
                    <select class="form-control" name="ds_altura" id="cmbaltura">
                      <option></option>
                    </select>
                  </div>
                </div>
              </fieldset><br>
              <hr>
              <fieldset>
                <button type="submit" class="btn btn-primary btn-sm" id="btnMovFeixe" style="width: 200px">Salvar</button>
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
                <th> Feixe  </th>
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
                 <td> <?php echo $dados_mov['ds_embalagem']; ?> </td>
                 <td> <?php echo $dados_mov['nr_qtde']; ?> </td>
               </tr>
             <?php }
             $link->close();?>
           </tbody>

         </table>
       </div>
       <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</form>
</div>
<script>
  $(document).ready(function () {
    $('#mov_destino').modal('show');
  });
</script>