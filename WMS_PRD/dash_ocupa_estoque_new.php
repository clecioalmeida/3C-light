<?php
    $servidor = "mysql.gisis.com.br";
    $usuario = "gisis";
    $senha = "wmsweb2017";
    $dbname = "gisis";
    
    //Criar a conexão
    $link = mysqli_connect($servidor, $usuario, $senha, $dbname);

    $sql_local = "select * from tb_armazem";
    $res_local = mysqli_query($link, $sql_local);
                
$link->close();
 ?>

        <style type="text/css">
            .ocupado {
                background-color: #F08080;
            }

            .tabela {
                width: 5px;
                height: 3px;
                font-size: xx-small;
                background-color: #F08080;
            }

            .livre {
                background-color: #7FFFD4;
            }

            .altura {
                width: 5px;
                height: 3px;
            }

            .coluna {
                width: 5px;
                height: 3px;
                background-color: #81BEF7;
            }

            .area {
                width: 30px;
                height: 20px;
                float: left;
                background-color: #87CEEB;
            }
        </style>
<div id="main" role="main">
    <div id="ribbon">
        <ol class="breadcrumb">
            <li>Home</li><li>Dashboard</li><li>Ocupação de estoque</li>
        </ol>
    </div>
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                </h1>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            </div>
        </div>
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div>
                        <div class="jarviswidget-editbox">
                            <input class="form-control" type="text">    
                        </div>
                        <div class="widget-body">
                            <section id="widget-grid" class="">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-8 control-label" for="form_control_estoque"><h3>Galpão: </h3></label>
                                    </div>
                                </div>
                                <fieldset>
                                                                <div class="col-sm-4" style="text-align: left;">
                                                                    <div class="form-group">
                                                                        <label>Armazém</label>
                                                                        <select class="form-control" id="id_armazem" name="id_armazem" required="true">
                                                                            <option value="">Todos</option>
                                                                            <?php
                                                                                while ($row_select_local = mysqli_fetch_assoc($res_local)) {
                                                                                echo '<option value="'.$row_select_local['id'].'">'.$row_select_local['nome'].'</option>';
                                                                                 } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="widget-body">
                                            <p>
                                                <code>
                                                    Legenda
                                                </code>
                                            </p>
                                            <a href="javascript:void(0);" class="btn btn-success btn-xs">Livre</a>
                                            <a href="javascript:void(0);" class="btn btn-warning btn-xs">Reservado</a>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-xs">Ocupado</a>
                                            <a href="javascript:void(0);" class="btn btn-primary btn-xs " style="background-color: black">Bloqueado</a>
                                        </div>
                                    </div>
                                    <div id="retornoDash"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="retornoTable">
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
            </article>
        </div>
    </div>
<div class="row">
    <div class="col-sm-12"></div>
</div>
<div class="modal fade" id="ModalDetalhe" tabindex="2" role="dialog" style="margin-top: 100px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2F4F4F;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="color: white">Produtos alocados</h3>
            </div>
            <div class="modal-body modal-lg">
                <div class="row">
                    <div id="retorno"></div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #2F4F4F;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->