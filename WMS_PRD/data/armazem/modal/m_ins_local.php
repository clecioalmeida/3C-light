<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$SQL = "select * from tb_galpao where fl_status = 1"; 
$res = mysqli_query($link,$SQL); 
$tr = mysqli_num_rows($res); // verifica o número total de registros  
        //echo $tr;         
$link->close();
?>
<div class="modal fade" id="incluir_local" aria-hidden="true">
<form method="post" action="" role="form" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="novo_galpao" style="color: white">Incluir Local</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="portlet-body form">
          <div class="modal-body">
           <fieldset>
            <div class="form-group">
              <label class="col-md-2 control-label" for="local_nome">Nome</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="nome" id="local_nome" placeholder="Nome">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-md-2 control-label" for="local_galpao">Galpão</label>
              <div class="col-md-4">
                <select class="form-group" name="galpao">
                  <option>Selecione</option>
                    <?php                                                          
                    while($row_select_galpao = mysqli_fetch_assoc($res)) {?>
                      <option value="<?php echo $row_select_galpao['cod_galpao']; ?>">
                          <?php echo $row_select_galpao['galpao']; ?>
                      </option> <?php } ?>
                </select>
                <div class="form-control-focus"> </div>
              </div>
            </div>
           </fieldset>
           <fieldset>
            <div class="form-group">
              <label class="col-md-2 control-label" for="local_curva">Curva</label>
              <div class="col-sm-4">
               <div>
                <label><input type="radio" name="fl_curva" value="A" id="local_curva">A<br /></label>
              </div>
              <div>
                <label><input type="radio" name="fl_curva" value="B" id="local_curva">B<br /></label>
              </div>
              <div>
                <label><input type="radio" name="fl_curva" value="C" id="local_curva">C</label>
              </div>
              </div>
              <label class="col-md-2 control-label" for="tipo_alocacao">Alocação</label>
              <div class="col-md-4">
                <div>
                <label><input type="radio" name="aloc_aut" value="S" id="tipo_alocacao">Automática<br /></label>
                </div>
                <div>
                <label><input type="radio" name="aloc_aut" value="N" id="tipo_alocacao">Manual</label>
                </div>
              </div>
            </div>
           </fieldset>
           <fieldset>
            <div class="form-group">
              <label class="col-md-2 control-label" for="tipo_galpao">Tipo</label>
              <div class="col-md-4">
                <div>
                <label><input type="radio" name="fl_tipo" value="F" id="tipo_galpao">Físico<br /></label>
                </div>
                <div>
                <label><input type="radio" name="fl_tipo" value="V" id="tipo_galpao">Virtual</label>
                </div>
              </div>
            </div>
           </fieldset> 
          </div>
          <div class="modal-footer" style="background-color: #2F4F4F;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <span aria-hidden="true"></span>Fechar
            </button>
            <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon glyphicon-floppy-disk" id="btnFormCadLocal" aria-hidden="true"></span>
            Salvar</button>
          </div>
    </div>
    </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#incluir_local').modal('show');
    });
</script>