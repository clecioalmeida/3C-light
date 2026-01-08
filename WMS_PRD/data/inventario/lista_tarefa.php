<!DOCTYPE html>
<html lang="pt-br">
    <head>
    </head>
    <body>
    <div class="container theme-showcase" role="main">
<?php

    require_once('bd_class_dsv.php');

    $nr_inv = $_POST['nr_inv'];
    $id_galpao = $_POST['id_galpao'];
    $id_produto = $_POST['id_produto'];
    $id_rua_inicio = $_POST['id_rua_inicio'];
    $id_rua_fim = $_POST['id_rua_fim'];
    $id_coluna_inicio = $_POST['id_coluna_inicio'];
    $id_coluna_fim = $_POST['id_coluna_fim'];
    $fl_status = $_POST['fl_status'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    if($fl_status == 'P'){

        if($id_rua_inicio == '0'){
            $sql="select t1.*, t2.cod_estoque, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.produto, t2.nr_qtde, t2.produto, t3.nome 
            from tb_inv_prog t1 
            left join tb_posicao_pallet t2 on t1.id_galpao = t2.ds_galpao
            left join tb_armazem t3 on t1.id_galpao = t3.id
            where t1.id = '$nr_inv'
            order by t1.fl_status desc";
            $res = mysqli_query($link, $sql);

            if(mysqli_affected_rows($link) > 0){

                include 'tarefas.php';

            } else{ ?>

                <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #FFA07A">
                                <h4 class="modal-title" id="myModalLabel">Atenção!</h4>
                            </div>
                            <div class="modal-body">                                
                                <?php echo "<h3>Não foram encontradas as informações solicitadas!</h3>"; ?>
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

        }else{

            $sql="select t1.*, t2.cod_estoque, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.produto, t2.nr_qtde, t2.produto, t3.nome 
            from tb_inv_prog t1 
            left join tb_posicao_pallet t2 on t1.id_galpao = t2.ds_galpao
            left join tb_armazem t3 on t1.id_galpao = t3.id
            where t1.id = '$nr_inv' and t2.ds_prateleira BETWEEN '$id_rua_inicio' and '$id_rua_fim' and t2.ds_coluna between '$id_coluna_inicio' and '$id_coluna_fim'
            order by t1.fl_status desc";
            $res = mysqli_query($link, $sql);

            if(mysqli_affected_rows($link) > 0){

                include 'tarefas.php';

            } else{ ?>

                <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #FFA07A">
                                <h4 class="modal-title" id="myModalLabel">Atenção!</h4>
                            </div>
                            <div class="modal-body">                                
                                <?php echo "<h3>Não foram encontradas as informações solicitadas!</h3>"; ?>
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
        }

    }else{ ?>

        <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #FFA07A">
                        <h4 class="modal-title" id="myModalLabel">Atenção!</h4>
                    </div>
                    <div class="modal-body">                                
                        <?php echo "<h3>Para que as tarefas sejam geradas é necessário que o inventário esteja ativo!</h3>"; ?>
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