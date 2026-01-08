<?php 
session_start();
  require_once('bd_class.php');
  $objDb = new db();
  $link = $objDb->conecta_mysql();

  //$id_rec = mysqli_real_escape_string($link, $_POST["nf_rec"]);
  $id_rec=$_SESSION['id_rec'];

  $select_nf = "select r.nm_fornecedor, r.nm_transportadora, r.nm_placa, r.ds_obs, DATE_FORMAT(dt_recebimento_previsto ,'%d/%m/%Y') dt_recebimento_previsto, c.nm_cliente, i.cod_nf_entrada, i.nr_fisc_ent, i.dt_emis_ent, i.nr_cfop_ent, i.qtd_vol_ent, i.nr_peso_ent, i.vl_tot_nf_ent, i.tp_vol_ent, i.base_icms_ent, i.vl_icms_ent, i.chavenfe from tb_recebimento r left join tb_cliente c on r.cod_cli = c.cod_cliente left join tb_nf_entrada i on i.cod_rec = r.cod_recebimento where cod_recebimento = '$id_rec'";
  $res_nf = mysqli_query($link,$select_nf);
  $tr = mysqli_num_rows($res_nf); 

    $select_or = "select * from tb_recebimento where cod_recebimento = '$id_rec'";
    $res_or = mysqli_query($link,$select_or);
    while($dados_or=mysqli_fetch_assoc($res_or)){
        $nm_fornecedor=$dados_or["nm_fornecedor"];
        $nm_transportadora=$dados_or["nm_transportadora"];
        $nr_peso_previsto=$dados_or["nr_peso_previsto"];
        $nr_volume_previsto=$dados_or["nr_volume_previsto"];
        $dt_recebimento_previsto=$dados_or["dt_recebimento_previsto"];
        $nm_motorista=$dados_or["nm_motorista"];
        $nm_placa=$dados_or["nm_placa"];
        $ds_obs=$dados_or["ds_obs"];
    }

    $sql_emit = "select cod_cliente, nm_cliente from tb_cliente where cod_cli is null and fl_tipo = 'C'";
    $res_emit = mysqli_query($link,$sql_emit);

    $sql_dest = "select cod_cliente, nm_cliente from tb_cliente where cod_cli is null and fl_tipo = 'D'";
    $res_dest = mysqli_query($link,$sql_dest);
    while($dados_emit=mysqli_fetch_assoc($res_emit)) {
      $destinatario = $dados_emit['nm_cliente'];
    }
    
    session_destroy();
$link->close();
?>
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                      <tr>
                        <th colspan="4"> Ações</th>
                        <th> N.F. </th>
                        <th> Fornecedor </th>
                        <th data-toggle="tooltip" data-placement="left" title="Peso total da NF"> Peso (Kg)</th>
                        <th data-toggle="tooltip" data-placement="left" title="Total de volumes da NF"> Volumes </th>
                        <th data-toggle="tooltip" data-placement="left" title="Tipo de volume"> Tipo </th>
                        <th data-toggle="tooltip" data-placement="left" title="Valor total da NF"> Valor  </th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while($dados = mysqli_fetch_assoc($res_nf)) {
                        ?>
                        <tr class="odd gradeX">
                          <td style="text-align: center; width: 5px">
                            <button type="submit" id="btnUpdGalpao" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Detalhe</button>
                          </td>
                          <td style="text-align: center; width: 5px">
                            <button type="submit" id="btnUpdGalpao" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Alterar</button>
                          </td>
                          <td style="text-align: center; width: 5px">
                            <button type="submit" id="btnUpdGalpao" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Excluir</button>
                          </td>
                          <td style="text-align: center; width: 5px">
                            <button type="submit" id="btnUpdGalpao" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Produtos</button>
                          </td>
                          <td style="text-align: center; width: 10px"> <?php echo $dados['nr_fisc_ent']; ?> </td>
                          <td style="width: 30%"> <?php echo $dados['nm_fornecedor']; ?> </td>
                          <td style="text-align: center; width: 30px"> <?php echo $dados['nr_peso_ent']; ?> </td>
                          <td style="text-align: center; width: 30px"> <?php echo $dados['qtd_vol_ent']; ?> </td>
                          <td style="text-align: center; width: 10px"> <?php echo $dados['tp_vol_ent']; ?> </td>
                          <td style="text-align: center; width: 10px"> <?php echo $dados['vl_tot_nf_ent']; ?> </td>
                        </tr>
                    <?php } ?>
                  </tbody>
                </table>