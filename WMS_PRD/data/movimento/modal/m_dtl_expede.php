<?php
//Incluir a conexão com banco de dados
require_once('xhr/bd_class_dsv.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$expede = $_POST['expedicao'];

//$SQL = "select * from tb_produto where fl_tipo_comp = 1";
$sql = "select t1.*, t2.nm_cliente, t2.ds_cidade, t2.ds_uf, t2.nr_cnpj_cpf, t2.ds_ie_rg, t3.nm_tipo
from tb_pedido_coleta t1 
left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente
left join tb_tipo t3 on t1.ds_tipo = t3.cod_tipo
where t1.fl_status = 'E' and (t2.nm_cliente like '%$expede%' or t1.nr_pedido like '%$expede%')";
$res_expedicao = mysqli_query($link,$sql); 
$exp = mysqli_num_rows($res_expedicao);
$link->close();
?>
<div class="modal fade" id="detalhe_pedido<?php echo $dados['nr_pedido']; ?>" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header" style="background-color: #2F4F4F;">
                        <i class="icon-settings font-green-haze"></i>
                        <span class="caption-subject bold uppercase" style="color: white"> Pedido número: <?php echo $dados['nr_pedido']; ?>   </span>
                        <br />
                        <!--i class="icon-settings font-green-haze"></i>
                        <span class="caption-subject bold uppercase"> Status: <?php echo $dados['fl_status']; ?> </span-->
                    </div>
                    <div class="modal-body modal-lg" style="overflow-y: auto">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="emissor">Emissor</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="emissor">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="conferente">Conferente 1</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="conferente">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="conferente2">Conferente 2</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="conferente2">
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="form_control_cliente" value="<?php echo $dados['nm_cliente']; ?>">Cliente</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="CTEEP - COMPANHIA DE TRANSMISSÃO DE ENERGIA ELÉTRICA" id="form_control_cliente">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="solicitante">Solicitante</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="<?php echo $dados['nm_aprovacao']; ?>" id="solicitante">
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="caption font-green-haze">
                                <i class="icon-settings font-green-haze"></i>
                                <span class="caption-subject bold uppercase"> Destinatário:   </span>
                                <br />
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="r_social">Razão Social</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="r_social" value="<?php echo $dados['nm_cliente']; ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="cnpj">CNPJ</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="cnpj" value="<?php echo $dados['nr_cnpj_cpf']; ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="i_est">I.E.</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="i_est" value="<?php echo $dados['ds_ie_rg']; ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="caption font-green-haze">
                                <i class="icon-settings font-green-haze"></i>
                                <span class="caption-subject bold uppercase"> Modal:   </span>
                                <br />
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="modal">Modalidade</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="modal" value="<?php echo $dados['ds_modalidade']; ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="tipo">Tipo</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tipo" value="<?php echo $dados['nm_tipo']; ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="frete">Frete</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="frete" value="<?php echo $dados['ds_frete']; ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="d_limite">Data limite</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="d_limite" value="<?php 
                                    if($dt_limite<1){
                                        echo '';
                                    } else {
                                        echo date("d/m/Y", strtotime($dados['dt_limite']));
                                    }
                                    ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="h_limite">Hora limite</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $dados['hr_limite']; ?>" id="h_limite">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="h_limite"></label>
                                <div class="col-sm-2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="d_saida">Data de saída</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="d_saida">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="h_saida">Hora de saída</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="h_saida">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-sm-2 control-label" for="h_limite"></label>
                                <div class="col-sm-2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 control-label" for="p_obs">Observações da NF</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="p_obs">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #2F4F4F;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div><!--fim modal -->