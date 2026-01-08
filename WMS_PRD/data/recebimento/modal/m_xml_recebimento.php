<?php 

  require_once('bd_class.php');
  $objDb = new db();
  $link = $objDb->conecta_mysql();

  $id_rec = mysqli_real_escape_string($link, $_POST["xml_rec"]);

  $select_rec="select r.nm_fornecedor, r.nm_transportadora, r.cod_recebimento, r.nm_placa, r.ds_obs, DATE_FORMAT(dt_recebimento_previsto ,'%d/%m/%Y') dt_recebimento_previsto, c.nm_cliente, i.cod_nf_entrada, i.nr_fisc_ent, i.dt_emis_ent, i.nr_cfop_ent, i.qtd_vol_ent, i.nr_peso_ent, i.vl_tot_nf_ent, i.tp_vol_ent, i.base_icms_ent, i.vl_icms_ent, i.chavenfe from tb_recebimento r left join tb_cliente c on r.cod_cli = c.cod_cliente left join tb_nf_entrada i on i.cod_rec = r.cod_recebimento where cod_recebimento = '$id_rec'";
  $res = mysqli_query($link,$select_rec);

  while ($dados = mysqli_fetch_assoc($res)) {
    $cod_recebimento=$dados['cod_recebimento'];
    $nm_cliente=$dados['nm_cliente'];;
    $nm_fornecedor=$dados['nm_fornecedor'];
    $dt_recebimento_previsto=$dados['dt_recebimento_previsto'];
    $nm_transportadora=$dados['nm_transportadora'];
    $nm_placa=$dados['nm_placa'];
    $ds_obs=$dados['ds_obs'];
}

$link->close();

?>
<div class="modal fade" id="importar_xml" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #2F4F4F;">
              <h5 class="modal-title" id="importar_xml" style="color: white">Upload XML</h5>
              <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body modal-lg" style="overflow-y: auto">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="form_control_or">O.R.</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="form_control_or" placeholder="OR" value="<?php echo $cod_recebimento;?>">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="form_control_cliente">Cliente</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="form_control_cliente" value="<?php echo $nm_cliente;?>" placeholder="Cliente">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="form_control_fornecedor">Fornecedor</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="form_control_fornecedor" value="<?php echo $nm_fornecedor;?>" placeholder="Fornecedor">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="form_control_transportador">Transportador</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="form_control_transportador" value="<?php echo $nm_transportadora;?>" placeholder="Transportador">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="form_control_data_real">Data real</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="form_control_data_real" value="<?php echo $dt_recebimento_real;?>">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="form_control_data_real">Status</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="form_control_data_real">
                    <div class="form-control-focus"> </div>
                </div>
            </div><br><br>
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <div class="btn-group">
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                                <p><input class="btn btn-default btn-block btn-md sbold" type="file" name="xml[]" /></p>
                                <p><input class="btn btn-default btn-block btn-md sbold" type="file" name="xml[]" /></p>
                                <p><input class="btn btn-default btn-block btn-md sbold" type="file" name="xml[]" /></p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="btn-group">
                        <div class="btn-group">
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                                <p><input class="btn btn-default btn-block btn-md sbold" type="file" name="xml[]" /></p>
                                <p><input class="btn btn-default btn-block btn-md sbold" type="file" name="xml[]" /></p>
                                <p><input class="btn btn-default btn-block btn-md sbold" type="file" name="xml[]" /></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <div class="btn-group">
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                                <p><input class="btn btn-primary sbold green" type="submit" value="Enviar" /></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> Produto</th>
                            <th> Descrição </th>
                            <th> N.F. </th>
                            <th> Qtde prevista </th>
                            <th> Qtde N.F. </th>
                            <th> Qtde recebida </th>
                            <th> Lote </th>
                            <th> Validade </th>
                            <th> Fabricação </th>
                            <th> Conferente </th>
                            <th> Observações  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd gradeX">
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer" style="background-color: #2F4F4F;">
        <div class="row">
            <div class="col-md-4">
                <textarea class="form-control" id="form_control_obs" placeholder="Observação"></textarea>
                <div class="form-control-focus"> </div>
            </div>
            <div class="col-md-8">
                    <button type="button" class="btn btn-primary" id="btnFormInsXml">Salvar</button>
                </button>
                <button type="button" class="btn btn-secondary" id="btnCloseXml">Fechar</button>
                <div class="form-control-focus"> </div>
            </div>
        </div>
        </div>
</div>
</div>
</div>
<script>
  $(document).ready(function () {
    $('#importar_xml').modal('show');
  });

  $('#btnCloseXml').click(function(e){
    e.preventDefault();
    $('#importar_xml').modal('hide');
    $('#nf_recebimento').modal('show');
  });

</script>