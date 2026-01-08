<!DOCTYPE html>
<html lang="pt-br">
    <head>
    </head>
    <body>
    <div class="container theme-showcase" role="main">
<?php

    require_once('bd_class.php');

    $galpao = $_POST['galpao'];
    $ds_apelido = $_POST['ds_apelido'];
    $g_cidade = $_POST['g_cidade'];
    $g_uf = $_POST['g_uf'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();
    
    $sql = " insert into tb_galpao (galpao, ds_apelido, g_cidade, g_uf, fl_status) values ('$galpao', '$ds_apelido', '$g_cidade',  '$g_uf', 1) ";

           $resultado_id = mysqli_query($link, $sql);

            if(mysqli_affected_rows($link) > 0){ ?>

                <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Cadastro realizado com sucesso!</h4>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                            <a href="http://www.gisis.com.br/app/WMS/wms/html/armazem.php"><button type="button" class="btn btn-success">Ok</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $('#conf_cadastro').modal('show');
                    });
                </script>

                <?php }else{ ?>    

                <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Erro no cadastro!</h4>
                            </div>
                            <div class="modal-body">                                

                            </div>
                            <div class="modal-footer">
                                <a href="http://www.gisis.com.br/app/WMS/wms/html/armazem.php"><button type="button" class="btn btn-danger">Ok</button></a>
                            </div>
                        </div>
                    </div>
                </div>          
                <script>
                    $(document).ready(function () {
                        $('#conf_cadastro').modal('show');
                    });
                </script>
    <?php }
    
   
$link->close();
?>