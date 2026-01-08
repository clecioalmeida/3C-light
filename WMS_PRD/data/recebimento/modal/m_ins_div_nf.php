<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:../../index.php");
  exit;

}else{

  $id     = $_SESSION["id"];
  $cod_cli  = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$query_prod = "SELECT * from tb_div_nf where fl_empresa = '$cod_cli'";
$res_prod = mysqli_query($link,$query_prod);

$link->close();
?>
<style type="text/css">

  .tableFixHead          { overflow-y: auto; height: 640px; }
  .tableFixHead thead th { position: sticky; top: 0; }
  table  { border-collapse: collapse; width: 100%; }
  th, td { padding: 8px 16px; }
  th     { background:#eee; }

  /* CAMPO INPUT DENTRO DA TD */

  table td {
    position: relative;
}

table td input {
    position: absolute;
    display: block;
    top:0;
    left:0;
    margin: 0;
    height: 100%;
    width: 100%;
    border: none;
    padding: 10px;
    box-sizing: border-box;
    font-size: 12px;
    text-align: left;

</style>
<div class="modal fade" id="ins_div" tabindex="-1" role="dialog">
    <form method="post" action="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #22262E;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color: white">INCLUSÃO DE DIVERGÊNCIAS DE NOTAS FISCAIS</h4>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <section>
                          <div class="form-group">
                            <label for="nm_expedidor" class="control-label col-sm-4">DIVERGÊNCIA</label>
                            <div class="col-md-8">       
                              <div class="input-group input-group-md">
                                <input class="form-control" id="ds_div" name="ds_div" placeholder="DIGITE A DIVERGÊNCIA" type="text">
                                <span class="input-group-btn">
                                    <button class="btn btn-info" type="button" id="btnSavDivNf" style="height: 32px"><span class="fa fa-save" title data-original-title="SALVAR"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </section>
                </fieldset>
                <hr>
                <fieldset>
                    <section>
                        <div class="tableFixHead">
                            <table id="" class="table" data-detail-view="" data-pagination="true" data-pagination-pre-text="< Previous" data-pagination-next-text="Next >" data-classes="table table-hover table-condensed" style="font-size: 12px">
                               <tr>
                                <th>ID</th>
                                <th>DIVERGÊNCIA</th>
                                <th>AÇÕES</th>
                            </tr>
                            <tbody id="listTbDivNf"> 
                            </tbody>
                        </table>
                    </div>
                </section>
            </fieldset>
        </div>
        <div class="modal-footer" style="background-color: #22262E;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>
</div>
</form>
</div>
<script>
    $(document).ready(function () {
        $('#ins_div').modal('show');

        $('#listTbDivNf').load('data/recebimento/list_tb_div_nf.php');
    });
</script>