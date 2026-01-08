<?php
    $servidor = "mysql.gisis.com.br";
    $usuario = "gisis";
    $senha = "wmsweb2017";
    $dbname = "gisis";
    
    //Criar a conexão
    $link = mysqli_connect($servidor, $usuario, $senha, $dbname);

    $query="SET SQL_BIG_SELECTS=1";
    $res_query=mysqli_query($link, $query);

    $id_armazem = $_POST['id_armazem'];

    //$sql_posicao = "select id from tb_endereco where exists (select distinct(id_endereco) from tb_posicao_pallet where nr_qtde is not null)";
    $sql_posicao = "SELECT distinct(id) FROM tb_endereco e
WHERE NOT EXISTS (SELECT distinct(id_endereco) FROM tb_posicao_pallet p WHERE e.id = p.id_endereco)";

    $res_posicao = mysqli_query($link,$sql_posicao);
    $sql_endereco = "select id from tb_endereco";
    $res_endereco = mysqli_query($link,$sql_endereco);

    $sql_altura = "select distinct(altura) from tb_endereco where galpao = 13 and rua = 'a01'";
    $res_altura = mysqli_query($link,$sql_altura);
    $sql_alturaA03 = "select distinct(altura) from tb_endereco where galpao = 13 and rua = 'a03'";
    $res_alturaA03 = mysqli_query($link,$sql_alturaA03);
    $sql_coluna = "select distinct(coluna) from tb_endereco where galpao = 13 and rua = 'a01'";
    $res_coluna = mysqli_query($link,$sql_coluna);
    $sql_colunaA03 = "select distinct(coluna) from tb_endereco where galpao = 13 and rua = 'a03'";
    $res_colunaA03 = mysqli_query($link,$sql_colunaA03);
    $sql_colunaA05 = "select distinct(coluna) from tb_endereco where galpao = 13 and rua = 'a05'";
    $res_colunaA05 = mysqli_query($link,$sql_colunaA05);
    $sql_colunaA07 = "select distinct(coluna) from tb_endereco where galpao = 13 and rua = 'a07'";
    $res_colunaA07 = mysqli_query($link,$sql_colunaA07);
    $sql_colunaA09 = "select distinct(coluna) from tb_endereco where galpao = 13 and rua = 'a09'";
    $res_colunaA09 = mysqli_query($link,$sql_colunaA09);
    $sql_colunaA11 = "select distinct(coluna) from tb_endereco where galpao = 13 and rua = 'a11'";
    $res_colunaA11 = mysqli_query($link,$sql_colunaA11);
    $sql_colunaA13 = "select distinct(coluna) from tb_endereco where galpao = 13 and rua = 'a13'";
    $res_colunaA13 = mysqli_query($link,$sql_colunaA13);
    $sql_colunaA151 = "select distinct(coluna) from tb_endereco where galpao = 13 and rua = 'a15' and coluna <='14E'";
    $res_colunaA151 = mysqli_query($link,$sql_colunaA151);
    $sql_colunaA152 = "select distinct(coluna) from tb_endereco where galpao = 13 and rua = 'a15' and coluna >'14E'";
    $res_colunaA152 = mysqli_query($link,$sql_colunaA152);
    $galpao = "select distinct(t2.nome) from tb_endereco t1 left join tb_armazem t2 on t1.galpao = t2.id";
    $res_galpao = mysqli_query($link,$galpao);
    $sql = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a01' and t1.altura = 'A' group by t1.id";
    $res = mysqli_query($link,$sql);
    //$sql1 = "select id from tb_endereco where galpao = 11 and rua = 'a01' and altura = 'B'";
    $sql1 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a01' and t1.altura = 'B' group by t1.id";
    $res1 = mysqli_query($link,$sql1);
    $sql2 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a01' and t1.altura = 'C' group by t1.id";
    $res2 = mysqli_query($link,$sql2);
    $sql3 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a01' and t1.altura = 'D' group by t1.id";
    $res3 = mysqli_query($link,$sql3);
    $sql4 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a03' and t1.altura = 'A' group by t1.id";
    $res4 = mysqli_query($link,$sql4);
    $sql5 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a03' and t1.altura = 'B' group by t1.id";
    $res5 = mysqli_query($link,$sql5);
    $sql6 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a03' and t1.altura = 'C' group by t1.id";
    $res6 = mysqli_query($link,$sql6);
    $sql7 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a03' and t1.altura = 'D' group by t1.id";
    $res7 = mysqli_query($link,$sql7);
    $sql8 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a05' and t1.altura = 'A' group by t1.id";
    $res8 = mysqli_query($link,$sql8);
    $sql9 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a05' and t1.altura = 'B' group by t1.id";
    $res9 = mysqli_query($link,$sql9);
    $sql10 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a05' and t1.altura = 'C' group by t1.id";
    $res10 = mysqli_query($link,$sql10);
    $sql11 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a05' and t1.altura = 'D' group by t1.id";
    $res11 = mysqli_query($link,$sql11);
    $sql12 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a07' and t1.altura = 'A' group by t1.id";
    $res12 = mysqli_query($link,$sql12);
    $sql13 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a07' and t1.altura = 'B' group by t1.id";
    $res13 = mysqli_query($link,$sql13);
    $sql14 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a07' and t1.altura = 'C' group by t1.id";
    $res14 = mysqli_query($link,$sql14);
    $sql15 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a07' and t1.altura = 'D' group by t1.id";
    $res15 = mysqli_query($link,$sql15);
    $sql16 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a09' and t1.altura = 'A' group by t1.id";
    $res16 = mysqli_query($link,$sql16);
    $sql17 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a09' and t1.altura = 'B' group by t1.id";
    $res17 = mysqli_query($link,$sql17);
    $sql18 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a09' and t1.altura = 'C' group by t1.id";
    $res18 = mysqli_query($link,$sql18);
    $sql19 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a09' and t1.altura = 'D' group by t1.id";
    $res19 = mysqli_query($link,$sql19);
    $sql20 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a09' and t1.altura = 'A' group by t1.id";
    $res20 = mysqli_query($link,$sql20);
    $sql21 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a11' and t1.altura = 'B' group by t1.id";
    $res21 = mysqli_query($link,$sql21);
    $sql22 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a11' and t1.altura = 'C' group by t1.id";
    $res22 = mysqli_query($link,$sql22);
    $sql23 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a11' and t1.altura = 'D' group by t1.id";
    $res23 = mysqli_query($link,$sql23);
    $sql24 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a13' and t1.altura = 'A' group by t1.id";
    $res24 = mysqli_query($link,$sql24);
    $sql25 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a13' and t1.altura = 'B' group by t1.id";
    $res25 = mysqli_query($link,$sql25);
    $sql26 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a13' and t1.altura = 'C' group by t1.id";
    $res26 = mysqli_query($link,$sql26);
    $sql27 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a13' and t1.altura = 'D' group by t1.id";
    $res27 = mysqli_query($link,$sql27);
    $sql28 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a15' and t1.altura = 'A' and t1.coluna <='14E' group by t1.id";
    $res28 = mysqli_query($link,$sql28);
    $sql29 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a15' and t1.altura = 'B' and t1.coluna <='14E' group by t1.id";
    $res29 = mysqli_query($link,$sql29);
    $sql30 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a15' and t1.altura = 'C' and t1.coluna <='14E' group by t1.id";
    $res30 = mysqli_query($link,$sql30);
    $sql31 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a15' and t1.altura = 'D' and t1.coluna <='14E' group by t1.id";
    $res31 = mysqli_query($link,$sql31);
    $sql32 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a15' and t1.altura = 'A' and t1.coluna >'14E' group by t1.id";
    $res32 = mysqli_query($link,$sql32);
    $sql33 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a15' and t1.altura = 'B' and t1.coluna >'14E' group by t1.id";
    $res33 = mysqli_query($link,$sql33);
    $sql34 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a15' and t1.altura = 'C' and t1.coluna >'14E' group by t1.id";
    $res34 = mysqli_query($link,$sql34);
    $sql35 = "select t1.id, t1.rua, t1.coluna, t1.altura, t2.produto from tb_endereco t1 left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira and t1.coluna = t2.ds_coluna
