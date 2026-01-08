<!DOCTYPE html>
<html lang="pt-br">
<head>
</head>
<body>
    <div class="container theme-showcase" role="main">
        <?php

        require_once('bd_class_dsv.php');

        $ds_tipo = $_POST['ds_tipo'];
        $dt_inicio = $_POST['dt_inicio'];
        $dt_fim = $_POST['dt_fim'];
        $id_galpao = $_POST['id_galpao'];
        $id_rua_inicio = $_POST['id_rua_inicio'];
        $id_coluna_inicio = $_POST['id_coluna_inicio'];
        $id_rua_fim = $_POST['id_rua_fim'];
        $id_coluna_fim = $_POST['id_coluna_fim'];
        $id_grupo = $_POST['id_grupo'];
        $id_sub_grupo = $_POST['id_sub_grupo'];
        $id_produto = $_POST['id_produto'];

        $objDb = new db();
        $link = $objDb->conecta_mysql();

        if($id_galpao == '0' or $dt_inicio == "" or $dt_fim == ""){?>

            <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #FFA07A">
                            <h4 class="modal-title" id="myModalLabel">Atenção!</h4>
                        </div>
                        <div class="modal-body">                                
                            <h3>É necessário selecionar as datas do inventário e o armazém!</h3>
                        </div>
                        <div class="modal-footer">
                            <a href="http://localhost/WMS_dsv/wms/html/inv_programacao.php"><button type="button" class="btn btn-danger">Ok</button></a>
                        </div>
                    </div>
                </div>
            </div>          
            <script>
                $(document).ready(function () {
                    $('#conf_cadastro').modal('show');
                });
            </script> <?php
        } else{

            $sql_inv = " insert into tb_inv_prog (ds_tipo, dt_inicio, dt_fim, id_galpao, id_rua_inicio, id_coluna_inicio, id_rua_fim, id_coluna_fim, id_grupo, id_sub_grupo, id_produto, fl_status) values ('$ds_tipo', '$dt_inicio', '$dt_fim',  '$id_galpao', '$id_rua_inicio', '$id_coluna_inicio', '$id_rua_fim', '$id_coluna_fim', '$id_grupo', '$id_sub_grupo', '$id_produto', 'A') ";

            $resultado_id = mysqli_query($link, $sql_inv);

            if(mysqli_affected_rows($link) > 0){ ?>

            <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #98FB98; text-align: center">
                            <h4 class="modal-title" id="myModalLabel">Inventário agendado com sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            <p><h3>Não esqueça de se planejar!</h3></p> 
                            <p><h4>O inventário não poderá ser ativado se houver alguma movimentação pendente e quando o inventário for ativado as movimentações serão bloqueadas.</h4></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
                        <div class="modal-header" style="background-color: #FFA07A">
                            <h4 class="modal-title" id="myModalLabel">Erro no cadastro!</h4>
                        </div>
                        <div class="modal-body">                                

                        </div>
                        <div class="modal-footer">
                            <a href="http://localhost/WMS_dsv/wms/html/inv_programacao.php#tab_1_2"><button type="button" class="btn btn-danger">Ok</button></a>
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
        }
        $link->close();
        ?>