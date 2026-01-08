<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
        $id_oper=$_SESSION["cod_cli"];
    }
?>
<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$select_doca = "select * from tb_doca";
$res_doca = mysqli_query($link,$select_doca);

$select_galpao = "select * from tb_armazem where id_oper = '$id_oper'";
$res_galpao = mysqli_query($link,$select_galpao);

    $link->close();
?>
<div class="modal fade" id="novo_registro" aria-hidden="true">
 <form method="post" action="" id="formInsPedido">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" style="color: white">NOVO REGISTRO</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">                
        <div class="portlet-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="ds_placa">Placa</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="ds_placa" value="">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="ds_veiculo">Veículo</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="ds_veiculo">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br />
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="ds_empresa">Empresa</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="ds_empresa" value="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br />
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="ds_nome">Nome</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="ds_nome" value="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br />
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="ds_dpto">Departamento</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="ds_dpto" value="">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="ds_contato">Contato</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="ds_contato" value="">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="ds_motivo">Motivo</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" value="" id="ds_motivo">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br />
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="ds_galpao">Armazém</label>
                    <div class="col-sm-2">
                        <select class="form-control" id="ds_galpao" name="ds_galpao" required="true">
                            <option>Armazém</option>
                               <?php
                                while ($dados_galpao=mysqli_fetch_assoc($res_galpao)) {?>

                                <option value="<?php echo $dados_galpao['id']; ?>"><?php echo $dados_galpao['ds_apelido']."-".$dados_galpao['nome']; ?></option>

                            <?php } ?>
                        </select>
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="ds_doca">Doca</label>
                    <div class="col-sm-2">
                        <select class="form-control" id="ds_doca" name="ds_doca" required="true">
                            <option></option>
                        </select>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br />
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="dt_saida">Saída</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="dt_saida" value="">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="hr_saida">Hora</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="hr_saida" value="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div><br />
            <div class="row">
                <label class="col-sm-2 control-label" for="ds_obs">Observações</label>
                <div class="col-sm-10">
                    <textarea type="textarea" class="form-control" id="ds_obs" value=""></textarea>
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer" style="background-color: #22262E;">
        <button type="submit" class="btn btn-primary" id="btnSaveRegPrt">Salvar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseRegPrt">Fechar</button>
      </div>
    </div>
  </div>
 </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#novo_registro').modal('show');
    });
</script>