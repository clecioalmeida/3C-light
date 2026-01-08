<?php 
session_start();
  require_once('bd_class.php');
  $objDb = new db();
  $link = $objDb->conecta_mysql();

  $cod_nf_entrada=$_SESSION['cod_nf_entrada'];

  $select_nf_item = "select t1.cod_nf_entrada_item, t4.nr_fisc_ent, t1.nr_qtde, t1.vl_unit, t1.nr_peso_unit, t2.cod_produto, t2.nm_produto, t3.estado 
  from tb_nf_entrada_item t1
  left join tb_produto t2 on t1.produto = t2.cod_produto
  left join tb_estado_produto t3 on t1.estado_produto = t3.id
  left join tb_nf_entrada t4 on t1.cod_nf_entrada = t4.cod_nf_entrada
  where t1.cod_nf_entrada = '$cod_nf_entrada'";
  $res_nf_item = mysqli_query($link,$select_nf_item);

  unset ($_SESSION["cod_nf_entrada"]);
$link->close();
?>
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
  <thead>
    <tr>
      <th colspan="4"> Ações</th>
      <th> ID </th>
      <th> Produto </th>
      <th> Descrição</th>
      <th> Estado </th>
      <th> Qtde </th>
      <th> Vlr Unit.  </th>
      <th> Peso Unit.  </th>
    </tr>
  </thead>
  <tbody>
    <?php 
      while($dados = mysqli_fetch_assoc($res_nf_item)) {
    ?>
    <tr class="odd gradeX">
      <td style="text-align: center; width: 5px">
        <button type="submit" id="btnDtlPrdrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada_item']; ?>">Detalhe</button>
      </td>
      <td style="text-align: center; width: 5px">
        <button type="submit" id="btnUpdPrdrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada_item']; ?>">Alterar</button>
      </td>
      <td style="text-align: center; width: 5px">
        <button type="submit" id="btnDelPrdrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada_item']; ?>">Excluir</button>
      </td>
      <td>
        <button type="submit" id="btnNsPrdrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada_item']; ?>">N.Série</button>
      </td>
      <td style="text-align: center; width: 10px"> <?php echo $dados['cod_nf_entrada_item']; ?> </td>
      <td style="text-align: center; width: 30px"> <?php echo $dados['cod_produto']; ?> </td>
      <td style="text-align: center; width: 30px"> <?php echo $dados['nm_produto']; ?> </td>
      <td style="text-align: center; width: 10px"> <?php echo $dados['estado']; ?> </td>
      <td style="text-align: center; width: 10px"> <?php echo $dados['nr_qtde']; ?> </td>
      <td style="text-align: center; width: 10px"> <?php echo $dados['vl_unit']; ?> </td>
      <td style="text-align: center; width: 10px"> <?php echo $dados['nr_peso_unit']; ?> </td>
    </tr>
    <?php } ?>
  </tbody>
</table>