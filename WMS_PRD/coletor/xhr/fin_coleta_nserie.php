<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;
} else {

    $id         = $_SESSION["id"];
    $cod_cli     = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_col = $_POST['id_col'];

$sql = "SELECT n_serie from tb_nserie where fl_status = 'A' and id_col = '$id_col'";
$res = mysqli_query($link, $sql);

if (mysqli_num_rows($res) > 0) {

    while ($dados = mysqli_fetch_assoc($res)) {

        $upd = "UPDATE tb_nserie set fl_status = 'P', dt_fin_col = '$date' where n_serie = '" . $dados['n_serie'] . "'";
        $res_upd = mysqli_query($link, $upd);
    }

    $sql_conf = "SELECT id as conf 
            from tb_nserie
            where fl_status = 'A' and id_col = '$id_col'";
    $res_conf = mysqli_query($link, $sql_conf);

    if (mysqli_num_rows($res_conf) == 0) {

        $upd_for = "UPDATE tb_nserie_col set fl_status = 'P' where id = '$id_col'";
        $res_for = mysqli_query($link, $upd_for);

        $retorno = array(
            'info'        => "0",
            'conf'        => "<span style='background-color: #98FB98; text-align:center'>Todos os números de série coletados!</span>",
        );
    } else {

        $retorno = array(
            'info'        => "1",
            'conf'        => "<span style='background-color: #FF7F50; text-align:center'>Não foi possível coletar os números de série.</span>",
        );
    }
} else {
    
    $retorno = array(
        'info'        => "1",
        'conf'        => "<span style='background-color: #FF7F50; text-align:center'>Todos os números de série já foram alocados.</span>",
    );

    $upd_for = "UPDATE tb_nserie_col set fl_status = 'P' where id = '$id_col'";
    $res_for = mysqli_query($link, $upd_for);

}

echo (json_encode($retorno));

$link->close();
?>