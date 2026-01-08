<?php 
    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $cod_rec = $_REQUEST['cod_rec'];
    $query="SET SQL_BIG_SELECTS=1";
    $res_query=mysqli_query($link, $query);

    $query_prd="select t1.cod_recebimento, t2.cod_nf_entrada, t2.nr_fisc_ent, t4.nr_qtde, t3.cod_produto, t3.cod_prod_cliente, t3.nm_produto
    from tb_recebimento t1
    left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
    left join tb_nf_entrada_item t4 on t2.cod_nf_entrada = t4.cod_nf_entrada
    left join tb_produto t3 on t4.produto = t3.cod_produto
    where t1.cod_recebimento = '$cod_rec'";
    $res_prd=mysqli_query($link, $query_prd);
    $tr_prd = mysqli_num_rows($res_prd);

$link->close();


?>
<div class="modal fade" id="list_prd" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title"></h3></h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
        <div class="col-sm-12">
            <label><h4 style="color: white">Inclusão de produtos</h4></label>
        </div>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <div id="retornoPrd">
              <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                <thead>
                  <tr>
                    <th> ID </th>
                    <th> NF </th>
                    <th> Produto </th>
                    <th> Descrição</th>
                    <th> Qtde </th>
                    <th> Ações</th>
                  </tr>
                </thead>
                <tbody id="retProdNfItem">
                  <?php
                    while($dados_prdNf=mysqli_fetch_assoc($res_prd)) {
                  ?>
                  <tr>
                    <td><?php echo $dados_prdNf['cod_nf_entrada'];?></td>
                    <td><?php echo $dados_prdNf['nr_fisc_ent'];?></td>
                    <td><?php echo $dados_prdNf['cod_produto'];?></td>
                    <td><?php echo $dados_prdNf['nm_produto'];?></td>
                    <td style="text-align: right;"><?php echo $dados_prdNf['nr_qtde'];?></td>
                    <td style="text-align: center; width: 5px">
                      <a href="data/recebimento/relatorio/list_etq_rec.php?cod_produto=<?php echo $dados_prdNf['cod_produto'];?>" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-primary btn-xs" value="">Etiqueta</button></a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#list_prd').modal('show');
    });

</script>