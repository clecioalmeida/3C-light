<?php 
require_once('bd_class.php');

$cod_ocorrencia=$_POST['id_ocor'];

$objDb = new db();
$link = $objDb->conecta_mysql();


$sql_ocorrencia = "select * from tb_ocorrencias where cod_ocorrencia = '$cod_ocorrencia'"; 
$res_ocorrencia = mysqli_query($link,$sql_ocorrencia); 
$tr_ocorrencia = mysqli_num_rows($res_ocorrencia);

    while ($dados=mysqli_fetch_assoc($res_ocorrencia)) {
      $dt_create=date("Y-m-d", strtotime($dados['dt_create']));
      $nm_ocorrencia=$dados['nm_ocorrencia'];
      $ds_responsavel=$dados['ds_responsavel'];
      $nm_depto=$dados['nm_depto'];
      $dt_final=date("Y-m-d", strtotime($dados['dt_final']));
      $ds_obs=$dados['ds_obs'];
      $criticidade=$dados['criticidade'];
      $tipo=$dados['tipo'];
      $cod_origem=$dados['cod_origem'];
      $ds_solucao=$dados['ds_solucao'];
      $ds_resp_sol=$dados['ds_resp_sol'];
      $dt_sol=date("Y-m-d", strtotime($dados['dt_sol']));
    }

$link->close();
   ?>
        <div class="modal fade" id="finalizar_ocorrencia" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #87CEEB">
                
                <h4 class="modal-title">Finalizar ocorrência</h4>
              </div>
              <div class="modal-body modal-lg" style="overflow-y: auto">
                <!--form method="POST" action="updt_ocorrencia.php"-->
                <div class="form-body">
                  <div class="widget-body no-padding">
                    <form id="formFin" class="smart-form" method="POST" action="" novalidate="novalidate">
                      <fieldset>
                        <div class="row">
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-circle"></i>
                              <input type="text" value="Ocorrência número: <?php echo $cod_ocorrencia; ?>" placeholder="Ocorrência número" readonly="true">
                              <input type="hidden" name="cod_ocorrencia" value="<?php echo $cod_ocorrencia; ?>">
                            </label>
                          </section>
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-circle"></i>
                              <input type="text" value="<?php echo $cod_origem; ?>" placeholder="Origem" readonly="true">
                            </label>
                          </section>
                        </div>
                        <div class="row">
                        <section class="col col-5">
                          <label class="input"> <!--i class="icon-prepend fa fa-circle"></i-->
                            <input type="text" value="<?php if($criticidade == 'B'){

                                                    echo "Baixa";

                                                }elseif($criticidade == 'M'){


                                                    echo "Média";

                                                }else{

                                                    echo "Alta";

                                                } ?>" readonly="true">
                          </label>
                        </section>
                        <section class="col col-5">
                          <label class="input"> <!--i class="icon-prepend fa fa-circle"></i-->
                            <input type="text" value="<?php if($tipo == 'A'){

                                                    echo "Armazém";

                                                }elseif($tipo == 'T'){

                                                    echo "Transporte";

                                                }else{

                                                    echo "Outros";

                                                } ?>" readonly="true">
                          </label>
                        </section>
                      </div>
                        <div class="row">
                          <section class="col col-10">
                            <label class="input"> <i class="icon-prepend fa fa-list"></i>
                              <input type="text" value="<?php echo $nm_ocorrencia; ?>" placeholder="Descrição" readonly="true">
                            </label>
                          </section>
                        </div>
                        <div class="row">
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-user"></i>
                              <input type="text" value="<?php echo $ds_responsavel; ?>" placeholder="Responsável">
                            </label>
                          </section>
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-list"></i>
                              <input type="text" value="<?php echo $nm_depto; ?>" placeholder="Departamento" >
                            </label>
                          </section>
                        </div>
                        <div class="row">
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                              <input type="date" value="<?php echo $dt_create; ?>" placeholder="Data de abertura">
                            </label>
                          </section>
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                              <input type="date" value="<?php if($dt_final > 0){

                                                               echo $dt_final;

                                                            }else{

                                                                echo '';

                                                            } ?>" placeholder="Data final para solução">
                            </label>
                          </section>
                        </div>
                        <div class="row">
                          <section class="col col-10">
                            <label class="input"><h4>Problema detalhado</h4>
                              <textarea class="form-control" placeholder="Observações" rows="5"><?php echo $ds_obs; ?> </textarea>
                            </label>
                          </section>
                        </div>
                      </fieldset>
                      <fieldset>
                       <div class="row">
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-user"></i>
                              <input type="text" name="ds_resp_sol" value="<?php echo $ds_resp_sol; ?>" placeholder="Responsável pela solução">
                            </label>
                          </section>
                          <section class="col col-5">
                            <label class="input"><i class="icon-prepend fa fa-calendar"></i>
                              <input type="date" name="dt_sol" value="<?php if($dados['dt_sol'] > 0){

                                                               echo  date("Y-m-d", strtotime($dados['dt_sol']));

                                                            }else{

                                                                echo '';

                                                            } ?>" placeholder="Data de Solução">
                            </label>
                          </section>
                        </div>
                        <div class="row">
                          <section class="col col-10">
                            <label class="input"> <h4>Solução aplicada</h4>
                              <textarea class="form-control" name="ds_solucao" placeholder="Solução aplicada" rows="5"><?php echo $ds_solucao; ?> </textarea>
                            </label>
                          </section>
                        </div>
                      </fieldset>
                    </form>
                  </div>
                </div>
              </div>
              <div class="modal-footer" style="background-color: #4169E1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" id="btnFintOcor" class="btn btn-success">Salvar</button>
              </div>
            </div>
          </div>
        </div>
        </div><!--Fim modal-->
        <script>
            $(document).ready(function () {
                $('#finalizar_ocorrencia').modal('show');
            });
        </script>
        <!--script type="text/javascript">
            
            $('#btnFin').click(function(){
              $('#formFin').ajaxForm({
                  target:'#finalizar_ocorrencia',
                  url:'fin_ocorrencia.php',
              });
          });

        </script-->