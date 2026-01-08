<div class="container theme-showcase" role="main">
    <?php

        require_once('bd_class_dsv.php');

        $id_tar = $_POST['id_tar'];

        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $consulta_conf="select t1.*, t2.id_estoque, t2.id_produto, t2.nr_qtde 
        from tb_inv_conf t1
        left join tb_inv_tarefa t2 on t1.id_tar = t2.id 
        where id_tar = '$id_tar'";
        $consulta = mysqli_query($link, $consulta_conf);

            while ($dados_conf = mysqli_fetch_assoc($consulta)) {

            $id_tar_conf=$dados_conf['id_tar'];
            $id_conf=$dados_conf['id'];
            $cont_1_conf=$dados_conf['cont_1'];
            $cont_2_conf=$dados_conf['cont_2'];
            $cont_3_conf=$dados_conf['cont_3'];
            $conf_1_conf=$dados_conf['conf_1'];
            $conf_2_conf=$dados_conf['conf_2'];
            $conf_3_conf=$dados_conf['conf_3'];
            $dt_conf_1_conf=$dados_conf['dt_conf_1'];
            $dt_conf_2_conf=$dados_conf['dt_conf_2'];
            $dt_conf_3_conf=$dados_conf['dt_conf_3'];
            $cod_estoque=$dados_conf['id_estoque'];
            $id_produto=$dados_conf['id_produto'];
            $nr_qtde=$dados_conf['nr_qtde'];
            
            }

            if($id_tar_conf != ""){ ?>

                <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #FFA07A">
                                <h4 class="modal-title" id="myModalLabel">Atenção!</h4>
                                <h5 class="modal-title" id="myModalLabel">Estoque:<?php echo $cod_estoque;?></h5>
                                <h5 class="modal-title" id="myModalLabel">Quantidade:<?php echo $nr_qtde;?></h5>
                                <h5 class="modal-title" id="myModalLabel">Produto:<?php echo $id_produto;?></h5>
                            </div>
                            <div class="modal-body modal-lg">    
                                <form class="form-inline" method="post" action="inv_conf_dtl.php" id="formConf2" role="form">    
                                    <input type="hidden" name="id_conf" value="<?php echo $id_conf; ?>">               
                                    <fieldset>
                                        <header>
                                            <legend>Primeira conferência</legend>
                                        </header>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input type="text" name="cont_1" value="<?php echo $cont_1_conf; ?>" class="form-control" id="cont_1" placeholder="Primeira contagem">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="conf_1" value="<?php echo $conf_1_conf; ?>" class="form-control" id="conf_1" placeholder="Conferente 1">
                                            </div>
                                            <div class="form-group">
                                                <input type="date" name="dt_conf_1" value="<?php echo $dt_conf_1_conf; ?>" class="form-control" id="dt_conf_1" placeholder="Data"> 
                                            </div>
                                        </div>
                                    </fieldset><br/><br/>
                                    <fieldset>
                                        <header>
                                            <legend>Segunda conferência</legend>
                                        </header>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input type="text" name="cont_2" value="<?php echo $cont_2_conf; ?>" class="form-control" id="cont_2" placeholder="Segunda contagem">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="conf_2" value="<?php echo $conf_2_conf; ?>" class="form-control" id="conf_2" placeholder="Conferente 2">
                                            </div>
                                            <div class="form-group">
                                                <input type="date" name="dt_conf_2" value="<?php echo $dt_conf_2_conf; ?>" class="form-control" id="dt_conf_2" placeholder="Data"> 
                                            </div>
                                        </div>
                                    </fieldset><br/><br/>
                                    <fieldset>
                                        <header>
                                            <legend>Terceira conferência</legend>
                                        </header>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input type="text" name="cont_3" value="<?php echo $cont_3_conf; ?>" class="form-control" id="cont_3" placeholder="Terceira contagem">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="conf_3" value="<?php echo $conf_3_conf; ?>" class="form-control" id="conf_3" placeholder="Conferente 3">
                                            </div>
                                            <div class="form-group">
                                                <input type="date" name="dt_conf_3" value="<?php echo $dt_conf_3_conf; ?>" class="form-control" id="dt_conf_3" placeholder="Data"> 
                                            </div>
                                        </div>
                                    </fieldset> <br/><br/>
                                    <fieldset>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>  <?php

                //$update="update tb_inv_conf set cont_1 = '$cont_1', cont_2 = '$cont_2', cont_3 = '$cont_3'";
                //$res_update = mysqli_query($link, $update);

            } else{

                $consulta_conf="select * from tb_inv_tarefa where id = '$id_tar'";
                    $consulta = mysqli_query($link, $consulta_conf);

                        while ($dados_conf = mysqli_fetch_assoc($consulta)) {
                        
                        $cod_estoque=$dados_conf['id_estoque'];
                        $id_produto=$dados_conf['id_produto'];
                        $nr_qtde=$dados_conf['nr_qtde'];
                        
                        }

                $insert_conf="insert into tb_inv_conf (id_tar) values ('$id_tar')";
                $res_conf = mysqli_query($link, $insert_conf);
                $id_conf = mysqli_insert_id($link);

                if(mysqli_affected_rows($link) > 0){ ?>

                    <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #FFA07A">
                                    <h4 class="modal-title" id="myModalLabel">Atenção!</h4>
                                <h5 class="modal-title" id="myModalLabel">Estoque:<?php echo $cod_estoque;?></h5>
                                <h5 class="modal-title" id="myModalLabel">Quantidade:<?php echo $nr_qtde;?></h5>
                                <h5 class="modal-title" id="myModalLabel">Produto:<?php echo $id_produto;?></h5>
                                </div>
                                <div class="modal-body modal-lg">                                
                                    <form class="form-inline" method="post" action="inv_conf_dtl.php" id="formConf2" role="form"> 
                                    <input type="hidden" name="id_conf" value="<?php echo $id_conf; ?>">                        
                                    <fieldset>
                                        <header>
                                            <legend>Primeira conferência</legend>
                                        </header>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input type="text" name="cont_1" value="" class="form-control" id="cont_1" placeholder="Primeira contagem">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="conf_1" value="" class="form-control" id="conf_1" placeholder="Conferente 1">
                                            </div>
                                            <div class="form-group">
                                                <input type="date" name="dt_conf_1" value="" class="form-control" id="dt_conf_1" placeholder="Data"> 
                                            </div>
                                        </div>
                                    </fieldset><br/><br/>
                                    <fieldset>
                                        <header>
                                            <legend>Segunda conferência</legend>
                                        </header>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input type="text" name="cont_2" value="" class="form-control" id="cont_2" placeholder="Segunda contagem">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="conf_2" value="" class="form-control" id="conf_2" placeholder="Conferente 2">
                                            </div>
                                            <div class="form-group">
                                                <input type="date" name="dt_conf_2" value="" class="form-control" id="dt_conf_2" placeholder="Data"> 
                                            </div>
                                        </div>
                                    </fieldset><br/><br/>
                                    <fieldset>
                                        <header>
                                            <legend>Terceira conferência</legend>
                                        </header>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input type="text" name="cont_3" value="" class="form-control" id="cont_3" placeholder="Terceira contagem">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="conf_3" value="" class="form-control" id="conf_3" placeholder="Conferente 3">
                                            </div>
                                            <div class="form-group">
                                                <input type="date" name="dt_conf_3" value="" class="form-control" id="dt_conf_3" placeholder="Data"> 
                                            </div>
                                        </div>
                                    </fieldset> <br/><br/>
                                    <fieldset>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </fieldset>
                                </form>
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
                    </script> <?php

                }

            }
        $link->close();
    ?>