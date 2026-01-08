<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.id, t1.id_galpao, t1.dt_inicio, t2.nome
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.fl_status = 'P'";
$res_inv = mysqli_query($link, $SQL);

$link->close();
?>
<style type="text/css">
.carregando{
  color:#ff0000;
  display:none;
}
</style>
<div class="modal fade" id="enc_dia" aria-hidden="true">
  <form class="form-horizontal" method="post" action="" id="formCadTar">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #2F4F4F;">
          <h5 class="modal-title" style="color: white"><bold>Fechamento de período de inventário</bold></h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body modal-lg" style="overflow-y: auto">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="id_torre">Inventário</label>
            <div class="col-sm-4">
              <select class="form-control" id="id_inv_enc" name="id_inv_enc" required="true">
                <option>Selecione o inventário</option>
                <?php
                while ($row_inv = mysqli_fetch_assoc($res_inv)) {
                 $id_inv = $row_inv['id'];
                 ?>
                 <option value="<?php echo $row_inv['id']; ?>">
                  <?php echo $row_inv['id'] . " - " . $row_inv['nome'] . " - " . date('d/m/Y', strtotime($row_inv['dt_inicio'])); ?>
                </option>
                <?php
              }?>
            </select>
            <div class="form-control-focus"> </div>
          </div>
        </div>
        <div id="confirma">
          <h1 class="bg-color-red txt-color-white">Existem tarefas não encerradas!</h1>
          <h3>Faça o encerramento das tarefas antes do fechamento do período.</h3><br>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Dia</th>
                <th scope="col">Tarefas não encerradas</th>
              </tr>
            </thead>
            <tbody id="retEncTar">
            </tbody>
          </table>
        </div>
        <div id="encerra" style="text-align:center"></div>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F">
      </div>
    </div>
  </div>
</form>
</div><!--Fim modal-->
<script>
  $(document).ready(function () {
    $('#enc_dia').modal('show');
    $('#confirma').hide();
  });
</script>