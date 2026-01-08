<?php
session_start();

if (!isset($_SESSION["id_user"]) || !isset($_SESSION["id_oper"])) {

    header("Location:../../index.php");
    exit;

} else {

    $id_user    = $_SESSION["id_user"];
    $cod_cli    = $_SESSION['id_oper'];

}

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

$cod_rec    = trim(strip_tags($_POST['cod_rec']));
$ds_rec     = trim(strip_tags($_POST['ds_rec']));
$sts_rec    = "R";

$upd_rec = "UPDATE tb_recebimento_ag set ";
$upd_rec .= "fl_status = ?, ds_motivo = ?, usr_update = ?, dt_update = ? ";
$upd_rec .= "WHERE cod_recebimento = ?";
$result = $conexao->prepare($upd_rec);

$result->bindParam(1, $sts_rec);
$result->bindParam(2, $ds_rec);
$result->bindParam(3, $id_user);
$result->bindParam(4, $date);
$result->bindParam(5, $cod_rec);
$result->execute();

$count = $result->rowCount();

if ($count > 0) {

    $sts_jn     = "A";

    $upd_jn = "UPDATE tb_janela set ";
    $upd_jn .= "fl_status = ?, cod_rec = NULL, usr_update = ?, dt_update = ? ";
    $upd_jn .= "WHERE cod_rec = ?";
    $res_jn = $conexao->prepare($upd_jn);

    $res_jn->bindParam(1, $sts_jn);
    $res_jn->bindParam(2, $id_user);
    $res_jn->bindParam(3, $date);
    $res_jn->bindParam(4, $cod_rec);
    $res_jn->execute();

    $count_jn = $res_jn->rowCount();

    if ($count_jn > 0) {

        $retorno = array(
            'info' => "0",
        );

        echo (json_encode($retorno));

    } else {

        $retorno = array(
            'info' => "1",
        );

        echo (json_encode($retorno));
        //print_r($result->errorInfo());

    }

} else {

    $retorno = array(
        'info' => "2",
    );

    echo (json_encode($retorno));
    //print_r($result->errorInfo());
}
