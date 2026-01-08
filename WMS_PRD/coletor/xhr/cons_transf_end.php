<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
    exit;

}else{

    $id=$_SESSION["id"];
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

$sql_conf = "SELECT ROUND(sum(t1.nr_qtde)) as total_qtde
from tb_posicao_pallet t1
where t1.ds_prateleira = '$rua_org' and t1.ds_coluna = '$col_org' and t1.ds_altura = '$alt_org' and t1.produto = '$prd_org' and t1.fl_status = 'A' and t1.nr_qtde > 0 and t1.fl_empresa = '$cod_cli' and t1.ds_lp = '$lp_org'";
$res_conf = mysqli_query($link, $sql_conf);

if(mysqli_num_rows($res_conf) > 0){

    $dados = mysqli_fetch_assoc($res_conf);

    if($dados['total_qtde'] >= $qtd_dst){

        echo "0";

    }else{

        echo "1 ".$dados['total_qtde'];

    }

}else{

    echo "Não há produto no endereço informado. ".$dados['total_qtde'];

}

$link->close();
?>