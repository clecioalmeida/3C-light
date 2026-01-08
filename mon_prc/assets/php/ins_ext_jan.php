<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

$id_oper        = $_SESSION['id_oper'];
$id_user        = $_SESSION['id_user'];
$dt_janela      = trim(strip_tags($_POST['dt_janela']));
$hr_janela      = trim(strip_tags($_POST['hr_janela']));
$ds_doca        = trim(strip_tags($_POST['ds_doca']));
$ds_solicitante = trim(strip_tags($_POST['ds_solicitante']));
$ds_motivo      = trim(strip_tags($_POST['ds_motivo']));
$fl_status      = trim(strip_tags('A'));
$fl_tipo        = trim(strip_tags('N'));

// insere a tabela extra
$insert = "INSERT INTO tb_janela ";
$insert .= "(dt_janela, ds_janela, ds_doca, ds_solicitante, ds_motivo, fl_status, fl_tipo, fl_empresa, usr_create, dt_create) VALUES ";
$insert .= "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$result = $conexao->prepare($insert);
$result->bindParam(1, $dt_janela);
$result->bindParam(2, $hr_janela);
$result->bindParam(3, $ds_doca);
$result->bindParam(4, $ds_solicitante);
$result->bindParam(5, $ds_motivo);
$result->bindParam(6, $fl_status);
$result->bindParam(7, $fl_tipo);
$result->bindParam(8, $id_oper);
$result->bindParam(9, $id_user);
$result->bindParam(10, $date);

if ($result->execute()) {

    echo "CADASTRO REALIZADO COM SUCESSO";
} else {

    echo "ERRO! FAVOR TENTE NOVAMENTE MAIS TARDE";
    print_r($result->errorInfo());
}