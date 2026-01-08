<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "select id,ds_apelido, nome from tb_armazem where id > 1";
$select_local = mysqli_query($link, $sql_local);

$link->close();

?>
<style type="text/css">
    .ocupado {
        background-color: #F08080;
    }

    .livre {
        background-color: #7FFFD4;
    }

    .alerta {
        background-color: #EEDD82;
    }
</style>
<div class="modal fade" id="consulta_doca" aria-hidden="true">
 <form method="post" action="" id="">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Consulta docas</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg">
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <select class="form-control" name="codGalpao" id="codGalpao">
                <option>Selecione</option>
                <?php 
                while($local = mysqli_fetch_assoc($select_local)) {?>
                <option value="<?php echo $local['id']; ?>">
                  <?php echo $local['ds_apelido']." - ".$local['nome']; ?>
                </option> <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <table class="table" id="tbConfPed">
            <thead>
              <tr>
                <th> Armazém </th>
                <th> Doca</th>
                <th> Status </th>
              </tr>
            </thead>
            <tbody id="retorno_status">
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer modal-lg" style="background-color: #2F4F4F;">
      </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#consulta_doca').modal('show');
    });
</script>
<!--script type="text/javascript">
    $(document).ready(function(){
        var status_ = new Array();
        $('.status').each( function( i,v ){
            var $this = $( this )
            status_[i] = $this.attr('data-status');
            if(status_[i] == "L"){
                $this.addClass('ocupado');
            }else{
                $this.removeClass('ocupado').addClass('alerta');
            }
        });
    });
</script-->