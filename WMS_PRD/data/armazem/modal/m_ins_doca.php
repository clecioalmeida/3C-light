<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$SQL = "select * from tb_armazem"; 
$res = mysqli_query($link,$SQL); 

$link->close();
?>
<div class="modal fade" id="incluir_local" aria-hidden="true">
<form method="post" action="" role="form" id="formCadDoca" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="novo_galpao" style="color: white">Incluir Doca</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="portlet-body form">
          <div class="modal-body">
           <fieldset>
            <div class="form-group">
              <label class="col-md-2 control-label" for="local_nome">Tipo</label>
              <div class="col-md-4">
                <div class="row">
                    <div class="col col-4">
                      <label class="radio">
                        <input type="radio" name="fl_tipo" value="RAMPA" checked="checked">
                        <i></i>Rampa</label>
                      <label class="radio">
                        <input type="radio" name="fl_tipo" value="RECEBIMENTO">
                         <i></i>Recebimento</label>
                      <label class="radio">
                        <input type="radio" name="fl_tipo" value="MISTA">
                         <i></i>Mista</label>
                      <label class="radio">
                        <input type="radio" name="fl_tipo" value="SIDER">
                         <i></i>Sider</label>
                    </div>
                  </div>
                <div class="form-control-focus"> </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label" for="local_galpao">Galpão</label>
              <div class="col-md-4">
                <select class="form-group" name="galpao">
                  <option>Selecione</option>
                    <?php                                                          
                    while($row_select_galpao = mysqli_fetch_assoc($res)) {?>
                      <option value="<?php echo $row_select_galpao['id']; ?>">
                          <?php echo $row_select_galpao['nome']; ?>
                      </option> <?php } ?>
                </select>
                <div class="form-control-focus"> </div>
              </div>
            </div>
           </fieldset>
           <fieldset>
            <div class="form-group">
              <label class="col-md-2 control-label" for="local_curva">Nome</label>
              <input type="text" class="form-control" name="ds_doca" id="ds_doca" placeholder="Nome">  
            </div>
          </div>
          <div class="modal-footer" style="background-color: #2F4F4F;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <span aria-hidden="true"></span>Fechar
            </button>
            <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon glyphicon-floppy-disk" id="btnFormCadDoca" aria-hidden="true"></span>
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