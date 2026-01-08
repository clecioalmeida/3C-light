<!DOCTYPE html>
<html lang="pt-br">
<head>
</head>
<body>
    <div class="container theme-showcase" role="main">
    <?php

        require_once('bd_class_dsv.php');

        $id = $_POST['id_conf'];
        $cont_1 = $_POST['cont_1'];
        $conf_1 = $_POST['conf_1'];
        $dt_conf_1 = $_POST['dt_conf_1'];
        $cont_2 = $_POST['cont_2'];
        $conf_2 = $_POST['conf_2'];
        $dt_conf_2 = $_POST['dt_conf_2'];
        $cont_3 = $_POST['cont_3'];
        $conf_3 = $_POST['conf_3'];
        $dt_conf_3 = $_POST['dt_conf_3'];

        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $update="update tb_inv_conf set cont_1 = '$cont_1', conf_1 = '$conf_1', dt_conf_1 = '$dt_conf_1', cont_2 = '$cont_2', conf_2 = '$conf_2', dt_conf_2 = '$dt_conf_2', cont_3 = '$cont_3', conf_3 = '$conf_3', dt_conf_3 = '$dt_conf_3' where id = '$id'";
        $res_update = mysqli_query($link, $update);

        if(mysqli_affected_rows($link) > 0){ ?>

            <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #98FB98; text-align: center">
                            <h4 class="modal-title" id="myModalLabel">Dados cadastrados com sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                        <div class="modal-footer">
                            <a href="http://localhost/WMS_dsv/wms/html/inv_programacao.php"><button type="button" class="btn btn-success">Ok</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('#conf_cadastro').modal('show');
                });
            </script> <?php

        } else{ ?>

            <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #FFA07A">
                            <h4 class="modal-title" id="myModalLabel">Erro no cadastro!</h4>
                        </div>
                        <div class="modal-body">                                

                        </div>
                        <div class="modal-footer">
                            <a href="http://localhost/app/WMS_dsv/wms/html/inv_programacao.php"><button type="button" class="btn btn-danger">Ok</button></a>
                        </div>
                    </div>
                </div>
            </div>          
            <script>
                $(document).ready(function () {
                    $('#conf_cadastro').modal('show');
                });
            </script> <?php

        }

        $link->close();
    ?>