and t1.altura = t2.ds_altura where t1.galpao = 13 and t1.rua = 'a15' and t1.altura = 'D' and t1.coluna >'14E' group by t1.id";
    $res35 = mysqli_query($link,$sql35);
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
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered" style="width: 100px">
                    <legend>Rua A01</legend>
                            <tbody>
                                <th class="altura">#</th>
                                    <?php
                                    while($coluna = mysqli_fetch_array($res_coluna)) {?>
                                    <td class="coluna"><?php echo $coluna['coluna']; ?></td>
                                <?php } ?>
                            </tbody>
                            <tbody>
                                <td class="altura">A</td>
                                <?php
                                    while($g11a01A = mysqli_fetch_array($res)) {?>
                                    <td class="tabela livre" id="g11a01A" data-endereco="<?php echo $g11a01A['id']; ?>" data-produto="<?php echo $g11a01A['produto']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a01A['rua'].$g11a01A['coluna'].$g11a01A['altura'] ?>"><?php echo $g11a01A['produto']; ?></td>
                                <?php } ?>
                            </tbody>
                            <tbody>
                                <td class="altura">B</td>
                                <?php
                                    while($g11a01B = mysqli_fetch_array($res1)) {?>
                                    <td class="tabela livre" id="g11a01B" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a01B['rua'].$g11a01B['coluna'].$g11a01B['altura'] ?>" data-endereco="<?php echo $g11a01B['id']; ?>"><?php echo $g11a01B['produto']; ?></td>
                                <?php } ?>
                            </tbody>
                            <tbody>
                                <td class="altura">C</td>
                                <?php
                                    while($g11a01C = mysqli_fetch_array($res2)) {?>
                                    <td class="tabela livre" id="g11a01C" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a01C['rua'].$g11a01C['coluna'].$g11a01C['altura'] ?>" data-endereco="<?php echo $g11a01C['id']; ?>"><?php echo $g11a01C['produto']; ?></td>
                                <?php } ?>
                            </tbody>
                            <tbody>
                                <td class="altura">D</td>
                                <?php
                                    while($g11a01D = mysqli_fetch_array($res3)) {?>
                                    <td class="tabela livre" id="g11a01D" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a01D['rua'].$g11a01D['coluna'].$g11a01D['altura'] ?>" data-endereco="<?php echo $g11a01D['id']; ?>"><?php echo $g11a01D['produto']; ?></td>
                                <?php } ?>
                            </tbody>
                            <input type="submit" id="btnSubmit" name="" style="display: none">
                        </form>
                    </table>
                    <table class="table table-bordered" style="width: 300px">
                    <legend>Rua A03</legend>
                        <tbody>
                            <th class="altura">#</th>
                                <?php
                                while($colunaA03 = mysqli_fetch_array($res_colunaA03)) {?>
                                <td class="coluna"><?php echo $colunaA03['coluna']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">A</td>
                            <?php
                                while($g11a03A = mysqli_fetch_array($res4)) {?>
                                <td class="livre tabela" id="g11a03A" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a03A['rua'].$g11a03A['coluna'].$g11a03A['altura'] ?>" data-endereco="<?php echo $g11a03A['id']; ?>"><?php echo $g11a03A['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">B</td>
                            <?php
                                while($g11a03B = mysqli_fetch_array($res5)) {?>
                               <td class="livre tabela" id="g11a03B" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a03B['rua'].$g11a03B['coluna'].$g11a03B['altura'] ?>" data-endereco="<?php echo $g11a03B['id']; ?>"><?php echo $g11a03B['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">C</td>
                            <?php
                                while($g11a03C = mysqli_fetch_array($res6)) {?>
                                <td class="livre tabela" id="g11a03C" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a03C['rua'].$g11a03C['coluna'].$g11a03C['altura'] ?>" data-endereco="<?php echo $g11a03C['id']; ?>"><?php echo $g11a03C['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">D</td>
                            <?php
                                while($g11a03D = mysqli_fetch_array($res7)) {?>
                                <td class="livre tabela" id="g11a03D" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a03D['rua'].$g11a03D['coluna'].$g11a03D['altura'] ?>" data-endereco="<?php echo $g11a03D['id']; ?>"><?php echo $g11a03D['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <table class="table table-bordered" style="width: 300px">
                    <legend>Rua A05</legend>
                        <tbody>
                            <th class="altura">#</th>
                                <?php
                                while($colunaA05 = mysqli_fetch_array($res_colunaA05)) {?>
                                <td class="coluna"><?php echo $colunaA05['coluna']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">A</td>
                            <?php
                                while($g11a05A = mysqli_fetch_array($res8)) {?>
                                <td class="tabela livre" id="g11a05A" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a05A['rua'].$g11a05A['coluna'].$g11a05A['altura'] ?>" data-endereco="<?php echo $g11a05A['id']; ?>"><?php echo $g11a05A['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">B</td>
                            <?php
                                while($g11a05B = mysqli_fetch_array($res9)) {?>
                                <td class="tabela livre" id="g11a05B" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a05B['rua'].$g11a05B['coluna'].$g11a05B['altura'] ?>" data-endereco="<?php echo $g11a05B['id']; ?>"><?php echo $g11a05B['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">C</td>
                            <?php
                                while($g11a05C = mysqli_fetch_array($res10)) {?>
                                <td class="tabela livre" id="g11a05C" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a05C['rua'].$g11a05C['coluna'].$g11a05C['altura'] ?>" data-endereco="<?php echo $g11a05C['id']; ?>"><?php echo $g11a05C['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">D</td>
                            <?php
                                while($g11a05D = mysqli_fetch_array($res11)) {?>
                                <td class="tabela livre" id="g11a05D" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a05D['rua'].$g11a05D['coluna'].$g11a05D['altura'] ?>" data-endereco="<?php echo $g11a05D['id']; ?>"><?php echo $g11a05D['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered" style="width: 300px">
                    <legend>Rua A07</legend>
                        <tbody>
                            <th class="altura">#</th>
                                <?php
                                while($colunaA07 = mysqli_fetch_array($res_colunaA07)) {?>
                                <td class="coluna"><?php echo $colunaA07['coluna']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                             <td class="altura">A</td>
                            <?php
                                while($g11a07A = mysqli_fetch_array($res12)) {?>
                                <td class="tabela livre" id="g11a07A" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a07A['rua'].$g11a07A['coluna'].$g11a07A['altura'] ?>" data-endereco="<?php echo $g11a07A['id']; ?>"><?php echo $g11a07A['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                             <td class="altura">B</td>
                            <?php
                                while($g11a07B = mysqli_fetch_array($res13)) {?>
                                <td class="tabela livre" id="g11a07B" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a07B['rua'].$g11a07B['coluna'].$g11a07B['altura'] ?>" data-endereco="<?php echo $g11a07B['id']; ?>"><?php echo $g11a07B['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                             <td class="altura">C</td>
                            <?php
                                while($g11a07C = mysqli_fetch_array($res14)) {?>
                                <td class="tabela livre" id="g11a07C" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a07C['rua'].$g11a07C['coluna'].$g11a07C['altura'] ?>" data-endereco="<?php echo $g11a07C['id']; ?>"><?php echo $g11a07C['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                             <td class="altura">D</td>
                            <?php
                                while($g11a07D = mysqli_fetch_array($res15)) {?>
                                <td class="tabela livre" id="g11a07D" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a07D['rua'].$g11a07D['coluna'].$g11a07D['altura'] ?>" data-endereco="<?php echo $g11a07D['id']; ?>"><?php echo $g11a07D['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <table class="table table-bordered" style="width: 300px">
                    <legend>Rua A09</legend>
                        <tbody>
                            <th class="altura">#</th>
                                <?php
                                while($colunaA09 = mysqli_fetch_array($res_colunaA09)) {?>
                                <td class="coluna"><?php echo $colunaA09['coluna']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">A</td>
                            <?php
                                while($g11a09A = mysqli_fetch_array($res16)) {?>
                                <td class="tabela livre" id="g11a09A" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a09A['rua'].$g11a09A['coluna'].$g11a09A['altura'] ?>" data-endereco="<?php echo $g11a09A['id']; ?>"><?php echo $g11a09A['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">B</td>
                            <?php
                                while($g11a09B = mysqli_fetch_array($res17)) {?>
                                <td class="tabela livre" id="g11a09B" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a09B['rua'].$g11a09B['coluna'].$g11a09B['altura'] ?>" data-endereco="<?php echo $g11a09B['id']; ?>"><?php echo $g11a09B['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">C</td>
                            <?php
                                while($g11a09C = mysqli_fetch_array($res18)) {?>
                                <td class="tabela livre" id="g11a09C" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a09C['rua'].$g11a09C['coluna'].$g11a09C['altura'] ?>" data-endereco="<?php echo $g11a09C['id']; ?>"><?php echo $g11a09C['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">D</td>
                            <?php
                                while($g11a09D = mysqli_fetch_array($res19)) {?>
                                <td class="tabela livre" id="g11a09D" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a09D['rua'].$g11a09D['coluna'].$g11a09D['altura'] ?>" data-endereco="<?php echo $g11a09D['id']; ?>"><?php echo $g11a09D['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered" style="width: 300px">
                    <legend>Rua A11</legend>
                        <tbody>
                            <th class="altura">#</th>
                                <?php
                                while($colunaA11 = mysqli_fetch_array($res_colunaA11)) {?>
                                <td class="coluna"><?php echo $colunaA11['coluna']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">A</td>
                            <?php
                                while($g11a11A = mysqli_fetch_array($res20)) {?>
                                <td class="tabela livre" id="g11a11A" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a11A['rua'].$g11a11A['coluna'].$g11a11A['altura'] ?>" data-endereco="<?php echo $g11a11A['id']; ?>"><?php echo $g11a11A['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">B</td>
                            <?php
                                while($g11a12B = mysqli_fetch_array($res21)) {?>
                                <td class="tabela livre" id="g11a12B" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a12B['rua'].$g11a12B['coluna'].$g11a12B['altura'] ?>" data-endereco="<?php echo $g11a12B['id']; ?>"><?php echo $g11a12B['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">C</td>
                            <?php
                                while($g11a11C = mysqli_fetch_array($res22)) {?>
                                <td class="tabela livre" id="g11a11C" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a11C['rua'].$g11a11C['coluna'].$g11a11C['altura'] ?>" data-endereco="<?php echo $g11a11C['id']; ?>"><?php echo $g11a11C['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">D</td>
                            <?php
                                while($g11a11D = mysqli_fetch_array($res23)) {?>
                                <td class="tabela livre" id="g11a11D" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a11D['rua'].$g11a11D['coluna'].$g11a11D['altura'] ?>" data-endereco="<?php echo $g11a11D['id']; ?>"><?php echo $g11a11D['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered" style="width: 300px">
                    <legend>Rua A13</legend>
                        <tbody>
                            <th class="altura">#</th>
                                <?php
                                while($colunaA13 = mysqli_fetch_array($res_colunaA13)) {?>
                                <td class="coluna"><?php echo $colunaA13['coluna']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">A</td>
                            <?php
                                while($g11a13A = mysqli_fetch_array($res24)) {?>
                                <td class="tabela livre" id="g11a13A" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a13A['rua'].$g11a13A['coluna'].$g11a13A['altura'] ?>" data-endereco="<?php echo $g11a13A['id']; ?>"><?php echo $g11a13A['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">B</td>
                            <?php
                                while($g11a13B = mysqli_fetch_array($res25)) {?>
                                <td class="tabela livre" id="g11a13B" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a13B['rua'].$g11a13B['coluna'].$g11a13B['altura'] ?>" data-endereco="<?php echo $g11a13B['id']; ?>"><?php echo $g11a13B['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">C</td>
                            <?php
                                while($g11a13C = mysqli_fetch_array($res26)) {?>
                                <td class="tabela livre" id="g11a13C" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a13C['rua'].$g11a13C['coluna'].$g11a13C['altura'] ?>" data-endereco="<?php echo $g11a13C['id']; ?>"><?php echo $g11a13C['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">D</td>
                            <?php
                                while($g11a13D = mysqli_fetch_array($res27)) {?>
                                <td class="tabela livre" id="g11a13D" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a13D['rua'].$g11a13D['coluna'].$g11a13D['altura'] ?>" data-endereco="<?php echo $g11a13D['id']; ?>"><?php echo $g11a13D['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered" style="width: 300px">
                    <legend>Rua A15</legend>
                        <tbody>
                            <th class="altura">#</th>
                                <?php
                                while($colunaA151 = mysqli_fetch_array($res_colunaA151)) {?>
                                <td class="coluna"><?php echo $colunaA151['coluna']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">A</td>
                            <?php
                                while($g11a15A = mysqli_fetch_array($res28)) {?>
                                <td class="tabela livre" id="g11a15A" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a15A['rua'].$g11a15A['coluna'].$g11a15A['altura'] ?>" data-endereco="<?php echo $g11a15A['id']; ?>"><?php echo $g11a15A['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">B</td>
                            <?php
                                while($g11a15B = mysqli_fetch_array($res29)) {?>
                                <td class="tabela livre" id="g11a15B" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a15B['rua'].$g11a15B['coluna'].$g11a15B['altura'] ?>" data-endereco="<?php echo $g11a15B['id']; ?>"><?php echo $g11a15B['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">C</td>
                            <?php
                                while($g11a15C = mysqli_fetch_array($res30)) {?>
                                <td class="tabela livre" id="g11a15C" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a15C['rua'].$g11a15C['coluna'].$g11a15C['altura'] ?>" data-endereco="<?php echo $g11a15C['id']; ?>"><?php echo $g11a15C['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">D</td>
                            <?php
                                while($g11a15D = mysqli_fetch_array($res31)) {?>
                                <td class="tabela livre" id="g11a15D" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a15D['rua'].$g11a15D['coluna'].$g11a15D['altura'] ?>" data-endereco="<?php echo $g11a15D['id']; ?>"><?php echo $g11a15D['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered" style="width: 300px">
                    <legend>Rua A15</legend>
                        <tbody>
                            <th class="altura">#</th>
                                <?php
                                while($colunaA152 = mysqli_fetch_array($res_colunaA152)) {?>
                                <td class="coluna"><?php echo $colunaA152['coluna']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">A</td>
                            <?php
                                while($g11a152A = mysqli_fetch_array($res32)) {?>
                                 <td class="tabela livre" id="g11a152A" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a152A['rua'].$g11a152A['coluna'].$g11a152A['altura'] ?>" data-endereco="<?php echo $g11a152A['id']; ?>"><?php echo $g11a152A['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">B</td>
                            <?php
                                while($g11a152B = mysqli_fetch_array($res33)) {?>
                                <td class="tabela livre" id="g11a152B" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a152B['rua'].$g11a152B['coluna'].$g11a152B['altura'] ?>" data-endereco="<?php echo $g11a152B['id']; ?>"><?php echo $g11a152B['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">C</td>
                            <?php
                                while($g11a152C = mysqli_fetch_array($res34)) {?>
                                <td class="tabela livre" id="g11a152C" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a152C['rua'].$g11a152C['coluna'].$g11a152C['altura'] ?>" data-endereco="<?php echo $g11a152C['id']; ?>"><?php echo $g11a152C['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                        <tbody>
                            <td class="altura">D</td>
                            <?php
                                while($g11a152D = mysqli_fetch_array($res35)) {?>
                                <td class="tabela livre" id="g11a152D" data-toggle="tooltip" data-placement="top" title="<?php echo $g11a152D['rua'].$g11a152D['coluna'].$g11a152D['altura'] ?>" data-endereco="<?php echo $g11a152D['id']; ?>"><?php echo $g11a152D['produto']; ?></td>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
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