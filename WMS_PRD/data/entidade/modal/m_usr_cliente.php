<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_usr_cliente = mysqli_real_escape_string($link, $_POST["usr_cliente"]);


$sql = "select * from tb_cliente where fl_tipo = 'U' and cod_cli = '$id_usr_cliente'"; 
$res = mysqli_query($link,$sql); 

$link->close();
?>
<div class="modal fade" id="usuarios_cliente" aria-hidden="true">
        <form method="POST" action="" id="formUpdCliente">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #2F4F4F;">
                        <h5 class="modal-title text-center" style="color: white"></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body modal-lg" style="overflow-y: auto">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                <th colspan="3"> Ações </th>
                                <th> Código</th>
                                <th> Nome </th>
                                <th> E-mail </th>
                                <th> Nivel </th>
                                <th> Ativo </th>
                                <th> Permissões </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($dados = mysqli_fetch_array($res)) { ?>
                            <tr class="odd gradeX">
                                <td style="text-align: center; width: 5px">  
                                    <button type="submit" id="btnDtlUsrCliente" class="btn btn-default btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Detalhe</button>
                                </td>
                                <td style="text-align: center; width: 5px">
                                    <button type="submit" id="btnUpdUsrCliente" class="btn btn-default btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Alterar</button>
                                </td>
                                <td style="text-align: center; width: 5px">
                                    <button type="submit" id="btnDelUsrCliente" class="btn btn-default btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Excluir</button>
                                </td>
                                <td style="text-align: center; width: 20px" data-toggle="modal" data-target="#detalhe_usuario<?php echo $dados['cod_cliente']; ?>"> <?php echo $dados['cod_cliente']; ?> </td>
                                <td> <?php echo $dados['nm_cliente']; ?> </td>
                                <td> <?php echo $dados['ds_email']; ?> </td>
                                <td> <?php echo $dados['fl_nivel']; ?> </td>
                                <td> <?php echo $dados['fl_status']; ?> </td>
                                <td style="text-align: center; width: 15px">  
                                    <button type="submit" id="btnPerUsrCliente" class="btn btn-default btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Permissões</button>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div id="detalhe"></div>                        
                    </div>
                    <div class="modal-footer" style="background-color: #2F4F4F;">
                        <button type="submit" class="btn btn-secondary" data-dismiss="modal" style="float: left">Fechar</button>
                        <button type="button" class="btn btn-primary" id="btnNewUsrCliente">Novo</button>
                        <button type="submit" class="btn btn-primary" id="btnFormUpdUsrCliente">Alterar</button>
                    </div>
                </div>
            </div>
        </form>
    </div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#usuarios_cliente').modal('show');
    });
</script>