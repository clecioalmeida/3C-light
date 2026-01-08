<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
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

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$end_org    = $_POST['end_org'];
$prd_org    = $_POST['prd_org'];
$qtd_org    = $_POST['qtd_org'];
$end_dst    = $_POST['end_dst'];
$prd_dst    = $_POST['prd_dst'];
$qtd_dst    = $_POST['qtd_dst'];
$lp_org     = $_POST['lp_org'];

$end_org    = explode("-", $end_org);

// $id_end_org = $end_org[0];
$rua_org    = $end_org[0];
$col_org    = $end_org[1];
$alt_org    = $end_org[2];

$end_dst    = explode("-", $end_dst);

// $id_end_dst = $end_dst[0];
$rua_dst    = $end_dst[0];
$col_dst    = $end_dst[1];
$alt_dst    = $end_dst[2];

$sql_conf = "SELECT t1.produto, t1.cod_estoque, t1.ds_galpao, t1.nr_or, t1.id_tar, date(t1.dt_create) as dt_create, 
t1.ds_lp, t1.ds_kva, t1.ds_fabr, t1.ds_ano, t1.n_serie, t1.cod_etq
from tb_posicao_pallet t1
where t1.ds_prateleira = '$rua_org' and t1.ds_coluna = '$col_org' and t1.ds_altura = '$alt_org' and t1.produto = '$prd_org' and t1.fl_status = 'A' and t1.nr_qtde > 0  and ds_lp = '$lp_org'
order by date(t1.dt_create) asc";
$res_conf = mysqli_query($link, $sql_conf);

$qtd_transf = $qtd_dst;

while ($dados = mysqli_fetch_assoc($res_conf)) {

    $sql_tot = "SELECT round(t1.nr_qtde,0) as nr_qtde
    from tb_posicao_pallet t1
    where t1.cod_estoque = '".$dados['cod_estoque']."'";
    $res_tot = mysqli_query($link, $sql_tot);

    $total = mysqli_fetch_assoc($res_tot);

    $qtd_transf = $total['nr_qtde'] - $qtd_transf;

    if($qtd_transf > 0){

        $n_qtd = $total['nr_qtde'] - $qtd_transf;

        //echo "Primeira soma: cod_estoque ".$dados['cod_estoque'].' - qtde estoque '.$total['nr_qtde'].' - calculo '.$qtd_transf.' - novo calculo '.$n_qtd.'<br>';

        $sql_ins = "INSERT into tb_posicao_pallet (
            produto, nr_qtde, ds_galpao, ds_prateleira, ds_coluna, ds_altura, ds_lp, ds_kva, ds_fabr, ds_ano, n_serie, nr_or, id_tar, 
            cod_etq, nr_posicao_temp, fl_status, fl_bloq, fl_empresa, nm_user_mov, dt_user_mov, usr_create, dt_create
            ) values (
                '".$dados['produto']."','".$n_qtd."','".$dados['ds_galpao']."','".$rua_dst."','".$col_dst."',
                '".$alt_dst."','".$lp_org."','".$dados['ds_kva']."','".$dados['ds_fabr']."','".$dados['ds_ano']."',
                '".$dados['n_serie']."',  '".$dados['nr_or']."', '".$dados['id_tar']."','".$dados['cod_etq']."',
                '".$dados['cod_estoque']."', 'A', 'N', '".$cod_cli."', '".$id."','".$date."', '".$id."','".$date."')";
        $res_ins = mysqli_query($link,$sql_ins);
        $n_pos = mysqli_insert_id($link);

        if(mysqli_affected_rows($link) > 0){

            $sql_upd = "UPDATE tb_posicao_pallet set nr_posicao_temp = '".$n_pos."', nr_qtde = '".$qtd_transf."', nm_user_mov = '".$id."', 
            dt_user_mov = '".$date."',  user_update = '".$date."', dt_update = '".$date."' WHERE cod_estoque = '".$dados['cod_estoque']."'";
            $res_upd = mysqli_query($link,$sql_upd);

            if(mysqli_affected_rows($link) > 0){

                echo "0";

            }else{

                echo "1";
                
            }

        }else{

            echo "2";

        }

        exit();


    }else{

        //echo "Segunda soma: cod_estoque ".$dados['cod_estoque'].' - qtde estoque '.$total['nr_qtde'].' - calculo '.$qtd_transf."<br>";

        $sql_ins = "INSERT into tb_posicao_pallet (
            produto, nr_qtde, ds_galpao, ds_prateleira, ds_coluna, ds_altura, ds_lp, ds_kva, ds_fabr, ds_ano, n_serie, nr_or, id_tar, nr_posicao_temp, 
            fl_status, fl_bloq, fl_empresa, nm_user_mov, dt_user_mov
            ) values (
                '".$dados['produto']."','".$total['nr_qtde']."','".$dados['ds_galpao']."','".$rua_dst."','".$col_dst."',
                '".$alt_dst."','".$lp_org."','".$dados['ds_kva']."','".$dados['ds_fabr']."','".$dados['ds_ano']."',
                '".$dados['n_serie']."', '".$dados['nr_or']."','".$dados['id_tar']."','".$dados['cod_estoque']."', 'A', 'N', '".$cod_cli."', 
                '".$id."','".$date."')";
        $res_ins = mysqli_query($link,$sql_ins);
        $n_pos = mysqli_insert_id($link);

        if(mysqli_affected_rows($link) > 0){

            $sql_upd = "UPDATE tb_posicao_pallet set nr_posicao_temp = '".$n_pos."', fl_status = 'E', nm_user_mov = '".$id."', 
            dt_user_mov = '".$date."', user_update = '".$date."', user_update = '".$id."', dt_update = '".$date."' where cod_estoque = '".$dados['cod_estoque']."'";
            $res_upd = mysqli_query($link,$sql_upd);

            if(mysqli_affected_rows($link) > 0){

                echo "0";

            }else{

                echo "1";

            }

        }else{

            echo "2";

        }

        $qtd_transf = $qtd_transf*-1;

    }

}

$link->close();
?>