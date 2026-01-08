<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"])){

    header("Location:../logout.php");
    exit;

}else{

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_aloc = $_POST['id_aloc'];

if($cod_cli == '5'){

    $ds_galpao = '7';

}else if($cod_cli == '6'){

    $ds_galpao = '18';

}else if($cod_cli == '7'){

    $ds_galpao = '27';

}else if($cod_cli == '8'){

    $ds_galpao = '33';

}else{

    $ds_galpao = "0";

}

//if(isset($rec)){

    $query="SET SQL_BIG_SELECTS=1";
    $res_query=mysqli_query($link, $query);

    $sql_vol = "select sum(t1.nr_volume) as total_volume
    from tb_nf_entrada_item t1
    where t1.cod_rec = '$id_aloc' and fl_status <> 'E'
    group by t1.cod_rec";
    $res_vol = mysqli_query($link, $sql_vol);
    $dados_vol = mysqli_fetch_assoc($res_vol);
    $nr_qtde        = $dados_vol['total_volume'];

    $sql_etq = "select count(t2.id) as total_etq
    from  tb_etiqueta t2
    where t2.cod_rec = '$id_aloc' and fl_status <> 'E'";
    $res_etq = mysqli_query($link, $sql_etq);
    $dados_etq = mysqli_fetch_assoc($res_etq);
    $nr_alocado     = $dados_etq['total_etq'];

    if($nr_qtde == $nr_alocado){

        $sql = "select t1.id, t1.cod_estoque, t1.cod_item, t1.id_end, t2.galpao, t2.rua, t2.coluna, t2.altura, t4.produto, t4.nr_or, t4.nr_volume, t1.nr_qtde, t4.dt_validade, t4.cod_ca, t4.cod_laudo
        from tb_etiqueta t1
        left join tb_endereco t2 on t1.id_end = t2.id
        left join tb_posicao_pallet t4 on t1.cod_estoque = t4.cod_estoque
        where t1.cod_rec = '$id_aloc' and t1.fl_status <> 'E'
        group by t1.id";
        $res=mysqli_query($link, $sql);

        while ($dados=mysqli_fetch_assoc($res)) {
            $id_etq         = $dados['id'];
            $produto        = $dados['produto'];
            $nr_or          = $dados['nr_or'];
            $nr_qtde        = $dados['nr_qtde'];
            $nr_volume      = $dados['nr_volume'];
            $galpao         = $dados['galpao'];
            $rua            = $dados['rua'];
            $coluna         = $dados['coluna'];
            $altura         = $dados['altura'];
            $cod_estoque    = $dados['cod_estoque'];
            $dt_validade    = $dados['dt_validade'];
            $cod_ca         = $dados['cod_ca'];
            $cod_laudo      = $dados['cod_laudo'];
            $cod_item       = $dados['cod_item'];

            $ins_pp = "insert into tb_posicao_pallet (produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_volume, nr_qtde, nr_posicao_temp, dt_validade, cod_ca, cod_laudo, cod_etq, fl_status, fl_bloq, fl_empresa, nr_or, usr_create, dt_create) values ('$produto', '$galpao', '$rua', '$coluna', '$altura', '$nr_volume', '$nr_qtde', '$cod_estoque', '$dt_validade', '$cod_ca', '$cod_laudo', '$id_etq', 'A', 'N', '$cod_cli', '$nr_or', '$id', '$date')";
            $res_ins = mysqli_query($link,$ins_pp);

            if(mysqli_affected_rows($link) > 0){

                $novo_cod_estoque = mysqli_insert_id($link);

                $upd_alc = "update tb_etiqueta set fl_status = 'F', cod_estoque = '$novo_cod_estoque' where id = '$id_etq'";
                $res_alc = mysqli_query($link,$upd_alc);

                $ins_lg = "insert into tb_log_produto (cod_item, ds_ref, id_ref, ds_rotina, ds_obs, usr_create, dt_create) values ('$cod_item', 'COD ESTOQUE', '$novo_cod_estoque', 'ALOCAÇÃO', 'PRODUTO ALOCADO', '$id', '$date')";
                $res_LG = mysqli_query($link,$ins_lg);

            }else{

                $array_estoque = array(
                    'fin_conf'    => "Erro!",
                );

                echo(json_encode($array_estoque));

            }
        }

        $conf_aloc = "select id from tb_etiqueta where cod_rec = '$id_aloc' and fl_status <> 'F'";
        $res_conf = mysqli_query($link,$conf_aloc);

        if(mysqli_num_rows($res_conf) > 0){

            echo "Alocação não finalizada.";

        }else{

            $upd_rec = "update tb_recebimento set fl_status = 'F' where cod_recebimento = '$id_aloc'";
            $res_rec = mysqli_query($link,$upd_rec);

            $upd_pp="update tb_posicao_pallet set nr_qtde = '0', fl_status = 'E' where nr_or = '$id_aloc' and ds_galpao = '$ds_galpao'";
            $res_upd = mysqli_query($link,$upd_pp);

            $array_estoque[] = array(
                'fin_conf'    => "Conferência finalizada com sucesso!",
            );

            echo(json_encode($array_estoque));

        }


    }else{

        $array_estoque[] = array(
            'fin_conf'    => "Ainda existem produtos a conferir!",
        );

        echo(json_encode($array_estoque));

    }


/*}else{

    $array_estoque[] = array(
        'fin_conf'    => "Sessão expirada!",
    );

    echo(json_encode($array_estoque));

}*/

$link->close();
?>