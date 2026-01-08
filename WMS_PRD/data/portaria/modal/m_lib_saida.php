<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }
?>
<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_prt = $_REQUEST['id'];

$select_saida = "select * from tb_portaria where id = '$id_prt'";
$res_saida = mysqli_query($link,$select_saida);
while ($dados=mysqli_fetch_assoc($res_saida)) {
    $ds_placa=$dados['ds_placa'];
    $ds_nome=$dados['ds_nome'];
}

//$select_galpao = "select * from tb_armazem";
//$res_galpao = mysqli_query($link,$select_galpao);

$link->close();
?>
<div class="modal fade" id="ins_minuta_saida" aria-hidden="true">
 <form method="post" action="" id="formInsPedido">
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Liberação de saída: Placa: <?php echo $ds_placa;?> - Nome: <?php echo $ds_nome;?></h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-xs" style="overflow-y: auto">                
        <div class="portlet-body">
            <legend>Digite a minuta</legend>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nr_minuta">Minuta</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nr_minuta">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer modal-xs" style="background-color: #2F4F4F;">
        <button type="submit" class="btn btn-primary" id="btnSaveSaida" value="<?php echo $id_prt;?>">Salvar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
 </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#ins_minuta_saida').modal('show');
    });
</script>