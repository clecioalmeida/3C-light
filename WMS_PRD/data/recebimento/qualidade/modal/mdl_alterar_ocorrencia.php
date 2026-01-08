<?php
require_once('bd_class.php');

$cod_ocorrencia=$_POST['id_ocor'];

$objDb = new db();
$link = $objDb->conecta_mysql();


$sql_ocorrencia = "select t1.*, t2.img from tb_ocorrencias t1 left join tb_img_ocor t2 on t1.cod_ocorrencia = t2.id_ocorrencia where t1.cod_ocorrencia = '$cod_ocorrencia'"; 
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
}
$sql_img="select id, img from tb_img_ocor where id_ocorrencia = '$cod_ocorrencia'";
$res_img = mysqli_query($link,$sql_img); 
$link->close();
?>
<script type="text/javascript" src="data/qualidade/modal/upload.js"></script>
<link type="text/css" rel="stylesheet" href="data/qualidade/modal/style.css" />
<div class="modal fade" id="alterar_ocorrencia" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E">

        <h4 class="modal-title" style="color: white">ALTERAR OCORRÊNCIA</h4>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <div class="form-body">
          <div class="widget-body no-padding">
            <form id="formUpdt" class="smart-form" method="POST" action="" novalidate="novalidate">
              <fieldset>
                <div class="row">
                  <section class="col col-5">
                    <label class="input"> <i class="icon-prepend fa fa-circle"></i>
                      <input type="text" value="OCORRÊNCA NÚMERO: <?php echo $cod_ocorrencia; ?>" placeholder="OCORRÊNCA NÚMERO:" readonly="true">
                      <input type="hidden" name="cod_ocorrencia" id="codOcor" value="<?php echo $cod_ocorrencia; ?>">
                    </label>
                  </section>
                  <section class="col col-5">
                    <label class="input"> <i class="icon-prepend fa fa-circle"></i>
                      <input type="text" value="DOCUMENTO DE ORIGEM: <?php echo $cod_origem; ?>" placeholder="Origem" readonly="true">
                    </label>
                  </section>
                </div>
                <div class="row">
                  <section class="col col-5">
                    <label class="input">
                      <input type="text" value="
                        <?php 
                          if($criticidade == 'B'){

                            echo "BAIXA";

                        }elseif($criticidade == 'M'){


                          echo "MÉDIA";

                          }else{

                            echo "ALTA";

                          } ?>" readonly="true">
                        </label>
                      </section>
                      <section class="col col-5">
                        <label class="input">
                          <input type="text" value="
                            <?php 
                              if($tipo == 'A'){

                                echo "ARMAZÉM";

                              }elseif($tipo == 'T'){

                                echo "TRANSPORTE";

                              }else{

                                echo "OUTROS";

                              } 
                              ?>" 
                          readonly="true">
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
                              <input type="text" name="ds_responsavel" value="<?php echo $ds_responsavel; ?>" placeholder="Responsável">
                            </label>
                          </section>
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-list"></i>
                              <input type="text" name="nm_depto" value="<?php echo $nm_depto; ?>" placeholder="Departamento" >
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
                              <input type="date" name="dt_final" value="<?php if($dt_final > 0){

                               echo $dt_final;

                               }else{

                                echo '';

                              } ?>" placeholder="Data final para solução">
                            </label>
                          </section>
                        </div>
                        <div class="row">
                          <section class="col col-10">
                            <label class="input">
                              <textarea class="form-control" name="ds_obs" placeholder="Observações" rows="5"><?php echo $ds_obs; ?> </textarea>
                            </label>
                          </section>
                        </div>
                      </fieldset>                     
                    </form>
                    <form method="post" class="smart-form" name="upload_form" id="upload_form" enctype="multipart/form-data" action="data/qualidade/modal/upload.php">
                      <fieldset>
                        <div class="row">
                          <section class="col col-10">
                            <label><h3>SELECIONE AS IMAGENS</h3></label>
                            <br>
                            <br>
                            <input type="file" name="upload_images[]" id="image_file" multiple >
                            <input type="hidden" name="id_ocor" id="idOcor" value="<?php echo $cod_ocorrencia;?>">
                            <div class="file_uploading hidden">
                              <label> </label>
                              <img src="data/qualidade/modal/uploading.gif" alt="Uploading......"/>
                            </div>
                          </section>
                        </div>
                      </fieldset>
                      <fieldset>
                        <div class="gallery" id="ret_img">
                          <ul id="uploaded_images_preview">
                            
                          </ul>
                        </div>                          
                      </fieldset>
                    </form>
                  </div>
                </div>
                <div class="row">
                  <div class="gallery" id="gallery">
                  </div>
                </div>
              </div>
              <div class="modal-footer modal-lg" style="background-color: #22262E">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" id="btnUpdtOcor" class="btn btn-success">Salvar</button>
              </div>
            </div>
          </div>
        </div>
        <script>
          $(document).ready(function () {
            $('#alterar_ocorrencia').modal('show');
            $('#gallery').load("data/qualidade/list_img.php?search=",{id_ocor:"<?php echo $cod_ocorrencia;?>"});
          });
        </script>
        <!--script type="text/javascript">
            
            $('#btnUpdt').click(function(){
              $('#formUpdt').ajaxForm({
                  target:'#alterar_ocorrencia',
                  url:'updt_ocorrencia.php',
              });
          });

        </script-->