<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:../index.php");
    exit;
} else {

    $id = $_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_ped        = $_POST['cod_ped'];
$nr_ped         = $_POST['nr_ped'];
$ds_umb         = $_POST['ds_umb'];
$nr_qtde_rec    = $_POST['nr_qtde_rec'];
$cod_dst        = $_POST['cod_dst'];
$ds_mat         = strtoupper($_POST['ds_mat']);
$cod_mat        = $_POST['cod_mat'];

$end = explode("-", $cod_dst);

$id_end = $end[0];
$rua    = $end[1];
$coluna = $end[2];
$alt    = $end[3];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$ins_rec = "INSERT into tb_reclassifica (
    cod_ped, nr_qtde, cod_prd_org, cod_prd_dst, ds_umb, ds_material, fl_status, usr_create, dt_create
    ) values (
        '$nr_ped', '$nr_qtde_rec', '$cod_mat', '$cod_dst', '$ds_umb', '$ds_mat', 'A', '$id', '$date'
        )";
$res_rec = mysqli_query($link, $ins_rec);

$upd_col = "insert into tb_pedido_conferencia (
    nr_pedido, produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde, fl_conferido, fl_status, usr_create, dt_create
    )values(
        '$cod_ped', '$cod_mat', '$rua', '$coluna', '$alt', '$nr_qtde_rec', 'C', 'A', '$id', '$date'
        )";
$res_col = mysqli_query($link1, $upd_col);

if (mysqli_affected_rows($link) > 0) {

    $sql_rec = "SELECT cod_ped, nr_qtde, cod_prd_org, cod_prd_dst, ds_umb, ds_material 
    from tb_reclassifica 
    where cod_ped = '$nr_ped' and fl_status <> 'E'";
    $res_sql = mysqli_query($link, $sql_rec);

    if (mysqli_num_rows($res_sql) > 0) {

        while ($init = mysqli_fetch_assoc($res_sql)) {

            $array_reclassifica[] = array(
                'info'           => "0",
                'cod_ped'        => $init['cod_ped'],
                'nr_qtde'        => $init['nr_qtde'],
                'cod_org'        => $init['cod_prd_org'],
                'cod_dst'        => $init['cod_prd_dst'],
                'ds_umb'         => $init['ds_umb'],
                'ds_material'    => $init['ds_material']
            );
        }

    } else {

        $array_reclassifica[] = array(
            'info'    => "1",
        );
    }

} else {

    $array_reclassifica[] = array(
        'info'    => "2",
    );

}

echo (json_encode($array_reclassifica));
$link->close();
$link1->close();
?>