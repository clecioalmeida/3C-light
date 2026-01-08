<?php
    $servidor = "mysql.gisis.com.br";
    $usuario = "gisis";
    $senha = "wmsweb2017";
    $dbname = "gisis";
    
    //Criar a conexão
    $link = mysqli_connect($servidor, $usuario, $senha, $dbname);

    //$sql_posicao = "select id from tb_endereco where exists (select distinct(id_endereco) from tb_posicao_pallet where nr_qtde is not null)";
    $sql_posicao = "SELECT distinct(id) FROM tb_endereco e
WHERE NOT EXISTS (SELECT distinct(id_endereco) FROM tb_posicao_pallet p WHERE e.id = p.id_endereco)";

    $res_posicao = mysqli_query($link,$sql_posicao);
    $sql_endereco = "select id from tb_endereco";
    $res_endereco = mysqli_query($link,$sql_endereco);

    $sql_altura = "select distinct(altura) from tb_endereco where galpao = 17 and rua = 'M01'";
    $res_altura = mysqli_query($link,$sql_altura);

    $sql_alturaA03 = "select distinct(altura) from tb_endereco where galpao = 17 and rua = 'M02'";
    $res_alturaA03 = mysqli_query($link,$sql_alturaA03);

    $sql_coluna = "select distinct(coluna) from tb_endereco where galpao = 17 and rua = 'M01'";
    $res_coluna = mysqli_query($link,$sql_coluna);

    $sql_colunaA03 = "select distinct(coluna) from tb_endereco where galpao = 17 and rua = 'M02'";
    $res_colunaA03 = mysqli_query($link,$sql_colunaA03);

    $sql_colunaA05 = "select distinct(coluna) from tb_endereco where galpao = 17 and rua = 'M03'";
    $res_colunaA05 = mysqli_query($link,$sql_colunaA05);

    $sql_colunaA07 = "select distinct(coluna) from tb_endereco where galpao = 17 and rua = 'M04'";
    $res_colunaA07 = mysqli_query($link,$sql_colunaA07);

    $sql_colunaA09 = "select distinct(coluna) from tb_endereco where galpao = 17 and rua = 'M05'";
    $res_colunaA09 = mysqli_query($link,$sql_colunaA09);

    $sql_colunaA17 = "select distinct(coluna) from tb_endereco where galpao = 17 and rua = 'M06'";
    $res_colunaA17 = mysqli_query($link,$sql_colunaA17);

    $sql_colunaA13 = "select distinct(coluna) from tb_endereco where galpao = 17 and rua = 'M07'";
    $res_colunaA13 = mysqli_query($link,$sql_colunaA13);

    $sql_colunaA151 = "select distinct(coluna) from tb_endereco where galpao = 17 and rua = 'M08'";
    $res_colunaA151 = mysqli_query($link,$sql_colunaA151);

    $sql_colunaA152 = "select distinct(coluna) from tb_endereco where galpao = 17 and rua = 'M09'";
    $res_colunaA152 = mysqli_query($link,$sql_colunaA152);

    $sql_colunaA162 = "select distinct(coluna) from tb_endereco where galpao = 17 and rua = 'M10'";
    $res_colunaA162 = mysqli_query($link,$sql_colunaA162);

    $galpao = "select distinct(t2.nome) from tb_endereco t1 left join tb_armazem t2 on t1.galpao = t2.id";
    $res_galpao = mysqli_query($link,$galpao);

    $sql = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.id = t2.id_endereco where t1.galpao = 17 and t1.rua = 'M01' and t1.altura = 'A' group by t1.id";
    $res = mysqli_query($link,$sql);

    $sql4 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.id = t2.id_endereco where t1.galpao = 17 and t1.rua = 'M02' and t1.altura = 'A' group by t1.id";
    $res4 = mysqli_query($link,$sql4);

    $sql8 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.id = t2.id_endereco where t1.galpao = 17 and t1.rua = 'M03' and t1.altura = 'A' group by t1.id";
    $res8 = mysqli_query($link,$sql8);

    $sql12 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.id = t2.id_endereco where t1.galpao = 17 and t1.rua = 'M04' and t1.altura = 'A' group by t1.id";
    $res12 = mysqli_query($link,$sql12);

    $sql16 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.id = t2.id_endereco where t1.galpao = 17 and t1.rua = 'M05' and t1.altura = 'A' group by t1.id";
    $res16 = mysqli_query($link,$sql16);

    $sql20 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.id = t2.id_endereco where t1.galpao = 17 and t1.rua = 'M06' and t1.altura = 'A' group by t1.id";
    $res20 = mysqli_query($link,$sql20);

    $sql24 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.id = t2.id_endereco where t1.galpao = 17 and t1.rua = 'M07' and t1.altura = 'A' group by t1.id";
    $res24 = mysqli_query($link,$sql24);

    $sql28 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.id = t2.id_endereco where t1.galpao = 17 and t1.rua = 'M08' and t1.altura = 'A' group by t1.id";
    $res28 = mysqli_query($link,$sql28);

    $sql32 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.id = t2.id_endereco where t1.galpao = 17 and t1.rua = 'M09' and t1.altura = 'A' group by t1.id";
    $res32 = mysqli_query($link,$sql32);

    $sql33 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.id = t2.id_endereco where t1.galpao = 17 and t1.rua = 'M10' and t1.altura = 'A' group by t1.id";
    $res33 = mysqli_query($link,$sql33);
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
                <div class="jarviswidget" id="wid-id-0">
                    <div>
                        <div class="jarviswidget-editbox">
                            <input class="form-control" type="text">    
                        </div>
                        <div class="widget-body">
                            <section id="widget-grid" class="">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-8 control-label" for="form_control_estoque"><h3>Galpão: Pátio 04 - Torres</h3></label>
                                        <!--div class="col-md-2">
                                            <select class="form-control">
                                                    <?php
                                                while($dados_galpao = mysqli_fetch_array($res_galpao)) {?>

                                                <option id="galpao" value="<?php echo $dados_galpao['nome']; ?>"><?php echo $dados_galpao['nome']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="form-control-focus"> </div>
                                        </div-->
                                    </div>
                                </div>
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
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered tb_estoque" style="width: 300px">
                                            <!--legend>Rua M01</legend-->
                                            <tbody>
                                                <th class="altura">#</th>
                                                            <?php
                                                    while($coluna = mysqli_fetch_array($res_coluna)) {?>
                                                    <td class="coluna"><?php echo $coluna['coluna']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                            <tbody>
                                                <td class="altura">M01</td>
                                                <?php
                                                    while($g17a01A = mysqli_fetch_array($res)) {?>
                                                            <!--td class="tabela" id="g17a01A" data-endereco="<?php echo $g17a01A['id']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a01A['rua'].$g17a01A['coluna'].$g17a01A['altura'] ?>"><?php echo $g17a01A['produto']; ?>
                                                            </td-->
                                                    <td class="tabela" id="g17a01A" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a01A['rua'].$g17a01A['coluna'].$g17a01A['altura'] ?>" data-endereco="<?php echo $g17a01A['id']; ?>"><?php echo $g17a01A['produto']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered tb_estoque" style="width: 300px">
                                            <tbody>
                                                <th class="altura">#</th>
                                                    <?php
                                                    while($colunaA03 = mysqli_fetch_array($res_colunaA03)) {?>
                                                    <td class="coluna"><?php echo $colunaA03['coluna']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                            <tbody>
                                                <td class="altura">M02</td>
                                                <?php
                                                    while($g17a03A = mysqli_fetch_array($res4)) {?>
                                                    <td class="tabela" id="g17a03A" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a03A['rua'].$g17a03A['coluna'].$g17a03A['altura'] ?>" data-endereco="<?php echo $g17a03A['id']; ?>"><?php echo $g17a03A['produto']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered tb_estoque" style="width: 300px">
                                            <tbody>
                                                <th class="altura">#</th>
                                                        <?php
                                                    while($colunaA05 = mysqli_fetch_array($res_colunaA05)) {?>
                                                    <td class="coluna"><?php echo $colunaA05['coluna']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                            <tbody>
                                                <td class="altura">M03</td>
                                                <?php
                                                    while($g17a05A = mysqli_fetch_array($res8)) {?>
                                                    <td class="tabela" id="g17a05A" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a05A['rua'].$g17a05A['coluna'].$g17a05A['altura'] ?>" data-endereco="<?php echo $g17a05A['id']; ?>"><?php echo $g17a05A['produto']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered tb_estoque" style="width: 300px">
                                            <tbody>
                                                <th class="altura">#</th>
                                                    <?php
                                                    while($colunaA07 = mysqli_fetch_array($res_colunaA07)) {?>
                                                    <td class="coluna"><?php echo $colunaA07['coluna']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                            <tbody>
                                                <td class="altura">M04</td>
                                                <?php
                                                    while($g17a07A = mysqli_fetch_array($res12)) {?>
                                                    <td class="tabela" id="g17a07A" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a07A['rua'].$g17a07A['coluna'].$g17a07A['altura'] ?>" data-endereco="<?php echo $g17a07A['id']; ?>"><?php echo $g17a07A['produto']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered tb_estoque" style="width: 300px">
                                            <tbody>
                                                <th class="altura">#</th>
                                                        <?php
                                                    while($colunaA09 = mysqli_fetch_array($res_colunaA09)) {?>
                                                    <td class="coluna"><?php echo $colunaA09['coluna']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                            <tbody>
                                                <td class="altura">M05</td>
                                                <?php
                                                    while($g17a09A = mysqli_fetch_array($res16)) {?>
                                                    <td class="tabela" id="g17a09A" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a09A['rua'].$g17a09A['coluna'].$g17a09A['altura'] ?>" data-endereco="<?php echo $g17a09A['id']; ?>"><?php echo $g17a09A['produto']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered tb_estoque" style="width: 300px">
                                            <tbody>
                                                <th class="altura">#</th>
                                                        <?php
                                                    while($colunaA17 = mysqli_fetch_array($res_colunaA17)) {?>
                                                    <td class="coluna"><?php echo $colunaA17['coluna']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                            <tbody>
                                                <td class="altura">M06</td>
                                                <?php
                                                    while($g17a17A = mysqli_fetch_array($res20)) {?>
                                                    <td class="tabela" id="g17a17A" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a17A['rua'].$g17a17A['coluna'].$g17a17A['altura'] ?>" data-endereco="<?php echo $g17a17A['id']; ?>"><?php echo $g17a17A['produto']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered tb_estoque" style="width: 300px">
                                            <tbody>
                                                <th class="altura">#</th>
                                                    <?php
                                                    while($colunaA13 = mysqli_fetch_array($res_colunaA13)) {?>
                                                    <td class="coluna"><?php echo $colunaA13['coluna']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                            <tbody>
                                                <td class="altura">M07</td>
                                                <?php
                                                    while($g17a13A = mysqli_fetch_array($res24)) {?>
                                                    <td class="tabela" id="g17a13A" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a13A['rua'].$g17a13A['coluna'].$g17a13A['altura'] ?>" data-endereco="<?php echo $g17a13A['id']; ?>"><?php echo $g17a13A['produto']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered tb_estoque" style="width: 300px">
                                            <tbody>
                                                <th class="altura">#</th>
                                                    <?php
                                                    while($colunaA151 = mysqli_fetch_array($res_colunaA151)) {?>
                                                    <td class="coluna"><?php echo $colunaA151['coluna']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                            <tbody>
                                                <td class="altura">M08</td>
                                                <?php
                                                     while($g17a15A = mysqli_fetch_array($res28)) {?>
                                                    <td class="tabela" id="g17a15A" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a15A['rua'].$g17a15A['coluna'].$g17a15A['altura'] ?>" data-endereco="<?php echo $g17a15A['id']; ?>"><?php echo $g17a15A['produto']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered tb_estoque" style="width: 300px">
                                            <tbody>
                                                <th class="altura">#</th>
                                                <?php
                                                    while($colunaA152 = mysqli_fetch_array($res_colunaA152)) {?>
                                                    <td class="coluna"><?php echo $colunaA152['coluna']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                            <tbody>
                                                <td class="altura">M09</td>
                                                <?php
                                                     while($g17a152A = mysqli_fetch_array($res32)) {?>
                                                    <td class="tabela" id="g17a152A" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a152A['rua'].$g17a152A['coluna'].$g17a152A['altura'] ?>" data-endereco="<?php echo $g17a152A['id']; ?>"><?php echo $g17a152A['produto']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered tb_estoque" style="width: 300px">
                                            <tbody>
                                                <th class="altura">#</th>
                                                    <?php
                                                    while($colunaA162 = mysqli_fetch_array($res_colunaA162)) {?>
                                                    <td class="coluna"><?php echo $colunaA162['coluna']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                            <tbody>
                                                <td class="altura">M10</td>
                                                <?php
                                                    while($g17a162A = mysqli_fetch_array($res33)) {?>
                                                    <td class="tabela" id="g17a162A" data-toggle="tooltip" data-placement="top" title="<?php echo $g17a162A['rua'].$g17a162A['coluna'].$g17a162A['altura'] ?>" data-endereco="<?php echo $g17a162A['id']; ?>"><?php echo $g17a152A['produto']; ?></td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('.tb_estoque tbody tr td.tabela').each(function(){
            if($(this).text() == ""){
                $(this).css("backgroundColor","#98FB98")
            }else{
                $(this).css("backgroundColor","#FF4040")
            }                

        })
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('td').on('click',function(){
            $.ajax({
                url: 'data/dashboard/modal/ocupacao_detalhe.php',
                type: 'post',
                data: 'id_endereco=' + $(this).attr("data-endereco"),
                success:function(data){
                    $('#ModalDetalhe').modal('show');
                    $('#retorno').html(data);
                }
            });
        });
    });
</script>